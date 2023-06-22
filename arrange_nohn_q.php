<?php
include "config.inc.php";	



$type_work_id = $_POST['type_work_id'];
$plan_id = $_POST['plan_id'];
$student_id = $_POST['student_id'];
$teacher_id = $_POST['teacher_id'];
$arrange_nohn_time_type = $_POST['arrange_nohn_time_type'];
$arrange_nohn_type = $_POST['arrange_nohn_type'];
$arrange_nohn_detail  = $conn -> real_escape_string($_POST['arrange_nohn_detail']);

$arrange_nohn_date = $_POST['arrange_nohn_date'];
$arrange_nohn_record_date= date('Y-m-d');
$arrange_nohn_time = date('H:i:s');
$arrange_nohn_check_eval = "0";


$sql= "INSERT INTO tbl_arrange_nohn (arrange_nohn_id, type_work_id, plan_id, student_id, arrange_nohn_date, arrange_nohn_time_type, arrange_nohn_record_date, arrange_nohn_time, arrange_nohn_detail, teacher_id, arrange_nohn_check_eval) VALUES (NULL, '$type_work_id', '$plan_id', '$student_id', '$arrange_nohn_date', '$arrange_nohn_time_type', '$arrange_nohn_record_date', '$arrange_nohn_time', '$arrange_nohn_detail', '$teacher_id', '$arrange_nohn_check_eval');";
$conn->query($sql); 




echo "<script type='text/javascript'>";
//echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
echo "window.location='no_hn.php?student_id=$student_id&type_work_id=$type_work_id&do=success'";
echo "</script>";








?>