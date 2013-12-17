<?php 
session_start();

if(!defined("INC")){
	define("INC", 1);
}
error_reporting(E_ALL);
require_once("config.mysqli.php");
$dsn = 'mysql:host='.$dbhost.';dbname='.$dbname;
$pdo = new PDO($dsn, $dbuser, $dbpass);

//require_once("dBug.php");//https://github.com/KOLANICH/dBug
//new dBug($_POST);

$sth = $pdo->prepare("UPDATE tbl_user SET user_archived = :boolArchive WHERE user_id=:id");
$sth->bindParam(':boolArchive',$_POST["setArchived"]);
$sth->bindParam(':id', $value);

$selectedUserList = $_POST['selectedUsers'];
$userArray = explode(", ", $selectedUserList);
$firstElement = $userArray[0];
$firstElement = substr($firstElement, 1);
$userArray[0] = $firstElement;
$lastElement = $userArray[(count($userArray)-1)];
$lastElement = substr($lastElement, 0, -1);
$userArray[(count($userArray)-1)] = $lastElement;

foreach ($userArray as $value) {	
	//echo ($value."<br>");
	$sth->execute();
}
header('Location: manage_users.php');
?>
