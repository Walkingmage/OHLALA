<?php require_once('functions.php'); ?>
<?php
  if (isset($_POST['login'])) {
    $user_login = check_user_login($_POST['email'], $_POST['password']);
  }
?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Book Computer - Jensen Offline');
?>
<body>

<!-- pageheader starts -->

<?php
// Get file name
$path = pathinfo($_SERVER['PHP_SELF']);
$file = $path['filename'];

$indexActive = "";
$manageUsersActive = "";
$boolkRoomActive = "";
$bookComputerActive = "";

switch ($file) {
  case 'index':
    $indexActive = "active";
    break;
  case 'manage_users':
    $manageUsersActive = "active";
    break;
  case 'book_computer':
    $bookComputerActive = "active";
    break;
  case 'book_room':
    $boolkRoomActive = "active";
    break;
  default:
    //do nothing
    break;
}
?>
<script src="js/functions.js"></script>
<header>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <!-- Mobile menu toggle -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Jensen <span class="red-brand">Offline</span></a>
      </div>
      <!-- Menu content -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="<?php echo $indexActive; ?>"><a href="index.php">Start</a></li> <!-- What should be displayed on the startpage? -->
          <?php if (user_logged_in()) { ?>
          <li class="<?php echo $manageUsersActive; ?>"><a href="manage_users.php">Hantera konton</a></li>
          <li class="<?php echo $bookComputerActive; ?>"><a href="book_computer.php">Boka dator</a></li>
          <li class="<?php echo $boolkRoomActive; ?>"><a href="book_room.php">Boka lokal</a></li>
          <?php } ?>
        </ul>
      </div>

    </div>
  </nav>
</header>

<!-- pageheader ends -->

<section class="wrapper">

	<div class="container">
		<header>
		     <h1>Jensen Offline</h1>
		</header>
    <?php if ( !user_logged_in()) { ?>
      <form class="form-signin" method="post" action="">
        <h2 class="form-signin-heading">Logga in här!</h2>
        <input name="email" type="text" class="form-control" placeholder="Användarnamn" required="" autofocus="">
        <input name="password" type="password" class="form-control" placeholder="Lösenord" required="">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Kom ihåg mig!
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Logga in</button>
      </form>
    <?php } ?>
      <?php if ( isset($user_login) && $user_login == false) { ?>
         <p class="center-text">Fel användarnamn eller lösenord!</p>
      <?php } ?>
    </div>
      </div>
<?php require('pagefooter.php'); ?>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>