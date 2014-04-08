<?php
use Arsenals\Core\file_exists;
require 'libs.php';
// If not in CLI mode, exit
if(!is_cli()){
	exit();
}

$usage = <<<USAGE
 * Usage:
 * 		php model.php -n PROJECT_NAME 
 * 
 * Optional parameters:
 * 		--author
 *   	--model
 *    	--path
USAGE;

cli_opt_init('n:', array('model:', 'author:', 'namespace:', 'path:'));

// get the project name from command line
$proj_meta = get_project_meta($usage);
// initialize the project name and path
$proj_name = $proj_meta['proj_name'];
$proj_path = $proj_meta['proj_path'];
$base_path = $proj_path . $proj_name . DIRECTORY_SEPARATOR;

if(!is_dir($base_path)){
	exit(" The project name does not exist!");
}

$project_conf_file = $proj_path . $proj_name . DIRECTORY_SEPARATOR . 'project.cfg.php';
$project_conf = array();
if(file_exists($project_conf_file)){
	$project_conf = include $project_conf_file;
}


$parameters = array();
// The model name is required
$parameters['model_name'] = get_arg('model', '');
if($parameters['model_name'] == '') exit('The model name is required!');

$parameters['author'] = get_arg('author', get_current_user());// current user
$parameters['namespace'] = preg_replace('/', '\\', get_arg('namespace', isset($project_conf['model']) ? $project_conf['model'] : ($proj_name . '\models')));
$parameters['path'] = rtrim(rtrim(get_arg('path', 'models'), '\\'), '/') . DIRECTORY_SEPARATOR;

$model_filename = $parameters['path'] . $parameters['model_name'] . '.php';

$files = array(
	$model_filename => 'templates/model.tpl'
	);

// create project template files
create_file_from_array($files, $parameters, $base_path);

output("\nThe Model {$parameters['model_name']} has been created ");