<?php 
session_start();
include "config.inc.php"; 

if(isset($_GET['del_conduct']) && !empty($_GET['del_conduct'])){ 

$teacher_id = $_SESSION['user_id'];
$date_log  = date('Y-m-d H:i:s');
$conduct_log   =  ",up|$date_log|$teacher_id/";

                $conduct_id = $_GET['del_conduct'];
               echo $sql_up_conduct = "UPDATE tbl_conduct SET conduct_status = '0' ,conduct_log = replace(conduct_log, '/','$conduct_log')  WHERE tbl_conduct.conduct_id = $conduct_id";
                $conn->query($sql_up_conduct); 
      
 

   
   echo "<script type='text/javascript'>";
   //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
   echo "window.history.back(1)";
   //echo "window.location='evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$conduct_date&arrange_id=$arrange_id'";
   echo "</script>";

}

?>