<?php 
session_start();
//require('functions.php');
require_once("dbconnect.php");
?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Book Room - Jensen Offline');
  ?>
  <link rel="stylesheet" type="text/css" href="css/datepicker.css">
</head>
<body>
<?php require('pageheader.php'); ?>

<div class="container">
  <div class="row cf top-filters room-top-filters">
    <div class="col-md-12">
      <form class="form-inline" role="form">
        <div class="form-group">
          <label for="input-seats">Minst antal platser</label>
          <input type="text" class="form-control seat-filter-control" id="input-seats">
        </div>
        <div class="form-group">
          <label for="inputProjector">Projektor</label>
          <select class="form-control projector-select">
            <option>Ja</option>
            <option>Nej</option>
            <option>Spelar ingen roll</option>
          </select>
        </div>
        <button type="submit" class="btn btn-default top-filter-btn">En knapp, om det behövs</button>
      </form>
    </div>
  </div>
  <div class="row cf">
    <div class="col-md-9 main-booking-content room-timeline">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2>Timeline placeholder</h2>
        </div>
      </div>
    </div>
    <div class="col-md-3 aside-filter-controls">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Visa tider för:</h3>
        </div>
<!--    <div class="panel-body">
          Här kan man också lägga filterkontroller
        </div> -->
        <ul class="list-group">
          <li class="list-group-item">Sal 123</li>
          <li class="list-group-item">Sal 444</li>
          <!-- Utgråad för att visa att den inte matchar valen i .top-filters -->
          <li class="list-group-item inactive-filter-list-item">Sal 555</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row cf book-controls book-room">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <!-- Form & action/POST -->
          <h3>Boka lokal</h3>
          <form role="form" class="book-form" action="functions.php?function=bookRoom" method="POST">
            <!-- Välj lokal -->
            <div class="form-group">
              <select id="classroom" name="classroom" class="form-control">
                <option>Välj lokal..</option>
                <?php 
                  $query = "SELECT * FROM `tbl_classroom`";
                  $result = mysqli_query($mysqli, $query) or die ();
                  while($row = mysqli_fetch_array($result)){
                  $classroom_id = $row["classroom_id"];
                  echo "<option value='$classroom_id'>" .  $row['classroom_name'] . "</option>";
                }?>
              </select>
            </div>
            <!-- Välj start & slut datum -->
            <div class="form-group">
              <input class="datepicker" type="text" value="Startdatum.." name ="startdate">
               - 
              <input class="datepicker" type="text" value="Slutdatum.." name="enddate">
            </div>
            <!-- Välj tid -->
            <div class="form-group">

              <select class="form-control filterSelector classSelector" name="bookingtime">
                <option value="">Välj tid..</option>
                <?php 
                $query = "SELECT * FROM `tbl_bookingtime`";
                $result = mysqli_query($mysqli, $query) or die ();
                while($row = mysqli_fetch_array($result)){
                  $bookingtime_id = $row["bookingtime_id"];
                  echo "<option value='$bookingtime_id'>" . substr($row['bookingtime_start'],0,5) . " - " . substr($row['bookingtime_end'],0,5) . "</option>";
                }
                mysqli_free_result($result);
                ?>
              </select>

      </select>
            </div>
            <input type="submit" class="btn btn-default" value="Boka" />   
            <?php 
            $bookingsuccess = $_GET['bookingsuccess'];
            $bookingerror = $_GET['bookingerror'];
            echo " <span style='color:#FF0000'> " .$bookingerror . "</span>";
            echo " <span style='color:#00BF32'> " .$bookingsuccess . "</span>";
            ?>      
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <!-- Empty -->
    </div>
  </div>
</div>

<?php require('pagefooter.php'); ?>
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/datepicker_initiate.js"></script>

</body>
</html>