<?php

namespace Admin\controllers;

use Arsenals\Core\Abstracts\Controller;
/**
 *
 * @author guan
 *        
 */
class Widget extends Controller {
	public function header(){
		return $this->view('widget/header');
	}
	
	public function slidebar(){
		$nav = array(
			'main' => array(
					'index' => array('<i class="icon-home"></i>首页', 'index/home'),
					'article' => array('写文章', 'article/write'),
					'photo' => array('传相片', 'photos/addPhoto'),
					'weibo' => array('写微博', 'twitter/weibo')
			),
			'articles' => array(
					'article' => array('写文章', 'article/write'),
					'archive' =>array('归档', 'article/blog_list'),
					'draft' => array('草稿', 'article/blog_tmp'),
					'#others' => array(
							'其它',
							array('分类','article/category'),
							array('标签', 'article/tags')
					)
			),
			'remarks' => array(
					'remark' => array('评论', 'remark/list')
			),
			'photos' => array(
					'photos' => array('相册', 'photos/photo_list'),
					'photo' => array('传相片', 'photos/addPhoto')
			),
			'pages' => array(),
			'system' => array(
					'users' => array('用户', 'user/user_info'),
					'settings' => array('配置', 'setting/lists'),
					'logs' => array('日志', 'log/lists')
			)
		);
		return $this->view('widget/slidebar', array('nav' => $nav));
	}
}
