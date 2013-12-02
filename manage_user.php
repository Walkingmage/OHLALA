<!DOCTYPE html>
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
          <li class="active"><a href="list_trade_request.php">Start</a></li>
          <li><a href="#">Hantera konton</a></li>
          <li><a href="#">Boka dator</a></li>
          <li><a href="#">Boka lokal</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div>
  </nav>  
</header>


<div class="container">



<ul class="nav nav-tabs">
  <li class="active"><a href="#">Kontouppgifter</a></li>
  <li><a href="#">Program</a></li>
  <li><a href="#">Kurser & betyg</a></li>
  <li><a href="#">LIA</a></li>
</ul>



<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputFname" class="col-sm-2 control-label">Förnamn</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputFname" placeholder="Förnamn">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEname" class="col-sm-2 control-label">Efternamn</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEname" placeholder="Efternamn">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Telefon</label>
    <div class="col-sm-10">
      <input type="tel" class="form-control" id="inputEmail3" placeholder="Telefon">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
</form>


</div>

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