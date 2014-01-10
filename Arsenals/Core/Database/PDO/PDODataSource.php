<?php

namespace Arsenals\Core\Database\PDO;

use Arsenals\Core\Database\DataSource;
use Arsenals\Core\Config;
use Arsenals\Core\Abstracts\Arsenals;

/**
 * PDO 数据源
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class PDODataSource extends Arsenals implements DataSource {
	private $pdo;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Arsenals\Core\Database\DataSource::closeConnection()
	 *
	 */
	public function closeConnection() {
		$this->pdo->close();
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Arsenals\Core\Database\DataSource::init()
	 *
	 */
	public function init() {
		$config = Config::load('database');
		try{
			$this->pdo = new \PDO($config['pdo']['dsn'],
					$config['mysql']['user'],
					$config['mysql']['password']);
		}catch (\PDOException $e){
			throw new \Exception('数据库连接失败!原因:' . $e->getMessage());
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Arsenals\Core\Database\DataSource::getConnection()
	 *
	 */
	public function getConnection() {
		return $this->pdo;
	}
}
