<?php
/**
 * 参数： var, value 
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(isset($params['var']) && isset($params['value'])){
		return "<?php \${$params['var']} = {$params['value']} ; ?>";
	}
	return "<!-- Template Syntax Error! -->";
};
return array('set', true, $callback);