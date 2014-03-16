<?php
$callback = function($matches){
	//$params = parse_params($matches['content']);
	return "<?php } else { ?>";
};
return array('else', true, $callback);