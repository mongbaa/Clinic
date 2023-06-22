สาขา OD

<?php
echo $detail_id = $row_form_re['detail_id']; // รหัสงานที่ประเมิน


//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////
$total_score_sum = 0;
$total_weight_sum = 0;
$sum_sw = 0;
$total_score = 0;
$total_weight = 0;
$total_step = 0;
$total_scoress = 0;
$total_weightss = 0;
$total_weightsss = 0;


    $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
    $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
    $query_form_re = $conn->query($sql_form_re);
    $num_rows = $query_form_re->num_rows;
    while ($row_form_re = $query_form_re->fetch_assoc()) {

     
                   // ดึงชื่อฟิวด์
                    $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                    $sql_form_detail_re  .=  " FROM (SELECT f.*  FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
                    $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                    //echo $sql_form_detail_re;
                    $query_form_detail_re = $conn->query($sql_form_detail_re);
                    $row_a = 0;
                    while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                    $row_a++;  
                    $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                    $field_grade = $field . "_grade";  //_grade

                  echo  "<br>";
                  echo  $row_a;
                  echo  ". ";
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
                              $score = 1;
                              $stepp = 1;
                              $weight_ss =  $weight;
                              $claass = "table-success";
                            } else {
                              $score = 0;
                              $stepp = 0;
                              $weight_ss =  0;
                              $claass = "";
                            } 

                           $sum_score = $weight_ss * $score;


                           echo  $grade;
                           echo  " = ";
                           echo  $score;
                           echo  " x ";
                           echo $weight_ss;
                           echo  " = ";
                           echo  $sum_score;

                           $total_score = $total_score + $sum_score;
                           $total_weight = $total_weight + $weight_ss;
                           @$sum_sw = $total_score / $total_weight;


                           $grade = $grade;
                     }


echo  "<br> คะแนน : ";
echo  $total_score;
echo  "<br> น้ำหนัก : ";
echo  $total_weight;
echo  "<br> สูตร คะแนน / น้ำหนัก  ";
echo  "<br> ผลลัพธ์ : ";
echo  round($sum_sw,2);



                   
        echo  "<br>------------------------------------------ <br>";
     
     
        $total_score_sum = $total_score_sum + $total_score;
        $total_weight_sum = $total_weight_sum + $total_weight;
        @$total_sum_sw = $total_score_sum / $total_weight_sum;
      


        $sum_sw = 0;
        $total_score = 0; //ล้างค่า 0
        $total_weight = 0; //ล้างค่า 0


  


  }







echo  "<br> คะแนนรวม : ";
echo  $total_score_sum;
echo  "<br> น้ำหนักรวม : ";
echo  $total_weight_sum;
echo  "<br> สูตร คะแนนรวม / น้ำหนักรวม  ";
echo  "<br> ผลลัพธ์ : ";
echo  round($total_sum_sw,2);

echo  "<br>------------------------------------------ <br>";
     






/*
  echo  "<br>";
  echo  "<br>";
  echo "คะแนนรวม : ".$total_score;
  echo  "<br>";
  echo "น้ำหนักรวม : ".$total_weight;
  echo  "<br>";
  echo "รวม : ".$total_score / $total_weight;*/
  


//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////










?>


