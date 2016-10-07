<?php

namespace Arsenals\Core\Abstracts;

use Arsenals\Core\Registry;

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}
/**
 * Arsenals 抽象类.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
abstract class Arsenals
{
    protected $_log = null;
    protected $_benchMark = null;

    public function __construct()
    {
        $this->_log = Registry::load('\Arsenals\Core\Log');
        $this->_benchMark = Registry::load('\Arsenals\Core\Benchmark');

        $this->_log->info('Class loaded!', get_class($this));
    }

    /**
     * 多语言支持
     *
     * @param string $code    语言转换代码
     * @param array  $replace 代替值
     * @param string $default 默认值，在找不到代码代表值的时候使用
     * @param string $file    语言文件，默认为basic,不需要扩展名
     */
    final protected static function L($code, $replace = null, $default = null, $file = 'basic')
    {
        return \Arsenals\Core\L($code, $replace, $default, $file);
    }
}
