<?php

namespace Common;
require BASE_PATH . 'Common\\libs\\Parsedown\\Parsedown.php';
class MarkdownParser{
	private $instance = null;
	public function __construct(){
		$this->instance = new \Parsedown();
	}

	public function parse($markdown){
		return $this->instance->parse($markdown);
	}
}