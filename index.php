<?php
/**
 * Arsenals框架示例程序入口
 */
use Demo\DemoBootstrap;

// 定义项目配置
define('APP_NAME', 'Demo');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
// 调试模式
define('DEBUG', true);
define('LOG', true);
// 项目入口
require BASE_PATH . 'Demo/DemoBootstrap.php';
$instance = new DemoBootstrap();
$instance->startup();
