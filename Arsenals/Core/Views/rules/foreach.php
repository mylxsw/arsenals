<?php
$callback = function($matches){
	$params = Arsenals\Core\Views\TemplateCompiler::parse_params($matches['content']);
	if(array_key_exists('data', $params)){
		return "<?php } else if ({$params['test']}) { ?>";
	}
	return "模板错误！";
};

return array('(foreach|loop)', false, $callback);