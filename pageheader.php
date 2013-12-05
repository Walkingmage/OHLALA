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
          <?php #if (user_logged_in()) { ?>
          <li class="<?php echo $manageUsersActive; ?>"><a href="manage_users.php">Hantera konton</a></li>
          <li class="<?php echo $bookComputerActive; ?>"><a href="book_computer.php">Boka dator</a></li>
          <li class="<?php echo $boolkRoomActive; ?>"><a href="book_room.php">Boka lokal</a></li>
          <?php if (user_logged_in()) { ?>
          <li><a href="#">Inloggad användare: <?php echo $_SESSION['user']['user_firstname'].' '.$_SESSION['user']['user_lastname']; ?></a></li>
          <li><a href="?logout">Logga ut</a></li>
          <?php } ?>
          <?php #} ?>
        </ul>
      </div>

    </div>
  </nav>  
</header>