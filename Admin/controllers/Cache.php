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
		$cache_path = array(
			BASE_PATH . "articles{$DIR_S}show{$DIR_S}",
			CACHE_PATH
			);

		foreach ($cache_path as $v) {
			$this->_clear($v);
		}

		return Ajax::ajaxReturn('缓存已经清理完毕!', Ajax::SUCCESS);
	}
	/**
	 * 清理单篇文章缓存
	 */ 
	public function clear_article_cache(){
		$DIR_S = DIRECTORY_SEPARATOR;
		$cache_path = BASE_PATH . "articles{$DIR_S}show{$DIR_S}";

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

	private function _clear($cache_path){

		$handler = opendir($cache_path);
		while(($filename = readdir($handler)) !== false){
			if(is_file($cache_path . $filename) && $filename != '.' && $filename != '..'){
				unlink($cache_path . $filename);
			}
		}
		closedir($handler);
	}
}
