<?php

namespace Common\models;

use Arsenals\Core\Abstracts\Model;
use Arsenals\Core\Exceptions\NoRecoredException;
use Arsenals\Core\Registry;
/**
 * 文章模型
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Article extends Model {
	/**
	 * 查询单篇文章
	 * @param number $id
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
	public function getAllArticles($p = 1, $cat = null){
		if (!is_null($cat) && $cat > 0){
			return $this->getAllArticlesInCate($cat, $p);
		}
		
		$sql = "SELECT * FROM `" . $this->getTableName() . "` ORDER BY PUBLISH_DATE DESC";
		return array(
			'data' => $this->select($sql, array(), $p),
			'total' => $this->getPageRecordCounts(),
			'page' => $this->getPageCounts()
			);
	}
	/**
	 * 查询所有文章(分类下)
	 * @param unknown $category
	 * @return NULL
	 */
	public function getAllArticlesInCate($category, $p = 1){
		if (!is_array($category)) {
			$category = array($category);
		}
		$sql = "SELECT * FROM " . $this->getTableName() . " WHERE id in (";
		$sql .= "SELECT DISTINCT A.ARTICLE_ID FROM " . $this->getTableName('article_category') . " AS A WHERE A.CATEGORY_ID IN (";
		foreach ($category as $k){
			$sql .= intval($k) . ' ,';
		}
		$sql = rtrim($sql, ',') . ")) ORDER BY PUBLISH_DATE DESC";
		return array(
			'data' => $this->select($sql, array(), $p),
			'total' => $this->getPageRecordCounts(),
			'page'	=> $this->getPageCounts()
		);
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
		$sql .= "SELECT DISTINCT A.ARTICLE_ID FROM " . $this->getTableName('article_category') . " AS A WHERE A.CATEGORY_ID in (";
		foreach ($category as $k){
			$sql .= intval($k) . ' ,';
		}
		$sql = rtrim($sql, ',') . ')) ORDER BY PUBLISH_DATE DESC LIMIT ' . intval($count);
		
		return $this->query($sql);
	}
	/**
	 * 删除文章
	 * @param number $id
	 */
	public function deleteArticle($id){
		 if(!is_array($id)){
            $id = array($id);
        }
        foreach($id as $i){
            $this->delArtToCateMapByArtId($i);
			$this->delArtToTagMapByArtId($i);
			$this->delete(array('id' => $i));
        }
	}
	/**
	 * 根据文章id删除文章分类关联
	 * @param number $article_id
	 */
	public function delArtToCateMapByArtId($article_id){
		$this->delete(array('article_id'=>$article_id), 'article_category');
	}
	/**
	 * 根据文章id删除标签关联
	 * @param unknown $article_id
	 */
	public function delArtToTagMapByArtId($article_id){
		$this->delete(array('article_id'=>$article_id), 'article_tag');
	}
	/**
	 * 添加文章
	 * @param unknown $data
	 */
	public function addArticle($data){
		// 保存文章信息
		$save_data['isvalid'] = 1;
		$save_data['title'] = $data['title'];
		$save_data['content'] = $data['content'];
		$save_data['intro'] = $data['intro'];
		$save_data['author'] = $data['author'];
		$save_data['creator'] = $data['author'];
		$save_data['publish_date'] = time();
		$save_data['feature_img'] = $data['feature_img'];
		
		$article_id = $this->save($save_data);
		// 保存分类信息
		$this->mapArtToCate($article_id, $data['category_id']);
		// 保存标签信息
		$this->mapArtToTags($article_id, $data['tag']);
	}
	public function updateArticle($data, $id){
		$id = intval($id);
		// 保存文章信息
		//$save_data['isvalid'] = 1;
		$save_data['title'] = $data['title'];
		$save_data['content'] = $data['content'];
		$save_data['intro'] = $data['intro'];
		//$save_data['author'] = $data['author'];
		//$save_data['creator'] = $data['author'];
		//$save_data['publish_date'] = time();
		$save_data['updator'] = $data['updator'];
		$save_data['update_date'] = time();
		isset($data['feature_img']) && $data['feature_img'] != '' && $save_data['feature_img'] = $data['feature_img'];

		$this->update($save_data, array('id'=>$id));
		// 保存分类信息
		$this->mapArtToCate($id, $data['category_id']);
		// 保存标签信息
		$this->mapArtToTags($id, $data['tag']);
	}
    /**
     * 从指定分类删除指定文章
     * @param int $art_id
     * @param int $cat_id
     * 
     * @return void
     */ 
    public function removeArtFromCate($art_id, $cat_id){
        $art_id = intval($art_id);
        $cat_id = intval($cat_id);
        
        $this->delete(array('category_id' => $cat_id, 'article_id'=> $art_id ), 'article_category');
    }


	/**
	 * 添加文章到分类的关联
	 * @param number $article_id
	 * @param number|array $category_id
	 * @param number $sort
	 * @param number $is_main
	 */
	public function mapArtToCate($article_id, $category_id, $sort = 0, $is_main = 0){
		$data = array();
		$data['article_id'] = $article_id;
		$data['sort'] = 0;
		$data['is_main'] = 0;
		
		// 删除文章所有分类关联
		$sql = "DELETE FROM `" . $this->getTableName('article_category') . "` WHERE article_id='" . intval($article_id) . "'";
		$this->query($sql, null, true);
		
		// 重新添加关联
		if(!is_array($category_id)){
			$category_id = array($category_id);
		}
		foreach ($category_id as $cate_id) {
			$data['category_id'] = $cate_id;
			if(is_null($this->load($data, 'article_category'))){
				$this->save($data, 'article_category');
			}
		}
		
	}
	/**
	 * 添加文章到标签的关联
	 * @param number $article_id
	 * @param string $tags
	 */
	public function mapArtToTags($article_id, $tags){
		// 分割标签
		$tags_array = explode(',', trim(str_replace(' ', '', $tags), ','));
		
		$tagModel = Registry::load('\\Common\\models\\Tag');
		// 遍历所有标签并插入
		foreach ($tags_array as $tag){
			$data = array();
			
			$data['article_id'] = $article_id;
			$data['tag_id'] = $tagModel->getTagId($tag);
			// 如果不存在标签文章对应关系， 则插入
			if (is_null($this->load($data, 'article_tag'))){
				$this->save($data, 'article_tag');
			}
		}
	}
}