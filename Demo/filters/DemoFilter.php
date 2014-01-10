<?php

namespace Demo\filters;

use Arsenals\Core\Abstracts\Filter;
/**
 *
 * @author guan
 *        
 */
class DemoFilter implements Filter {
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Abstracts\Filter::doFilter()
	 */
	public function doFilter(\Arsenals\Core\Filters $filterChain,\Arsenals\Core\Router $router) {
		$filterChain->doFilter();		
	}

	
}
