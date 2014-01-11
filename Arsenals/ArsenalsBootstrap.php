<?php

namespace Arsenals;

use Arsenals\Core\Registry;
/**
 * Arsenals框架入口
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class ArsenalsBootstrap {
	/**
	 * 环境变量
	 * @var array
	 */
	private static $_paths = array(
		
	);
	
	/**
	 * 执行框架
	 * @throws \Exception
	 */
	public static function run(){
		// 检查PHP版本
		if(version_compare(PHP_VERSION, '5.3.0', '>=')){
			// 类自动加载
			spl_autoload_register(array(new self(), 'autoload'), true, true);
			// 处理魔术引号
			if(version_compare(PHP_VERSION, '5.4.0', '<')){
				define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
			}else{
				define('MAGIC_QUOTES_GPC', false);
			}
		}else{
			throw new \Exception('PHP版本不能小于5.3.0！');
		}
		// 检查是否完成了必须的配置
		if(!defined('APP_NAME')){
			throw new \Exception('APP_NAME必须定义！');
		}
		if(!defined('BASE_PATH')){
			throw new \Exception('BASE_PATH必须定义！');
		}
		// 定义系统常量
		define('ARSENALS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
		define('ARSENALS_CORE_PATH', ARSENALS_PATH . 'Core' . DIRECTORY_SEPARATOR);
		define('ARSENALS_CONFIG_PATH', ARSENALS_PATH . 'Configs' . DIRECTORY_SEPARATOR);
		define('ARSENALS_LIBRARIES_PATH', ARSENALS_PATH . 'Libraries' . DIRECTORY_SEPARATOR);
		
		defined('APP_PATH') || define('APP_PATH', BASE_PATH . APP_NAME . DIRECTORY_SEPARATOR);
		defined('CONFIG_PATH') || define('CONFIG_PATH', APP_PATH . 'configs' . DIRECTORY_SEPARATOR);
		defined('VIEW_PATH') || define('VIEW_PATH', APP_PATH . 'views' . DIRECTORY_SEPARATOR);
		defined('VIEW_LAYER') || define('VIEW_LAYER', 'Arsenals\\Core\\Views\\SimpleView');
		
		defined('MODEL_NAMESPACE') || define('MODEL_NAMESPACE', APP_NAME . '\\models\\');
		defined('SERVICE_NAMESPACE') || define('SERVICE_NAMESPACE', APP_NAME . '\\services\\');
		defined('CONTROLLER_NAMESPACE') || define('CONTROLLER_NAMESPACE', APP_NAME . '\\controllers\\');
		defined('FILTER_NAMESPACE') || define('FILTER_NAMESPACE', APP_NAME . '\\filters\\');
		
		// 载入系统函数库
		require ARSENALS_CORE_PATH . 'Common.php';
		// 配置统一的异常处理
		set_error_handler('Arsenals\\Core\\_error_handler');
		set_exception_handler('Arsenals\\Core\\_exception_handler');
		
		// 初始化环境变量
		self::$_paths = array_merge(
				array_map(function($item){
							return APP_PATH . $item;
						}, self::$_paths), 
				explode(PATH_SEPARATOR, get_include_path()));
		
		// 对用户输入进行预处理
		Registry::register('Arsenals\\Core\\Input');
		
		// 载入系统钩子，对系统进行扩展
		$hook = Registry::load('Arsenals\\Core\\Hooks');
		// 系统开始前
		$hook->call('before_system');
		
		// 注册Session
		Registry::register('Arsenals\\Core\\Session');
		
		// 执行安全检查
		$security = Registry::load('Arsenals\\Core\\Security');
		$security->init();
		
		// 路由转发
		$router = Registry::load('Arsenals\\Core\\Router');
		$router->init();
		
		// 增加过滤器控制
		$filter = Registry::load('Arsenals\\Core\\Filters');
		$filter->init($router);
		
		// 进行路由调度
		$filter->dispatch();
	}
	/**
	 * 自动加载文件
	 * @param string $class
	 */
	public static function autoload($class){
		foreach (self::$_paths as $path){
			$file = $path . DIRECTORY_SEPARATOR .
			 		str_replace('\\', DIRECTORY_SEPARATOR, trim($class, '\\')) .
					'.php';
			if(file_exists($file)){
				include $file;
				return ;
			}
		}
	}
}