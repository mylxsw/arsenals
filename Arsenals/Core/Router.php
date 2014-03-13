<?php

namespace Arsenals\Core;
use Arsenals\Core\Abstracts\Arsenals;
use Arsenals\Core\Utils\CommonUtils;
use Arsenals\Core\Exceptions\PageNotFoundException;
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
		// 替换为标准正则表达式
		$key = str_replace(
				array_keys(self::$_regexp_replace_vars), 
				array_values(self::$_regexp_replace_vars), 
				'/' . str_replace('/', '\/', trim($url, '/')) . '/');
		self::$_router_defined[$key] = $route;
		
		$args = array();
		if(func_num_args() > 2){
			$func_args = func_get_args();
			$args = array_splice($func_args, 2);
		}
		self::$_router_data[$key] = $args;
	}
	
	public function __construct(){
		// 加载配置文件
		$this->_routers = Config::load('router');
		$uri = Registry::load('Arsenals\\Core\\Uri');
		
		$this->_path_info = $uri->getPathInfo();
		$this->_controller = CONTROLLER_NAMESPACE . ($uri->getModuleName() == '' ? 
				$uri->getControllerName() 
				:($uri->getModuleName() . '\\' . $uri->getControllerName())) ;
		$this->_action = $uri->getActionName();
		// 钩子
		$this->_hook = Registry::load('Arsenals\\Core\\Hooks');
		
		// 配置文件定义的路由
		self::$_router_defined = array_merge(self::$_router_defined, $this->_routers['route']);
		parent::__construct();
	}
	
	/**
	 * 执行路由调度
	 */
	public function dispatch(){
		// 如果匹配了指定的路由规则，则使用路由规则进行路由分发，否则使用惯例优先
		if (CommonUtils::array_key_exists_regexp($this->_path_info, self::$_router_defined)){
			// 返回值 [0] 正则 [1] 回调函数
			$callback_funcs = CommonUtils::array_val_by_key_regexp(self::$_router_defined, $this->_path_info);
			// 捕获正则组
			$matches = array();
			preg_match($callback_funcs[0], $this->_path_info, $matches);
			
			// 移除原始路径
			if(is_array($matches) && count($matches) > 0){
				$matches = array_slice($matches, 1);
			}
			
			// 追加提供的参数
			$data = self::$_router_data[$callback_funcs[0]];
			if (count($data) > 0) {
				$matches = array_merge($matches, $data);
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
					&& $reflectionParameter[0]->getClass()->getName() == 'Arsenals\\Core\\Input') {
					// 第一个参数设为$input,INPUT类的实例
					array_unshift($matches, Registry::load('\\Arsenals\\Core\\Input'));
				}
			}
			$this->_hook->call('before_controller');
			$this->_benchMark->mark('controller_start');
			
			$view = call_user_func_array($controller_func, $matches);
			
			$this->_benchMark->mark('controller_end');
			$this->_hook->call('after_controller');
		}else{
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
			
			$view = $controller->{$this->_action}(Registry::load('\\Arsenals\\Core\\Input'));
			
			$this->_benchMark->mark('controller_end');
			$this->_hook->call('after_controller');
			
			// 如果视图含有_output方法，则使用视图自定义的输出方式处理
			if(method_exists($controller, '_output')){
				$controller->_output($view);
				return ;
			}
		}
		
		// 处理输出
		$output = Registry::load('Arsenals\\Core\\Output');
		// 根据返回类型进行创建相应的视图对象
		$output->render($view);
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
}
