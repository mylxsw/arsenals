<?php
use Arsenals\ArsenalsBootstrap;
// 定义项目配置
define('APP_NAME', 'Demo');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
//define('VIEW_LAYER', 'Arsenals\Libraries\Twig\TwigView');
define('VIEW_LAYER', 'Arsenals\Core\Views\SimpleView');
// 项目入口
require BASE_PATH . 'Arsenals' . DIRECTORY_SEPARATOR . 'ArsenalsBootstrap.php';
ArsenalsBootstrap::run();