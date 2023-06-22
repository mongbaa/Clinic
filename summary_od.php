สาขา OD
<?php



if(isset($last_date) && !empty($last_date)){ echo $last_date = $last_date;  }else{ echo $last_date = $row_form_re['last_date']; }
// วันที่ที่ประเมิน
echo " > ";
if(isset($detail_id) && !empty($detail_id)){ echo $detail_id = $detail_id;  }else{ echo $detail_id = $row_form_re['detail_id']; }
// รหัสงานที่ประเมิน


//////////////////////////////////////////   คำนวนคะแนน เอาเกรดล่าสุดมาคำนวน	/////////////////////////////////////////////////////////////////////////

$total_score = 0;
$total_weight = 0;
$sum_sw = 0;
// ดึงชื่อฟิวด์
$sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
$sql_form_detail_re  .=  " FROM (SELECT f.*  FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
$sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
$query_form_detail_re = $conn->query($sql_form_detail_re);
$row_a = 0;
while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
  $row_a++;

  //echo  "<br>";
  //echo  $row_a;
  //echo  " : ";

  $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
  $field_grade = $field . "_grade";  //ชื่อฟิลด์_grade

                                    $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id  and $field_grade != '' ";
                                    $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                    $query_form_re = $conn->query($sql_form_re);
                                    $num_rows = $query_form_re->num_rows;
                                    while ($row_form_re = $query_form_re->fetch_assoc()) {

                                      $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                                      $field_grade = $field . "_grade";  //_grade
                                      $grade_last = $row_form_re["{$field_grade}"];

                                      if (isset($grade_last) && !empty($grade_last)) {
                                        $grade =  $grade_last;
                                        $field_weights = $field . "_weight";   //_weight
                                        $weight = $row_form_re["{$field_weights}"];

                                            //คำนวนเกรด เป็นคะแนน 
                                            if ($grade == "A") {  
                                              $score = 4;
                                              $weight_ss =  $weight;
                                            } else if ($grade == "B") {
                                              $score = 3;
                                              $weight_ss =  $weight;
                                            } else if ($grade == "C") {
                                              $score = 2;
                                              $weight_ss =  $weight;
                                            } else if ($grade == "F") {
                                              $score = 0;
                                              $weight_ss =  $weight;
                                            } else {
                                              $score = 0;
                                              $weight_ss =  0;
                                            } 


                                      } else {

                                        $grade = "";
                                        $weight = 0;
                                        $score = 0;
                                        $weight_ss =  0;
                                 
                                      }
 
                                          $sum_score = $weight_ss * $score;

                                    }

                                    //echo  $grade;
                                    //echo  " = ";
                                    //echo  $score;
                                    //echo  " x ";
                                    //echo $weight_ss;
                                    //echo  " = ";
                                    //echo  $sum_score;


                                    $total_score = $total_score + $sum_score;
                                    $total_weight = $total_weight + $weight_ss;
                                    @$sum_sww = $total_score / $total_weight;
                                    @$sum_sw = round($sum_sww,2);
                                    
                                        $grade = "";
                                        $weight = 0;
                                        $score = 0;
                                        $weight_ss =  0;
                                        $sum_score=  0;


}





echo  "<br>------------------------------------------";
echo  "<br> คะแนน : ";
echo $total_score;
echo  "<br> น้ำหนัก : ";
echo $total_weight;
echo  "<br> คะแนน / น้ำหนัก : ";
echo round($sum_sw,2);
//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////










?>