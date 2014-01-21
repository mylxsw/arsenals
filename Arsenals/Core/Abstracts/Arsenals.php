<?php

namespace Arsenals\Core\Abstracts;

use Arsenals\Core\Registry;
/**
 * Arsenals 抽象类
 * @author 管宜尧<mylxsw@126.com>
 *
 */
abstract class Arsenals {
	protected $_log = null;
	protected $_benchMark = null;
	
	public function __construct(){
		$this->_log = Registry::load('Arsenals\\Core\\Log');
		$this->_benchMark = Registry::load('Arsenals\\Core\\Benchmark');
		
		$this->_log->info('类加载完成!', get_class($this));
	}
	
}
