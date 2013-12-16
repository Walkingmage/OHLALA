<?php 
session_start();
require_once("dbconnect.php"); ?>
<?php //require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');

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
<body>
<?php require('pageheader.php'); ?>
<div id="test-list" class="container">

  <div class="row table-controls cf">
  
    <div class="col-md-6 add-entry-controls">
      <?php
      if($showArchived==0){
      ?>
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-plus"></span><a href="add_user.php">&nbsp;Lägg&nbsp;till</a>
      </button>
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
                $usertype_id = $row["usertype_id"];
                echo "<option value='$usertype_id'>".$row['usertype_name']."</option>";
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
  <form id="archiveForm" action="archive.php" method="POST">
    <table class="table table-striped table-condensed user-table">
      <thead>
        <tr>
          <th></th>
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
      //static test data:
      //require 'random_static_list.php';
      $sql=("SELECT
      tbl_user.user_id,
      tbl_user.user_firstname,
      tbl_user.user_lastname,
      tbl_user.user_email,
      tbl_user.usertype_id,
      tbl_user.user_phonenumber
      FROM
      tbl_user
      WHERE
      tbl_user.user_archived = ?;");
      
      if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("s",$showArchived);
        $stmt->execute();
        $stmt->bind_result($id,$user_firstname,$user_lastname,$user_email,$user_access,$user_phonenumber);
        while($data = $stmt->fetch()){
      ?>
        <tr>
          <td>
            <input type="checkbox" name="userCheckbox[<?=$id?>]" id="userCheckbox[<?=$id?>]" class="rowSelectedCheckbox">
          </td>
          <td class="name"><a class="" href="edit_user.php?id=<?php echo"$id";?>"><?php echo $user_firstname . " " . $user_lastname; ?></a></td>
          <td class="email hide-mobile"><?php echo $user_email; ?></td>
          <td class="telephone hide-mobile"><?php echo $user_phonenumber; ?></td>
          <td class="schoolClass hide-mobile"><?php echo "-" ?></td>
          <td class="schoolClass hide-mobile"><?php echo "-" ?></td>
          <td class="access hide-mobile"><?php echo $user_access ?></td>
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
    <input type="hidden" name="selectedUsers" value="">
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
<script type="text/javascript" src="js/manage_users.js"></script>
</body>
</html>