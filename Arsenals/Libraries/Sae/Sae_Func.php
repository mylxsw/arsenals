<?php
namespace Arsenals\Core;

function SaeKv(){
	static $kv = null;
	if (is_null($kv)) {
		$kv = new \SaeKv();
        
		if (!$kv->init()) {
			throw new \Exception("Error Processing Request");
		}
	}
	return $kv;
}
/**
 * 写文件
 * @param unknown $filename
 * @param unknown $data
 * @param string $flag
 * @param string $context
 * @return number
 */
function file_put_contents($filename, $data, $flag = null, $context = null){
	$file = md5($filename);
    if(SaeKv()->get($file)){
    	SaeKv()->set($file, $data);
    }else{
    	SaeKv()->add($file, $data);
    }
}

/**
 * 写文件，存储到storage
 * @param $filename
 * @param $data
 * @param null $flag
 * @param null $context
 * @return mixed
 */
function write_file($filename, $data, $flag = null, $context = null){
    $store = new \SaeStorage();
    return $store->write('arsenals', $filename, $data);
}
/**
 * 读取文件
 */ 
function file_get_contents($filename, $use_include_path = false, $context = null, $offset = -1, $maxlen = null){
	if(\file_exists($filename)){
		return \file_get_contents($filename);
	}
    
	return SaeKv()->get(md5($filename));
}
/**
 * 检查文件是否存在
 */ 
function file_exists($filename){
	if (\file_exists($filename)) {
		return true;
	}
	$kv = SaeKV();

	return $kv->get(md5($filename));
}
/**
 * 打开目录
 */ 
function opendir($path, $resource = null){
	if(is_null($resource)){
		return \opendir($path);
	}
	return \opendir($path, $resource);
}
/**
 * 读取目录
 */ 
function readdir($handle = null){
	if (is_null($handle)) {
		return \readdir();
	}
	return \readdir($handle);
}
/**
 * 删除文件
 */ 
function unlink($filename, $context = null){
	return SaeKv()->delete(md5($filename));
}
/**
 * 关闭目录
 */ 
function closedir($handle = null){
	if (is_null($handle)) {
		\closedir();
		return ;
	}
	\closedir($handle);
}
/**
 * 是否是文件
 */ 
function is_file($filename){
	return \is_file($filename);
}
/**
 * Moves an uploaded file to a new location
 */ 
function move_uploaded_file($filename, $destination){
    $store = new \SaeStorage();
    return $store->upload('arsenals', $destination, $filename);
}

/**
 * 包含文件
 * 
 * $datas为传递给页面的数据
 */
function include_file($filename, Array $datas = array()){
	$content = file_get_contents($filename);
	@extract($datas);
	eval("?>{$content}");
}

/**
 * 创建目录
 * @param $path
 */
function create_dir($path){
    // 留空即可，SaeStorage会在上传时自动创建目录
}