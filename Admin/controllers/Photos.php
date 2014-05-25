<?php
namespace Admin\controllers;

use Arsenals\Core\Session;
use Admin\utils\Ajax;
use Arsenals\Libraries\Images\ImageUtils;


/**
 * 相册控制器
 * 
 * @author
 * 
 */ 
class Photos extends CoreController{
	/**
	 * 图片列表
	 */ 
	public function lists(){
		$tag = $this->get('tag', null, 'tag');
        $p = $this->get('p', 1, 'int');
        
        $photosModel = $this->model('Photos');
        $this->assign('photos', $photosModel->getAllPhotos($p, $tag));
    	
        $this->assign('p', $p);
        $this->assign('tag', $tag);

        return $this->view('photos/lists');
	}
    /**
     * 添加图片
     */ 
    public function add(){
        $this->_init_tags();
        return $this->view('photos/add');
    }

    /**
     * 初始化图片标签列表
     */
    private function _init_tags(){
        $tags = $this->model('Setting')->getSetting('photo_tags', 'dlroom');
        if(is_null($tags)){
            $this->assign('tags', array());
            return ;
        }
        $result = explode(',', str_replace(' ', '', $tags['setting_value']));
        $this->assign('tags', $result);
    }
    /**
     * 添加图片提交
     * @return string
     */
    public function addPost(){

        $data = array();
        $data['title'] = $this->post('title', '', 'required|len:1,200');
        $data['tags'] = $this->post('tags', '', 'len:0,255');
        $data['intro'] = $this->post('intro', '', 'len:0,1000');

        $data['images'] = array();
        $images = $this->post('image');
        $intros = $this->post('image_intro');

        if(is_array($images) && count($images) > 0){
            foreach($images as $k=>$v){
                $data['images'][] = array($images[$k], $intros[$k]);
            }
        }

        $photosModel = $this->model('Photos');
        $photosModel->addPhotosPackage($data);

        return Ajax::success('添加成功！');
    }

    /**
     * 编辑照片库
     */
    public function edit(){
        $id = $this->get('id', null, 'required|int');

        $photoModel = $this->model('Photos');
        $this->assign('photo', $photoModel->getPhotoPackage($id));

        $this->_init_tags();

        return $this->view('photos/edit');
    }

    /**
     * 编辑照片库POST
     */
    public function editPost(){
        $data = array();
        $data['title'] = $this->post('title', '', 'required|len:1,200');
        $data['tags'] = $this->post('tags', '', 'len:0,255');
        $data['intro'] = $this->post('intro', '', 'len:0,1000');

        $data['images'] = array();
        $images = $this->post('image');
        $intros = $this->post('image_intro');

        if(is_array($images) && count($images) > 0){
            foreach($images as $k=>$v){
                $data['images'][] = array($images[$k], $intros[$k]);
            }
        }

        $photosModel = $this->model('Photos');
        $photosModel->savePhotosPackage($data, $this->post('id', null, 'required|int'));

        return Ajax::success('操作成功！');
    }

    /**
     * 删除照片库
     */
    public function del(){
        $ids = str_replace(' ', '', $this->post('ids', null, 'required|len:1,100'));
        $ids_array = preg_split('/,/', $ids);

        $photoModel = $this->model('Photos');
        $photoModel->del($ids_array);

        return Ajax::success('操作成功！');
    }

    /**
     * 上传图片
     */
    public function upload(){
        // 生成文件签名，检查文件是否已经上传过了
        $file_sig = md5_file($_FILES['upload_file']['tmp_name']);
        $uploaded_file = $this->model('Upload')->getFileBySig($file_sig);
        $up_status = '';
        if(!is_null($uploaded_file) && is_array($uploaded_file)){
            $up_status = $uploaded_file['url'];
        }else{
            // 生成保存的文件名
            $file_name = md5($_FILES['upload_file']['name'] . time()) . '.'
                . substr($_FILES['upload_file']['name'], strrpos($_FILES['upload_file']['name'], '.') + 1);
            // 创建原始图片存储目录
            \Arsenals\Core\create_dir('Resources/uploads/photos/');
            $dest_file = 'photos/' . $file_name;

            // 上传原始图片
            $uploader = $this->load('\Arsenals\Libraries\Files\Uploader');
            $up_status = $uploader->upload('upload_file', IS_SAE ? $dest_file : ('Resources/uploads/' . $dest_file));

            // 创建图片缩略图（小图）
            \Arsenals\Core\create_dir('Resources/uploads/photos/thumb_small');

            ob_start();
            ImageUtils::thumb($up_status, 300, 300);
            $content = ob_get_contents();
            ob_end_clean();

            $small_filename = IS_SAE ? 'photos/thumb_small/' . $file_name :('Resources/uploads/photos/thumb_small/' . $file_name);
            \Arsenals\Core\write_file($small_filename, $content);

            // 创建图片缩略图（大图）
            \Arsenals\Core\create_dir('Resources/uploads/photos/thumb_large');

            ob_start();
            ImageUtils::thumb($up_status, 1000, 1000);
            $content = ob_get_contents();
            ob_end_clean();

            $large_filename = IS_SAE ? 'photos/thumb_large/' . $file_name : ('Resources/uploads/photos/thumb_large/' . $file_name);
            \Arsenals\Core\write_file($large_filename, $content);

        }
        $source_filename = $_FILES['upload_file']['name'];
        $source_filename = substr($source_filename, 0, strrpos($source_filename, '.'));


        // 存储图片元信息
        $meta = array();
        $meta['file_name'] = $source_filename;
        $meta['url'] = $up_status;
        $meta['upload_time'] = time();
        $meta['uploader'] = '';
        $meta['type'] = 'image';
        $meta['file_sig'] = $file_sig;
        list($meta['width'], $meta['height']) = ImageUtils::getImageInfo($up_status);
        $this->model('Upload')->addImage($meta);

        return Ajax::success($up_status, array('filename'=> $source_filename));
    }

    /**
     * 图片管理
     * @return \Arsenals\Core\View\ViewAndModel
     */
    public function manager(){
        $p = $this->get('p', 1, 'int');

        $photos = $this->model('Upload')->getAllImages($p);
        $this->assign('photos', $photos);

        $this->assign('p', $p);
        return $this->view('photos/manager');
    }
}