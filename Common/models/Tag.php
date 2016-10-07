<?php

namespace Common\models;

use Arsenals\Core\Abstracts\Model;

/**
 * 标签.
 *
 * @author 管宜尧<mylxsw@126.com>
 */
class Tag extends Model
{
    /**
     * 获取指定标签的ID.
     *
     * 如果标签不存在，则先插入
     *
     * @param string $tag_name
     *
     * @return number
     */
    public function getTagId($tag_name)
    {
        $tag = $this->load(['name' => $tag_name]);
        if (is_null($tag)) {
            $data = [];
            $data['name'] = $tag_name;
            $data['isvalid'] = 1;
            $data['create_time'] = time();

            return $this->save($data);
        }

        return $tag['id'];
    }

    /**
     * 获取指定文章的标签.
     */
    public function getTagsByArtId($id)
    {
        $sql = 'SELECT * FROM `'.$this->getTableName().'` WHERE id in (SELECT tag_id FROM `'.$this->getTableName('article_tag')."` WHERE article_id='".intval($id)."' )";

        return $this->query($sql);
    }

    /**
     * 添加标签.
     *
     * @param unknown_type $data
     */
    public function addTag($data)
    {
        return $this->save($data);
    }

    /**
     * 更新标签.
     *
     * @param $data
     * @param $id
     */
    public function updateTag($data, $id)
    {
        $entity = [];
        $entity['name'] = $data['name'];

        $this->update($entity, ['id' => intval($id)]);
    }

    /**
     * 删除标签.
     *
     * @param $id
     */
    public function delTag($id)
    {
        if (!is_array($id)) {
            $id = [$id];
        }
        foreach ($id as $i) {
            // 删除文章关联
            $this->delTagArts($i);
            // 删除该分类
            $this->delete(['id' => $i]);
        }
    }

    /**
     * 删除标签与文章的关联.
     *
     * @param $tag_id
     */
    public function delTagArts($tag_id)
    {
        $this->delete(['tag_id' => $tag_id], 'article_tag');
    }
}
