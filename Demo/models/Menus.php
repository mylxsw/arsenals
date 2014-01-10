<?php

namespace Demo\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 菜单模型
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Menus extends Model {
	
	public function getMenusTree($top_id, $menu_type, $level = 3){
		$top_menus_list = $this->find(array(
			'menu_pid'  => $top_id,
			'menu_type'	=> $menu_type,
		), 'menu_sort ASC');
			
		$level --;
			
		$menus = array();
		if($level > 0){
			foreach ($top_menus_list as $k=>$v){
				array_push($menus, $v);
				$res = $this->getMenusTree($v['id'],$menu_type, $level);
				if(count($res) > 0){
					$menus[$k]['sub'] = $res;
				}
			}
		}
			
		return $menus;
	}
}

