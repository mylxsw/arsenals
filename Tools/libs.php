<?php
/**
 * Function library
 * 
 * @author  Yiyao Guan <mylxsw@126.com>
 */ 


/**
 * read the template file and parse it
 * 
 * @param string $file  The template file
 * @param array $replace_var
 * 
 * @return string
 */ 
function get_template_content($file, $replace_var){
	$content = file_get_contents($file);
	return preg_replace(array_keys($replace_var), array_values($replace_var), $content);
}

/**
 * read the template file and parse it
 * 
 * @param string $str
 * 
 * @return  void
 */ 
function output($str){
	echo $str , "\n";
}

/**
 * create the directory recursive
 * 
 * @param string $dir
 * 
 * @return bool
 */ 
function mkdirs($dir){
	if(!is_dir($dir)){
		if(!mkdirs(dirname($dir))){
			return false;
		}
		if(!mkdir($dir, 0777)){
			return false;
		}
		// If the directory create succeed, add index.html in case of directory list
		file_put_contents($dir . DIRECTORY_SEPARATOR . 'index.html', ''); 
	}
	return true;
}
/**
 * get the parameter from console
 * 
 * @param array $opts
 * @param string $arg_name
 * @param string $default
 * 
 * @return string
 */ 
function get_arg($opts, $arg_name, $default = null){

	if(isset($opts[$arg_name]) && $opts[$arg_name] != null){
		return $opts[$arg_name];
	}
	return $default;
}