<?php
//include("dbconnect.php");


function addUserToList($firstname,$lastname,$email,$tel,$num){
  global $premissionOptions;
  echo('<div class="row add-user-row">
    <div class="col-sm-6">
      <h3>Användare</h3>
      <div class="form-group">
        <label for="inputFname'.$num.'" class="control-label">Förnamn</label>
        <div class="">
          <input type="text" class="form-control" name="firstname['.$num.']" id="inputFname'.$num.'" placeholder="Inklusive mellannamn" value="'.$firstname.'">
        </div>
      </div>
      <div class="form-group">
        <label for="inputEname'.$num.'" class="control-label">Efternamn</label>
        <div class="">
          <input type="text" class="form-control" name="lastname['.$num.']" id="inputEname'.$num.'" placeholder="" value="'.$lastname.'">
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail'.$num.'" class="control-label">Privat&nbsp;email</label>
        <div class="">
          <input type="email" class="form-control" name="privemail['.$num.']" id="inputEmail'.$num.'" placeholder="exempel@domän.se" value="'.$email.'">
        </div>
      </div>
      <div class="form-group">
        <label for="inputTelephone'.$num.'" class="control-label">Telefon</label>
        <div class="">
          <input type="tel" class="form-control" name="telephone['.$num.']" id="inputTelephone'.$num.'" placeholder="+46 ..." value="'.$tel.'-'.$num.'">
      </div>
      </div>
      <div class="form-group">
        <label for="inputAccess'.$num.'" class="control-label">Behörighet</label>
        <div class="">
        <select name="access['.$num.']" id="inputAccess'.$num.'" class="form-control">
          '.$premissionOptions.'
        </select>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="jensen-account-info">
        <h3>Användarkonto</h3>
        <p>Användarnamn: <span class="user-name">-</span></p>
        <p>Jensen mail: <span class="jensen-email">-</span></p>
      </div>
    </div>
  </div>');
}



/*?>
<?php*/
require('functions.php');
if (!user_logged_in()) {
   header('Location: index.php');
   die();
}
?>
<!DOCTYPE html>
<html>
<?php
require('html_head.php');
echoHeadWithTitle('Manage Users - Jensen Offline');

function getPremissionOptions($mysqli){
  $premissionOptions="";
  $query = "SELECT tbl_usertype.usertype_id, tbl_usertype.usertype_name, tbl_usertype.usertype_rights FROM tbl_usertype";
  $result = mysqli_query($mysqli, $query) or die ();
  while($row = mysqli_fetch_array($result)){
    $premissionOptions.= ('<option value="'.$row["usertype_id"].'">'.utf8_encode($row["usertype_name"]).'</option>\n');
  }
  mysqli_free_result($result);
  unset($query);
  return $premissionOptions;
}
$premissionOptions=getPremissionOptions($mysqli);

?>
<body>
<?php require('pageheader.php'); ?>

<div class="container">
<div class="add-user-nav">
  <ul class="nav navbar-nav navbar-right">
    <li><a href="import_users.php">Importera</a></li>
  </ul>
</div>

<!-- <form class="form add-user-form" role="form"> -->
<!-- <form class="form add-user-form" role="form">  -->
<form class="form add-user-form" name="form add-user-form" action="confirmation_page.php?function=adduser" method="POST">

<?php

$allowedExts = array("csv", "lol", "tst", "txt");
$target_path = "./";
//print_r($_FILES);
if(isset($_FILES['inputFile'])){
  $target_path = $target_path . basename( $_FILES['inputFile']['name']); 

  $temp = explode(".", $_FILES["inputFile"]["name"]);
  $extension = end($temp);
  unset($temp);
  if(!in_array($extension, $allowedExts)){die("Felaktig Fil!");}
  $row = 0;
  if (($handle = fopen($_FILES['inputFile']['tmp_name'], "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          //$num = count($data);
         // echo "<p> $num fields in line $row: <br /></p>\n";
          /*for ($c=0; $c < $num; $c++) {
              echo $data[$c] . "<br />\n";
          }^*/

        addUserToList($data[0],$data[1],$data[3],$data[4],$row);
        //sleep(1);//uncomment to enable enterprise mode
        $row++;
      }
      fclose($handle);
  }



}else{
addUserToList('','','','',0);


}



/*
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu','4799322574',0);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu','4799322574',1);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu','4799322574',2);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu','4799322574',3);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu','4799322574',4);
addUserToList('Ozell','Nicholson','MxzueK@iPawIS.edu','4799322574',5);
*/







?>
  <div class="row save-button-row">
    <div class="form-group">
      <div class="col-sm-12">
        <!-- <button type="submit" class="btn btn-default">Spara och generera Jensenkonton</button> -->
        <input type="submit" class="btn btn-default" value="Spara och generera Jensenkonton" />
      </div>
    </div>
  </div>
</form>

</div> <!-- // .container -->

<?php require('pagefooter.php'); ?>
  
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>