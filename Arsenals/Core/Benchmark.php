<?php

namespace Arsenals\Core;

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}
/**
 * 基准测试类
 * 参考CI框架.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
class Benchmark
{
    private $_marker = [];

    /**
     * 记录一个时间点.
     *
     * @param unknown $name
     */
    public function mark($name)
    {
        $this->_marker[$name] = microtime();
    }

    /**
     * 总共消耗的时间计算.
     *
     * @param unknown $point1
     * @param string  $point2
     * @param number  $decimals
     *
     * @return string
     */
    public function elapsedTime($point1, $point2 = '', $decimals = 4)
    {
        if (!isset($this->_marker[$point1])) {
            return '';
        }
        if (!isset($this->_marker[$point2])) {
            $this->_marker[$point2] = microtime();
        }

        list($sm, $ss) = explode(' ', $this->_marker[$point1]);
        list($em, $es) = explode(' ', $this->_marker[$point2]);

        return number_format(($em + $es) - ($sm + $ss), $decimals);
    }
}
