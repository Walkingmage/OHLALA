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

if ( isset($_POST['selectedPrograms']) ) {
	$redirect = "manage_programs.php";
	if ( empty($_POST['selectedPrograms']) ) {
		header("Location: $redirect");		
	}
	$selectedIDList = $_POST['selectedPrograms'];
	$table = "tbl_program";
	$archivedColumn = "program_archived";
	$cell = "program_id";

	$sth_course = $pdo->prepare("UPDATE tbl_course SET course_archived = :boolArchive WHERE program_id=:id");
	$sth_course->bindParam(':boolArchive',$_POST["setArchived"]);
	$sth_course->bindParam(':id', $value);

	$sth_user = $pdo->prepare("UPDATE tbl_user SET user_archived = :boolArchive WHERE program_id=:id");
	$sth_user->bindParam(':boolArchive',$_POST["setArchived"]);
	$sth_user->bindParam(':id', $value);

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

if (isset($_POST['selectedPrograms'])) {
	foreach ($idArray as $value) {	
		//echo ($value."<br>");
		$sth->execute();
		$sth_user->execute();
		$sth_course->execute();		
	}
} else {
	foreach ($idArray as $value) {	
		//echo ($value."<br>");
		$sth->execute();
	}
}


header("Location: $redirect");
?>
