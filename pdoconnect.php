<?php
if(!defined("INC")){
	define("INC", 1);
}
require_once("config.mysqli.php");
$dsn = 'mysql:host='.$dbhost.';dbname='.$dbname;
$pdo = new PDO($dsn, $dbuser, $dbpass);
?>