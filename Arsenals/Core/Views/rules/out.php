<?php
/**
 * 参数： value[, escape=false][, default=null] 
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	$default = isset($params['default']) ? $params['default'] : 'null';
	if(isset($params['escape']) && $params['escape']){
		return "<?php echo htmlspecialchars({$params['value']} == null ? {$default} : {$params['value']});?>";
	}
	return "<?php echo {$params['value']} == null ? {$default} : {$params['value']};?>";
};
return array('out', true, $callback);