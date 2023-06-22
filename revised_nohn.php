<meta charset="utf-8">
<?php


$date_start = '2022-03-01';
$date_end = '2022-09-22';

include "config.inc.php";
echo $sql_form_nohn  = "SELECT * FROM tbl_arrange_nohn  where (arrange_nohn_date BETWEEN '$date_start' AND '$date_end') and arrange_nohn_check_eval = 1 ORDER BY tbl_arrange_nohn.arrange_nohn_id DESC";
$query_form_nohn = $conn->query($sql_form_nohn);
echo $num_rows_form_nohn = $query_form_nohn->num_rows;
while ($row_form_nohn = $query_form_nohn->fetch_assoc()) {


    echo "<br>";
    echo $plan_id = $row_form_nohn['plan_id'];
    echo "<br>";

    $sum_score_nohn  = $row_form_nohn['sum_score_nohn'];
    $student_id      = $row_form_nohn['student_id'];
    $detail_id       = $row_form_nohn['arrange_nohn_id'];
    $arrange_nohn_id       = $row_form_nohn['arrange_nohn_id'];


    //รหัสงาน   
    $sql_plan   = " SELECT * FROM tbl_plan WHERE plan_id = $plan_id ";
    $query_plan = $conn->query($sql_plan);
    $row_plan   = $query_plan->fetch_assoc();
    $form_main_id  = $row_plan['form_main_id'];




    //////////////////////////////////////////   ดึงข้อมูลการประเมิน 	/////////////////////////////////////////////////////////////////////////
    $sql_form_main   =  " SELECT * FROM tbl_form_main WHERE form_main_id = $form_main_id ";
    $query_form_main = $conn->query($sql_form_main);
    $row_form_main = $query_form_main->fetch_assoc();

    $table = $row_form_main['form_main_table'];
    $field_id = $table . "_id";


    //////////////////////////////////////////  ดึงคะแนนที่ได้ 	/////////////////////////////////////////////////////////////////////////
    echo $sql_form_re_nohn = "SELECT * FROM tbl_" . $table . " where student_id = '$student_id'  and detail_id = '$detail_id'";
    $query_form_re_nohn = $conn->query($sql_form_re_nohn);
    if ($row_form_re_nohn = $query_form_re_nohn->fetch_assoc()) {

        $sum_total_score = 0;
        $sum_score = 0;
        $total_score = 0;
        $total_weight = 0;
        $total_step = 0;

        //////////////////////////////////////////   ดึงข้อมูล field	/////////////////////////////////////////////////////////////////////////
        $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
        $sql_form_detail_re  .=  " FROM (SELECT f.*  FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
        $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
        $sql_form_detail_re;
        $query_form_detail_re = $conn->query($sql_form_detail_re);
        while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {

            echo "<br>";
            // echo  $row_form_detail_re['form_detail_topic']; //ชื่อฟิลด์ form_detail_topic
            echo $field = $table . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
            $field_grade = $field . "_grade";  //_grade

            echo " = ";
                $grade = $row_form_re_nohn["{$field_grade}"];



            if (isset($grade) && !empty($grade)) {
                $field_weights = $field . "_weight";   //_weight
                $weight = $row_form_re_nohn["{$field_weights}"];
                $field_teacher = $field . "_teacher";  //_teacher
                $teacher = $row_form_re_nohn["{$field_teacher}"];
                $field_date = $field . "_date";  //_date
                $datee = $row_form_re_nohn["{$field_date}"];
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

                $score = 0;
                $stepp = 0;
                $weight_ss =  0;
                $claass = "";
            }

            
            echo $weight_ss;
            echo " - ";
            echo $score;

            $sum_score = $weight_ss * $score; // ผลคูณคะแนน
            $total_score = $total_score + $sum_score;
            $total_weight = $total_weight + $weight_ss;
            $total_step = $total_step + $stepp;
        }


        $sum_total_score = $total_score / $total_weight;



        echo "<br>";


        echo $sum_score_nohn;
        echo " = ";
        echo $sum_total_score = number_format($sum_total_score, 2);
    }



 if($sum_score_nohn == $sum_total_score ){

    echo "<br>";
    echo  $arrange_nohn_id;

  }else{

    echo "<br>";
    //////////////////////////////////////////  อัพเดทสถานะการประเมิน	///////////////////////////////////////////////////////////////////////// 
    echo $sql_update_arrange = "UPDATE tbl_arrange_nohn SET  sum_weight_nohn = '$total_weight',  sum_scores_nohn = '$total_score',  sum_grade_nohn = '$sum_total_score' WHERE tbl_arrange_nohn.arrange_nohn_id = $arrange_nohn_id ";
    //$conn->query($sql_update_arrange); 
 }

    echo "<br>";

}
$conn->close();


?>