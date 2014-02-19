<?php
/**
 * Arsenals框架示例程序入口
 */
use Demo\DemoBootstrap;

// 定义项目配置
define('APP_NAME', 'Demo');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
// 调试模式
define('DEBUG', false);
define('LOG', false);
// 定义缓存文件路径
define('CACHE_PATH', BASE_PATH . 'Temp' . DIRECTORY_SEPARATOR);

define('ERROR_HANDLER', 'Demo\\common\\ExceptionHandler@error');
define('EXCEPTION_HANDLER', 'Demo\\common\\ExceptionHandler@exception');


// 项目入口
require BASE_PATH . 'Demo/DemoBootstrap.php';
$instance = new DemoBootstrap();
$instance->startup();
