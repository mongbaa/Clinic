<?PHP session_start(); ?>
<meta charset="utf-8">
<?php
//include "header.php";
include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 





if(isset($_POST['form_detail_id'])  && !empty($_POST['form_detail_id']) ){

	foreach($_POST as $key => $value) {
		$_POST[$key] = $conn->real_escape_string($value);
	}



$sql= "UPDATE tbl_form_detail SET form_detail_order = '$_POST[form_detail_order]', form_detail_topic = '$_POST[form_detail_topic]', weight_type_id = '$_POST[weight_type_id]', form_detail_weight = '$_POST[form_detail_weight]', form_detail_extra = '$_POST[form_detail_extra]', score_type_id = '$_POST[score_type_id]', score_id = '$_POST[score_id]', form_detail_competency = '$_POST[form_detail_competency]', form_detail_complete = '$_POST[form_detail_complete]', form_detail_field = '$_POST[form_detail_field]' WHERE tbl_form_detail.form_detail_id = $_POST[form_detail_id]";




}else{

	

 $sql= "INSERT INTO tbl_form_detail (form_detail_id, form_main_id, form_detail_order, form_detail_topic, weight_type_id, form_detail_weight, form_detail_extra, score_type_id, score_id, form_detail_competency, form_detail_complete, form_detail_field) VALUES (NULL, '$_POST[form_main_id]',  '$_POST[form_detail_order]', '$_POST[form_detail_topic]', '$_POST[weight_type_id]', '$_POST[form_detail_weight]', '$_POST[form_detail_extra]', '$_POST[score_type_id]', '$_POST[score_id]', '$_POST[form_detail_competency]', '$_POST[form_detail_complete]', '$_POST[form_detail_field]')";


}


 
$conn->query($sql); 




            echo "<script type='text/javascript'>";
			echo  "alert('สร้างรายการประเมินสำเร็จ');";
		    echo "window.location='form_main_detail.php?form_main_id=$_POST[form_main_id]'";
			echo "</script>";
			
		
?>