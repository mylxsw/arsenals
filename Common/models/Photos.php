<?php
namespace Common\models;

use Arsenals\Core\Abstracts\Model;

/**
 * 照片库
 *
 * @package Common\models
 */
class Photos extends Model {
    /**
     * 添加照片包
     * @param array $data
     */
    public function addPhotosPackage(array $data){
        $entity = array();
        $entity['title'] = $data['title'];
        $entity['intro'] = $data['intro'];
        $entity['url'] = '#';
        $tag = trim(trim($data['tags']), ',');
        $tag_arr = explode(',', $tag);
        foreach($tag_arr as $k=>$v){
            $tag_arr[$k] = trim($v);
        }
        $tag = ',' . implode(',', $tag_arr) . ',';
        $entity['tag'] = $tag;
        $entity['isvalid'] = 1;
        $entity['create_time'] = time();
        $entity['pid'] = 0;
        $entity['url'] = isset($data['images']) && count($data['images']) > 0 ? $data['images'][0][0] : '';

        // 创建照片库
        $package_id = $this->save($entity);

        // 创建照片库下的照片
        if(is_array($data['images']) && count($data['images']) > 0){
            foreach($data['images'] as $k=>$v){
                $_ent = array();
                $_ent['title'] = '';
                $_ent['intro'] = $v[1];
                $_ent['url'] = $v[0];
                $_ent['create_time'] = time();
                $_ent['isvalid'] = 1;
                $_ent['pid'] = $package_id;

                $this->save($_ent);
            }
        }
        return $package_id;
    }

    /**
     * 保存对照片库的修改
     *
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function savePhotosPackage(array $data, $id){
        $entity = array();
        $entity['title'] = $data['title'];
        $entity['intro'] = $data['intro'];
        $tag = trim(trim($data['tags']), ',');
        $tag_arr = explode(',', $tag);
        foreach($tag_arr as $k=>$v){
            $tag_arr[$k] = trim($v);
        }
        $tag = ',' . implode(',', $tag_arr) . ',';
        $entity['tag'] = $tag;
        $entity['isvalid'] = 1;
        $entity['update_time'] = time();
        $entity['url'] = isset($data['images']) && count($data['images']) > 0 ? $data['images'][0][0] : '';

        $this->update($entity,array('id'=>$id));

        $this->delete(array('pid'=>$id));

        if(is_array($data['images']) && count($data['images']) > 0){
            foreach($data['images'] as $k=>$v){
                $_ent = array();
                $_ent['title'] = '';
                $_ent['intro'] = $v[1];
                $_ent['url'] = $v[0];
                $_ent['update_time'] = time();
                $_ent['isvalid'] = 1;
                $_ent['pid'] = $id;

                $this->save($_ent);
            }
        }
        return $id;
    }

    /**
     * 删除照片库
     *
     * @param $id
     */
    public function del($id){
        if(!is_array($id)){
            $id = array($id);
        }
        foreach($id as $i){
            // 删除照片库下所有的照片
            $this->delete(array('pid'=>$i));
            // 删除照片库
            $this->delete(array('id'=>$i));
        }
    }

    /**
     * 查询照片包
     *
     * @param $id
     * @return null|object
     */
    public function getPhotoPackage($id){
        $package = $this->load(array('id'=>$id, 'pid'=>0));
        if(is_null($package)){
            return null;
        }

        $subs = $this->find(array('pid'=>$package['id']), 'id asc');
        if(!is_array($subs) || count($subs) == 0){
            $subs = array();
        }
        $package['images'] = $subs;

        return $package;
    }

    /**
     * 获取所有的照片库
     *
     * @param int $p
     * @param null $tag
     * @param string $keyword
     * @param int $per_nums
     * @return array
     */
    public function getAllPhotos($p = 1, $tag = null, $keyword = '', $per_nums = 15){
		
        $condition = ' WHERE pid=0 ';
        
        if(!is_null($tag) && $tag != '' && strlen($tag) > 1){
        	$condition .= " and `tag` like '%," . $this->escape($tag) . ",%' ";
        }

        if($keyword != '' && strlen($keyword) > 2){
        	$condition .= " and `title` like '%" . $this->escape($keyword) . "%' ";
        }

        $sql = " FROM `" . $this->getTableName() . "` t {$condition} ORDER BY CREATE_TIME DESC";
		//echo $sql;
		//$sql = "SELECT t.*, (select count(m.*) from `ar_photos` m where m.pid=t.id) as c FROM `ar_photos` t WHERE pid=0 ORDER BY CREATE_TIME DESC";
		return array(
			'data' => $this->_select("SELECT t.*, (select count(*) from `" . $this->getTableName() . "` m where m.pid=t.id) as c ", $sql, array(), $p, $per_nums),
			'total' => $this->getPageRecordCounts(),
			'page' => $this->getPageCounts()
			);
	}

    /**
     * 查询照片
     *
     * @param $sql_res
     * @param $sql
     * @param array $args
     * @param bool $index
     * @param int $per
     * @return mixed
     */
    private function _select($sql_res, $sql, $args = array(), $index = FALSE, $per = 15){
		if($index === FALSE){
			return $this->_conn->query($sql_res . $sql, $args );
		}
		$sql = trim($sql);
		$index = intval($index);
		$per = intval($per);
	
		// 分页查询
		// 首先查询出总记录数量
		$count_res = $this->_conn->query( 'SELECT COUNT(*) AS C ' . substr($sql, strpos(strtoupper($sql), ' FROM ')), $args);
		$this->page_record_counts = $count_res[0]['C'];
		// 总页数
		$this->page_counts = $this->page_record_counts / $per + 1;
		// 判断当前页码是否正确
		if($index <= 0 || $index > $this->page_counts){
			$index = 1;
		}
		$sql .= ' LIMIT ' . ($index - 1) * $per . ', ' . $per;
		
		return $this->_conn->query($sql_res . $sql, $args);
	}
}