<?php
//session_start();
//require('functions.php');
//require_once("dbconnect.php");
require_once("functions.php");
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
<?php require('pageheader.php');
if (!user_logged_in()) {
   header('Location: index.php');
   die();
}
?>

<div class="container"><a href="manage_booking_rooms.php">
        <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-inbox"></span>&nbsp;Hantera&nbsp;bokade&nbsp;lokaler
      </button></a>
  <div class="row cf top-filters room-top-filters">
    <div class="col-md-12">

    </div>
  </div>
  <div class="row cf">
    <div class="col-md-9 main-booking-content room-timeline">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2>Schema</h2>
          <?php
            $qs = (format_query_string()) ? format_query_string() : '';
            if ( ! empty($_GET['classroom_id'])) {
          ?>
          <?php require_once('timeline/timeline.php'); ?>
          <?php } else { ?>
            <p>Börja med att välja en sal till höger!</p>
        <?php } ?>
        </div>
      </div>
    </div>
    <div class="col-md-3 aside-filter-controls">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Visa tider för:</h3>
        </div>
        <div class="panel-body">
           <form class="form-inline" role="form" action="">
            <div class="form-group">
              <?php
                $num_seats = isset($_GET['classroom_numberofseats']) ? $_GET['classroom_numberofseats'] : '';
              ?>
              <label for="input-seats">Minst antal platser</label>
              <input type="number" value="<?php echo $num_seats; ?>" class="form-control seat-filter-control" id="input-seats" name="classroom_numberofseats" min="0">
            </div>

            <div class="form-group">
              <label for="inputProjector">Utrustning</label>
              <select class="form-control projector-select" name="classroom_equipment">
                <option value="" SELECTED>Inget</option>
                <?php
                  $types = get_classroom_eq();
                ?>
                <?php foreach($types as $key => $val) { ?>
                <option value="<?php echo $key; ?>"><?php echo(utf8_encode($val)); ?></option>
                <?php } ?>
              </select>
            </div>
            <input type="hidden" name="classroom_id" value="<?php echo isset($_GET['classroom_id']) ? $_GET['classroom_id'] : ''; ?>" />
            <div class="form-group button">
              <input type="submit" class="btn btn-default top-filter-btn" value="Sök"/>
            </div>
          </form>
        </div>
        <ul class="list-group">
          <?php
            $filter = null;
            if ( ! empty($_GET) && count($_GET) > 1) {
              $filter = $_GET;
            }
            $rooms = get_all_rooms($filter);

            if (empty($rooms)) {
              echo("En lokal som motsvarar det angiva vilkoren finns ej");
            }else{
              foreach($rooms as $room) {
              $selected = isset($_GET['classroom_id']) ? $_GET['classroom_id'] : '';//kunde göras utanför loopen
              if (isset($selected) && $selected == $room['classroom_id']) { ?>
                <li class="list-group-item inactive-filter-list-item"><?php echo $room['classroom_name']; ?></li>
              <?php } else { ?>
                <li class="list-group-item <?php echo $selected; ?>"><a href="<?php echo ( ! isset($_GET['classroom_id'])) ? '?classroom_id='.$room['classroom_id'] : format_query_string(array('classroom_id' => $room['classroom_id'])); ?>"><?php echo $room['classroom_name']; ?></a></li>
              <?php } ?>
            <?php } ?>
          <?php } ?>
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
                <option value="">Välj lokal..</option>
                <?php
                  $query = "SELECT * FROM `tbl_classroom`";
                  $result = mysqli_query($mysqli, $query) or die ();
                  while($row = mysqli_fetch_array($result)){
                  $classroom_id = $row["classroom_id"];
                  echo "<option value='$classroom_id'>" .  $row['classroom_name'] . "</option>";
                }
                mysqli_free_result($result);
                ?>
              </select>
            </div>
            <!-- Välj start & slut datum -->
            <div class="form-group">
              <input class="datepicker" type="text" placeholder="Startdatum.." name ="startdate">
              <input class="datepicker" type="text" placeholder="Slutdatum.." name="enddate">
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
<script src="js/jquery-ui.custom.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/datepicker_initiate.js"></script>
<script src="js/show_room_booking.js"></script>

</body>
</html>