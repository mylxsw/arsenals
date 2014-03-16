<?php
/**
 * 参数： test
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(isset($params['file'])){
		\Arsenals\Core\Views\ViewAndModel::make($params['file']);
		return "<?php include (\"{$params['file']}.php\"); ?>";
	}
	return "模板错误！";
};

return array('include', true, $callback);