<?php
$callback = function($matches){
	$params = Arsenals\Core\Views\TemplateCompiler::parse_params($matches['content']);
	if(array_key_exists('test', $params)){
		return "<?php if ({$params['test']}) { ?>";
	}
	return "模板错误！";
};

return array('if', false, $callback);