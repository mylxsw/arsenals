<?php

namespace Demo\controllers;

use Arsenals\Core\Abstracts\Controller;
/**
 *
 * @author guan
 *        
 */
class Index extends Controller{
	public function index(){
		$this->assign('current_nav', 'home');
		return $this->view('home');
	}
}