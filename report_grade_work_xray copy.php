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


           echo  $report_date_id = $_GET['report_date_id'];


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
if(isset($_GET['act'])){
	if($_GET['act']== 'excel'){
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=export_$type_work_name.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
}
?>


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
        $sql_plan  .=  " ORDER BY p.plan_id ASC ";
        $query_plan = $conn->query($sql_plan);
        while ($result_plan = $query_plan->fetch_assoc()) {
            $plan_array[] = array(
                'plan_id' => $result_plan['plan_id'],
                'plan_name' => $result_plan['plan_name']
            );
        }

        ?>


        <div class="table-responsive">
        <table id="example1" class="table table-hover" border = "1">
                <thead>



                    <tr>
                        <th Width="7%">รหัส</th>
                        <th Width="20%">ชื่อ-สกุล</th>
                            <?PHP
                            foreach ($plan_array as $values => $data) {
                                $plan_id_arr =  $data['plan_id'];
                                $plan_name_arr =  $data['plan_name'];
                            ?>
                                <th colspan="2"><?php echo $plan_name_arr; ?></th>
                            <?php } ?>

                        <th colspan="2">Total</th>
                    </tr>


                    <tr>
                        <th Width="7%">รหัส</th>
                        <th Width="20%">ชื่อ-สกุล</th>

                        <?PHP
                        foreach ($plan_array as $values => $data) {
                            $plan_id_arr =  $data['plan_id'];
                            $plan_name_arr =  $data['plan_name'];
                        ?>


                            <th><a href="#" data-toggle="tooltip" title="Count Work">C</a></th>
                            <th><a href="#" data-toggle="tooltip" title="Sum (score * film)">T</a></th>



                        <?php }  ?>



                        <th><a href="#" data-toggle="tooltip" title="Total (Count Work)">C</a></th>
                        <th><a href="#" data-toggle="tooltip" title="Total (Sum (score * film))">T</a></th>


                    </tr>




                </thead>


                <tbody>

                    <?php
                    $total_form_rei_sum  = 0;
                    $total_score_sum = 0;
                    $total_weight_sum = 0;
                    $total_total_sum = 0;
                    $total_ag =  0;
                    $total_ag_total_sum =  0;

                    

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
                    //echo $sql_student; 

                    $query_student = $conn->query($sql_student);
                    while ($result_student = $query_student->fetch_assoc()) {
                        $i++;
                        $student_id = $result_student['student_id'];
                    ?>
                        <tr>
                            <td> <?php echo $result_student['student_id']; ?></td>
                            <td><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></td>

                            <?PHP
                            foreach ($plan_array as $values => $data) {
                                $plan_id_arr =  $data['plan_id'];
                                $plan_name_arr =  $data['plan_name'];
                            ?>



                                <td align="center">
                                    <?php
                                    


                                    
                                    // ข้อมูล ค้นหาคะแนน ของ นพท. / ต้องเป็นงานที่ complete
                                    $total_form_rei =  0;
                                    $total_score =  0;
                                    $total_weight =  0;
                                    $total_total =  0;
                                    $total_ag =  0;

                                    /*
                                    include "config.inc.php";
                                    $sql_detail = " SELECT o.*, d.*, p.* , t.* , f.* FROM";
                                    $sql_detail  .=  " (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                                    $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail  WHERE detail_complete = 1 or detail_date_complete!='0000-00-00'  ) AS d  ON  d.order_id = o.order_id ";
                                    $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE plan_id = $plan_id_arr  ) as p  ON  p.plan_id = d.plan_id";
                                    $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                                    $sql_detail  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
                                    $sql_detail  .=  " ORDER BY d.detail_id ASC ";
                                    $query_detail = $conn->query($sql_detail);
                                    //echo $num_rows = $query_detail->num_rows;
                                    //echo "<br>";
                                    while ($result_detail = $query_detail->fetch_assoc()) {

                                        $tbl = $result_detail['form_main_table']; // ชื่อตาราง
                                        $tbl_id = $tbl . "_id"; // Id ของตาราง
                                        $detail_id = $result_detail['detail_id']; //รหัสงาน
                                        $form_main_id = $result_detail['form_main_id']; //รหัสฟอร์ม


                                        // ข้อมูล ค้นหาคะแนน ของ นพท. ในช่วงวันที่เลือก
                                        $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id and (last_date BETWEEN '$date_start' AND '$date_end') GROUP BY detail_id DESC";
                                        $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                        $query_form_re = $conn->query($sql_form_re);
                                        $num_rows_form_re = $query_form_re->num_rows;
                                        if ($row_form_re = $query_form_re->fetch_assoc()) {

                                            $form_rei = 1; // นับจำนวนงาน
                                            $last_date = $row_form_re['last_date'];
                                            $detail_score = $result_detail['detail_score']; //คะแนนรวม
                                            $detail_weight = $result_detail['detail_weight']; //น้ำหนักรวม
                                            $detail_total = $result_detail['detail_total']; //คะแนนรวม / น้ำหนักรวม

                                        } else {

                                            $form_rei = 0;
                                            $last_date = "";
                                            $detail_score = 0;
                                            $detail_weight = 0;
                                            $detail_total = 0;
                                        }

                                        //  echo $detail_total;
                                        //  echo "<br>";
                                        // echo $last_date;

                                        $total_form_rei = $total_form_rei + $form_rei; // รวมจำนวนงาน
                                        $total_score = $total_score + $detail_score; // รวมคะแนน
                                        $total_weight = $total_weight + $detail_weight; // รวมคะแนน
                                        $total_total = $total_total + $detail_total; // รวมคะแนน
                                    }
                                    //echo "<br>";
                                    echo $total_form_rei;
                                    echo " / ";
                                    */


                                   

                                    include "config.inc.php";
                                    $sql_detail_s =    " SELECT   o.order_id, o.student_id,    ";
                                    $sql_detail_s  .=  " COUNT(d.detail_id) as count_detail_id, ";
                                    $sql_detail_s  .=  " SUM(d.detail_score) as total_score, ";
                                    $sql_detail_s  .=  " SUM(d.detail_total) as total_grade, ";
                                    $sql_detail_s  .=  " SUM(d.detail_weight) as total_weight, ";
                                    $sql_detail_s  .=  " d.detail_id, d.detail_score, d.detail_weight, d.detail_total, d.detail_date_last";
                                    $sql_detail_s  .=  " FROM ";
                                    $sql_detail_s  .=  " tbl_detail AS d ";
                                    $sql_detail_s  .=  " INNER JOIN tbl_order AS o ON o.order_id = d.order_id";
                                    $sql_detail_s  .=  " WHERE o.student_id = '$student_id' and d.plan_id = $plan_id_arr ";
                                    $sql_detail_s  .=  " and (d.detail_date_last BETWEEN '$date_start' AND '$date_end') ";
                                    $query_detail_s = $conn->query($sql_detail_s);
                                    $result_detail_s = $query_detail_s->fetch_assoc();
                                    $count_detail_id_s = $result_detail_s['count_detail_id'];
                                    $total_score_s = $result_detail_s['total_score'];
                                    $total_weight_s = $result_detail_s['total_weight'];
                                    $total_grade_s = $result_detail_s['total_grade'];

                                    echo $count_detail_id_s;







                                    @$total_ag = $total_total / $total_form_rei;
                                    ?>
                                </td>


                                <!--<td bgcolor="#FFE4C4" align="center"><?php echo round($total_score,2); ?></td>-->
                                <td bgcolor="#FFE4C4" align="center">
                                <?php //echo round($total_total,2); ?> 
                                <?php echo round($total_grade_s,2); ?>
                               </td>



                            <?php
                                $total_form_rei_sum = $total_form_rei_sum + $count_detail_id_s;
                               // $total_form_rei_sum = $total_form_rei_sum + $total_form_rei;
                                $total_score_sum = $total_score_sum + $total_score;
                                $total_total_sum = $total_total_sum + $total_grade_s;
                            } ?>

                            <td><?php echo round($total_form_rei_sum,2); ?></td>
                            <td><?php echo round($total_total_sum,2); ?></td>
                        </tr>
                    <?php

                        $total_form_rei =  0;
                        $total_score =  0;
                        $total_weight =  0;
                        $total_total =  0;

                        $total_form_rei_sum =  0;
                        $total_score_sum = 0;
                        $total_weight_sum = 0;
                        $total_total_sum = 0;
                    } ?>
                </tbody>



            </table>

        </div><!-- /.table-responsive -->






    </div><!-- /.card-body -->

</div><!-- /.card -->