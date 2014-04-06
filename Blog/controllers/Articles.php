<?php

namespace Blog\controllers;

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
	public function lists(Input $input, $category_id){
		$p = $this->get('p', 1);
		
		$articleModel = $this->model('Article');
		$this->assign('articles', $articleModel->getAllArticlesInCate($category_id, $p));

		$category = $this->model('Category')->load(array('id'=>$category_id));
		
		$this->assign('breadcrumbs', array('首页'=>'', $category['name']=> "category_/{$category['id']}.html" ));
        $this->assign('current_nav', "category_{$category_id}.html");
		$this->assign('cat', $category_id);
		$this->assign('p', $p);
        $this->assign('_page_title', $category['name']);
		return $this->view('articles/lists');
	}
	/**
	 * 显示文章内容
	 * GET: id
	 */
	public function show($id){

		$id = (isset($id) && !is_null($id) && $id != '') ? intval($id) : $this->get('id', null, 'int|required');
		
		$articleModel = $this->model('Article');
		$article = $articleModel->getArticleById($id);
		$this->assign('article', $article);
		
		$this->assign('id', $id);
        $this->assign('breadcrumbs', count($article['cate']) > 0 ? array('首页'=>'', $article['cate'][0]['name']=> "category_{$article['cate'][0]['id']}.html" , $article['title'] => $article['id'] ) : '');
        if(count($article['cate']) > 0){
            $this->assign('current_nav', "category_{$article['cate'][0]['id']}.html");
        }
        
        $this->assign('_page_title', $article['title']);
        
		return $this->view('articles/show');
	}
}
