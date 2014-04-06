<?php

namespace Common\models;

use Arsenals\Core\Abstracts\Model;
/**
 *
 * @author guan
 *        
 */
class User extends Model {
	/**
	 * 查询出指定用户信息
	 * 
	 * @param string $username
	 * @param string $password
	 * @return array|null
	 */
	public function getUser($username, $password){
		return $this->load(array('username'=>$username, 'password'=> sha1($password), 'isvalid'=>1));
	}
	/**
	 * 更新用户密码
	 * 
	 * @param  string $username
	 * @param  string $password
	 * @return  void
	 */ 
	public function updateUserPassword($username, $password){
		$this->update(array('password'=> sha1($password)), array('username'=>$username));
	}
	/**
	 * 删除用户
	 * 
	 * @param  array $ids 待删除的ID数组
	 * @param  string $current_user 当前登录用户
	 * 
	 */ 
	public function delUsers($ids, $current_user){
		$user = $this->load(array('username'=> $current_user));
		if(is_null($user)){
			throw new \Arsenals\Core\Exceptions\NoRecoredException('当前用户不存在！');
		}

		if (in_array($user['id'], $ids)) {
			throw new \Arsenals\Core\Exceptions\AccessDeniedException('不允许删除当前用户！');
		}

		foreach ($ids as $id) {
			$this->delete(array('id'=>$id));
		}
	}
	/**
	 * 添加新用户
	 * 
	 * @param array $data
	 * @return int 新添加用户ID
	 */ 
	public function addUser(array $data){
		$entity = array();
		$entity['username'] = $data['username'];
		$entity['password'] = sha1($data['password']);
		$entity['role'] = $data['role'];
		$entity['isvalid'] = $data['isvalid'];

		// 检查确保用户唯一
		$user = $this->load(array('username'=>$entity['username']));
		if(!is_null($user)){
			throw new \Arsenals\Core\Exceptions\QueryException("用户名 {$entity['username']} 已经存在！");
		}
		return $this->save($entity);
	}
	/**
	 * 更新用户信息
	 * 
	 * @param array $data
	 * @param int $id
	 */ 
	public function updateUser(array $data, $id){
		$entity = array();
		$data['password'] != '' && $entity['password'] = sha1($data['password']);
		$entity['role'] = $data['role'];
		$entity['isvalid'] = $data['isvalid'];

		// 检查用户是否存在
		$user = $this->load(array('id'=>$id));
		if(is_null($user)){
			throw new \Arsenals\Core\Exceptions\QueryException("用户不存在！");
		}

		return $this->update($entity, array('id'=>$id));
	}
}
