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
