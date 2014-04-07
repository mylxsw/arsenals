<?php
/**
 * Function library
 * 
 * @author  Yiyao Guan <mylxsw@126.com>
 */ 

/**
 * get the project meta information
 * 
 * @return array
 */ 
function get_project_meta($usage = ''){
	$proj_name_param = cli_opt_init();
	$proj_name = $proj_name_param['n'];
	if($proj_name == null) {
		$proj_name = get_cli_param('name', null);
		if ($proj_name == null) {
			exit($usage);
		}
	}

	$proj_path = dirname($proj_name);
	if($proj_path == '.'){
		$proj_path = '.' . DIRECTORY_SEPARATOR . 'output';
	}
	$proj_path = $proj_path . DIRECTORY_SEPARATOR;
	$proj_name = basename($proj_name);

	return array('proj_name' => $proj_name, 'proj_path' => $proj_path);
}
/**
 * Check Cli mode
 */ 
function is_cli(){
	return php_sapi_name() == 'cli';
}
/**
 * initialize cli parameters
 */ 
function cli_opt_init($options = '', array $longopts = array()){
	static $opts = null;
	if($opts == null){
		$opts = getopt($options, $longopts);
	}
	return $opts;
}
/**
 * get the param from the command line
 * 
 * before this function , cli_opt_init() must be exec first
 * 
 * @param string $key
 * @param string $default
 * 
 * @return string
 */ 
function get_cli_param($key, $default = ''){
	$opt = cli_opt_init();
	$val = isset($opt[$key]) ? $opt[$key] : null;	
	return $val == null ? $default : $val;
}
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
 * @param string $arg_name
 * @param string $default
 * 
 * @return string
 */ 
function get_arg($arg_name, $default = null){
	return get_cli_param($arg_name, $default);
}
/**
 * create directories from directory array
 * 
 * @param array $dirs
 */ 
function create_dir_from_array(Array $dirs, $base_path = ''){
	foreach($dirs as $dir){
		$dirname = preg_replace('#/#', DIRECTORY_SEPARATOR, $base_path . $dir);
		mkdirs($dirname);
		output("Create directory: {$dirname} ");
	}
}

function create_file_from_array($files, $parameters = array(), $base_path = ''){

	// variable replace
	$replace_var = array();
	foreach ($parameters as $key => $val) {
		$replace_var['#\[\[' . $key . '\]\]#'] = $val;
	}

	foreach($files as $file => $tpl){
		$filename = preg_replace('#/#', DIRECTORY_SEPARATOR,  $base_path . $file );
		mkdirs(dirname($filename));
		if( !file_exists($filename) ){
			file_put_contents($filename, 
				$tpl == '' ? '' : get_template_content($tpl, $replace_var));
		}
		output("Generate file: {$filename} ");
	}
}