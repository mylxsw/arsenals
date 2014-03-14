<?php

namespace Arsenals\Core;
use Arsenals\Core\Exceptions\RedefineException;
use Arsenals\Core\Exceptions\ClassNotFoundException;
use Arsenals\Core\Abstracts\Arsenals;
/**
 * 载入类对象注册器
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Registry extends Arsenals {
	/**
	 * @static 缓存的对象
	 */
	private static $_cache_objects = array();
	/**
	 * 防止该类被克隆
	 */
	private function __clone(){}
	/**
	 * 判断指定类是否已经加载过了
	 * 
	 * @param string $class_name
	 * @return boolean
	 */
	public static function exist($class_name){
		return array_key_exists(ucfirst($class_name), self::$_cache_objects);
	}
	/**
	 * 载入指定类对象
	 *
	 * 如果该对象不存在，则创建该对象
	 *
	 * @param string $calss_name 类名
	 * @param  bool $config 是否加载配置文件
	 * @return object
	 */
	public static function load($class_name, $config = false){
		// 如果类名不含有命名空间，则首字母默认大写
		if(strpos($class_name, '\\') === false){
			$class_name = ucfirst($class_name);
		}
		// 如果已经加载过了，则不再重复加载
		if(!array_key_exists($class_name, self::$_cache_objects)){
			$config_arr = array();
			if($config !== false){
				// 加载配置
				$last_occr_pos = strrpos($class_name, '\\');
				$config_file_name = strtolower(substr($class_name, $last_occr_pos === false ? 0 : $last_occr_pos));

				$config_arr = Config::load($config_file_name);
			}
			// 如果参数config是数组，则合并为新的参数
			if(is_array($config)){
				$config_arr = array_merge($config_arr, $config);
			}
			self::$_cache_objects[$class_name] = new $class_name($config_arr);
		}
		return self::$_cache_objects[$class_name];
	}
	/**
	 * 获取指定的对象
	 *
	 * 如果该对象不存在，则返回指定的默认值
	 *
	 * @param string $class_name 要载入的类名
	 * @param mixed $default 默认值
	 *
	 * @return object
	 */
	public static function get($class_name, $default = null){
		$class_name = ucfirst($class_name);
		if(isset(self::$_cache_objects[$class_name])){
			return self::$_cache_objects[$class_name];
		}
		return $default;
	}
	/**
	 * 注册一个类对象
	 *
	 * @param string $class_name 要注册的类名
	 * @param object $object 要注册的对象，如果为null，则注册类名的对象
	 * @param  bool $config 是否加载配置文件
	 * 
	 * @return void
	 */
	public static function register($class_name, $object = null, $config = false){
		// 如果类名不含有命名空间，则首字母默认大写
		if(strpos($class_name, '\\') === false){
			$class_name = ucfirst($class_name);
		}
		// 如果已经加载过了，则不再重复加载
		if(!array_key_exists($class_name, self::$_cache_objects)){
			if(!is_null($object)){
				self::$_cache_objects[$class_name] = $object;
				return ;
			}

			$config_arr = array();
			if($config !== false){
				// 加载配置
				$last_occr_pos = strrpos($class_name, '\\');
				$config_file_name = strtolower(substr($class_name, $last_occr_pos === false ? 0 : $last_occr_pos));

				$config_arr = Config::load($config_file_name);
			}
			// 如果参数config是数组，则合并为新的参数
			if(is_array($config)){
				$config_arr = array_merge($config_arr, $config);
			}
			self::$_cache_objects[$class_name] = new $class_name($config_arr);
		}else if(!is_null($object)){
			throw new RedefineException('This class name is already registered, different objects can not be registered again!');
		}
	}
	
	/**
	 * 替换已经注册的类对象
	 *
	 * @param string $class_name 要注册的类名
	 * @param object $object 要注册的对象，如果为null，则注册类名的对象
	 *
	 * @return void
	 */
	public static function replace($calss_name, $object = null){
		$class_name = ucfirst($class_name);
		if(is_null($object)){
			self::$_cache_objects[$class_name] = new $class_name;
		}else{
			self::$_cache_objects = $object;
		}
	}
	/**
	 * 移除已经注册的类对象
	 *
	 * @param string $class_name 要移除的类对象名
	 * @return void
	 */
	public static function remove($class_name){
		$class_name = ucfirst($class_name);
		if(!array_key_exists($class_name, self::$_cache_objects)){
			throw new ClassNotFoundException('No object of that class be found!');
		}
		unset(self::$_cache_objects[$calss_name]);
	}
	/**
	 * 重置
	 */
	public static function clear(){
		self::$_cache_objects = array();
	}
}
