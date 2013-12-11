<?php
session_start();
if(!defined("INC")){
	define("INC", 1);
}
require_once("config.mysqli.php");
@$mysqli = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("No Db found");
//echo($mysqli->character_set_name());
//$mysqli->set_charset("utf8") or die("Can't set charset");
//echo($mysqli->character_set_name());
?>