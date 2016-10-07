<?php

namespace Blog\controllers;

class Open extends CoreController
{
    public function kuaijianli()
    {
        // 'status' => 'check|read',
        // 'manager_name' => '李四',
        // 'manager_weibo' => '李四的微博昵称',
        // 'manager_job_title' => '某网CTO',
        // 'message' => '您的简历已被某网CTO阅读',
        // 'request_time' => '2014-04-13 10:20:50'

        $manager_name = $this->post('manager_name', '', 'required|len:1:20');
        $manager_weibo = $this->post('manager_weibo', '', 'required|len:1:20');
        $manager_job_title = $this->post('manager_job_title', '', 'required|len:1:50');
        $message = $this->post('message', '', 'required|len: 1, 1000');

        $data = [];
        $data['title'] = '来自快简历的消息:'.$manager_job_title;
        $data['content'] = "管理者:{$manager_name}<br /> 微博: {$manager_weibo} <br /> {$message}";
        $data['sources'] = '快简历';
        $data['type'] = 'webhook';
        $data['receive_time'] = time();
        $data['is_read'] = 0;


        $messageModel = $this->model('Message');
        $messageModel->save($data);

        return 'SUCCESS';
    }
}
