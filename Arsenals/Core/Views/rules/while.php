<?php
/**
 * 参数： test
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(array_key_exists('test', $params)){
		return "<?php while ({$params['test']}) { ?>";
	}
	return "模板错误！";
};

return array('if', false, $callback);