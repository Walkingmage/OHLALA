<?php if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include_once("dbconnect.php");
include_once("pdoconnect.php");
isset($_GET["function"]) ? $function = $_GET["function"] : $function = "";
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
			WHERE user_username = "'.$email.'"
			AND user_password = "'.$password.'"';
	$query = mysqli_query($mysqli, $sql);

	$num = mysqli_num_rows($query);
	$res = mysqli_fetch_assoc($query);

	if ($num > 0) {
		// set session user
		$_SESSION['user'] = $res;
		header('Location: manage_users.php');
    exit;
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

function get_all_rooms($filter = array()) {
  global $mysqli;
  $rooms = array();
  $where = null;

  $sql = 'SELECT classroom_id, classroom_name FROM tbl_classroom';

  /*if ( ! empty($filter)) {
    $where .= ' WHERE ';
    if ( ! empty($filter['classroom_equipment'])) {
      $where .= " classroomtype.classroomtype_name = "%'.$filter['classroomtype_name'].'%"";
    }

    $sql = 'SELECT
            classroom_id,
            classroom_name,
            classroomtype.classroomtype_name
            FROM tbl_classroom AS classroom
            LEFT JOIN tbl_classroomtype AS classroomtype
            ON classroomtype.classroomtype_id = classroom.classroom_type
            "'.$where.'"';
  }*/
  $query = mysqli_query($mysqli, $sql);
  $rows = mysqli_num_rows($query);

  if ($rows == 0) {
    return false;
  }

  while ($row = mysqli_fetch_assoc($query)) {
    $rooms[] = $row;
  }
  return $rooms;
}

function get_classroom_eq() {
  global $mysqli;
  $classroom_types = array();

  $sql = 'SELECT
          classroom.classroom_equipment
          FROM tbl_classroom AS classroom';
  $query = mysqli_query($mysqli, $sql);

  $num = mysqli_num_rows($query);

  if ($num == 0) {
    return false;
  }
  while($row = mysqli_fetch_assoc($query)) {
    $eq = explode(',', $row['classroom_equipment']);
    if ( ! empty($eq)) {
      $classroom_types[] = $eq;
    }
  }

  foreach($classroom_types as $k) {
    foreach($k as $key => $val) {
      if ( ! empty($val)) {
        $key = strtolower(trim($val));
        $types[$key] = $val;
      }
    }
  }

  return $types;
}

/*
function format_query_string($qv = array()) {
  $qs = null;
  if (empty($_GET) && empty($qv)) {
    return false;
  }

  if (empty($qv)) {
    foreach($_GET as $k => $v) {
      if ( ! empty($v)) {
        $query_vars[$k] = $v;
      }
    }
    $qs = '?'.http_build_query($query_vars) . "\n";
  } else {

    foreach($qv as $k => $v) {
      $query_vars[$k] = $v;
    }
    if ( ! empty($_GET) && count($_GET) > 1) {
      foreach($_GET as $k => $v) {
        if ( ! empty($v)) {
          $query_vars[$k] = $v;
        }
      }
    }
    $qs = '?'.http_build_query($query_vars) . "\n";
  }

  return $qs;
}
*/

function format_query_string($qv = array()) {
  $query_vars = array();

  if ( ! empty($qv)) {
    foreach($qv as $k => $v) {
      $query_vars[$k] = $v;
    }
  }
  $qs = '?'.http_build_query($query_vars) . "\n";
  return $qs;
}

function get_room_by_id($classroom_id) {
  global $mysqli;
  $classroom = array();

  if (empty($classroom_id)) {
    return false;
  }
  $sql = 'SELECT
          classroom.classroom_id,
          classroom.classroom_name,
          booking.booking_startdate,
          booking.booking_enddate,
          user.user_firstname,
          user.user_lastname,
          bookingtime.bookingtime_start,
          bookingtime.bookingtime_end
          FROM tbl_classroom AS classroom
          LEFT JOIN tbl_booking AS booking
          ON classroom.classroom_id = booking.classroom_id
          LEFT JOIN tbl_user AS user
          ON user.user_id = booking.user_id
          LEFT JOIN tbl_bookingtime AS bookingtime
          ON bookingtime.bookingtime_id = booking.bookingtime_id
          WHERE classroom.classroom_id = "'.$classroom_id.'"';
  $query = mysqli_query($mysqli, $sql);
  $num = mysqli_num_rows($query);

  if ($num == 0) {
    return false;
  }

  while($row = mysqli_fetch_assoc($query)) {
    $classroom[] = $row;
  }

  return $classroom;
}

function requireUserLevel($requiredLevel){//Kontrollerar även om användaren är inloggad.
  //echo($requiredLevel."-".gettype($requiredLevel));
  if ($requiredLevel==(-1)) {
    //error_log("hi");
    return true;
  }
  global $_SESSION;
  return isset($_SESSION["user"]['usertype_id'])&&(intval($_SESSION["user"]['usertype_id'])>=$requiredLevel);
}

if($function == "logout"){
session_destroy();
header('Location: index.php');
exit;
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
	$userid = $_SESSION['user']['user_id'];
	$bookingtime = $_POST['bookingtime'];
	$bookingsuccess = "Bokningen lyckades!";

  	if((strlen($classroom) < 1 ) OR (strlen($startdate) < 1) OR (strlen($enddate) < 1) OR (strlen($bookingtime) < 1))
  	{
	$bookingerror = "Du fyllde inte i alla fält. Försök igen!";
	header("location:book_room.php?bookingerror=$bookingerror");
  	}
  	else{
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
      $sql = "INSERT INTO "./*`wukwebbi_grupp1`*/".`tbl_booking` (`booking_id`, `bookingtime_id`, `booking_startdate`, `booking_enddate`, `course_id`, `classroom_id`, `user_id`) 
	VALUES (NULL, 	:bookingtime,	:startdate, 	:enddate, 	'0', 	:classroom, 	:userid);";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		":classroom" => $classroom, 
		":startdate" => $startdate, 
		":enddate" => $enddate, 
		":userid" => $userid,
		":bookingtime" => $bookingtime));
	header("location:book_room.php?bookingsuccess=$bookingsuccess");
	}
	mysqli_free_result($bookingresult);
}}?>
