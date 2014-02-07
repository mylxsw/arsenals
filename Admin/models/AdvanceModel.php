<?php

namespace Admin\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 高级模型
 * @author guan
 *        
 */
abstract class AdvanceModel extends Model {
	/**
	 * 为DataTable提供数据
	 * @param unknown $cont
	 * @param unknown $columns
	 * @param unknown $indexColumn
	 * @param string $callback
	 * @return multitype:multitype: number unknown mixed Ambigous <multitype:, multitype:multitype: , unknown>
	 */
	protected function loadDataTable($cont, $columns, $indexColumn, $callback = null){
		/* 分页  */
		$limit = '';
		if(isset($cont['iDisplayStart']) && $cont['iDisplayLength'] != '-1'){
			$limit = "LIMIT " . intval($cont['iDisplayStart']) . ', ' . intval($cont['iDisplayLength']);
		}
		/* 排序 */
		$order = '';
		if (isset( $cont['iSortCol_0'] )) {
			$order = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $cont['iSortingCols'] ) ; $i++ ) {
				if ( $cont[ 'bSortable_'.intval($cont['iSortCol_'.$i]) ] == "true" ) {
					$order .= "`".$columns[ intval( $cont['iSortCol_'.$i] ) ]."` ".
							($cont['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
	
			$order = substr_replace( $order, "", -2 );
			if ( $order == "ORDER BY" ) {
				$order = "";
			}
		}
		/* 查询条件 */
		$where = "";
		if ( isset($cont['sSearch']) && $cont['sSearch'] != "" ) {
			$where = "WHERE (";
			for ( $i=0 ; $i<count($columns) ; $i++ ) {
				$where .= "`".$columns[$i]."` LIKE '%".$this->escape( $cont['sSearch'] )."%' OR ";
			}
			$where = substr_replace( $where, "", -3 );
			$where .= ')';
		}
	
		/* 单独的列过滤 */
		for ( $i=0 ; $i<count($columns) ; $i++ ) {
			if ( isset($cont['bSearchable_'.$i]) && $cont['bSearchable_'.$i] == "true" && $cont['sSearch_'.$i] != '' ) {
				if ( $where == "" ) {
					$where = "WHERE ";
				} else {
					$where .= " AND ";
				}
				$where .= "`".$columns[$i]."` LIKE '%".$this->escape($cont['sSearch_'.$i])."%' ";
			}
		}
	
		/* 生成要执行的sql */
		$sql = "SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $columns))."`
		FROM {$this->getTableName()} {$where} {$order} {$limit} ";
		$result = $this->query($sql);
	
		/* Data set length after filtering */
		$sQuery = "SELECT FOUND_ROWS() c";
		$rResultFilterTotal = $this->query($sQuery);
		$iFilteredTotal = $rResultFilterTotal[0]['c'];

		/* Total data set length */
		 $sQuery = "SELECT COUNT(`".$indexColumn."`) c
		 FROM   {$this->getTableName()} ";
		 $aResultTotal = $this->query($sQuery);
		 $iTotal = $aResultTotal[0]['c'];

		 $output = array(
		 		"sEcho" => intval($_GET['sEcho']),
		 		"iTotalRecords" => $iTotal,
		 		"iTotalDisplayRecords" => $iFilteredTotal,
		 		"aaData" => array()
		 );

		 if ($callback == null){
		 	$output['aaData'] = $result;
		 }else{
		 	$output['aaData'] = call_user_func($callback, $columns, $result);
		 }

		 return $output;
	}	
}
