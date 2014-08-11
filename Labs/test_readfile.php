<?php


// $file = file("test.ts");
// foreach($file as &$line){
// 	$doc_pos = strpos($line, '#');
// 	$content = trim(substr($line, 0, $doc_pos === false ? strlen($line) : $doc_pos));
// 	if($content != ''){
// 		echo $content . "\n";
// 	}
// }

class A{
	private $o = "what";
	public function __construct(){

	}
	public function hello($name){
		$this->trans(function($name){
			echo $name . "-" . $this->o;
			throw new \Exception("sorry!");
		}, $name);
	}

	public function trans($callback, $args){
		try{
			$args = func_get_args();
			array_shift($args);
			call_user_func_array($callback, $args);
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}

$className = 'A';
$a = new $className(array());
$a->hello("jack");