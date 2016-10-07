<?php

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}
/*
 * 参数： func
 */
$callback = function ($matches) {
    $params = \Arsenals\Core\Views\TemplateCompiler::parseParams($matches['content']);
    if (isset($params['func'])) {
        return "<?php echo {$params['func']};  ?>";
    }

    return '<!-- Template Syntax Error! -->';
};

return ['func', true, $callback];
