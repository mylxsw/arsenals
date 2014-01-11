<?php

namespace Arsenals\Core;

use Arsenals\Core\Abstracts\Arsenals;
/**
 * 输入处理类
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Input extends Arsenals {
	
	private $_get;
	private $_post;
	private $_cookies;

	/**
	 * 初始化Input对象
	 */ 
	public function __construct(){
		
		// 如果开启了MAGIC_QUOTES_GPC,则需要对所有的魔术变量stripslashes
		if(MAGIC_QUOTES_GPC){
			$globals = array('_POST', '_GET', '_COOKIE', '_REQUEST');
			
			foreach ($globals as $global){
				$$global = self::_clean($global);
			}
		}
		
		
		$this->_get = $_GET;
		$this->_post = $_POST;
		$this->_request = $_REQUEST;
		$this->_cookies = $_COOKIE;
	}
	/**
	 * 获取GET值
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */ 
	public function get($key, $default = null){
		if(!array_key_exists($key, $this->_get)){
			return $default;
		}
		return $this->_get[$key];
	}
	/**
	 * 获取POST值
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function post($key, $default = null){
		return $this->_post[$key];
	}
	/**
	 * 获取REQUEST值
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function request($key, $default = null){
		return $this->_request[$key];
	}
	/**
	 * 获取COOKIE值
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function cookie($key, $default = null){
		return $this->_cookies[$key];
	}
	/**
	 * 反引用一个引用字符串
	 * @param string|array $array
	 * @return string
	 */
	protected static function _clean($array){
		if(is_array($array)){
			return array_map(__CLASS__ . '::_clean', $array);
		}
		return stripslashes($array);
	}
}
