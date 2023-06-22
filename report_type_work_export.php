<head>
  <meta charset="utf-8">
</head>

<style>
  .table-responsive {
    height: 500px;
    overflow: scroll;
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

  th,




  table,
  th,
  td {
    border: 1px solid black;
    border-collapse: collapse;
    border-style: dotted;
    padding: 10px;
  }
</style>



<?php
//ตัวแปรเงื่อนไขการค้นหา


if (isset($_GET['type_work_id'])) {
  $type_work_id = $_GET['type_work_id'];
} else {
  $type_work_id = 1;
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


<?php
	
  header("Content-Type: application/xls");
	header("Content-Disposition: attachment; filename=export_dashboard_". $level_search ."_". $type_work_id ."_.xls");
	header("Pragma: no-cache");
  header("Expires: 0");
  
?>




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
            <td>จำนวนฟิลม์ทั้งหมด</td>
            <td>จำนวนฟิลม์ที่ได้ Competency</td>
          <?php }  ?>
          <td>จำนวนงานทั้งหมด</td>
          <td>Complete </td>
          <td>Competency</td>
        <?php } else { ?>
          <td colspan="3">จำนวนงาน</td>
        <?php } ?>
      <?php } ?>
    </tr>


    <?php
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

        <td><?php echo $result_student['student_id']; ?></td>
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