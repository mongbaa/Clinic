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
                $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y' and form_main_type = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
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


                                    <th colspan="3"><?php echo $plan_name_arr; ?></h6>
                                    </th>


                                <?php } ?>
                                <th colspan="4">Total</th>
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
                                    <th><a href="#" data-toggle="tooltip" title="Sum (weight * grade)">S</a></th>
                                    <!--<th><a href="#" data-toggle="tooltip" title="Weight">W</a></th>-->
                                    <!--<th><a href="#" data-toggle="tooltip" title="Total">T</a></th>-->
                                    <th><a href="#" data-toggle="tooltip" title="Avg grade">AG</a></th>

                                <?php } ?>



                                <th><a href="#" data-toggle="tooltip" title="Total (Count Work)">C</a></th>
                                <th><a href="#" data-toggle="tooltip" title="Total (Sum (weight * grade))">S</a></th>
                                <!-- <th><a href="#" data-toggle="tooltip" title="Weight">W</a></th>-->
                                <!-- <th><a href="#" data-toggle="tooltip" title="Total">T</a></th>-->
                                <th><a href="#" data-toggle="tooltip" title="Total (Avg grade)">AG</a></th>
                                <th><a href="#" data-toggle="tooltip" title="Performance Precent">PP</a></th>


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

                                            @$total_ag = $total_total / $total_form_rei;
                                            ?>
                                        </td>


                                        <td bgcolor="#FFE4C4" align="center"><?php echo $total_score; ?></td>
                                        <!--  <td bgcolor="#F5F5DC" align="center"><?php echo $total_weight; ?></td> -->
                                        <!--  <td bgcolor="#DEB887" align="center"><?php echo $total_total; ?></td> -->
                                        <td bgcolor="#DEB887" align="center"><?php echo round($total_ag, 2); ?></td>




                                    <?php
                                        $total_form_rei_sum = $total_form_rei_sum + $total_form_rei;
                                        $total_score_sum = $total_score_sum + $total_score;
                                        $total_weight_sum = $total_weight_sum + $total_weight;
                                        $total_total_sum = $total_total_sum + $total_total;
                                        $total_ag_total_sum = $total_ag_total_sum + $total_ag;
                                    }

                                    if ($total_form_rei_sum != 0) {
                                        $bgcolori = "#BBFFFF";
                                    } else {
                                        $bgcolori = "#E0FFFF";
                                    }
                                    if ($total_score_sum != 0) {
                                        $bgcolors = "#BBFFFF";
                                    } else {
                                        $bgcolors = "#E0FFFF";
                                    }
                                    if ($total_weight_sum != 0) {
                                        $bgcolorw = "#BBFFFF";
                                    } else {
                                        $bgcolorw = "#E0FFFF";
                                    }
                                    if ($total_total_sum != 0) {
                                        $bgcolort = "#BBFFFF";
                                    } else {
                                        $bgcolort = "#E0FFFF";
                                    }
                                    ?>


                                    <td bgcolor="<?php echo $bgcolori; ?>" align="center"><?php echo $total_form_rei_sum; ?></td>
                                    <td bgcolor="<?php echo $bgcolors; ?>" align="center"><?php echo $total_score_sum; ?></td>
                                    <!-- <td bgcolor="<?php echo $bgcolorw; ?>" align="center"><?php echo $total_weight_sum; ?></td>-->
                                    <td bgcolor="<?php echo $bgcolort; ?>" align="center">
                                        <?php
                                        @$total_ag_sum = $total_total_sum / $total_form_rei_sum;

                                        echo round($total_ag_sum, 2);

                                        ?></td>



                                    <td bgcolor="<?php echo $bgcolort; ?>" align="center">
                                        <?php
                                        $total_pp = $total_score_sum * 3.2;
                                        echo round($total_pp, 2);
                                        ?>
                                    </td>





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