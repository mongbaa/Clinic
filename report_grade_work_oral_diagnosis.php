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
        }else{
            $report_date_id = '';
        }




        if (isset($_GET['report_date_id'])) {


           $report_date_id = $_GET['report_date_id'];


           include "config.inc.php";	
           $sql_report_date="SELECT * FROM tbl_report_date  WHERE  report_date_id = $report_date_id ";	
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

<?php
if (isset($_GET['act'])) {
    if ($_GET['act'] == 'excel') {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=export_Oral_diagnosis.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}
?>



<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> Score By Work <?php echo $type_work_name; ?></h3>
    </div>

    <div class="card-body">

        <?PHP // ข้อมูล งานของแต่ละสาขา
        include "config.inc.php";

        $plan_array = array();
        $sql_plan = " SELECT p.* , t.* , f.*";
        $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p ";
        $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
        $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y') AS f  ON  f.form_main_id = p.form_main_id ";
        $sql_plan  .=  " ORDER BY p.plan_id ASC ";
        $query_plan = $conn->query($sql_plan);
        while ($result_plan = $query_plan->fetch_assoc()) {
            $plan_array[] = array(
                'plan_id' => $result_plan['plan_id'],
                'plan_name' => $result_plan['plan_name'],
                'form_main_type' => $result_plan['form_main_type']
            );
        }

        ?>

 
        <div class="table-responsive">


            <table id="example1" class="table table-hover" border="1">

                <thead>

                    <tr>
                        <th width="7%">รหัส</th>
                        <th width="20%">ชื่อ-สกุล</th>
                        <?PHP
                        foreach ($plan_array as $values => $data) {
                            $plan_id_arr =  $data['plan_id'];
                            $plan_name_arr =  $data['plan_name'];
                        ?>

                            <th colspan="3"><a href="report_grade_detail_work.php?plan_id=<?php echo $plan_id_arr; ?>&type_work_id=<?php echo $type_work_id; ?>&report_date_code=<?php echo $report_date_code;?>&date_start=<?php echo $date_start;?>&date_end=<?php echo $date_end;?>" target="_blank"><?php echo $plan_name_arr; ?> </a></th>

                        <?php } ?>

                        <th colspan="3">Total</th>

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
                            <th><a href="#" data-toggle="tooltip" title="Sum (Score)">S</a></th>
                            <th><a href="#" data-toggle="tooltip" title="Sum (Grade)">G</a></th>

                        <?php }  ?>

                        <th><a href="#" data-toggle="tooltip" title="Total (Count Work)">TC</a></th>
                        <th><a href="#" data-toggle="tooltip" title="Total (Sum (Total score))">TS</a></th>
                        <th><a href="#" data-toggle="tooltip" title="Total (Sum (Total Grade))">TG</a></th>

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
                        $sql_student   .=  " where student_id  like '$report_date_code%' and student_level != 7 ";
                        $sql_student  .=  " ORDER BY student_id ASC  ";
                    }

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

                            ?>

 

                                <td align="center">

                                    <?php if ($form_main_type == 1) { 
                                        
                                            // ข้อมูล ค้นหาคะแนน ของ นพท. / ต้องเป็นงานที่ complete
                                            $total_form_rei =  0;
                                            $total_score =  0;
                                            $total_weight =  0;
                                            $total_grade =  0;
        
                                            include "config.inc.php";
                                            $sql_detail =    " SELECT   o.order_id, o.student_id,    ";
                                            $sql_detail  .=  " COUNT(d.detail_id) as count_detail_id, ";
                                            $sql_detail  .=  " SUM(d.detail_score) as total_score, ";
                                            $sql_detail  .=  " SUM(d.detail_total) as total_grade, ";
                                            $sql_detail  .=  " SUM(d.detail_weight) as total_weight, ";
                                            $sql_detail  .=  " d.detail_id, d.detail_score, d.detail_weight, d.detail_total, d.detail_date_last";
                                            $sql_detail  .=  " FROM ";
                                            $sql_detail  .=  " tbl_detail AS d ";
                                            $sql_detail  .=  " INNER JOIN tbl_order AS o ON o.order_id = d.order_id";
                                            $sql_detail  .=  " WHERE o.student_id = '$student_id' and d.plan_id = $plan_id_arr ";
                                            $sql_detail  .=  " and (d.detail_complete = 1 ) ";
                                            $sql_detail  .=  " and (d.detail_date_last BETWEEN '$date_start' AND '$date_end') ";
                                            $query_detail = $conn->query($sql_detail);
                                            $result_detail = $query_detail->fetch_assoc();
        
                                            $count_detail_id = $result_detail['count_detail_id'];
                                            $total_score = $result_detail['total_score'];
                                            $total_weight = $result_detail['total_weight'];
                                            $total_grade = $result_detail['total_grade'];
        
                                            echo $count_detail_id;
        
                                        
        
                                        }else{
        
         
        
        
                                            $total_form_rei =  0;
                                            $total_score =  0;
                                            $total_weight =  0;
                                            $total_grade =  0;
        
                                            $num_rows_form_nohn = 0;
        
        
                                                $sql_nohn = " SELECT ";
                                                $sql_nohn  .=  " COUNT(n.arrange_nohn_id) as count_detail_id, ";
                                                $sql_nohn  .=  " SUM(n.sum_scores_nohn) as total_score, ";
                                                $sql_nohn  .=  " SUM(n.sum_grade_nohn) as total_grade, ";
                                                $sql_nohn  .=  " SUM(n.sum_weight_nohn) as total_weight ";
                                                $sql_nohn  .=  " FROM ";
                                                $sql_nohn  .=  " tbl_arrange_nohn as n ";
                                                $sql_nohn  .=  " WHERE n.plan_id = $plan_id_arr and n.arrange_nohn_check_eval = 1 and n.student_id = $student_id";
                                                $sql_nohn  .=  " and n.arrange_nohn_date BETWEEN '$date_start' AND '$date_end' ";
                                                $sql_nohn  .=  " ORDER BY n.arrange_nohn_id ASC ";
                                                $query_nohn = $conn->query($sql_nohn);
                                                $result_nohn = $query_nohn->fetch_assoc();
        
                                                $count_detail_id = $result_nohn['count_detail_id'];
                                                $total_score = $result_nohn['total_score'];
                                                $total_weight = $result_nohn['total_weight'];
                                                $total_grade = $result_nohn['total_grade'];

        
                                              echo $count_detail_id;
        
                                  
        
                                        }
                                        
                                    ?>



                                 



                                </td>


                                <td bgcolor="#FFE4C4" align="center"><?php echo round($total_score, 2); ?></td>
                                <td bgcolor="#FFE4C4" align="center"><?php echo round($total_grade, 2); ?></td>



                            <?php
                                $total_form_rei_sum = $total_form_rei_sum + $total_form_rei;
                                $total_score_sum = $total_score_sum + $total_score;
                                $total_grade_sum = $total_grade_sum + $total_grade;
                            }
                            ?>

                            <td><?php echo $total_form_rei_sum; ?></td>
                            <td><?php echo round($total_score_sum, 2); ?></td>
                            <td><?php echo round($total_grade_sum, 2); ?></td>

                        </tr>
                    <?php

                        $total_form_rei =  0;
                        $total_score =  0;
                        $total_weight =  0;
                        $total_grade =  0;

                        $total_form_rei_sum =  0;
                        $total_score_sum = 0;
                        $total_weight_sum = 0;
                        $total_grade_sum = 0;
                    } ?>
                </tbody>



            </table>

        </div><!-- /.table-responsive -->






    </div><!-- /.card-body -->

</div><!-- /.card -->