<?php
namespace Blog\common;

class CacheUtils{
	public static function cacheFile($filename, $callback, $params = array()){
        $filename = defined('IS_SAE') && IS_SAE ? md5(CACHE_PATH . $filename) : CACHE_PATH . md5($filename);
      
        //if (!\Arsenals\Core\file_exists($filename)) {
			$html = call_user_func_array($callback, array_slice(func_get_args(), 2));  
			\Arsenals\Core\file_put_contents($filename, $html);
        //}
        return $html;
		return \Arsenals\Core\file_get_contents($filename);
	}
}