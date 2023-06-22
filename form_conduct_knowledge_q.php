<?PHP session_start();

include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 


foreach($_POST as $key => $value) {
    $_POST[$key] = $conn->real_escape_string($value);
}



$form_conduct_knowledge_id = $_POST['form_conduct_knowledge_id'];
$form_conduct_knowledge_order = $_POST['form_conduct_knowledge_order'];
$form_conduct_knowledge_type = $_POST['form_conduct_knowledge_type'];
$form_conduct_knowledge_name = $_POST['form_conduct_knowledge_name'];
$form_conduct_knowledge_score = $_POST['form_conduct_knowledge_score'];
$form_conduct_knowledge_field = $_POST['form_conduct_knowledge_field'];
$form_conduct_knowledge_status = $_POST['form_conduct_knowledge_status'];
$type_work_id = $_POST['type_work_id'];




$date_log = date('Y-m-d H:i:s');
$by = $_SESSION['username'];

if(isset($form_conduct_knowledge_id)  && !empty($form_conduct_knowledge_id) ){

    $form_conduct_knowledge_log   =  "UP|$date_log|$by|/";

    $sql_update = "UPDATE tbl_form_conduct_knowledge SET 
        form_conduct_knowledge_type = '$form_conduct_knowledge_type',
        type_work_id = '$type_work_id', 
        form_conduct_knowledge_order = '$form_conduct_knowledge_order',
        form_conduct_knowledge_type = '$form_conduct_knowledge_type',
        form_conduct_knowledge_name = '$form_conduct_knowledge_name',
        form_conduct_knowledge_score = '$form_conduct_knowledge_score',
        form_conduct_knowledge_status = '$form_conduct_knowledge_status',
        form_conduct_knowledge_log = replace(form_conduct_knowledge_log, '/','$form_conduct_knowledge_log')                           
        WHERE tbl_form_conduct_knowledge.form_conduct_knowledge_id = $form_conduct_knowledge_id;";
    $conn->query($sql_update);

}else{


$form_conduct_knowledge_log   =  "IN|$date_log|$by|/";

$sql= "INSERT INTO tbl_form_conduct_knowledge (form_conduct_knowledge_id, type_work_id, form_conduct_knowledge_order, form_conduct_knowledge_field, form_conduct_knowledge_type, form_conduct_knowledge_name, form_conduct_knowledge_score, form_conduct_knowledge_status, form_conduct_knowledge_log) VALUES (NULL, '$type_work_id', '$form_conduct_knowledge_order', '$form_conduct_knowledge_field', '$form_conduct_knowledge_type', '$form_conduct_knowledge_name', '$form_conduct_knowledge_score', '$form_conduct_knowledge_status', '$form_conduct_knowledge_log');";
$conn->query($sql); 


//ต้องสร้างตาราง conduct_knowledge ของสาขาก่อน โดยใช้ tbl_ck_1  tbl_ck_2 tbl_ck_3
echo "<br>";
$sql_ADD= " ALTER TABLE tbl_ck_$type_work_id ADD $form_conduct_knowledge_field TEXT NOT NULL";
$conn->query($sql_ADD); 

}






            echo "<script type='text/javascript'>";
		    echo  "alert('สร้างรายการประเมินสำเร็จ');";
		    echo "window.location='form_conduct_knowledge.php?type_work_id=$type_work_id'";
			echo "</script>";
			
		
?>