<?php 
session_start();
require_once("pdoconnect.php");
$admin=FALSE;//TODO FIXME!
$loggedInUserId=151;//TODO FIXME!
//require_once("dBug.php");//https://github.com/KOLANICH/dBug
//new dBug($_SESSION);
function checkForUnbookPrem($checkPremSth,$userId){
		$checkPremSth->execute();
		//$checkPremSth->setFetchMode(PDO::FETCH_OBJ);
	 	$f = $checkPremSth->fetch();
	  	RETURN $userId == $f['user_id'];
	}
if(!$admin){
//SETUP statement

	$checkPremSth = $pdo->prepare("SELECT user_id FROM tbl_booking WHERE booking_id=:id");
	$checkPremSth->bindParam(':id', $value);



}


$sth = $pdo->prepare("DELETE FROM tbl_booking WHERE booking_id=:id");
$sth->bindParam(':id', $value);

$selectedRoomList = $_POST['selectedBookings'];
$roomArray = explode(", ", $selectedRoomList);
$firstElement = $roomArray[0];
$firstElement = substr($firstElement, 1);
$roomArray[0] = $firstElement;
$lastElement = $roomArray[(count($roomArray)-1)];
$lastElement = substr($lastElement, 0, -1);
$roomArray[(count($roomArray)-1)] = $lastElement;

foreach ($roomArray as $value) {	
	//echo ($value."<br>");
	if($admin){
		$sth->execute();
	}else{
		if (checkForUnbookPrem($checkPremSth,$loggedInUserId)) {
			$sth->execute();
		}else{
			//echo ("UserID ".$loggedInUserId." can't unbook booking ".$value."!<br>\n");//TODO debug only


		}
		
	}



	
}
header('Location: manage_booking_rooms.php');

?>
