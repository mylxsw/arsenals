<?php

namespace Demo\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 导航分类
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Navigator extends Model {
	/**
	 * 递归获取导航树
	 * @param number $top_id 导航顶级id
	 * @param string $nav_pos 导航位置
	 * @param number $level 最大查询级别
	 * @return array
	 */
	public function getNavTrees($top_id, $nav_pos, $level = 3){
		$top_menus_list = $this->find(array(
				'pid'  => $top_id,
				'pos'	=> $nav_pos,
		), 'sort DESC');
			
		$level --;
			
		$menus = array();
		if($level > 0){
			foreach ($top_menus_list as $k=>$v){
				array_push($menus, $v);
				$res = $this->getNavTrees($v['id'],$nav_pos, $level);
				if(count($res) > 0){
					$menus[$k]['sub'] = $res;
				}
			}
		}
			
		return $menus;
	}

}
