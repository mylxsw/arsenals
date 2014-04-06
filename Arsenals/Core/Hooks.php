<?php

namespace Arsenals\Core;

use Arsenals\Core\Abstracts\Arsenals;
use Arsenals\Core\Utils\CommonUtils;

if (!defined('APP_NAME')) exit('Access Denied!');
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
		parent::__construct();
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
				call_user_func(CommonUtils::convStringToCallUserFuncParam($hook));
			}
		}
		
	}
	
}
