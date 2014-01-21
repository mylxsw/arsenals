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
	 * 解析模板并返回解析完成后的内容
	 * 
	 * @param mixed $vm
	 * @return string
	 */
	public function parse($vm);
}
