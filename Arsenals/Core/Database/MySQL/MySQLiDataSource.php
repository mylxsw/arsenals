<?php

namespace Arsenals\Core\Database\MySQL;

use Arsenals\Core\Database\DataSource;
use Arsenals\Core\Config;
use Arsenals\Core\Abstracts\Arsenals;
use Arsenals\Core\Exceptions\QueryException;
use Arsenals\Core\Registry;
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
		$mysqli->query('SET NAMES ' . $config['global']['char_set']);
		
		$this->mysqli = $mysqli;
	}
	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Database\DataSource::getConnection()
	 */
	public function getConnection() {
		return $this;
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::getRealConnection()
	 */
	public function getRealConnection(){
		return $this->getConnection();
	}

	/* (non-PHPdoc)
	 * @see \Arsenals\Core\Database\DataSource::closeConnection()
	 */
	public function closeConnection() {
		$this->mysqli->close();
	}
	/**
	 * (non-PHPdoc)
	 * @see \Arsenals\Core\Database\DataSource::query()
	 */
	public function query($sql, $args = array(), $insert = false){
		if(is_null($args)){
            $args = array();
        }
        // 日志记录
        $log = Registry::load('Arsenals\Core\Log');
		$log->debug("执行SQL：{$sql}", 'system');
		
		// 如果没有提供参数数组，则执行普通查询
		if(\count($args) == 0){
			$res = $this->mysqli->query($sql);
			if($this->mysqli->errno){
				throw new \Arsenals\Core\Exceptions\QueryException($this->mysqli->error);
			}
            if(method_exists('mysqli_result', 'fetch_all')){
                return $insert ? $res : $res->fetch_all(MYSQLI_ASSOC);
            }
            if($insert){
                return $res;
            }
			$r = array();
            while(($tmp = $res->fetch_array(MYSQLI_ASSOC)) != false){
            	$r[] = $tmp;
            }
			return $r;
		}
        
		// 提供了参数数组，执行预处理
		$stmt = $this->mysqli->prepare($sql);
		if($this->mysqli->errno){
			throw new \Arsenals\Core\Exceptions\QueryException($this->mysqli->error);
		}
		$b_types = '';
		$b_params = array();
		foreach ($args as $k => $v){
			if(\is_integer($v)){
				$type = 'i';
			}else if(\is_float($v) || \is_double($v)){
				$type = 'd';
			}else{
				$type = 's';
			}
			$b_types .= $type;
			// bind_param第二个参数之后必须是引用
			// 同时注意的是，这里必须用$args，而不能用$v
			// 因为每次引用$v，都是传递的引用，$v最后只有一个相同的值
			$b_params[$k] = &$args[$k];
		}
		
		call_user_func_array(array($stmt, 'bind_param'), array_merge(array($b_types), $b_params));
		if(!$stmt->execute() ){
			throw new QueryException($this->mysqli->error);
		}
		if(!$insert){
			if(method_exists($stmt, 'get_result')){
				$res = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			}else{
				$stmt->store_result();
					
				$fileds = $stmt->result_metadata()->fetch_fields();
				$statementParams = '';
				$column = array();
				foreach ($fileds as $field){
					if(empty($statementParams)){
						$statementParams .= "\$column['" . $field->name . "']";
					}else{
						$statementParams .= ", \$column['" . $field->name . "']";
					}
				}
				$statement = "\$stmt->bind_result($statementParams);";
				eval($statement);
					
				$res = array();
				while ($stmt->fetch()){
                    
					$item = array();
                    foreach($column as $k=>$v){
                    	$item[$k] = $v;
                    }
                    
                    $res[] = $item;
				}
			}
            
			return $res;
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::escape()
	 */
	public function escape($str){
		return $this->mysqli->real_escape_string($str);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::beginTrans()
	 */
	public function beginTrans(){
		$this->mysqli->autocommit(false);
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::commit()
	 */
	public function commit(){
		$this->mysqli->commit();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::rollback()
	 */
	public function rollback(){
		$this->mysqli->rollback();
	}
	/**
	 * (non-PHPdoc)
	 * @see Arsenals/Core/Database/Arsenals\Core\Database.DataSource::lastInsertId()
	 */
	public function lastInsertId(){
		return $this->mysqli->insert_id;
	}
}
