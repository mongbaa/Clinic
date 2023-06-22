<?php
if (isset($last_date) && !empty($last_date)) {
  $last_date = $last_date;
} else {
  $last_date = $row_form_re['last_date'];
}
// วันที่ที่ประเมิน
//echo " > ";
if (isset($detail_id) && !empty($detail_id)) {
  $detail_id = $detail_id;
} else {
  $detail_id = $row_form_re['detail_id'];
}
// รหัสงานที่ประเมิน


//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////
// ดึงชื่อฟิวด์
$summary_score  =  0;
$summary_full  =   0;

$sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
$sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
$sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
//echo $sql_form_detail_re;
$query_form_detail_re = $conn->query($sql_form_detail_re);
while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {

  $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์




  $total_score_full = 0;   //คะแนนเต็มในขั้นตอนรวมกัน
  $total_score = 0; //คะแนนรวมในขั้นตอน
  $total_stepp_full = 0;;   //จำนวนครั้งในขั้นตอนรวมกัน


  $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
  $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
  $query_form_re = $conn->query($sql_form_re);
  $num_rows = $query_form_re->num_rows;
  while ($row_form_re = $query_form_re->fetch_assoc()) {

    $field_grade = $field . "_grade";  //_grade
    $grade = $row_form_re["{$field_grade}"];



    if (isset($grade) && !empty($grade)) {
      $field_weights = $field . "_weight";   //_weight
      $weight = $row_form_re["{$field_weights}"];
      $field_teacher = $field . "_teacher";  //_teacher
      $teacher = $row_form_re["{$field_teacher}"];
      $field_date = $field . "_date";  //_date
      $datee = $row_form_re["{$field_date}"];
    } else {
      $weight = "";
      $teacher = "";
      $datee = "";
    }


    //คำนวนเกรด เป็นคะแนน 
    if ($grade == "A") {
      $score = 4;
      $stepp = 1;
      $weight_ss =  $weight;
      $claass = "table-success";
    } else if ($grade == "B+") {
      $score = 3.5;
      $stepp = 1;
      $weight_ss =  $weight;
      $claass = "table-success";
    } else if ($grade == "B") {
      $score = 3;
      $stepp = 1;
      $weight_ss =  $weight;
      $claass = "table-success";
    } else if ($grade == "C+") {
      $score = 2.5;
      $stepp = 1;
      $weight_ss =  $weight;
      $claass = "table-success";
    } else if ($grade == "C") {
      $score = 2;
      $stepp = 1;
      $weight_ss =  $weight;
      $claass = "table-success";
    } else if ($grade == "F") {

      $score = 0;
      $stepp = 1;
      $weight_ss =  $weight;
      $claass = "table-success";
    } else {
      $grade = "X";
      $score = 0;
      $stepp = 0;
      $weight_ss =  0;
      $claass = "";
    }





    $sum_score_full = $weight * 4;   //คะแนนเต็ม
    $sum_score = $weight * $score; //คะแนนคูณน้ำหนัก
    $sum_stepp = $stepp++; // รวม จำนวนครั้ง


    $total_stepp_full = $total_stepp_full + $sum_stepp;   //จำนวนครั้งในขั้นตอนรวมกัน
    $total_score_full = $total_score_full + $sum_score_full;   //คะแนนเต็มในขั้นตอนรวมกัน
    $total_score = $total_score + $sum_score;  //คะแนนรวมในขั้นตอน


   // echo " | ";
  }

  //echo " = ";

  /* 
  echo $total_stepp_full;
  echo " | ";
  echo $total_score_full;
  echo " | ";
  echo $total_score;
  echo "<br>";
  */

  if ($total_stepp_full == 0) {
    $total_full_stepp =  0;
  } else {
    $total_full_stepp =  $total_score_full / $total_stepp_full; //คะแนนเต็มหารจำนวนครั้ง
  }
  //echo $total_full_stepp;
  //echo " | ";
  if ($total_stepp_full == 0) {
    $total_score_stepp =  0;
  } else {
    $total_score_stepp =  $total_score / $total_stepp_full; //คะแนนจริงที่หารจำนวนครั้ง
  }
  //echo $total_score_stepp;
  //echo "<br>";
  $summary_score  =  $summary_score + $total_score_stepp;
  $summary_full  =   $summary_full  + $total_full_stepp;

}

$total_score  = round($summary_score,2);
$total_weight = round($summary_full,2);

echo  "<br>  คะแนนเต็ม  = ";
echo $summary_full   = round($summary_full,2);
echo  "<br>  คะแนนรวม  = ";
echo $summary_score = round($summary_score,2); 

@$sum_sww = $summary_score / $summary_full ;
@$sum_sw = round($sum_sww,2);
echo  "<br>  คะแนนรวม / คะแนนเต็ม = ";
echo  round($sum_sw,2);
echo  " (คะแนนเฉลี่ย) =  คะแนน ";
echo $sum_sw = $sum_sw * 4;



 
//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////
?>