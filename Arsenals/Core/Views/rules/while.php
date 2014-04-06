<?php if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 参数： test
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(array_key_exists('test', $params)){
		return "<?php while ({$params['test']}) { ?>";
	}
	return "<!-- Template Syntax Error! -->";
};

return array('while', false, $callback);