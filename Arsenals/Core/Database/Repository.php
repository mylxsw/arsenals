<?php

namespace Arsenals\Core\Database;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 数据仓库操作接口
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
interface Repository {
	public function query($sql, $bind = FALSE);
	public function execute($sql, $bind = FALSE);
}
