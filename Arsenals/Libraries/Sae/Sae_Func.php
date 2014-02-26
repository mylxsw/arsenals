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
	if (!IS_SAE) {
		return \file_put_contents($filename, $data, $flag, $context);
	}
	SaeKv()->add($filename, $data);
}
/**
 * 读取文件
 */ 
function file_get_contents($filename, $use_include_path = false, $context = null, $offset = -1, $maxlen = null){
	if(\file_exists($filename)){
		return \file_get_contenst($filename, $use_include_path, $context, $offset, $maxlen);
	}
	
	return SaeKv()->get($filename);
}
/**
 * 检查文件是否存在
 */ 
function file_exists($filename){
	if (\file_exists($filename)) {
		return true;
	}
	$kv = SaeKV();
    
	return $kv->get($filename);
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
	if(is_null($context)){
		return \unlink($filename);
	}
	return \unlink($filename, $context);
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
    if(!IS_SAE){
		return \move_uploaded_file($filename, $destination);
    }
    $store = new \SaeStorage();
    return $store->upload('arsenals', $destination, $filename);
}
