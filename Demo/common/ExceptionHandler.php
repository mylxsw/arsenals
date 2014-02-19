<?php
namespace Demo\common;
class ExceptionHandler{
	public function exception(\Exception $exception){
		echo "<script>window.location.href='http://cdcafe.cc'</script>";
		exit();
	}

	public function error($errno, $errstr, $errfile, $errline){
		echo "<script>window.location.href='http://cdcafe.cc'</script>";
		exit();
	}
}