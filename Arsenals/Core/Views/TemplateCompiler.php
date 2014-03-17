<?php

namespace Arsenals\Core\Views;
/**
 * 模板编译器
 * 
 * 可选参数: namespace, rule_files
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class TemplateCompiler extends \Arsenals\Core\Abstracts\Arsenals implements Compiler {
	private $namespace = 'c';
	private $el_delim = array('{', '}');
	private $rule_files = array(
		'rules/include',
		'rules/if', 
		'rules/else',
		'rules/end_any',
		'rules/out',
		'rules/elif',
		'rules/foreach',
		'rules/while',
		'rules/function',
	);

	private $_inited = false;
	/**
	 * 构造函数
	 * 
	 * @param array $config
	 */
	public function __construct(array $config = array()){
		isset($config['namespace']) && $this->namespace = $config['namespace'];
		isset($config['rule_files']) && is_array($config['rule_files']) 
			&& $this->rule_files = array_merge($this->rule_files, $config['rule_files']);
		isset($config['el_delim']) && $this->el_delim = $config['el_delim'];
	}
	/**
	 * 初始化编译器
	 * 
	 * 规则：
	 * 	'标签名', 是否闭合, 回调函数[, 是否自定义正则表达式]
	 */
	private function init(){
		if($this->_inited){
			return ;
		}
		// 遍历所有的规则文件并初始化编译规则
		foreach($this->rule_files as $rule){
			// 导入规则文件
			// 0->规则名称/规则正则表达式
			// 1->是否是闭合标签
			// 2->规则回调函数，参数$matches
			// 3->是否使用正则表达式，默认值为false
			$data = include $rule . '.php';
			
			// 不使用正则，则穿件标签语法规则
			if(!isset($data[3]) || $data[3] == false){
				$data[0] = '#<__namespace__:' . $data[0] . '\s+(?<content>.*?)' . ($data[1] ? '/' : '') . '>#';
			}
			// 替换命名空间为用户配置的命名空间
			$data[0] = str_replace('__namespace__', $this->namespace , $data[0]);
			
			// 完成规则初始化
			$this->_rules[$data[0]] = $data[2];
		}
		$this->_inited = true;
	}
	
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Views\Compiler::compile()
	 */
	public function compile($content) {
		// 初始化规则编译器的所有规则
		$this->init();
		// 按照规则对模板文件内容进行编译
		foreach ($this->_rules as $k=>$v){// k 正则， v 回调函数
			$content = preg_replace_callback($k, $v, $content);
		}
		// 提供类似于EL表达式的语法支持
		// {$abc }
		// {func:函数名(参数)}
		$content = preg_replace('#' . $this->el_delim[0] . '\$([a-zA-Z_\x7f-\xff]*)\s*' . $this->el_delim[1] . '#' , '<?php echo $\1;?>', $content);
		$content = preg_replace_callback('#{func:\s*(?<funcname>[\\a-zA-Z_\x7f-\xff]+)\s*\((?<params>.*?)\)\s*}#' , 
			function($matches){
				$matches['funcname'] = str_replace('.', '\\', $matches['funcname']);
				return "<?php echo {$matches['funcname']}(${matches['params']});?>";
			}, $content);
		
		return $content;
	}
	
	/**
	 * 从字符串中解析出标签参数
	 * 
	 * @param string $content 要解析的字符串
	 * @return array 键值对形式数组[key=>$value]
	 */
	public static function parseParams($content){
		preg_match_all('#(?<key>\w+)\s*=(?<quote>"|\')(?<value>.*?)(?<!\\\\)\k<quote>#', trim($content), $cmd_arr);
		$params = array();
		foreach ($cmd_arr['key'] as $k=>$v){
			
			$_v = str_replace(' gt ', ' > ',  $cmd_arr['value'][$k]);
			$_v = str_replace(' gte ', ' >= ', $_v);
			$_v = str_replace(' lt ', ' < ', $_v);
			$_v = str_replace(' lte ', ' <= ', $_v);
			$_v = str_replace(' eq ', ' = ', $_v);
			$_v = str_replace(' neq ', ' != ', $_v);
		
			$params[$v] = $_v;
		}
		return $params;
	}
}
