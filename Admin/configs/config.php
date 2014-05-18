<?php
/**
 * 项目配置
 * 
 * @author 管宜尧
 */ 
$global_base_config = require(BASE_PATH . 'Config/base.config.php');
return array_merge(array(
    //	'site_url'		=>	'http://agiledev.sinaapp.com/'
	), $global_base_config, array(
	'multi_theme'	=> false,
	'hook_enabled'	=>	true
));