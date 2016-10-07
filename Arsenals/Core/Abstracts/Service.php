<?php

namespace Arsenals\Core\Abstracts;

use Arsenals\Core\conv_path_to_ns;
use Arsenals\Core\Registry;

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}
/**
 * 抽象Service.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
abstract class Service extends Arsenals
{
    private static $_inner_module = [
        'Input'                    => '\Arsenals\Core\Input',
        'Output'                   => '\Arsenals\Core\Output',
        'Router'                   => '\Arsenals\Core\Router',
        'Security'                 => '\Arsenals\Core\Security',
        'Session'                  => '\Arsenals\Core\Session',
        'Uri'                      => '\Arsenals\Core\Uri',
        'ViewAndModel'             => '\Arsenals\Core\Views\ViewAndModel',
    ];

    /**
     * 加载模型.
     *
     * 如果模型名是以\\开头，则说明指定了命名空间，不再使用默认命名空间
     *
     * @param string $model_name
     *
     * @return Ambigous <object, mixed, multitype:>
     */
    protected function model($model_name)
    {
        if (!Registry::exist($model_name)) {
            if (\Arsenals\Core\str_start_with($model_name, '\\')) {
                $model = $model_name;
            } else {
                $model = conv_path_to_ns(MODEL_PATH).ucfirst($model_name);
            }
            Registry::register($model_name, new $model());
        }

        return Registry::get($model_name);
    }

    /**
     * 载入模块.
     *
     * @param $module_name
     */
    protected function load($module_name)
    {
        if (array_key_exists($module_name, self::$_inner_module)) {
            return Registry::load(self::$_inner_module[$module_name]);
        }

        return Registry::load($module_name);
    }
}
