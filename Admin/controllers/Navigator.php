<?php

namespace Admin\controllers;

use Demo\controllers\CoreController;
use Admin\utils\Ajax;

/**
 *
 * @author guan
 *        
 */
class Navigator extends CoreController {
	public function lists(){
		$navModel = $this->model('Navigator');
		$this->assign('navs', $navModel->listByCondition(array('pid'=>0)));
		$this->assign('navModel', $navModel);
		return $this->view('navigator/list');
	}
	
	public function add(){
		return $this->view('navigator/add');
	}
	
	public function addPost(){
		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}
	
	public function edit(){
		return $this->view('navigator/edit');
	}
	
	public function editPost(){
		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}
	
	public function del(){
		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}
}

