<?php require('functions.php'); ?>
<!DOCTYPE html>
<?php
  if (isset($_POST['login'])) {
    $user_login = check_user_login($_POST['email'], $_POST['password']);
  }
?>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Book Computer - Jensen Offline');
?>
<body>
<?php require('pageheader.php'); ?>
<section class="wrapper">

	<div class="container">
		<header>
		     <h1>Jensen Offline</h1>
		</header>
    <?php if ( ! user_logged_in()) { ?>
      <form class="form-signin" method="post" action="">
        <h2 class="form-signin-heading">Logga in här!</h2>
        <input name="email" type="text" class="form-control" placeholder="E-postadress" required="" autofocus="">
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