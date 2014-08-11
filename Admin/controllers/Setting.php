<?php

namespace Admin\controllers;
use Admin\utils\Ajax;
/**
 *
 * @author guan
 *        
 */
class Setting extends CoreController {
	public function lists(){
		$settingModel = $this->model('Setting');
		$this->assign('settings', $settingModel->listByCondition());
		return $this->view('setting/list');
	}

	public function add(){
		return $this->view('setting/add');
	}

	public function addPost(){
		$data = array();
		$data['setting_key'] = $this->post('setting_key', null, 'required|len:1,100');
		$data['setting_value'] = $this->post('setting_value', '', 'len:0, 1000');
		$data['namespace'] = strtolower($this->post('namespace', null, 'required|len:1:100'));
		$data['info'] = $this->post('info', '', 'len:0, 255');
		$data['isserialise'] = $this->post('isserialise', '1', 'required|in:0,1');
		$data['isvalid'] = $this->post('isvalid', '1', 'required|in:0,1');

		$settingModel = $this->model('Setting');
		$settingModel->addSetting($data);

		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}

	public function edit(){
		$id = $this->get('id', null, 'int|required');

		$settingModel = $this->model('Setting');
		$this->assign('se', $settingModel->load(array('id' => $id)));
		return $this->view('setting/edit');
	}

	public function editPost(){
		$data = array();
		$data['setting_key'] = $this->post('setting_key', null, 'required|len:1,100');
		$data['setting_value'] = $this->post('setting_value', '', 'len:0, 1000');
		$data['namespace'] = strtolower($this->post('namespace', null, 'required|len:1:100'));
		$data['info'] = $this->post('info', '', 'len:0, 255');
		$data['isserialise'] = $this->post('isserialise', '1', 'required|in:0,1');
		$data['isvalid'] = $this->post('isvalid', '1', 'required|in:0,1');

		$settingModel = $this->model('Setting');
		$settingModel->updateSetting($data, $this->post('id', null, 'required|int'));

		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}

	public function del(){

		$ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
    	$ids_array = preg_split('/,/', $ids);

		$settingModel = $this->model('Setting');
		$settingModel->delSetting($ids_array);

		return Ajax::ajaxReturn('操作成功！', Ajax::SUCCESS);
	}

}
