<?php
/**
 * Arsenals框架示例程序入口
 */
use Dlroom\DlroomBootstrap;

// 定义项目配置
define('APP_NAME', 'Dlroom');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
// 调试模式
define('DEBUG', true);
define('LOG', false);
// 定义缓存文件路径
define('CACHE_PATH', BASE_PATH . 'Temp' . DIRECTORY_SEPARATOR);

//define('ERROR_HANDLER', 'Blog\common\ExceptionHandler@error');
//define('EXCEPTION_HANDLER', 'Blog\common\ExceptionHandler@exception');
define('VIEW_IMPL', 'Arsenals\Core\Views\ArsenalsTemplates');

// 项目入口
require BASE_PATH . 'Dlroom/DlroomBootstrap.php';
$instance = new DlroomBootstrap();
$instance->startup();
