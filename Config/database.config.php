<?php

return [
    'data_source'        => 'Arsenals\Core\Database\PDO\PDODataSource',
    'global'             => [
        'prefix'          => 'ar_',
        'char_set'        => 'utf8',
        'dbcollat'        => 'utf8_general_ci',
    ],
    'mysql'                => [
        'host'            => 'localhost',
        'port'            => '3306',
        'db_name'         => 'arsenals_demo',
        'user'            => 'root',
        'password'        => '',
    ],
    'pdo'                => [
        'dsn'             => 'mysql:dbname=arsenals_demo;host=localhost',
        'user'            => 'root',
        'password'        => '',
    ],
];
