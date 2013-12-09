
<?php require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
?>
<body>
<?php require('pageheader.php'); ?>

<div class='container'>
<div id='confirm-page'>
<h2> Kontot har skapats!</h2>
<?php
session_start(); 

require 'dbconnect.php';

$function = $_GET["function"];
function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
	$size = strlen( $chars );
	for($i = 0; $i < $length; $i++ ) {
	$str .= $chars[ rand( 0, $size - 1 ) ];}
	return $str; 
	}

if ($function == "adduser"){

	for ($i = 0, $l = count($_POST['firstname']); $i < $l; $i++) {
		$firstname 	= $_POST['firstname'][$i];
		$lastname 	= $_POST['lastname'][$i];
		$privemail 	= $_POST['privemail'][$i];
		$telephone 	= $_POST['telephone'][$i];
		$access		= $_POST['access'][$i];

		$usercounts = 0;
		$checkuserresult = mysqli_query($mysqli, "SELECT * FROM `tbl_user` WHERE `user_firstname` = '$firstname' AND `user_lastname` = '$lastname'");
		if($checkuserresult != false){
		while($row = mysqli_fetch_assoc($checkuserresult)){$usercounts++;}}
		
		$username 	= "YH" . substr($firstname, 0, 3) . substr($lastname, 0, 3) . $usercounts;
		$password 	= rand_string( 7 );

		$usertyperesult = mysqli_query($mysqli, "SELECT * FROM `tbl_usertype` WHERE `usertype_id` = '$access'");
		$usertype = $row = mysqli_fetch_assoc($usertyperesult);
		$jensenemail = $username . "@" .  $row["usertype_name"]. ".jensenoffline.se";
// ----------------------------------------------------------------
try{
$pdo = new PDO('mysql:host=wuk.web.bitcloud.se;dbname=wukwebbi_grupp1', 'wukwebbi_grupp1', 'ofumfg123');
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
		'$password',
		now(),
		:access
	)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(":firstname" => $firstname, ":lastname" => $lastname, ":privemail" => $privemail, ":jensenemail" => $jensenemail, ":username" => $username, ":access" => $access, ":telephone" => $telephone));
  }
  catch(PDOException $e) {
    echo 'ERROR: '. $e->getMessage();
}

$checkaccessresult = mysqli_query($mysqli, "SELECT * FROM `tbl_usertype` WHERE `usertype_id` = '$access'");
while($row = mysqli_fetch_array($checkaccessresult)){ $checkaccess = $row['usertype_name'];}

		echo "Förnamn: " . $firstname . "<br>";
		echo "Efternamn: " . $lastname . "<br>";
		echo "Privat email: " . $privemail . "<br>";
		echo "Telefon: " . $telephone . "<br>";
		echo "Behörighet: " . $access . " (" . $checkaccess . ")<br><br>";

		echo "Jensen-mail: " . $jensenemail . "<br>";
		echo "Användarnamn: " . $username . "<br>";
		echo "Lösenord:" . $password . "<br>";
		echo "<br>Ett email med denna information har skickats till den angivna e-post adressen.<br>";
		echo "<hr>";
		require_once('mail_to_user.php');
 		mailToUser($firstname, $lastname, $privemail, $telephone, $access, $jensenemail, $username);
}
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