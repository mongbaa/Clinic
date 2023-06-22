<?php
if(isset($last_date) && !empty($last_date)){  $last_date = $last_date;  }else{  $last_date = $row_form_re['last_date']; }
// วันที่ที่ประเมิน
//echo " > ";
if(isset($detail_id) && !empty($detail_id)){  $detail_id = $detail_id;  }else{  $detail_id = $row_form_re['detail_id']; }
// รหัสงานที่ประเมิน
 

 
//////////////////////////////////////////   คำนวนคะแนน เอาที่เกรดมารวมกัน	/////////////////////////////////////////////////////////////////////////

$total_score = 0;
$total_weight = 0;
$sum_sw = 0;
$total_score_sum = 0;
$total_weight_sum  = 0;
$total_sum_score = 0;
$total_sum_weight = 0;
$total_score_full = 0;


 // ดึงชื่อฟิวด์
 $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
 $sql_form_detail_re  .=  " FROM (SELECT f.*  FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
 $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
 $query_form_detail_re = $conn->query($sql_form_detail_re);
 $row_a = 0;
 while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
 $row_a++;
  $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์


  //echo  "<br>------------------------------------------<br>";
  $field_grade = $field . "_grade";  //ชื่อฟิลด์_grade
  //echo  $row_a;
  //echo  " ";

          $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id and $field_grade != ''";
          $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
          $query_form_re = $conn->query($sql_form_re);
          $num_rows = $query_form_re->num_rows;
          while ($row_form_re = $query_form_re->fetch_assoc()) {

            $field_grade = $field . "_grade";  //_grade
             $grade_last = $row_form_re["{$field_grade}"];
          

            if (isset($grade_last) && !empty($grade_last)) {

              $grade =  $grade_last;
              $field_weights = $field . "_weight";   //_weight
              $weight = $row_form_re["{$field_weights}"];
            
              //คำนวนเกรด เป็นคะแนน 
             /* if ($grade == "A") {  
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
              } */
              
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

                        $score = 0;
                        $stepp = 0;
                        $weight_ss =  0;
                        $claass = "";
                      }




            } else {

              $grade = "";
              $weight = 0;
              $score = 0;
              $weight_ss =  0;
       
            }

            

            $sum_score = $weight_ss * $score;

         /*   echo  $grade;
            echo  " = ";
            echo  $score;
            echo  " x ";
            echo $weight_ss;
            echo  " = ";
            echo  $sum_score;
            echo  " ";
            echo  ", ";
*/

            $total_sum_score = $total_sum_score + $sum_score;
            $total_sum_weight = $weight_ss;

            
        
          }

        //  echo  " == ";
        //  echo $total_sum_score;
        //  echo  " , ";
        //  echo $total_sum_weight;

      //    $total_score_sum = $total_score_sum + $total_sum_score;
      //    $total_weight_sum  = $total_weight_sum + $total_sum_weight;

        
          $total_score = $total_score + $total_sum_score;
          $total_weight = $total_weight + $total_sum_weight;
          @$sum_sww = $total_score / $total_weight;
          @$sum_sw = round($sum_sww,2);

          $total_sum_score = 0;
          $total_sum_weight= 0;

         
 }


echo  "<br>------------------------------------------";
echo  "<br> คะแนน : ";
echo $total_score;
echo  "<br> น้ำหนัก : ";
echo $total_weight;
echo  "<br> คะแนน / น้ำหนัก : ";
echo round($sum_sw,2);

 