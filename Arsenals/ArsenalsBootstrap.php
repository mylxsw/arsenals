<?php
namespace Arsenals;

use \Arsenals\Core\Registry;

if (!defined('APP_NAME')) exit('Access Denied!');

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
		// 定义系统常量
		define('ARSENALS_VERSION', '1.0 dev');// 框架版本
		
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
			throw new \Exception('PHP版本必须大于 5.3.0 !');
		}
		// 检查是否完成了必须的配置
		// 检查应用名称是否定义
		if(!defined('APP_NAME')){
			throw new \Exception('APP_NAME必须定义 ！');
		}
		// 检查系统路径是否定义
		if(!defined('BASE_PATH')){
			throw new \Exception('BASE_PATH必须定义！');
		}

		// 是否调试模式和记录日志
		defined('DEBUG') || define('DEBUG', false);
		defined('LOG') || define('LOG', false);
		
		// 定义错误，异常处理
		defined('ERROR_HANDLER') 			|| define('ERROR_HANDLER', '\Arsenals\Core\_error_handler');
		defined('EXCEPTION_HANDLER') 		|| define('EXCEPTION_HANDLER', '\Arsenals\Core\_exception_handler');
		
		
		// 框架目录配置
		define('ARSENALS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
		define('ARSENALS_CORE_PATH', ARSENALS_PATH . 'Core' . DIRECTORY_SEPARATOR);
		define('ARSENALS_CONFIG_PATH', ARSENALS_PATH . 'Configs' . DIRECTORY_SEPARATOR);
		define('ARSENALS_LANG_PATH', ARSENALS_PATH . 'Langs' . DIRECTORY_SEPARATOR);
		
		
		// 采用的视图层
		defined('VIEW_IMPL') 				|| define('VIEW_IMPL', '\Arsenals\Core\Views\SimpleView');
		// 日志实现
		defined('LOG_IMPL') 				|| define('LOG_IMPL', '\Arsenals\Core\Logs\FileLogImpl');
		
		// 应用路径
		defined('APP_PATH') 				|| define('APP_PATH', BASE_PATH . APP_NAME . DIRECTORY_SEPARATOR);
		defined('CONFIG_PATH') 				|| define('CONFIG_PATH', APP_PATH . 'configs' . DIRECTORY_SEPARATOR);
		defined('CONTROLLER_PATH') 			|| define('CONTROLLER_PATH', APP_PATH . 'controllers' . DIRECTORY_SEPARATOR);
		defined('FILTER_PATH') 				|| define('FILTER_PATH', APP_PATH . 'filters' . DIRECTORY_SEPARATOR );
		defined('VIEW_PATH') 				|| define('VIEW_PATH', APP_PATH . 'views' . DIRECTORY_SEPARATOR);
		defined('CACHE_PATH') 				|| define('CACHE_PATH', APP_PATH . 'caches' . DIRECTORY_SEPARATOR);
		defined('LANG_PATH') 				|| define('LANG_PATH', APP_PATH . 'langs' . DIRECTORY_SEPARATOR);
		defined('MODEL_PATH') 				|| define('MODEL_PATH', APP_PATH . 'models' . DIRECTORY_SEPARATOR);
		
		// 默认时区配置
		defined('DEFAULT_TIME_ZONE') 		|| define('DEFAULT_TIME_ZONE', 'PRC');
		// 设置时区
		date_default_timezone_set(DEFAULT_TIME_ZONE);
		
		
		// 载入系统函数库
		require ARSENALS_CORE_PATH . 'Common.php';
		
		// 系统开始前
		// 一定要在加载系统函数库之前，因为
		// 在这里可以完成系统函数库的重写
		$hook = Registry::load('\Arsenals\Core\Hooks');
		$hook->call('before_system');

		
		// 框架依赖的一些常用函数，可以在前置钩子
		// 中通过相同命名空间重写函数
		require ARSENALS_CORE_PATH . 'OverrideFuncs.php';

		// 配置统一的异常处理
		set_error_handler(\Arsenals\Core\conv_str_to_call_user_func_param(ERROR_HANDLER));
		set_exception_handler(\Arsenals\Core\conv_str_to_call_user_func_param(EXCEPTION_HANDLER));
		
		// 开始计算系统运行时间
		$benchMark = Registry::load('\Arsenals\Core\Benchmark');
		$benchMark->mark('system_start');
		
		// 增加过滤器控制
		// 类似于Java Servlet中的Filter
		$filter = Registry::load('\Arsenals\Core\Filters');
		$filter->init();
		
		// 进行路由调度
		$filter->dispatch($this);
		
		// 记录系统运行结束时间
		$benchMark->mark('system_end');
		$hook->call('after_system');
				
		// 项目定义的清理操作
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
	/**
	 * 执行清理工作
	 */ 
	public function clear(){}
}