<?php

namespace Arsenals\Core\Abstracts;

use Arsenals\Core\Config;
use Arsenals\Core\Registry;
use Arsenals\Core\Views\ViewAndModel;
use Arsenals\Core\Views\Ajax;
use Arsenals\Core\Exceptions\TypeErrorException;
/**
 * 抽象控制器
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
abstract class Controller extends Service {
	/**
	 * 需要传递给视图的数据
	 * @var array
	 */
	private $_view_datas = array();
	
	/**
	 * 实现对资源的快速访问（类似于Ioc）
	 *
	 * 由系统创建（注入）所需要的资源，而不需要手动的实例化创建
	 *
	 * @param $name
	 * @return object
	 */
	public function __get($name){
		$config = Config::load('config');
		$class_name = preg_replace('/\./', '\\', SERVICE_NAMESPACE . '.' . ucfirst($name));
		$this->$name = new $class_name;
		return $this->$name;
	}
	/**
	 * 获取get值
	 * @param unknown $key
	 * @param string $default
	 * @param string $type
	 */
	protected function get($key, $default = null, $type = null){
		$input = Registry::load('\\Arsenals\\Core\\Input');
		return $input->get($key, $default, $type);
	}
	/**
	 * 获取post值
	 * @param unknown $key
	 * @param string $default
	 * @param string $type
	 */
	protected function post($key, $default = null, $type = null){
		$input = Registry::load('\\Arsenals\\Core\\Input');
		return $input->post($key, $default, $type);
	}
	/**
	 * 返回模型视图
	 * @param string $view_name
	 * @param array $data
	 * @return \Arsenals\Core\View\ViewAndModel
	 */
	protected function view($view_name, $data = array()){
		return ViewAndModel::make($view_name, array_merge($this->_view_datas, $data));
	}
	/**
	 * 返回Ajax结果视图
	 * @param array $data
	 * @return \Arsenals\Core\Views\Ajax
	 */
	protected function ajax($data = array()){
		return new Ajax($data);
	}
	/**
	 * 传递给视图的值
	 * @param string $key
	 * @param mixed $data
	 */
	protected function assign($key, $data){
		if(!is_string($key)){
			throw new TypeErrorException("key必须为字符串格式！");
		}
		$this->_view_datas[$key] = $data;
	}
}
