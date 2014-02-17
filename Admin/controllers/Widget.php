<?php

namespace Admin\controllers;

/**
 *
 * @author guan
 *        
 */
class Widget extends CoreController {
	public function header(){
		return $this->view('widget/header');
	}
	
	public function slidebar(){
		$nav = array(
			'main' => array(
					'index' => array('<i class="icon-home"></i>首页', 'index/home'),
					'article' => array('写文章', 'article/write'),
					'archive' =>array('归档', 'article/lists'),
					'lists' => array('页面', 'page/page_list')
					// 'photo' => array('传相片', 'photos/addPhoto'),
					// 'weibo' => array('写微博', 'twitter/weibo')
			),
			'articles' => array(
					'article' => array('写文章', 'article/write'),
					'archive' =>array('归档', 'article/lists'),
					'draft' => array('草稿', 'article/temp'),
					'#others' => array(
							'其它',
							array('分类','article/category'),
							array('标签', 'article/tags')
					)
			),
			// 'remarks' => array(
			// 		'remark' => array('评论', 'remark/list')
			// ),
			// 'photos' => array(
			// 		'photos' => array('相册', 'photos/photo_list'),
			// 		'photo' => array('传相片', 'photos/addPhoto')
			// ),
			'pages' => array(
					'add' => array('新增页面', 'page/add'),
					'lists' => array('所有页面', 'page/page_list')
				),
			'system' => array(
					'users' => array('用户', 'user/user_info'),
					'settings' => array('配置', 'setting/lists'),
					'navigator' => array('导航', 'navigator/lists'),
					'logs' => array('日志', 'log/lists')
			)
		);
		return $this->view('widget/slidebar', array('nav' => $nav));
	}
}
