<?php
namespace Admin\controllers;

use Admin\utils\Ajax;
/**
 * 文档相关（模型等）
 * 
 * @author 管宜尧<mylxsw@126.com>
 * 
 */ 
class Document extends CoreController {
	/**
	 * 文档模型列表
	 */ 
	public function doc_model(){
		$docModel = $this->model('Document');
		$this->assign('docs', $docModel->lists());
		
		return $this->view('document/doc_model');
	}
	/**
	 * 添加文档模型显示
	 */ 
	public function doc_model_add(){
		return $this->view('document/doc_model_add');
	}
	/**
	 * 添加文档模型保存
	 */ 
	public function doc_model_add_post(){
		$data = array();
		$data['model_name'] = $this->post('model_name', '', 'required|len:1,20');
		$data['intro'] = $this->post('intro', '', 'len:0,100');
		$data['tpl_show'] = $this->post('tpl_show', '', 'len: 0,2000');
		$data['tpl_edit'] = $this->post('tpl_edit', '', 'len: 0,2000');
		$data['isvalid'] = $this->post('isvalid', '1', 'required|range:0,1');
		$data['setting'] = $this->post('setting', '', 'len:0, 100');

		$docModel = $this->model('Document');
		$docModel->addModel($data);

		return Ajax::success('添加成功');
	}
	/**
	 * 文档模型删除
	 */ 
	public function doc_model_del(){
		$ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
        $ids_array = preg_split('/,/', $ids);

        $docModel = $this->model('Document');
        $docModel->delModel($ids_array);

        return Ajax::success('操作成功！');
	}
	/**
	 * 更新模型显示
	 */ 
	public function doc_model_update(){
		$this->assign('doc', $this->model('Document')->load(array('id'=>$this->get('id', '', 'required|int'))));
		return $this->view('document/doc_model_update');
	}
	/**
	 * 更新模型提交
	 */ 
	public function doc_model_update_post(){
		$data = array();
		$data['model_name'] = $this->post('model_name', '', 'required|len:1,20');
		$data['intro'] = $this->post('intro', '', 'len:0,100');
		$data['tpl_show'] = $this->post('tpl_show', '', 'len: 0,2000');
		$data['tpl_edit'] = $this->post('tpl_edit', '', 'len: 0,2000');
		$data['isvalid'] = $this->post('isvalid', '1', 'required|range:0,1');
		$data['setting'] = $this->post('setting', '', 'len:0, 100');

		$docModel = $this->model('Document');
		$docModel->updateModel($data, $this->post('id', '', 'required|int'));

		return Ajax::success('保存成功');
	}

}