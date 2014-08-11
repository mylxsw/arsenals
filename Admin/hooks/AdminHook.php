<?php

namespace Admin\hooks;

class AdminHook {

	public function beforeSystem(){
		$sae = new \Arsenals\Libraries\Sae\SaeInit();
		$sae->init();
	}
}
