<?php

namespace Demo\controllers;

/**
 *
 * @author guan
 *        
 */
class Index extends CoreController{
	public function index(){
		$this->assign('current_nav', 'home');
		return $this->view('home');
	}
}