<?php
use Admin\AdminBootstrap;
// 定义项目配置
define('APP_NAME', 'Admin');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
// 调试模式
define('DEBUG', true);
define('LOG', true);
// 定义缓存文件路径
define('CACHE_PATH', BASE_PATH . 'Temp' . DIRECTORY_SEPARATOR);
// 项目入口
require BASE_PATH . 'Admin/AdminBootstrap.php';
$instance = new AdminBootstrap();
$instance->startup();