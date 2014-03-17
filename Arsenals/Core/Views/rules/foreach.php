<?php
/**
 * 参数： data, var [, index]
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(isset($params['data']) && isset($params['var'])){
		if(isset($params['index'])){
			return "<?php foreach({$params['data']} as \${$params['index']} => \${$params['var']} ) {";
		}
		return "<?php foreach({$params['data']} as \${$params['var']} ) {";
	}
	return "<!-- Template Syntax Error! -->";
};

return array('(foreach|loop)', false, $callback);