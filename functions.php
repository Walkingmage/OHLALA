<?php
include("dbconnect.php");

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

if ( ! empty($_SESSION['user'])) {
	if (isset($_GET['logout'])) {
		unset($_SESSION['user']);
		header('Location: index.php');
	}
}

function user_logged_in() {
	if (empty($_SESSION['user'])) {
		return false;
	}

	return true;
}