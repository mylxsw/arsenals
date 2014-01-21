<?php

namespace Arsenals\Core\Logs;
/**
 * 日志接口
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
interface Logs {
	
	public function write($level, $message);
	public function getLogs($level = null);
}
