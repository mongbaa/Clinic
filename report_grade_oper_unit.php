<?php include "header.php"; ?>


<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">






<?php

//ตัวแปรเงื่อนไขการค้นหา

if (isset($_GET['type_work_id'])) {
    $type_work_id = $_GET['type_work_id'];
} else {
    $type_work_id = 1;
}

if (isset($_GET['level_search'])) {
    $level_search = $_GET['level_search'];
} else {
    $level_search = 4;
}

if (isset($_GET['student_group'])) {
    $student_group = $_GET['student_group'];
} else {
    $student_group = "";
}

if (isset($_GET['student_search'])) {
    $student_search = $_GET['student_search'];
} else {
    $student_search = "";
}

if (isset($_GET['report_date_id'])) {
    $report_date_id = $_GET['report_date_id'];
} else {
    $report_date_id = '';
}

if (isset($_GET['report_date_id'])) {


    $report_date_id = $_GET['report_date_id'];

    include "config.inc.php";
    $sql_report_date = "SELECT * FROM tbl_report_date  WHERE  report_date_id = $report_date_id ";
    $query_report_date = $conn->query($sql_report_date);
    $result_report_date  = $query_report_date->fetch_assoc();



    $date_start = $result_report_date['report_date_start'];
    $date_end = $result_report_date['report_date_end'];


    $report_date_code = $result_report_date['report_date_code'];
    $report_date_year = $result_report_date['report_date_code'];
} else {


    if (isset($_GET['report_date_code'])) {
        $report_date_code = $_GET['report_date_code'];
    } else {
        $report_date_code = "55";
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
}

?>





<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1>  รายงานคะแนนหน่วยงาน (Complete)  </h1>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>







<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-search"></i> ค้นหาข้อมูล </h3>
    </div>

    <div class="card-body">





        <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
            <div class="row">


                <div class="col-sm-4">


                    <select name="report_date_id" id="report_date_id" class="select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                        <option value="" <?php if ($report_date_id == "") {
                                                echo "selected";
                                            } ?>> -- เลือกช่วงวันที่ -- <?php echo $report_date_id; ?></option>
                        <?PHP
                        include "config.inc.php";
                        $sql_report_date = "SELECT * FROM tbl_report_date  ORDER BY tbl_report_date.report_date_id ASC ";
                        $query_report_date = $conn->query($sql_report_date);
                        while ($result_report_date  = $query_report_date->fetch_assoc()) {

                            $report_date_start = date_create($result_report_date['report_date_start']);
                            $report_date_start = date_format($report_date_start, "d-m-Y");

                            $report_date_end = date_create($result_report_date['report_date_end']);
                            $report_date_end = date_format($report_date_end, "d-m-Y");

                        ?>
                            <option value="<?php echo $result_report_date['report_date_id']; ?>" <?php if ($report_date_id == $result_report_date['report_date_id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                รหัส <?php echo $result_report_date['report_date_code']; ?> ชั้นปี: <?php echo $result_report_date['report_date_year']; ?> (<?php echo $report_date_start; ?> - <?php echo $report_date_end; ?>) </option>
                        <?php } ?>
                    </select>


                </div>




                <!--

                        <div class="col-sm-4">
                            <?php for ($i = 4; $i <= 6; $i++) { ?>
                                <a href="?level_search=<?php echo $i; ?>&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == $i) { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ชั้นปีที่ <?php echo $i; ?> </a>
                            <?php } ?>
                            <a href="?level_search=all&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == "all") { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ทุกชั้นปี </a>
                        </div>
                    -->




                <div class="col-sm-2">
                    <button class="btn btn-info" type="submit">เลือก</button>
                </div>





            </div>

        </form>

        <br>

        <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">

            <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
            <input type="hidden" name="student_search" value="<?php echo $student_search; ?>">


            <div class="row">

                <div class="col-sm-2">
                    <input class="form-control" type="search" name="report_date_code" placeholder="รหัส" value="<?php echo $report_date_code; ?>" aria-label="Search">
                </div>


                <div class="col-sm-2">
                    <input type="date" name="date_start" value="<?php echo $date_start; ?>" class="form-control">
                </div>

                <div class="col-sm-2">
                    <input type="date" name="date_end" value="<?php echo $date_end; ?>" class="form-control">
                </div>



                <div class="col-sm-3">
                    <input class="form-control" type="search" name="student_search" placeholder="รหัส , ชื่อ , สกุล , กลุ่ม" value="<?php echo $student_search; ?>" aria-label="Search">
                </div>

                <div class="col-sm-2">
                    <button class="btn btn-info" type="submit"> ยืนยัน </button>
                </div>

            </div>

        </form>


        <font color="red">*** เลือกช่วงวันที่ และ กดยืนยันอีกครั้ง เพื่อดึงข้อมูล </font>

    </div><!-- /.card-body -->
</div><!-- /.card -->















<?PHP // ข้อมูล งานของแต่ละสาขา
include "config.inc.php";

$plan_array = array();
$sql_plan = " SELECT p.* , t.* , f.*";
$sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = 4  ) as p ";
$sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
$sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
$sql_plan  .=  " ORDER BY p.plan_id ASC ";
$query_plan = $conn->query($sql_plan);
while ($result_plan = $query_plan->fetch_assoc()) {

    $plan_array[] = array(
        'plan_id' => $result_plan['plan_id'],
        'plan_name' => $result_plan['plan_name'],
        'form_main_id' => $result_plan['form_main_id']
    );
}
?>



<!-- Main content -->
<section class="content">
    <div class="container-fluid">


        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-search"></i> แสดงข้อมูลคะแนน </h3>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table id="example1" class="table table-hover" border="1">
                        <thead>
                            <tr>
                                <th Width="7%">รหัส</th>
                                <th Width="15%">ชื่อ-สกุล</th>


                                <?PHP
                                foreach ($plan_array as $values => $data) {
                                    $plan_id_arr =  $data['plan_id'];
                                    $plan_name_arr =  $data['plan_name'];
                                    $form_main_id_arr =  $data['form_main_id'];
                                ?>

                                    <th align="center" ><?php echo $plan_name_arr; ?> </th>

                                <?php } ?>


                                <th >Total</th>
                                
                            </tr>

                         

                        </thead>

                        <tbody>


                            <?php
                            include "config.inc.php";
                            $i = 0;

                            $totall = 0;

                            $sql_student   =  " SELECT *FROM  tbl_student ";


                            if ($level_search == "all") {
                                $sql_student  .=  " ORDER BY student_id ASC   ";
                            } else if ($student_search != "") {
                                $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' or student_group like '%$student_search%'  ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            } else {
                                $sql_student   .=  " where student_id  like '$report_date_code%' and student_level != 7 ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            }

                            $query_student = $conn->query($sql_student);
                            while ($result_student = $query_student->fetch_assoc()) {
                                $i++;
                                $student_id = $result_student['student_id'];
                            ?>


                                <tr>
                                    <td Width="7%"> <?php echo $result_student['student_id']; ?></td>
                                    <td Width="15%"><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?> </td>

                              

                                    <?PHP
                                    
                                    foreach ($plan_array as $values => $data) {
                                        $plan_id_oper =  $data['plan_id'];
                                        $plan_name_arr =  $data['plan_name'];

                                        
                                        
                                        $unit_total = 0;
                                        $detail_work_ids = " and detail_type_work_id = '4' "; //สาขาที่ประเมิน งานที่ Complete
                                        include "config.inc.php";
                                        $sql_detail = " SELECT o.*, d.*, p.* , t.* , f.*";
                                        $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = '$student_id') as o ";
                                        $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE  plan_id = '$plan_id_oper' and detail_complete = 1  $detail_work_ids ) as d  ON  d.order_id = o.order_id";
                                        $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = 4) as p  ON  p.plan_id = d.plan_id";
                                        $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                                        $sql_detail  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
                                        $sql_detail  .=  " ORDER BY d.detail_id ASC ";
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




                                                            $check_f = 0;
                                                            // $detail_id;
                                                             // ข้อมูล ค้นหาคะแนน ของ นพท. ในช่วงวันที่เลือก
                                                            $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id and (last_date BETWEEN '$date_start' AND '$date_end') GROUP BY detail_id DESC";
                                                         // $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                                            $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                                            $query_form_re = $conn->query($sql_form_re);
                                                            if ($row_form_re = $query_form_re->fetch_assoc()) {



                                                                $sql_diagnosis = "SELECT * FROM tbl_oper_diagnosis where detail_id = $detail_id";
                                                                $query_diagnosis = $conn->query($sql_diagnosis);
                                                                $row_diagnosis = $query_diagnosis->fetch_assoc();


                                                          
                                                                 $diagnosis_difficulty = $row_diagnosis['oper_diagnosis_difficulty'];

                                                                 $diagnosis_difficulty = json_decode($diagnosis_difficulty);


                                                                if(!empty($diagnosis_difficulty[0])){

                                                                    $diagnosis_difficulty = $diagnosis_difficulty[0];

                                                                }else{
                                                    
                                                                    $diagnosis_difficulty = 0;
                                                                }
            
                                                                



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
                                                                    $grade_chk_Sealant = $row_form_re['oper_prr_step10_grade'];
                                
                                                                   // if (!empty($grade_chk_Restoration) && !empty($grade_chk_Sealant)) {
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
                                                                    
                                                                    //วันที่ ภาควิชา 5 พ.ค. 66 อ.  09.00น.  ปฏิญา แจ้งเปลี่ยน Polish Old Restoration   บังคับ คูณ 0.2 ทุกคลาส

                                                                    $grade_chk_Beginning = $row_form_re['oper_polish_step1_grade'];
                                                                    $grade_chk_Polishing = $row_form_re['oper_polish_step2_grade'];
                                
                                                                    if (!empty($grade_chk_Beginning) && !empty($grade_chk_Polishing)) {
                                
                                                                         //$unit = $row_class['class_score']  + $diagnosis_difficulty;
                                                                        $unit = 0.2 + $diagnosis_difficulty;
                                
                                                                    }else{
                                
                                                                        $unit = 0;
                                                                        
                                                                    }
                                
                                                                }
                                
                                
                                
                                
                                                                if ($plan_id_oper == 57) { //เช็คหน่วยงาน Treatment Plan   
                                
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

                            
                                                                        if (!empty($grade)) {


                                                                            if ($grade != "F") {
                            
                                                                                $num_f = 0;
                                                                            } else {
                            
                                                                                $num_f = 1;
                                                                            }
                            
                                                                            $check_f = $check_f + $num_f;
                                                                        }//if (!empty($grade)) {



                                                                    }// while ($row_form_detail_re

                                                                  
                                    
                                                             
                                                                    if($check_f==0){
                                
                                                                         $score_unit = $unit;
                                                                   
                                                                     }else{
                                
                                                                         $score_unit = 0;
                                                                    } // if($check_f==0){
                                                                    
                                                                
                                                            }//if ($row_form_re

                                                            

                                                            $unit_total =  $unit_total + @$score_unit;
                                                            $check_f = 0;
                                                            $score_unit  = 0;
                                                        } //while ($result_detail
                                       
                                    ?>

                                        <td>  
                                        <?php
                                        echo $unit_total;
                                      
                                        ?>
                                    </td>

                                    <?php 

                                    $totall = $totall + $unit_total;
                                    
                                    } //foreach ($plan_array as $values => $data) { 
                                     ?>

                                   
                                <td>  <?php echo $totall;?> </td>






                                </tr>


                            <?php 
                        
                        $totall = 0;
                                    $unit = 0;
                                    $unit_total = 0;
                        
                        
                        } ?>


                        <tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
</section>





<?php include "footer.php"; ?>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            "paging": true,
            "pageLength": 50,
            "lengthChange": true,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            "buttons": ["excel"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        $('#example3').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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

<!-- page script Tooltip -->
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<!-- page script Tooltip -->

</body>

</html>