<?php

namespace Arsenals\Core;

use \Arsenals\Core\Abstracts\Arsenals;
use \Arsenals\Core\Abstracts\Filter;
use \Arsenals\Core\Exceptions\ClassTypeException;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 过滤器实现
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Filters extends Arsenals {
	private static $_filters;
	private $_router;
	private $_bootstrap;
	
	/**
	 * 过滤器初始化
	 */
	public function init(){
		self::$_filters = Config::load('filter');
		$this->_router = Registry::load('Arsenals\Core\Router');
	}
	/**
	 * 执行过滤器
	 * @throws ClassTypeException
	 */
	public function doFilter(){
		// 如果过滤器链已经遍历完成，则执行最后路由调度
		if(count(self::$_filters) == 0){
			// 执行路由调度
			$this->_bootstrap->run();
			// 如果没有匹配的规则，则执行基于惯例的路由调度
			if (!Router::$_stop) {
				$this->_router->dispatch_convention();
			}
			return true;
		}
		// 遍历过滤器链
		$filterName = FILTER_NAMESPACE . array_shift(self::$_filters);
		$filter = new $filterName();
		if(!$filter instanceof Filter){
			throw new ClassTypeException("The filter {$filterName} must implement the interface : Arsenals\\Core\\Abstracts\\Filter！");
		}
		
		$filter->doFilter($this, $this->_router);
	}
	
	/**
	 * 执行路由调度
	 */
	public function dispatch($bootstrap){
		$this->_bootstrap = $bootstrap;
		$this->doFilter();
	}

}
