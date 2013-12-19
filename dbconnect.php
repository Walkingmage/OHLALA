<?php
if(!defined("INC")){
	define("INC", 1);
}
error_reporting(E_ALL & ~E_NOTICE);
require_once("config.mysqli.php");
@$mysqli = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("No Db found");
