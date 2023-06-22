<meta charset="utf-8">
<?php
//ตัวแปรเงื่อนไขการค้นหา

if (isset($_GET['level_search'])) {
    $level_search = $_GET['level_search'];
} else {
    $level_search = 4;
}

if (isset($_GET['student_search'])) {
    $student_search = $_GET['student_search'];
} else {
    $student_search = "";
}

if (isset($_GET['date_start'])) {
    $date_start = $_GET['date_start'];
} else {
    $date_start = date('Y-m-d');
}

if (isset($_GET['date_end'])) {
    $date_end = $_GET['date_end'];
} else {
    $date_end = date('Y-m-d');
}

$student_id = $student_search;


?>


<?php
if(isset($_GET['act'])){
	if($_GET['act']== 'excel'){
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=export".$student_search.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
}
?>





<?php
include "_class_student.php";
include "_class_teacher.php";
include "_class_class.php";
include "_class_type_work.php";
include "_class_plan.php";
include "_class_causes_of_pay.php";
include "_class_detail.php";
include "_class_detail_order.php";


 include  "config.inc.php";


$student_id = $student_search;
$sql_student   =  " SELECT *FROM  tbl_student where student_id = '$student_id' ";
$sql_student  .=  " ORDER BY student_id ASC   ";
$query_student = $conn->query($sql_student);
if ($result_student = $query_student->fetch_assoc()) {

    $result_students = 1;

    $student_id = $result_student['student_id'];
    $student_name = $result_student['student_name'];
    $student_lastname = $result_student['student_lastname'];
    $student_level = $result_student['student_level'];
    $student_group = $result_student['student_group'];


    // ข้อมูลงานที่มีในสาขาที่ส่งค่ามา
    $plan_oper_array = array();
    $plan_array_index = array();


    include "config.inc.php";
    $sql_plan = " SELECT o.*, d.*, COUNT( d.detail_id ) AS count_detail, p.*, t.*, f.* ";
    $sql_plan  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
    //$sql_plan  .=  " INNER JOIN (SELECT detail_id, order_id, plan_id, detail_type_work_id  FROM tbl_detail where detail_complete = 1 or detail_date_complete != '0000-00-00' ) as d  ON  d.order_id = o.order_id";
    
    $sql_plan  .=  " INNER JOIN (SELECT detail_id, order_id, plan_id, detail_type_work_id  FROM tbl_detail) as d  ON  d.order_id = o.order_id";

    $sql_plan  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = 4) as p  ON  p.plan_id = d.plan_id";
    $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
    $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y') AS f  ON  f.form_main_id = p.form_main_id ";
    $sql_plan  .=  " group by d.plan_id ";


    //echo   $sql_plan;
    $query_plan = $conn->query($sql_plan);
    while ($result_plan = $query_plan->fetch_assoc()) {

        //echo $result_plan['plan_id'];

        $plan_oper_array[] = array(
            'plan_id_oper' => $result_plan['plan_id'],
            'plan_name' => $result_plan['plan_name'],
            'count_detail' => $result_plan['count_detail']
        );
    }
}

?>





<?php if (!empty($result_students)) { ?>



    <h1> Report > <?php echo $student_id; ?> : <?php echo $student_name; ?> <?php echo $student_lastname; ?> ชั้นปี <?php echo $student_level; ?></h1>





    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


            <?php
            foreach ($plan_oper_array as $values => $data) {
                $plan_id_oper =  $data['plan_id_oper'];
                $plan_name =  $data['plan_name'];
                $count_detail =  $data['count_detail'];
            ?>

                <h3> <?php echo $data['plan_id_oper']; ?> <?php echo $data['plan_name']; ?> (<?php echo $data['count_detail']; ?>) </h3>
                        


                <?php
                $unit_total = 0;
                $detail_work_ids = " and detail_type_work_id = '4' "; //สาขาที่ประเมิน งานที่ Complete
                include "config.inc.php";
                $sql_detail = " SELECT o.*, d.*, p.* , t.* , f.*";
                $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = '$student_id') as o ";
               // $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE  plan_id = '$plan_id_oper' and (detail_complete = 1 or detail_date_complete != '0000-00-00')  $detail_work_ids ) as d  ON  d.order_id = o.order_id";
                $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE  plan_id = '$plan_id_oper') as d  ON  d.order_id = o.order_id";

                $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = 4) as p  ON  p.plan_id = d.plan_id";
                $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                $sql_detail  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
                
                //$sql_detail  .=  " ORDER BY d.detail_id ASC ";

                $sql_detail  .=  " ORDER BY d.class_id ASC "; // เรียงตามคลาส


                $query_detail = $conn->query($sql_detail);
                while ($result_detail = $query_detail->fetch_assoc()) {

                    $tbl = $result_detail['form_main_table']; // ชื่อตาราง
                    $tbl_id = $tbl . "_id"; // Id ของตาราง
                    $detail_id = $result_detail['detail_id']; //รหัสงาน
                    $form_main_id = $result_detail['form_main_id']; //รหัสฟอร์ม


                    //--------------- ข้อมูล class หน่วยงาน --------------- //
                    $class_id =  $result_detail['class_id']; // ชื่อตาราง
                    $sql_class = "SELECT * FROM tbl_class where class_id = $class_id";
                    $query_class = $conn->query($sql_class);
                    $row_class = $query_class->fetch_assoc();
                    $class_score =  $row_class['class_score'];


                ?>




                    <?php // ดึงข้อมูลคะแนนที่ประเมินในตารางคะแนน

                    $check_f = 0;
                    // $detail_id;
                    $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                    $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                    $query_form_re = $conn->query($sql_form_re);
                    if ($row_form_re = $query_form_re->fetch_assoc()) {
                    ?>


                        <h4>
                            HN : <?php echo $result_detail['HN']; ?> :
                            <?php echo $result_detail['pname']; ?><?php echo $result_detail['fname']; ?>
                            <?php echo $result_detail['lname']; ?>



                            <?php if (!empty($result_detail['detail_surface'])) { ?>
                                Surface : <?php echo $result_detail['detail_surface']; ?>
                            <?php } ?>



                            <?php if (!empty($result_detail['detail_root'])) { ?>
                                Root : <?php echo $result_detail['detail_root']; ?>
                            <?php } ?>



                            <?php if (!empty($result_detail['class_id'])) { ?>
                                Class : <?php echo nameClass::get_class_name($result_detail['class_id']); ?> (<?php echo  $class_score; ?>)
                            <?php } ?>



                            <?php if (!empty($result_detail['detail_tooth'])) {  ?>
                                <?php
                                $array_detail_tooth = (array)json_decode($result_detail['detail_tooth']);
                                $toothh = "";
                                foreach ($array_detail_tooth as $id => $value) {
                                ?>
                                    <span class="badge badge-success"> <?php echo $value; ?></span>

                                <?php }  ?>
                            <?php
                            }
                            ?>





                            <!--<span class='badge bg-warning'><?php echo nameType_work::get_type_work_name($result_detail['detail_type_work_id']); ?></span>-->


                            <?php if ($result_detail['detail_date_complete'] != "0000-00-00") { //complete 
                            ?>

                                <font color='red'> Complete
                                    <?php
                                    $detail_date_complete = date_create($result_detail['detail_date_complete']);
                                    echo date_format($detail_date_complete, "d-m-Y");
                                    ?>
                                </font>

                            <?php }  ?>




                            <?php if ($result_detail['detail_competency'] == 1) { //Competency 
                            ?>
                                > Competency
                            <?php }  ?>




                        </h4>



                        <font color ="red">
                            <?php 
                              $field_comment = $tbl."_comment"; // ชื่อ field comment
                              $comment = $row_form_re["{$field_comment}"];
                              echo $comment;
                            ?>
                        </font>



                        <div class="card card-default color-palette-box">
                            <div class="card-header bg-info">
                               
                                <?php
                                //--------------- ข้อมูล diagnosis --------------- //
                                $sql_diagnosis = "SELECT * FROM tbl_oper_diagnosis where detail_id = $detail_id";
                                $query_diagnosis = $conn->query($sql_diagnosis);
                                $row_diagnosis = $query_diagnosis->fetch_assoc();
                                $diagnosis_difficulty = $row_diagnosis['oper_diagnosis_difficulty'];
                                $diagnosis_difficulty = json_decode($diagnosis_difficulty);
                                if (!empty($diagnosis_difficulty)) {
                                    $diagnosis_difficulty = json_decode($diagnosis_difficulty);
                                } else {
                                    $diagnosis_difficulty = '+0';
                                }
                                echo " > Difficulty : " . $diagnosis_difficulty;
                                ?>



                                <?php

                                if ($plan_id_oper == 47) { //เช็คหน่วยงาน Filling  

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6

                                    //3. การนับหน่วยเพิ่ม 
                                    //3.1. Beginning Check & Outline = step1
                                    //3.2. Restoration  = step9
                                    //3.3. Polishing = step10

                                    //ประเมิน 3.1,3.2,3.3 = หน่วย *1 *Difficulty
                                    //ประเมิน 3.1,3.2 = หน่วย *0.75 *Difficulty
                                    /*
                                                echo $grade_chk_Beginning = $row_form_re['oper_filling_step1_grade'];
                                                echo ",";
                                                echo $grade_chk_Restoration = $row_form_re['oper_filling_step9_grade'];
                                                echo ",";
                                                echo $grade_chk_Polishing = $row_form_re['oper_filling_step10_grade'];
                                                echo " ";
                                    */

                                    $grade_chk_Beginning = $row_form_re['oper_filling_step1_grade'];
                                    $grade_chk_Restoration = $row_form_re['oper_filling_step9_grade'];
                                    $grade_chk_Polishing = $row_form_re['oper_filling_step10_grade'];


                                    ////ประเมิน 3.1,3.2,3.3 = หน่วย *1 *Difficulty
                                    if (!empty($grade_chk_Beginning) && !empty($grade_chk_Restoration) && !empty($grade_chk_Polishing)) {
                                        $chk_unit = 1;
                                        $unit = ($row_class['class_score'] * $chk_unit) + $diagnosis_difficulty;
                                        //ประเมิน 3.1,3.2 = หน่วย *0.75 *Difficulty
                                    } else if (!empty($grade_chk_Beginning) && !empty($grade_chk_Restoration)) {
                                        $chk_unit = 0.75;
                                        $unit = ($row_class['class_score'] * $chk_unit) + $diagnosis_difficulty;
                                    } else {
                                        $chk_unit = 0;
                                        $unit = 0;
                                    }

                                    //echo  $unit;

                                }




                               
                            
                                if ($plan_id_oper == 48) { //เช็คหน่วยงาน PRR  

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6
                                    //3                            
                                    $grade_chk_Restoration  = $row_form_re['oper_prr_step9_grade'];
                                   // $grade_chk_Sealant = $row_form_re['oper_prr_step10_grade'];

                                    if (!empty($grade_chk_Restoration)) {

                                        $unit = $row_class['class_score']  + $diagnosis_difficulty;

                                    }else{

                                        $unit = 0;
                                        
                                    }

                                }





                                if ($plan_id_oper == 49) { //เช็คหน่วยงาน Sealant   

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6
                                    //3                            
                                    $grade_chk_Beginning = $row_form_re['oper_sealant_step1_grade'];
                                    $grade_chk_Sealant = $row_form_re['oper_sealant_step3_grade'];

                                    if (!empty($grade_chk_Beginning) && !empty($grade_chk_Sealant)) {

                                        $unit = $row_class['class_score']  + $diagnosis_difficulty;

                                    }else{

                                        $unit = 0;
                                        
                                    }

                                }




                                if ($plan_id_oper == 50) { //เช็คหน่วยงาน Polish Old Restoration   

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6
                                    //3                            
                                    $grade_chk_Beginning = $row_form_re['oper_polish_step1_grade'];
                                    $grade_chk_Polishing = $row_form_re['oper_polish_step2_grade'];

                                    if (!empty($grade_chk_Beginning) && !empty($grade_chk_Polishing)) {

                                        $unit = $row_class['class_score']  + $diagnosis_difficulty;

                                    }else{

                                        $unit = 0;
                                        
                                    }

                                }




                                if ($plan_id_oper == 57) { //เช็คหน่วยงาน Polish Old Restoration   

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6
                                    //3                            
                                    $grade_chk_treatment = $row_form_re['oper_treatment_step1_grade'];
                                

                                    if (!empty($grade_chk_treatment)) {

                                        $unit = $row_class['class_score']  + $diagnosis_difficulty;

                                    }else{

                                        $unit = 0;
                                        
                                    }

                                }




                                if ($plan_id_oper == 52) { //เช็คหน่วยงาน Direct veneer

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6
                                    //3                            

                                    $grade_chk_Beginning = $row_form_re['oper_direct_step1_grade'];
                                    $grade_chk_Restoration = $row_form_re['oper_direct_step9_grade'];
                                    $grade_chk_Polishing = $row_form_re['oper_direct_step10_grade'];


                                   
                                    if (!empty($grade_chk_Beginning) && !empty($grade_chk_Restoration) && !empty($grade_chk_Polishing)) {
                                   ////ประเมิน 3.1,3.2,3.3 = หน่วย *1 *Difficulty
                                        $unit = ($row_class['class_score'] * 1) + $diagnosis_difficulty;
                                        
                                    } else if (!empty($grade_chk_Beginning) && !empty($grade_chk_Restoration)) {
                                  //ประเมิน 3.1,3.2 = หน่วย *0.75 *Difficulty
                                        $unit = ($row_class['class_score'] * 0.75) + $diagnosis_difficulty;
                                    } else {
                                      
                                        $unit = 0;
                                    }


                                }



                                
                                if ($plan_id_oper == 51) { //เช็คหน่วยงาน ทายาแก้เสียวฟัน

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6
                                    //3                            
                                    $grade_chk_Beginning = $row_form_re['oper_dent_step1_grade'];
                                

                                    if (!empty($grade_chk_Beginning)) {

                                        $unit = $row_class['class_score']  + $diagnosis_difficulty;

                                    }else{

                                        $unit = 0;
                                        
                                    }

                                }



                                  
                                if ($plan_id_oper == 56) { //เช็คหน่วยงาน Walking bleaching

                                    //เงื่อนไข
                                    //1.complete //งานที่แสดงเป็นงานที่ complete อยู่แล้วเท่านั้น
                                    //2.ไม่มี F ปี4   ไม่มี CF ปี5,6
                                    //3                            
                                   /* $grade_chk_treatment = $row_form_re['oper_treatment_step1_grade'];
                                

                                    if (!empty($grade_chk_treatment)) {

                                        $unit = $row_class['class_score']  + $diagnosis_difficulty;

                                    }else{

                                        $unit = 0;
                                        
                                    }*/
                                }
                                ?>


                            </div>

                            <div class="card-body">

                                <table id="example3" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th Width="3%">
                                                <div align="center">ลำดับ</div>
                                            </th>
                                            <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>

                                            <th Width="7%">
                                                <div align="center"> ครั้ง </div>
                                            </th>
                                            <th Width="7%">
                                                <div align="center">คะแนน</div>
                                            </th>
                                            <th Width="7%">
                                                <div align="center"> ผู้ประเมิน </div>
                                            </th>
                                            <th Width="7%">
                                                <div align="center">วันที่</div>
                                            </th>                                     
                                        </tr>

                                    </thead>

                                    <tbody>


                                        <?php
                                        $i_re = 0;
                                        // หาชื่อฟิลด์
                                        $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                                        $sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
                                        $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                                        //echo $sql_form_detail_re;
                                        $query_form_detail_re = $conn->query($sql_form_detail_re);
                                        while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                            $i_re++;

                                            $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์

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




                                            if (!empty($grade)) {


                                                if ($grade != "F") {

                                                    $num_f = 0;
                                                } else {

                                                    $num_f = 1;
                                                }

                                                $check_f = $check_f + $num_f;

                                        ?>

                                                <tr>
                                                    <td>
                                                        <div align="center"> <?php echo $i_re; ?></div>
                                                    </td>

                                                    <td><?php echo $row_form_detail_re['form_detail_topic']; ?> </td>

                                                    <td>
                                                        <div align="center"><?php echo $weight; ?>
                                                    </td>

                                                    <td>
                                                        <div align="center"> <?php echo $grade; ?> (<?php echo $score; ?>) </div>
                                                    </td>

                                                    <td>
                                                        <div align="center">
                                                            <?php echo nameTeacher::get_teacher_name($teacher); ?>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div align="center">

                                                            <?php
                                                            $date = date_create($datee);
                                                            echo date_format($date, "d/m/Y H:i:s");
                                                            ?>
                                                        </div>
                                                    </td>



                                                </tr>

                                        <?php
                                            } //if (!empty($grade)) {                                    
                                        ?>

                                        <?php }  //while ($row_form_detail_re ?>

                                    </tbody>

                                </table>

                                <h2>

                                    Check_F = <?php echo  $check_f;
                                    
                                    
                                    echo " : หน่วยที่ได้ : ";
                                    if($check_f==0){

                                       echo  $score_unit = $unit;
                                   
                                     }else{

                                        echo $score_unit = 0;

                                     }
                                    
                                    
                                    
                                    ?>

                                    
                                </h2>


                                
                                       

                            </div>
                        </div>

                        <?php } // $sql_form_re ?>
                       

                    <?php


                    $unit_total =  $unit_total + $score_unit;
                    $check_f = 0;
                    $score_unit  = 0;
                } //while ($result_detail
                    ?>


                    <h1>
                    <?php
                    echo $data['plan_name'];
                    echo " = ";
                    echo $unit_total;
                    $unit = 0;
                    $unit_total = 0;
                    ?>
                    </h1>
                    <hr>

                    

                    <br>
                    <br>
                    <br>



                <?php } //foreach Work
                ?>



            <?php } ?>




        </div>
    </section>





    <!-- /.content -->


    <?php include "footer.php"; ?>



    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>



    <!-- Page script -->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });
            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                            .endOf('month')
                        ]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

        })
    </script>

    <!-- page script -->


    <script src="dist/js/pages/dashboard.js"></script>




    <script>
        var ctx = document.getElementById("areaChart");
        var myChart = new Chart(ctx, {
            type: 'line',


            data: {
                labels: [<?php foreach ($plan_array_index as $values => $data) { ?> '<?php echo $data['plan_name']; ?>',
                    <?php } ?>
                ],
                datasets: [{
                    label: '# of Votes',
                    data: [<?php foreach ($plan_array_index as $values => $data) { ?> '<?php echo $data['count_detail']; ?>',
                        <?php } ?>

                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });



        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($plan_array_index as $values => $data) { ?> '<?php echo $data['plan_name']; ?>',
                    <?php } ?>
                ],
                datasets: [{

                    label: ['# of Votes'],
                    data: [<?php foreach ($plan_array_index as $values => $data) { ?> '<?php echo $data['count_detail']; ?>', <?php } ?>],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                    borderWidth: 1

                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });











        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [<?php foreach ($plan_array_index as $values => $data) { ?> '<?php echo $data['plan_name']; ?>',
                    <?php } ?>
                ],
                datasets: [{
                    label: '# of Votes',
                    data: [<?php foreach ($plan_array_index as $values => $data) { ?> '<?php echo $data['count_detail']; ?>',
                        <?php } ?>

                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>





    </body>

    </html>