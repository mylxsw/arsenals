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
					'article' => array('<i class="icon-pencil"></i>写文章', 'article/write'),
					'archive' =>array('<i class="icon-folder"></i>归档', 'article/lists'),
					'lists' => array('<i class="icon-new"></i>页面', 'page/page_list'),
					'category' => array('<i class="icon-bookmark"></i>文章分类', 'article/category')
					// 'photo' => array('传相片', 'photos/addPhoto'),
					// 'weibo' => array('写微博', 'twitter/weibo')
			),
			'articles' => array(
					'article' => array('<i class="icon-pencil"></i>写文章', 'article/write'),
					'archive' =>array('<i class="icon-folder"></i>归档', 'article/lists'),
					'draft' => array('<i class="icon-remove"></i>草稿', 'article/temp'),
					'#others' => array(
							'其它',
							array('<i class="icon-bookmark"></i>分类','article/category'),
							array('<i class="icon-tag"></i>标签', 'article/tags')
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
					'add' => array('<i class="icon-file"></i>新增页面', 'page/add'),
					'lists' => array('<i class="icon-new"></i>所有页面', 'page/page_list')
				),
			'system' => array(
					'users' => array('<i class="icon-user"></i>用户', 'user/user_info'),
					'settings' => array('<i class="icon-cog"></i>配置', 'setting/lists'),
					'navigator' => array('<i class="icon-arrow-up-right"></i>导航', 'navigator/lists'),
					'logs' => array('<i class="icon-yelp"></i>日志', 'log/lists')
			),
			'help' => array(
					'howto'	=> array('使用帮助', 'help/howto'),
					'about' => array('关于', 'help/about')
				)
		);
		return $this->view('widget/slidebar', array('nav' => $nav));
	}
}
