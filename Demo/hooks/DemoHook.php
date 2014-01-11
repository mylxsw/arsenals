<?php

namespace Demo\hooks;

class DemoHook {

	public function beforeSystem1(){
		echo "before1";
	}
	
	public static function beforeSystem2(){
		echo "before2";
	}

}
