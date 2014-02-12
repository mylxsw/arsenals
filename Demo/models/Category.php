<?php

namespace Demo\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 分类
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Category extends Model {
    /**
     * 添加新的文章分类
     * 
     * @param array $data
     * @return int
     */ 
    public function addCategory($data){
        return $this->save($data);
    }
    /**
     * 删除文章分类
     * 
     * @param int $id
     */ 
    public function delCategroy($id){
        // 移动所有文章分类下的文章到回收站
        $this->moveArtCatToOther($moved_cat_id, $dest_cat_id);
        
        // 删除该分类
        $this->delete(array('id'=>$id));
    }
    /**
     * 移动指定分类下的文章到另一个分类下
     */ 
    public function moveArtCatToOther($moved_cat_id, $dest_cat_id){
        $sql = 'UPDATE `' . $this->getTableName('article_category') . '` SET category_id=' . intval($dest_cat_id) . ' WHERE category_id=' . intval($moved_cat_id);
        $this->query($sql, null, true);
    }
    /**
     * 查询指定分类下文章的数量
     * 
     * @param int $cat_id
     * @return int
     */ 
    public function getArtCountInCate($cat_id){
        $sql = "SELECT COUNT(*) total FROM `" . $this->getTableName('article_category') . "` WHERE category_id=" . intval($cat_id);
        $res = $this->query($sql);
        return $res[0]['total'];
    }
}