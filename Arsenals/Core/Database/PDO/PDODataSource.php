<?php

namespace Arsenals\Core\Database\PDO;

use \Arsenals\Core\Database\DataSource;
use \Arsenals\Core\Config;
use \Arsenals\Core\Abstracts\Arsenals;
use \Arsenals\Core\Registry;
if (!defined('APP_NAME')) exit('Access Denied!');
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
					$config['pdo']['user'],
					$config['pdo']['password']);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			
			$this->pdo->query('SET NAMES ' . $config['global']['char_set']);
		}catch (\PDOException $e){
			throw new \Exception('Database connection failed! Error：' . $e->getMessage());
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \Arsenals\Core\Database\DataSource::getConnection()
	 *
	 */
	public function getConnection() {
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::getRealConnection()
	 */
	public function getRealConnection(){
		return $this->pdo;
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::query()
	 */
	public function query($sql, $args = array(), $insert = false){
		try{
			if(is_null($args)){
	            $args = array();
	        }
	        // 日志记录
	        $log = Registry::load('Arsenals\Core\Log');
			$log->debug("执行SQL：{$sql}", 'system');
			
			// 如果没有提供参数数组，则执行普通查询
			if(\count($args) == 0){
				$res = $this->pdo->query($sql);
	            if($insert){
	                return $res->fetch();
	            }
				
				return $res->fetchAll();
			}
	        
			// 提供了参数数组，执行预处理
			$stmt = $this->pdo->prepare($sql);
			
//			$i = 1;
//			foreach ($args as $k => $v){
//				$stmt->bindParam($i++, $v);
//			}
//			
			$stmt->execute($args);
			
			if(!$insert){
				return $stmt->fetchAll();
			}
		} catch (\PDOException $e){
			throw new \Arsenals\Core\Exceptions\QueryException($e->getMessage());
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::escape()
	 */
	public function escape($str){
		return \addslashes($str);
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::beginTrans()
	 */
	public function beginTrans(){
		$this->pdo->beginTransaction();
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::commit()
	 */
	public function commit(){
		$this->pdo->commit();
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::rollback()
	 */
	public function rollback(){
		$this->pdo->rollBack();
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::lastInsertId()
	 */
	public function lastInsertId(){
		return $this->pdo->lastInsertId();
	}
}
