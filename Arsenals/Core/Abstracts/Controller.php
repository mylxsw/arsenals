<?php

namespace Arsenals\Core\Abstracts;

use Arsenals\Core\Config;
use Arsenals\Core\Registry;
use Arsenals\Core\Views\ViewAndModel;
use Arsenals\Core\Views\Ajax;
/**
 * 抽象控制器
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
abstract class Controller extends Service {
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
	 */
	protected function get($key, $default = null){
		$input = Registry::load('\\Arsenals\\Core\\Input');
		return $input->get($key, $default);
	}
	/**
	 * 获取post值
	 * @param unknown $key
	 * @param string $default
	 */
	protected function post($key, $default = null){
		$input = Registry::load('\\Arsenals\\Core\\Input');
		return $input->post($key, $default);
	}
	/**
	 * 返回模型视图
	 * @param string $view_name
	 * @param array $data
	 * @return \Arsenals\Core\View\ViewAndModel
	 */
	protected function view($view_name, $data = array()){
		return new ViewAndModel($view_name, $data);
	}
	/**
	 * 返回Ajax结果视图
	 * @param array $data
	 * @return \Arsenals\Core\Views\Ajax
	 */
	protected function ajax($data = array()){
		return new Ajax($data);
	}
}
