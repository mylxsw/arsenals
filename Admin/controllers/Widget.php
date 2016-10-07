<?php

namespace Admin\controllers;

/**
 * @author guan
 */
class Widget extends CoreController
{
    public function slidebar()
    {
        $nav = [
            'main' => [
                    'index'    => ['<i class="icon-home"></i>首页', 'index/home'],
                    'article'  => ['<i class="icon-pencil"></i>写文章', 'article/write'],
                    'archive'  => ['<i class="icon-folder"></i>归档', 'article/lists'],
                    'lists'    => ['<i class="icon-new"></i>页面', 'page/page_list'],
                    'category' => ['<i class="icon-bookmark"></i>文章分类', 'article/category'],
                    // 'photo' => array('传相片', 'photos/addPhoto'),
                    // 'weibo' => array('写微博', 'twitter/weibo')
            ],
            'documents' => [
                    'article'          => ['<i class="icon-pencil"></i>写文章', 'article/write'],
                    'article-markdown' => ['<i class="icon-newspaper"></i>写文章Markdown', 'article/writeMarkdown'],
                    'archive'          => ['<i class="icon-folder"></i>归档', 'article/lists'],
                    'photos'           => ['<i class="icon-pictures"></i>图库', 'photos/lists'],
                    'photos-manager'   => ['<i class="icon-picassa"></i>图片管理', 'photos/manager'],
                    '#others'          => [
                            '其它',
                            ['<i class="icon-bookmark"></i>分类', 'article/category'],
                            ['<i class="icon-tag"></i>标签', 'article/tags'],
                    ],
            ],
            // 'remarks' => array(
            // 		'remark' => array('评论', 'remark/list')
            // ),
            // 'photos' => array(
            // 		'photos' => array('相册', 'photos/photo_list'),
            // 		'photo' => array('传相片', 'photos/addPhoto')
            // ),
            'pages' => [
                    'add'   => ['<i class="icon-file"></i>新增页面', 'page/add'],
                    'lists' => ['<i class="icon-new"></i>所有页面', 'page/page_list'],
                ],
            'personal' => [
                    'user_info'    => ['<i class="icon-user"></i>个人信息', 'user/userInfo'],
                'message'          => ['<i class="icon-comments-4"></i>消息', 'message/lists'],
                ],
            'system' => [
                    'users'     => ['<i class="icon-user"></i>用户', 'user/userList'],
                    'settings'  => ['<i class="icon-cog"></i>配置', 'setting/lists'],
                    'navigator' => ['<i class="icon-arrow-up-right"></i>导航', 'navigator/lists'],
                    'model'     => ['<i class="icon-cube"></i>文档模型', 'document/doc_model'],
                    'logs'      => ['<i class="icon-yelp"></i>日志', 'log/lists'],
            ],
            'help' => [
                    'howto'    => ['使用帮助', 'help/howto'],
                    'doc'      => ['开发文档', 'help/doc'],
                    'about'    => ['关于', 'help/about'],
                ],
        ];

        return $this->ajax($nav);
    }
}
