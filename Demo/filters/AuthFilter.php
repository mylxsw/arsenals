<?php

namespace Demo\filters;

use Arsenals\Core\Abstracts\Filter;
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
		$filterChain->doFilter();
	}

	
}
