<?php

namespace Admin\controllers;

use Arsenals\Core\Abstracts\Controller;
use Arsenals\Core\Session;
use Admin\utils\Ajax;
/**
 *
 * @author guan
 *        
 */
class Article extends Controller {
	public function write(){
		$this->assign('categorys', $this->model('\\Demo\\models\\Category')->lists());
		$this->assign('tags', $this->model('\\Demo\\models\\Tag')->lists());
		
		return $this->view('article/write');
	}
	public function writePost(){
		$user = Session::get('user');
		
		$data = array();
		$data['title'] = $this->post('blog_title', null, 'required|len:1,100');
		$data['content'] = $this->post('blog_textarea', null, 'len:0,4000');
		$data['intro'] = $this->post('intro', null, 'len:0, 200');
		$data['tag'] = $this->post('tag', null);
		$data['category_id'] = $this->post('category_id', 'required|int');
		$data['author'] = $user['username'];
		
		$this->model('\\Demo\\models\\Article')->addArticle($data);
		
		return Ajax::ajaxReturn('保存成功！', Ajax::SUCCESS);
	}
}
