<?php
namespace Arsenals\Libraries\Images;
/**
 * 图片处理库
 * 
 * @author  管宜尧<mylxsw@126.com>
 * 
 */ 
class ImageUtils{
	private static $_image_type = array(
		'image/jpeg'	=>	'jpeg',
		'image/jpg'		=>	'jpeg',
		'image/png'		=>	'png',
		'image/gif'		=>	'gif',
		'image/bmp'		=>	'bmp'
		);
	/**
	 * 创建水印
	 * 
	 * @param array $config
	 *	'source_file'	=> '', 		原图片
	 *	'watermark'		=> '', 		水印图片
	 *	'pos_x' 		=> '', 		水印左边距（负数为右边距）
	 *	'pos_y'			=> '', 		水印上边距（负数为下边距）
	 *	'dest_file'		=> null, 	目标存储文件
	 *	'alpha'			=> 75  		水印透明度
	 */ 
	public static function watermark(array $config){
		$config = array_merge(array(
			'source_file'	=> '', 
			'watermark'		=> '', 
			'pos_x' 		=> '', 
			'pos_y'			=> '', 
			'dest_file'		=> null, 
			'alpha'			=> 75
			), $config);
		
		list($s_width, $s_height, $s_mime) = self::getImageInfo($config['source_file']);
		list($w_width, $w_height, $w_mime) = self::getImageInfo($config['watermark']);

		$src_image = self::_imageCreateFrom($config['source_file'], $s_mime);
		$watermark = self::_imageCreateFrom($config['watermark'], $w_mime);

		$pos_x = $config['pos_x'] >= 0 ? $config['$pos_x'] : ($s_width + $config['pos_x'] - $w_width);
		$pos_y = $config['pos_y'] >= 0 ? $config['pos_y'] : ($s_height + $config['pos_y'] - $w_height);

		imagecopymerge($src_image, // 原图片
			$watermark, // 水印图片
			$pos_x, // 目标点的X坐标
			$pos_y, // 目标点的Y坐标
			0,  // 水印图的X坐标
			0,  // 水印图的Y坐标
			$w_width, // 水印图的宽度
			$w_height,  // 水印图的高度
			$config['alpha']); // alpha

		self::_imageOutput($src_image, $s_mime);
		
		imagedestroy($src_image);
		imagedestroy($watermark);
	}
	/**
	 * 百分比调整图片尺寸
	 * 
	 * @param  string $source_filename 原文件名
	 * @param  float $percent 调整的百分比
	 * @param  string|null $dest_filename 目标文件名
	 * @param  int $quailty 压缩率
	 */ 
	public static function resizePercent($source_filename, 
		$percent = 0.5,  $dest_filename = null, $quailty = 80){
		// 获取原图片的尺寸
		list($s_width, $s_height, $s_type) = self::getImageInfo($source_filename);
		self::resizeTo($source_filename, 
			$s_width * $percent, 
			$s_height * $percent, 
			$dest_filename, 
			$quailty);
	}
	/**
	 * 调整图片尺寸到指定大小
	 * @param  string $source_filename 原文件名
	 * @param  int $width 新宽度
	 * @param  int $height 新高度
	 * @param  string|null $dest_filename 目标文件名
	 * @param  int $quailty 压缩率
	 */ 
	public static function resizeTo($source_filename, $width, $height, $dest_filename = null, $quailty=80){
		list($s_width, $s_height, $mime_type) = self::getImageInfo($source_filename);

		$source = self::_imageCreateFrom($source_filename, $mime_type);
		$dest = imagecreatetruecolor($width, $height);

		imagecopyresized($dest, $source, 0, 0, 0, 0, $width, $height, $s_width, $s_height);

		self::_imageOutput($dest, $mime_type, $dest_filename, $quailty);	
	}
	/**
	 * 以最大宽高度创建缩略图
	 * @param  string $source_filename 原文件名
	 * @param  int $max_width 最大宽度
	 * @param  int $max_height 最大高度
	 * @param  string|null $dest_filename 目标文件名
	 * @param  int $quailty 压缩率
	 */ 
	public static function thumb($source_filename, $max_width, $max_height, $dest_filename = null, $quailty = 80){
		// 获取原图片的尺寸
		list($s_width, $s_height, $s_type) = self::getImageInfo($source_filename);
		// 缩略图大小
		if($s_width <= $max_width){
			$width = $s_width;
		}else{
			$width = $max_width;
		}

		$height = $s_height * $width / $s_width;
		if($height > $max_height){
			if($s_height <= $max_height){
				$height = $s_height;
			}else{
				$height = $max_height;
			}
			$width = $s_width * $height / $s_height;
		}

		self::resizeTo($source_filename, $width, $height, $dest_filename, $quailty);
	}

	private static function getImageInfo($filename){
		$image_info = getimagesize($filename);
		return array($image_info[0], $image_info[1], $image_info['mime']);
	}
	/**
	 * 创建图像
	 * 
	 * @param string $filename 图片文件名	
	 * @param string $mime_type 图片的MIME类型
	 * 
	 * @return 读取到的图片
	 */ 
	private static function _imageCreateFrom($filename, $mime_type){
		$image_type = self::$_image_type[$mime_type];
		$func_name = "imagecreatefrom{$image_type}";
		if (function_exists($func_name)) {
			return $func_name($filename);
		}
		throw new exceptions\NoSuchFunctionException("函数{$func_name}不存在！");
	}
	/**
	 * 生成图片imagejpeg/imagepng/imagegif等
	 * 
	 * @param resources $image 图片资源
	 * @param string $mime_type MIME类型
	 * @param string $dest_filename 目标文件名
	 * @param int $quailty 图片质量（0-100之间的整数）
	 * 
	 */ 
	private static function _imageOutput($image, $mime_type, $dest_filename = null, $quailty = 80){
		if(is_null($dest_filename)){
			header("Content-Type: {$mime_type}");
		}
		$image_type = self::$_image_type[$mime_type];
		$func_name = "image{$image_type}";
		if (function_exists($func_name)) {
			return $func_name($image, $dest_filename, $func_name == 'imagepng' ? floor($quailty / 10) : $quailty);
		}
		throw new exceptions\NoSuchFunctionException("函数{$func_name}不存在！");	
	}
}