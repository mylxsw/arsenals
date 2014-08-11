<?php

namespace Admin\controllers;

use Admin\utils\Ajax;
use Arsenals\Core\Session;
use Common\models\Log;
/**
 * 账户管理
 * @author guan
 *        
 */
class Account extends CoreController {
	/**
	 * 用户登陆页面
	 */
	public function login(){
		return $this->view('account/login');
	}
    
    public function verifyCode(){
    	$captcha = new \Arsenals\Libraries\Images\Captcha();
       
        $code = $captcha->generateCode();
        Session::add('captcha', strtolower($code));
        
        $captcha->createImage($code);
    }
    
	/**
	 * 用户登陆提交
	 * @return \Arsenals\Core\Views\Ajax
	 */
	public function loginPost(){
		$username = $this->post('username', null, 'required|len:3,30');
		$password = $this->post('password', null, 'required|len:5,30');
        $captcha = $this->post('verify_code', null, 'required|len:4,4');
		
        // 检查验证码是否正确
        $sess_captcha = Session::get('captcha');
        Session::remove('captcha');
        
        if(is_null($sess_captcha) || $sess_captcha == '' || $sess_captcha != strtolower($captcha)){
        	return Ajax::ajaxReturn('验证码错误！', Ajax::FAILED);
        }
        
		// 检查用户名密码是否合法
		$userModel = $this->model('User');
		if(($user = $userModel->getUser($username, $password)) != null){
			Session::add('user', array(
				'username' => $user['username'],
				'role' => $user['role']
			));
			$logModel = $this->model('Log');
			$logModel->writeLog("用户{$user['username']}登陆了系统！", Log::EVENT, $user['username']);
		}else{
			return Ajax::ajaxReturn('登陆失败，账号或密码有误！', Ajax::FAILED);
		}
		
		return Ajax::ajaxReturn('登陆成功！', Ajax::SUCCESS);
	}
	/**
	 * 用户退出
	 * @return \Arsenals\Core\Views\Ajax
	 */
	public function logout(){
		$user = Session::get('user');
		$logModel = $this->model('Log');
		$logModel->writeLog("用户{$user['username']}退出了系统！", Log::EVENT, $user['username']);
		
		Session::clear();
		return Ajax::ajaxReturn('安全退出系统！', Ajax::SUCCESS);
	}
}
