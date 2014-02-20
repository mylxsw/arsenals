<?php
namespace Admin\controllers;

use Admin\utils\Ajax;
/**
 *
 * @author guan
 *        
 */
class Cache extends CoreController {
	/**
	 * 清理全局缓存
	 */ 
	public function clear(){
		$DIR_S = DIRECTORY_SEPARATOR;
		$cache_path = CACHE_PATH . "articles{$DIR_S}show{$DIR_S}";

		$handler = opendir($cache_path);
		while(($filename = readdir($handler)) !== false){
			if($filename != '.' && $filename != '..'){
				unlink($cache_path . $filename);
			}
		}
		closedir($handler);

		return Ajax::ajaxReturn('缓存已经清理完毕!', Ajax::SUCCESS);
	}
	/**
	 * 清理单篇文章缓存
	 */ 
	public function clear_article_cache(){
		$DIR_S = DIRECTORY_SEPARATOR;
		$cache_path = CACHE_PATH . "articles{$DIR_S}show{$DIR_S}";

		$ids = $this->get('ids', null);

		if (!is_null($ids)) {
			$ids_array = preg_split('/,/', str_replace(' ', '', $ids));

			foreach ($ids_array as $key => $value) {
				$filename = intval($value) . '.html';

				if (file_exists($cache_path . $filename)) {
					unlink($cache_path . $filename);
				}
			}
		}

		return Ajax::ajaxReturn('缓存已经清理完毕!', Ajax::SUCCESS);
	}
}
