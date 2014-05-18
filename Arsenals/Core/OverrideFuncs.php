<?php
namespace Arsenals\Core;
use \Arsenals\Core\Views\Ajax;
if (!defined('APP_NAME')) exit('Access Denied!');

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
 * 写文件
 * @param unknown $filename
 * @param unknown $data
 * @param string $flag
 * @param string $context
 * @return number
 */
if(!function_exists('\Arsenals\Core\file_put_contents')){
	function file_put_contents($filename, $data, $flag = null, $context = null){
		$dir = dirname($filename);
		if(!file_exists($dir)){
			create_dir($dir);
		}
		return \file_put_contents($filename, $data, $flag, $context);
	}
}
/**
 * 写文件
 */
if(!function_exists('\Arsenals\Core\write_file')){
    function write_file($filename, $data, $flag = null, $context = null){
        return file_put_contents($filename, $data, $flag, $context);
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
		\move_uploaded_file($filename, $destination);
        return $destination;
	}
}
/**
 * 递归创建目录
 * 
 */ 
if(!function_exists('\Arsenals\Core\create_dir')){
	function create_dir($path){
		// 如果目录存在，则直接返回
		if(is_dir($path)){
			return ;
		}
		// 获取当前目录的上级目录
		$dirname = dirname($path);
		// 如果上级目录存在，则创建当前目录
		if(is_dir($dirname)){
			mkdir($path);
		}
		// 如果上级目录不存在，则递归调用创建上级目录
		if(!is_dir($dirname)){
			create_dir($dirname);
			mkdir($path);
		}
	}
}
/**
 * 包含文件
 * 
 * $datas为传递给页面的数据
 */
if(!function_exists('\Arsenals\Core\include_file')){
	function include_file($filename, Array $datas = array()){
		@extract($datas);
		include $filename;
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