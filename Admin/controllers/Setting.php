<?php

namespace Admin\controllers;

/**
 *
 * @author guan
 *        
 */
class Setting extends CoreController {
	public function lists(){
		
		return $this->view('setting/list');
	}
	public function async(){
		$settingModel = $this->model('Setting');
		return json_encode($settingModel->loadSettings($_GET));
	}
}
