<?php
namespace Demo\controllers;

use Arsenals\Core\Abstracts\Controller;
/**
 *
 * @author guan
 *
 */
class Blog extends Controller{
	public function index(){
		$datas = array();
		$datas['current_nav'] = 'home';
		
		$blogModel = $this->model('Blog');
		return $this->view('home', datas);
	}
}