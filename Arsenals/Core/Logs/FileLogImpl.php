<?php

namespace Arsenals\Core\Logs;
use Arsenals\Core\file_put_contents;
use Arsenals\Core\Abstracts\Arsenals;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 基于文件的Log实现
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class FileLogImpl implements Logs {
	private static $_messages;
	private static $_log_count = 0;
	
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Logs\Logs::write()
	 */
	public function write($level, $message) {
		$log = array('level' => $level,
				'message' => $message,
				'time' => time());
		self::$_messages[self::$_log_count ++] = $log;
		file_put_contents($this->_getLogFile(), date('Y-m-d H:i:s', $log['time']) . "  [{$level}]  " . $message . "\r\n", FILE_APPEND|LOCK_EX);
	}
	/*
	 * 获取日志文件名称
	 */
	private function _getLogFile(){
		return CACHE_PATH . 'arsenals' . date('Y-m-d', time()) . '.log';
	}

	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Logs\Logs::getLogs()
	 */
	public function getLogs($level = null) {
		if(is_null($level)){
			return self::$_messages;
		}
		$messages = array();
		
		if(!is_array($level)){
			$level = array($level);
		}
		
		foreach (self::$_messages as $key=>$val){
			if (in_array($val['level'], $level)) {
				$messages[$key] = $val;
			}
		}
		return $messages;
	}

}
