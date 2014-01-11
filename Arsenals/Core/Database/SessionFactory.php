<?php

namespace Arsenals\Core\Database;

use Arsenals\Core\Config;
use Arsenals\Core\Abstracts\Arsenals;
/**
 * 数据库会话工厂，用于产生数据库连接
 * 
 * @author 管宜尧<mylxsw@126.com>
 *
 */
class SessionFactory extends Arsenals {
	private static $_last_connection = null;
	private static $_connections = array();
	private function __construct(){}
	/**
	 * 创建一个会话，打开数据库连接
	 * 
	 * 返回的是数据库连接， 如果要获取默认数据库连接，则使用default作为参数
	 * 
	 * @param string $data_source 数据源名称
	 * @throws \Exception
	 * @return resource:
	 */
	public static function getSession($data_source = null){
		// 如果没有指定参数，则获取默认的数据库连接
		if(is_null($data_source)){
			// 如果还没有创建数据库连接，则进行创建默认连接
			if(is_null(self::$_last_connection)){
				// 读取数据库连接配置
				$config = Config::load('database');
				$data_source_class = $config['data_source'];
				
				// 创建数据源
				$ds = new $data_source_class();
				if(!$ds instanceof DataSource){
					throw new \Exception('数据源必须实现DataSource接口!');
				}
				$ds->init();
				
				self::$_last_connection = $ds->getConnection();
				self::$_connections['default'] = self::$_last_connection;
			}
			return self::$_last_connection;
		}
		// 如果指定了数据源，则查找相应数据源
		if(is_string($data_source)){
			// 如果已经创建过了，则直接使用已经创建过的，反之则进行创建
			if(array_key_exists($data_source, self::$_connections)){
				self::$_last_connection = self::$_connections[$data_source];
			}else{
				// 创建指定的数据源
				$ds = new $data_source();
				if(!$ds instanceof DataSource){
					throw new \Exception('数据源必须实现DataSource接口!');
				}
				$ds->init();
				
				self::$_last_connection = $ds->getConnection();
				self::$_connections[$data_source] = self::$_last_connection;
			}
			return self::$_last_connection;
		}
		throw new \Exception('没有查找到该数据源!');
	}
	
}
