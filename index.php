<?php include "header.php";

include "config.inc.php";

?>



<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">ยินดีต้อนรับ</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active"> <?php echo date('d-m-Y'); ?></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->





<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">




      <div class="col-sm-12">
        <?php if (isset($_SESSION['level_user'])) { ?>

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">

                ยินดีต้อนรับ เข้าสู่ระบบประเมินคะแนนนักศึกษาในคลินิก (E-Clinic)

              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">

              <?php if (isset($_SESSION['level_user']) && !empty($_SESSION['level_user'])) { ?>



                <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                  <?php if ($_SESSION['level_user'] == "Student") { // เป็น Student  
                  ?>
                    <div class="image">
                      <!--  <img src="http://10.151.127.134/estudent/pic_students/<?php echo $_SESSION['loginname']; ?>.jpg" class="img-circle elevation-2" alt="User Image">-->
                      <img src="../pic_students/<?php echo $_SESSION['loginname']; ?>.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                  <?php } ?>



                  <div class="info">
                    <a href="#" class="d-block"><?php echo  $_SESSION['loginname']; ?> <br>
                      <?php echo  $_SESSION['fname']; ?> <?php echo  $_SESSION['lname']; ?></a>
                  </div>



                </div>

                

                    <?php if (isset($_SESSION['level_user']) && !empty($_SESSION['level_user'])) { ?>



                      <?php //เป็น  ระดับ Admin root
                      if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 2)) {
                      ?>


                      <?php  } ?>




                    <?php  } ?>






              <?php } ?>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="logout.php" class="btn btn-default">
                <i class="fa fa-unlock nav-icon"></i> ออกจากระบบ
              </a>

            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->



          <?php if ($_SESSION['level_user'] == "Student") { // เป็น Student   

            $student_id = $_SESSION['loginname'];
          ?>



            <?PHP
            if (isset($_GET['type_work_id'])) {
              $type_work_ids = $_GET['type_work_id'];
            } else {
              $type_work_ids = 1;
            }
            ?>



            <div class="row">
              <?php
              // order_type = 0 and

              $sql_order = " SELECT count(order_id) As count_order FROM tbl_order where  causes_of_pay_id = 0  and student_id = $student_id ";
              $query_order = $conn->query($sql_order);
              $result_order = $query_order->fetch_assoc();

              if (!empty($result_order["count_order"])) {
                $count_order = $result_order["count_order"];
              } else {
                $count_order = 0;
              }


              $sql_order_o = " SELECT count(order_id) As count_order FROM tbl_order where  causes_of_pay_id != 0 and student_id = $student_id ";
              $query_order_o = $conn->query($sql_order_o);
              $result_order_o = $query_order_o->fetch_assoc();

              if (!empty($result_order_o["count_order"])) {
                $count_order_o = $result_order_o["count_order"];
              } else {
                $count_order_o = 0;
              }

              ?>


              <div class="col-12 col-sm-3 col-md-2">
                <div class="info-box">
                  <span class="info-box-icon elevation-1">
                    <img src="images/dent.png" class="img-circle" width="50" height="50">
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text"> จำนวนผู้ป่วยคงอยู่ </span>
                    <span class="info-box-number">
                      <?php echo $count_order; ?>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>




              <div class="col-12 col-sm-3 col-md-2">
                <div class="info-box">
                  <span class="info-box-icon elevation-1">
                    <img src="images/dent.png" class="img-circle" width="50" height="50">
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text"> จำนวนผู้ป่วยจ่ายออก </span>
                    <span class="info-box-number">
                      <?php echo $count_order_o; ?>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>


              <?php
              $sql_holistic_count = " SELECT   COUNT(h.holistic_id) As holistic_count ";
              $sql_holistic_count  .=  " FROM (SELECT * FROM tbl_holistic WHERE student_id = '$student_id' ";
              $sql_holistic_count  .=  " ) as h ";
              $sql_holistic_count  .=  " INNER JOIN (SELECT * FROM tbl_teacher WHERE type_work_id = $type_work_ids) as th  ON  h.teacher_id = th.teacher_id";
              $query_holistic_count = $conn->query($sql_holistic_count);
              $result_holistic_count = $query_holistic_count->fetch_assoc();

              if (!empty($result_holistic_count["holistic_count"])) {
                $holistic_count = $result_holistic_count["holistic_count"];
              } else {
                $holistic_count = 0;
              }
              ?>


              <div class="col-12 col-sm-3 col-md-2">
                <div class="info-box">
                  <span class="info-box-icon elevation-1">
                    <img src="images/dent.png" class="img-circle" width="50" height="50">
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text"> Holistic </span>
                    <span class="info-box-number">
                      <?php echo $holistic_count; ?>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>

            </div>





            <div class="row">

              <?PHP
              $sql_work = "SELECT * FROM tbl_type_work ";
              $query_work = $conn->query($sql_work);
              while ($result_work = $query_work->fetch_assoc()) {

                $type_work_id   = $result_work['type_work_id'];
                $type_work_name = $result_work['type_work_name'];


                $sql_detail_c = " SELECT  count(d.detail_id) as count_detail_id ";
                $sql_detail_c  .=  " FROM  tbl_detail as d ";
                $sql_detail_c  .=  " INNER JOIN  (SELECT * FROM  tbl_order  WHERE student_id = $student_id) as o  ON  o.order_id = d.order_id ";
                $sql_detail_c  .=  " INNER JOIN  (SELECT * FROM  tbl_plan  WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = d.plan_id ";

                $query_detail_c = $conn->query($sql_detail_c);
                $result_detail_c = $query_detail_c->fetch_assoc();

                if (!empty($result_detail_c["count_detail_id"])) {
                  $count_detail_c = $result_detail_c["count_detail_id"];
                } else {
                  $count_detail_c = 0;
                }





                $sql_detail_cc = " SELECT  count(d.detail_id) as count_detail_id ";
                $sql_detail_cc  .=  " FROM (SELECT * FROM  tbl_detail  WHERE detail_complete = 1) as d ";
                $sql_detail_cc  .=  " INNER JOIN  (SELECT * FROM  tbl_order  WHERE student_id = $student_id) as o  ON  o.order_id = d.order_id ";
                $sql_detail_cc  .=  " INNER JOIN  (SELECT * FROM  tbl_plan  WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = d.plan_id ";

                $query_detail_cc = $conn->query($sql_detail_cc);
                $result_detail_cc = $query_detail_cc->fetch_assoc();

                if (!empty($result_detail_cc["count_detail_id"])) {
                  $count_detail_cc = $result_detail_cc["count_detail_id"];
                } else {
                  $count_detail_cc = 0;
                }







              ?>

                <div class="col-12 col-sm-3 col-md-2">
                  <a href="?student_id=<?php echo $student_id; ?>&type_work_id=<?php echo $type_work_id; ?>">
                    <div class="info-box">
                      <span class="info-box-icon elevation-1">

                        <img src="images/dent2.png" class="img-circle" width="50" height="50">

                      </span>

                      <div class="info-box-content">
                        <span class="info-box-text"> <?php echo $type_work_name; ?></span>
                        <span class="info-box-number">
                          <?php echo $count_detail_c; ?> / <?php echo $count_detail_cc; ?>
                        </span>



                      </div>
                      <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                  </a>
                </div>

              <?php } ?>



            </div>







            <div class="row">

              <div class="col-md-12">
                <!-- AREA CHART -->
                <div class="card card-purple">
                  <div class="card-header">
                    <h3 class="card-title">Plan >> <?php echo nameType_work::get_type_work_name($type_work_id); ?></h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->


              </div>

            </div>



          <?php } ?>




     
            <div class="row">

                <div class="col-md-12">
                  <!-- AREA CHART -->
                  <div class="card card-purple">
                          <div class="card-header">
                            <h3 class="card-title">คู่มือใช้งาน</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                              </button>
                            </div>
                          </div>
                          
                          <div class="card-body">
                               <a href="manual/manualT11.pdf" class="btn btn-danger" target="_blank"> <i class="fas fa-file-pdf"></i>  โหลดคู่มือการประเมิน </a>
                               <a href="manual/manualT2.pdf" class="btn btn-danger" target="_blank"> <i class="fas fa-file-pdf"></i>  โหลดวิธีการดึงคะแนนปฏิบัติงานในระบบ  </a>
                          </div>                       
                        <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>

            </div>

      
















          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">

                Update_version

              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">
              <?PHP
              $sql_update_version = " SELECT * FROM tbl_update_version as update_version ";
              $sql_update_version .= " ORDER BY update_version.update_version_date DESC ";
              $query_update_version = $conn->query($sql_update_version);
              while ($result_update_version = $query_update_version->fetch_assoc()) {
              ?>

                <?php echo $result_update_version['update_version_date']; ?> -->> <?php echo $result_update_version['update_version_detail']; ?> <br>

              <?php } ?>

            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->











              <?php  // เป็น Staff  และ ระดับ Admin
              if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 1)) {
              ?>

                <!-- Default box -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">
                      ขั้นตอนการจ่ายเคสให้นักศึกษา
                    </h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="mp4/case.mp4" allowfullscreen></iframe>
                    </div>

                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">

                  </div>
                  <!-- /.card-footer-->
                </div>
                <!-- /.card -->

              <?php } ?>







             


        <?php } else { ?>

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                ยินดีต้อนรับ กรุณาเข้าสู่ระบบ โดยใช้ Username และ Password ของ ระบบ Hosxp
              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">

              <form name="form1" method="post" action="check_login.php">

                <div class="row">
                  <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Username </label>
                      <input name="username" type="text" class="form-control" placeholder="Username" required>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Password </label>
                      <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
                      <button type="submit" class="btn btn-info">เข้าสู่ระบบ</button>

                    

                    </div>
                  </div> 
                </div>
              </form>

              <a href="admin.php" target="_blank"> สำหรับเจ้าหน้าที่สาขาวิชา คลิ๊กที่นี้</a>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a href="http://10.0.1.108/resetpw" target="_blank"> คลิ๊กที่นี้ กรณีลืม Password ระบบ Hosxp
              </a> <br>
              <img src="images/reset.png">
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->



        <?php } ?>










      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>


<?php if (isset($_SESSION['level_user'])) {  ?>
  <?php if ($_SESSION['level_user'] == "Student") { // เป็น Student  
  ?>


    <?PHP // ข้อมูล งานของแต่ละสาขา


    $plan_array = array();

    $sql_plan = " SELECT p.* , t.* , f.*";
    $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_ids  ) as p ";
    $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
    $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
    $sql_plan  .=  " ORDER BY p.plan_id ASC ";

    $query_plan = $conn->query($sql_plan);
    while ($result_plan = $query_plan->fetch_assoc()) {

      $plan_id = $result_plan['plan_id'];
      $sql_detail = " SELECT  count(d.detail_id) as count_detail_id ";
      $sql_detail  .=  " FROM (SELECT * FROM tbl_detail WHERE plan_id = $plan_id) as d ";
      $sql_detail  .=  " INNER JOIN  (SELECT * FROM  tbl_order  WHERE student_id = $student_id) as o  ON  o.order_id = d.order_id ";
      $sql_detail  .=  " ORDER BY d.detail_id ASC ";
      $query_detail = $conn->query($sql_detail);
      $result_detail = $query_detail->fetch_assoc();
      if (!empty($result_detail["count_detail_id"])) {
        $count_detail_id = $result_detail["count_detail_id"];
      } else {
        $count_detail_id = 0;
      }



      $sql_detail_com = " SELECT  count(d.detail_id) as count_detail_id ";
      $sql_detail_com  .=  " FROM (SELECT * FROM tbl_detail WHERE plan_id = $plan_id and detail_complete = 1) as d ";
      $sql_detail_com  .=  " INNER JOIN  (SELECT * FROM  tbl_order  WHERE student_id = $student_id) as o  ON  o.order_id = d.order_id ";
      $sql_detail_com  .=  " ORDER BY d.detail_id ASC ";
      $query_detail_com = $conn->query($sql_detail_com);
      $result_detail_com = $query_detail_com->fetch_assoc();
      if (!empty($result_detail_com["count_detail_id"])) {
        $count_detail_id_com = $result_detail_com["count_detail_id"];
      } else {
        $count_detail_id_com = 0;
      }



      $sql_detail_comcy = " SELECT  count(d.detail_id) as count_detail_id ";
      $sql_detail_comcy  .=  " FROM (SELECT * FROM tbl_detail WHERE plan_id = $plan_id and detail_competency = 1) as d ";
      $sql_detail_comcy  .=  " INNER JOIN  (SELECT * FROM  tbl_order  WHERE student_id = $student_id) as o  ON  o.order_id = d.order_id ";
      $sql_detail_comcy  .=  " ORDER BY d.detail_id ASC ";
      $query_detail_comcy = $conn->query($sql_detail_comcy);
      $result_detail_comcy = $query_detail_comcy->fetch_assoc();


      if (!empty($result_detail_comcy["count_detail_id"])) {
        $count_detail_id_comcy = $result_detail_comcy["count_detail_id"];
      } else {
        $count_detail_id_comcy = 0;
      }



      $plan_array[] = array(
        'plan_id' => $result_plan['plan_id'],
        'plan_name' => $result_plan['plan_name'],
        'count_detail_id' => $count_detail_id,
        'count_detail_id_com' => $count_detail_id_com,
        'count_detail_id_comcy' => $count_detail_id_comcy
      );
    }


    ?>

  <?php } ?>
<?php } ?>


<?php $conn->close(); ?>



<?php include "footer.php"; ?>
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
  $(function() {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART - 
    //-------------- labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {

      labels: [<?php foreach ($plan_array as $values => $data) { ?> '<?php echo $data['plan_name']; ?>', <?php } ?>],

      datasets: [{
          label: 'จำนวนงาน',
          backgroundColor: '#D7BDE2',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [<?php foreach ($plan_array as $values => $data) { ?><?php echo $data['count_detail_id']; ?>, <?php } ?>]
        },
        {
          label: 'Complete',
          backgroundColor: '#AF7AC5',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [<?php foreach ($plan_array as $values => $data) { ?><?php echo $data['count_detail_id_com']; ?>, <?php } ?>]
        },

        {
          label: 'Competency',
          backgroundColor: '#633974',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [<?php foreach ($plan_array as $values => $data) { ?><?php echo $data['count_detail_id_comcy']; ?>, <?php } ?>]
        },

      ]
    }

    var areaChartOptions = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            display: false,
          }
        }],
        yAxes: [{
          gridLines: {
            display: false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'bar',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData = {
      labels: [
        'Chrome',
        'IE',
        'FireFox',
        'Safari',
        'Opera',
        'Navigator',
      ],
      datasets: [{
        data: [700, 500, 400, 600, 300, 100],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
      }]
    }
    var donutOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = donutData;
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>