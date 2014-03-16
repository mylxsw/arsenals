<?php
$callback = function($matches){
	$params = Arsenals\Core\Views\TemplateCompiler::parse_params($matches['content']);
	if(array_key_exists('escape', $params)){
		return "<?php echo htmlspecialchars({$params['value']});?>";
	}
	return "<?php echo {$params['value']};?>";
};
return array('out', true, $callback);