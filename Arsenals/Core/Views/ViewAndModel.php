<?php

namespace Arsenals\Core\Views;

use Arsenals\Core\Abstracts\Arsenals;

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}
/**
 * 核心视图.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
class ViewAndModel extends Arsenals
{
    /**
     * 视图名称.
     */
    private $view_name;
    /**
     * 传递给视图对形象的数据.
     */
    private $view_datas;
    /**
     * 视图实现实例.
     *
     * @var unknown
     */
    private static $_view_instance = null;

    /**
     * 构造函数，初始化视图对象
     *
     * @param string $view_name  视图名称
     * @param array  $view_datas 传递给视图对象的数据
     */
    public function __construct($view_name, $view_datas = [])
    {
        $this->view_name = $view_name;
        $this->view_datas = $view_datas;

        parent::__construct();
    }

    /**
     * 获取当前视图名称.
     *
     * @return string
     */
    public function getView()
    {
        return $this->view_name;
    }

    /**
     * 获取传递给视图对象的数据.
     *
     * @return array
     */
    public function getDatas()
    {
        return $this->view_datas;
    }

    /**
     * 视图模型解析.
     *
     * @param unknown $view_name
     * @param unknown $view_datas
     *
     * @throws \Exception
     *
     * @return string
     */
    public static function make($view_name, $view_datas = [])
    {
        if ($view_name instanceof self) {
            if (is_null(self::$_view_instance)) {
                $view_layer = VIEW_IMPL;
                self::$_view_instance = new $view_layer();
            }

            if (self::$_view_instance instanceof View) {
                // 将数据添加到值栈，以便随时访问
                ValueStack::addAll($view_name->getDatas());

                return self::$_view_instance->parse($view_name);
            } else {
                throw new \Exception('The view class must implement the interface : Arsenals\\Core\\Views\\View!');
            }
        } else {
            $vm = new self($view_name, $view_datas);

            return self::make($vm);
        }
    }
}
