<?PHP session_start();

include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 


foreach($_POST as $key => $value) {
    $_POST[$key] = $conn->real_escape_string($value);
}

$form_conduct_id = $_POST['form_conduct_id'];
$form_conduct_order = $_POST['form_conduct_order'];
//$form_conduct_group = $_POST['form_conduct_group'];
$form_conduct_name = $_POST['form_conduct_name'];
$form_conduct_score = $_POST['form_conduct_score'];
//$form_conduct_detail = $_POST['form_conduct_detail'];
$form_conduct_note = $_POST['form_conduct_note'];
$form_conduct_field = $_POST['form_conduct_field'];
$form_conduct_status = $_POST['form_conduct_status'];
$AFTER = $_POST['AFTER'];





if(isset($form_conduct_id)  && !empty($form_conduct_id) ){


$sql= "";

}else{

$sql= "INSERT INTO tbl_form_conduct (form_conduct_id, form_conduct_order, form_conduct_name,  form_conduct_score, form_conduct_note, form_conduct_field, form_conduct_status) VALUES (NULL, '$form_conduct_order', '$form_conduct_name', '$form_conduct_score', '$form_conduct_note', '$form_conduct_field', '$form_conduct_status');";
$conn->query($sql); 

echo "<br>";

$note = $form_conduct_field."_note";

if(isset($AFTER)  && !empty($AFTER) ){
	  $sql_ADD= " ALTER TABLE tbl_conduct ADD $form_conduct_field TEXT NOT NULL AFTER $AFTER ";
}else{
	  $sql_ADD= " ALTER TABLE tbl_conduct ADD $form_conduct_field TEXT NOT NULL ";
}
$conn->query($sql_ADD); 



}







            echo "<script type='text/javascript'>";
		    echo  "alert('สร้างรายการประเมินสำเร็จ');";
		    echo "window.location='form_conduct.php'";
			echo "</script>";
			
		
?>