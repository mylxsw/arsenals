<?php
namespace Demo\common;

class CacheUtils{
	public static function cacheFile($filename, $callback, $params = array()){
		$filename = CACHE_PATH . md5($filename);
		if (!file_exists($filename)) {
			$html = call_user_func_array($callback, array_slice(func_get_args(), 2));
			file_put_contents($filename, $html);
		}
		return file_get_contents($filename);
	}
}