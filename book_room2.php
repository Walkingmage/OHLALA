<html>
<head>
<meta charset="utf-8">
<?php 
require('functions.php');
require('dbconnect.php');  
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
/*?>
<?php */
require('pageheader.php');
if (!user_logged_in()) {
   header('Location: index.php');
   die();
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="css/datepicker.css">
<script>
$(function() {
  $(".datepicker").datepicker({
    format:'dd/mm/yyyy',
    autoclose: true
  });
});
</script>
</head>
<body>
<!-- Form & action/POST -->
<form class="form add-user-form" name="form add-user-form" action="functions.php?function=bookRoom" method="POST">
<div class="container">
<h3>Boka lokal</h3>

<!-- Välj lokal -->
  <div class="form-group">
          Välj lokal..<br>
            <select name="classroom">
<?php 
        $query = "SELECT * FROM `tbl_classroom`";
        $result = mysqli_query($mysqli, $query) or die ();
        while($row = mysqli_fetch_array($result)){
        echo "<option>" .  $row['classroom_name'];
}?>
            </select>
   </div>

<!-- Välj start & slut datum -->
<br>
  <input class="datepicker" size="16" type="text" value="Startdatum.." data-date-format="mm/dd/yyyy" name ="startdate">
   - 
  <input class="datepicker" size="16" type="text" value="Slutdatum.." name="enddate"><br><br>

<!-- Välj tid -->
<div class="form-group">
  <select class="form-control filterSelector classSelector" name="bookingtime">
  <option>Välj tid..</option>
<?php 
$query = "SELECT * FROM `tbl_bookingtime`";
$result = mysqli_query($mysqli, $query) or die ();
        while($row = mysqli_fetch_array($result)){
        echo "<option>" .  substr($row['bookingtime_start'],0,5) . " - " . substr($row['bookingtime_end'],0,5);
}?>

  </select>
  </div>
<br>

<!-- Spara-knapp -->
<input type="submit" class="btn btn-default" value="Spara" />
</div>
</form>

<!-- footer -->
<?php require('pagefooter.php'); ?>
  
</body>
</html>