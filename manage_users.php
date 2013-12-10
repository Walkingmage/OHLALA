<?php //require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
?>
<body>
<?php require('pageheader.php'); ?>

<div id="test-list" class="container">

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
          <label for="" class="col-md-4 control-label">Sök bland visade</label>
          <div class="col-md-8">
             <input type="text" class="form-control fuzzy-search" placeholder="Fritext">
          </div>
        </div>

      <!-- The selector options should be fetched from the DB! -->
        <div class="form-group">
          <label for="" class="col-md-8 control-label">Användartyp</label>
          <div class="col-md-4">
            <select class="form-control filterSelector accessSelector">
              <option>Alla...</option>
              <option>Elev</option>
              <option>Lärare</option>
              <option>Programadmin</option>
              <option>Webbadmin</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-md-8 control-label">Program</label>
          <div class="col-md-4">
            <select class="form-control filterSelector programSelector">
              <option>Alla...</option>
              <option>Webbutveckling</option>
              <option>Cobolprogrammerare</option>
              <option>IT-projektledare</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-md-10 control-label">Klass</label>
          <div class="col-md-2">
            <select class="form-control filterSelector classSelector">
              <option>Alla...</option>
              <option>1A</option>
              <option>1B</option>
              <option>1C</option>
              <option>1D</option>
              <option>1E</option>
              <option>2A</option>
              <option>2B</option>
              <option>2C</option>
              <option>2D</option>
              <option>2E</option>
              <option>3A</option>
              <option>3B</option>
              <option>3C</option>
              <option>3D</option>
              <option>3E</option>
            </select>
          </div>
        </div>

      </form>
    </div>
  </div>

  <!-- Table -->
  <table class="table table-striped table-condensed user-table">
    <thead>
      <tr>
        <th>Namn</th>
        <th class="hide-mobile">Email</th>
        <th class="hide-mobile">Telefon</th>
        <th class="hide-mobile">Klass</th>
        <th class="hide-mobile">Program </th>
        <th class="hide-mobile">Behörighet</th>
      </tr>
    </thead>
    <tbody class="list">
    <?php
      //Include phpfile with random entries
      include('random_static_list.php');
      //Generate random entries
      // $firstNameArray = array('Adam', 'Bertil', 'Ceasar', 'David', 'Erik');
      // $lastNameArray = array('Adamsson', 'Bertilsson', 'Ceasarsson', 'Davidsson', 'Eriksson');
      // $programArray = array('Webbutveckling', 'Cobolprogrammerare', 'IT-projektledare');
      // $accessArray = array('Elev', 'Lärare', 'Programadmin', 'Webbadmin');
      // for ($i=0; $i < 52; $i++) { 
      //   $randName = $firstNameArray[array_rand($firstNameArray)]." ".$lastNameArray[array_rand($lastNameArray)] ;
      //   $randStr1 = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
      //   $randStr2 = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
      //   $randEmail = $randStr1.'@'.$randStr2.'.com';
      //   $randTelephone = substr(str_shuffle(str_repeat("0123456789", 5)), 0, 7);
      //   $randClass = substr(str_shuffle(str_repeat("123", 5)), 0, 1).substr(str_shuffle(str_repeat("ABCDE", 5)), 0, 1);
      //   $randProgram = $programArray[array_rand($programArray)];
      //   $randAccess = $accessArray[array_rand($accessArray)];
      //   echo '
      //   <tr>
      //     <td class="name"><a class="" href="#">'.$randName.'</a></td>
      //     <td class="email hide-mobile">'.$randEmail.'</td>
      //     <td class="telephone hide-mobile">'.$randTelephone.'</td>
      //     <td class="schoolClass hide-mobile">'.$randClass.'</td>
      //     <td class="schoolProgram hide-mobile">'.$randProgram.'</td>
      //     <td class="access hide-mobile">'.$randAccess.'</td>
      //   </tr>
      //   ';
      // }
    ?>
    </tbody>    
  </table>

<!--   <div id="a-test-list">
    <input type="text" class="a-fuzzy-search" />
    <ul class="list">
      <li><p><span class="name">Guybrush Threepwood</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Elaine Marley</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">LeChuck</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Stan</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Voodoo Lady</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Herman Toothrot</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Meathook</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Carla</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Otis</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Rapp Scallion</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Rum Rogers Sr.</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Men of Low Moral Fiber</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Murray</span> <span class="email">a@test.com</span></p></li>
      <li><p><span class="name">Cannibals</span> <span class="email">a@test.com</span></p></li>
    </ul>
  </div> -->

<!--   <div id="test-list">
    <input type="text" class="fuzzy-search" />
    <table class="list">
      <tr><td class="name">Guybrush Threepwood</td></tr>
      <tr><td class="name">Elaine Marley</td></tr>
      <tr><td class="name">LeChuck</td></tr>
      <tr><td class="name">Stan</td></tr>
      <tr><td class="name">Voodoo Lady</td></tr>
      <tr><td class="name">Herman Toothrot</td></tr>
      <tr><td class="name">Meathook</td></tr>
      <tr><td class="name">Carla</td></tr>
      <tr><td class="name">Otis</td></tr>
      <tr><td class="name">Rapp Scallion</td></tr>
      <tr><td class="name">Rum Rogers Sr.</td></tr>
      <tr><td class="name">Men of Low Moral Fiber</td></tr>
      <tr><td class="name">Murray</td></tr>
      <tr><td class="name">Cannibals</td></tr>
    </table>
  </div> -->

<!--   <ul class="pagination">
    <li><a href="#">&laquo;</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#">&raquo;</a></li>
  </ul> -->

  <ul class="pagination"></ul>

</div>

<?php require('pagefooter.php'); ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/list.js"></script>
<script type="text/javascript" src="js/list.pagination.min.js"></script>
<script type="text/javascript" src="js/list.fuzzysearch.min.js"></script>
<script type="text/javascript" src="js/manage_users_list_search_sort.js"></script>
</body>
</html>