<?php
/**
 * Arsenals 数据库配置
 *
 * @author 管宜尧
 */

return array(
	'data_source'		=> 'Arsenals\\Core\\Database\\MySQL\\MySQLiDataSource',
	'global'			=> array(
		'prefix'		=> 'ori_',
	),
	'mysql'				=> array(
		'host'			=> 'localhost',
		'port'			=> '3306',
		'db_name'		=> 'orionis',
		'user'			=> 'root',
		'password'		=> '',
		'char_set'		=> 'utf8',
		'dbcollat'		=> 'utf8_general_ci'
	),
	'pdo'				=> array(
		'dsn'			=> 'mysql:dbname=arsenals;host=localhost',
		'user'			=> 'root',
		'password'		=> '',
	),
	
);