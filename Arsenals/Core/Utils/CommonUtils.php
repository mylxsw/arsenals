<?php

namespace Arsenals\Core\Utils;

use Arsenals\Core\Registry;
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
}
