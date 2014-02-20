<?php require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Edit Course - YH Online');
?>
<link rel="stylesheet" type="text/css" href="css/datepicker.css">
<body>
<?php require('pageheader.php');
if (!user_logged_in()) {
   header('Location: index.php');
   die();
}
?>

<div id="attendant-list" class="container">
  <!-- MODAL -->
  <div class="modal fade" id="addAttendantsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-hidden="true" id="modal-exit-btn">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Lägg till kursdeltagare</h4>
        </div>
        <!-- id for list.js -->
        <div class="modal-body" id="add-attendants-list">
          <div class="form-horizontal" role="form">

            <div class="form-group">
              <label for="" class="col-md-6 control-label">Sök bland visade</label>
              <div class="col-md-6">
                 <input type="text" class="form-control fuzzy-search" placeholder="Fritext">
              </div>
            </div>

            <!-- The selector options should be fetched from the DB! -->
            <div class="form-group">
              <label for="" class="col-md-8 control-label">Användartyp</label>
              <div class="col-md-4">
                <select class="form-control filterSelector accessSelector">
                  <option>Alla...</option>
                  <?php
                  $query = "SELECT * FROM `tbl_usertype`";
                  $result = mysqli_query($mysqli, $query) or die ();
                  while($row = mysqli_fetch_array($result)){
                    echo "<option value='".utf8_encode($row['usertype_name'])."'>".utf8_encode($row['usertype_name'])."</option>";
                  }
                  mysqli_free_result($result);
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="" class="col-md-8 control-label">Program</label>
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

          </div> <!-- /form-horizontal -->
          <table class="table table-striped table-condensed user-table">
            <thead>
              <tr>
                <th></th>
                <th>Namn</th>
                <th class="hide-mobile">Användartyp</th>
                <th class="hide-mobile">Program </th>
              </tr>
            </thead>
            <tbody class="list">

            <?php
            $sql=("SELECT tbl_user.user_id, tbl_user.user_firstname, tbl_user.user_lastname, tbl_usertype.usertype_name, tbl_program.program_name FROM tbl_user LEFT JOIN tbl_usertype ON tbl_user.usertype_id = tbl_usertype.usertype_id LEFT JOIN tbl_program ON tbl_user.program_id = tbl_program.program_id WHERE tbl_user.user_archived = 0;");

            if($stmt = $mysqli->prepare($sql)){
              $stmt->execute();
              $stmt->bind_result($id,$userFirstname,$userLastname,$userType, $programName);
              while($data = $stmt->fetch()){
            ?>
              <tr>
                <td>
                  <input type="checkbox" name="userCheckbox[<?=$id?>]" id="userCheckbox[<?=$id?>]" class="rowSelectedCheckbox">
                </td>
                <td class="name"><?php echo $userFirstname . " " . $userLastname; ?></td>
                <td class="userType hide-mobile"><?php echo utf8_encode($userType) ?></td>
                <td class="schoolProgram hide-mobile"><?php echo utf8_encode($programName) ?></td>
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
          <input type="hidden" name="selectedUsers" value="">
          <!-- Populated by list.js -->
          <ul class="pagination"></ul>
        </div> <!-- /modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="modal-cancel-btn">Avbryt</button>
          <button type="button" class="btn btn-primary" id="modal-add-attendants-btn">Lägg till</button>
        </div>
      </div>
    </div>
  </div> <!-- /modal -->

  <?php
  //If reached by GET = "load course before edit"
  require 'dbconnect.php';
  if (isset($_GET['id'])) {
    //$statusText = "reached by course link, prefilled form loaded";
    $urlid = $_GET['id'];

    $query = "SELECT * FROM `tbl_course` WHERE `course_id` = $urlid";
    $result = mysqli_query($mysqli, $query) or die ();
    
    while ($row = mysqli_fetch_array($result)) {
      $course_name = $row["course_name"];
      $course_startdate = $row["course_startdate"];
      $course_enddate = $row["course_enddate"];
      $course_program_id = $row["program_id"];
    }
  } else { //reached by add course button, load empty form
    $loadEmptyForm = true;
    //$statusText = "reached by add button, empty form loaded";
  }
  
  //If save button was clicked
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = mysqli_real_escape_string($mysqli, $_POST['course_name']);
    $course_startdate = mysqli_real_escape_string($mysqli, $_POST['course_startdate']);
    $course_enddate = mysqli_real_escape_string($mysqli, $_POST['course_enddate']);
    $course_program_id = mysqli_real_escape_string($mysqli, $_POST['course_program_id']);
    
    if (isset($_POST['id']) && !empty($_POST['id'])) { //update course
      $id = mysqli_real_escape_string($mysqli, $_POST['id']);

      //course info
      $sth = $pdo->prepare("UPDATE tbl_course SET course_name = :courseName, course_startdate = :courseStartdate, course_enddate = :courseEnddate, program_id = :programId WHERE course_id = :id");
      $sth->bindParam(':courseName', $course_name);
      $sth->bindParam(':courseStartdate', $course_startdate);
      $sth->bindParam(':courseEnddate', $course_enddate);
      $sth->bindParam(':programId', $course_program_id);
      $sth->bindParam(':id', $id);
      $sth->execute();

      //loop through $_POST to find new or deleted attendants or updated grades
      foreach ($_POST as $key => $value) {
        //create new attendant and grade
        if (strpos($key, 'attendantId_new') === 0) {
          //extract new_num from key
          $new_num = str_replace('attendantId_new_', '', $key);
          $new_num = mysqli_real_escape_string($mysqli, $new_num);
          //read course_id (already done)
          $course_id = $id;
          //extract userId from attendantInfo_new_num
          $user_id = $_POST['attendantInfo_new_'.$new_num];
          $user_id = mysqli_real_escape_string($mysqli, $user_id);
          //extract grade from grade_new_num
          $grade = $_POST['grade_new_'.$new_num];
          $grade = mysqli_real_escape_string($mysqli, $grade);
          //insert tbl_attendant
          $sth = $pdo->prepare("INSERT INTO tbl_attendant (user_id, course_id) VALUES (:user_id, :course_id);");
          $sth->bindParam(':user_id', $user_id);
          $sth->bindParam(':course_id', $course_id);
          $sth->execute();
          //insert tbl_grade
          $sth2 = $pdo->prepare("INSERT INTO tbl_grade (grade_grade, user_id, course_id) VALUES (:grade, :user_id, :course_id);");
          $sth2->bindParam(':grade', $grade);
          $sth2->bindParam(':user_id', $user_id);
          $sth2->bindParam(':course_id', $course_id);
          $sth2->execute();
        }
        //update grade
        if (strpos($key, 'gradeStatus') === 0) {
          $strGradeId = substr($key, (strpos($key, '_')+1) );
          if ($_POST["gradeStatus_$strGradeId"] === "edit") {
            $strGrade = $_POST["grade_$strGradeId"];
            $strGradeId = mysqli_real_escape_string($mysqli, $strGradeId);
            $strGrade = mysqli_real_escape_string($mysqli, $strGrade);

            $gradeQuery = "UPDATE tbl_grade SET grade_grade = :grade WHERE grade_id = :grade_id";
            $sth = $pdo->prepare($gradeQuery);
            $sth->bindParam(':grade', $strGrade);
            $sth->bindParam(':grade_id', $strGradeId);
            $sth->execute();
          }
        }
        //delete attendant and grade
        if (strpos($key, 'attendantId_') === 0 && $value === "delete") {
          //extract num from key
          $attendant_id = str_replace('attendantId_', '', $key);
          $attendant_id = mysqli_real_escape_string($mysqli, $attendant_id);
          //extract gradeId from attendantInfo_num
          $grade_id = str_replace('gradeId_', '', $_POST['attendantInfo_'.$attendant_id]);
          $grade_id = mysqli_real_escape_string($mysqli, $grade_id);
          //delete attendantId from tbl_attendant
          $attendantQuery = "DELETE FROM tbl_attendant WHERE attendant_id = :attendant_id";
          $sth = $pdo->prepare($attendantQuery);
          $sth->bindParam(':attendant_id', $attendant_id);
          $sth->execute();
          //delete gradeId from tbl_grade
          $gradeQuery = "DELETE FROM tbl_grade WHERE grade_id = :grade_id";
          $sth2 = $pdo->prepare($gradeQuery);
          $sth2->bindParam(':grade_id', $grade_id);
          $sth2->execute();
        }
        $statusText = "Ändringarna sparades";
      }
    } else { //add new course
      $sth = $pdo->prepare("INSERT INTO tbl_course (course_name, course_startdate, course_enddate, program_id) VALUES (:courseName, :courseStartdate, :courseEnddate, :programId)");
      $sth->bindParam(':courseName', $course_name);
      $sth->bindParam(':courseStartdate', $course_startdate);
      $sth->bindParam(':courseEnddate', $course_enddate);
      $sth->bindParam(':programId', $course_program_id);
      $sth->execute();
      $statusText = "Ny kurs skapad";
    }
  }
  
  ?>
  <form class="form edit-course-form" name="form edit-course-form" action="edit_course.php" method="POST">
    <input type="hidden" name="id" value="<?php if (isset($urlid)) { echo $urlid; } elseif (isset($id)) { echo $id; } ?>" />

    <?php
      echo '<p>'.$statusText.'</p>';
    ?>
    <!-- require 'add_course_form.php'; -->
    <div class="row edit-course-row">
      <div class="col-sm-6">
        <h3>Kurs</h3>
        
        <div class="form-group">
          <label for="course_name" class="control-label">Namn</label>
          <div class="">
            <input type="text" class="form-control" name="course_name" id="course_name" value="<?php if (isset($course_name)) { echo $course_name; } ?>" />
          </div>
        </div>

        <div class="form-group cf">
          <label class="float-label" for="">Start- och slutdatum</label>
          <input class="datepicker form-control" type="text" placeholder="Startdatum" name="course_startdate" value="<?php if (isset($course_startdate)) { echo $course_startdate; } ?>">
          <input class="datepicker form-control" type="text" placeholder="Slutdatum" name="course_enddate" value="<?php if (isset($course_enddate)) { echo $course_enddate; } ?>">
        </div>

        <div class="form-group">
          <label for="course_program_id" class="control-label">Program / Fristående kurs</label>
          <select name="course_program_id" class="form-control">
            <?php
            $query = "SELECT program_id, program_name FROM tbl_program";
            $result = mysqli_query($mysqli, $query) or die ();
            while ($row = mysqli_fetch_array($result)) {
              if (isset($course_program_id)) {
                if ($course_program_id == $row["program_id"]) {
                  echo '<option selected="selected" value="'.$row["program_id"].'">'.utf8_encode($row["program_name"]).'</option>';
                } else {
                  echo '<option value="'.$row["program_id"].'">'.utf8_encode($row["program_name"]).'</option>';
                }
              } else {
                echo '<option value="'.$row["program_id"].'">'.utf8_encode($row["program_name"]).'</option>';
              }
            }
            mysqli_free_result($result);
            ?>
          </select>
        </div>

      </div>
    </div>
    <?php
    //if page is reached from edit-link, or reached from a edit-page save-click
    if (isset($_GET['id']) || ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['id']) && !empty($_POST['id'])))) {
      if (isset($_GET['id'])) {
        $course_id = $_GET['id'];
      }
      if (isset($_POST['id']) && !empty($_POST['id'])) {
        $course_id = $_POST['id'];
      } ?>
      <div class="row edit-course-row">
        <div class="col-sm-12">
          <h3 class="attendants-heading">Deltagare</h3>
          <div class="row table-controls cf">

            <div class="col-md-6 add-entry-controls">
              <button type="button" class="btn btn-default" id="add-attendant">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;Lägg&nbsp;till
              </button>
              <button type="button" class="btn btn-default" id="delete-attendant">
                <span class="glyphicon glyphicon-minus"></span>&nbsp;Ta&nbsp;bort&nbsp;markerade
              </button>
            </div>

            <div class="col-md-6 filter-controls">
              <div class="form-horizontal" role="form">

                <div class="form-group">
                  <label for="" class="col-md-4 control-label">Sök bland visade</label>
                  <div class="col-md-8">
                     <input type="text" class="form-control fuzzy-search" placeholder="Fritext">
                  </div>
                </div>

              </div> <!-- /form-div -->
            </div> <!-- /col -->
          </div> <!-- /row -->
          
          <table class="table table-striped table-condensed attendant-table">
            <thead>
              <tr>
                <th></th>
                <th>Namn</th>
                <th class="hide-mobile">Användartyp</th>
                <th class="hide-mobile">Betyg</th>
                <th class="hide-mobile">Program</th>
              </tr>
            </thead>
            <tbody class="list">
            <?php
            $sql=("SELECT tbl_user.user_id, tbl_user.user_firstname, tbl_user.user_lastname, tbl_user.usertype_id, tbl_usertype.usertype_name, tbl_program.program_name, tbl_attendant.attendant_id, tbl_grade.grade_grade, tbl_grade.grade_id FROM tbl_user LEFT JOIN tbl_usertype ON tbl_user.usertype_id = tbl_usertype.usertype_id LEFT JOIN tbl_program ON tbl_user.program_id = tbl_program.program_id LEFT JOIN tbl_grade ON tbl_user.user_id = tbl_grade.user_id LEFT JOIN tbl_attendant ON tbl_user.user_id = tbl_attendant.user_id WHERE tbl_attendant.course_id = ? AND tbl_grade.course_id = ? AND tbl_user.user_archived = 0;");

            if($stmt = $mysqli->prepare($sql)){
              $stmt->bind_param("ss",$course_id,$course_id);
              $stmt->execute();
              $stmt->bind_result($userId,$userFirstname,$userLastname,$userTypeId,$userTypeName,$programName,$attendantId,$grade,$gradeId);
              while($data = $stmt->fetch()){
            
              echo '<tr>
                <td class="attendant-checkbox">
                  <input type="hidden" name="attendantId_'.$attendantId.'" value="'.$attendantId.'" />
                  <input type="hidden" name="attendantInfo_'.$attendantId.'" value="gradeId_'.$gradeId.'" />                  
                  <input type="checkbox" name="attendantCheckbox_'.$attendantId.'" id="attendantCheckbox_'.$attendantId.'" class="rowSelectedCheckbox attendantCheckbox">
                </td>
                <td class=""><input type="hidden" name="userId_'.$userId.'" value="'.$userId.'"><a class="name" href="edit_user.php?id='.$userId.'">'.$userFirstname.' '.$userLastname.'</a></td>
                <td class="userType hide-mobile">'.utf8_encode($userTypeName).'</td>
                <td class="grade hide-mobile">
                  <input type="hidden" name="gradeId_'.$gradeId.'" value="'.$gradeId.'" />
                  <input type="hidden" name="gradeStatus_'.$gradeId.'" value="" class="grade-status"/>
                  <select name="grade_'.$gradeId.'" class="form-control grade-select">';
                    if ($userTypeId != '2') {
                      if (empty($grade) || $grade == '0') {echo '<option class="grade-value" selected="selected" value="0">Inget</option>';} else {echo '<option value="0">Inget</option>';}
                      if ($grade == 'IG') {echo '<option class="grade-value" selected="selected" value="IG">IG</option>';} else {echo '<option value="IG">IG</option>';}
                      if ($grade == 'G') {echo '<option class="grade-value" selected="selected" value="G">G</option>';} else {echo '<option value="G">G</option>';}
                      if ($grade == 'VG') {echo '<option class="grade-value" selected="selected" value="VG">VG</option>';} else {echo '<option value="VG">VG</option>';}
                    } else {
                      echo '<option class="grade-value" selected="selected" value="0">Inget</option>'; 
                    }
                  echo '</select>
                </td>
                <td class="schoolProgram hide-mobile">'.utf8_encode($programName).'</td>
              </tr>';
             }
             $stmt->free_result();
             $stmt->close();
            }else{
             echo $mysqli->error;
            }
            echo '</tbody>
          </table>
        </div>
      </div>';
    }
    ?>

    <table class="removed-attendants">
      
    </table>

    <div class="row save-button-row">
      <div class="form-group">
        <div class="col-sm-12">
          <input type="submit" class="btn btn-default" value="Spara ändringar" />
          <?php //echo "<br><br><span style='color:#00BF32'>" .$success . "</span>"?>
        </div>
      </div>
    </div>
  </form>

</div> <!-- // .container -->

<?php require('pagefooter.php'); ?>
  
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<script src="js/jquery-ui.custom.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/datepicker_initiate.js"></script>
<script type="text/javascript" src="js/list.js"></script>
<script type="text/javascript" src="js/list.pagination.min.js"></script>
<script type="text/javascript" src="js/list.fuzzysearch.min.js"></script>
<script src="js/edit_course.js"></script>
</body>
</html>