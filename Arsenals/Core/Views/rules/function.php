<?php
/**
 * 参数： test
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(isset($params['func'])){
		return "<?php echo {$params['func']};  ?>";
	}
	return "模板错误！";
};

return array('func', true, $callback);