<?php 
session_start();
require_once("pdoconnect.php");
require_once("functions.php");
//require_once("dBug.php");//https://github.com/KOLANICH/dBug
?>
<?php //require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
$daynames['se']['1']="Måndag";
$daynames['se']['2']="Tisdag";
$daynames['se']['3']="Onsdag";
$daynames['se']['4']="Torsdag";
$daynames['se']['5']="Fredag";
$daynames['se']['6']="Lördag";
$daynames['se']['7']="Söndag";


?>




<body>
<?php require('pageheader.php'); ?>
<div id="test-list" class="container">

  <div class="row table-controls cf">
  
    <div class="col-md-6 add-entry-controls">
      <button type="button" class="btn btn-default" id="unbookButton">
        <span class="glyphicon glyphicon-minus"></span>&nbsp;Avboka
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

<!--         <div class="form-group">
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
        </div> -->
      </form>
    </div>
  </div>

  <form id="unbookForm" action="unbook_rooms.php" method="POST">
    <table class="table table-striped table-condensed user-table">
      <thead>
        <tr>
          <th></th>
          <th>Datum</th>
          <th>Tid</th>
          <th>Rum</th>
          <th class="hide-mobile">Veckodag</th>
          <th class="hide-mobile">Bokad av</th>
        </tr>
      </thead>
      <tbody class="list">

      <?php
// query
$sql = "SELECT
tbl_booking.booking_id,
tbl_booking.booking_startdate,
tbl_booking.booking_enddate,
tbl_booking.course_id,
tbl_booking.classroom_id,
tbl_booking.user_id,
tbl_bookingtime.bookingtime_id,
tbl_bookingtime.bookingtime_start,
tbl_bookingtime.bookingtime_end,
tbl_booking.bookingtime_id,
tbl_classroom.classroom_name,
tbl_classroom.classroom_type,
tbl_classroom.classroom_numberofseats,
tbl_classroom.classroom_equipment,
tbl_classroomtype.classroomtype_name,
tbl_course.course_name,
tbl_course.course_startdate,
tbl_course.course_enddate,
tbl_course.program_id,
tbl_user.user_id,
tbl_user.user_firstname,
tbl_user.user_lastname,
tbl_user.user_email,
tbl_user.user_jensenemail,
tbl_user.user_phonenumber,
tbl_user.user_username,
tbl_user.usertype_id,
tbl_user.user_archived,
tbl_user.user_lastlogin
FROM
tbl_booking
LEFT JOIN tbl_bookingtime ON tbl_booking.bookingtime_id = tbl_bookingtime.bookingtime_id
LEFT JOIN tbl_classroom ON tbl_classroom.classroom_id = tbl_booking.classroom_id
LEFT JOIN tbl_classroomtype ON tbl_classroomtype.classroomtype_id = tbl_classroom.classroom_type
LEFT JOIN tbl_course ON tbl_course.course_id = tbl_booking.course_id
LEFT JOIN tbl_user ON tbl_user.user_id = tbl_booking.user_id;";
$q = $pdo->prepare($sql);
$q->execute();


$q->setFetchMode(PDO::FETCH_OBJ);

// fetch
while($r = $q->fetch()){
  //print_r($r);
  //new dBug($r);
      ?>
        <tr>
          <td>
            <input type="checkbox" name="userCheckbox[<?=$r->booking_id?>]" id="userCheckbox[<?=$r->booking_id?>]" class="rowSelectedCheckbox">
          </td>
          <td class="dateRange"><?php echo $r->booking_startdate. " - " . $r->booking_enddate; ?></td>
          <td class="timeRange"><?php echo $r->bookingtime_start. " - " . $r->bookingtime_end; ?></td>
          <td class="room"><?php echo $r->classroom_name. " - " . $r->classroomtype_name; ?></td>
          <td class="weekday hide-mobile"><?php echo $daynames['se'][date('N', strtotime( $r->booking_startdate))]; ?></td>
          <td class="access hide-mobile"><?php echo $r->user_firstname. " " . $r->user_lastname; ?></td>
        </tr>
  <?php
  }
  ?>
      </tbody>
    </table>

    <input type="hidden" name="selectedBookings" value="">
  </form>
<!-- Populated by list.js -->
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
<script type="text/javascript" src="js/manage_booking_rooms.js"></script>
</body>
</html>


<?php


//$title = 'PHP AJAX';




?>