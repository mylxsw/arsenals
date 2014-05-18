<?php if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 参数： 无
 */ 
$callback = function($matches){
	//$params = parse_params($matches['content']);
	return "<?php } else { ?>";
};
return array('else', true, $callback);