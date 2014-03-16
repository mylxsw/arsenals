<?php

namespace Demo\filters;

use Arsenals\Core\Abstracts\Filter;
use Arsenals\Core\Exceptions\InnerException;
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
		try{
			$filterChain->doFilter();
		}catch (\Exception $e){
			if(!$e instanceof \Arsenals\Core\Exceptions\ArsenalsException){
				throw new InnerException($e->getMessage());
			}
			throw $e;
		}
	}

	
}
