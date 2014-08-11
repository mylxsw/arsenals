<?php
/**
 * Database configuration
 * 
 * @author [[author]]
 */ 
return array(
	'data_source'		=> 'Arsenals\Core\Database\MySQL\MySQLiDataSource',
	'global'			=> array(
		'prefix'		=> '[[db_prefix]]',
	),
	'mysql'				=> array(
		'host'			=> '[[db_host]]',
		'port'			=> '[[db_port]]',
		'db_name'		=> '[[db_dbname]]',
		'user'			=> '[[db_username]]',
		'password'		=> '[[db_password]]',
		'char_set'		=> 'utf8',
		'dbcollat'		=> 'utf8_general_ci'
	)
);