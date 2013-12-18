<?php require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
?>
<body>
<?php require('pageheader.php'); ?>

<div class="container">
<div class="add-user-nav">
  <ul class="nav nav-tabs navbar-left">
    <li class="active"><a href="#">Kontouppgifter</a></li>
    <li><a href="#">Program</a></li>
    <li><a href="#">Kurser & betyg</a></li>
    <li><a href="#">LIA</a></li>
  </ul>
</div>


<?php
require 'dbconnect.php';
$urlid = $_GET['id'];
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
      $user_program = "-";
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
 echo('<div class="row add-user-row">
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
        <select name="user_access" id="inputAccess'.$num.'" class="form-control">
          <option selected="selected">'.$user_access.'</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
        </select>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="jensen-account-info">
        <h3>Användarkonto</h3>
        <p>Användarnamn: <span class="user-name">'.$user_username.'</span></p>
        <p>Jensen mail:<span class="jensen-email">'.$user_jensenemail.'</span></p>
        <p>Last logged in: '.$user_lastlogin.'</p>
        <input type="button" class="btn btn-default" value="Återställ lösenord" onClick="userPasswordReset(' . $urlid . ')" />
        <br><br><span style="color:#00BF32">'.$resetSuccess.'</span>
      </div>
    </div>
  </div>');
?>


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