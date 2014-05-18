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
        if(defined('IS_SAE') && IS_SAE){
           if(function_exists('\Arsenals\Core\SaeKv')){
               $kv = \Arsenals\Core\SaeKv();
               $ret = $kv->pkrget('', \SaeKv::MAX_PKRGET_SIZE);
               while(true){
                   //var_dump(array_keys($ret));
                   // 删除所有的key
                   $keys = array_keys($ret);
                   foreach($keys as $k=>$v){
                       //echo $v . "\n";
                       $kv->delete($v);
                   }

                   // 判断是否读取完毕，若未完成则继续循环读取
                   end($ret);
                   $start_key = key($ret);
                   //\Arsenals\Core\_D($start_key);
                   $i = count($ret);
                   if($i < \SaeKv::MAX_PKRGET_SIZE ) break;
                   $ret = $kv->pkrget('', \SaeKv::MAX_PKRGET_SIZE, $start_key);
               }
           }
            
        }else{
        	$DIR_S = DIRECTORY_SEPARATOR;
            $cache_path = array(
                BASE_PATH . "articles{$DIR_S}show{$DIR_S}",
                CACHE_PATH
                );
    
            foreach ($cache_path as $v) {
                $this->_clear($v);
            }
        }

		return Ajax::ajaxReturn('缓存已经清理完毕!', Ajax::SUCCESS);
	}
	/**
	 * 清理单篇文章缓存
	 */ 
	public function clear_article_cache(){
		$cache_path = BASE_PATH . "article/";

		$ids = $this->get('ids', null);

		if (!is_null($ids)) {
			$ids_array = preg_split('/,/', str_replace(' ', '', $ids));

			foreach ($ids_array as $key => $value) {
				$filename = intval($value) . '.html';

				if (\Arsenals\Core\file_exists($cache_path . $filename)) {
					\Arsenals\Core\unlink($cache_path . $filename);
				}
			}
		}

		return Ajax::ajaxReturn('缓存已经清理完毕!', Ajax::SUCCESS);
	}

	private function _clear($cache_path){

		$handler = \Arsenals\Core\opendir($cache_path);
		while(($filename = \Arsenals\Core\readdir($handler)) !== false){
			if(\Arsenals\Core\is_file($cache_path . $filename) && $filename != '.' && $filename != '..'){
				\Arsenals\Core\unlink($cache_path . $filename);
			}
		}
		\Arsenals\Core\closedir($handler);
	}
}
