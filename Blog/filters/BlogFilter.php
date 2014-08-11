<?php

namespace Blog\filters;

use Arsenals\Core\Abstracts\Filter;
/**
 *
 * @author guan
 *        
 */
class BlogFilter implements Filter {
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Abstracts\Filter::doFilter()
	 */
	public function doFilter(\Arsenals\Core\Filters $filterChain,\Arsenals\Core\Router $router) {
		try{
			$filterChain->doFilter();
		}catch (\Arsenals\Core\Exceptions\ArsenalsException $e){
            throw $e;
            /*
            if($e instanceof \Arsenals\Core\Exceptions\TypeErrorException){
				echo "字段类型异常：{$e->getMessage()} ";
			}else if($e instanceof \Arsenals\Core\Exceptions\PageNotFoundException){
				echo "页面不存在 404 : {$e->getMessage()}";
			}else{
				throw $e;
			}
            */
		}
	}

	
}
