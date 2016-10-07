<?php

require 'BuildTools.php';

$usage = <<<'USAGE'
 * Usage:
 * 		php filter.php -n PROJECT_NAME 
 * 
 * Optional parameters:
 * 		--author
 *   	--filter_name
USAGE;

BuildTools::isCLI() || exit($usage);

$opts = [
    'filter_name'        => '',
    'author'             => get_current_user(),
];

try {
    $tools = new BuildTools($opts);
    $tools->readConfig();
    if ($tools->getParam('filter_name') == '') {
        exit($usage);
    }
    $model_file = $tools->getParam('filter').DIRECTORY_SEPARATOR.$tools->getParam('filter_name').'.php';

    $tools->addReplaceVar('namespace', BuildTools::convPath2Namespace($tools->getProjectName().DIRECTORY_SEPARATOR.$tools->getParam('filter')));

    $files = [
        $model_file            => 'templates/filter.tpl',
    ];

    $tools->createFiles($files);
} catch (Exception $e) {
    BuildTools::output($usage);
}
