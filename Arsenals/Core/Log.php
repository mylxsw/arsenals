<?php

namespace Arsenals\Core;

use \Arsenals\Core\Logs\Logs;
use \Arsenals\Core\Exceptions\ClassTypeException;

if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * 日志记录
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class Log{
	private static $_log_instance;
	private $_conf = array();

	public function __construct(){
		if(!LOG){return ;}
		if(self::$_log_instance == null){
			$logImpl = LOG_IMPL;
			self::$_log_instance = new $logImpl;
			if (!self::$_log_instance instanceof Logs) {
				throw new ClassTypeException('Log implementation class must implement the interface Logs!');
			}
		}
		$this->_conf = Config::load('log');
	}
	
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
		if(!LOG){
			return false;
		}
		
		if (!in_array($level, $this->_conf['log_levels'])) {
			return false;
		}
		return self::$_log_instance->write($level, $message);
	}
	/**
	 * 获取所有日志
	 * @return \Arsenals\Core\unknown
	 */
	public function getLogs($level = null){
		if(!LOG){
			return '';
		}
		if (!in_array($level, $this->_conf['log_levels'])) {
			return '';
		}
		return self::$_log_instance->getLogs($level);
	}
}
