<?php

namespace Arsenals\Core\Abstracts;

use Arsenals\Core\Filters;
use Arsenals\Core\Router;
/**
 * 过滤器接口
 * @author 管宜尧<mylxsw@126.com>
 *
 */
interface Filter {
	public function doFilter(Filters $filterChain, Router $router);
}
