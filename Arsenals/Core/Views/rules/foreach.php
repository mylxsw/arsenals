<?php if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 参数： items, var [, index]
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(isset($params['items']) && isset($params['var'])){
		if(isset($params['index'])){
			return "<?php foreach({$params['items']} as \${$params['index']} => \${$params['var']} ) { ?>";
		}
		return "<?php foreach({$params['items']} as \${$params['var']} ) { ?>";
	}
	return "<!-- Template Syntax Error! -->";
};

return array('(foreach|loop)', false, $callback);