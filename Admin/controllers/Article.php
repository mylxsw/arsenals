<?php

namespace Admin\controllers;

use Arsenals\Core\Session;
use Admin\utils\Ajax;
/**
 *
 * @author guan
 *        
 */
class Article extends CoreController {
	/**
	 * 文章发布页面
	 */
	public function write(){
		$this->assign('categorys', $this->model('Category')->lists());
		$this->assign('tags', $this->model('Tag')->lists());
		
		return $this->view('article/write');
	}
    private function _imageUpload($field){
        if(isset($_FILES[$field]) && $_FILES[$field]['error'] == 0){
            if ((($_FILES[$field]["type"] == "image/gif")
                || ($_FILES[$field]["type"] == "image/jpeg")
                || ($_FILES[$field]["type"] == "image/pjpeg"))
                && ($_FILES[$field]["size"] < 1000000)) {
                if ($_FILES[$field]["error"] > 0) {
                    throw new \Common\FileUploadException("错误: " . $_FILES[$field]["error"]);
                } else {
                    $dest_file = 'Resources/uploads/' . md5($_FILES[$field]['name'] . time()) . '.' 
                        . substr($_FILES[$field]['name'], strrpos($_FILES[$field]['name'], '.') + 1);
                    move_uploaded_file($_FILES[$field]['tmp_name'], BASE_PATH . $dest_file);

                    return $dest_file;
                }
            } else {
                throw new \Common\FileUploadException("错误: 文件不合法");
            }
        }
        return '';
    }
	/**
	 * 文章发布提交
	 * @return \Arsenals\Core\Views\Ajax
	 */
	public function writePost(){
        $user = Session::get('user');
        $data = array();
        // 处理文件上传
        $data['feature_img'] = $this->_imageUpload('feature_img');

        // 处理表单
		$data['title'] = $this->post('blog_title', null, 'required|len:1,100');
		$data['content'] = $this->post('blog_textarea', null, 'len:0,80000');
		$data['intro'] = $this->post('intro', null, 'len:0, 500');
		$data['tag'] = $this->post('tag', null);
		$data['category_id'] = $this->post('category_id', 'required');
		$data['author'] = $user['username'];
		
		$this->model('Article')->addArticle($data);
		
		return Ajax::ajaxReturn('保存成功！', Ajax::SUCCESS);
	}
	/**
	 * 文章分类列表页面
	 */
	public function category(){
		$categoryModel = $this->model('Category');
		$this->assign('categories', $categoryModel->lists(null));
		return $this->view('article/category');
	}
	/**
	 * 添加分类页面
	 */
	public function categoryAdd(){
		return $this->view('article/category_add');
	}
    /**
     * 添加分类页面保存
     */ 
    public function categoryAddPost(){
        $data = array();
        $data['name'] = $this->post('name', null, 'len:1,100|required');
        $data['isvalid'] = 1;
        
        $categoryModel = $this->model('Category');
        $categoryModel->addCategory($data);
        
        return Ajax::ajaxReturn('添加成功！', Ajax::SUCCESS);
    }
    /**
	 * 编辑分类页面
     */
    public function categoryEdit(){
    	$id = $this->get('id', null, 'required|int');

    	$categoryModel = $this->model('Category');
    	$this->assign('cat', $categoryModel->load(array('id'=>$id)));

    	return $this->view('article/category_edit');
    }
    /**
     * 编辑分类保存
     */
    public function categoryEditPost(){
    	$data = array();
    	$data['name'] = $this->post('name', null, 'len:1, 100|required');

    	$categoryModel = $this->model('Category');
    	$categoryModel->updateCate($data, $this->post('id', null , 'required|int'));

    	return Ajax::ajaxReturn('修改成功！', Ajax::SUCCESS);
    }
    /**
     * 删除分类
     */
    public function categoryDel(){
    	$ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
    	$ids_array = preg_split('/,/', $ids);

    	$categoryModel = $this->model('Category');
    	$categoryModel->delCategroy($ids_array);

    	return Ajax::ajaxReturn('删除成功!', Ajax::SUCCESS);
    }
    /**
     * 归档列表
     */
    public function lists(){
    	$cat = $this->get('cat', null, 'int');
        $p = $this->get('p', 1, 'int');
        
        $articleModel = $this->model('Article');
        $this->assign('articles', $articleModel->getAllArticles($p, $cat));
    	
        $this->assign('p', $p);
        $this->assign('cat', $cat);
        return $this->view('article/list');
    }

    public function temp(){
        return $this->view('article/temp');
    }
    /**
     * 删除文章
     */ 
    public function del(){
        $ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
        $ids_array = preg_split('/,/', $ids);

        $articleModel = $this->model('Article');
        $articleModel->deleteArticle($ids_array);

        return Ajax::ajaxReturn('删除成功!', Ajax::SUCCESS);
    }

    public function edit(){
        $id = $this->get('id', null, 'int|required');

        $articleModel = $this->model('Article');
        $this->assign('art', $articleModel->load(array('id' => $id)));
        
        $this->assign('categorys', $this->model('Category')->lists());
        $this->assign('tags', $this->model('Tag')->lists());

        return $this->view('article/edit');
    }

    public function editPost(){
        $user = Session::get('user');
        
        $data = array();
        
        $data['feature_img'] = $this->_imageUpload('feature_img');

        $data['title'] = $this->post('blog_title', null, 'required|len:1,100');
        $data['content'] = $this->post('blog_textarea', null, 'len:0,80000');
        $data['intro'] = $this->post('intro', null, 'len:0, 500');
        $data['tag'] = $this->post('tag', null);
        $data['category_id'] = $this->post('category_id', 'required');
        //$data['author'] = $user['username'];
        $data['updator'] = $user['username'];
        //
        $id = $this->post('id', null, 'required|int');
        
        $this->model('Article')->updateArticle($data, $id);
        
        return Ajax::ajaxReturn('修改成功！', Ajax::SUCCESS);
    }
}