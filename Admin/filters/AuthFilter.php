<?php
namespace Admin\filters;

use Arsenals\Core\Abstracts\Filter;
use Arsenals\Core\Registry;
use Arsenals\Core\Session;
/**
 * 权限控制过滤器
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class AuthFilter implements Filter {
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Abstracts\Filter::doFilter()
	 */
	public function doFilter(\Arsenals\Core\Filters $filterChain,\Arsenals\Core\Router $router) {
		$path_info = $router->getPathInfo();
		
		$auth = Registry::load('Arsenals\\Libraries\\Authorization\\Authencation');
		$auth->check($path_info, Session::get('user', array(
			'role' => 'anonymous'
		)));
		
		$filterChain->doFilter();
		
	}
}
