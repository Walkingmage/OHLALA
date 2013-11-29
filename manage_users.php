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
  <nav class="navbar navbar-default" role="navigation">
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
  <div class="manage-user-controls">
    <button type="button" class="btn btn-default">
      <span class="glyphicon glyphicon-plus"></span> Lägg till
    </button>
    <button type="button" class="btn btn-default">
      <span class="glyphicon glyphicon-minus"></span> Arkivera markerade
    </button>
    <button type="button" class="btn btn-default">
      <span class="glyphicon glyphicon-inbox"></span> Visa arkiverade
    </button>
  </div>

  <!-- Table -->
  <table class="table">
    <tr><th>Namn </th><th>Email</th><th>Telefon</th><th>Klass</th><th>Program </th><th>Rättigheter</th></tr>
    <tr><td>Andreas Smedjebacka</td><td>d@f.com</td><td>45465165</td><td>1A</td><td>sdf</td><td>Student</td></tr>
    <tr><td>Andreas</td><td>d@f.com </td><td>45465165</td><td>sdf</td><td>sdf</td><td>afk</td></tr>
    <tr><td>Henrik </td><td>d@f.com </td><td>7314181</td><td>2B</td><td>Webbutveckling  </td><td>Elev</td></tr>
    <tr><td>Robert Karlsson</td><td>d@f.com</td><td>678</td><td>Webb1,Webb2</td><td>Webbutveckling</td><td>Lärare</td></tr>
    <tr><td>Svenne</td><td>d@f.com </td><td>8151701</td><td>3F</td><td>Rymdforskare</td><td>Lärare</td></tr>
  </table>

  <ul class="pagination">
    <li><a href="#">&laquo;</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#">&raquo;</a></li>
  </ul>

</div>
	
<footer>
  
</footer>
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>