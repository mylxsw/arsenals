<?php

namespace Arsenals\Core;

use Arsenals\Core\Abstracts\Arsenals;
/**
 * Uri 解析
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Uri extends Arsenals {
	/**
	 * 模块名称
	 * @var string
	 */
	private $_module_name;
	/**
	 * 控制器名称
	 * @var string
	 */
	private $_controller_name;
	/**
	 * 动作名称
	 * @var string
	 */
	private $_action_name;
	/**
	 * 访问的路径
	 * @var string
	 */
	private $_path_info;
	
	/**
	 * 构造函数
	 */
	public function __construct(){
		// 加载配置文件
		$router_config = Config::load('router');
		
		// 获取访问路径信息
		$this->_path_info = $path_info = array_key_exists('PATH_INFO', $_SERVER) ? 
							trim($_SERVER['PATH_INFO'], '/')
							: '';
		$paths = preg_split('/\//', $path_info);
		
		if($path_info != ''){
			//$module_paths = preg_split('/\./', $paths[0], 2);
			$last_slash_pos = strrpos($paths[0], '.');
				
			if($last_slash_pos > 0){
				$this->_module_name = str_replace('.', '\\', substr($paths[0], 0, $last_slash_pos));
				$this->_controller_name = ucfirst(substr($paths[0], $last_slash_pos + 1));
			}else{
				$this->_module_name = '';
				$this->_controller_name = ucfirst($paths[0]);
			}
			$this->_action_name = count($paths) >= 2 ? $paths[1] : $router_config['default_action'];
		}else{
			$this->_controller_name = ucfirst(preg_replace('/\./', '\\',
					$router_config['default_controller']));
			$this->_action_name = $router_config['default_action'];
			$this->_module_name = '';
		}
	}
	/**
	 * 获取控制器名称
	 * @return string
	 */
	public function getControllerName(){
		return $this->_controller_name;
	}
	/**
	 * 获取模块名称
	 * @return string
	 */
	public function getModuleName(){
		return $this->_module_name;
	}
	/**
	 * 获取动作名称
	 * @return string
	 */
	public function getActionName(){
		return $this->_action_name;
	}
	/**
	 * 获取当前的路径信息
	 */
	public function getPathInfo(){
		return $this->_path_info;
	}
}
