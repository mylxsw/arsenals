<?php
namespace Admin\controllers;

use Admin\utils\Ajax;
class Page extends CoreController{

	public function add(){
		return $this->view('page/add');
	}

	public function addPost(){
		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}

	public function page_list(){
		$pageModel = $this->model('Page');
		$this->assign('pages', $pageModel->lists());

		return $this->view('page/list');
	}

	public function edit(){

	}

	public function editPost(){

	}

	public function del(){
		
	}
}