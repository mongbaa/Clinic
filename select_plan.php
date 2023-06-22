<?php
$type_work_id = isset($_POST['type_work_id']) ? $_POST['type_work_id'] : "";
include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
$sql_plan="SELECT * FROM tbl_plan WHERE type_work_id='{$type_work_id}' ";
$query_plan=$conn->query($sql_plan);
$Rows = $query_plan->num_rows;
if ($Rows > 0) {
while($Result=$query_plan->fetch_assoc()){
echo "<option value=\"" . $Result['plan_id'] . "\">" . $Result['plan_name'] . "</option>";
}
}else{
echo "<option value=\"\">ไม่มีที่เลือก</option>";
}