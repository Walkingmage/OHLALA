<?php require_once('../functions.php');//pdo/db connect included in functions
$fp = fopen('grades.txt', 'w');
$sql=("SELECT tbl_grade.grade_id, tbl_grade.grade_grade, tbl_grade.grade_comment, tbl_grade.user_id, tbl_grade.course_id FROM tbl_grade");
$q = $pdo->prepare($sql);
$q->execute();
$q->setFetchMode(PDO::FETCH_OBJ);
// fetch
while($r = $q->fetch()){
  foreach ($r as $key => $value) {
    switch ($key) {
      case 'grade_id':
        $length=5;
        break;
      case 'grade_grade':
        $length=10;
        break;
      case 'grade_comment':
        $length=50;
        break;
      case 'user_id':
        $length=10;
        break;
      case 'course_id':
        $length=5;
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
  @header('Location: grades.txt');
}else{
  echo "DONE Exporting Grades<br>";
}
  
  //exit;
//users.txt
?>