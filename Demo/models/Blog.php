<?php
namespace Demo\models;

use Arsenals\Core\Abstracts\Model;
/**
 * 
 * 博客模型
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Blog extends Model  {
	
	public function getAllArticles($category){
		return $this->find(array('category_id'=> intval($category)));
	}
	
	public function getNewBlogInCategory($category, $count = 1){
		if (!is_array($category)) {
			$category = array($category);
		}
		$sql = "SELECT * FROM " . $this->_table_name . " WHERE category_id in (";
		foreach ($category as $k){
			$sql .= '? ,';
		}
		$sql = rtrim($sql, ',') . ') ORDER BY blog_date DESC LIMIT ' . intval($count);
		
		return $this->query($sql, $category);
	}

}
