<?php

namespace Demo\controllers;

use Arsenals\Core\Input;
/**
 * 文章控制器
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Articles extends CoreController {
	/**
	 * 文章列表
	 * GET: cat, p
	 * OUTPUT: p, current_nav, breadcrumbs, articles
	 */
	public function lists(Input $input, $category){
		$p = $this->get('p', 1);
		
		$articleModel = $this->model('Article');
		$this->assign('articles', $articleModel->getAllArticlesInCate($category, $p));
		
		$this->assign('breadcrumbs', array('首页'=>'', 'C.D.Cafe'=> 'articles/list/' . $category ));
		$this->assign('current_nav', $category);
		$this->assign('cat', $category);
		$this->assign('p', $p);
		return $this->view('articles/lists');
	}
	/**
	 * 显示文章内容
	 * GET: id
	 */
	public function show(){
		$id = $this->get('id');
		
		$articleModel = $this->model('Article');
		$article = $articleModel->getArticleById($id);
		$this->assign('article', $article);
		
		$this->assign('id', $id);
		$this->assign('breadcrumbs', array('首页'=>'', 'C.D.Cafe'=> 'articles/lists/' . $article['cate'][0]['id'], $article['title'] => $article['id'] ));
		
		return $this->view('articles/show');
	}
}
