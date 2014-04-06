<?php

namespace Blog\hooks;

class BlogHook {

	public function beforeSystem(){
		$sae = new \Arsenals\Libraries\Sae\SaeInit();
		$sae->init();
	}
}
