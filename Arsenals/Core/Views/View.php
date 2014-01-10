<?php

namespace Arsenals\Core\Views;

/**
 * 视图接口
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
interface View {
	/**
	 * 显示内容给最终用户
	 * 
	 * @param mixed $vm
	 */
	public function display($vm);
	/**
	 * 解析模板并返回解析完成后的模板
	 * 
	 * @param mixed $vm
	 * @return string
	 */
	public function parse($vm);
}
