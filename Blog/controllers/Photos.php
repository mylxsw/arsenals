<?php
namespace Blog\controllers;


class Photos extends CoreController {
    public function lists(){
        $tag = $this->get('tag', null, 'tag');
        $p = $this->get('p', 1, 'int');

        $photosModel = $this->model('Photos');
        $photo = $photosModel->getAllPhotos($p, $tag);
        $this->assign('photos', $photo);

        $this->assign('p', $p);
        $this->assign('tag', $tag);
        $this->assign('p', $p);
        $this->assign('_page_title', '照片库');
        $this->assign('current_nav', "photos.html");

        return $this->view('photos/list');
    }

    public function show($id){

        $id = (isset($id) && !is_null($id) && $id != '') ? intval($id) : $this->get('id', null, 'int|required');

        $photoModel = $this->model('Photos');
        $photo = $photoModel->getPhotoPackage($id);
        $this->assign('photo', $photo);

        $this->assign('id', $id);
        $this->assign('breadcrumbs', array('首页'=>'', '照片库' => 'photos.html', $photo['title']=> "photos/{$photo['id']}.html"));
        $this->assign('current_nav', "photos.html");

        $this->assign('_page_title', $photo['title']);
        return $this->view('photos/show');
    }
} 