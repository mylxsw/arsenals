<?php
/**
 * Arsenals框架示例程序入口
 */
use Blog\BlogBootstrap;

// 定义项目配置
define('APP_NAME', 'Blog');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

// 这里的IS_SAE并不一定需要手动定义系统会自动定义，但是这里需要设置
// 在sae环境下禁止debug模式，所以手动定义
define('IS_SAE', isset($_SERVER['HTTP_APPCOOKIE']));
// 调试模式
define('DEBUG', !IS_SAE);
define('LOG', false);
// 定义缓存文件路径
define('CACHE_PATH', BASE_PATH . 'Temp' . DIRECTORY_SEPARATOR);

define('ERROR_HANDLER', 'Blog\common\ExceptionHandler@error');
define('EXCEPTION_HANDLER', 'Blog\common\ExceptionHandler@exception');
define('VIEW_IMPL', 'Arsenals\Core\Views\ArsenalsTemplates');

// 项目入口
require BASE_PATH . 'Blog/BlogBootstrap.php';
$instance = new BlogBootstrap();
$instance->startup();
