<?php 
session_start();
require_once("pdoconnect.php");
//require_once("dBug.php");//https://github.com/KOLANICH/dBug
?>
<?php //require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');

/*if(isset($_GET["showArchived"])&&($_GET["showArchived"]==1)){
  $showArchived=1;
  $setArchived=0;
  $archiveButtonText="&nbsp;Avarkivera&nbsp;markerade";
  $showArchivedButtonText="&nbsp;Visa&nbsp;oarkiverade";

}else{
  $showArchived=0;
  $setArchived=1;
  $archiveButtonText="&nbsp;Arkivera&nbsp;markerade";
  $showArchivedButtonText="&nbsp;Visa&nbsp;arkiverade";
}*/

?>
    <table class="table table-striped table-condensed user-table">
      <thead>
        <tr>
          <th></th>
          <th class="hide-mobile">DateRange</th>
          <th class="hide-mobile">TimeRange</th>
          <th>Rum</th>
          <th>Veckodag</th>
          <th class="hide-mobile">-</th>
          <th class="hide-mobile">-</th>
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
LEFT JOIN tbl_user ON tbl_user.user_id = tbl_booking.user_id

;";
$q = $pdo->prepare($sql);
//$q->execute(array($title));
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
          <td class="dateRange"><a class="" href="edit_user.php?id=<?php echo"$id";?>"><?php echo $r->booking_startdate. " - " . $r->booking_enddate; ?></a></td>
          <td class="timeRange"><?php echo $r->bookingtime_start. " - " . $r->bookingtime_end; ?></td>
          <td class="room"><?php echo $r->classroom_name. " - " . $r->classroomtype_name; ?></td>
          <td class="weekday hide-mobile"><?php echo "Tisdag(ar)"; ?></td>
          <td class="schoolClass hide-mobile"><?php echo "-" ?></td>
          <?php if(TRUE/*OM ADMIN*/){
            ?>

          <td class="userName hide-mobile"><?php echo "-" ?></td>
            <?php
          }
          ?>
          <td class="access hide-mobile"><?php echo $r->user_firstname. " " . $r->user_lastname; ?></td>
        </tr>
      <?php
    }
      ?>
      </tbody>
    </table>




<?php


//$title = 'PHP AJAX';




?>