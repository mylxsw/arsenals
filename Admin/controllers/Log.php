<?php

namespace Admin\controllers;

use Arsenals\Core\Abstracts\Controller;

/**
 *
 * @author guan
 *        
 */
class Log extends Controller {
	public function lists(){
		return $this->view('log/list');
	}
	public function async(){
		$logModel = $this->model('Log');
		$list = $logModel->logDataTable($_GET);
		
		return json_encode($list);
	}
}

