<?php

namespace Admin\controllers;

use Arsenals\Core\Abstracts\Controller;
use Admin\utils\Ajax;
use Arsenals\Core\Session;
/**
 *
 * @author guan
 *        
 */
class Account extends Controller {
	public function login(){
		return $this->view('account/login');
	}
	public function loginPost(){
		$username = $this->post('username', null, 'required|len:5,30');
		$password = $this->post('password', null, 'required|len:5,30');
		
		Session::add('user', array(
			'username' => $username,
			'role' => 'admin'
		));
		return Ajax::ajaxReturn('登陆成功！', Ajax::SUCCESS);
	}
	public function logout(){
		Session::clear();
		return Ajax::ajaxReturn('安全退出系统！', Ajax::SUCCESS);
	}
}
