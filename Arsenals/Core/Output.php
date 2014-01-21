<?php

namespace Arsenals\Core;

use Arsenals\Core\Views\Ajax;
use Arsenals\Core\Abstracts\Arsenals;
/**
 * 输出控制类
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Output extends Arsenals {
	/**
	 * 视图渲染
	 * @param mixed $view
	 * @throws \Exception
	 */
	public function render($view){
		// 如果执行的动作没有返回值，则抛错
		if(is_null($view)){
			return false;
		}
		// 根据具体视图类型进行展示
		if($view instanceof Ajax){// Ajax返回值
			$this->_renderAjax($view);
		}else{
			$this->output((string)$view);
		}
	}
	/**
	 * 渲染Ajax视图
	 * @param Ajax $view
	 */
	public function _renderAjax(Ajax $view){
		$this->output(json_encode($view->getDatas()));
	}
	
	/**
	 * 输出内容到客户端
	 * @param string $content
	 */
	public function output($content){
		echo $content;
	}
}
