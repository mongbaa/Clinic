<?php include "header.php"; ?>
<?php
if (isset($_SESSION['sessid']) && !empty($_SESSION['level_user'])) {
} else {
  echo "<script type='text/javascript'>";
  echo  "alert('เช้าสู่ระบบก่อนใช้งาน....!');";
  echo "window.location='login.php'";
  echo "</script>";
}
?> 

<?php
function set_format_date($rub)
{
  if (!empty($rub)) {
    list($yyy, $mmm, $ddd) = explode("-", $rub);
    $new_date = $ddd . "-" . $mmm . "-" . $yyy;
    return $new_date;
  }
}
?>

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
if (!empty($_SESSION['student'])) {
  $student_id = $_SESSION['username'];
} else {
  $student_id = $_GET['student_id'];
}

if (isset($_GET['type_work_id'])) {


  include "config.inc.php";
  $type_work_id = $_GET['type_work_id'];
  $sql_type_work = "SELECT * FROM tbl_type_work  where type_work_id = $type_work_id ";
  $query_type_work = $conn->query($sql_type_work);
  $result_type_work  = $query_type_work->fetch_assoc();

  $type_work_id = $result_type_work['type_work_id'];
  $type_work_name = $result_type_work['type_work_name'];


  $sql_student   =  " SELECT *FROM  tbl_student where student_id = $student_id";
  $sql_student  .=  " ORDER BY student_id ASC   ";
  $query_student = $conn->query($sql_student);
  $result_student = $query_student->fetch_assoc();


  $student_id = $result_student['student_id'];
  $student_name = $result_student['student_name'];
  $student_lastname = $result_student['student_lastname'];
  $student_level = $result_student['student_level'];
  $student_group = $result_student['student_group'];


  $conn->close();
} else {

  $type_work_name = "";
  $type_work_id = "";

  $student_id = "";
  $student_name = "";
  $student_lastname = "";
  $student_level = "";
  $student_group = "";
}




if (isset($_GET['detail_type_work_id'])) {

  $detail_type_work_id = $_GET['detail_type_work_id'];
} else {

  $detail_type_work_id = $type_work_id;
}




?>



<section class="content-header">
  <div class="container-fluid">

    <div class="row mb-2">

      <div class="col-sm-8">
        <h1> Report <?php echo $type_work_name; ?> > <?php echo $student_id; ?> : <?php echo $student_name; ?> <?php echo $student_lastname; ?> ชั้นปี <?php echo $student_level; ?></h1>
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

    <div class="row">


      <div class="col-md-6">
        <div class="form-group">
          <label> เลือกสาขาที่ประเมิน </label>
          <form name="myForm1" id="myForm1" action="" method="GET">
            <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
            <select name="detail_type_work_id" id="detail_type_work_id" class="form-control select2" onchange="this.form.submit()" required>
              <option value="0"> ทุกสาขา </option>
              <?php
              include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
              $sql_type_work = "SELECT * FROM tbl_type_work";
              $query_type_work = $conn->query($sql_type_work);
              while ($result_type_work = $query_type_work->fetch_assoc()) {
              ?>
                <option value="<?php echo $result_type_work['type_work_id']; ?>" <?php if (!(strcmp($result_type_work['type_work_id'], $detail_type_work_id))) {
                                                                                    echo "selected=\"selected\"";
                                                                                  } ?>>
                  <?php echo $result_type_work['type_work_name']; ?>
                </option>
              <?php
              }
              $conn->close();
              ?>
            </select>
          </form>
        </div>
      </div>


      <div class="col-12 col-sm-12 col-lg-12">
        <div class="card card-info card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-index-tab" data-toggle="pill" href="#custom-tabs-one-index" role="tab" aria-controls="custom-tabs-one-index" aria-selected="true">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-holistic-tab" data-toggle="pill" href="#custom-tabs-one-holistic" role="tab" aria-controls="custom-tabs-one-holistic" aria-selected="false">Holistic</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " id="custom-tabs-one-conduct-tab" data-toggle="pill" href="#custom-tabs-one-conduct" role="tab" aria-controls="custom-tabs-one-conduct" aria-selected="true">Conduct</a>
              </li>

              <?PHP // ข้อมูลงานที่มีในสาขาที่ส่งค่ามา
              $plan_array = array();
              $plan_array_index = array();

              if ($detail_type_work_id == 0) {
                $detail_work_id = "";
              } else {
                $detail_work_id = " WHERE detail_type_work_id = '$detail_type_work_id' ";
              }

              include "config.inc.php";
              $sql_plan = " SELECT o.*, d.*, COUNT( d.detail_id ) AS count_detail, p.*, t.*, f.* ";
              //  $sql_plan = " SELECT o.*, d.*, p.* , t.* , f.*";
              $sql_plan  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
              $sql_plan  .=  " INNER JOIN (SELECT detail_id, order_id, plan_id, detail_type_work_id  FROM tbl_detail $detail_work_id) as d  ON  d.order_id = o.order_id";
              $sql_plan  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = d.plan_id";
              $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
              //  $sql_plan  .=  " INNER JOIN (SELECT COUNT( detail_id ) AS count_detail, order_id, plan_id FROM tbl_detail $detail_work_id  group by plan_id) as d  ON  d.order_id = o.order_id";
              //  $sql_plan  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p  ON  p.plan_id = d.plan_id";
              // $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
              $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
              // $sql_plan  .=  " ORDER BY f.form_main_id ASC ";
              $sql_plan  .=  " group by d.plan_id ";
              //echo   $sql_plan;

              $query_plan = $conn->query($sql_plan);
              while ($result_plan = $query_plan->fetch_assoc()) {

                $plan_name = $result_plan['plan_name']; // ID งาน
                $plan_id = $result_plan['plan_id']; // ID งาน


                $plan_array_index[] = array(
                  'plan_id' => $result_plan['plan_id'],
                  'plan_name' => $result_plan['plan_name'],
                  'count_detail' => $result_plan['count_detail']
                );


                $plan_array[] = $plan_id;

              ?>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-<?php echo $plan_id; ?>-tab" data-toggle="pill" href="#custom-tabs-one-<?php echo $plan_id; ?>" role="tab" aria-controls="custom-tabs-one-<?php echo $plan_id; ?>" aria-selected="false"><?php echo $result_plan['plan_name']; ?> <span class="badge badge-danger"><?php echo $result_plan['count_detail']; ?></span> </a>
                </li>
              <?php } ?>











              <?PHP // ข้อมูลงานไม่มีผู้ป่วย
              $plan_array_nohn = array();
              include "config.inc.php";

              $sql_nohn = " SELECT count(n.arrange_nohn_id) as count_arrange_nohn_id, p.plan_id, p.plan_name FROM";
              $sql_nohn  .=  " (SELECT * FROM tbl_arrange_nohn WHERE student_id = $student_id ) as n ";
              $sql_nohn  .=  " INNER JOIN  (SELECT * FROM  tbl_plan  WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = n.plan_id ";
              $sql_nohn  .=  " GROUP BY n.plan_id ASC ";
              $query_nohn = $conn->query($sql_nohn);
              while ($result_nohn = $query_nohn->fetch_assoc()) {

                $plan_array_nohn[] = array(
                  'plan_id' => $result_nohn['plan_id'],
                  'plan_name' => $result_nohn['plan_name'],
                  'count_detail' => $result_nohn['count_arrange_nohn_id']
                );

                $plan_name = $result_nohn['plan_name']; // ID งาน
                $plan_id = $result_nohn['plan_id']; // ID งาน
                $count_detail = $result_nohn['count_arrange_nohn_id']

              ?>


                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-nohn-<?php echo $plan_id; ?>-tab" data-toggle="pill" href="#custom-tabs-one-nohn-<?php echo $plan_id; ?>" role="tab" aria-controls="custom-tabs-one-nohn-<?php echo $plan_id; ?>" aria-selected="false"><?php echo $plan_name; ?> <span class="badge badge-secondary"><?php echo $count_detail; ?></span> </a>
                </li>




              <?php } ?>






            </ul>
          </div>







          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">






              <div class="tab-pane fade show active" id="custom-tabs-one-index" role="tabpanel" aria-labelledby="custom-tabs-one-index-tab">



                <div class="row">


                  <section class="col-lg-8 connectedSortable">



                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-chart-pie mr-1"></i>
                          งาน
                        </h3>
                        <div class="card-tools">
                        </div>
                      </div><!-- /.card-header -->
                      <div class="card-body">

                        <div class="row">
                          <?php
                          function mixTextColor($length)
                          {
                            $colors = array('default', 'primary', 'secondary', 'success', 'info', 'danger', 'warning');
                            // $result = substr(str_shuffle($text), 0, $length); 
                            for ($i = 0; $i < $length; $i++) {
                              echo $colors[array_rand($colors)];
                            }
                          }
                          ?>



                          <?php
                          foreach ($plan_array_index as $values => $data) {
                            $plan_index =  $data['plan_id'];
                            $plan_name =  $data['plan_name'];
                            $count_detail =  $data['count_detail'];

                          ?>
                            <div class="col-lg-2 col-4">
                              <!-- small box -->
                              <div class="small-box bg-<?php echo mixTextColor(1); ?>">
                                <div class="inner">
                                  <h3><?php echo $data['count_detail']; ?></sup></h3>
                                  <p><?php echo $data['plan_name']; ?></p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-stats-bars"></i>
                                </div>

                              </div>
                            </div>
                            <!-- ./col -->

                          <?php } ?>




                          <?php
                          foreach ($plan_array_nohn as $values => $data) {
                            $plan_index =  $data['plan_id'];
                            $plan_name =  $data['plan_name'];
                            $count_detail =  $data['count_detail'];

                          ?>
                            <div class="col-lg-2 col-4">
                              <!-- small box -->
                              <div class="small-box bg-<?php echo mixTextColor(1); ?>">
                                <div class="inner">
                                  <h3><?php echo $data['count_detail']; ?></sup></h3>
                                  <p><?php echo $data['plan_name']; ?></p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-stats-bars"></i>
                                </div>

                              </div>
                            </div>
                            <!-- ./col -->

                          <?php } ?>



                        </div>
                      </div>
                    </div><!-- /.card-body -->







                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-chart-pie mr-1"></i>
                          งานมีผู้ป่วย
                        </h3>
                        <div class="card-tools">
                        </div>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content p-0">

                          <canvas id="myChart" width="400" height="150"></canvas>
                        </div>
                      </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                  </section>




                  <section class="col-lg-4 connectedSortable">









                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-chart-pie mr-1"></i>
                          งานมีไม่มีผู้ป่วย
                        </h3>
                        <div class="card-tools">
                        </div>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content p-0">
                          <canvas id="myChart2" width="400" height="150"></canvas>

                        </div>
                      </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->






                    <!-- Custom tabs (areaChart)-->
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-chart-pie mr-1"></i>
                          areaChart
                        </h3>
                        <div class="card-tools">
                          <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                              <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                            </li>
                          </ul>
                        </div>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content p-0">
                          <!-- Morris chart - Sales -->

                          <canvas id="areaChart" width="400" height="150"></canvas>
                        </div>
                      </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->






                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="ion ion-clipboard mr-1"></i>
                          To Do List
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">

                      </div>
                      <!-- /.card-body -->
                    </div>




                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="ion ion-clipboard mr-1"></i>
                          To Do List
                        </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">

                      </div>
                      <!-- /.card-body -->
                    </div>

                  </section>
                </div>
              </div>









              <?php
              foreach ($plan_array_nohn as $values => $data) {
                $plan_name = $data['plan_name'];
                $plan_id = $data['plan_id'];


              ?>

                <div class="tab-pane fade" id="custom-tabs-one-nohn-<?php echo $plan_id; ?>" role="tabpanel" aria-labelledby="custom-tabs-one-nohn-<?php echo $plan_id; ?>-tab">
                  <?php include "report_student_nohn.php"; ?>
                </div>

              <?php } ?>



              <div class="tab-pane fade" id="custom-tabs-one-holistic" role="tabpanel" aria-labelledby="custom-tabs-one-holistic-tab">
                <?php include "report_student_holistic.php"; ?>
              </div>


              <div class="tab-pane fade" id="custom-tabs-one-conduct" role="tabpanel" aria-labelledby="custom-tabs-one-conduct-tab">
                <?php include "report_student_conduct.php"; ?>
              </div>


              <?php
              if ($detail_type_work_id == 0) {

                $detail_work_ids = "";
              } else {  

                $detail_work_ids = " and detail_type_work_id = '$detail_type_work_id' "; //สาขาที่ประเมิน
              }

              for ($pi = 0; $pi < count($plan_array); $pi++) {
                $plan_id = $plan_array[$pi];
              ?>
                <div class="tab-pane fade" id="custom-tabs-one-<?php echo $plan_id; ?>" role="tabpanel" aria-labelledby="custom-tabs-one-<?php echo $plan_id; ?>-tab">


                  <?php
                  // echo $plan_id;
                  // echo "<br>";

                  include "config.inc.php";
                  $sql_detail = " SELECT o.*, d.*, p.* , t.* , f.*";
                  $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                  $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE plan_id = $plan_id $detail_work_ids) as d  ON  d.order_id = o.order_id";
                  $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p  ON  p.plan_id = d.plan_id";
                  $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                  $sql_detail  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
                  $sql_detail  .=  " ORDER BY d.detail_id ASC ";
                  $query_detail = $conn->query($sql_detail);
                  while ($result_detail = $query_detail->fetch_assoc()) {

                    $tbl = $result_detail['form_main_table']; // ชื่อตาราง
                    $tbl_id = $tbl . "_id"; // Id ของตาราง
                    $detail_id = $result_detail['detail_id']; //รหัสงาน
                    $form_main_id = $result_detail['form_main_id']; //รหัสฟอร์ม

                    $detail_score = $result_detail['detail_score']; //คะแนนรวม
                    $detail_weight = $result_detail['detail_weight']; //น้ำหนักรวม
                    $detail_total = $result_detail['detail_total']; //คะแนนรวม / น้ำหนักรวม



                    // ข้อมูล class หน่วยงาน
                    $class_id =  $result_detail['class_id']; // ชื่อตาราง
                    $sql_class = "SELECT * FROM tbl_class where class_id = $class_id";
                    $query_class = $conn->query($sql_class);
                    $num_rows_class = $query_class->num_rows;
                    $row_class = $query_class->fetch_assoc();
                    echo $row_class['class_score'];

                  ?>




                    <div class="card-header">
                      <h2 class="card-title">
                        <i class="fas fa-user"></i>
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
                          Class : <?php echo nameClass::get_class_name($result_detail['class_id']); ?>
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
                        <span class="badge badge-info"> Date : <?php echo set_format_date($result_detail['detail_date_work']); ?></span>
                      </h2>

                    </div>


                    <h2>
                      <span class='badge bg-warning'><?php echo nameType_work::get_type_work_name($result_detail['detail_type_work_id']); ?></span>

                      <?php
                      $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                      $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                      $query_form_re = $conn->query($sql_form_re);
                      if ($row_form_re = $query_form_re->fetch_assoc()) {


                      
                        $last_date = $row_form_re['last_date'];

                      ?>
                        <?php if ($result_detail['detail_complete'] == 1 ) { ?>
                          <span class="badge badge-danger"> Complete <?php echo set_format_date($result_detail['detail_date_complete']); ?></span>
                        <?php }  ?>

                        <?php if ($result_detail['detail_competency'] == 1) { ?>
                          <span class="badge badge-success"> Competency </span>
                        <?php }  ?>
                    </h2>


                    <?php

                        if ($type_work_id == 1) { // สาขา X-ray ดึง จำนวนฟิมล์มาแสดงด้วย  
                          include "summary_xray.php";
                        }

                        if ($type_work_id == 2) { // สาขา Pedodontics 
                          include "summary_pedo.php";
                        }

                        if ($type_work_id == 3) { // สาขา Ortho ดึง คะแนนทั่วไป
                          include "summary_ortho.php";
                        }

                        if ($type_work_id == 4) { // สาขา oper ดึง คะแนนทั่วไป
                          include "summary_oper.php";
                        }

                        if ($type_work_id == 5) { // สาขา endo ดึง คะแนนทั่วไป
                          include "summary_endo.php";
                        }

                        if ($type_work_id == 6) { // สาขา prevent ดึง คะแนนทั่วไป
                          include "summary_cb.php";
                        }

                        if ($type_work_id == 7) { // สาขา perio ดึง คะแนนทั่วไป
                          include "summary_perio.php";
                        }

                        if ($type_work_id == 8) { // สาขา prosth ดึง คะแนนทั่วไป
                          include "summary_prosth.php";
                        }

                        if ($type_work_id == 9) { // สาขา os ดึง คะแนนทั่วไป
                          include "summary_os.php";
                        }

                        if ($type_work_id == 10) { // สาขา od ดึงคะแนนครั้งล่าสุดมาคำนวน
                          include "summary_od.php";
                        }

                        if ($type_work_id == 11) { // สาขา prevent ดึง คะแนนทั่วไป
                          include "summary_prevent.php";
                        }

                        if ($type_work_id == 12) { // สาขา Opd ดึง คะแนนทั่วไป
                          include "summary_opd.php";
                        }
                    
                    ?>


                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="callout callout-info">

                        <?php
                        // ดึงฟอร์มอื่นๆ ที่เกี่ยวข้อง		   
                        $sql_form_more   =  " SELECT fm.*  , tw.* ";
                        $sql_form_more  .=  " FROM (SELECT f.*   FROM tbl_form_more AS f WHERE f.form_more_status = 'Y' and f.type_work_id = '$type_work_id') AS fm ";
                        $sql_form_more  .=  " INNER JOIN  tbl_type_work   AS tw  ON  tw.type_work_id = fm.type_work_id ";
                        $query_form_more = $conn->query($sql_form_more);
                        $num = mysqli_num_rows($query_form_more);
                        $row_form_more = $query_form_more->fetch_assoc();
                        // echo "<br>";
                        if ($num > 0) {

                          $tbl_more = $row_form_more['form_more_table'];
                          $form_more_id = $row_form_more['form_more_id'];
                          $tbl_id_more = $tbl_more . "_id";

                          $sql_tbl_more = "SELECT * FROM tbl_" . $tbl_more . " where detail_id = $detail_id ";
                          $query_tbl_more = $conn->query($sql_tbl_more);
                          if ($row_tbl_more = $query_tbl_more->fetch_assoc()) {

                            $field_id_more = $row_tbl_more["$tbl_id_more"];
                          } else {
                            $field_id_more = "";
                          }
                        ?>




                          <?php
                          $form_more_id = $row_form_more['form_more_id'];
                          $sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
                          $query_form_detail_more = $conn->query($sql_form_detail_more);
                          while ($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

                            $form_detail_more_topic = $row_form_detail_more['form_detail_more_topic'];
                            $form_detail_more_field = $row_form_detail_more['form_detail_more_field'];
                            $field_more =   $tbl_more . "_" . $row_form_detail_more['form_detail_more_field'];

                            $row_field = $row_tbl_more["$field_more"];

                            if (!empty($row_field)) {
                              $array_row_field = json_decode("$row_field");
                            } else {
                              $jsond = '[]';
                              $array_row_field =  json_decode("$jsond");
                            }




                          ?>



                            <h4>
                              <?php echo $row_form_detail_more['form_detail_more_topic']; ?> :

                              <span class="badge badge-danger"><?php echo  implode(', ', $array_row_field); ?></span>

                              <?php if (!empty($row_field)) {
                                $array_row_field = json_decode("$row_field");
                              } else {
                                $jsond = '["133"]';

                                $array_row_field =  json_decode("$jsond");
                              } ?>

                            </h4>

                          <?php } ?>
                        <?php } ?>





                        <div style="overflow-x:auto;">
                          <table id="example3" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th Width="3%"> 
                                  <div align="center">ลำดับ</div>
                                </th>
                                <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>
                                <?php
                                $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                $query_form_re = $conn->query($sql_form_re);
                                while ($row_form_re = $query_form_re->fetch_assoc()) {
                                  //$last_date = $row_form_re['last_date'];
                                  $id_form_re = $row_form_re["{$tbl_id}"];
                                ?>

                                  <th Width="7%">
                                    <div align="center"> <?php if ($type_work_id == 4) { ?> ครั้ง <?php } else { ?> น้ำหนัก <?php } ?></div>
                                  </th>
                                  <th Width="7%">
                                    <div align="center">คะแนน</div>
                                  </th>

                                  <?PHP if ($type_work_id != 6) { // สาขา cb 
                                  ?>

                                    <th Width="7%">
                                      <div align="center">ผู้ประเมิน </div>
                                    </th>
                                    <th Width="7%">
                                      <div align="center">วันที่</div>
                                    </th>
                                    <th Width="5%"> Sum </th>

                                  <?php } else { ?>

                                    <th Width="5%"> Sum </th>

                                  <?php } ?>

                                <?php } // $sql_form_re
                                ?>


                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $i_re = 0;
                              $total_sum = 0;
                              $total_sum_s = 0;

                              $sum_score = 0;
                              $sum_score_full = 0;
                              $sum_stepp  = 0;
                            

                              // หาชื่อฟิลด์
                              $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                              $sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
                              $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                              //echo $sql_form_detail_re;
                              $query_form_detail_re = $conn->query($sql_form_detail_re);
                              while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                $i_re++;
                                $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                              ?>

                                <tr>
                                  <td>
                                    <div align="center"> <?php echo $i_re; ?></div>
                                  </td>
                                  <td><?php echo $row_form_detail_re['form_detail_topic']; ?> (<?php echo $row_form_detail_re['form_detail_field']; ?>) </td>
                                  <?php

                                  $total_sum = 0;
                                  $sum_stepp_s = 0;
                                  $total_full = 0;
                                  $total_stepp = 0;
                                  $total_sum_stepp = 0;

                                  $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                  $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                  $query_form_re = $conn->query($sql_form_re);
                                  $num_rows = $query_form_re->num_rows;
                                  while ($row_form_re = $query_form_re->fetch_assoc()) {


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
                                      $score = 4; //เกรด
                                      $stepp = 1; // จำนวนครั้ง
                                      $weight_ss =  $weight; //น้ำหนัก
                                      $claass = "table-success";  //สี
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

                                  ?>

                                    <td>
                                      <div align="center"><?php echo $weight; ?>
                                    </td>
                                    <td>
                                      <div align="center"> <?php echo $grade; ?> (<?php echo $score; ?>) </div>
                                    </td>

                                    <?PHP if ($type_work_id != 6) { // สาขา cb 
                                    ?>

                                      <td>
                                        <div align="center">
                                          <?php echo nameTeacher::get_teacher_name($teacher); ?>
                                        </div>
                                      </td>

                                      <td>
                                        <div align="center"> <?php echo $datee; ?></div>
                                      </td>

                                      <td class="<?php echo $claass; ?>">
                                        <?php
                                        if ($type_work_id == 4) { // สาขา oper ดึง คะแนนทั่วไป
                                          $sum_score = 1 * $score;
                                        } else {
                                          $sum_score = $weight * $score; //คะแนนที่ได้
                                          // echo " / ";
                                          $sum_score_full = $weight * 4; //คะแนนเต็ม
                                          $sum_stepp =  $stepp++;
                                        }
                                        ?>
                                        <div align="center">
                                          <B data-toggle="tooltip" title=" <?php echo $weight; ?> x <?php echo $grade; ?> (<?php echo $score; ?>) | <?php echo nameTeacher::get_teacher_name($teacher); ?> | <?php echo $datee; ?> "> <?php echo  $sum_score; ?> </B>
                                        </div>
                                      </td>


                                    <?PHP } else { ?>


                                      <td class="<?php echo $claass; ?>">
                                        <?php
                                        if ($type_work_id == 4) { // สาขา oper ดึง คะแนนทั่วไป

                                          $sum_score = 1 * $score;

                                        } else {
                                          $sum_score = $weight * $score; //คะแนนที่ได้
                                          // echo " / ";
                                          $sum_score_full = $weight * 4; //คะแนนเต็ม
                                          $sum_stepp =  $stepp++;
                                        }
                                        ?>
                                        <div align="center">
                                          <B data-toggle="tooltip" title=" <?php echo $weight; ?> x <?php echo $grade; ?> (<?php echo $score; ?>) | <?php echo nameTeacher::get_teacher_name($teacher); ?> | <?php echo $datee; ?> "> <?php echo  $sum_score; ?> </B>
                                        </div>
                                      </td>





                                    <?PHP } ?>






                                  <?php
                                    $total_sum =  $total_sum + $sum_score; //คะแนนรวมในขั้นตอน
                                    $total_full =  $total_full + $sum_score_full; //คะแนนเต็มในขั้นตอน
                                    $total_stepp =  $total_stepp + $sum_stepp; //จำนวนได้คะแนนในขั้นตอน
                                  }
                                  ?>





                                </tr>



                              <?php


                              }
                              ?>


                              <tr>
                                <?PHP if ($type_work_id != 6) { // สาขา cb 
                                ?>
                                  <th colspan="<?php echo $num_rows * 7; ?>">
                                  <?php } else { ?>
                                  <th colspan="<?php echo $num_rows * 5; ?>">
                                  <?php } ?>
                                  <?php
                                  $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                  $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                  $query_form_re = $conn->query($sql_form_re);
                                  $num_rows = $query_form_re->num_rows;
                                  while ($row_form_re = $query_form_re->fetch_assoc()) {
                                    $field_comment = $tbl . "_comment"; // ชื่อ field comment
                                    $comment = $row_form_re["{$field_comment}"];
                                  ?>
                                    <?php echo $comment; ?>
                                  <?php } ?>
                                  </th>


                              </tr>



                              <tr>



                                <?PHP if ($type_work_id != 6) { // สาขา cb 
                                ?>
                                  <th colspan="<?php echo $num_rows * 5; ?>"> <?php echo $num_rows; ?> </th>
                                <?php } else { ?>
                                  <th colspan="<?php echo $num_rows * 3; ?>"> <?php echo $num_rows; ?> </th>
                                <?php } ?>


                                <th Width="5%"> <?php //echo $total_weight; ?> Total score</th>
                                <th Width="5%"> 
                                  

                                (<?php echo $total_score; ?>)  /
                                
                                
                                (<?php echo $detail_score; ?>) 
                              
                              
                              </th>
                                                

                              
                              </tr>


                              <tr>

                                <?PHP if ($type_work_id != 6) { // สาขา cb 
                                ?>
                                  <th colspan="<?php echo $num_rows * 5; ?>"> <?php echo $num_rows; ?> </th>

                                <?php } else { ?>
                                  <th colspan="<?php echo $num_rows * 3; ?>"> <?php echo $num_rows; ?> </th>
                                <?php } ?>


                                <th Width="5%">

                                  <?php if ($type_work_id == 1) { ?>
                                    Score * Film
                                  <?php } else if ($type_work_id == 11) { ?>
                                    Avg Grade
                                  <?php } else if ($type_work_id == 6) { ?>
                                    ค่าเฉลี่ย
                                  <?php } else { ?>
                                    Grade
                                  <?php } ?>

                                </th>

                                <th Width="5%"> <?php // echo round($sum_sw,2); ?>

                                 (<?php echo $sum_sw; ?>) / 
                                 
                                 (<?php echo $detail_total; ?>) 
                                
                                </th>
                              </tr>


                            </tbody>

                          </table>
                        </div>






                      </div>
                    </div>
                    <!-- /.card-body -->

                  <?php } else { ?>

                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="callout callout-danger">
                        ยังไม่ได้รับการประเมินคะแนน
                      </div>
                    </div>
                    <!-- /.card-body -->

                  <?php } ?>



                  <!-- /.card -->
                <?php   } ?>
                </div>
              <?php } ?>





            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- /.content -->

<?php $conn->close(); ?>
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
      labels: [<?php foreach ($plan_array_nohn as $values => $data) { ?> '<?php echo $data['plan_name']; ?>',
        <?php } ?>
      ],
      datasets: [{
        label: '# of Votes',
        data: [<?php foreach ($plan_array_nohn as $values => $data) { ?> '<?php echo $data['count_detail']; ?>',
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

<!-- page script Tooltip -->
<script type="text/javascript">
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<!-- page script Tooltip -->



</body>

</html>