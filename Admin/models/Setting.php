<?php

namespace Admin\models;

/**
 *
 * @author guan
 *        
 */
class Setting extends AdvanceModel {
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
