<?php include "header.php";
include "config.inc.php";	


if(isset($_POST['arrange_id'])){   $arrange_id = $conn -> real_escape_string($_POST['arrange_id']);  }else{  $arrange_id = 0; }
if(isset($_POST['arrange_detail'])){ $arrange_detail = $conn -> real_escape_string($_POST['arrange_detail']); }else{ $arrange_detail = "";}
if(isset($_POST['arrange_detail_old'])){ $arrange_detail_old = $conn -> real_escape_string($_POST['arrange_detail_old']); }else{ $arrange_detail_old = "";}



$teacher_id = $_SESSION['user_id'];
$date_log  = date('Y-m-d H:i:s');
$arrange_log   =  "up|$date_log|$teacher_id|$arrange_detail_old";


if(isset($_POST['arrange_id']) && !empty($_POST['arrange_id']) ){  

    $arrange_id = $_POST['arrange_id'];
    $sql= " UPDATE tbl_arrange SET arrange_detail = '$arrange_detail' , arrange_log = '$arrange_log'  WHERE tbl_arrange.arrange_id = $arrange_id ";
    $conn->query($sql); 
}
    
    



    echo "<script type='text/javascript'>";
    //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
    echo "window.history.back(1)";
    echo "</script>";







  













?>