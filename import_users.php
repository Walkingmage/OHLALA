<?php
//include("dbconnect.php");

?><!DOCTYPE html>
<html>
<head>
  <title>Jensen offline</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
</head>

<body>
<header>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container"><!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Brand</a>
      </div>
        
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">  
          <li class="active"><a href="#">Start</a></li>
          <li><a href="#">Hantera konton</a></li>
          <li><a href="#">Boka dator</a></li>
          <li><a href="#">Boka lokal</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div>
  </nav>  
</header>

<div class="container">
<h3>Importera Användare</h3>
<form class="form add-user-form" role="form" action="add_user.php" method="post" enctype="multipart/form-data">
  

<?php

/*addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu',1);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu',2);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu',3);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu',4);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu',5);*/

?>
  <div class="row add-user-row">
    <div class="col-sm-6">
      <div class="form-group">
        <label for="inputFile">File input</label>
        <input type="file" id="inputFile" name="inputFile">
        <p class="help-block">Example block-level help text here.</p>
      </div>
      <?php /*<div class="form-group">
        <label for="inputSeparator" class="control-label">Separator</label>
        <div class="">
          <input type="text" class="form-control" id="inputSeparator" value="," maxlength="1">
        </div>
      </div>
      <div class="form-group">
        <label for="inputEnclosure" class="control-label">Separator</label>
        <div class="">
          <input type="text" class="form-control" id="inputRnclosure" value="" maxlength="1">
        </div>
      </div>*/?>
    </div>
  </div>
  <div class="row save-button-row">
    <div class="form-group">
      <div class="col-sm-12">
        <button type="submit" class="btn btn-default">Importera fil</button>
      </div>
    </div>
  </div>
</form>

</div> <!-- // .container -->

<footer>
  <p>support@jensenoffline.com</p>
  <p>The footer will be moved down a bit with js. Not implemented in mockup</p>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>