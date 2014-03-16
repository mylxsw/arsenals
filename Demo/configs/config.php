<?php
/**
 * 项目配置
 * 
 * @author 管宜尧
 */ 
$global_base_config = require(BASE_PATH . 'Config/base.config.php');
return array_merge($global_base_config, array(
	'theme'			=>	'inkTpl',
	'hook_enabled'	=>	true
));