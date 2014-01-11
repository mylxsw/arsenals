<?php

namespace Arsenals\Core;

/**
 * DEBUG用于调试程序，打印变量
 *
 * @param mixed $var 要打印的变量
 * @param bool $dump 是否使用var_dump
 *
 * @return void
 */
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
/**
 * 字符串函数： 判断字符串是否以另一字符串结尾
 *
 * @param string $string 要进行判断的字符串
 * @param string $suffix 结尾字符串
 * @param bool $case_sensitive 是否大小写敏感
 *
 * @return bool
 */
function str_end_with($string, $suffix, $case_sensitive = TRUE){
	//return substr_compare($string, $suffix,
	//	strlen($string) - strlen($suffix), strlen($string), $case_sensitive) === 0;
	if(!$case_sensitive){
		$string = strtolower($string);
		$suffix = strtolower($suffix);
	}
	return substr($string, -strlen($suffix)) == $suffix;
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
function str_start_with($string, $prefix, $case_sensitive = TRUE){
	if(strlen($string) < strlen($prefix)){
		return false;
	}
	return substr_compare($string, $prefix,
			0, strlen($prefix), $case_sensitive) === 0;
}

/**
 * 在对象文件的源码内容中插入内容，并返回修改后的源码
 *
 * @param string $object_file 操作的原文件名，必须只包含一个类文件
 * @param string $content 要插入的内容
 * @return string 修改后的源码
 */
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
/**
 * 从PHP源码中去除注释和空白
 *
 * @param string $content
 * @return string
 */
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
/**
 * 错误处理
 * @param unknown $errno
 * @param unknown $errstr
 * @param unknown $errfile
 * @param unknown $errline
 */
function _error_handler($errno, $errstr, $errfile, $errline){
	_D("文件{$errfile}的第{$errline}行有一个错误，错误代码为{$errno}, 错误描述:{$errstr}");
}
/**
 * 异常处理
 * @param unknown $exception
 */
function _exception_handler($exception){
	_D($exception);
}