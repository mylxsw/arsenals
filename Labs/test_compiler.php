<?php

class TemplateCompiler
{
    private $_namespace = 'c';
    private $el_delim = ['{', '}'];
    private $_rules = [];

    /**
     * 初始化编译器.
     *
     * 规则：
     * 	'标签名', 是否闭合, 回调函数[, 是否自定义正则表达式]
     */
    private function init()
    {
        $rules = [
            //'../Arsenals/Core/Views/rules/out.php',
            //'../Arsenals/Core/Views/rules/if.php',
            //'../Arsenals/Core/Views/rules/end_any.php',
        ];
        foreach ($rules as $rule) {
            $data = include $rule;

            if (!isset($data[3]) || $data[3] == false) {
                $data[0] = '#<__namespace__:'.$data[0].'\s+(?<content>.*?)'.($data[1] ? '/' : '').'>#';
            }

            $data[0] = str_replace('__namespace__', $this->_namespace, $data[0]);

            $this->_rules[$data[0]] = $data[2];
        }
    }

    /* (non-PHPdoc)
     * @see \Arsenals\Core\Views\Compiler::compile()
     */
    public function compile($content)
    {
        $this->init();
        foreach ($this->_rules as $k => $v) {
            $content = preg_replace_callback($k, $v, $content);
        }
        // 提供类似于EL表达式的语法支持
        $content = preg_replace('#{\$([a-zA-Z_\x7f-\xff]*)\s*}#', '<?php echo $\1;?>', $content);
        $content = preg_replace_callback('#{func:\s*(?<funcname>[\\a-zA-Z_\x7f-\xff]+)\s*\((?<params>.*?)\)\s*}#',
            function ($matches) {
                $matches['funcname'] = str_replace('.', '\\', $matches['funcname']);

                return "<?php echo {$matches['funcname']}(${matches['params']});?>";
            }, $content);

        return $content;
    }

    public static function parseParams($content)
    {
        preg_match_all('#(?<key>\w+)\s*=(?<quote>"|\')(?<value>.*?)(?<!\\\\)\k<quote>#', trim($content), $cmd_arr);
        $params = [];
        foreach ($cmd_arr['key'] as $k => $v) {
            $_v = str_replace(' gt ', ' > ', $cmd_arr['value'][$k]);
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

$content = file_get_contents('test_tpl.tpl');


$compiler = new TemplateCompiler();
echo $compiler->compile($content);
