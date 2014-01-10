<?php

namespace Arsenals\Core;

use Arsenals\Core\Abstracts\Arsenals;
use Arsenals\Core\Abstracts\Filter;
use Arsenals\Core\Exceptions\ClassTypeException;
/**
 * 过滤器实现
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Filters extends Arsenals {
	private static $_filters;
	private $_router;
	
	/**
	 * 过滤器初始化
	 */
	public function init(Router $router){
		self::$_filters = Config::load('filter');
		$this->_router = $router;
	}
	/**
	 * 执行过滤器
	 * @throws ClassTypeException
	 */
	public function doFilter(){
		if(count(self::$_filters) == 0){
			return $this->run();
		}
		$filterName = FILTER_NAMESPACE . array_shift(self::$_filters);
		$filter = new $filterName();
		if(!$filter instanceof Filter){
			throw new ClassTypeException("过滤器{$filterName}必须实现Arsenals\\Core\\Abstracts\\Filter接口！");
		}
		
		$filter->doFilter($this, $this->_router);
	}
	
	/**
	 * 执行路由调度
	 */
	public function dispatch(){
		$this->doFilter();
	}
	/**
	 * 执行具体的请求
	 */
	private function run(){
		$this->_before();
		try{
			ob_start();
				
			$this->_router->dispatch();
				
			$content = ob_get_contents();
			ob_end_clean();
		}catch (\Exception $e){
			$this->_afterThrowException($e);
		}
		
		$this->_after($content);
	}
	
	/**
	 * 控制器方法执行之前
	 */
	private function _before(){
		
	}
	/**
	 * 控制器、视图渲染之后
	 * @param Router $router
	 * @param string $content
	 */
	private function _after($content){
		echo $content;
	}
	/**
	 * 处理过程出现异常
	 * @param Router $router
	 * @param Exception $e
	 */
	private function _afterThrowException(\Exception $e){
		
	}
}
