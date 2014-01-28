<?php
use Admin\AdminBootstrap;
// 定义项目配置
define('APP_NAME', 'Admin');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
// 调试模式
define('DEBUG', true);
define('LOG', true);
// 项目入口
require BASE_PATH . 'Admin/AdminBootstrap.php';
$instance = new AdminBootstrap();
$instance->startup();