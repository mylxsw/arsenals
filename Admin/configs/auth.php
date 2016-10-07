<?php

return [

    'rules'    => [
        // 普通用户组规则
        'normal' => [
                'enabled'  => true,
                'remark'   => '普通用户组',
                'order'    => 1,
                'inherit'  => false,
                'access'   => [
                        'home.dashboard',
                ],
                'deny' => [],
        ],

        // 教师用户组规则
        'teacher' => [
                'enabled'  => true,
                'remark'   => '教师用户组',
                'order'    => 1,
                'inherit'  => 'normal',
                'access'   => [

                ],
                'deny' => [],
        ],

        // 学生用户组规则
        'student' => [
                'enabled'  => true,
                'remark'   => '学生用户组',
                'order'    => 1,
                'inherit'  => 'normal',
                'access'   => [

                ],
                'deny' => [],
        ],

        // 超级管理员规则
        'admin' => [
                'enabled' => true,
                'remark'  => '管理员',
                'order'   => 1,
                'inherit' => false,
                'access'  => ['^[\w\.]*'],
                'deny'    => [],
        ],

        // 匿名用户规则（游客）
        'anonymous' => [
                'access' => [
                    '^account/login$',
                    '^account/loginPost$',
                    '^account/verifyCode$',
                ],
        ],
    ],
];
