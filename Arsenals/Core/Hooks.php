<?php

namespace Arsenals\Core;

use Arsenals\Core\Abstracts\Arsenals;
/**
 * 系统钩子
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Hooks extends Arsenals {
	/**
	 * 是否允许钩子调用
	 * @var bool
	 */
	private $_hook_enabled = false;
	
	private $_hooks = array();
	
	public function __construct(){
		// 读取配置文件
		$config = Config::load('config');
		$this->_hook_enabled = $config['hook_enabled'];
		
		// 载入钩子配置
		if(!$this->_hook_enabled){
			return false;
		}
		$this->_hooks = Config::load('hook');
	}
	/**
	 * 调用钩子
	 * @param unknown $point
	 */
	public function call($point){
		// 如果不允许钩子调用，直接返回
		if(!$this->_hook_enabled){
			return false;
		}
		
		// 调用钩子函数
		if(array_key_exists($point, $this->_hooks)){
			$hooks = $this->_hooks[$point];
			foreach ($hooks as $hook){
				$static = false;
				if(array_key_exists('static', $hook)){
					$static = $hook['static'];
				}
				
				if($static){
					call_user_func("{$hook['class']}::{$hook['method']}");
				}else{
					$hook_class = new $hook['class']();
					call_user_func(array($hook_class, $hook['method']));
				}
			}
		}
		
	}
	
}
