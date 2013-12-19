<?php
if(!defined("INC")){
	define("INC", 1);
}
error_reporting(E_ALL & ~E_NOTICE);
require_once("config.mysqli.php");
$dsn = 'mysql:host='.$dbhost.';dbname='.$dbname;
$pdo = new PDO($dsn, $dbuser, $dbpass);
?>