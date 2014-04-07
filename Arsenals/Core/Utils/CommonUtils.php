<?php

namespace Arsenals\Core\Utils;

use \Arsenals\Core\Registry;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 实用功能方法
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class CommonUtils {
	/**
	 * 转换类方法的字符串为call_user_func能够识别的参数类型
	 * @param unknown $class_str
	 * @return Ambigous <unknown, multitype:string Ambigous <object, multitype:> >
	 */
	public static function convStringToCallUserFuncParam($class_str){
		$validate_entity = $class_str;
		if(is_string($class_str)){
			// 如果规则中含有@，则规则实体为对象的普通方法
			// 如果不含@和::，则说明规则实体为普通函数
			$at_pos = strpos($class_str, '@');
			if($at_pos > 0){
				$class_name = substr($class_str, 0, $at_pos);
				$method_name = substr($class_str, $at_pos + 1);
				$class = Registry::load($class_name);
				$validate_entity = array($class, $method_name);
			}
		}
		
		return $validate_entity;
	}
	/**
	 * 正则表达式验证数组中是否含有key
	 * @param unknown $search_key
	 * @param unknown $array
	 * @return boolean
	 */
	public static function array_key_exists_regexp($search_key, $array){
		foreach ($array as $key => $value){
			if(preg_match($key, $search_key)){
				return true;
			}
		}
		return false;
	}
	/**
	 * 正则表达式匹配数组中是否含有值
	 * @param unknown $search
	 * @param unknown $array
	 * @return boolean
	 */
	public static function array_exists_regexp($search, $array){
		foreach ($array as $arr){
			$reg = '/' . str_replace('/', '\/', $arr) . '/';
			if(preg_match($reg, $search)){
				return true;
			}
		}
		return false;
	}
	/**
	 * 正则表达式从数组中获取值
	 * @param unknown $array
	 * @param unknown $key
	 * @return unknown|NULL
	 */
	public static function array_val_by_key_regexp($array, $search_key){
		foreach ($array as $key => $value){
			if(preg_match($key, $search_key)){
				return array($key, $value);
			}
		}
		return null;
	}
}
