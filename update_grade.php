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
<meta charset="utf-8">




<?PHP
if (isset($_GET['type_work_id'])) {
    include "config.inc.php";
    $type_work_id = $_GET['type_work_id'];
    $sql_type_work = "SELECT * FROM tbl_type_work  where type_work_id = $type_work_id ";
    $query_type_work = $conn->query($sql_type_work);
    $result_type_work  = $query_type_work->fetch_assoc();
    $type_work_id = $result_type_work['type_work_id'];
    $type_work_name = $result_type_work['type_work_name'];
} else {
    $type_work_name = "";
    $type_work_id = "";
}

?> 



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


        if (isset($_GET['student_group'])) {
            $student_group = $_GET['student_group'];
        } else {
            $student_group = '';
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

            $conn -> close();

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


<?php
if(isset($_GET['act'])){
	if($_GET['act']== 'excel'){
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=export.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
}
?>



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
                                <?php } 
                                $conn -> close();
                                
                                ?>
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


<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> Score By Work  <?php echo $type_work_name; ?></h3>
    </div>

    <div class="card-body">

        <?PHP // ข้อมูล งานของแต่ละสาขา
        include "config.inc.php";

        $plan_array = array();
        $sql_plan = " SELECT p.* , t.* , f.*";
        $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p ";
        $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
        $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y') AS f  ON  f.form_main_id = p.form_main_id ";
        $sql_plan  .=  " ORDER BY f.form_main_type,p.plan_id ASC ";
        $query_plan = $conn->query($sql_plan);
        while ($result_plan = $query_plan->fetch_assoc()) {
            $plan_array[] = array(
                'plan_id' => $result_plan['plan_id'],
                'plan_name' => $result_plan['plan_name'],
                'form_main_type' => $result_plan['form_main_type'],
                'form_main_id' => $result_plan['form_main_id'],
                'tbl' => $result_plan['form_main_table']
            );
        }
 
        ?>


        <div class="table-responsive">


            <table id="example1" class="table table-hover" border = "1">

                <thead>

                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ-สกุล</th>
                        <?PHP
                        foreach ($plan_array as $values => $data) {
                            $plan_id_arr =  $data['plan_id'];
                            $plan_name_arr =  $data['plan_name'];
                        ?>
                            <th colspan="2"><?php echo $plan_name_arr; ?> / <?php echo $plan_id_arr; ?></th>
                        <?php } ?>
                    </tr>
        
                    <tr>
                        <th></th>
                        <th></th>
                        <?PHP
                        foreach ($plan_array as $values => $data) {
                            $plan_id_arr =  $data['plan_id'];
                            $plan_name_arr =  $data['plan_name'];
                        ?>
                            <th><a href="#" data-toggle="tooltip" title="Count Work">C</a></th>
                            <th><a href="#" data-toggle="tooltip" title="Sum (weight)">Process</a></th>
                        <?php }  ?>
                    </tr>


                </thead>
                <tbody>

                    <?php
                    $total_form_rei_sum  = 0;
                    $total_score_sum = 0;
                    $total_weight_sum = 0;
                    $total_grade_sum = 0;
                    include "config.inc.php";
                    $i = 0;
                    $sql_student   =  " SELECT *FROM  tbl_student ";
                    if ($level_search == "all") {
                        $sql_student  .=  " ORDER BY student_id ASC   ";
                    } else if ($student_search != "") {
                        $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' or student_group like '%$student_search%'  ";
                        $sql_student  .=  " ORDER BY student_id ASC  ";
                    } else {
                        $sql_student   .=  " where student_id  like '$report_date_code%' and student_level != 7 and student_group like '%$student_group%' ";
                        $sql_student  .=  " ORDER BY student_id ASC  ";
                    }
                    echo  $sql_student ;
                    $query_student = $conn->query($sql_student);
                    while ($result_student = $query_student->fetch_assoc()) {
                    $i++;
                    $student_id = $result_student['student_id'];
                    ?>
                        <tr>
                            <td width="7%"> <?php echo $result_student['student_id']; ?></td>
                            <td width="7%"><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></td>

                            <?PHP
                            foreach ($plan_array as $values => $data) {
                                $plan_id_arr =  $data['plan_id'];
                                $plan_name_arr =  $data['plan_name'];
                                $form_main_type =  $data['form_main_type'];
                                $form_main_id =  $data['form_main_id'];
                                $tbl =  $data['tbl'];
                                $tbl_id = $tbl . "_id"; // Id ของตาราง
                            ?>



                                <td  align="center">
                                    <?php
                                        if($form_main_type == 1){
                                        $sql_detail =    " SELECT   o.order_id, o.student_id,    ";
                                        $sql_detail  .=  " COUNT(d.detail_id) as count_detail_id, ";
                                        $sql_detail  .=  " d.detail_id, d.detail_score, d.detail_weight, d.detail_total, d.detail_date_last";
                                        $sql_detail  .=  " FROM ";
                                        $sql_detail  .=  " tbl_detail AS d ";
                                        $sql_detail  .=  " INNER JOIN tbl_order AS o ON o.order_id = d.order_id";
                                        $sql_detail  .=  " WHERE  o.student_id = '$student_id' and d.plan_id = $plan_id_arr ";
                                        //ไม่ได้อัพเดท วันที่ล่าสุด
                                        // $sql_detail  .=  " WHERE   d.detail_date_last IS NULL  and o.student_id = '$student_id' and d.plan_id = $plan_id_arr ";
                                        // $sql_detail  .=  " and (d.detail_complete = 1 or d.detail_date_complete!='0000-00-00') ";
                                            $sql_detail  .=  "";
                                            $query_detail = $conn->query($sql_detail);
                                            $result_detail = $query_detail->fetch_assoc();
                                            $count_detail_id = $result_detail['count_detail_id'];
                                            echo "<B>".$count_detail_id."</B>";
                                        }else{
                                            $sql_nohn = " SELECT count(n.arrange_nohn_id) as count_arrange_nohn_id FROM ";
                                            $sql_nohn  .=  " tbl_arrange_nohn  as n  WHERE n.student_id = $student_id and n.plan_id = $plan_id_arr";
                                            $sql_nohn  .=  " GROUP BY n.plan_id  ";
                                            $query_nohn = $conn->query($sql_nohn);
                                            $result_nohn = $query_nohn->fetch_assoc();
                                            $count_arrange_nohn_id = $result_nohn['count_arrange_nohn_id'];
                                            echo "<B>".$count_arrange_nohn_id."</B>";
                                        }
                                    ?>
                                </td>







                                <td bgcolor="#FFE4C4" align="center">
                                 <?php 

                                  //echo $form_main_type;
                                    if($form_main_type == 1){

                                        $sql_detail =    " SELECT   o.order_id, o.student_id,    ";
                                        $sql_detail  .=  " d.detail_id, d.detail_score, d.detail_weight, d.detail_total, d.detail_date_last";
                                        $sql_detail  .=  " FROM ";
                                        $sql_detail  .=  " tbl_detail AS d ";
                                        $sql_detail  .=  " INNER JOIN tbl_order AS o ON o.order_id = d.order_id";
                                        $sql_detail  .=  " WHERE  o.student_id = '$student_id' and d.plan_id = $plan_id_arr ";
                                        //ไม่ได้อัพเดท วันที่ล่าสุด
                                        // $sql_detail  .=  " WHERE   d.detail_date_last IS NULL  and o.student_id = '$student_id' and d.plan_id = $plan_id_arr ";
                                        //$sql_detail  .=  " and (d.detail_complete = 1 or d.detail_date_complete!='0000-00-00') ";
                                        $sql_detail  .=  "ORDER BY d.detail_date_last DESC";
                                        $query_detail = $conn->query($sql_detail);
                                        while($result_detail = $query_detail->fetch_assoc()){

                                             $detail_date_last = $result_detail['detail_date_last'];
                                             $detail_score = $result_detail['detail_score'];
                                             $detail_weight = $result_detail['detail_weight'];
                                             $detail_total = $result_detail['detail_total'];
                                            echo $detail_id = $result_detail['detail_id'];


                                            $sql_last_date = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                            $sql_last_date  .=  " ORDER BY last_date DESC ";
                                            $query_last_date = $conn->query($sql_last_date);
                                            $row_last_date = $query_last_date->fetch_assoc();

                                            $last_date = $row_last_date['last_date']; 


                                            if ($type_work_id == 1) { // สาขา xray 
                                                include "summary_xray.php";
                                             }


                                             if ($type_work_id == 2) { // สาขา pedo
                                                include "summary_pedo.php";
                                             }

                                  
                                             if ($type_work_id == 4) { // สาขา pedo
                                                include "summary_oper.php";
                                             }

                                             if ($type_work_id == 5) { // สาขา endo 
                                                include "summary_endo.php";
                                             }

                                             if ($type_work_id == 6) { // สาขา opd 
                                                include "summary_cb.php";
                                             }

                                             if ($type_work_id == 10) { // สาขา Pedodontics 
                                                include "summary_od.php";
                                             }

                                             if ($type_work_id == 12) { // สาขา opd 
                                                include "summary_opd.php";
                                             }

                                        ?>

                                        

                                                <table style="width:100%">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>score</th>
                                                    <th>weight</th>
                                                    <th>total</th>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $detail_date_last; ?></td>
                                                    <td><?php echo $detail_score; ?></td>
                                                    <td><?php echo $detail_weight; ?></td>
                                                    <td><?php echo $detail_total; ?>  </td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $last_date; ?></td>
                                                    <td><?php echo $total_score; ?></td>
                                                    <td><?php echo $total_weight; ?></td>
                                                    <td><?php echo $sum_sw; ?></td>
                                                </tr>
                                                
                                                
                                                </table>
                                               
                                        <?php 
                                    
                                       



                                        if($total_score!=0){ //ไม่มีคะแนนค่าเป็น 0 
                                            echo "เปรียบเทียบ";

                                            if($detail_date_last != "$last_date"){ //วันที่ไม่ตรงกัน
                                                echo "<br>";
                                                echo $detail_date_last;
                                                echo " -XXXXX- ";
                                                echo $last_date;
                                                // อัพเดทสถานะ detail_date_last และ คะแนน
                                                $sql_update_complete = " UPDATE tbl_detail SET  ";
                                                $sql_update_complete .= " detail_date_last = '$last_date' ";
                                                $sql_update_complete .= " WHERE detail_id = $detail_id ";
                                                //$conn->query($sql_update_complete);
                                            }

                                            if($detail_score != "$total_score"){  //คะแนนไม่ตรงกัน
                                                echo "<br>";
                                                echo $detail_score;
                                                echo " -XXXXX- ";
                                                echo $total_score;
                                                // อัพเดทสถานะ detail_date_last และ คะแนน
                                                $sql_update_complete = " UPDATE tbl_detail SET  ";
                                                $sql_update_complete .= " detail_score = '$total_score', ";
                                                $sql_update_complete .= " detail_weight = '$total_weight', ";
                                                $sql_update_complete .= " detail_total = '$sum_sw', ";
                                                $sql_update_complete .= " detail_date_last = '$last_date' ";
                                                $sql_update_complete .= " WHERE detail_id = $detail_id ";
                                                //$conn->query($sql_update_complete);
                                            }

                                            if($detail_total != "$sum_sw"){  //คะแนนไม่ตรงกัน Total
                                                echo "<br> total";
                                                echo $detail_total;
                                                echo " -XXXXX- ";
                                                echo $sum_sw;
                                                // อัพเดทสถานะ detail_date_last และ คะแนน
                                                $sql_update_complete = " UPDATE tbl_detail SET  ";
                                                $sql_update_complete .= " detail_score = '$total_score', ";
                                                $sql_update_complete .= " detail_weight = '$total_weight', ";
                                                $sql_update_complete .= " detail_total = '$sum_sw', ";
                                                $sql_update_complete .= " detail_date_last = '$last_date' ";
                                                $sql_update_complete .= " WHERE detail_id = $detail_id ";
                                                //$conn->query($sql_update_complete);
                                            }

                                    
                                        }




                                    ?>
                                    <hr>
                                    <br>
                                          <?php
        
                                        } 
                                    
                                    
                                         ?>



                                    <?php

                                      

                                    }else{


                                        

                                    }
                                 ?>
                            
                            
                               </td>
                             

                            <?php
                            }
                            ?>
                        </tr>
                    <?php

                      
                    }
                    
                    $conn->close();
                    
                    ?>
                </tbody>



            </table>

        </div><!-- /.table-responsive -->






    </div><!-- /.card-body -->

</div><!-- /.card -->