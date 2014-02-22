<?php
function addMenuItem($level,$filename,$text/*,$dev==FALSE*/){
  if (requireUserLevel($level)) {
    $path = pathinfo($_SERVER['PHP_SELF']);
    if (substr($filename, 0, -4)==$path['filename']) {
      $active = "active ";
    }else{
      $active = "";
    }
    echo('<li class="thin-text '.$active.'"><a href="'.$filename.'">'.$text.'</a></li>');
    echo("\r\n");
  }
  return TRUE;
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
        <a class="navbar-brand" href="index.php"><span class="thin-text">YH </span><span class="green-brand">On</span><span class="thin-text">line</span></a>
      </div>
			<!-- Menu content -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="thin-text <?php echo $indexActive; ?>"><a href="index.php">Start</a></li> <!-- What should be displayed on the startpage? -->
          <?php
          addMenuItem(3,"manage_users.php","Hantera konton");
          addMenuItem(3,"manage_courses.php","Hantera kurser");
          addMenuItem(3,"manage_programs.php","Hantera program");
          addMenuItem(3,"book_computer.php","Boka dator");
          addMenuItem(1,"book_room.php","Boka lokal");
          addMenuItem(-1,"contact.php","Kontakta oss");
          ?>
        </ul>
      </div>

    </div>
  </nav>
</header>
<div class="container cf">
  <?php if (user_logged_in()) {
  @$firstName = $_SESSION['user']['user_firstname'];
  @$lastName = $_SESSION['user']['user_lastname'];
  ?>
    <div class="user-info">
      <ul>
        <li>Välkommen <?php echo @$firstName.' '.@$lastName; ?></li>
        <li><a href="?function=logout">Logga ut</a></li>
      </ul>
    </div>
  <?php } ?>
</div>