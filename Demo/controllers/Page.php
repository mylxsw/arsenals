<?php

namespace Demo\controllers;

use Arsenals\Core\Input;

class Page extends CoreController {
	
	public function show(Input $input, $id = null){
		if(is_null($id)){
			$id = $input->get('id', 0);
		}
		Input::validate($id, 'id');
		
		$pageModel = $this->model('Page');
		$page_res = $pageModel->load(array('id'=> $id));
		
		if (is_null($page_res)) {
			throw new  \Arsenals\Core\Exceptions\NoRecoredException('您访问的页面不存在!');
		}
		
		if (!is_null($page_res['attr']) && $page_res['attr'] != '') {
			$page_res['attr'] = unserialize($page_res['attr']);
		}
		
		return $this->view('page/show', array('page'=> $page_res));
	}

}
