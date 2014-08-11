<?php
/**
 * Index file
 */

// Project configuration
define('APP_NAME', '[[namespace]]');
define('BASE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

// debug mode
define('DEBUG', true);
define('LOG', false);

// Error and exception handler
//define('ERROR_HANDLER', 'Demo\\common\\ExceptionHandler@error');
//define('EXCEPTION_HANDLER', 'Demo\\common\\ExceptionHandler@exception');

// view layer
define('VIEW_LAYER', '\Arsenals\Core\Views\ArsenalsTemplates');

// initialize
require BASE_PATH . '[[namespace]]' . DIRECTORY_SEPARATOR . 'Bootstrap.php';
$instance = new \[[namespace]]\Bootstrap();
$instance->startup();
