<?php

namespace Arsenals\Core\Database\MySQL;

use Arsenals\Core\Database\DataSource;
use Arsenals\Core\Config;
use Arsenals\Core\Abstracts\Arsenals;
if (!defined('APP_NAME')) exit('Access Denied!');
/**
 * MySQL数据源mysqli方式
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class MySQLiDataSource extends Arsenals implements DataSource {
	
	private $mysqli = null;
	
	public function init(){
		$config = Config::load('database');
		$mysqli = new \mysqli($config['mysql']['host'], 
					$config['mysql']['user'],
					$config['mysql']['password'],
					$config['mysql']['db_name'],
					$config['mysql']['port']);
		
		if(mysqli_connect_errno()){
			throw new \Exception('Database connection failed! Error：' . mysqli_connect_error());
		}
		$mysqli->query('SET NAMES ' . $config['mysql']['char_set']);
		
		$this->mysqli = $mysqli;
	}
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Database\DataSource::getConnection()
	 */
	public function getConnection() {
		return $this->mysqli;
	}

	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Database\DataSource::closeConnection()
	 */
	public function closeConnection() {
		$this->mysqli->close();
	}
}
