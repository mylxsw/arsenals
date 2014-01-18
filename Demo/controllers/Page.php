<?php

namespace Demo\controllers;

use Arsenals\Core\Abstracts\Controller;

class Page extends Controller {
	
	public function show(){
		$id = $this->get('id', 0, 'int');
		
		
// 		$id = intval($this->get('id'));
// 		if ($id == 0){
// 			throw new \Arsenals\Core\Exceptions\TypeErrorException('页面ID必须！');
// 		}
		
// 		$pageModel = $this->model('Page');
// 		$page_res = $pageModel->load(array('id'=> $id));
		
// 		if (is_null($page_res)) {
// 			throw new  \Arsenals\Core\Exceptions\NoRecoredException('您访问的页面不存在!');
// 		}
		
// 		if (!is_null($page_res['attr']) && $page_res['attr'] != '') {
// 			$page_res['attr'] = unserialize($page_res['attr']);
// 		}
		
		return $this->view('page/show', array('page'=> $page_res));
	}

}
