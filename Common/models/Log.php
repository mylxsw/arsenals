<?php

namespace Common\models;

/**
 * @author guan
 */
class Log extends AdvanceModel
{
    const EVENT = 'event';
    private $_log_level = ['event'];

    /**
     * 记录日志.
     *
     * @param string $action_title
     * @param string $action_type
     * @param string $operator
     * @param string $data
     */
    public function writeLog($action_title, $action_type, $operator, $data = null)
    {
        if ($this->_checkLogLevel($action_type) === true) {
            $this->_writeLog($action_title, $action_type, $operator, $data);
        }
    }

    /**
     * 记录日志.
     *
     * @param string $action_title
     * @param string $action_type
     * @param string $operator
     * @param string $data
     */
    private function _writeLog($action_title, $action_type, $operator, $data = null)
    {
        $log['action_time'] = time();
        $log['action_name'] = $action_title;
        $log['operator'] = $operator;
        $log['action_type'] = $action_type;
        if (!is_null($data)) {
            $log['data'] = $data;
        }

        $this->save($log);
    }

    /**
     * 检查日志级别.
     *
     * @param string $action_type
     *
     * @return bool
     */
    private function _checkLogLevel($action_type)
    {
        $config = \Arsenals\Core\Config::load('admin');
        if (!$config['log_enabled']) {
            return false;
        }

        return in_array($action_type, $this->_log_level);
    }

    /**
     * 载入日志信息.
     *
     * @param unknown $cont
     *
     * @return Ambigous <\Admin\models\multitype:multitype:, multitype:multitype: number unknown mixed Ambigous <multitype:, multitype:multitype: , unknown> >|multitype:multitype:string unknown
     */
    public function logDataTable($cont)
    {
        $columns = ['id', 'action_time', 'action_name', 'operator', 'action_type'];
        $indexColumn = 'id';

        return $this->loadDataTable($cont, $columns, $indexColumn, function ($columns, $result) {
            $output = [];
            foreach ($result as $res) {
                $row = [];
                for ($i = 0; $i < count($columns); $i++) {
                    if ($columns[$i] == 'action_time') {
                        $row[] = date('Y-m-d H:i:s', $res['action_time']);
                    } elseif ($columns[$i] != ' ') {
                        /* General output */
                        $row[] = $res[$columns[$i]];
                    }
                }
                $output[] = $row;
            }

            return $output;
        });
    }
}
