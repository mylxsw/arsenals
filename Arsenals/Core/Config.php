<?php

namespace Arsenals\Core;

use \Arsenals\Core\Abstracts\Arsenals;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 配置管理类
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Config extends Arsenals {
	/**
	 * 缓存的配置文件
	 * @var unknown
	 */
	private static $_configs = array();
	/**
	 * 从指定文件中加载配置
	 * @param string $file_name
	 * @return array
	 */
	public static function load($file_name){
		// 如果没有再如果该配置文件，则进行载入
		if(!isset(self::$_configs[$file_name])){
			// 首先加载核心配置
			$core_config_file = ARSENALS_CONFIG_PATH . $file_name . '.php';
           
			if(\file_exists($core_config_file)){
				$configs = include $core_config_file;
			}else{
				$configs = array();
			}
			
			// 判断是否项目中含有配置文件，如果有则合并
			if(\file_exists(CONFIG_PATH . $file_name . '.php')){
				$app_configs = include CONFIG_PATH . $file_name . '.php';
				$configs = array_merge($configs, $app_configs);
			}
			self::$_configs[$file_name] = $configs;
		}
		return self::$_configs[$file_name];
	}
}
