<?php require_once('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Courses - YH Online');

if(isset($_GET["showArchived"])&&($_GET["showArchived"]==1)){
  $showArchived=1;
  $setArchived=0;
  $archiveButtonText="&nbsp;Avarkivera&nbsp;markerade";
  $showArchivedButtonText="&nbsp;Visa&nbsp;oarkiverade";

}else{
  $showArchived=0;
  $setArchived=1;
  $archiveButtonText="&nbsp;Arkivera&nbsp;markerade";
  $showArchivedButtonText="&nbsp;Visa&nbsp;arkiverade";
}

?>
</head>
<body>
<?php require('pageheader.php');
if (!user_logged_in()) {
   header('Location: index.php');
   die();
}?>

<div id="test-list" class="container">

  <div class="row table-controls cf">

    <div class="col-md-6 add-entry-controls">
      <?php
      if($showArchived==0){
      ?><a href="edit_course.php">
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-plus"></span>&nbsp;Lägg&nbsp;till
      </button></a>
      <?php
       }
       ?>
      <button type="button" class="btn btn-default" id="archiveButton">
        <span class="glyphicon glyphicon-minus"></span><?php echo ($archiveButtonText); ?>
      </button>
      <a href="<?php echo (basename($_SERVER['PHP_SELF'])."?showArchived=".$setArchived); ?>">
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-inbox"></span><?php echo ($showArchivedButtonText); ?>
      </button>
      </a>
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
          <label for="" class="col-md-8 control-label">Användartyp</label>
          <div class="col-md-4">
            <select class="form-control filterSelector accessSelector">
              <option>Alla...</option>
              <?php
              //$query = "SELECT * FROM `tbl_usertype`";
              //$result = mysqli_query($mysqli, $query) or die ();
              //while($row = mysqli_fetch_array($result)){
              //  echo "<option value='".utf8_encode($row['usertype_name'])."'>".utf8_encode($row['usertype_name'])."</option>";
              //}
              //mysqli_free_result($result);
              ?>
            </select>
          </div>
        </div> -->

        <div class="form-group">
          <label for="" class="col-md-8 control-label">Program/Fristående</label>
          <div class="col-md-4">
            <select class="form-control filterSelector programSelector">
              <option>Alla...</option>
              <?php
              $query = "SELECT * FROM `tbl_program`";
              $result = mysqli_query($mysqli, $query) or die ();
              while($row = mysqli_fetch_array($result)){
                echo "<option>".$row['program_name']."</option>";
              }
              mysqli_free_result($result);
              ?>
            </select>
          </div>
        </div>

      </form>
    </div>
  </div>

  <!-- Table -->
  <form id="archiveForm" action="archive.php" method="POST">
    <table class="table table-striped table-condensed user-table">
      <thead>
        <tr>
          <th></th>
          <th>Kurs</th>
          <th class="hide-mobile">Börjar</th>
          <th class="hide-mobile">Slutar</th>
          <th class="hide-mobile">Program</th>
        </tr>
      </thead>
      <tbody class="list">

      <?php
      //static test data:
      //require 'random_static_list.php';
      $sql=("SELECT tbl_course.course_id, tbl_course.course_name, tbl_course.course_startdate, tbl_course.course_enddate, tbl_program.program_name FROM tbl_course LEFT JOIN tbl_program ON tbl_course.program_id = tbl_program.program_id WHERE tbl_course.course_archived = ?;");

      if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s",$showArchived);
        $stmt->execute();
        $stmt->bind_result($id,$courseName,$courseStart,$courseEnd,$programName);
        while($data = $stmt->fetch()){
      ?>
        <tr>
          <td>
            <input type="checkbox" name="courseCheckbox[<?=$id?>]" id="userCheckbox[<?=$id?>]" class="rowSelectedCheckbox">
          </td>
          <td class="courseName"><a class="" href="edit_course.php?id=<?php echo"$id";?>"><?php echo $courseName; ?></a></td>
          <td class="courseStart hide-mobile"><?php echo $courseStart; ?></td>
          <td class="courseEnd hide-mobile"><?php echo $courseEnd; ?></td>
          <td class="schoolProgram hide-mobile"><?php echo $programName; ?></td>
        </tr>
      <?php
       }
       $stmt->free_result();
       $stmt->close();
      }else{
       echo $mysqli->error;
      }
      ?>
      </tbody>
    </table>
    <input type="hidden" name="setArchived" value="<?=$setArchived?>">
    <input type="hidden" name="selectedCourses" value="">
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
<script type="text/javascript" src="js/manage_courses.js"></script>
</body>
</html>