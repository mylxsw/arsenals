<?php
require 'BuildTools.php';

$usage = <<<USAGE
 * Usage:
 * 		php model.php -n PROJECT_NAME 
 * 
 * Optional parameters:
 * 		--author
 *   	--model
USAGE;

BuildTools::isCLI() || exit($usage);

$opts = array(
	'model_name'		=> '',
	'author'			=> get_current_user()
);

try{
	$tools = new BuildTools($opts);
	$tools->readConfig();
	if ($tools->getParam('model_name') == ''){
		exit($usage);
	}
	$model_file = $tools->getParam('model') . DIRECTORY_SEPARATOR . $tools->getParam('model_name') . '.php';
	
	$tools->addReplaceVar('namespace', BuildTools::convPath2Namespace($tools->getProjectName() . DIRECTORY_SEPARATOR . $tools->getParam('model')));
	
	$files = array(
		$model_file			=> 'templates/model.tpl'
	);
	
	$tools->createFiles($files);
} catch (Exception $e){
	BuildTools::output($usage);
}
