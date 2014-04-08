<?php
/**
 * Initialize the user project
 * 
 * @author  Yiyao Guan <mylxsw@126.com>
 * 
 * 
 */ 
require 'BuildTools.php';

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
 *		--model
 *		--controller
 *		--cache
 *		--filter
USAGE;

BuildTools::isCLI() || exit($usage);

$opts = array(
	'author' 		=> get_current_user(),
	'db_prefix'		=> '',
	'db_host'		=> 'localhost',
	'db_user'		=> 'root',
	'db_password'	=> '',
	'db_dbname'		=> '',
	'db_port'		=> '3306',
	'view_name'		=> 'default',
	'model'			=> 'models',
	'controller'	=> 'controllers',
	'filter'		=> 'filters',
	'cache'			=> 'caches'
);
try{
	$tools = new BuildTools($opts);
	
	$dirs = array(
		$tools->getParam('cache'),
		'configs',
		$tools->getParam('controller'),
		$tools->getParam('filter'),
		'hooks',
		$tools->getParam('model'),
		'views' . DIRECTORY_SEPARATOR . $tools->getParam('view_theme'),
	);
	
	$index_file = '..' . DIRECTORY_SEPARATOR . strtolower($tools->getProjectName()) . '.php';
	$index_controller = $tools->getParam('controller') . DIRECTORY_SEPARATOR . 'Index.php';
	$files = array(
		'Bootstrap.php'										=> 'templates/Bootstrap.tpl',
		'configs/config.php' 								=> 'templates/configs/config.tpl',
		'configs/database.php' 								=> 'templates/configs/database.tpl',
		'configs/router.php'								=> 'templates/configs/router.tpl',
		$index_controller									=> 'templates/controllers/Index.tpl',
		$index_file											=> 'templates/index.tpl',
	);
	
	$tools->addReplaceVar('db_prefix', strtolower($tools->getProjectName()) . '_');
	$tools->addReplaceVar('db_dbname', 'db_' . strtolower($tools->getProjectName()));
	$tools->addReplaceVar('namespace', $tools->getProjectName());
	
	$tools->createDirs($dirs);
	$tools->createFiles($files);
	
	$tools->createConfigFile();
} catch (Exception $e){
	BuildTools::output($usage);
}