<?php require_once('../functions.php');//pdo/db connect included in functions
$fp = fopen('usertypes.txt', 'w');
$sql=("SELECT tbl_usertype.usertype_id, tbl_usertype.usertype_name, tbl_usertype.usertype_rights FROM tbl_usertype");
$q = $pdo->prepare($sql);
$q->execute();
$q->setFetchMode(PDO::FETCH_OBJ);
// fetch
while($r = $q->fetch()){
  foreach ($r as $key => $value) {
    switch ($key) {
      case 'usertype_id':
          $length=5;
        break;
      case 'usertype_name':
          $length=20;
        break;
      case 'usertype_rights':
          $length=10;
        break;
      default:
          $length=13;
        break;
    }
  fwrite($fp, substr(str_pad($value, $length), 0, $length));
  }



  fwrite($fp, "\r\n");


  //print_r($r);
  //new dBug($r);
}
//fwrite($fp, "\n");//write end of file here
fclose($fp);
//echo "DONE";
if (!isset($gen_all)) {
  @header('Location: usertypes.txt');
}else{
  echo "DONE Exporting User Types<br>";
}
  //exit;
//users.txt
?>