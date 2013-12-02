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

  <div class="row table-controls cf">
  
    <div class="col-md-6 add-entry-controls">
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-plus"></span>&nbsp;Lägg&nbsp;till
      </button>
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-minus"></span>&nbsp;Arkivera&nbsp;markerade
      </button>
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-inbox"></span>&nbsp;Visa&nbsp;arkiverade
      </button>
    </div>
  
    <div class="col-md-6 filter-controls">
      <form class="form-horizontal" role="form">

        <div class="form-group">
          <label for="" class="col-md-4 control-label">Sök användare</label>
          <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Namn">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-md-8 control-label">Användartyp</label>
          <div class="col-md-4">
            <select class="form-control test">
              <option>Alla...</option>
              <option>Elev</option>
              <option>Lärare</option>
              <option>Skoladmin</option>
              <option>Webbadmin</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-md-8 control-label">Program</label>
          <div class="col-md-4">
            <select class="form-control test">
              <option>Alla...</option>
              <option>Program 1</option>
              <option>Program 2</option>
              <option>Program 3</option>
              <option>Program 4</option>
              <option>Program 5</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-md-10 control-label">Klass</label>
          <div class="col-md-2">
            <select class="form-control">
              <option>Alla...</option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
        </div>

      </form>
    </div>
  </div>

  <!-- Table -->
  <table class="table table-striped table-condensed user-table">
    <tr>
      <th>Namn</th>
      <th class="hide-mobile">Email</th>
      <th class="hide-mobile">Telefon</th>
      <th class="hide-mobile">Klass</th>
      <th class="hide-mobile">Program </th>
      <th class="hide-mobile">Behörighet</th>
    </tr>
    <tr>
      <td><a href="http://google.com">Andreas Smedjebacka</a></td>
      <td class="hide-mobile">d@f.com</td>
      <td class="hide-mobile">45465165</td>
      <td class="hide-mobile">1A</td>
      <td class="hide-mobile">sdf</td>
      <td class="hide-mobile">Student</td>
    </tr>
    <tr>
      <td><a href="http://google.com">Andreas</a></td>
      <td class="hide-mobile">d@f.com </td>
      <td class="hide-mobile">45465165</td>
      <td class="hide-mobile">sdf</td>
      <td class="hide-mobile">sdf</td>
      <td class="hide-mobile">afk</td>
    </tr>
    <tr>
      <td><a href="http://google.com">Henrik </a></td>
      <td class="hide-mobile">d@f.com </td>
      <td class="hide-mobile">7314181</td>
      <td class="hide-mobile">2B</td>
      <td class="hide-mobile">Webbutveckling</td>
      <td class="hide-mobile">Elev</td>
    </tr>
    <tr>
      <td><a href="http://google.com">Robert Karlsson</a></td>
      <td class="hide-mobile">d@f.com</td>
      <td class="hide-mobile">678</td>
      <td class="hide-mobile">Webb1, Webb2</td>
      <td class="hide-mobile">Webbutveckling</td>
      <td class="hide-mobile">Lärare</td></tr>
    <tr>
      <td><a href="http://google.com">Svenne</a></td>
      <td class="hide-mobile">d@f.com</td>
      <td class="hide-mobile">8151701</td>
      <td class="hide-mobile">3F</td>
      <td class="hide-mobile">Rymdforskare</td>
      <td class="hide-mobile">Lärare</td>
    </tr>
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
  <p>Contact details to web support</p>
  <p>Site map</p>
</footer>
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>