<?php

namespace Demo\controllers;

use Arsenals\Core\Abstracts\Controller;
/**
 * 文章控制器
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Articles extends Controller {
	public function lists(){
		$category = $this->get('cat');
		
		$blogModel = $this->model('Blog');
		$this->assign('articles', $blogModel->getAllArticles($category));
		
		$this->assign('breadcrumbs', array('首页'=>'', 'C.D.Cafe'=> 'articles/list?id=' . $category ));
		
		return $this->view('articles/lists');
	}
}
