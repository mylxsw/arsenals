<?php

namespace Arsenals\Core\Views;
use Arsenals\Core\Abstracts\Arsenals;
/**
 * 值栈
 * 
 * @author code.404
 *
 */
class ValueStack extends Arsenals {
	private static $_stack_map = array();
	
	private function __construct(){}
	
	public static function add($key, $value){
		self::$_stack_map[$key] = $value;
	}
	
	public static function get($key){
		return self::$_stack_map[$key];
	}
	
	public static function clear(){
		self::$_stack_map = array();
	}
	
	public static function remove($key){
		unset(self::$_stack_map[$key]);
	}
	
	public static function gets(){
		return self::$_stack_map;
	}
	
	public static function addAll($datas){
		if(!is_array($datas)){
			return ;
		}
		self::$_stack_map = array_merge(self::$_stack_map, $datas);
	}
}
