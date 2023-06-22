<?php
session_start();
?>
<meta charset="utf-8">
<?php
include "config.inc.php";



foreach($_POST as $key => $value) {
    $_POST[$key] = $conn->real_escape_string($value);
}


echo $arrange_id = $_POST['arrange_id'];
echo "<br>";
echo $detail_id = $_POST['detail_id'];
echo "<br>";
echo $plan_id = $_POST['plan_id'];
echo "<br>";
echo $form_main_id = $_POST['form_main_id'];
echo "<br>";
echo $id_form = $_POST['id_form'];
echo "<br>";
echo $evaluate_del_detail = $_POST['evaluate_del_detail'];
echo "<br>";
echo $evaluate_del_user = $_POST['evaluate_del_user'];
echo "<br>";


//ดึงชื่อตารางหลักลงฐานข้อมูล หลัก--------------------
$sql_form_main = " SELECT * FROM tbl_form_main WHERE form_main_id = $form_main_id ";
$query_form_main = $conn->query($sql_form_main);
$row_form_main = $query_form_main->fetch_assoc();
echo $table = $row_form_main['form_main_table'];
$tfield_id = $table . "_id";
echo "<br>";


echo $sql = "SELECT * FROM tbl_{$table} WHERE {$tfield_id} = {$id_form} ";
$query = $conn->query($sql);
$row  = $query->fetch_assoc();
$evaluate_del_log =  json_encode($row);
echo "<br>";  
    


echo $sql_del_redone = "DELETE FROM tbl_{$table} WHERE {$tfield_id} = {$id_form} ";
$conn->query($sql_del_redone); 
echo "<br>";        
echo "<br>";    


$evaluate_del_date = date('Y-m-d H:i:s');
$sql_in = "INSERT INTO tbl_evaluate_del (evaluate_del_id, detail_id, plan_id, form_main_id, id_form, arrange_date, arrange_id, evaluate_del_detail, evaluate_del_user, evaluate_del_date, evaluate_del_log) VALUES ";
echo $sql_in .= "(NULL, '$detail_id', '$plan_id', '$form_main_id', '$id_form', '$arrange_date', '$arrange_id', '$evaluate_del_detail', '$evaluate_del_user', '$evaluate_del_date', '$evaluate_del_log');";
$conn->query($sql_in);
//////////////////////////////////////////  คำนวนคะแนน     /////////////////////////////////////////////////////////////////////////
echo "<br>";
echo "<br>";
echo "<br>";



// อัพเดทสถานะ Complete และ คะแนน
    $sql_update_complete = " UPDATE tbl_detail SET  ";
    $sql_update_complete .= " detail_score = '0' ";
    $sql_update_complete .= " ,detail_weight = '0' ";
    $sql_update_complete .= " ,detail_total = '0' ";
    $sql_update_complete .= " ,detail_date_last = '0000-00-00' ";
    echo $sql_update_complete .= "  WHERE detail_id = $detail_id ";
    $conn->query($sql_update_complete);



$conn-> close();


echo "<script type='text/javascript'>";
//echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
echo "window.location='evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$arrange_date&arrange_id=$arrange_id'";
echo "</script>";
