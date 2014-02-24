<?php

namespace Demo\hooks;

class DemoHook {

	public function beforeSystem(){
		$sae = new \Arsenals\Libraries\Sae\SaeInit();
		$sae->init();
	}
}
