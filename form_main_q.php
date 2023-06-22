<?PHP session_start(); ?>
<meta charset="utf-8">
<?php

include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู

$date_type_product = date('Y-m-d H:i:s');
$name_type_product = $conn -> real_escape_string($_POST['name_type_product']);


if(isset($_POST['type_work_id'])){ $type_work_id = $conn -> real_escape_string($_POST['type_work_id']); }else{ $type_work_id = 0;}
if(isset($_POST['form_main_name'])){ $form_main_name = $conn -> real_escape_string($_POST['form_main_name']); }else{ $form_main_name = 0;}
if(isset($_POST['form_main_format'])){ $form_main_format = $conn -> real_escape_string($_POST['form_main_format']); }else{ $form_main_format = 0;}
if(isset($_POST['form_main_type'])){ $form_main_type = $conn -> real_escape_string($_POST['form_main_type']); }else{ $form_main_type = 0;}

if(isset($_POST['form_main_status'])){ $form_main_status = $conn -> real_escape_string($_POST['form_main_status']); }else{ $form_main_status = "Y";}

if(isset($_POST['form_main_confirm'])){ $form_main_confirm = $conn -> real_escape_string($_POST['form_main_confirm']); }else{ $form_main_confirm = 0;}
if(isset($_POST['form_main_table'])){ $form_main_table = $conn -> real_escape_string($_POST['form_main_table']); }else{ $form_main_table = date('YmdHis');}


if(isset($_POST['form_main_detail'])){
    
	$form_main_detail = json_encode($_POST['form_main_detail']);  
}else{ 

	$form_main_detail = json_encode([]);  

}




if(!empty($_POST['form_main_id'])){  
	
$form_main_id = $_POST['form_main_id'];

$sql= " UPDATE tbl_form_main SET 
type_work_id = '$type_work_id',
form_main_name = '$form_main_name',
form_main_format = '$form_main_format',
form_main_type = '$form_main_type',
form_main_status = '$form_main_status',
form_main_table = '$form_main_table',
form_main_detail = '$form_main_detail', 
form_main_confirm = '$form_main_confirm'
WHERE tbl_form_main.form_main_id =$form_main_id ";
$conn->query($sql); 
	
	
}else{
			
if(isset($_POST['form_main_table'])){ $form_main_table = $conn -> real_escape_string($_POST['form_main_table']); }else{ $form_main_table = "";}
	
$sql= "INSERT INTO tbl_form_main (form_main_id, type_work_id, form_main_name, form_main_format, form_main_type, form_main_status, form_main_table, form_main_detail, form_main_confirm) VALUES (NULL, '$type_work_id', '$form_main_name', '$form_main_format', '$form_main_type', '$form_main_status', '$form_main_table', '$form_main_detail', '$form_main_confirm');";
$conn->query($sql); 
	
	
}



            echo "<script type='text/javascript'>";
			echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
		    echo "window.location='form_main.php'";
			echo "</script>";
			
		
?>