<?php

define('HOST_SPEC','http://192.168.1.1/');
define('SQLITE_DB',__DIR__ . '/sqlite3.db');
define('PG_HOST','localhost');
define('PG_PORT',  '5432');
define('PG_DB',  'pg_database');

define("VIEWFILE",0);
define("POSTFILE",1);
define("DRAGFILE",2);

define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LANG', 'ja');				// 言語ファイル

const DatabaseParameter  = [
	'Postgre' =>  array(
		'persistent' => false,
		'host' => PG_HOST,
		'port' => PG_PORT,
		'login' => '',
		'password' => '',
		'database' => PG_DB,
		'prefix' => '',
		'encoding' => 'utf8'
	),
	'SQLite' => array(
		'persistent' => false,
		'host' => 'localhost',
		'login' => '',
		'password' => '',
		'database' => SQLITE_DB,
		'prefix' => '',
		'encoding' => 'utf8'
	),
	'Filemaker' => array(
		'persistent' => false,
		'host' => HOST_SPEC,
		'login' => '',
		'password' => '',
		'database' => '*',
		'prefix' => '',
		'encoding' => 'utf8'
	),
	'Folder' => array(
		'persistent' => false,
		'host' => 'localhost',
		'login' => '',
		'password' => '',
		'database' => OSDEP,
		'prefix' => '',
		'encoding' => 'utf8'
	),
];