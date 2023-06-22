<?PHP session_start();

include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
$form_more_table="tbl_".$_POST['form_more_table'];


 $sql= "INSERT INTO tbl_form_more (form_more_id, type_work_id, form_more_name, form_more_status, form_more_table, form_more_confirm) VALUES (NULL, '$_POST[type_work_id]', '$_POST[form_more_name]', '$_POST[form_more_status]', '$form_more_table', '0')";
$conn->query($sql); 




            echo "<script type='text/javascript'>";
			echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
		    echo "window.location='form_more.php'";
			echo "</script>";
			
		
?>