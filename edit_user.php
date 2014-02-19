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

<div class="container">

<?php
require 'dbconnect.php';
$urlid = mysqli_real_escape_string($mysqli, $_GET['id']);
if (isset($_GET['success'])) {
  $success = $_GET['success'];
} else {
  $success = "";
}
if (isset($_GET['resetSuccess'])) {
  $resetSuccess = $_GET['resetSuccess'];
} else {
  $resetSuccess = "";
}
$query = "SELECT * FROM `tbl_user` WHERE `user_id` = $urlid";
$result = mysqli_query($mysqli, $query) or die ();
$num = "";

while($row = mysqli_fetch_array($result)){
  $user_firstname= $row["user_firstname"];
  $user_lastname = $row["user_lastname"];
  $user_email = $row["user_email"];
  $user_phonenumber = $row['user_phonenumber'];
  $user_class = "-";
  $user_program = $row['program_id'];
  $user_access = $row['usertype_id'];
  $user_jensenemail = $row['user_jensenemail'];
  $user_username =  $row['user_username'];
  $user_password =  $row['user_password'];
  $user_lastlogin = $row['user_lastlogin'];
}

// mysql_free_result($result);
?>
<form class="form add-user-form" name="form add-user-form" action="functions.php?function=edituser&id=<?php echo $urlid ?>" method="POST">

<?php
 echo '<div class="row add-user-row">
    <div class="col-sm-6">
      <h3>Användare</h3>
      <div class="form-group">
        <label for="inputFname'.$num.'" class="control-label">Förnamn</label>
        <div class="">
          <input type="text" class="form-control" name="user_firstname" id="inputFname'.$num.'"  value="'.$user_firstname .'" />
        </div>
      </div>
      <div class="form-group">
        <label for="inputEname'.$num.'" class="control-label">Efternamn</label>
        <div class="">
          <input type="text" class="form-control" name="user_lastname" id="inputEname'.$num.'" value="'.$user_lastname.'" />
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail'.$num.'" class="control-label">Privat&nbsp;email</label>
        <div class="">
          <input type="email" class="form-control" name="user_email" id="inputEmail'.$num.'" placeholder="exempel@domän.se" value="'.$user_email.'" />
        </div>
      </div>
      <div class="form-group">
        <label for="inputTelephone'.$num.'" class="control-label">Telefon</label>
        <div class=""> 
          <input type="tel" class="form-control" name="user_phonenumber" id="inputTelephone'.$num.'" placeholder="+46 ..." value="'. $user_phonenumber.'" />
      </div>
      </div>
      <div class="form-group">
        <label for="inputAccess'.$num.'" class="control-label">Behörighet</label>
        <div class="">
        <select name="user_access" id="inputAccess'.$num.'" class="form-control">';
              $query = "SELECT tbl_usertype.usertype_id, tbl_usertype.usertype_name, tbl_usertype.usertype_rights FROM tbl_usertype";
              $result = mysqli_query($mysqli, $query) or die ();
              while($row = mysqli_fetch_array($result)){
                if($user_access==$row["usertype_id"]){
                  echo ('<option selected="selected" value="'.$row["usertype_id"].'">'.utf8_encode($row["usertype_name"]).'</option>');
                }else{
                  echo ('<option value="'.$row["usertype_id"].'">'.utf8_encode($row["usertype_name"]).'</option>');
                }
              }
              mysqli_free_result($result);
              echo '
        </select>
        </div>
      </div>
      <div class="form-group">
        <label for="program'.$num.'" class="control-label">Program</label>
        <div class="">
        <select name="program" id="program'.$num.'" class="form-control">';
              $query = "SELECT tbl_program.program_id, tbl_program.program_name FROM tbl_program";
              $result = mysqli_query($mysqli, $query) or die ();
              while ($row = mysqli_fetch_array($result)) {
                if ($user_program == $row["program_id"]) {
                  echo ('<option selected="selected" value="'.$row["program_id"].'">'.utf8_encode($row["program_name"]).'</option>');
                } else {
                  echo ('<option value="'.$row["program_id"].'">'.utf8_encode($row["program_name"]).'</option>');
                }
              }
              mysqli_free_result($result);
              echo '
        </select>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="jensen-account-info">
        <h3>Användarkonto</h3>
        <p>Användarnamn: <span class="user-name">'.$user_username.'</span></p>
        <p>Jensen mail:<span class="jensen-email">'.$user_jensenemail.'</span></p>
        <p>Last logged in: '.$user_lastlogin.'</p>';
        if (isset($_GET['resetSuccess'])) {
          echo '<p>New password: '.$user_password.'</p>';
        }
        echo '<input type="button" class="btn btn-default" value="Återställ lösenord" onClick="userPasswordReset(' . $urlid . ')" />
        <br><br><span style="color:#00BF32">'.$resetSuccess.'</span>
      </div>
    </div>
  </div>';
?>
  <?php if ($user_access == 1) { ?>
  <div class="row add-user-row">
    <div class="col-sm-12">
      <h3 class="attendants-heading">Studieresultat</h3>
      <table class="table table-striped table-condensed user-courses">
        <thead>
          <tr>
            <th>Kurs</th>
            <th>Betyg</th>
            <th>Period</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $courseQuery = "SELECT tbl_grade.grade_grade, tbl_course.course_name, tbl_course.course_startdate, tbl_course.course_enddate FROM tbl_grade LEFT JOIN tbl_course ON tbl_grade.course_id = tbl_course.course_id WHERE tbl_grade.user_id = ?";
          $sth = $mysqli->prepare($courseQuery);
          $sth->bind_param('s', $urlid);
          $sth->execute();
          $sth->bind_result($grade,$course_name,$course_startdate,$course_enddate);
          while ($data = $sth->fetch()) {
            echo "<tr>
                <td>$course_name</td>
                <td>$grade</td>
                <td>$course_startdate - $course_enddate</td>
            </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php } ?>

  <div class="row save-button-row">
    <div class="form-group">
      <div class="col-sm-12">
        <input type="submit" class="btn btn-default" value="Spara ändringar" />
        <?php echo "<br><br><span style='color:#00BF32'>" .$success . "</span>"?>
      </div>
    </div>
  </div>
</form>

</div> <!-- // .container -->

<?php require('pagefooter.php'); ?>
  
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>