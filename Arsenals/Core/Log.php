<?php

namespace Arsenals\Core;

use Arsenals\Core\Abstracts\Arsenals;
/**
 * 日志记录
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Log{
	/**
	 * 全局日志消息
	 * @var unknown
	 */
	private static $_messages = array();
	/**
	 * 当前日志计数
	 * @var unknown
	 */
	private static $_log_count = 0;
	
	public function info($message, $name = ''){
		$this->writeLog('info', "[{$name}] {$message}");
	}
	public function debug($message, $name = ''){
		$this->writeLog('debug', "[{$name}] {$message}");
	}
	public function error($message, $name = ''){
		$this->writeLog('error', "[{$name}] {$message}");
	}
	public function warning($message, $name = ''){
		$this->writeLog('warning', "[{$name}] {$message}");
	}
	/**
	 * 记录日志信息
	 * @param unknown $level
	 * @param unknown $message
	 */
	public function writeLog($level, $message){
		self::$_messages[self::$_log_count ++] = array('level' => $level, 
				'message' => $message, 
				'time' => microtime());
	}
	/**
	 * 获取所有日志
	 * @return \Arsenals\Core\unknown
	 */
	public static function getLogs($level = null){
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
