<?php

namespace Common\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 系统配置
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Setting extends AdvanceModel {
	/**
	 * 添加配置项
	 */ 
	public function addSetting(array $data){
		$entity = array();
		$entity['setting_key'] = $data['setting_key'];
		$entity['setting_value'] = $data['setting_value'];
		$entity['namespace'] = $data['namespace'];
		$entity['isvalid'] = $data['isvalid'];
		$entity['info'] = $data['info'];
		$entity['isserialise'] = $data['isserialise'];

		return $this->save($entity);
	}

	public function updateSetting(array $data, $id){
		$entity = array();
		$entity['setting_key'] = $data['setting_key'];
		$entity['setting_value'] = $data['setting_value'];
		$entity['namespace'] = $data['namespace'];
		$entity['isvalid'] = $data['isvalid'];
		$entity['info'] = $data['info'];
		$entity['isserialise'] = $data['isserialise'];

		$this->update($entity, array('id'=>$id));
	}
	/**
	 * 删除配置
	 */ 
	public function delSetting($id){
		if(!is_array($id)){
            $id = array($id);
        }
        foreach($id as $i){
            $this->delete(array('id'=>$i));
        }
	}
	/**
	 * 根据条件列出
	 * @param unknown $condition
	 * @return Ambigous <multitype:, multitype:multitype: , unknown>
	 */
	public function listByCondition(array $condition = array() ){
		$sql = "SELECT * FROM `" . $this->getTableName() . "` ";
		if(count($condition) > 0){
			$sql .= ' WHERE ' . $this->_init_conditions_no_prepare($condition);
		}
		
		$sql .= " ORDER BY namespace ASC, id ASC";
		
		return $this->query($sql);
	}
	/**
	 * 读取命名空间下的所有配置
	 * @param string $namespace
	 * @return array
	 */
	public function getSettingsByNamespace($namespace){
		$sql = "SELECT * FROM ' . $this->getTableName() 
				. ' WHERE `namespace`='" . $this->escape($namespace) 
				. "' AND `isvalid`=1";
		return $this->query($sql);
	}
	/**
	 * 读取配置项
	 * @param string $key
	 * @param string $namespace
	 * @return array
	 */
	public function getSetting($key, $namespace){
		$sql = "SELECT * FROM " . $this->getTableName() 
			. " WHERE `namespace`='" . $this->escape($namespace) 
			. "' AND `isvalid`=1 AND `setting_key`='" . $this->escape($key) . "'";
		$res = $this->query($sql);
		if(count($res) > 0){
			return $res[0];
		}
		return null;
	}
	public function loadSettings($cont){
		$columns = array('id', 'setting_key', 'namespace', 'info', 'isvalid');
		$indexColumn = 'id';
		return $this->loadDataTable($cont, $columns, $indexColumn, function($columns, $result){
			$output = array();
			foreach ($result as $res){
				$row = array();
				for ( $i=0 ; $i<count($columns) ; $i++ )
				{
					if ( $columns[$i] == "isvalid" )
					{
						$row[] = $res['isvalid'] == '1' ? '可用' : '不可用';
					}
					else if ( $columns[$i] != ' ' )
					{
						/* General output */
						$row[] = $res[$columns[$i]];
					}
				}
				$row[] = '<button><i class="icon-spin"></i></button>';
				$output[] = $row;
			}
			
			return $output;
		});
	}	
}
