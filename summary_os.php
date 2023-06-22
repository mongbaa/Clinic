
<?php
//สาขา OS
if(isset($last_date) && !empty($last_date)){  $last_date = $last_date;  }else{  $last_date = $row_form_re['last_date']; }
// วันที่ที่ประเมิน
//echo " > ";
if(isset($detail_id) && !empty($detail_id)){  $detail_id = $detail_id;  }else{  $detail_id = $row_form_re['detail_id']; }
// รหัสงานที่ประเมิน


//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////
 
 
$total_score = 0;
$total_weight = 0;
$total_step = 0;
$total_scoress = 0;
$total_weightss = 0;
$total_weightsss = 0;
$sum_score_full = 0;
$total_score_full = 0;



  // ดึงชื่อฟิวด์
  $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
  $sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
  $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
  //echo $sql_form_detail_re;
  $query_form_detail_re = $conn->query($sql_form_detail_re);
  while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
    
    $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
  
  
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
                            } else if ($grade == "B") {
                              $score = 3;
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
                              $score = 0;
                              $stepp = 0;
                              $weight_ss =  0;
                              $claass = "";
                            } 

                          // echo  "<br>";
                           $sum_score = $weight * $score; 
                           $sum_score_full = $weight * 4;


                           /*echo  "-----";
                           echo  $grade;
                           echo  " = ";
                           echo  $score;
                           echo  " x ";
                           echo $weight_ss;
                           echo  " = ";
                           echo  $sum_score;*/
                          
                           $total_score_full = $total_score_full + $sum_score_full; //คะแนนเต็ม
                           $total_score = $total_score + $sum_score;
                           $total_weight = $total_weight + $weight_ss;

                           
                           @$sum_sww = $total_score / $total_score_full;
                           @$sum_sw = round($sum_sww,2);
                       
                            
                     }


                   


  }

/*
  echo  "<br>";
  echo  "<br>";
  echo "คะแนนรวม : ".$total_score;
  echo  "<br>";
  echo "คะแนนเต็ม : ".$total_score_full;
  echo  "<br>";
  echo "น้ำหนักรวม : ".$total_weight;
  echo  "<br> คะแนน / คะแนนเต็ม = ";
  echo  round($total_score_full,2);
*/



//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////










?>


