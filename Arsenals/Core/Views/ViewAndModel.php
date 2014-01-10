<?php

namespace Arsenals\Core\Views;

use Arsenals\Core\Abstracts\Arsenals;
/**
 * 核心视图
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class ViewAndModel extends Arsenals {
	/**
	 * 视图名称
	 */
	private $view_name;
	/**
	 * 传递给视图对形象的数据
	 */
	private $view_datas;
	/**
	 * 构造函数，初始化视图对象
	 *
	 * @param string $view_name 视图名称
	 * @param array $view_datas 传递给视图对象的数据
	 *
	 */
	public function __construct($view_name, $view_datas = array()){
		$this->view_name = $view_name;
		$this->view_datas = $view_datas;
	}
	/**
	 * 获取当前视图名称
	 *
	 * @return string
	 */
	public function getView(){
		return $this->view_name;
	}
	/**
	 * 获取传递给视图对象的数据
	 *
	 * @return array
	 */
	public function getDatas(){
		return $this->view_datas;
	}
}
