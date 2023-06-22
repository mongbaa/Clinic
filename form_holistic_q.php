<?PHP session_start();

include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 


foreach($_POST as $key => $value) {
    $_POST[$key] = $conn->real_escape_string($value);
}

$form_holistic_id = $_POST['form_holistic_id'];
$form_holistic_order = $_POST['form_holistic_order'];
$form_holistic_group = $_POST['form_holistic_group'];
$form_holistic_name = $_POST['form_holistic_name'];
$form_holistic_score = $_POST['form_holistic_score'];
$form_holistic_detail = $_POST['form_holistic_detail'];
$form_holistic_note = $_POST['form_holistic_note'];
$form_holistic_field = $_POST['form_holistic_field'];
$form_holistic_status = $_POST['form_holistic_status'];
$AFTER = $_POST['AFTER'];





if(isset($form_holistic_id)  && !empty($form_holistic_id) ){


$sql= "";

}else{

$sql= "INSERT INTO tbl_form_holistic (form_holistic_id, form_holistic_order, form_holistic_group, form_holistic_name,  form_holistic_score, form_holistic_detail, form_holistic_note, form_holistic_field, form_holistic_status) VALUES (NULL, '$form_holistic_order', '$form_holistic_group', '$form_holistic_name', '$form_holistic_score', '$form_holistic_detail', '$form_holistic_note', '$form_holistic_field', '$form_holistic_status');";
$conn->query($sql); 

echo "<br>";

$note = $form_holistic_field."_note";

if(isset($AFTER)  && !empty($AFTER) ){
	  $sql_ADD= " ALTER TABLE tbl_holistic ADD $form_holistic_field TEXT NOT NULL, ADD $note TEXT NOT NULL AFTER $AFTER ";
}else{
	  $sql_ADD= " ALTER TABLE tbl_holistic ADD $form_holistic_field TEXT NOT NULL, ADD $note TEXT NOT NULL";
}
$conn->query($sql_ADD); 



}




$conn -> close();


            echo "<script type='text/javascript'>";
		    echo  "alert('สร้างรายการประเมินสำเร็จ');";
		    echo "window.location='form_holistic.php'";
			echo "</script>";
			
		
?>