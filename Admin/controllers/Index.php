<?php

namespace Admin\controllers;

/**
 *
 * @author guan
 *        
 */
class Index extends CoreController {
	public function main(){
		return $this->view('main');
	}
	
	public function home(){
		return $this->view('home');
	}
}
