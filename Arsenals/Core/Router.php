<?php

namespace Arsenals\Core;
use Arsenals\Core\Abstracts\Arsenals;
use Arsenals\Core\Utils\CommonUtils;
use Arsenals\Core\Exceptions\PageNotFoundException;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 路由控制
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Router extends Arsenals {
	private static $_router_defined = array();
	private static $_router_data = array();
	
	private $_routers;
	private $_controller;
	private $_action;
	private $_path_info;
	private $_hook;
	
	// 标记是否是已经找到匹配路由
	// 如果为false， 则继续进行路由匹配
	// 如果为true，则停止路由匹配
	// 如果所有规则匹配完成后仍然为false，则调用默认路由规则
	public static $_stop = false;
	// 路由实例
	private static $_instance = null;
	/**
	 * 正则表达式替换变量
	 * @var array
	 */
	private static $_regexp_replace_vars = array(
		':num' 				=> '[0-9]+',
		':any'				=> '.+'
	);
	
	/**
	 * 映射指定路径到函数或者是控制器
	 * @param unknown $url
	 * @param unknown $route
	 */
	public static function map($url, $route){
		// 如果一定调度过了，则再次调用该方法直接返回
		if(self::$_stop){
			return false;
		}
		// 路由实例，本方法为静态方法，需要获取实例后在进行操作
		$_instance = self::$_instance == null ? Registry::load('Arsenals\Core\Router') : self::$_instance;

		// 替换路由规则为标准正则表达式
		$key = str_replace(
				array_keys(self::$_regexp_replace_vars), 
				array_values(self::$_regexp_replace_vars), 
				'/' . str_replace('/', '\/', trim($url, '/')) . '/');
		
		// 处理提供的额外参数，这些参数将传递给
		// 控制器方法或者是匿名函数
		$args = array();
		if(func_num_args() > 2){
			$func_args = func_get_args();
			$args = array_splice($func_args, 2);
		}
		// 进行路由规则匹配， 如果能够匹配，则进行指定规则调度
		// 如果无法匹配则继续进行下一规则匹配
		if(preg_match($key, $_instance->_path_info)){
			// 标记路由已经执行过
			self::$_stop = true;
			// 完成路由调度并返回相应的视图对象
			$_instance->dispatch_map(array($key, $route) , $args);
		}
	}
	/**
	 * 构造函数
	 */
	public function __construct(){
		// 加载配置文件
		$this->_routers = Config::load('router');
		$uri = Registry::load('Arsenals\Core\Uri');
		
		$this->_path_info = $uri->getPathInfo();
		$this->_controller = CONTROLLER_NAMESPACE . ($uri->getModuleName() == '' ? 
				$uri->getControllerName() 
				:($uri->getModuleName() . '\\' . $uri->getControllerName())) ;
		$this->_action = $uri->getActionName();
		// 钩子
		$this->_hook = Registry::load('Arsenals\Core\Hooks');
		
		// 配置文件定义的路由
		self::$_router_defined = array_merge(self::$_router_defined, $this->_routers['route']);
		parent::__construct();
	}

	/**
	 * 根据惯例进行路由分发，只有在所有自定义
	 * 路由规则均无法匹配的情况下才被调用
	 * 
	 * @throws PageNotFoundException
	 * @return void|unknown
	 */
	public function dispatch_convention(){
		if(!class_exists($this->_controller)){
			throw new PageNotFoundException('The controller does not exist!');
		}
		// 创建控制器并执行动作
		$this->_hook->call('before_controller');
		$this->_benchMark->mark('controller_start');
		
		$controller = new $this->_controller();
		
		if(!method_exists($controller, $this->_action)) {
			throw new PageNotFoundException('Controller method specified does not exist!');
		}
		
		$view = $controller->{$this->_action}(Registry::load('\Arsenals\Core\Input'));
		
		$this->_benchMark->mark('controller_end');
		$this->_hook->call('after_controller');
		
		// 如果视图含有_output方法，则使用视图自定义的输出方式处理
		if(method_exists($controller, '_output')){
			$controller->_output($view);
			return ;
		}
		
		$this->view($view);
	}
	/**
	 * 基于自定义路由规则的路由分发
	 * 
	 * @param unknown $callback_funcs
	 * @param array $args
	 * @return mixed
	 */
	public function dispatch_map($callback_funcs, $args){
		// 返回值 [0] 正则 [1] 回调函数
		//$callback_funcs = CommonUtils::array_val_by_key_regexp(self::$_router_defined, $this->_path_info);
		// 捕获正则组
		$matches = array();
		preg_match($callback_funcs[0], $this->_path_info, $matches);
		
		// 移除原始路径
		if(is_array($matches) && count($matches) > 0){
			$matches = array_slice($matches, 1);
		}
		
		// 追加提供的参数
		if (count($args) > 0) {
			$matches = array_merge($matches, $args);
		}
		
		// 调用函数OR控制器
		$controller_func = CommonUtils::convStringToCallUserFuncParam($callback_funcs[1]);
		// 如果第一个参数为Input类型，则注入Input对象
		$reflectionParameter = null;
		if(is_array($controller_func)){// 如果为数组，则第一个参数为对象，第二个为方法名
			// 反射获取参数对象
			$reflectionClass = new \ReflectionClass($controller_func[0]);
			$reflectionMethod = $reflectionClass->getMethod($controller_func[1]);
			$reflectionParameter = $reflectionMethod->getParameters();
		}else if (is_callable($controller_func)){// 如果可执行，则为回调函数
			// 反射获取参数对象
			$reflectionFunc = new \ReflectionFunction($controller_func);
			$reflectionParameter = $reflectionFunc->getParameters();
		}
		// 在含有参数的情况下，检查第一个参数是否为Input
		if ($reflectionParameter != null && count($reflectionParameter) > 0){
			if ($reflectionParameter[0] instanceof \ReflectionParameter 
				&& !is_null($reflectionParameter[0]->getClass()) 
				&& $reflectionParameter[0]->getClass()->getName() == 'Arsenals\Core\Input') {
				// 第一个参数设为$input,INPUT类的实例
				array_unshift($matches, Registry::load('\Arsenals\Core\Input'));
			}
		}
		$this->_hook->call('before_controller');
		$this->_benchMark->mark('controller_start');
		
		$view = call_user_func_array($controller_func, $matches);
		
		$this->_benchMark->mark('controller_end');
		$this->_hook->call('after_controller');

		$this->view($view);
	}

	/**
	 * 获取当前控制器名
	 * 
	 * @return string
	 */
	public function getController(){
		return $this->_controller;
	}
	
	/**
	 * 获取当前动作名称
	 * 
	 * @return string
	 */
	public function getAction(){
		return $this->_action;
	}
	/**
	 * 获取当前的PATH_INFO
	 * 
	 * @return string
	 */
	public function getPathInfo(){
		return $this->_path_info;		
	}
	/**
	 * 将控制器处理的结果交费视图层
	 * @param unknown $view
	 */
	private function view($view){
		// 处理输出
		$output = Registry::load('Arsenals\Core\Output');
		// 根据返回类型进行创建相应的视图对象
		$output->render($view);
	}
}
