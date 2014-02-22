<?php require_once('../functions.php');//pdo/db connect included in functions
$fp = fopen('programs.txt', 'w');
$sql=("SELECT tbl_program.program_id, tbl_program.program_name, tbl_program.program_startdate, tbl_program.program_enddate FROM tbl_program");
$q = $pdo->prepare($sql);
$q->execute();
$q->setFetchMode(PDO::FETCH_OBJ);
// fetch
while($r = $q->fetch()){
  foreach ($r as $key => $value) {
    switch ($key) {
      case 'program_id':
          $length=5;
        break;
      case 'program_name':
          $length=20;
        break;
      case 'program_startdate':
          $length=10;
        break;
      case 'program_enddate':
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
  @header('Location: programs.txt');
}else{
  echo "DONE Exporting Programs<br>";
}
  
  //exit;
//users.txt
?>