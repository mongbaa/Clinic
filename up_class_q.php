<?php

	include "config.inc.php";
	$student_level=$_POST['student_level'];
	
	
	for($i=0;$i<count($_POST["chkclass"]);$i++)
	{
		if($_POST["chkclass"][$i] != "")
		{
			
			 $chkclass=$_POST["chkclass"][$i];
			
			

$sql_update = " UPDATE tbl_student  SET student_level='$student_level' WHERE student_id='$chkclass' ";
$conn->query($sql_update); 


			
		}
	}

	

echo "<script type='text/javascript'>";
//echo  "alert('สำเร็จ');";
echo "window.location='student_list.php?level_search=$student_level'";
echo "</script>";
?>
