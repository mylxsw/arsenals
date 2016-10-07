<?php

namespace Blog\filters;

use Arsenals\Core\Abstracts\Filter;

/**
 * 缓存过滤器.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
class CacheFilter implements Filter
{
    /* (non-PHPdoc)
     * @see \Arsenals\Core\Abstracts\Filter::doFilter()
     */
    public function doFilter(\Arsenals\Core\Filters $filterChain, \Arsenals\Core\Router $router)
    {
        $path_info = $router->getPathInfo();

        // 所有文章页面内容缓存
        if (\Arsenals\Core\str_start_with($path_info, 'article/')) {
            $cache_file = BASE_PATH.$path_info;

            // 如果存在文件，则读取缓存
            if (!DEBUG && \Arsenals\Core\file_exists($cache_file)) {
                echo \Arsenals\Core\file_get_contents($cache_file);

                return true;
            }

            // 如果不存在，则重新写入文件
            ob_start();
            $filterChain->doFilter();
            $content = ob_get_contents();
            ob_end_clean();

            \Arsenals\Core\file_put_contents($cache_file, $content);

            echo $content;

            return true;
        }

        $filterChain->doFilter();
    }
}
