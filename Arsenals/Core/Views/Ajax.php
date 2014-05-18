<?php

namespace Arsenals\Core\Views;

use \Arsenals\Core\Abstracts\Arsenals;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * Ajax返回值
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Ajax extends Arsenals {
	/**
	 * 存储ajax对象数据
	 * @var array
	 */
	private $datas = array();
	/**
	 * 构造函数
	 * @param array $datas 返回的ajax数据
	 */
	function __construct($datas = array()) {
		$this->datas = $datas;
		parent::__construct();
	}
	/**
	 * 添加数据
	 * @param string $key
	 * @param mixed $value
	 */
	public function add($key, $value){
		$this->datas[$key] = $value;
	}
	/**
	 * 取值
	 * @param string $key
	 * @param string $default
	 * @return multitype:|string
	 */
	public function get($key, $default = null){
		if(array_key_exists($key, $this->datas)){
			return $this->datas[$key];
		}
		return $default;
	}
	/**
	 * 返回所有的值
	 * @return array 
	 */
	public function getDatas(){
		return $this->datas;
	}
}
