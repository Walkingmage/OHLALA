<?php require_once('../pdoconnect.php');
$fp = fopen('users.txt', 'a');
$sql=("SELECT tbl_user.user_id, tbl_user.user_firstname, tbl_user.user_lastname, tbl_user.user_jensenemail, tbl_user.user_phonenumber, tbl_user.usertype_id, tbl_user.program_id FROM tbl_user WHERE tbl_user.user_archived = 1 AND tbl_user.usertype_id <3 ;");
$q = $pdo->prepare($sql);
$q->execute();
$q->setFetchMode(PDO::FETCH_OBJ);
// fetch
while($r = $q->fetch()){
  foreach ($r as $key => $value) {
    switch ($key) {
      case 'user_id':
          $length=10;
          $padmode="0L";
        break;
      case 'user_firstname':
          $length=15;
          $padmode="BR";
        break;
      case 'user_lastname':
          $length=15;
        break;
      case 'user_jensenemail':
          $length=40;
        break;
      case 'user_phonenumber':
          $length=20;
        break;
      case 'usertype_id':
          $length=4;
        break;
      case 'program_id':
          $length=4;
        break;
      
      default:
          $length=13;
        break;
    }
    /*
    tbl_user.user_id
    tbl_user.user_firstname
    tbl_user.user_lastname
    tbl_user.user_jensenemail
    tbl_user.user_phonenumber
    tbl_user.usertype_id
    tbl_user.program_id
    */
   /*if ($padmode=="0L") {
      fwrite($fp, substr(str_pad($value, $length,"0", STR_PAD_LEFT), 0, $length));
    } else {*/
      fwrite($fp, substr(str_pad($value, $length), 0, $length));
   // }
    
    # code...
  }



  fwrite($fp, "\r\n");
try {
  $sqlupd=("UPDATE tbl_user SET tbl_user.user_archived = 2 WHERE tbl_user.user_archived = 1 AND tbl_user.user_id = :user_id LIMIT 1;");
  $stmt = $pdo->prepare($sqlupd);
  $stmt->bindParam(':user_id', $r->user_id);
  $stmt->execute();
  if($rowCount=$stmt->rowCount()!=1){
    error_log("ERROR archiving userid ".$r->user_id);
  }
  //throw new Exception("Error Processing Request", 1);
  
} catch (Exception $e) {
    error_log("ERROR archiving userid ".$r->user_id." Exception thrown: ".$e->getMessage());
}


  //print_r($r);
  //new dBug($r);
}
//fwrite($fp, "\n");//write end of file here
fclose($fp);
//echo "DONE";
if (!isset($gen_all)) {
  @header('Location: users.txt');
}else{
  echo "DONE Exporting Users<br>";
}
  //exit;
//users.txt
?>