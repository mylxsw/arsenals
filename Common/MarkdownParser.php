<?php

namespace Common;
require BASE_PATH . 'Common' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'Parsedown' . DIRECTORY_SEPARATOR . 'Parsedown.php';
class MarkdownParser{
	private $instance = null;
	public function __construct(){
		$this->instance = new \Parsedown();
	}

	public function parse($markdown){
		return $this->instance->parse($markdown);
	}
}