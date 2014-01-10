<?php

namespace Arsenals\Core\Database;

/**
 * 数据源接口
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
interface DataSource {
	/**
	 * 数据库连接初始化
	 */
	public function init();
	/**
	 * 获取数据库连接
	 */
	public function getConnection();
	/**
	 * 关闭数据库连接
	 */
	public function closeConnection();
	
}
