<?php require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
?>
<body>
<?php require('pageheader.php'); ?>

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

<?php require('pagefooter.php'); ?>
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>