<?php

namespace Common\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 标签
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Tag extends Model {
	/**
	 * 获取指定标签的ID
	 * 
	 * 如果标签不存在，则先插入
	 * @param string $tag_name
	 * @return number
	 */
	public function getTagId($tag_name){
		$tag = $this->load(array('name'=>$tag_name));
		if (is_null($tag)){
			$data = array();
			$data['name'] = $tag_name;
			$data['isvalid'] = 1;
			$data['create_time'] = time();
			
			return $this->save($data);
		}
		return $tag['id'];
	}	

	/**
	 * 获取指定文章的标签
	 */ 
	public function getTagsByArtId($id){
		$sql = "SELECT * FROM `" . $this->getTableName() . "` WHERE id in (SELECT tag_id FROM `" . $this->getTableName('article_tag') . "` WHERE article_id='" . intval($id) . "' )";
        return $this->query($sql);
	}
}
