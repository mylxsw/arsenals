<?php

namespace Admin\controllers;

use Arsenals\Core\Abstracts\Controller;
/**
 *
 * @author guan
 *        
 */
class Setting extends Controller {
	public function lists(){
		
		return $this->view('setting/list');
	}
	public function async(){
		$settingModel = $this->model('Setting');
		return json_encode($settingModel->loadSettings($_GET));
	}
}
