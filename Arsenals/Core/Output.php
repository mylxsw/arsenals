<?php

namespace Arsenals\Core;

use Arsenals\Core\Views\View;
use Arsenals\Core\Views\ValueStack;
use Arsenals\Core\Views\ViewAndModel;
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
		if($view instanceof ViewAndModel){// 模型视图
			$this->_renderViewAndModel($view);
		}else if($view instanceof Ajax){// Ajax返回值
			$this->_renderAjax($view);
		}else if($view instanceof View){// 其它类型
			$view->parse($view);
			$view->display($view);
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
	 * 视图渲染
	 *
	 * @param View $view 要渲染的视图对象
	 *
	 * @return void|string
	 */
	public function _renderViewAndModel(ViewAndModel $vm){
		$view_name = VIEW_LAYER;
		$view = new $view_name();
		if($view instanceof View){
			// 将数据添加到值栈，以便随时访问
			ValueStack::addAll($vm->getDatas());
			$view->display($vm);
		}else{
			throw new \Exception('指定的视图类必须实现Arsenals\\Core\\Views\\View接口!');
		}
	}
	/**
	 * 输出内容到客户端
	 * @param string $content
	 */
	public function output($content){
		echo $content;
	}
}
