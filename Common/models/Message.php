<?php

namespace Common\models;

class Message extends AdvanceModel
{
    public function messageDataTable($cont)
    {
        $columns = ['id', 'title', 'content', 'sources', 'type', 'receive_time', 'is_read'];
        $indexColumn = 'id';

        return $this->loadDataTable($cont, $columns, $indexColumn, function ($columns, $result) {
            $output = [];

            foreach ($result as $res) {
                $row = [];
                for ($i = 0; $i < count($columns); $i++) {
                    if ($columns[$i] == 'receive_time') {
                        $row[] = date('Y-m-d H:i:s', $res['receive_time']);
                    } elseif ($columns[$i] == 'is_read') {
                        $row[] = $res['is_read'] == 0 ? '未读' : '已读';
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
