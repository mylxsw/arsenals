<?php

namespace Arsenals\Core\Views;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 模板编译器接口
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
interface Compiler {
	/**
	 * 编译模板
	 * @param unknown $content
	 */
	public function compile($content);
}
