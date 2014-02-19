<?php require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
?>
<body>
<?php require('pageheader.php');
if (!user_logged_in()) {
   header('Location: index.php');
   die();
}
?>

<div class='container'>
<div id='confirm-page'>
<h2> Kontot har skapats!</h2>
<?php
session_start(); 

require 'dbconnect.php';


if ($function == "adduser"){
	//$mysqli->set_charset("utf8");

	for ($i = 0, $l = count($_POST['firstname']); $i < $l; $i++) {
		$firstname 	= utf8_decode($mysqli->real_escape_string($_POST['firstname'][$i]));
		$lastname 	= utf8_decode($mysqli->real_escape_string($_POST['lastname'][$i]));
		$privemail 	= utf8_decode($mysqli->real_escape_string($_POST['privemail'][$i]));
		$telephone 	= utf8_decode($mysqli->real_escape_string($_POST['telephone'][$i]));
		$access		= utf8_decode($mysqli->real_escape_string($_POST['access'][$i]));
		$usercounts = 0;
		$checkuserresult = mysqli_query($mysqli, "SELECT * FROM `tbl_user` WHERE `user_firstname` = '$firstname' AND `user_lastname` = '$lastname'");
		if($checkuserresult != false){
		while($row = mysqli_fetch_assoc($checkuserresult)){$usercounts++;}}
		
		$username 	= "YH" . substr($firstname, 0, 3) . substr($lastname, 0, 3) . str_pad($usercounts, 3, "0", STR_PAD_LEFT);
		$password 	= rand_string( 7 );

		$usertyperesult = mysqli_query($mysqli, "SELECT * FROM `tbl_usertype` WHERE `usertype_id` = '$access'");
		$usertype = $row = mysqli_fetch_assoc($usertyperesult);
		$jensenemail = $username . "@" .  $row["usertype_name"]. ".jensenoffline.se";
// ----------------------------------------------------------------
		try{
			include_once("pdoconnect.php");
			$sql = "INSERT INTO tbl_user(
				user_firstname,
				user_lastname,
				user_email,
				user_jensenemail,
				user_phonenumber,
				user_username,
				user_password,
				user_lastlogin,
				usertype_id
			) VALUES (
				:firstname,
				:lastname,
				:privemail,
				:jensenemail,
				:telephone,
				:username,
				:password,
				now(),
				:access
			)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(":firstname" => $firstname, ":lastname" => $lastname, ":privemail" => $privemail, ":jensenemail" => $jensenemail, ":username" => $username, ":access" => $access, ":telephone" => $telephone, ":password" => $password));
	  

		}catch(PDOException $e) {
    		echo 'ERROR: '. $e->getMessage();
		}


		$checkaccessresult = mysqli_query($mysqli, "SELECT * FROM `tbl_usertype` WHERE `usertype_id` = '$access'");
		while($row = mysqli_fetch_array($checkaccessresult)){
			$checkaccess = $row['usertype_name'];
		}

		echo "Förnamn: " . utf8_encode($firstname) . "<br>";
		echo "Efternamn: " . utf8_encode($lastname) . "<br>";
		echo "Privat email: " . utf8_encode($privemail) . "<br>";
		echo "Telefon: " . utf8_encode($telephone) . "<br>";
		echo "Behörighet: " . $access . " (" . $checkaccess . ")<br><br>";

		echo "Jensen-mail: " . utf8_encode($jensenemail) . "<br>";
		echo "Användarnamn: " . utf8_encode($username) . "<br>";
		echo "Lösenord:" . $password . "<br>";
		echo "<br>Ett email med denna information har skickats till den angivna e-post adressen.<br>";
		echo "<hr>";
		require_once('mail_to_user.php');
 		mailToUser($firstname, $lastname, $privemail, $telephone, $access, $jensenemail, $username);
	}
}
function removeDots($text){
	//fungerar endast vid utf8
	$ts = array("/[À-Å]/","/Ä/","/Æ/","/Ç/","/[È-Ë]/","/[Ì-Ï]/","/Ð/","/Ñ/","/[Ò-ÖØ]/","/×/","/[Ù-Ü]/","/[Ý-ß]/","/[à-å]/","/æ/","/ç/","/[è-ë]/","/[ì-ï]/","/ð/","/ñ/","/[ò-öø]/","/÷/","/[ù-ü]/","/[ý-ÿ]/");
	$tn = array("A","A","AE","C","E","I","D","N","O","X","U","Y","a","ae","c","e","i","d","n","o","x","u","y");
	$title = preg_replace($ts, $tn, $text);
	return $title;
}
?>
</div></div>
<?php require('pagefooter.php'); ?>
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>