<?php

namespace Admin\utils;

/**
 * @author guan
 */
class Ajax
{
    const SUCCESS = '1';
    const ERROR = '-1';
    const FAILED = '0';

    public static function ajaxReturn($info, $status, $data = [])
    {
        return new \Arsenals\Core\Views\Ajax(['info' => $info, 'status' => $status, 'data' => $data]);
    }

    public static function success($info, $data = [])
    {
        return self::ajaxReturn($info, 1, $data);
    }

    public static function failed($info, $data = [])
    {
        return self::ajaxReturn($info, 0, $data);
    }
}
