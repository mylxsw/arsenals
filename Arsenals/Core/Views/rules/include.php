<?php
/**
 * 参数： test
 */ 
$callback = function($matches){
	$params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
	if(isset($params['file'])){
		return "<?php echo \Arsenals\Core\Views\ViewAndModel::make(\"{$params['file']}\"); ?>";
	}
	return "模板错误！";
};

return array('include', true, $callback);