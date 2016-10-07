<?php

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}
/*
 * 参数： var, value, default
 */
$callback = function ($matches) {
    $params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
    if (isset($params['var']) && isset($params['value'])) {
        if (isset($params['default'])) {
            return "<?php \${$params['var']} = isset({$params['value']}) ? {$params['value']} : \"{$params['default']}\" ; ?>";
        }

        return "<?php \${$params['var']} = {$params['value']} ; ?>";
    }

    return '<!-- Template Syntax Error! -->';
};

return ['set', true, $callback];
