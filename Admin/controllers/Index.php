<?php

namespace Admin\controllers;

use Arsenals\Core\Abstracts\Controller;
/**
 *
 * @author guan
 *        
 */
class Index extends Controller {
	public function main(){
		return $this->view('main');
	}
	
	public function home(){
		return "hello, world!";
	}
}
