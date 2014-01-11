<?php

namespace Demo\models;

use Arsenals\Core\Abstracts\Model;
use Arsenals\Core\Exceptions\NoRecoredException;
/**
 * 文章模型
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Article extends Model {
	/**
	 * 查询单篇文章
	 * @param int $id
	 * @param boolean $with_cate
	 * @param boolean $with_tag
	 * @throws NoRecoredException
	 * @return array
	 */
	public function getArticleById($id, $with_cate = true, $with_tag = true){
		$id = intval($id);
		$sql = "SELECT * FROM " . $this->getTableName() . " WHERE `id`={$id}";
		$res = $this->query($sql);
		if(count($res)  == 0){
			throw new NoRecoredException('文章不存在！');
		}
		if($with_cate){
			$sql_cate = "SELECT * FROM " . $this->getTableName('article_category') . " AS r LEFT JOIN " . $this->getTableName('category') . " AS c ON r.category_id=c.id WHERE r.article_id={$id} ORDER BY r.IS_MAIN DESC";
			$res[0]['cate'] = $this->query($sql_cate);
		}
		if($with_tag){
			$sql_tag = "SELECT * FROM " . $this->getTableName('tag') . " WHERE id in (";
			$sql_tag .= " SELECT R.TAG_ID FROM " . $this->getTableName('article_tag') . " AS R WHERE R.`article_id`={$id}) ";
			$res[0]['tag'] = $this->query($sql_tag);
		}
		return $res[0];
	}
	
	/**
	 * 查询所有文章
	 * @param unknown $category
	 * @return NULL
	 */
	public function getAllArticles($category, $p = 1){
		if (!is_array($category)) {
			$category = array($category);
		}
		$sql = "SELECT * FROM " . $this->getTableName() . " WHERE id in (";
		$sql .= "SELECT DISTINCT A.ID FROM " . $this->getTableName('article_category') . " AS A WHERE A.CATEGORY_ID IN (";
		foreach ($category as $k){
			$sql .= intval($k) . ' ,';
		}
		$sql = rtrim($sql, ',') . ")) ORDER BY PUBLISH_DATE DESC";
		
		return $this->select($sql, array(), $p);
	}
	/**
	 * 查询指定数量指定分类下的最新文章
	 * @param array|number $category
	 * @param number $count
	 * @return array
	 */
	public function getNewArticlesInCategory($category, $count = 1){
		if (!is_array($category)) {
			$category = array($category);
		}
		$sql = "SELECT * FROM " . $this->getTableName() . " WHERE id in (";
		$sql .= "SELECT DISTINCT A.ID FROM " . $this->getTableName('article_category') . " AS A WHERE A.CATEGORY_ID in (";
		foreach ($category as $k){
			$sql .= intval($k) . ' ,';
		}
		$sql = rtrim($sql, ',') . ')) ORDER BY PUBLISH_DATE DESC LIMIT ' . intval($count);
	
		return $this->query($sql);
	}
}
