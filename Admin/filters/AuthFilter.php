<?php
namespace Admin\filters;

use Arsenals\Core\Abstracts\Filter;
use Arsenals\Core\Registry;
use Arsenals\Core\Session;
use Arsenals\Libraries\Authorization\exceptions\AuthException;
use Demo\views\ink\header;
use Arsenals\Core\Config;
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
		try{
			$path_info = $router->getPathInfo();
			
			$auth = Registry::load('Arsenals\\Libraries\\Authorization\\Authencation');
			$auth->check($path_info, Session::get('user', array(
					'role' => 'anonymous'
			)));
			
			$filterChain->doFilter();
			
		}catch (AuthException $e){
			$config = Config::load('config');
			header("Location: " . $config['site_url'] . 'admin.php/account/login');
		}
	}
}
