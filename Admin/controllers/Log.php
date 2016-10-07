<?php

namespace Admin\controllers;

/**
 * @author guan
 */
class Log extends CoreController
{
    public function lists()
    {
        return $this->view('log/list');
    }

    public function async()
    {
        $logModel = $this->model('Log');
        $list = $logModel->logDataTable($_GET);

        return json_encode($list);
    }
}
