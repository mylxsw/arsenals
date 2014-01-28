<?php
/**
 *  认证授权配置
 */
// 授权管理规则
// '角色名'=> array(
// 		'enabled' => TRUE, 		是否可用
// 		'remark' => '会员用户组',	用户组注释
// 		'order'	=> 1,			显示顺序
// 		'inherit' => FALSE,		是否继承自其它角色
// 		'access' => array(		允许的权限列表
// 			),
// 		'deny' => array(		不允许的权限列表
// 			)
// 		),
return array(
	'enabled'			=>	TRUE, // 是否开启授权管理
	'rules'				=>	array()
);
