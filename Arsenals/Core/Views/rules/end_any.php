<?php if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 参数： 无
 */ 
$callback = function($matches){
	//$params = parse_params($matches['content']);
	return "<?php } ?>";
};
return array('#</__namespace__:(?<tag>(if|switch|loop|foreach|while|for)+)\s*>#', false, $callback, true);