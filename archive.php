<?php 
session_start();
require_once("pdoconnect.php");
//require_once("dBug.php");//https://github.com/KOLANICH/dBug
//new dBug($_POST);
$sth = $pdo->prepare("UPDATE tbl_user SET user_archived = :boolArchive WHERE user_id=:id");
$sth->bindParam(':boolArchive',$_POST["setArchived"]);
$sth->bindParam(':id', $key);
foreach ($_POST["userCheckbox"] as $key => $value) {	
	//echo ($key."<br>");
	$sth->execute();
}
header('Location: manage_users.php');
?>
