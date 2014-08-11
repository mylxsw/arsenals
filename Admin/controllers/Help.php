<?php

namespace Admin\controllers;

/**
 *
 * @author guan
 *        
 */
class Help extends CoreController {
	public function doc(){
		$markdown = \Arsenals\Core\Registry::load('\\Common\\MarkdownParser');
		return $this->_prefix('开发文档', $markdown->parse(file_get_contents(BASE_PATH . 'README.MD')));
	}

	public function about(){
		return $this->_prefix('关于', '基于Arsenals框架开发， 作者： 管宜尧');
	}

	public function howto(){
		return $this->_prefix('使用帮助', '正在完善中...');
	}

	private function _prefix($title, $content = ''){
		return "<blockquote class=\"block-title\">{$title}</blockquote><div class='page-section'>{$content}</div>";
	}
}
