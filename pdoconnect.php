<?php
if(!defined("INC")){
	define("INC", 1);
}
error_reporting(E_ALL & ~E_NOTICE);
require_once("config.mysqli.php");
$dsn = 'mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8';
$pdo = new PDO($dsn, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
