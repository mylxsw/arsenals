<?php

namespace Common\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 导航分类
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Navigator extends Model {
	/**
	 * 添加导航
	 */ 
	public function addNav(array $data){
		$entity = array();
		$entity['name'] = $data['name'];
		$entity['url'] = $data['url'];
		$entity['isvalid'] = $data['isvalid'];
		$entity['sort'] = $data['sort'];
		$entity['pos'] = strtolower($data['pos']);

		if($data['pid'] != 0){
			$pnav = $this->load(array('id'=> $data['pid'], 'pid'=> 0, 'pos' => $entity['pos']));
			if (is_null($pnav)) {
				throw new \Arsenals\Core\Exceptions\NoRecoredException('上级菜单不存在！');
			}
		}
		$entity['pid'] = $data['pid'];

		return $this->save($entity);
	}
	/**
	 * 更新导航
	 */ 
	public function updateNav(array $data, $id){
		$entity = array();
		$entity['name'] = $data['name'];
		$entity['url'] = $data['url'];
		$entity['isvalid'] = $data['isvalid'];
		$entity['sort'] = $data['sort'];
		$entity['pos'] = strtolower($data['pos']);

		if($data['pid'] != 0){
			$pnav = $this->load(array('id'=> $data['pid'], 'pid'=> 0, 'pos'=> $entity['pos']));
			if (is_null($pnav)) {
				throw new \Arsenals\Core\Exceptions\NoRecoredException('上级菜单不存在！');
			}
			if ($data['pid'] == $id) {
				throw new \Arsenals\Core\Exceptions\QueryException('上级菜单不能是菜单本身!');
			}
		}
		$entity['pid'] = $data['pid'];

		return $this->update($entity, array('id'=>$id));
	}
	/**
	 * 批量删除导航
	 */ 
	public function delNavs(array $ids){
		foreach ($ids as $id) {
			$this->delNav(intval($id));
		}
	}
	/**
	 * 删除单个导航
	 */ 
	public function delNav($id){
		$nav = $this->load(array('id'=> $id));
		if(is_null($nav)){
			$this->noRecoredException('没有查找到要删除的记录!');
		}
		if ($nav['pid'] == 0) {
			$sub_navs = $this->find(array('pid'=>$nav['id']));
			if(!is_null($sub_navs) && count($sub_navs) > 0){
				$this->queryException('导航含有子导航，请先手动删除子导航之后在进行操作!');
			}
		}
		$this->delete(array('id'=>$id));
	}
	/**
	 * 根据条件列出导航
	 * @param unknown $condition
	 * @return Ambigous <multitype:, multitype:multitype: , unknown>
	 */
	public function listByCondition(array $condition ){
		$sql = "SELECT * FROM `" . $this->getTableName() . "` WHERE ";
		$sql .= $this->_init_conditions_no_prepare($condition);
		$sql .= " ORDER BY pos DESC, pid ASC, sort DESC";
		
		return $this->query($sql);
	}
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
				'isvalid' => 1
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
