<?php require_once('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Programs - YH Online');

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
  $program_name = mysqli_real_escape_string($mysqli, $_POST['programName']);
  $sth = $pdo->prepare("INSERT INTO tbl_program (program_name) VALUES (:program_name);");
  $sth->bindParam(':program_name', $program_name);
  $sth->execute();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['programName']) && empty($_POST['programName'])) {
  $statusText = "Textfältet tomt, inget program skapades";
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

  <?php if (!empty($statusText)) {
    echo "<p>$statusText</p>";
  }?>  

  <div class="row table-controls cf">

    <div class="col-md-12 add-entry-controls">
      <button type="button" class="btn btn-default" id="add-program"><span class="glyphicon glyphicon-plus"></span>&nbsp;Lägg&nbsp;till</button>
    </div>

  </div>

  <!-- Table -->
  <table class="table table-striped table-condensed program-table">
    <thead>
      <tr>
        <th>Program</th>
      </tr>
    </thead>
    <tbody class="list">
      <?php
      $sql=("SELECT tbl_program.program_name FROM tbl_program");

      if($stmt = $mysqli->prepare($sql)){
        $stmt->execute();
        $stmt->bind_result($programName);
        while($data = $stmt->fetch()){
      ?>
      <tr>
        <td class="schoolProgram hide-mobile"><?php echo utf8_encode($programName); ?></td>
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
  <!-- Populated by list.js -->
</div>

<?php require('pagefooter.php'); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/manage_programs.js"></script>
</body>
</html>