<?php
//körs alltid i functions.php \/
/*if (session_status() == PHP_SESSION_NONE) {
  session_start();
} */

/*if (!user_logged_in()) {
   header('Location: index.php');
   die();
}*/
// Get file name
$path = pathinfo($_SERVER['PHP_SELF']);
$file = $path['filename'];

$indexActive = "";
$manageUsersActive = "";
$boolkRoomActive = "";
$bookComputerActive = "";
isset($_SESSION['user']['user_firstname']) ? $firstName = $_SESSION['user']['user_firstname'] : $firstName = "";
isset($_SESSION['user']['user_lastname']) ? $lastName = $_SESSION['user']['user_lastname'] : $lastName = "";


switch ($file) {
	case 'index':
		$indexActive = "active";
		break;
	case 'manage_users':
		$manageUsersActive = "active";
		break;
  case 'manage_courses':
    $manageCoursesActive = "active";
    break;
	case 'book_computer':
		$bookComputerActive = "active";
		break;
  case 'book_room':
    $boolkRoomActive = "active";
    break;
	case 'contact':
		$contactActive = "active";
		break;
	default:
		//do nothing
		break;
}
?>
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
        <a class="navbar-brand" href="index.php">YH <span class="green-brand">On</span>line</a>
      </div>
			<!-- Menu content -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="<?php echo $indexActive; ?>"><a href="index.php">Start</a></li> <!-- What should be displayed on the startpage? -->
          <?php
          if (requireUserLevel(3)) {echo('<li class="<?php echo $manageUsersActive; ?>"><a href="manage_users.php">Hantera konton</a></li>');}
          if (requireUserLevel(3)||requireUserLevel(4)) {echo('<li class="<?php echo $manageCoursesActive; ?>"><a href="manage_courses.php">Hantera kurser</a></li>');}
          if (requireUserLevel(5)||@$_SESSION['dev']) {echo(' <li class="<?php echo $bookComputerActive; ?>"><a href="book_computer.php">Boka dator</a></li>');}
          if (requireUserLevel(1)) {echo('<li class="<?php echo $boolkRoomActive; ?>"><a href="book_room.php">Boka lokal</a></li>');}
          if (requireUserLevel(-1)) {echo('<li class="<?php echo $contactActive; ?>"><a href="contact.php">Kontakta Oss</a></li>');}
          ?>
        </ul>
      </div>

    </div>
  </nav>
</header>
<div class="container cf">
  <?php if (user_logged_in()) {?>
    <div class="user-info">
      <ul>
        <li>Välkommen <?php echo $firstName.' '.$lastName; ?></li>
        <li><a href="?function=logout">Logga ut</a></li>
      </ul>
    </div>
  <?php } ?>
</div>