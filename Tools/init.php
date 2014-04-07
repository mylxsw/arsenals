<?php
/**
 * Initialize the user project
 * 
 * @author  Yiyao Guan <mylxsw@126.com>
 * 
 * 
 */ 
// If not in CLI mode, exit
$mode = php_sapi_name();
if($mode != 'cli'){
	exit();
}

require 'libs.php';

$usage = <<<USAGE
 * Usage:
 * 		php init.php -n PROJECT_NAME
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

$opts = getopt('n:', array('name:',
						'db_prefix:',
						'db_dbname:',
						'db_user:',
						'db_password:',
						'db_host:',
						'db_port:',
						'author:',
						'view_theme:'
					));

// get the project name from command line
$proj_name = '';
if(isset($opts['n'])){
	$proj_name = $opts['n'];
}else if( isset($opts['name'])){
	$proj_name = $opts['name'];
}else{
	exit($usage);
}


// initialize the project name and path
$proj_path = dirname($proj_name);
if($proj_path == '.'){
	$proj_path = '.' . DIRECTORY_SEPARATOR . 'output';
}

$proj_path = $proj_path . DIRECTORY_SEPARATOR;
$proj_name = basename($proj_name);

// parameters
$arg_author = get_arg($opts, 'author', get_current_user());// current user
$db_prefix = get_arg($opts, 'db_prefix', strtolower($proj_name) . '_');// database prefix
$db_dbname = get_arg($opts, 'db_dbname', 'db_' . strtolower($proj_name));// database name
$db_username = get_arg($opts, 'db_user', 'root');// database user name
$db_password = get_arg($opts, 'db_password', '');// database password
$db_host = get_arg($opts, 'db_host', 'localhost');// database host
$db_port = get_arg($opts, 'db_port', '3306');// database port

$view_theme = get_arg($opts, 'view_theme', 'default');// theme


// variable replace
$replace_var = array(
	'#\[\[namespace\]\]#' 		=> $proj_name,
	'#\[\[author\]\]#'			=> $arg_author,
	'#\[\[db_prefix\]\]#'		=> $db_prefix,
	'#\[\[db_dbname\]\]#'		=> $db_dbname,
	'#\[\[db_username\]\]#'		=> $db_username,
	'#\[\[db_password\]\]#'		=> $db_password,
	'#\[\[db_host\]\]#'		=> $db_host,
	'#\[\[db_port\]\]#'		=> $db_port,
	'#\[\[view_theme\]\]#'		=> $view_theme,
);

$dirs = array(
	'caches',
	'configs',
	'controllers',
	'filters',
	'hoooks',
	'models',
	'views' . DIRECTORY_SEPARATOR . $view_theme,
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

// create project directories
foreach($dirs as $dir){
	$dirname = preg_replace('#/#', DIRECTORY_SEPARATOR, $proj_path . $proj_name . DIRECTORY_SEPARATOR . $dir);
	mkdirs($dirname);
	output("Create directory: {$dirname} ");
}

// create project template files
foreach($files as $file => $tpl){
	$filename = preg_replace('#/#', DIRECTORY_SEPARATOR,  $proj_path . $proj_name . DIRECTORY_SEPARATOR . $file );
	mkdirs(dirname($filename));
	file_exists($filename) || file_put_contents($filename, get_template_content($tpl, $replace_var));
	output("Generate file: {$filename} ");
}

output("\nThe Project {$proj_name} has been created ");



