<?php
namespace Arsenals\Libraries\Sae;
/**
 * 兼容SAE
 */ 
class SaeInit{
	public function __construct(){
		
		// SAE环境检测
		!defined('IS_SAE') && define('IS_SAE', isset($_SERVER['HTTP_APPCOOKIE']));
		
	}

	public function init(){
		if (IS_SAE) {
			require realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR .'Sae_Func.php';
		}
	}
}