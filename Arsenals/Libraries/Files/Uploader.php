<?php
namespace Arsenals\Libraries\Files;
/**
 * 文件上传类
 * 
 * @author  管宜尧<mylxsw@126.com>
 * 
 */ 
class Uploader{
	/**
	 * @var 最大上传文件大小
	 */ 
	private $max_upload_size = 2;

	/**
	 * @var 允许上传的文件类型
	 */ 
	private $allowed_ext = array('jpg', 'gif', 'png', 'bmp', 'jpeg');

	public function __construct(array $configs = array()){
		foreach ($configs as $key => $value) {
			$this->$key = $value;
		}
	}

	public function upload($field, $dest_filename){

		// 检查文件是否存在
		if(!\Arsenals\Core\file_exists($_FILES[$field]['tmp_name'])){
			throw new \Arsenals\Core\Exceptions\FileInvalidException('上传文件不存在！');
		}

		// 检查是否是上传文件
		if(!\is_uploaded_file($_FILES[$field]['tmp_name'])){
			throw new \Arsenals\Core\Exceptions\FileInvalidException('不是合法的上传文件！');
		}

		// 检查文件大小是否合法
		$size = \filesize($_FILES[$field]['tmp_name']) / 1048576;// bytes->M
		if($size > $this->max_upload_size){
			throw new \Arsenals\Core\Exceptions\FileInvalidException("上传文件不能大于{$this->max_upload_size} M！");
		}

		// 检查文件类型是否合法
		$extension = strtolower(trim(strrchr($_FILES[$field]['name'], '.'), '.'));
		if (!in_array($extension, $this->allowed_ext)) {
			throw new \Arsenals\Core\Exceptions\FileInvalidException("不允许的上传文件类型！");
		}

		// 完成文件上传
		return \Arsenals\Core\move_uploaded_file($_FILES[$field]['tmp_name'], $dest_filename);
	}
}