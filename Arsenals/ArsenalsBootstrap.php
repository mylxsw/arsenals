<?php

namespace Arsenals;

use Arsenals\Core\Registry;
use Arsenals\Core\Abstracts\Arsenals;
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
	public function startup(){
		// 检查PHP版本
		if(version_compare(PHP_VERSION, '5.3.0', '>=')){
			// 初始化环境变量
			self::$_paths = array_merge(
				array_map(function($item){
							return APP_PATH . $item;
						}, self::$_paths), 
				explode(PATH_SEPARATOR, get_include_path()));
			// 类自动加载
			spl_autoload_register(array(new self(), 'autoload'), true, true);
			// 处理魔术引号
			if(version_compare(PHP_VERSION, '5.4.0', '<')){
				define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
			}else{
				define('MAGIC_QUOTES_GPC', false);
			}
		}else{
			throw new \Exception('The version of PHP can not be less than 5.3.0 !');
		}
		// 检查是否完成了必须的配置
		if(!defined('APP_NAME')){
			throw new \Exception('The constant APP_NAME not defined ！');
		}
		if(!defined('BASE_PATH')){
			throw new \Exception('The constant BASE_PATH not defined ！');
		}
		// 定义系统常量
		defined('ERROR_HANDLER') || define('ERROR_HANDLER', 'Arsenals\Core\_error_handler');
		defined('EXCEPTION_HANDLER') || define('EXCEPTION_HANDLER', 'Arsenals\Core\_exception_handler');
		defined('LOG_IMPL') || define('LOG_IMPL', 'Arsenals\Core\Logs\FileLogImpl');// 日志实现
		
		define('ARSENALS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
		define('ARSENALS_CORE_PATH', ARSENALS_PATH . 'Core' . DIRECTORY_SEPARATOR);
		define('ARSENALS_CONFIG_PATH', ARSENALS_PATH . 'Configs' . DIRECTORY_SEPARATOR);
		define('ARSENALS_LIBRARIES_PATH', ARSENALS_PATH . 'Libraries' . DIRECTORY_SEPARATOR);
		define('ARSENALS_LANG_PATH', ARSENALS_PATH . 'Langs' . DIRECTORY_SEPARATOR);
		
		// 是否调试模式和记录日志
		defined('DEBUG') || define('DEBUG', false);
		defined('LOG') || define('LOG', false);
		
		defined('DEFAULT_TIME_ZONE') || define('DEFAULT_TIME_ZONE', 'PRC');
		
		defined('APP_PATH') || define('APP_PATH', BASE_PATH . APP_NAME . DIRECTORY_SEPARATOR);
		defined('CONFIG_PATH') || define('CONFIG_PATH', APP_PATH . 'configs' . DIRECTORY_SEPARATOR);
		defined('VIEW_PATH') || define('VIEW_PATH', APP_PATH . 'views' . DIRECTORY_SEPARATOR);
		defined('VIEW_LAYER') || define('VIEW_LAYER', 'Arsenals\Core\Views\SimpleView');
		defined('CACHE_PATH') || define('CACHE_PATH', APP_PATH . 'caches' . DIRECTORY_SEPARATOR);
		defined('LANG_PATH') || define('LANG_PATH', APP_PATH . 'langs' . DIRECTORY_SEPARATOR);
		
		defined('MODEL_NAMESPACE') || define('MODEL_NAMESPACE', APP_NAME . '\models\\');
		defined('SERVICE_NAMESPACE') || define('SERVICE_NAMESPACE', APP_NAME . '\services\\');
		defined('CONTROLLER_NAMESPACE') || define('CONTROLLER_NAMESPACE', APP_NAME . '\controllers\\');
		defined('FILTER_NAMESPACE') || define('FILTER_NAMESPACE', APP_NAME . '\filters\\');
		
		// 载入系统钩子，对系统进行扩展
		$hook = Registry::load('Arsenals\Core\Hooks');
		// 系统开始前
		$hook->call('before_system');

		// 载入系统函数库
		require ARSENALS_CORE_PATH . 'Common.php';

		// 配置统一的异常处理
		set_error_handler(\Arsenals\Core\Utils\CommonUtils::convStringToCallUserFuncParam(ERROR_HANDLER));
		set_exception_handler(\Arsenals\Core\Utils\CommonUtils::convStringToCallUserFuncParam(EXCEPTION_HANDLER));
		
		
		// 开始计算系统运行时间
		$benchMark = Registry::load('Arsenals\Core\Benchmark');
		$benchMark->mark('system_start');
		
		// 设置时区
		date_default_timezone_set(DEFAULT_TIME_ZONE);
		// 执行入口运行初始化
		$this->run();
		
		// 对用户输入进行预处理
		Registry::register('Arsenals\Core\Input');
		// 注册Session
		Registry::register('Arsenals\Core\Session');
		
		// 执行安全检查
		$security = Registry::load('Arsenals\Core\Security');
		
		// 路由转发
		$router = Registry::load('Arsenals\Core\Router');
		
		// 增加过滤器控制
		$filter = Registry::load('Arsenals\Core\Filters');
		$filter->init($router);
		
		// 进行路由调度
		$filter->dispatch();
		// 记录系统运行结束时间
		$benchMark->mark('system_end');
		
		$log = Registry::load('Arsenals\Core\Log');
		$log->debug("The system has been running : {$benchMark->elapsedTime('system_start', 'system_end')}", 'system');
		$log->debug("The controller has been running : {$benchMark->elapsedTime('controller_start', 'controller_end')}", 'system');
		
		$this->clear();
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
	/**
	 * 子类覆写该方法，实现系统的自定义初始化工作
	 */
	public function run(){}

	public function clear(){}
}