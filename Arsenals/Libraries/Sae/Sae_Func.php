<?php
namespace Arsenals\Core;

/**
 * 写文件
 * @param unknown $filename
 * @param unknown $data
 * @param string $flag
 * @param string $context
 * @return number
 */
function file_put_contents($filename, $data, $flag = null, $context = null){
	return \file_put_contents($filename, $data, $flag, $context);
}
/**
 * 读取文件
 */ 
function file_get_contents($filename, $use_include_path = false, $context = null, $offset = -1, $maxlen = null){
	if (is_null($maxlen)) {
		return \file_get_contents($filename, $use_include_path, $context, $offset);
	}
	return \file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
}
/**
 * 检查文件是否存在
 */ 
function file_exists($filename){
	return \file_exists($filename);
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
	return \move_uploaded_file($filename, $destination);
}
