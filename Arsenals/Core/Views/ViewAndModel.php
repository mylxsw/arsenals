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
	/**
	 * 视图模型解析
	 * @param unknown $view_name
	 * @param unknown $view_datas
	 * @throws \Exception
	 * @return string
	 */
	public static function make($view_name, $view_datas = array()){
		if ($view_name instanceof ViewAndModel) {
			$view_layer = VIEW_LAYER;
			$view = new $view_layer();
			if($view instanceof View){
				// 将数据添加到值栈，以便随时访问
				ValueStack::addAll($view_name->getDatas());
				return $view->parse($view_name);
			}else{
				throw new \Exception('指定的视图类必须实现Arsenals\\Core\\Views\\View接口!');
			}
		}else{
			$vm = new ViewAndModel($view_name, $view_datas);
			return self::make($vm);
		}
	}
}
