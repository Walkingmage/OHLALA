<?php require_once('../functions.php');//pdo/db connect included in functions
$fp = fopen('courses.txt', 'w');
$sql=("SELECT tbl_course.course_id, tbl_course.course_name, tbl_course.course_startdate, tbl_course.course_enddate, tbl_course.program_id FROM tbl_course");
$q = $pdo->prepare($sql);
$q->execute();
$q->setFetchMode(PDO::FETCH_OBJ);
// fetch
while($r = $q->fetch()){
  foreach ($r as $key => $value) {
    switch ($key) {

      case 'course_id':
        $length=5;
        break;
      case 'course_name':
        $length=30;
        break;
      case 'course_startdate':
        $length=11;
        break;
      case 'course_enddate':
        $length=11;
        break;
      case 'program_id':
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
  @header('Location: courses.txt');
}else{
  echo "DONE Exporting Courses<br>";
}
  
  //exit;
//users.txt
?>