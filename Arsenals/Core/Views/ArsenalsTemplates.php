<?php

namespace Arsenals\Core\Views;

use \Arsenals\Core\Abstracts\Arsenals;
use \Arsenals\Core\Config;
use \Arsenals\Core\Exceptions\ClassTypeException;
use \Arsenals\Core\Registry;
if (!defined('APP_NAME')) exit('Access Denied!');
class ArsenalsTemplates extends Arsenals implements View {
	
	/**
	 * 模板文件后缀
	 * @var unknown
	 */
	private $suffix = '.html';
	/**
	 * 模板目录
	 * @var unknown
	 */
	private $template_dir = '';
	/**
	 * 编译目录
	 * @var unknown
	 */
	private $compile_dir = '';
	/**
	 * 编译后文件后缀
	 * @var unknown
	 */
	private $compile_suffix = '.php';
	/**
	 * 是否编译成html
	 * @var unknown
	 */
	private $cache_html = false;
	/**
	 * 是否是debug模式
	 * @var unknown
	 */
	private $debug = false;
	/**
	 * 采用的编译器
	 * @var unknown
	 */
	private $compiler = 'Arsenals\Core\Views\TemplateCompiler';
	
	/**
	 * 模板编译器实例
	 * @var unknown
	 */
	private $_compiler_instance = null;
	/**
	 * 是否加载过了视图函数库
	 * @var
	 */ 
	private static $is_func_loaded = false;
	
	public function __construct(array $config = array()){
		// 读取视图相关配置信息
		$config = Config::load('config');
		$this->template_dir = VIEW_PATH . ($config['multi_theme'] ? $config['theme'] . DIRECTORY_SEPARATOR : '');
		// 配置信息
		foreach ($config as $k=>$v){
			$this->{$k} = $v;
		}
		// 是否是调试模式
		$this->debug = DEBUG;
	}
	/**
	 * 初始化模板编译器
	 */
	private function _initCompiler(){
		if(is_null($this->_compiler_instance)){
			$this->_compiler_instance = Registry::load($this->compiler, true);
			if(!$this->_compiler_instance instanceof Compiler){
				throw new ClassTypeException('The compiler must implement the Arsenals\Core\Views\Compiler interface');
			}
		}
	}
	
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Views\View::parse()
	 */
	public function parse($vm) {
		if(!$vm instanceof ViewAndModel){
			return FALSE;
		}
		
		// 加载视图函数库
		if(!self::$is_func_loaded && \Arsenals\Core\file_exists("{$this->template_dir}functions.php")){
			include "{$this->template_dir}functions.php";
			self::$is_func_loaded = true;
		}
		//$template_file = $vm->getView() . $this->suffix;
		$cache_file = CACHE_PATH . 'views' . DIRECTORY_SEPARATOR . APP_NAME . DIRECTORY_SEPARATOR .  $vm->getView() . $this->compile_suffix;
       
        ob_start();
		if($this->debug || !\Arsenals\Core\file_exists($cache_file)){
            
			// 加载视图
			$template_content = \Arsenals\Core\file_get_contents($this->template_dir . $vm->getView() . $this->suffix);
           
			// 初始话模板编译器
			$this->_initCompiler();
			// 编译模板
			$compiled_content = $this->_compiler_instance->compile($template_content);
            
			// 写入缓存
			\Arsenals\Core\file_put_contents($cache_file, $compiled_content);
		}
		// 读取缓存内容

		\Arsenals\Core\include_file($cache_file, ValueStack::gets());

        $buffer = ob_get_contents();
        ob_end_clean();
        
		return $buffer;
	}
}
