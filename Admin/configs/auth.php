<?php
return array(
	
	'rules'	=>	array(
		// 普通用户组规则
		'normal' => array(
				'enabled' => TRUE,
				'remark' => '普通用户组',
				'order'	=> 1,
				'inherit' => FALSE,
				'access' => array(
						'home.dashboard'
				),
				'deny' => array()
		),

		// 教师用户组规则
		'teacher' => array(
				'enabled' => TRUE,
				'remark' => '教师用户组',
				'order'	=> 1,
				'inherit' => 'normal',
				'access' => array(
							
				),
				'deny' => array()
		),

		// 学生用户组规则
		'student' => array(
				'enabled' => TRUE,
				'remark' => '学生用户组',
				'order'	=> 1,
				'inherit' => 'normal',
				'access' => array(
							
				),
				'deny' => array()
		),

		// 超级管理员规则
		'admin' => array(
				'enabled' => TRUE,
				'remark' => '管理员',
				'order' => 1,
				'inherit' => FALSE,
				'access' => array('^[\w\.]*'),
				'deny' => array()
		),

		// 匿名用户规则（游客）
		'anonymous' => array(
				'access' => array(
						'',
				)
		)
	)
);