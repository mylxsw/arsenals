<?php
class BuildTools{
	private $opts = null;
	private $project_name;
	private $project_path;
	
	private $replace_var = array();
	
	/**
	 * 构造函数
	 * 
	 * @param array $longopts
	 */
	public function __construct( Array $longopts = array()){
		// 执行初始化
		$this->_init($longopts);
	}
	
	/**
	 * 添加替换变量
	 * @param unknown_type $var
	 * @param unknown_type $value
	 */
	public function addReplaceVar($var , $value){
		$this->replace_var['#\[\[' . $var . '\]\]#'] = $value;
		if (array_key_exists($var, $this->opts)){
			$this->opts[$var] = $value;
		}
	}
	/**
	 * 批量添加替换变量
	 * 
	 * @param array $vars
	 */
	public function addReplaceVars(Array $vars){
		foreach ($vars as $k=>$v){
			$this->addReplaceVar($k, $v);
		}
	}
	/**
	 * 获取项目名称
	 */
	public function getProjectName(){
		return $this->project_name;
	}
	/**
	 * 获取项目目录
	 */
	public function getProjectPath(){
		return $this->project_path;
	}
	/**
	 * 读取从命令行提供的参数
	 * 
	 * @param string $key
	 * @param string $default
	 */
	public function getParam($key, $default = null){
		$result = null;
		if (isset($this->opts[$key])){
			$result = $this->opts[$key];
		}
		
		$result = is_null($result) ? $default : $result;
		return PHP_OS == 'WINNT' ? iconv('GBK', 'UTF-8', $result) : $result;
	}
	/**
	 * 是否是windows系统
	 */
	public static function isWin(){
		return PHP_OS == 'WINNT';
	}
	
	/**
	 * GBK -> UTF8
	 * @param $str
	 */
	public static function convG2U($str){
		return iconv('GBK', 'UTF-8', $str);
	}
	/**
	 * UTF8 -> GBK
	 * @param unknown_type $str
	 */
	public static function convU2G($str){
		return iconv('UTF-8', 'GBK', $str);
	}
	
	/**
	 * 是否是CLI模式
	 * 
	 * @return bool
	 */
	public static function isCLI(){
		return php_sapi_name() == 'cli';
	}
	/**
	 * 创建目录
	 * @param string $dir
	 */
	public static function mkdir($dir){
		if(!is_dir($dir)){
			if(!self::mkdir(dirname($dir))){
				return false;
			}
			if(!mkdir($dir, 0777)){
				return false;
			}
			// 如果常见成功，则附加创建index.html，防止服务器配置错误而列出目录结构
			file_put_contents($dir . DIRECTORY_SEPARATOR . 'index.html', ''); 
		}
		return true;
	}
	/**
	 * 输出一行内容
	 * @param string $str
	 */
	public static function output($str){
		echo (PHP_OS == 'WINNT' ? iconv('UTF-8', 'GBK', $str) : $str) , "\n";
	}
	
	/**
	 * 读取模板内容并替换掉变量
	 * 
	 * @param unknown_type $filename
	 */
	public function getTemplateContent($filename){
		$content = file_get_contents($filename);
		return preg_replace(array_keys($this->replace_var), array_values($this->replace_var), $content);
	}
	/**
	 * 获取项目路径
	 */
	public function getBasePath(){
		return $this->project_path . $this->project_name . DIRECTORY_SEPARATOR;
	}
	/**
	 * 创建目录群
	 * @param array $dirs
	 */
	public function createDirs(Array $dirs){
		foreach($dirs as $dir){
			$dirname = preg_replace('#/#', DIRECTORY_SEPARATOR, $this->getBasePath() . $dir);
			self::mkdir($dirname);
			self::output("创建目录: {$dirname} ");
		}
	}
	/**
	 * 从模板创建文件群
	 * @param array $files
	 */
	public function createFiles(Array $files){
		foreach($files as $file => $tpl){
			$filename = preg_replace('#/#', DIRECTORY_SEPARATOR,  $this->getBasePath() . $file );
			self::mkdir(dirname($filename));
			if( !file_exists($filename) ){
				file_put_contents($filename, 
					$tpl == '' ? '' : $this->getTemplateContent($tpl));
			}
			self::output("生成文件: {$filename} ");
		}
	}
	
	/**
	 * 创建项目配置文件
	 */
	public function createConfigFile(){
		$cfg = '<?php if(php_sapi_name() == "cli") return ' . var_export($this->opts, true) . ';';
		file_put_contents($this->getBasePath() . 'project.cfg.php', self::isWin() ? self::convG2U($cfg) : $cfg);
	}
	
	/**
	 * 初始化项目
	 * @throws Exception
	 */
	private function _init($longopts){
		
		// 首先读取从命令行提供的所有参数与其原始值
		$optparams = array();
		foreach ($longopts as $k=>$v){
			$optparams[] = $k . ':';
		}
		$this->opts = getopt('n:', $optparams);
		// 对没有设置的原始值进行处理，使用默认值
		foreach($longopts as $k=>$v){
			$this->opts[$k] = (isset($this->opts[$k]) && $this->opts[$k] != null) ? $this->opts[$k] : $v  ;
		}
		
		// 参数提供的项目名称 -n / --name
		$project_name = '';
		if (isset($this->opts['n']) && $this->opts['n'] != null){
			$project_name = $this->opts['n'];
		}else if(isset($this->opts['name']) && $this->opts['name'] != null){
			$project_name = $this->opts['name'];
		}else{
			throw new Exception();
		}
		$proj_path = dirname($project_name);
		if($proj_path == '.'){
			$proj_path = '.' . DIRECTORY_SEPARATOR . 'output';
		}
		$this->project_path = $proj_path . DIRECTORY_SEPARATOR;
		$this->project_name = basename($project_name);
		
		// 创建默认替换变量列表
		$this->addReplaceVars($this->opts);
	}
	
}