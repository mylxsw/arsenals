<?php

namespace Demo\models;

use Arsenals\Core\Abstracts\Model;
class Page extends Model {
    /**
     * 新增页面
     * 
     * @param array $data
     * @return int
     */ 
    public function addPage($data){
        $entity = array();
        
        $entity['title'] = $data['title'];
        $entity['templates'] = $data['templates'];
        $entity['creator'] = $data['creator'];
        $entity['create_date'] = time();
        $entity['attr'] = $data['attr'];
        $entity['isvalid'] = 1;
        
        return $this->save($entity);
    }
    /**
     * 更新页面
     * 
     * @param array $data
     * @param int id
     * 
     * @return void
     */ 
    public function updatePage($data, $id){
        $entity = array();
        
        isset($data['title']) && $entity['title'] = $data['title'];
        isset($data['templates']) && $entity['templates'] = $data['templates'];
        isset($data['attr']) && $entity['attr'] = $data['attr'];
        isset($data['isvalid']) && $entity['isvalid'] = $data['isvalid'];
        
        $entity['updator'] = $data['creator'];
        $entity['update_date'] = time();
        
        
        $this->update($entity, array('id'=> intval($id)));
    }

}