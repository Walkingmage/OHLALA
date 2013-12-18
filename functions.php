<?php
include_once("dbconnect.php");
include_once("pdoconnect.php");
$function = $_GET["function"];
session_start(); 

// function to check if user exists in the database, if so, login!
function check_user_login($email, $password) {
	global $mysqli;

	$email = mysqli_real_escape_string($mysqli, $email);
	$password = mysqli_real_escape_string($mysqli, $password);

	if (empty($email) || empty($password)) {
		return false;
	}
	mysqli_query($mysqli, "set names 'utf8'");
	$sql = 'SELECT * FROM tbl_user 
			WHERE user_email = "'.$email.'"
			AND user_password = "'.$password.'"';
	$query = mysqli_query($mysqli, $sql);

	$num = mysqli_num_rows($query);
	$res = mysqli_fetch_assoc($query);

	if ($num > 0) {
		// set session user
		$_SESSION['user'] = $res;
		header('Location: manage_users.php');
	} else {
		return false;
	}
}

// if ( !empty($_SESSION['user'])) {
// 	if (isset($_GET['logout'])) {
// 		unset($_SESSION['user']);
// 		header('Location: index.php');
// 	}
// }

function user_logged_in() {
	if (empty($_SESSION['user'])) {
		return false;
	}
	return true;
}

function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
	$size = strlen( $chars );
	for($i = 0; $i < $length; $i++ ) {
	$str .= $chars[ rand( 0, $size - 1 ) ];}
	return $str; 
}

if($function == "logout"){
session_destroy();
header('Location: index.php');
}

if ($function == "edituser") {
$id = $_GET["id"];
$sql = "UPDATE `tbl_user` SET  `user_firstname`=:user_firstname, `user_lastname`=:user_lastname, `user_email`=:user_email, `user_phonenumber`=:user_phonenumber, `usertype_id`=:user_access WHERE `user_id` = $id";

$stmt = $pdo->prepare($sql);
$stmt->execute(array(":user_firstname" => $_POST["user_firstname"], ":user_lastname" => $_POST["user_lastname"], ":user_email" => $_POST["user_email"], ":user_phonenumber" => $_POST['user_phonenumber'], ":user_access" => $_POST['user_access']));
   
$success = "Ändringar sparades";
  
header("location:edit_user.php?id=$id&success=$success");
}

if($function == "resetUserPassword"){
$newPassword = rand_string( 7 );
$id = $_GET["id"];
$sql = "UPDATE `tbl_user` SET  `user_password`=:user_password WHERE `user_id` = $id";

$stmt = $pdo->prepare($sql);
$stmt->execute(array(":user_password" => $newPassword));
   
$resetSuccess = "Lösenordet återställdes";
  
header("location:edit_user.php?id=$id&resetSuccess=$resetSuccess");
}

if($function == "bookRoom"){
	$classroom = $_POST['classroom'];
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$bookingtime = $_POST['bookingtime'];
	// $user = $_GET['user'];
	$bookingsuccess = "Bokningen lyckades!";

	$bookingquery = "SELECT * 
	FROM  `tbl_booking` WHERE  `classroom_id` = $classroom 
	AND (`booking_startdate` <=  '$startdate' 
	AND  `booking_enddate` >=  '$enddate'
	AND bookingtime_id = $bookingtime)";

    $bookingresult = mysqli_query($mysqli, $bookingquery);
  	$bookingrows = mysqli_num_rows($bookingresult);

	if($bookingrows > 0){
	$bookingerror = "Bokningen misslyckades. Lokalen är redan bokad vid denna tid!";
	header("location:book_room.php?bookingerror=$bookingerror");	
	}
	else{
	$sql = "INSERT INTO `wukwebbi_grupp1`.`tbl_booking` (`booking_id`, `bookingtime_id`, `booking_startdate`, `booking_enddate`, `course_id`, `classroom_id`, `user_id`) 
	VALUES (NULL, 	:bookingtime,	:startdate, 	:enddate, 	'0', 	:classroom, 	'0');";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		":classroom" => $classroom, 
		":startdate" => $startdate, 
		":enddate" => $enddate, 
		":bookingtime" => $bookingtime));
	header("location:book_room.php?bookingsuccess=$bookingsuccess");
	}
	mysqli_free_result($bookingresult);
}