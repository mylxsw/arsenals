<?php 
return array(
	'data_source'		=> 'Arsenals\Core\Database\MySQL\MySQLiDataSource',
	'global'			=> array(
		'prefix'		=> 'ar_',
	),
	'mysql'				=> array(
		'host'			=> 'localhost',
		'port'			=> '3306',
		'db_name'		=> 'arsenals_demo',
		'user'			=> 'root',
		'password'		=> '',
		'char_set'		=> 'utf8',
		'dbcollat'		=> 'utf8_general_ci'
	)
);