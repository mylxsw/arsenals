<?php

namespace Arsenals\Libraries\Authorization;

use \Arsenals\Core\Config;
use \Arsenals\Libraries\Authorization\exceptions\AuthException;
use \Arsenals\Core\Utils\CommonUtils;
/**
 * 认证授权功能
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Authencation {
	/**
	 * 是否允许授权检查
	 */
	private $_enabled = TRUE;
	/**
	 * 认证授权规则
	 * anonymous是默认规则，针对匿名角色
	 */
	private $_rules = array(
		'anonymous'=> array(
				'enabled' => TRUE,
				'remark' => '匿名角色',
				'order' => 1,
				'inherit' => FALSE,
				'access' => array(),
				'deny' =>array()
		)
	);
	/**
	 * 认证授权初始化
	 */
	public function __construct($auth = array()){
		$auth_config = Config::load('auth');
		if (is_array($auth_config)){
			$auth = array_merge($auth_config, $auth);
		}
		$this->_enabled = $auth['enabled'];
		// 如果配置文件中手动指定了anonymous的配置，则使用配置文件的配置覆盖
		// 默认配置
		if(array_key_exists('anonymous', $auth['rules'])){
			$this->_rules['anonymous'] = array_merge($this->_rules['anonymous']
					, $auth['rules']['anonymous']);
			unset($auth['rules']['anonymous']);
		}
		$this->_rules = array_merge($this->_rules, $auth['rules']);
	}
	
	/**
	 * 进行权限校验
	 * @param unknown $path_info
	 * @param unknown $user
	 * @throws AuthException
	 * @return boolean
	 */
	public function check($path_info, $user){
		if(!$this->_enabled)
			return TRUE;
		// 检查$user是否合法
		if($user == NULL || !is_array($user)){
			throw new AuthException('用户不能为空!');
		}
		// 检查用户角色是否合法
		if(!array_key_exists($user['role'], $this->_rules)){
			throw new AuthException('不是合法的用户!');
		}
		// 当前角色权限
		$user_role = $this->_rules[$user['role']];
		// 判断角色是否可用
		if(!$user_role['enabled']){
			throw new AuthException('角色已禁用');
		}
		// 获取角色的权限列表，判断是否具备访问权限
		$access_list = $this->_mergeInheritPermission($user['role']);
		
		if(CommonUtils::array_exists_regexp($this->_generatePermissionSignature($path_info),
				$access_list)){
			return TRUE;
		}
		throw new AuthException('您没有访问权限!');
	}
	/**
	 * 合并角色权限列表
	 * 完成角色继承权限的分配
	 */
	private function _mergeInheritPermission($rolename, $type = 'access'){
		// 如果没有继承角色，则直接返回角色权限列表
		$inherit = $this->_rules[$rolename]['inherit'];
		if($inherit === FALSE OR !is_string($inherit)){
			return $this->_rules[$rolename][$type];
		}
		// 如果存在继承角色，则递归进行合并
		return array_merge($this->_mergeInheritPermission($inherit, $type)
				, $this->_rules[$rolename][$type]);
	}
	
	/**
	 * 生成权限签名，用于与权限列表进行比较，以
	 * 确定用户是否具有访问权限
	 */
	private function _generatePermissionSignature($path_info){
		return strtolower($path_info);
	}
}
