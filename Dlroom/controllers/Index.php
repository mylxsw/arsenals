<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 14-5-12
 * Time: 下午11:16
 */

namespace Dlroom\controllers;


use Admin\controllers\CoreController;

class Index extends CoreController {
    public function index(){
        return $this->view('home');
    }
} 