<?php

namespace Admin;

use Arsenals\Core\Exceptions\PageNotFoundException;
use Arsenals\Core\Router as Route;

require BASE_PATH.'Arsenals'.DIRECTORY_SEPARATOR.'ArsenalsBootstrap.php';

class AdminBootstrap extends \Arsenals\ArsenalsBootstrap
{
    public function run()
    {
        Route::map('widget/(:any)', function ($widgetName) {
            $widget = new \Admin\controllers\Widget();
            if (!\Arsenals\Core\str_start_with($widgetName, '_') && method_exists($widget, $widgetName)) {
                return $widget->{$widgetName}();
            }
            throw new PageNotFoundException('您访问的Widget不存在！');
        });
        Route::map('^$', '\Admin\controllers\Index@main');
    }
}
