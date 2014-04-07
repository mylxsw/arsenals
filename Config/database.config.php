<?php 
return array(
	'data_source'		=> 'Arsenals\Core\Database\PDO\PDODataSource',
	'global'			=> array(
		'prefix'		=> 'ar_',
		'char_set'		=> 'utf8',
		'dbcollat'		=> 'utf8_general_ci'
	),
	'mysql'				=> array(
		'host'			=> 'localhost',
		'port'			=> '3306',
		'db_name'		=> 'arsenals_demo',
		'user'			=> 'root',
		'password'		=> ''
	)
	,
	'pdo'				=> array(
		'dsn'			=> 'mysql:dbname=arsenals_demo;host=localhost',
		'user'			=> 'root',
		'password'		=> '',
	),
);