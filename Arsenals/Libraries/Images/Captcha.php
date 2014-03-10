<?php
namespace Arsenals\Libraries\Images;

/**
 * 图形验证码
 * 
 * @author  管宜尧<mylxsw@126.com>
 * 
 * 使用方法：		
 *   $captcha = new Captcha();
 *   $code = $captcha->generateCode();
 *   $captcha->createImage($code);
 */ 
class Captcha {
	private $bg_width = 70;
	private $bg_height = 30;
	// 干扰线数量
	private $interfering_line_min = 1;
	private $interfering_line_max = 5;

	// 干扰点数量
	private $interfering_pixel_min = 5;
	private $interfering_pixel_max = 20; 

	// 字体大小配置
	private $fontsize_min = 12;
	private $fontsize_max = 20;

	// 代码数量
	private $code_len = 4;

	// 随机数种子
	private $seed = 'abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHIJKLMNPQRSTUVWXYZ';

	/**
	 * 构造函数
	 * 
	 * 可以以数组形式传递需要覆盖的配置项
	 */ 
	public function __construct(array $configs = array()){
		foreach ($configs as $key => $value) {
			$this->$key = $value;
		}
	}

	/**
	 * 生成验证码字符串
	 */ 
	public function generateCode(){
		$seed_len = strlen($this->seed);

		// 生成随机字符画
		$text = '';
		for($i = 0; $i < $this->code_len; $i++){
			$index = rand(0, $seed_len - 1);
			$text .= $this->seed{$index};
		}

		return $text;
	}

	/**
	 * 生成验证码
	 * 
	 * @param  string $text 验证码字符串
	 * @param  string|null 是直接输出到浏览器还是保存到文件，为NULL则输出到浏览器
	 */ 
	public function createImage($text, $filename = NULL){
		header("Content-Type: image/jpeg");
		// 创建画布
		$image = imagecreatetruecolor($this->bg_width, $this->bg_height);

		// 设置背景颜色
		$color_grey = imagecolorallocate($image, 204, 204, 204);
		imagefill($image, 0, 0, $color_grey);

		// 生成干扰线
		for ($j=0; $j < rand($this->interfering_line_min, $this->interfering_line_max); $j++) { 
			imageline($image, rand(0, $this->bg_width), rand(0, $this->bg_height), rand(0, $this->bg_width), rand(0, $this->bg_height), $this->getRandColor($image));
		}
		// 生成干扰点
		for($j=0; $j < rand($this->interfering_pixel_min, $this->interfering_pixel_max); $j ++) {
			imagesetpixel($image, rand(0, $this->bg_width), rand(0, $this->bg_height), $this->getRandColor($image));
		}

		// 生成随机字符画
		for($i = 0; $i < strlen($text); $i++){
			imagechar($image, rand($this->fontsize_min,$this->fontsize_max) , 5 + 15 * $i, 5, $text{$i}, $this->getRandColor($image));
		}

		// 生成图片
		imagejpeg($image, $filename);
		imagedestroy($image);
	}
	/**
	 * 生成随机颜色
	 * 
	 * @param  resources $image 图片资源
	 */ 
	private function getRandColor($image){
		return imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
	}
}