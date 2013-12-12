<?php 
session_start();
require_once("dbconnect.php"); ?>
<?php //require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Book Room - Jensen Offline');
?>
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
          <h3 class="panel-title">Välj rum</h3>
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
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2>Booking placeholder</h2>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require('pagefooter.php'); ?>
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>