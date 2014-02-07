<?php

namespace Admin\models;

use Arsenals\Core\Abstracts\Model;
/**
 *
 * @author guan
 *        
 */
class User extends Model {
	/**
	 * 查询出指定用户信息
	 * @param string $username
	 * @param string $password
	 * @return array|null
	 */
	public function getUser($username, $password){
		return $this->load(array('username'=>$username, 'password'=> sha1($password), 'isvalid'=>1));
	}
}
