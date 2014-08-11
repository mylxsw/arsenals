<?php
namespace Common\models;

use Arsenals\Core\Abstracts\Model;

/**
 * 文档模型
 * 
 * @author mylxsw<mylxsw@126.com>
 * 
 */  
class Document extends Model{
	/**
	 * 添加模型
	 */  
	public function addModel(Array $data){
		$entity = array();
		$entity['model_name'] = $data['model_name'];
		$entity['tpl_show'] = $data['tpl_show'];
		$entity['tpl_edit'] = $data['tpl_edit'];
		$entity['setting'] = $data['setting'];
		$entity['intro'] = $data['intro'];
		$entity['isvalid'] = $data['isvalid'];

		return $this->save($entity);
	}
	/**
	 * 更新模型
	 */ 
	public function updateModel(Array $data, $id){
		$entity = array();
		isset($data['model_name']) && $entity['model_name'] = $data['model_name'];
		isset($data['tpl_show']) && $entity['tpl_show'] = $data['tpl_show'];
		isset($data['tpl_edit']) && $entity['tpl_edit'] = $data['tpl_edit'];
		isset($data['setting']) && $entity['setting'] = $data['setting'];
		isset($data['intro']) && $entity['intro'] = $data['intro'];
		isset($data['isvalid']) && $entity['isvalid'] = $data['isvalid'];

		$this->update($entity, array('id'=> intval($id)));
	}
	/**
	 * 删除模型
	 */ 
	public function delModel($id){
		if(!is_array($id)){
            $id = array($id);
        }
        $this->checkModelHasRef($id);
        foreach($id as $i){
            $this->delete(array('id'=>$i));
        }
	}
	/**
	 * 检查其它表是否有对模型的引用
	 */ 
	public function checkModelHasRef($id){
		if(!is_array($id)){
			$id = array($id);
		}

		$ids = implode(',', array_map(function($val){
			return intval($val);
		}, $id));

		$sql = "select count(*) c from " . $this->getTableName('article') . " where model in (" . $ids . ")";
		$res = $this->query($sql);
		
		if($res[0]['c'] > 0){
			$this->queryException('部分或全部模型已经被引用，请先删除引用后在执行该操作！');
		}
	}
}