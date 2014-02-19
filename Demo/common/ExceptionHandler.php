<?php
namespace Demo\common;
class ExceptionHandler{
	public function exception(\Exception $exception){
		echo '操作有误！';
		exit();
	}

	public function error($errno, $errstr, $errfile, $errline){
		echo "操作有误！";
		exit();
	}
}