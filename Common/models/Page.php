<?php

namespace Common\models;

use Arsenals\Core\Abstracts\Model;

class Page extends Model
{
    /**
     * 新增页面.
     *
     * @param array $data
     *
     * @return int
     */
    public function addPage($data)
    {
        $entity = [];

        $entity['title'] = $data['title'];
        $entity['templates'] = $data['templates'];
        $entity['creator'] = $data['creator'];
        $entity['create_date'] = time();
        $entity['attr'] = serialize($data['attr']);
        $entity['isvalid'] = $data['isvalid'];

        return $this->save($entity);
    }

    /**
     * 更新页面.
     *
     * @param array $data
     * @param int id
     *
     * @return void
     */
    public function updatePage($data, $id)
    {
        $entity = [];

        isset($data['title']) && $entity['title'] = $data['title'];
        isset($data['templates']) && $entity['templates'] = $data['templates'];
        isset($data['attr']) && $entity['attr'] = $data['attr'];
        isset($data['isvalid']) && $entity['isvalid'] = $data['isvalid'];

        $entity['updator'] = $data['updator'];
        $entity['update_date'] = time();


        $this->update($entity, ['id' => intval($id)]);
    }

    /**
     *  删除页面.
     */
    public function delPage($id)
    {
        if (!is_array($id)) {
            $id = [$id];
        }
        foreach ($id as $i) {
            $this->delete(['id' => $i]);
        }
    }

    /**
     *  列出所有页面.
     */
    public function lists($limit = 10, $table = null)
    {
        $table = is_null($table) ? $this->_table_name : $this->getTableName($table);

        $sql = "SELECT id, title, isvalid, creator, create_date, updator, update_date, attr FROM {$table}";
        // 添加查询记录数量限制
        if (!\is_null($limit)) {
            $sql .= " LIMIT {$limit}";
        }

        return $this->query($sql);
    }
}
