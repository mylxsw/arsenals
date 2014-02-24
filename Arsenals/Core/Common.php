<?php

namespace Arsenals\Core;

use Arsenals\Core\Views\Ajax;
/**
 * DEBUG用于调试程序，打印变量
 *
 * @param mixed $var 要打印的变量
 * @param bool $dump 是否使用var_dump
 *
 * @return void
 */
if(!function_exists('\\Arsenals\\Core\\_D')){
	function _D($var , $dump = false){
		echo '<pre style="border:1px solid #D0D0D0; background:#F9F9F9; padding:10px;">';
		if($dump || is_object($var)){
			var_dump($var);
		}else{
			if(is_array($var)){
				print_r($var);
			}else{
				echo $var;
			}
		}
		echo '</pre>';
	}
}

/**
 * 字符串函数： 判断字符串是否以另一字符串结尾
 *
 * @param string $string 要进行判断的字符串
 * @param string $suffix 结尾字符串
 * @param bool $case_sensitive 是否大小写敏感
 *
 * @return bool
 */
if(!function_exists('\\Arsenals\\Core\\str_end_with')){	
	function str_end_with($string, $suffix, $case_sensitive = TRUE){
		//return substr_compare($string, $suffix,
		//	strlen($string) - strlen($suffix), strlen($string), $case_sensitive) === 0;
		if(!$case_sensitive){
			$string = strtolower($string);
			$suffix = strtolower($suffix);
		}
		return substr($string, -strlen($suffix)) == $suffix;
	}
}
/**
 * 字符串函数： 判断字符串是否以某一字符串开始
 *
 * @param string $string 要进行判断的字符串
 * @param string $prefix 开始字符串
 * @param bool $case_sensitive 是否大小写敏感
 *
 * @return bool
 */
if(!function_exists('\\Arsenals\\Core\\str_start_with')){	
	function str_start_with($string, $prefix, $case_sensitive = TRUE){
		if(strlen($string) < strlen($prefix)){
			return false;
		}
		return substr_compare($string, $prefix,
				0, strlen($prefix), $case_sensitive) === 0;
	}
}

/**
 * 在对象文件的源码内容中插入内容，并返回修改后的源码
 *
 * @param string $object_file 操作的原文件名，必须只包含一个类文件
 * @param string $content 要插入的内容
 * @return string 修改后的源码
 */
if(!function_exists('\\Arsenals\\Core\\source_insert')){	
	function source_insert($object_file, $content){
		$source_code = php_strip_whitespace($object_file);
		if(str_end_with($source_code, '?>')){
			$source_code = substr($source_code, 0, -2);
		}
		if(str_end_with($source_code, '}')){
			$source_code = substr($source_code, 0, -1);
		}
		$source_code .= $content;
		$source_code .= '}';

		return strip_whitespace($source_code);
	}
}
/**
 * 从PHP源码中去除注释和空白
 *
 * @param string $content
 * @return string
 */
if(!function_exists('\\Arsenals\\Core\\strip_whitespace')){
	function strip_whitespace($content){
		$source = '';
		$last_space = false;
		$tokens = token_get_all($content);
		foreach($tokens as $token){
			if(is_string($token)){
				$last_space = false;
				$source .= $token;
			}else{
				list ($id, $text)  =  $token;
				switch($id){
					case T_COMMENT:
					case T_DOC_COMMENT:
						break;
					case T_WHITESPACE:
						if(!$last_space){
							$source .= ' ';
							$last_space = true;
						}
						break;
					default:
						$source .= $text;
						$last_space = false;
				}
			}
		}

		return $source;
	}
}
/**
 * 写文件
 * @param unknown $filename
 * @param unknown $data
 * @param string $flag
 * @param string $context
 * @return number
 */
if(!function_exists('\\Arsenals\\Core\\file_put_contents')){
	function file_put_contents($filename, $data, $flag = null, $context = null){
		return \file_put_contents($filename, $data, $flag, $context);
	}
}
/**
 * 读取文件
 */ 
if(!function_exists('\\Arsenals\\Core\\file_get_contents')){
	function file_get_contents($filename, $use_include_path = false, $context = null, $offset = -1, $maxlen = null){
		if (is_null($maxlen)) {
			return \file_get_contents($filename, $use_include_path, $context, $offset);
		}
		return \file_get_contents($filename, $use_include_path, $context, $offset, $maxlen);
	}
}
/**
 * 检查文件是否存在
 */ 
if(!function_exists('\\Arsenals\\Core\\file_exists')){
	function file_exists($filename){
		return \file_exists($filename);
	}
}
/**
 * 打开目录
 */ 
if(!function_exists('\\Arsenals\\Core\\opendir')){
	function opendir($path, $resource = null){
		if(is_null($resource)){
			return \opendir($path);
		}
		return \opendir($path, $resource);
	}
}
/**
 * 读取目录
 */ 
if(!function_exists('\\Arsenals\\Core\\readdir')){
	function readdir($handle = null){
		if (is_null($handle)) {
			return \readdir();
		}
		return \readdir($handle);
	}
}
/**
 * 删除文件
 */ 
if(!function_exists('\\Arsenals\\Core\\unlink')){
	function unlink($filename, $context = null){
		if(is_null($context)){
			return \unlink($filename);
		}
		return \unlink($filename, $context);
	}
}
/**
 * 关闭目录
 */ 
if(!function_exists('\\Arsenals\\Core\\closedir')){
	function closedir($handle = null){
		if (is_null($handle)) {
			\closedir();
			return ;
		}
		\closedir($handle);
	}
}
/**
 * 是否是文件
 */ 
if(!function_exists('\\Arsenals\\Core\\is_file')){
	function is_file($filename){
		return \is_file($filename);
	}
}
/**
 * Moves an uploaded file to a new location
 */ 
if(!function_exists('\\Arsenals\\Core\\move_uploaded_file')){
	function move_uploaded_file($filename, $destination){
		return \move_uploaded_file($filename, $destination);
	}
}
/**
 * 错误处理
 * @param unknown $errno
 * @param unknown $errstr
 * @param unknown $errfile
 * @param unknown $errline
 */
if(!function_exists('\\Arsenals\\Core\\_error_handler')){
	function _error_handler($errno, $errstr, $errfile, $errline){
		_D("文件{$errfile}的第{$errline}行有一个错误，错误代码为{$errno}, 错误描述:{$errstr}");
	}
}
/**
 * 异常处理
 * @param unknown $exception
 */
if(!function_exists('\\Arsenals\\Core\\_exception_handler')){
	function _exception_handler(\Exception $exception){
		$input = Registry::load('\\Arsenals\\Core\\Input');
		if($input->server('HTTP_X_REQUESTED_WITH', '') == 'XMLHttpRequest'){
			$output = Registry::load('\\Arsenals\\Core\\Output');
			$output->render(new Ajax(array('info'=>$exception->getMessage(), 'status'=>0)));
		}else{
			_D("文件{$exception->getFile()}的第{$exception->getLine()}行抛出异常， 错误代码为 {$exception->getCode()}， 错误描述 ：{$exception->getMessage()}");
		}
	}
}