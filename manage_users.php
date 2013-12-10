<?php require('functions.php'); ?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');
?>
<body>
<?php require('pageheader.php'); ?>

<div class="container">

  <div class="row table-controls cf">
  
    <div class="col-md-6 add-entry-controls">
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-plus"></span><a href="add_user.php">&nbsp;Lägg&nbsp;till</a>
      </button>
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-minus"></span>&nbsp;Arkivera&nbsp;markerade
      </button>
      <button type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-inbox"></span>&nbsp;Visa&nbsp;arkiverade
      </button>
    </div>
  
    <div class="col-md-6 filter-controls">
      <form class="form-horizontal" role="form">

        <div class="form-group">
          <label for="" class="col-md-4 control-label">Sök användare</label>
          <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Namn">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-md-8 control-label">Användartyp</label>
          <div class="col-md-4">
            <select class="form-control test">
              <option>Alla...</option>
              <option>Elev</option>
              <option>Lärare</option>
              <option>Skoladmin</option>
              <option>Webbadmin</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="col-md-8 control-label">Program</label>
          <div class="col-md-4">
            <select class="form-control test">
              <option>Alla...</option>
              <option>Program 1</option>
              <option>Program 2</option>
              <option>Program 3</option>
              <option>Program 4</option>
              <option>Program 5</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="inputPassword3" class="col-md-10 control-label">Klass</label>
          <div class="col-md-2">
            <select class="form-control">
              <option>Alla...</option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <table class="table table-striped table-condensed user-table">
    <tr>
      <th></th>
      <th>Namn</th>
      <th class="hide-mobile">Email</th>
      <th class="hide-mobile">Telefon</th>
      <th class="hide-mobile">Klass</th>
      <th class="hide-mobile">Program </th>
      <th class="hide-mobile">Behörighet</th>
    </tr>

    <?php
if(isset($_GET["showArchived"])&&($_GET["showArchived"]==1)){
  $showArchived=1;
}else{
  $showArchived=0;
}

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
tbl_user.user_archived = ?
OR tbl_user.user_archived IS NULL;");
    if($stmt = $mysqli->prepare($sql)){
      $stmt->bind_param("s",$showArchived);
      $stmt->execute();
      $stmt->bind_result($id,$user_firstname,$user_lastname,$user_email,$user_access,$user_phonenumber);
      while($data = $stmt->fetch()){
        ?>
    <tr>
      <td>
        <input type="checkbox" name="userCheckbox<?=$id?>" id="userCheckbox<?=$id?>">
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
  </table>

  <ul class="pagination">
    <li><a href="#">&laquo;</a></li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#">&raquo;</a></li>
  </ul>

</div>

<?php require('pagefooter.php'); ?>
	
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>