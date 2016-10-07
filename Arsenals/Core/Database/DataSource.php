<?php

namespace Arsenals\Core\Database;

if (!defined('APP_NAME')) {
    exit('Access Denied!');
}
/**
 * 数据源接口.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
interface DataSource
{
    /**
     * 数据库连接初始化.
     */
    public function init();

    /**
     * 获取数据库连接.
     */
    public function getConnection();

    /**
     * 获取原始数据库连接.
     */
    public function getRealConnection();

    /**
     * 关闭数据库连接.
     */
    public function closeConnection();

    /**
     * 执行sql语句.
     *
     * @param string $sql  要执行的sql语句
     * @param array  $args 预处理的变量
     *
     * @return array | int
     */
    public function query($sql, $args = [], $insert = false);

    /**
     * 对字符串进行安全处理.
     *
     * @param unknown_type $str
     */
    public function escape($str);

    /**
     * 开始事务
     */
    public function beginTrans();

    /**
     * 提交事务
     */
    public function commit();

    /**
     * 回滚事务
     */
    public function rollback();

    /**
     * 最后插入ID.
     */
    public function lastInsertId();
}
