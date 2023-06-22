<?PHP
session_start();
?>
 <meta charset="utf-8">



<?php
//ตัวแปรเงื่อนไขการค้นหา


if (isset($_GET['tbl_s'])) {
    $tbl_s          = $_GET['tbl_s'];
} else {
    $tbl_s = "";
}


if (isset($_GET['tbl_id_s'])) {
    $tbl_id_s       = $_GET['tbl_id_s'];
} else {
    $tbl_id_s = 0;
}


if (isset($_GET['form_main_id_s'])) {
    $form_main_id_s = $_GET['form_main_id_s'];
} else {
    $form_main_id_s = "";
}


if (isset($_GET['detail_id_s'])) {
    $detail_id_s    = $_GET['detail_id_s'];
} else {
    $detail_id_s = "";
}

if (isset($_GET['student_search'])) {
    $student_search = $_GET['student_search'];
} else {
    $student_search = "";
}

$student_id = $student_search;


include "config.inc.php";
$sql_student   =  " SELECT * FROM  tbl_student where student_id = '$student_id' ";
$sql_student  .=  " ORDER BY student_id ASC   ";
$query_student = $conn->query($sql_student);
if ($result_student = $query_student->fetch_assoc()) {

    $result_students = 1;

    $student_id = $result_student['student_id'];
    $student_name = $result_student['student_name'];
    $student_lastname = $result_student['student_lastname'];
    $student_level = $result_student['student_level'];
    $student_group = $result_student['student_group'];



    $type_work_id = 6; //Report Crown and Bridge

    // ข้อมูลงานที่มีในสาขาที่ส่งค่ามา
    $plan_oper_array = array();

    include "config.inc.php";
    $sql_plan = " SELECT o.*, d.*, COUNT( d.detail_id ) AS count_detail, p.*, t.*, f.* ";
    $sql_plan  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
    $sql_plan  .=  " INNER JOIN (SELECT detail_id, order_id, plan_id, detail_type_work_id  FROM tbl_detail ) as d  ON  d.order_id = o.order_id";
    $sql_plan  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = d.plan_id";
    $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
    $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y') AS f  ON  f.form_main_id = p.form_main_id ";
    $sql_plan  .=  " group by d.plan_id ";

    //echo   $sql_plan;
    $query_plan = $conn->query($sql_plan);
    while ($result_plan = $query_plan->fetch_assoc()) {

        //echo $result_plan['plan_id'];

        $plan_oper_array[] = array(
            'plan_id' => $result_plan['plan_id'],
            'plan_name' => $result_plan['plan_name'],
            'count_detail' => $result_plan['count_detail']
        );
    }
} else {

    $student_name = "";
    $student_lastname = "";
    $student_level = "";
}




$conn->close();
?>


                            <?php
                                    $summary_full =  0;

                                    
                                    include "config.inc.php";

                                    $sql_detail_show = " SELECT  d.*, p.*, c.*, o.*";
                                    $sql_detail_show  .=  " FROM        tbl_detail        AS d ";
                                    $sql_detail_show  .=  " INNER JOIN  tbl_plan          AS p  ON  d.plan_id = p.plan_id";
                                    $sql_detail_show  .=  " LEFT  JOIN  tbl_causes_of_pay AS c  ON  d.causes_of_pay_id = c.causes_of_pay_id ";
                                    $sql_detail_show  .=  " INNER JOIN (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ON  d.order_id = o.order_id";
                                    $sql_detail_show  .=  " WHERE d.detail_id = $detail_id_s";
                                    $query_detail_show = $conn->query($sql_detail_show);
                                    $result_detail_show = $query_detail_show->fetch_assoc();
                                    $conn->close();


                                    $detail_competency = $result_detail_show['detail_competency'];


                            ?>




<?php
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=export_C&B_".$student_id."_".$student_name."_".$student_lastname."_".$result_detail_show['HN'].".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
?>





                                        HN : <?php echo $result_detail_show['HN']; ?> :
                                        <?php echo $result_detail_show['pname']; ?><?php echo $result_detail_show['fname']; ?>
                                        <?php echo $result_detail_show['lname']; ?>


                                        <?php if (!empty($result_detail_show['plan_name'])) { ?>
                                            Plan : <?php echo $result_detail_show['plan_name']; ?>
                                        <?php } ?>


                                        <?php if (!empty($result_detail_show['detail_surface'])) { ?>
                                            Surface : <?php echo $result_detail_show['detail_surface']; ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail_show['detail_root'])) { ?>
                                            Root : <?php echo $result_detail_show['detail_root']; ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail_show['class_id'])) { ?>
                                            Class : <?php echo nameClass::get_class_name($result_detail_show['class_id']); ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail_show['detail_tooth'])) {  ?>

                                            <?php
                                            $array_detail_tooth = (array)json_decode($result_detail_show['detail_tooth']);

                                            foreach ($array_detail_tooth as $id => $value) {
                                            ?>
                                                <span class="badge badge-success"> <?php echo $value; ?></span>

                                            <?php }  ?>

                                        <?php
                                        }
                                        ?>


                                        Date : <?php echo $result_detail_show['detail_date_work']; ?>

                                        <?php if ($result_detail_show['detail_date_complete'] != "0000-00-00") { ?>
                                                <?php if ($result_detail_show['causes_of_pay_detail'] == 7) { ?>
                                                Complete <?php echo $result_detail_show['detail_date_complete']; ?>
                                                <?php }else{ ?>
                                                    จ่ายออก : <?php echo $result_detail_show['causes_of_pay_detail']; ?>
                                                <?php }  ?>
                                        <?php }  ?>

                                        <?php if ($result_detail_show['detail_competency'] == 1) { ?>
                                            Competency
                                        <?php }  ?>


                                    <br>






                                    <?php 
                                    echo  $student_id;
                                    echo " ";
                                    echo  $student_name;
                                    echo " ";
                                    echo  $student_lastname;
 
 ?>


        <style>
            table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            border-style: dotted;
            padding: 10px;
            }
        </style>







                <table id="example" class="stripe row-border order-column">
                                        <thead>
                                            <tr>
                                                <th Width="3%">
                                                    <div align="center">ลำดับ</div>
                                                </th>
                                                <th Width="30%">หัวข้อการประเมิน / น้ำหนัก </th>
                                                    <?php
                                                    include "config.inc.php";
                                                    $i_count = 0;
                                                    $sql_form_re = "SELECT * FROM tbl_" . $tbl_s . " where detail_id = $detail_id_s";
                                                    $sql_form_re  .=  " ORDER BY $tbl_id_s  ASC ";
                                                    $query_form_re = $conn->query($sql_form_re);
                                                    while ($row_form_re = $query_form_re->fetch_assoc()) {
                                                        $i_count++;
                                                        $last_date = $row_form_re['last_date'];
                                                        $id_form_re = $row_form_re["{$tbl_id_s}"];
                                                    ?>
                                                        <th Width="7%">
                                                            <div align="center"><?php echo $i_count; ?></div>
                                                        </th>
                                                    <?php }
                                                    $conn->close();
                                                    ?>
                                                <th Width="5%"> ครั้ง </th>
                                                <th Width="5%"> คะแนน</th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                            <?php
                                            include "config.inc.php";
                                            $i_re = 0;
                                            $sum_score_total = 0;
                                            $sum_score = 0;
                                            $sum_weight_total = 0;

                                            $st = 0;
                                           

                                            $summary_score  =  0;
                                            $summary_full =  0;


                                            // หาชื่อฟิลด์
                                            $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order, fd.form_detail_weight";
                                            $sql_form_detail_re  .=  " FROM (SELECT f.* FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id_s') AS fd ";
                                            $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                                            $query_form_detail_re = $conn->query($sql_form_detail_re);
                                            while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                                $i_re++;
                                                $field = $tbl_s . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                                                $form_detail_id = $row_form_detail_re['form_detail_id'];
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i_re; ?>
                                                    </td>
                                                    <td><?php echo $row_form_detail_re['form_detail_topic']; ?> / (<?php echo $row_form_detail_re['form_detail_weight']; ?>) </td>

                                                    <?php
                                                    $total_stepp_full = 0;
                                                    $total_score = 0;
                                                    $total_score_full = 0;
                                                    $total_full_stepp = 0;

                                                    $sum_weight_total = 0;
                                                    $sum_score_total = 0;
                                                    $sum_score = 0;
                                                    $sql_form_re_ = "SELECT * FROM tbl_" . $tbl_s . " where detail_id = $detail_id_s";
                                                    $sql_form_re_  .=  " ORDER BY $tbl_id_s  ASC ";
                                                    $query_form_re = $conn->query($sql_form_re_);
                                                    while ($row_form_re = $query_form_re->fetch_assoc()) {


                                                        $last_date = $row_form_re['last_date'];
                                                        $id_form_re = $row_form_re["{$tbl_id_s}"];
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

                                                        $sum_score = $weight * $score;
                                                        $sum_stepp = $stepp++; // รวม จำนวนครั้ง
                                                        $sum_score_full = $weight * 4;   //คะแนนเต็ม
                                                    ?>



                                                        <td class="<?php echo $claass; ?>">
                                                            <div align="center">
                                                                <?php echo  $sum_score; ?> 
                                                        </td>


                                                    <?php
                                                        $sum_weight_total = $sum_weight_total + $weight_ss;
                                                        $sum_score_total = $sum_score_total + $sum_score;

                                                        $total_score_full = $total_score_full + $sum_score_full;   //คะแนนเต็มในขั้นตอนรวมกัน
                                                        $total_score = $total_score + $sum_score;  //คะแนนรวมในขั้นตอน
                                                        $total_stepp_full = $total_stepp_full + $sum_stepp;   //จำนวนครั้งในขั้นตอนรวมกัน
                                                    }
                                                    ?>

                                                    <td class="table-danger">
                                                        <div align="center"><?php echo  $total_stepp_full; ?></div>
                                                    </td>

                                                    <!--  
                                                        <td class="table-warning">
                                                            <div align="center"><?php echo  $total_score_full; ?></div>
                                                        </td>
                                                         -->

                                                    <!--  
                                                        <td class="table-success">
                                                            <div align="center">
                                                                <?php
                                                                if ($total_stepp_full == 0) {
                                                                    $total_full_stepp =  0;
                                                                } else {
                                                                    $total_full_stepp =  $total_score_full / $total_stepp_full; //คะแนนเต็มหารจำนวนครั้ง
                                                                }
                                                                echo $total_full_stepp;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        -->






                                                    <!-- 
                                                    <td class="table-info">
                                                        <div align="center"><?php echo  $total_score; ?></div>
                                                    </td>
                                                        -->

                                                    <td class="table-success">
                                                        <div align="center">
                                                            <?php
                                                            if ($total_stepp_full == 0) {
                                                                $total_score_stepp =  0;
                                                            } else {
                                                                $total_score_stepp =  $total_score / $total_stepp_full; //คะแนนจริงที่หารจำนวนครั้ง
                                                            }
                                                            echo $total_score_stepp;
                                                            ?>
                                                        </div>
                                                    </td>



                                                    <!-- 
                                                    <td class="table-success">
                                                        <div align="center">
                                                            <?php
                                                            if ($total_score_full == 0) {
                                                                $total_full_full =  0;
                                                            } else {
                                                                $total_full_full =  ($total_score_stepp / $total_score_full) * 100;
                                                            }
                                                            echo $total_full_full;
                                                            ?> %
                                                        </div>
                                                    </td>
                                                    -->



                                                </tr>
                                            <?php
                                                $summary_score  =  $summary_score + $total_score_stepp;
                                                $summary_full  =   $summary_full  + $total_full_stepp;
                                            } //row_form_detail_re
                                            ?>

                                           

                                             <tr>
                                                <th align="right" colspan="<?php echo $i_count+4;?>"> 
                                                ค่าเฉลี่ย <?php echo $summary_score; ?> /   <?php echo $summary_full; ?> =  
                                            
                                                <?php   
                                                if(!empty($summary_score)){
                                                $st = $summary_score / $summary_full;    
                                                }else{
                                                $st = 0; 
                                                }
                                                ?> 
                                                <?php  echo @$st = round($st,4); ?>  
                                             </th>

                                             </tr>
                                             <tr>
                                                <th align="right" colspan="<?php echo $i_count+4;?>">  <?php  $st100 = ($st*100) ; echo  number_format($st100,2);?>  % </th>
                                             </tr>

                                        </tbody>

                                    </table>
                                


                              
                              

                              
                         
                               