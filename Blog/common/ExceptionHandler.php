<?php

namespace Blog\common;

use Arsenals\Core\Views\ViewAndModel;

class ExceptionHandler
{
    public function exception(\Exception $exception)
    {
        echo ViewAndModel::make('error/error');
        exit();
    }

    public function error($errno, $errstr, $errfile, $errline)
    {
        echo ViewAndModel::make('error/error');
        exit();
    }
}
