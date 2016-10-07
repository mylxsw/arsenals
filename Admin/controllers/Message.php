<?php

namespace Admin\controllers;

/**
 * @author guan
 */
class Message extends CoreController
{
    public function lists()
    {
        return $this->view('message/list');
    }

    public function async()
    {
        $messageModel = $this->model('Message');
        $list = $messageModel->messageDataTable($_GET);

        return json_encode($list);
    }
}
