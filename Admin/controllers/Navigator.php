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
	/**
	 * 所有导航列表
	 */ 
	public function lists(){
		$navModel = $this->model('Navigator');
		$this->assign('navs', $navModel->listByCondition(array('pid'=>0)));
		$this->assign('navModel', $navModel);
		return $this->view('navigator/list');
	}
	/**
	 * 添加导航页面
	 */ 
	public function add(){
		$navModel = $this->model('Navigator');
		$this->assign('navs', $navModel->listByCondition(array('pid'=>0)));
		return $this->view('navigator/add');
	}
	/**
	 * 添加导航处理页面
	 */ 
	public function addPost(){
		$data = array();
		$data['name'] = $this->post("name", null, 'required|len:1,100');
		$data['url'] = $this->post("url", '#', 'required|len:1,200');
		$data['isvalid'] = $this->post("isvalid", '1', 'required|int|in:0,1');
		$data['sort'] = $this->post("sort", 50, 'required|int|range:0,999');
		$data['pos'] = $this->post("pos", '', 'required|string|len:1, 45');
		$data['pid'] = $this->post('pid', '0', 'required|int');

		$navModel = $this->model('Navigator');
		$navModel->addNav($data);

		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}
	/**
	 * 编辑导航页面
	 */ 
	public function edit(){
		$id = $this->get('id', null, 'required|int');

		$navModel = $this->model('Navigator');
		$nav = $navModel->load($id);
		if(is_null($nav)){
			throw new \Arsenals\Core\Exceptions\NoRecoredException('没有找到指定导航!');
		}

		$this->assign('nav', $nav);
		$this->assign('navs', $navModel->listByCondition(array('pid'=>0, 'id%NEQ'=>$id)));

		return $this->view('navigator/edit');
	}
	/**
	 * 编辑导航处理页面
	 */
	public function editPost(){
		$data = array();
		$data['name'] = $this->post("name", null, 'required|len:1,100');
		$data['url'] = $this->post("url", '#', 'required|len:1,200');
		$data['isvalid'] = $this->post("isvalid", '1', 'required|int|in:0,1');
		$data['sort'] = $this->post("sort", 50, 'required|int|range:0,999');
		$data['pos'] = $this->post("pos", '', 'required|string|len:1, 45');
		$data['pid'] = $this->post('pid', '0', 'required|int');

		$navModel = $this->model('Navigator');
		$navModel->updateNav($data, $this->post('id', null, 'required|int'));

		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}
	/**
	 * 删除导航页面
	 */
	public function del(){

		$ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
    	$ids_array = preg_split('/,/', $ids);

		$navModel = $this->model('Navigator');
		$navModel->delNavs($ids_array);
		
		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}
}

