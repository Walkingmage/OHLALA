<?php
require_once('../functions.php');//pdo/db connect included in functions
$gen_all=true;
require_once('list_users.php');//bortkommenterad pga teckenkodningsfel
require_once('list_usertypes.php');
require_once('list_programs.php');
require_once('list_courses.php');
require_once('list_grades.php');
echo "DONE!";
?>