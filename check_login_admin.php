<?php 
include "header.php";

include "config.inc.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

$user=$_POST['username'];
//$pass_member=$_POST['password'];
$pass=MD5($_POST['password']);

  $sql_member = "select * from tbl_admin  where  admin_username ='$user' and admin_password ='$pass' and admin_status=1"; 
  $objQuery_member=$conn ->query($sql_member);
  $objResult_member = $objQuery_member->fetch_assoc();

 


	if(isset($objResult_member)){


		$_SESSION["sessid"] = session_id();
		$_SESSION['user_id'] = $objResult_member["admin_id"];
		$_SESSION['fname'] = $objResult_member["admin_fname"];
		$_SESSION['lname'] = $objResult_member["admin_lname"];
		$_SESSION['loginname'] = $objResult_member["admin_fname"];
		$_SESSION['level_user'] = "Staff";
		$_SESSION['staff_level'] = $objResult_member["admin_level"];

		
		$_SESSION["login_em"] = "Y";	
			
		   echo "<script wg='text/javascript'>";
           echo  "alert('[เข้าระบบสำเร็จ ยินดีต้อนรับเข้าสู่ระบบ]');";
		   echo "window.location='admin.php';";
           echo "</script>";

	}else{ 

		
		   echo "<script wg='text/javascript'>";
           echo  "alert('[ Username  หรือ Password ผิด กรุณาเข้าสู่ระบบใหม่อีกครั้ง]');";
           echo "window.location='admin.php';";
           echo "</script>";
		
		
	}
	


?>