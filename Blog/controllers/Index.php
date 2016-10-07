<?php

namespace Blog\controllers;

/**
 * @author guan
 */
class Index extends CoreController
{
    public function index()
    {
        $p = $this->get('p', 1);
        $keyword = $this->get('keyword', '', 'len:1:40');

        $articleModel = $this->model('Article');
        $this->assign('articles', $articleModel->getAllArticles($p, null, $keyword));

        //$category = $this->model('Category')->load(array('id'=>$category_id));

        $this->assign('p', $p);

        $this->assign('current_nav', 'home');
        $this->assign('_page_title', '爱代码，爱生活');

        return $this->view('home');
    }

    // public function basic(){
    // 	$router = \Arsenals\Core\Registry::load('\Arsenals\Core\Router');

    // 	$url = $router->getPathInfo();
    // 	if($url != ''){
    // 		$url = substr($url, 0, strpos($url, '.html')) . '.do';
    // 	}else{
    // 		$url = "home.do";
    // 	}

    // 	$this->assign('url', $url);
    // 	return $this->view('global');
    // }
}
