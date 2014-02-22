<?php require_once('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Programs - YH Online');

if (isset($_GET["showArchived"])&&($_GET["showArchived"]==1)) {
  $showArchived=1;
  $setArchived=0;
  $archiveButtonText="&nbsp;Avarkivera&nbsp;markerade";
  $showArchivedButtonText="&nbsp;Visa&nbsp;oarkiverade";

} else {
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

<?php
$statusText = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['programName']) && !empty($_POST['programName'])) {

  if ($_POST['operationType'] === 'add') {
    $program_name = mysqli_real_escape_string($mysqli, $_POST['programName']);
    $sth = $pdo->prepare("INSERT INTO tbl_program (program_name) VALUES (:program_name);");
    $sth->bindParam(':program_name', $program_name);
    $sth->execute();
    $statusText = "Program skapat";
  } elseif ($_POST['operationType'] === 'edit') {
    $program_name = mysqli_real_escape_string($mysqli, $_POST['programName']);
    $program_id = mysqli_real_escape_string($mysqli, $_POST['programId']);
    $sth = $pdo->prepare("UPDATE tbl_program SET program_name = :program_name WHERE program_id = :program_id;");
    $sth->bindParam(':program_name', $program_name);
    $sth->bindParam(':program_id', $program_id);
    $sth->execute();
    $statusText = "Programnamn ändrat";
  }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['programName']) && empty($_POST['programName'])) {
  $statusText = "Textfältet tomt";
}

?>


<div id="test-list" class="container add-program-container">
  <!-- MODAL -->
  <div class="modal fade" id="addProgramModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-hidden="true" data-dismiss="modal" id="modal-exit-btn">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Lägg till program</h4>
        </div>

        <div class="modal-body">
          <form class="form-horizontal" id="addProgramForm" role="form" action="manage_programs.php" method="POST">

            <div class="form-group">
              <div class="col-md-12">
                 <input type="text" name="programName" class="form-control" placeholder="Programnamn">
                 <input type="hidden" name="operationType" value="add">
                 <input type="hidden" name="programId" value="">                 
              </div>
            </div>

          </form> <!-- /form-horizontal -->
        </div> <!-- /modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
          <button type="button" class="btn btn-primary" id="modal-add-program-btn" onclick="document.getElementById('addProgramForm').submit();">Lägg till</button>
        </div>
      </div>
    </div>
  </div> <!-- /modal -->


  <div class="row table-controls add-entry-controls cf">
    <?php if (!empty($statusText)) {
      echo "<p>$statusText</p>";
    }?>
    <?php
    if($showArchived==0){
    ?>
    <button type="button" id="add-program" class="btn btn-default">
      <span class="glyphicon glyphicon-plus"></span>&nbsp;Lägg&nbsp;till
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

  <div class="row">
    <form id="archiveForm" action="archive.php" method="POST">
      <!-- Table -->
      <table class="table table-striped table-condensed user-table">
        <thead>
          <tr>
            <th></th>
            <th>Program</th>
          </tr>
        </thead>
        <tbody class="list">
          <?php
          $sql=("SELECT tbl_program.program_name, tbl_program.program_id FROM tbl_program  WHERE tbl_program.program_archived = ?;");

          if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s",$showArchived);
            $stmt->execute();
            $stmt->bind_result($programName, $programId);
            while($data = $stmt->fetch()){
          ?>
          <tr>
            <td>
              <input type="checkbox" name="programCheckbox[<?=$programId?>]" id="userCheckbox[<?=$programId?>]" class="rowSelectedCheckbox">
            </td>
            <td class="schoolProgram"><a href="" class="programNameLink" id="<?=$programId?>"><?php echo $programName; ?></a></td>
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
      <input type="hidden" name="selectedPrograms" value="">
    </form>    
  </div>
</div>

<?php require('pagefooter.php'); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/list.js"></script>
<script type="text/javascript" src="js/manage_programs.js"></script>
</body>
</html>