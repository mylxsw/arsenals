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
	 * 文章发布页面 Markdown
	 */
	public function writeMarkdown(){
		$this->assign('categorys', $this->model('Category')->lists());
		$this->assign('tags', $this->model('Tag')->lists());
		
		return $this->view('article/write-markdown');
	}
	/**
	 * 文章发布页面
	 */
	public function write(){
		$this->assign('categorys', $this->model('Category')->lists());
		$this->assign('tags', $this->model('Tag')->lists());
		
		return $this->view('article/write');
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
        if($data['feature_img'] == ''){
            $data['feature_img'] = $this->post('feature_img_selected');
        }

        // 处理表单
		$data['title'] = $this->post('blog_title', null, 'required|len:1,100');
		$data['content'] = $this->post('blog_textarea', null, 'len:0,80000');
		$data['intro'] = $this->post('intro', null, 'len:0, 500');
		$data['tag'] = $this->post('tag', null);
		$data['category_id'] = $this->post('category_id', 'required');
		$data['author'] = $user['username'];
        $data['source'] = $this->post('sources', null, 'required|len:1,200');
        $data['model'] = $this->post('model', 'html', 'len:0, 20');
		
		$id = $this->model('Article')->addArticle($data);

        $this->ping($id);

		return Ajax::ajaxReturn('保存成功！', Ajax::SUCCESS);
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
	/**
	 * 编辑文章
	 */
    public function edit(){
        $id = $this->get('id', null, 'int|required');

        $articleModel = $this->model('Article');
        $art = $articleModel->load(array('id' => $id));
        $this->assign('art', $art);
        
        $this->assign('categorys', $this->model('Category')->lists());
        $this->assign('tags', $this->model('Tag')->lists());
		if($art['model'] == 'markdown'){
			return $this->view('article/edit-markdown');
		}
        return $this->view('article/edit');
    }
	/**
	 * 编辑文章Post
	 */
    public function editPost(){
        $user = Session::get('user');
        
        $data = array();
        
        $data['feature_img'] = $this->_imageUpload('feature_img');
		if($data['feature_img'] == ''){
            $data['feature_img'] = $this->post('feature_img_selected', null);
        }
        $data['title'] = $this->post('blog_title', null, 'required|len:1,100');
        $data['content'] = $this->post('blog_textarea', null, 'len:0,80000');
        $data['intro'] = $this->post('intro', null, 'len:0, 500');
        $data['tag'] = $this->post('tag', null);
        $data['category_id'] = $this->post('category_id', 'required');
        //$data['author'] = $user['username'];
        $data['updator'] = $user['username'];
        $data['source'] = $this->post('sources', null, 'required|len:1,200');
        //
        $id = $this->post('id', null, 'required|int');
        
        $this->model('Article')->updateArticle($data, $id);

        $this->ping($id);
        
        return Ajax::ajaxReturn('修改成功！', Ajax::SUCCESS);
    }
    /**
     * 图片封面列表
     */ 
    public function image_covers(){
    	$this->assign('covers', $this->_imageCoverList());
        return $this->view('article/image_cover');
    }
    /**
     * 图片封面
     * @return [type] [description]
     */
    private function _imageCoverList(){
        $file_str = array();
        if(IS_SAE){
            $saeStorage = new \SaeStorage();
            $files = $saeStorage->getListByPath('arsenals', 'cover', 1000 );

            foreach($files['files'] as $k=>$file){
                $file_str[] = $saeStorage->getUrl('arsenals', $file['fullName']);
            }
        }else{

            $handle = \opendir(BASE_PATH . 'Resources/uploads/cover/');
            while ( false !== ( $file = \readdir( $handle ) ) ) {
                if ( $file != '.' && $file != '..' ) {
                    
                    if ( preg_match( "/\.(gif|jpeg|jpg|png|bmp)$/i" , $file ) ) {
                        
                        //!!!此处需要读取配置文件获取网站url并拼接上去
                        $file_str[] = 'Resources/uploads/cover/'. $file;
                    }
                }
            }
        }
        
        return $file_str;
    }
    /**
     * 图片上传
     */
    private function _imageUpload($field){
        if(isset($_FILES[$field]) && $_FILES[$field]['error'] == 0){
            $dest_file = 'cover/' . md5($_FILES[$field]['name'] . time()) . '.' 
                . substr($_FILES[$field]['name'], strrpos($_FILES[$field]['name'], '.') + 1);

            $uploader = \Arsenals\Core\Registry::load('\\Arsenals\\Libraries\\Files\\Uploader');
            $up_status = $uploader->upload($field, IS_SAE ? $dest_file : (BASE_PATH . 'Resources/uploads/' . $dest_file));

            if($up_status === true){
            	return $dest_file;
            }else if($up_status === false){
            	throw new \Common\FileUploadException("文件上传失败!");
            }else{
                if(\is_string($up_status)){
                	return $up_status;
                }
            }
            return $dest_file;
        }
        if (isset($_FILES[$field]) && $_FILES[$field]["error"] > 0) {
            throw new \Common\FileUploadException("错误: " . $_FILES[$field]["error"]);
        }
        return '';
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
	 * 标签列表
	 */    
    public function tags(){
    	$tagModel = $this->model('Tag');
    	$this->assign('tags', $tagModel->lists(null));
    	return $this->view('article/tags');
    }
    /**
     * 添加标签显示
     */
	public function tagAdd(){
		return $this->view('article/tag_add');
	}
	/**
	 * 标签添加提交
	 * Enter description here ...
	 */
    public function tagAddPost(){
        $data = array();
        $data['name'] = $this->post('name', null, 'len:1,100|required');
        $data['isvalid'] = 1;
        
        $categoryModel = $this->model('Tag');
        $categoryModel->addTag($data);
        
        return Ajax::ajaxReturn('添加成功！', Ajax::SUCCESS);
    }
 	/**
 	 * 标签编辑显示
 	 * Enter description here ...
 	 */   
    public function tagEdit(){
    	$id = $this->get('id', null, 'required|int');

    	$tagModel = $this->model('Tag');
    	$this->assign('tag', $tagModel->load(array('id'=>$id)));

    	return $this->view('article/tag_edit');
    }
    /**
     * 编辑标签提交
     */
    public function tagEditPost(){
    	$data = array();
    	$data['name'] = $this->post('name', null, 'len:1, 100|required');

    	$tagModel = $this->model('Tag');
    	$tagModel->updateTag($data, $this->post('id', null , 'required|int'));

    	return Ajax::ajaxReturn('修改成功！', Ajax::SUCCESS);
    }
    /**
     * 删除标签
     */
    public function tagDel(){
    	$ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
    	$ids_array = preg_split('/,/', $ids);

    	$tagModel = $this->model('Tag');
    	$tagModel->delTag($ids_array);

    	return Ajax::ajaxReturn('删除成功!', Ajax::SUCCESS);
    }

    /**
     * Ping
     * @param $id
     * @return \Arsenals\Core\Views\Ajax
     */
    public function ping($id = null){
        if(is_null($id) || $id instanceof \Arsenals\Core\Input){
            $id = $this->get('id', null, 'required|int');
        }

        $baidu = $this->load('\Arsenals\Libraries\Ping\BaiduPing');
        $res = $baidu->ping('AiCode', 'http://aicode.cc', 'http://aicode.cc/article/' . $id . '.html', "");

        if($res){
            return Ajax::success('操作成功!');
        }
        return Ajax::failed('操作失败！');
    }
}