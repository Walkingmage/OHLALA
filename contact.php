<?php require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Book Computer - Jensen Offline');
?>
<body>
<?php require('pageheader.php');
if (!requireUserLevel(constLevelPremContact)) {
   header('Location: index.php');
   die();
}
?>

<div class="container contact-page-container">
  <h1>Kontaktuppgifter</h1>
  <p>Administration: 08-645 00 00</p>
  <p>Sjukanmälan: 08-645 45 45</p>
  <p>IT-support: 08-645 99 99</p>
  <hr>
  <h3>Besöksadress</h3>
  <p>Gatan 88</p>
  <p>Stockholm</p>
  <h3>Postadress</h3>
  <p>Box 8490</p>
  <p>120 20 Stockholm</p>
</div>

<?php require('pagefooter.php'); ?>
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>