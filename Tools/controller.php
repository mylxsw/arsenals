<?php
require 'BuildTools.php';

$usage = <<<USAGE
 * Usage:
 * 		php controller.php -n PROJECT_NAME 
 * 
 * Optional parameters:
 * 		--author
 *   	--controller_name
USAGE;

BuildTools::isCLI() || exit($usage);

$opts = array(
	'controller_name'		=> '',
	'author'			=> get_current_user()
);

try{
	$tools = new BuildTools($opts);
	$tools->readConfig();
	if ($tools->getParam('controller_name') == ''){
		exit($usage);
	}
	$model_file = $tools->getParam('controller') . DIRECTORY_SEPARATOR . $tools->getParam('controller_name') . '.php';
	
	$tools->addReplaceVar('namespace', BuildTools::convPath2Namespace($tools->getProjectName() . DIRECTORY_SEPARATOR . $tools->getParam('controller')));
	
	$files = array(
		$model_file			=> 'templates/controller.tpl'
	);
	
	$tools->createFiles($files);
} catch (Exception $e){
	BuildTools::output($usage);
}