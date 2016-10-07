<?php

namespace Admin\controllers;

use Admin\utils\Ajax;
use Arsenals\Core\Session;

class User extends CoreController
{
    public function userInfo()
    {
        $user = Session::get('user');

        return $this->view('user/userinfo', ['user' => $user]);
    }

    public function userList()
    {
        $this->assign('users', $this->model('User')->lists());
        $this->assign('current_user', Session::get('user'));

        return $this->view('user/userlist');
    }

    public function addUser()
    {
        return $this->view('user/add_user');
    }

    public function addUserPost()
    {
        $data = [];
        $data['username'] = $this->post('username', '', 'required|len: 2,30');
        $data['password'] = $this->post('password', '', 'required|len: 6,20');
        $data['isvalid'] = $this->post('isvalid', '1', 'required|in:0,1');
        $data['role'] = $this->post('role', 'nologin', 'required|len:1,20');

        $userModel = $this->model('User');
        $userModel->addUser($data);

        return Ajax::ajaxReturn('操作完成！', Ajax::SUCCESS);
    }

    public function updateUser()
    {
        $id = $this->get('id', '', 'required|int');
        $userModel = $this->model('User');

        $this->assign('user', $userModel->load(['id' => $id]));
        $this->assign('current_user', Session::get('user'));

        return $this->view('user/edit_user');
    }

    public function updateUserPost()
    {
        $data = [];
        $data['password'] = $this->post('password', '');
        $data['isvalid'] = $this->post('isvalid', '1', 'required|in:0,1');
        $data['role'] = $this->post('role', 'nologin', 'required|len:1,20');

        $userModel = $this->model('User');
        $userModel->updateUser($data, $this->post('id', '', 'required|int'));

        return Ajax::ajaxReturn('操作完成！', Ajax::SUCCESS);
    }

    public function delUser()
    {
        $ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
        $ids_array = preg_split('/,/', $ids);

        $user = Session::get('user');

        $userModel = $this->model('User');
        $userModel->delUsers($ids_array, $user['username']);

        return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
    }

    /**
     * 修改密码
     */
    public function changePassword()
    {
        $old_password = $this->post('old_password', '', 'required|len:6,20');
        $new_password = $this->post('new_password', '', 'required|len:6,20');
        $new_password_confirm = $this->post('new_password_confirm', '', 'required|len:6,20');

        // 检查密码确认是否一致
        if ($new_password != $new_password_confirm) {
            throw new \Arsenals\Core\Exceptions\FormInvalidException('两次输入的密码不一致！');
        }

        // 检查旧密码是否合法
        $userModel = $this->model('User');
        $user = Session::get('user');

        if (!$userModel->getUser($user['username'], $old_password)) {
            throw new \Arsenals\Core\Exceptions\FormInvalidException('原始密码不正确！');
        }

        // 更新密码
        $userModel->updateUserPassword($user['username'], $new_password);

        return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
    }
}
