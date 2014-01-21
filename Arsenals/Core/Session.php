<?php

namespace Arsenals\Core;

use Arsenals\Core\Abstracts\Arsenals;
/**
 * Session 管理类
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Session extends Arsenals {
	/**
	 * 构造函数，完成初始化Session
	 */
	public function __construct(){
		session_start();
		parent::__construct();
	}
	/**
	 * 获取当前Session的ID
	 * @return string
	 */
	public static function getId(){
		return session_id();
	}
	/**
	 * 获取当前Session名字
	 * @return string
	 */
	public static function getName(){
		return session_name();
	}
	/**
	 * 设置当前Session名字
	 * @param string $name
	 * @return string
	 */
	public static function setName($name){
		return session_name($name);
	}
	
	/**
	 * 设置当前Session的ID
	 * @param string $id
	 * @return string
	 */
	public static function setId($id){
		return session_id($id);
	}
	/**
	 * 添加到Session
	 * @param string $key
	 * @param mixed $value
	 */
	public static function add($key, $value){
		$_SESSION[$key] = $value;
	}
	/**
	 * 从Session中移除
	 * @param string $key
	 */
	public static function remove($key){
		unset($_SESSION[$key]);
	}
	/**
	 * 从Session中读取值
	 * @param string $key
	 * @param mixed $default 默认值
	 * @return mixed
	 */
	public static function get($key, $default = null){
		if(array_key_exists($key, $_SESSION)){
			return $_SESSION[$key];
		}
		return $default;
	}
	/**
	 * 清空Session
	 */
	public static function clear(){
		session_unset();
	}
	/**
	 * 销毁Session
	 */
	public static function destory(){
		session_destroy();
	}
	/**
	 * 重新创建Session
	 * @param bool $delete_old_session 是否删除原始session中的数据
	 */
	public static function regenerateId($delete_old_session = false){
		session_regenerate_id($delete_old_session);
	}
	/**
	 * Session编码
	 * @return string
	 */
	public static function encode(){
		return session_encode();
	}
	/**
	 * 解码编码后的session字符串到Session中
	 * @param mixed $data
	 * @return boolean
	 */
	public static function decode($data){
		return session_decode($data);
	}
	/**
	 * 写入session数据并结束session
	 */
	public static function flush(){
		session_write_close();
	}
}
