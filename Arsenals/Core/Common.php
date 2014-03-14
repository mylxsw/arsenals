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
if(!function_exists('\Arsenals\Core\_D')){
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
 * 检查当前语言配置
 */ 
if(!function_exists('\Arsenals\Core\detect_lang')){
	function detect_lang(){
		return 'cn';
	}
}
/**
 * 多语言支持
 * 
 * @param string $code 语言转换代码
 * @param array $replace 代替值
 * @param string $default 默认值，在找不到代码代表值的时候使用
 * @param string $file 语言文件，默认为basic,不需要扩展名
 */ 
if(!function_exists('\Arsenals\Core\L')){
	function L($code, $replace = null, $default = null, $file = 'basic'){
		// 缓存已经加载的语言文件
		static $langs = array();

		// 如果没有缓存过，则先缓存
		if(!array_key_exists($file, $langs)){
			$current_lang = detect_lang();
			$lang_file_sys = ARSENALS_LANG_PATH . $current_lang . DIRECTORY_SEPARATOR . $file . '.php';
			$lang_kv = array();
			// 首先读取系统内置语言
			if(\file_exists($lang_file_sys)){
				$lang_kv = include $lang_file_sys;
			}
			// 读取项目配置语言
			$lang_file = LANG_PATH . $current_lang . DIRECTORY_SEPARATOR . $file . '.php';
			if(\file_exists($lang_file)){
				$lang_kv_prog = include $lang_file;
				$lang_kv = array_merge($lang_kv, $lang_kv_prog);
			}

			$langs[$file] = $lang_kv;
		}
		// 判断是否是存在该代码对应的翻译，如果存在，则处理翻译，否则，返回默认值
		if(array_key_exists($code, $langs[$file])){
			// 如果没有提供替换变量， 则直接返回翻译语言
			if (is_null($replace)) {
				return $langs[$file][$code];
			}
			// 正则替换需要翻译的变量
			$lang_trans = $langs[$file][$code];
			foreach ($replace as $key => $value) {
				$lang_trans = preg_replace('/#{' . $key . '}/', $value, $lang_trans);
			}
			return $lang_trans;
		}

		// 返回提供的默认值
		return $default;
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
if(!function_exists('\Arsenals\Core\str_end_with')){	
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
if(!function_exists('\Arsenals\Core\str_start_with')){	
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
if(!function_exists('\Arsenals\Core\source_insert')){	
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
if(!function_exists('\Arsenals\Core\strip_whitespace')){
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
if(!function_exists('\Arsenals\Core\file_put_contents')){
	function file_put_contents($filename, $data, $flag = null, $context = null){
		return \file_put_contents($filename, $data, $flag, $context);
	}
}
/**
 * 读取文件
 */ 
if(!function_exists('\Arsenals\Core\file_get_contents')){
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
if(!function_exists('\Arsenals\Core\file_exists')){
	function file_exists($filename){
		return \file_exists($filename);
	}
}
/**
 * 打开目录
 */ 
if(!function_exists('\Arsenals\Core\opendir')){
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
if(!function_exists('\Arsenals\Core\readdir')){
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
if(!function_exists('\Arsenals\Core\unlink')){
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
if(!function_exists('\Arsenals\Core\closedir')){
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
if(!function_exists('\Arsenals\Core\is_file')){
	function is_file($filename){
		return \is_file($filename);
	}
}
/**
 * Moves an uploaded file to a new location
 */ 
if(!function_exists('\Arsenals\Core\move_uploaded_file')){
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
if(!function_exists('\Arsenals\Core\_error_handler')){
	function _error_handler($errno, $errstr, $errfile, $errline){
		_D("File {$errfile} , Line {$errline} has an error occer，error code : {$errno}, description :{$errstr}");
	}
}
/**
 * 异常处理
 * @param unknown $exception
 */
if(!function_exists('\Arsenals\Core\_exception_handler')){
	function _exception_handler(\Exception $exception){
		$input = Registry::load('\Arsenals\Core\Input');
		if($input->server('HTTP_X_REQUESTED_WITH', '') == 'XMLHttpRequest'){
			$output = Registry::load('\Arsenals\Core\Output');
			$output->render(new Ajax(array('info'=>$exception->getMessage(), 'status'=>0)));
		}else{
			_D("File {$exception->getFile()}, Line {$exception->getLine()} has an exception occer， error code : {$exception->getCode()}， description ：{$exception->getMessage()}");
		}
	}
}