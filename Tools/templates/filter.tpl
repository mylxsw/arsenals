<?php
namespace [[namespace]];

use \Arsenals\Core\Abstracts\Filter;
/**
 * [[filter]] Filter
 * 
 * @author [[author]]
 *
 */
class [[filter]] implements Filter {
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Abstracts\Filter::doFilter()
	 */
	public function doFilter(\Arsenals\Core\Filters $filterChain,\Arsenals\Core\Router $router) {
		
		$filterChain->doFilter();

	}
}
