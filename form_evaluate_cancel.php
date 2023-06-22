<?php
include "config.inc.php";

echo $field_id = $_GET['field_id']; //field_id
echo "<br>";
echo $form_main_id = $_GET['form_main_id']; //form_main
echo "<br>";
echo $detail_id = $_GET['detail_id']; //detail_id
echo "<br>";
echo $form_detail_id = $_GET['form_detail_id']; //field
echo "<br>";
echo $plan_id = $_GET['plan_id']; //plan_id
echo "<br>";
echo $arrange_date = $_GET['arrange_date']; //arrange_date
echo "<br>";
echo $arrange_id = $_GET['arrange_id']; //arrange_id
echo "<br>";
echo $type_work_id = $_GET['type_work_id']; //type_work_id
echo "<br>";
echo $field_teacher_ = $_GET['field_teacher']; //field_teacher
echo "<br>";
echo $field_weight_ = $_GET['field_weight']; //field_weight
echo "<br>";
echo $field_grade_ = $_GET['field_grade']; //field_grade
echo "<br>";
echo $field_date_ = $_GET['field_date']; //field_date
echo "<br>";
echo $cancel_user = $_GET['cancel_user']; //cancel_user
echo "<br>";



//ดึงชื่อตารางหลักลงฐานข้อมูล หลัก--------------------
$sql_form_main = " SELECT * FROM tbl_form_main WHERE form_main_id = $form_main_id ";
$query_form_main = $conn->query($sql_form_main);
$row_form_main = $query_form_main->fetch_assoc();
echo $table = $row_form_main['form_main_table'];
echo "<br>";
$tfield_id = $table . "_id";
echo "<br>";


//ดึงชื่อตาราง ชื่อฟิลด
$sql_form_detail = " SELECT * FROM tbl_form_detail WHERE form_detail_id = $form_detail_id ";
$query_form_detail = $conn->query($sql_form_detail);
$row_form_detail = $query_form_detail->fetch_assoc();
echo $field = $table . "_" . $row_form_detail['form_detail_field'];
echo "<br>";

// field น้ำหนักมีค่า
if ($row_form_detail['weight_type_id'] != "") {
    $field_weight = $field . "_weight"; // ชื่อfield ในฐานข้อมูล
    $weight = " $field_weight = '', ";
} else {
    $weight = "";
}

// field extra
if ($row_form_detail['form_detail_extra'] == "Y") {
    $field_extra = $field . "_extra"; // ชื่อfield ในฐานข้อมูล
    $extra = " $field_extra = '', ";
} else {
    $extra = "";
}

// field competency
if ($row_form_detail['form_detail_competency'] == "Y") {
    $field_competency = $field . "_competency"; // ชื่อfield ในฐานข้อมูล
    $competency = " $field_competency = '', ";
} else {
    $competency = "";
}

// field complete
if ($row_form_detail['form_detail_complete'] == "Y") {
    $field_complete = $field . "_complete"; // ชื่อfield ในฐานข้อมูล
    $complete = " $field_complete = '', ";
} else {
    $complete = "";
}

$field_grade = $field . "_grade";
$field_teacher = $field . "_teacher";
$field_date = $field . "_date";


$sql = "UPDATE tbl_$table  SET ";
$sql .= $weight;
$sql .= " $field_grade = '', ";
$sql .= " $field_teacher = '', ";
$sql .= " $field_date = '', ";
$sql .= $competency;
$sql .= $complete;
$sql .= "detail_id = $detail_id ";
echo $sql .= " WHERE $tfield_id = $field_id ";
$conn->query($sql);




echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
$cancel_log = $sql;
$cancel_date = date('Y-m-d H:i:s');

$sql_in = "INSERT INTO tbl_evaluate_cancel (evaluate_cancel_id, form_main_id, field_id, detail_id, form_detail_id, plan_id, arrange_date, arrange_id, field_weight, field_grade, field_teacher, field_date, cancel_user, cancel_date, cancel_log)";
echo $sql_in .= " VALUES (NULL, '$form_main_id', '$field_id', '$detail_id', '$form_detail_id', '$plan_id', '$arrange_date', '$arrange_id', '$field_weight_', '$field_grade_', '$field_teacher_', '$field_date_', '$cancel_user', '$cancel_date', '$cancel_log')";
$conn->query($sql_in);

//////////////////////////////////////////  คำนวนคะแนน     /////////////////////////////////////////////////////////////////////////
echo "<br>";
echo "<br>";
echo "<br>";

if (!empty($type_work_id)) {

    $last_date = date('Y-m-d');
    // ดึงชื่อตาราง
    $sql_tabel = " SELECT * FROM tbl_form_main  WHERE form_main_id = '$form_main_id' ";
    $query_tabel = $conn->query($sql_tabel);
    $row_tabel = $query_tabel->fetch_assoc();

    $tbl = $row_tabel['form_main_table']; // ชื่อตาราง
    $tbl_id = $tbl . "_id"; // Id ของตาราง

    if ($type_work_id == 1) { // สาขา X-ray ดึง จำนวนฟิมล์มาแสดงด้วย
        include "summary_xray.php";
    }

    if ($type_work_id == 2) { // สาขา pedo ดึง คะแนนทั่วไป
        include "summary_pedo.php";
    }
    if ($type_work_id == 3) { // สาขา pedo ดึง คะแนนทั่วไป
        include "summary_pedo.php";
    }
    if ($type_work_id == 4) { // สาขา oper ดึง คะแนนทั่วไป
        include "summary_oper.php";
    }

    if ($type_work_id == 5) { // สาขา endo ดึง คะแนนทั่วไป
        include "summary_endo.php";
    }

    if ($type_work_id == 6) { // สาขา Crown and Bridge ดึง คะแนนทั่วไป
        include "summary_cb.php";
    }

    if ($type_work_id == 7) { // สาขา perio ดึง คะแนนทั่วไป
        include "summary_perio.php";
    }

    if ($type_work_id == 8) { // สาขา Prosthodontics ดึง คะแนนทั่วไป
        include "summary_prosth.php";
    }

    if ($type_work_id == 9) { // สาขา os ดึง คะแนนทั่วไป
        include "summary_os.php";
    }

    if ($type_work_id == 10) { // สาขา od ดึงคะแนนครั้งล่าสุดมาคำนวน
        include "summary_od.php";
    }

    if ($type_work_id == 11) { // สาขา prevent ดึง คะแนนทั่วไป
        include "summary_prevent.php";
    }

    if ($type_work_id == 12) { // สาขา prevent ดึง คะแนนทั่วไป
        include "summary_prevent.php";
    }

    $detail_date_last = $last_date;
    $detail_score = $total_score;
    $detail_weight = $total_weight;
    $detail_total = $sum_sw;

// อัพเดทสถานะ Complete และ คะแนน
    $sql_update_complete = " UPDATE tbl_detail SET  ";
    $sql_update_complete .= " detail_score = '$detail_score' ";
    $sql_update_complete .= " ,detail_weight = '$detail_weight' ";
    $sql_update_complete .= " ,detail_total = '$detail_total' ";
    $sql_update_complete .= " ,detail_date_last = '$detail_date_last' ";
    echo $sql_update_complete .= "  WHERE detail_id = $detail_id ";
    $conn->query($sql_update_complete);

}

echo "<script type='text/javascript'>";
//echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
echo "window.location='evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$arrange_date&arrange_id=$arrange_id'";
echo "</script>";
