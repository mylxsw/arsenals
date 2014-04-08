<?php
require 'libs.php';
// If not in CLI mode, exit
if(!is_cli()){
	exit();
}

$usage = <<<USAGE
 * Usage:
 * 		php controller.php -n PROJECT_NAME 
 * 
 * Optional parameters:
 * 		--author
 *    	--path
 * 		--namespace
 *		--controller
USAGE;

cli_opt_init('n:', array('controller:', 'author:', 'namespace:', 'path:'));

// get the project name from command line
$proj_meta = get_project_meta($usage);
// initialize the project name and path
$proj_name = $proj_meta['proj_name'];
$proj_path = $proj_meta['proj_path'];
$base_path = $proj_path . $proj_name . DIRECTORY_SEPARATOR;

if(!is_dir($base_path)){
	exit(" The project name does not exist!");
}

$parameters = array();
// The controller name is required
$parameters['controller'] = get_arg('controller', '');
if($parameters['controller'] == '') exit('The controller name is required!');

$parameters['author'] = get_arg('author', get_current_user());// current user
$parameters['namespace'] = get_arg('namespace', $proj_name . '\controllers');
$parameters['path'] = rtrim(rtrim(get_arg('path', 'controllers'), '\\'), '/') . DIRECTORY_SEPARATOR;

$controller_filename = $parameters['path'] . $parameters['controller'] . '.php';

$files = array(
	$controller_filename => 'templates/controller.tpl'
	);

// create project template files
create_file_from_array($files, $parameters, $base_path);

output("\nThe Controller {$parameters['controller']} has been created ");