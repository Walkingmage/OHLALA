<?php
//session_start();
if(!defined("INC")){
	define("INC", 1);
}
error_reporting(E_ALL);
require_once("config.mysqli.php");
@$mysqli = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("No Db found");
//echo($mysqli->character_set_name());
//$mysqli->set_charset("latin1") or die("Can't set charset");
//echo($mysqli->character_set_name());
?>