<?php

namespace Arsenals\Core;
use Arsenals\Core\Abstracts\Arsenals;
use Arsenals\Core\Utils\CommonUtils;
/**
 * 路由控制
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Router extends Arsenals {
	private static $_router_defined = array();
	
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
		':num' 				=> '[0-9]*',
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
	}
	/**
	 * 路由初始化
	 */
	public function init(){}
	
	/**
	 * 执行路由调度
	 */
	public function dispatch(){
		
		if (CommonUtils::array_key_exists_regexp($this->_path_info, self::$_router_defined)){
			// 返回值 [0] 正则 [1] 回调函数
			$callback_funcs = CommonUtils::array_val_by_key_regexp(self::$_router_defined, $this->_path_info);
			// 捕获正则组
			$matches = array();
			preg_match($callback_funcs[0], $this->_path_info, $matches);
			
			// 移除原始路径
			if(is_array($matches) && count($matches) > 1){
				$matches = array_slice($matches, 1);
			}
			// 第一个参数设为$input,INPUT类的实例
			array_unshift($matches, Registry::load('\\Arsenals\\Core\\Input'));
			// 调用函数OR控制器
			$view = call_user_func_array(CommonUtils::convStringToCallUserFuncParam($callback_funcs[1]), $matches);
		}else{
			// 创建控制器并执行动作
			$this->_hook->call('before_controller_init');
			$controller = new $this->_controller();
			$this->_hook->call('after_controller_init');
			
			$this->_hook->call('before_action');
			$view = $controller->{$this->_action}(Registry::load('\\Arsenals\\Core\\Input'));
			$this->_hook->call('after_action');
			
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
}
