<meta charset="utf-8">
<?php 
include "config.inc.php"; 
/////////////////////////////////////////  ฟอร์ม  conduct 	/////////////////////////////////////////////////////////////////////////
$plan_id = $_POST['plan_id']; //plan_id
$arrange_id = $_POST['arrange_id']; //arrange_id
$detail_id = $_POST['detail_id']; //arrange_id



$teacher_id = $_POST['teacher_id']; //teacher_id
$student_id = $_POST['student_id']; //student_id
$conduct_date = $_POST['arrange_date']; //student_id

$conduct_time = date('H:i:s');
$conduct_time_type = $_POST['arrange_time_type']; //arrange_time_type


for ($i=0; $i<=30; $i++)
   {

$form_conduct_id = trim($_POST["form_conduct_id" . $i]);  
$conduct_group = trim($_POST["form_conduct_group" . $i]);  
$type_work_id = trim($_POST["type_work_id" . $i]);  
$conduct_score = trim($_POST["conduct_score" . $i]);  
$conduct_note = trim($_POST["conduct_note" . $i]);  

$date_log  = date('Y-m-d H:i:s');
$conduct_log = "IN|$date_log|$teacher_id/";

//update
//$conduct_log   =  ",up|$date_log|$teacher_id/";
//conduct_log = replace(conduct_log, '/','$conduct_log'),

            if($conduct_score!=""){
                $sql_in_conduct = "INSERT INTO tbl_conduct (conduct_id, teacher_id, student_id, conduct_group, type_work_id, conduct_date, conduct_time, conduct_time_type, form_conduct_id, conduct_score, conduct_note, conduct_status, conduct_log) VALUES (NULL, '$teacher_id', '$student_id', '$conduct_group', '$type_work_id', '$conduct_date', '$conduct_time', '$conduct_time_type', '$form_conduct_id', '$conduct_score', '$conduct_note','1','$conduct_log');";
                $conn->query($sql_in_conduct); 
            }

            //echo "<br>";

   }

   



   echo "<script type='text/javascript'>";
   //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
     echo "window.history.back(1)";
   //echo "window.location='evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$conduct_date&arrange_id=$arrange_id'";
   echo "</script>";

   


?>