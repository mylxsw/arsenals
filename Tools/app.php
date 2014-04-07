<?php
/**
 * Initialize the user project
 * 
 * @author  Yiyao Guan <mylxsw@126.com>
 * 
 * 
 */ 
require 'libs.php';
// If not in CLI mode, exit
if(!is_cli()){
	exit();
}

$usage = <<<USAGE
 * Usage:
 * 		php app.php -n PROJECT_NAME
 * 
 * Optional parameters:
 * 		--author
 *   	--db_prefix
 *    	--db_dbname
 *     	--db_user
 *      --db_password
 *      --db_host
 *      --db_port
 *		--view_theme
USAGE;

cli_opt_init('n:', array(
	'author:', 'db_prefix:', 'db_dbname:', 'db_user:', 'db_password:', 'db_host:', 'db_port:', 'view_theme:'
	));

// get the project name from command line
$proj_meta = get_project_meta($usage);
// initialize the project name and path
$proj_name = $proj_meta['proj_name'];
$proj_path = $proj_meta['proj_path'];

$parameters = array();
$parameters['author'] = get_arg('author', get_current_user());// current user
$parameters['db_prefix'] = get_arg('db_prefix', strtolower($proj_name) . '_');// database prefix
$parameters['db_dbname'] = get_arg('db_dbname', 'db_' . strtolower($proj_name));// database name
$parameters['db_username'] = get_arg('db_user', 'root');// database user name
$parameters['db_password'] = get_arg('db_password', '');// database password
$parameters['db_host'] = get_arg('db_host', 'localhost');// database host
$parameters['db_port'] = get_arg('db_port', '3306');// database port
$parameters['view_theme'] = get_arg('view_theme', 'default');// theme
$parameters['namespace'] = $proj_name;


$dirs = array(
	'caches',
	'configs',
	'controllers',
	'filters',
	'hoooks',
	'models',
	'views' . DIRECTORY_SEPARATOR . $parameters['view_theme'],
);

$index_file = '..' . DIRECTORY_SEPARATOR . strtolower($proj_name) . '.php';
$files = array(
	'Bootstrap.php'				=> 'templates/Bootstrap.tpl',
	'configs/config.php' 		=> 'templates/configs/config.tpl',
	'configs/database.php' 		=> 'templates/configs/database.tpl',
	'configs/router.php'		=> 'templates/configs/router.tpl',
	'controllers/Index.php'		=> 'templates/controllers/Index.tpl',
	$index_file					=> 'templates/index.tpl',
);

$base_path = $proj_path . $proj_name . DIRECTORY_SEPARATOR;

// create project directories
create_dir_from_array($dirs, $base_path);

// create project template files
create_file_from_array($files, $parameters, $base_path);

output("\nThe Project {$proj_name} has been created ");