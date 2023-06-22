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


<?PHP
if (isset($_GET['type_work_id'])) {

  include "config.inc.php";
  $type_work_id = $_GET['type_work_id'];
  $sql_type_work = "SELECT * FROM tbl_type_work  where type_work_id = $type_work_id ";
  $query_type_work = $conn->query($sql_type_work);
  $result_type_work  = $query_type_work->fetch_assoc();
  $type_work_id = $result_type_work['type_work_id'];
  $type_work_name = $result_type_work['type_work_name'];

  $conn->close();
} else {
  $type_work_name = "";
  $type_work_id = "";
}
?>




<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1> Dashboard <?php echo $type_work_name; ?></h1>
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


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
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

      $conn->close();
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
                <?php }
                $conn->close();
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
        <font color="red">*** เลือกช่วงวันที่ และ กดยืนยันอีกครั้ง เพื่อดึงข้อมูล </font>
      </div><!-- /.card-body -->
    </div><!-- /.card -->











    <style>
      .table-responsive {
        height: 480px;
        overflow: scroll;
      }

      thead tr:nth-child(1) th {
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
      }

      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      td,
      th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
      }

      th {
        background-color: #dddddd;
        color: black;
      }

      th:first-child,


      td:first-child {
        position: sticky;
        left: 0px;
      }

      td:first-child {
        background-color: whitesmoke;
        color: white;
      }
    </style>




    <div class="card card-default color-palette-box">
      <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> Report </h3>
      </div>

      <div class="card-body">

        <?PHP // ข้อมูล งานของแต่ละสาขา
        include "config.inc.php";

        $plan_array = array();

        $sql_plan = " SELECT p.* , t.* , f.*";
        $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p ";
        $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
        $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
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




        <a href="report_type_work_export.php?type_work_id=<?php echo $type_work_id; ?>&report_date_id=<?php echo $report_date_id; ?>" target="_blank" class="btn btn-info mb-3"> Export </a>


        <div class="table-responsive">
          <table id="example1" class="table table-bordered">
            <thead>
              <tr>
                <th Width="7%">รหัส</th>
                <th Width="15%">ชื่อ-สกุล</th>
                <?PHP
                foreach ($plan_array as $values => $data) {
                  $plan_id_arr =  $data['plan_id'];
                  $plan_name_arr =  $data['plan_name'];
                ?>
                  <?php if ($type_work_id == 1) { // สาขา X-ray ดึง จำนวนฟิมล์มาแสดงด้วย   
                  ?>

                    <th align="center" colspan="5"><?php echo $plan_name_arr; ?></th>

                  <?php } else { ?>

                    <th align="center" colspan="3"><?php echo $plan_name_arr; ?></th>

                  <?php } ?>

                <?php } ?>
              </tr>


            </thead>

            <tbody>




              <tr>

                <td Width="7%"></td>
                <td Width="15%"></td>
                <?PHP
                foreach ($plan_array as $values => $data) {
                  $plan_id_arr =  $data['plan_id'];
                  $plan_name_arr =  $data['plan_name'];
                  $form_main_type =  $data['form_main_type'];
                ?>

                  <?php if ($form_main_type == 1) { ?>

                    <?php if ($type_work_id == 1) { // สาขา X-ray ดึง จำนวนฟิมล์มาแสดงด้วย   
                    ?>
                      <td><a href="#" data-toggle="tooltip" title="จำนวนฟิลม์ทั้งหมด">F</a></td>
                      <td><a href="#" data-toggle="tooltip" title="จำนวนฟิลม์ที่ได้ Competency">FC</a></td>
                    <?php }  ?>

                    <td><a href="#" data-toggle="tooltip" title="จำนวนงานทั้งหมด">T</a></td>
                    <td><a href="#" data-toggle="tooltip" title="Complete">CP</a></td>
                    <td><a href="#" data-toggle="tooltip" title="Competency">CY</a></td>

                  <?php } else { ?>

                    <td colspan="3"><a href="#" data-toggle="tooltip" title="จำนวนงานทั้งหมด">จำนวนงาน</a></td>

                  <?php } ?>


                <?php } ?>
              </tr>


              <?php
              include "config.inc.php";
              $i = 0;
              $sql_student   =  " SELECT *FROM  tbl_student ";

              /*
              if ($level_search == "all") {
                $sql_student   .=  " where student_active = 1 ";
                $sql_student  .=  " ORDER BY student_id ASC   ";
              } else if ($student_search != "") {
                $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' or student_group like '%$student_search%' and student_active = 1 ";
                $sql_student  .=  " ORDER BY student_id ASC  ";
              } else {
                $sql_student   .=  " where student_level=$level_search and student_active = 1";
                $sql_student  .=  " ORDER BY student_id ASC  ";
              }*/


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

                  <td> <a href="report_student.php?type_work_id=<?php echo $type_work_id; ?>&student_id=<?php echo $result_student['student_id']; ?>" target="_blank"><?php echo $result_student['student_id']; ?></a></td>
                  <td>
                    <?php echo $result_student['student_name']; ?>
                    <?php echo $result_student['student_lastname']; ?>
                  </td>
                  
                  <?PHP
                  foreach ($plan_array as $values => $data) {
                    $plan_id_arr =  $data['plan_id'];
                    $plan_name_arr =  $data['plan_name'];
                    $form_main_type =  $data['form_main_type'];
                  ?>



                    <?php if ($form_main_type == 1) { ?>

                      <?php if ($type_work_id == 1) { // สาขา X-ray ดึง จำนวนฟิมล์มาแสดงด้วย  
                        // ดึงข้อมูล จำนวนฟิมล์ ของการประเมินในครั้งนี้ 
                        $sql_f = " SELECT  SUM(f.arrange_detail) as count_arrange_detail ";

                        // $sql_f  .=  " FROM (SELECT * FROM tbl_detail WHERE plan_id = $plan_id_arr) as d ";
                        // $sql_f  .=  " INNER JOIN  (SELECT * FROM  tbl_order    WHERE student_id = $student_id) as o  ON  o.order_id = d.order_id ";
                        //  $sql_f  .=  " INNER JOIN  (SELECT * FROM  tbl_arrange  WHERE arrange_check_eval = 1)   as f  ON  f.detail_id = d.detail_id ";

                        $sql_f  .=  " FROM  tbl_detail  as d ";
                        $sql_f  .=  " INNER JOIN  tbl_order      as o  ON  o.order_id = d.order_id ";
                        $sql_f  .=  " INNER JOIN  tbl_arrange    as f  ON  f.detail_id = d.detail_id ";
                        $sql_f  .=  " WHERE d.plan_id = $plan_id_arr   and (d.detail_date_last BETWEEN '$date_start' AND '$date_end')  ";
                        $sql_f  .=  " and o.student_id = '$student_id' and f.arrange_check_eval = 1 ";
                        $query_f = $conn->query($sql_f);
                        if ($row_f = $query_f->fetch_assoc()) {

                          $film = $row_f['count_arrange_detail'];
                        } else {

                          $film = 0;
                        }


                        $sql_fc = " SELECT  SUM(f.arrange_detail) as count_arrange_detail ";
                        $sql_fc  .=  " FROM  tbl_detail  as d ";
                        $sql_fc  .=  " INNER JOIN  tbl_order      as o  ON  o.order_id = d.order_id ";
                        $sql_fc  .=  " INNER JOIN  tbl_arrange    as f  ON  f.detail_id = d.detail_id ";
                        $sql_fc  .=  " WHERE d.plan_id = $plan_id_arr  and d.detail_competency = 1 and (d.detail_date_last BETWEEN '$date_start' AND '$date_end')  ";
                        $sql_fc  .=  " and o.student_id = '$student_id' and f.arrange_check_eval = 1 ";

                        $query_fc = $conn->query($sql_fc);
                        if ($row_fc = $query_fc->fetch_assoc()) {

                          $film_c = $row_fc['count_arrange_detail'];
                        } else {

                          $film_c = 0;
                        }

                      ?>

                        <td><?php echo $film; ?> </td>
                        <td><?php echo $film_c; ?> </td>

                      <?php }  ?>






                      <td align="center">
                        <?php
                        $student_id = $result_student['student_id'];
                        $plan_id = $plan_id_arr;
                        $sql_detail = " SELECT  count(d.detail_id) as count_detail_id ";
                        $sql_detail  .=  " FROM  tbl_detail  as d ";
                        $sql_detail  .=  " INNER JOIN tbl_order as o  ON  o.order_id = d.order_id ";
                        $sql_detail  .=  " WHERE o.student_id = '$student_id' and d.plan_id = $plan_id ";
                        $sql_detail  .=  " and (d.detail_date_last BETWEEN '$date_start' AND '$date_end') ";
                        $sql_detail  .=  " ORDER BY d.detail_id ASC ";
                        $query_detail = $conn->query($sql_detail);
                        $result_detail = $query_detail->fetch_assoc();
                        echo $result_detail['count_detail_id'];
                        ?>

                      </td>

                      <td align="center">





                        <?php
                        /*

                        $sql_detail_com = " SELECT  count(d.detail_id) as count_detail_id ";
                        $sql_detail_com  .=  " FROM (SELECT * FROM tbl_detail WHERE plan_id = $plan_id ) as d ";
                        $sql_detail_com  .=  " INNER JOIN  (SELECT * FROM  tbl_order  WHERE student_id = '$student_id') as o  ON  o.order_id = d.order_id ";
                        $sql_detail_com  .=  " WHERE d.detail_complete = 1 and d.detail_date_complete!='0000-00-00' and (d.detail_date_last BETWEEN '$date_start' AND '$date_end')";
                        $sql_detail_com  .=  " ORDER BY d.detail_id ASC ";
                        $query_detail_com = $conn->query($sql_detail_com);
                        $result_detail_com = $query_detail_com->fetch_assoc();
                        echo $result_detail_com['count_detail_id'];
*/



                        $sql_detail =    " SELECT   o.order_id, o.student_id,    ";
                        $sql_detail  .=  " COUNT(d.detail_id) as count_detail_id, ";
                        $sql_detail  .=  " d.detail_id, d.detail_score, d.detail_weight, d.detail_total, d.detail_date_last";
                        $sql_detail  .=  " FROM ";
                        $sql_detail  .=  " tbl_detail AS d ";
                        $sql_detail  .=  " INNER JOIN tbl_order AS o ON o.order_id = d.order_id";
                        $sql_detail  .=  " WHERE o.student_id = '$student_id' and d.plan_id = $plan_id ";
                        $sql_detail  .=  " and (d.detail_complete = 1) ";
                        $sql_detail  .=  " and (d.detail_date_complete BETWEEN '$date_start' AND '$date_end') ";
                        $query_detail = $conn->query($sql_detail);
                        $result_detail = $query_detail->fetch_assoc();
                        $count_detail_id = $result_detail['count_detail_id'];

                        echo $count_detail_id;


                        ?>

                      </td>


                      <td align="center">
                        <?php

                        /*
                        $sql_detail_com = " SELECT  count(d.detail_id) as count_detail_id ";
                        $sql_detail_com  .=  " FROM (SELECT * FROM tbl_detail WHERE plan_id = $plan_id and detail_competency = 1) as d ";
                        $sql_detail_com  .=  " INNER JOIN  (SELECT * FROM  tbl_order  WHERE student_id = $student_id) as o  ON  o.order_id = d.order_id ";
                        $sql_detail_com  .=  " WHERE d.detail_date_last BETWEEN '$date_start' AND '$date_end' ";
                        $sql_detail_com  .=  " ORDER BY d.detail_id ASC ";
                        $query_detail_com = $conn->query($sql_detail_com);
                        $result_detail_com = $query_detail_com->fetch_assoc();
                        echo $result_detail_com['count_detail_id'];
                        */



                        $sql_detail =    " SELECT   o.order_id, o.student_id,    ";
                        $sql_detail  .=  " COUNT(d.detail_id) as count_detail_id, ";
                        $sql_detail  .=  " d.detail_id, d.detail_score, d.detail_weight, d.detail_total, d.detail_date_last";
                        $sql_detail  .=  " FROM ";
                        $sql_detail  .=  " tbl_detail AS d ";
                        $sql_detail  .=  " INNER JOIN tbl_order AS o ON o.order_id = d.order_id";
                        $sql_detail  .=  " WHERE o.student_id = '$student_id' and d.plan_id = $plan_id_arr ";
                        $sql_detail  .=  " and d.detail_competency = 1 ";
                        $sql_detail  .=  " and (d.detail_date_last BETWEEN '$date_start' AND '$date_end') ";
                        $query_detail = $conn->query($sql_detail);
                        $result_detail = $query_detail->fetch_assoc();
                        $count_detail_id = $result_detail['count_detail_id'];

                        echo $count_detail_id;

                        ?>
                      </td>


                    <?php } else { ?>






                      <td colspan="3">


                        <?php
                        $student_id = $result_student['student_id'];
                        $plan_id = $plan_id_arr;



                        /*
                        $sql_nohn = " SELECT count(n.arrange_nohn_id) as count_arrange_nohn_id FROM";
                        $sql_nohn  .=  " (SELECT * FROM tbl_arrange_nohn WHERE plan_id = $plan_id and arrange_nohn_check_eval = 1 and student_id = $student_id) as n ";
                        $sql_nohn  .=  " ORDER BY n.arrange_nohn_id ASC ";
                        $sql_nohn  .=  " ORDER BY n.arrange_nohn_id ASC ";
                        $query_nohn = $conn->query($sql_nohn);
                        $result_nohn = $query_nohn->fetch_assoc();
                        echo $result_nohn['count_arrange_nohn_id'];
                        */


                        $sql_nohn = " SELECT ";
                        $sql_nohn  .=  " COUNT(n.arrange_nohn_id) as count_detail_id, ";
                        $sql_nohn  .=  " SUM(n.sum_scores_nohn) as total_score, ";
                        $sql_nohn  .=  " SUM(n.sum_grade_nohn) as total_grade, ";
                        $sql_nohn  .=  " SUM(n.sum_weight_nohn) as total_weight ";
                        $sql_nohn  .=  " FROM ";
                        $sql_nohn  .=  " tbl_arrange_nohn as n ";
                        $sql_nohn  .=  " WHERE n.plan_id = $plan_id and n.arrange_nohn_check_eval = 1 and n.student_id = $student_id";
                        $sql_nohn  .=  " and n.arrange_nohn_date BETWEEN '$date_start' AND '$date_end' ";
                        $sql_nohn  .=  " ORDER BY n.arrange_nohn_id ASC ";
                        $query_nohn = $conn->query($sql_nohn);
                        $result_nohn = $query_nohn->fetch_assoc();

                        $count_detail_id = $result_nohn['count_detail_id'];
                        $total_score = $result_nohn['total_score'];
                        $total_weight = $result_nohn['total_weight'];
                        $total_grade = $result_nohn['total_grade'];


                        echo $count_detail_id;


                        ?>



                      </td>






                    <?php } ?>



                  <?php } ?>

                </tr>


              <?php } ?>

            </tbody>
          </table>

        </div>
      </div><!-- /.card-body -->

    </div><!-- /.card -->




  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php $conn->close(); ?>

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
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "ordering": true,
      "paging": true,
      "pageLength": 5,
      "lengthChange": true,
      //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
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