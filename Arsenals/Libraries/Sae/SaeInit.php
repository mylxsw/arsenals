<?php
namespace Arsenals\Libraries\Sae;
/**
 * 兼容SAE
 */ 
class SaeInit{
	public function __construct(){
		// SAE环境检测
		!defined('IS_SAE') && define('IS_SAE', isset($_SERVER['HTTP_APPCOOKIE']));
		if (IS_SAE) {
			require './Sae_Func.php';
		}
	}

	public function init(){
		
	}
}