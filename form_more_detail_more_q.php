<?PHP session_start();

include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 


if(isset($_POST['form_detail_more_id'])  && !empty($_POST['form_detail_more_id']) ){

	foreach($_POST as $key => $value) {
		$_POST[$key] = $conn->real_escape_string($value);
	}

$sql= "UPDATE tbl_form_detail_more SET form_detail_more_topic = '$_POST[form_detail_more_topic]',
form_detail_more_field = '$_POST[form_detail_more_field]',form_detail_more = '$_POST[form_detail_more]',
form_detail_more_format = '$_POST[form_detail_more_format]' WHERE tbl_form_detail_more.form_detail_more_id =$_POST[form_detail_more_id];";

}else{

$sql= "INSERT INTO db_clinic.tbl_form_detail_more (
form_detail_more_id ,
form_more_id ,
form_detail_more_topic ,
form_detail_more_field ,
form_detail_more ,
form_detail_more_format
)
VALUES (NULL , '$_POST[form_more_id]', '$_POST[form_detail_more_topic]', '$_POST[form_detail_more_field]', '$_POST[form_detail_more]', '$_POST[form_detail_more_format]')";


}


 
$conn->query($sql); 




            echo "<script type='text/javascript'>";
			echo  "alert('สร้างรายการประเมินสำเร็จ');";
		    echo "window.location='form_more_detail.php?form_more_id=$_POST[form_more_id]'";
			echo "</script>";
			
		
?>