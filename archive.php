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

if ( isset($_POST['selectedUsers']) ) {
	$redirect = "manage_users.php";
	if ( empty($_POST['selectedUsers']) ) {
		header("Location: $redirect");		
	}
	$selectedIDList = $_POST['selectedUsers'];
	$table = "tbl_user";
	$archivedColumn = "user_archived";
	$cell = "user_id";
}

if ( isset($_POST['selectedCourses']) ) {
	$redirect = "manage_courses.php";
	if ( empty($_POST['selectedCourses']) ) {
		header("Location: $redirect");		
	}
	$selectedIDList = $_POST['selectedCourses'];
	$table = "tbl_course";
	$archivedColumn = "course_archived";
	$cell = "course_id";
}

$sth = $pdo->prepare("UPDATE $table SET $archivedColumn = :boolArchive WHERE $cell=:id");
$sth->bindParam(':boolArchive',$_POST["setArchived"]);
$sth->bindParam(':id', $value);

$idArray = explode(", ", $selectedIDList);
$firstElement = $idArray[0];
$firstElement = substr($firstElement, 1);
$idArray[0] = $firstElement;
$lastElement = $idArray[(count($idArray)-1)];
$lastElement = substr($lastElement, 0, -1);
$idArray[(count($idArray)-1)] = $lastElement;

foreach ($idArray as $value) {	
	//echo ($value."<br>");
	$sth->execute();
}
header("Location: $redirect");
?>
