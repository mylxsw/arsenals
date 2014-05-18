<?php if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 参数： test
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(isset($params['file'])){
		return "<?php echo \Arsenals\Core\Views\ViewAndModel::make(\"{$params['file']}\"); ?>";
	}
	return "<!-- Template Syntax Error! -->";
};

return array('include', true, $callback);