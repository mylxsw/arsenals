<?php
namespace Admin\controllers;

use Admin\utils\Ajax;
use Arsenals\Core\Session;
class Page extends CoreController{

	public function add(){
		return $this->view('page/add');
	}

	public function addPost(){
		$user = Session::get('user');

		$data = array();
		$data['title'] = $this->post('title', null, 'required|len:1,200');
		$data['templates'] = $this->post('templates', '', 'required|len:0, 8000');
		$data['isvalid'] = 1;
		$data['creator'] = $user['username'];
		$data['attr'] = array();

		$pageModel = $this->model('Page');
		$pageModel->addPage($data);

		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}

	public function page_list(){
		$pageModel = $this->model('Page');
		$this->assign('pages', $pageModel->lists());

		return $this->view('page/list');
	}

	public function edit(){
		$id = $this->get('id', null, 'int|required');

		$pageModel = $this->model('Page');
		$this->assign('page', $pageModel->load(array('id' => $id)));
		
		return $this->view('page/edit');
	}

	public function editPost(){
		$user = Session::get('user');

		$data = array();
		$data['title'] = $this->post('title', null, 'required|len:1,200');
		$data['templates'] = $this->post('templates', '', 'required|len:0, 8000');
		$data['updator'] = $user['username'];

		$id = $this->post('id', null , 'required|int');

		$pageModel = $this->model('Page');
		$pageModel->updatePage($data, $id);

		return Ajax::ajaxReturn('编辑成功！', Ajax::SUCCESS);
	}

	public function del(){
		$ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
    	$ids_array = preg_split('/,/', $ids);

    	$categoryModel = $this->model('Page');
    	$categoryModel->delPage($ids_array);

    	return Ajax::ajaxReturn('删除成功!', Ajax::SUCCESS);
	}
}