<?php
session_start();
define("INC", 1);
//die("Används ej");
include("config.mysqli.php");


@$mysqli = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("No Db found");
//echo($mysqli->character_set_name());
//$mysqli->set_charset("utf8") or die("Can't set charset");
//echo($mysqli->character_set_name());


?>