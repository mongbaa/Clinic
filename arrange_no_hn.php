<?php include "header.php"; ?>

<?php 
if (isset($_SESSION['sessid']) && !empty($_SESSION['level_user'])) { 
}else{
  echo "<script type='text/javascript'>";
  echo  "alert('เช้าสู่ระบบก่อนใช้งาน....!');";
  echo "window.location='login.php'";
  echo "</script>";
}
?>

<?php		 
		function set_format_date($rub){
			if(!empty($rub)){
				list($yyy,$mmm,$ddd) = explode("-",$rub);
				$new_date = $ddd."-".$mmm."-".$yyy;
				return $new_date;
			}
		}
  ?>


<?php

$teacher_id = $_SESSION['user_id'];

$time_check = date('H:i:s');

if ($time_check <= "13:00:00") {
  $time_check_s = "AM";
} else {
  $time_check_s = "PM";
}



$arrange_time_type = $time_check_s;

if (isset($_GET['arrange_nohn_date'])) {
  $arrange_nohn_date = $_GET['arrange_nohn_date'];
} else {
  $arrange_nohn_date = date('Y-m-d');
}

if (isset($_GET['arrange_nohn_time_type'])) {
  $arrange_nohn_time_type = $_GET['arrange_nohn_time_type'];
} else {
  $arrange_nohn_time_type = $time_check_s;
}

if (isset($_GET['arrange_nohn_id'])) {
  $arrange_nohn_id = $_GET['arrange_nohn_id'];
} else {
  $arrange_nohn_id = 0;
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



<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">







  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-8">
          <h1>รายชื่อนักศึกษารอประเมินคะแนน (กรณีไม่มีผู้ป่วย) </h1>
        </div>

        <div class="col-sm-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
            <li class="breadcrumb-item active">ประเมินคะแนนนักศึกษา</li>
          </ol>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>



  <!-- Main content -->
  <section class="content">










    <div class="row">
      <div class="col-12 col-sm-6 col-md-6">
        <div class="card collapsed-card">
          <form id="search" name="search" method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="input-group input-group">
              <input type="date" name="arrange_nohn_date" class="form-control" value="<?php echo $arrange_nohn_date; ?>" placeholder="date">

              <select name="arrange_nohn_time_type" id="arrange_nohn_time_type" class="form-control select2" required>
                <option value=""> เลือก ช่วงเวลา </option>
                <option value="AM" <?php if (!(strcmp("AM", $arrange_nohn_time_type))) {
                                      echo "selected=\"selected\"";
                                    } ?>>เช้า</option>
                <option value="PM" <?php if (!(strcmp("PM", $arrange_nohn_time_type))) {
                                      echo "selected=\"selected\"";
                                    } ?>>บ่าย</option>
              </select>
              <div class="input-group-append">
                <button type="submit" class="btn btn-info">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row -->








    <div class="row">




      <div class="col-8">


        <div class="card card-primary">

          <div class="card-header">
            <h3 class="card-title">รอประเมินคะแนนนักศึกษากรณีไม่มีผู้ป่วย</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
          </div>

          <div class="card-body">




            <div class="row">

              <?php
              // แสดงข้อมูล นักศึกษาที่ ส่งงานมาตามวันที่เลือก
              include "config.inc.php";
              $sql_arrange_nohn = " SELECT a.* ,  p.* , f.*  ";
              $sql_arrange_nohn .= " FROM (SELECT * FROM tbl_arrange_nohn where arrange_nohn_date = '$arrange_nohn_date' and arrange_nohn_time_type = '$arrange_nohn_time_type' and teacher_id = $teacher_id  and arrange_nohn_check_eval = 0) AS a ";
              $sql_arrange_nohn .= " INNER JOIN tbl_plan as p ON p.plan_id = a.plan_id ";
              $sql_arrange_nohn .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id ";
              $sql_arrange_nohn .= " ORDER BY a.arrange_nohn_time ASC ";
              $query_arrange_nohn = $conn->query($sql_arrange_nohn);
              while ($row_arrange_nohn = $query_arrange_nohn->fetch_assoc()) {
              ?>



                <div class="col-12 col-sm-6 col-md-4">




                  <div class="card mb-3">

                    <div class="row g-0">
                      <div class="col-md-4">

                        <a href="evaluate_nohn.php?student_id=<?php echo $row_arrange_nohn['student_id']; ?>&plan_id=<?php echo $row_arrange_nohn['plan_id']; ?>&arrange_nohn_date=<?php echo $row_arrange_nohn['arrange_nohn_date']; ?>&arrange_nohn_id=<?php echo $row_arrange_nohn['arrange_nohn_id']; ?>">
                          <img src="../pic_students/<?php echo $row_arrange_nohn['student_id']; ?>.jpg" width="120" height="120" class="card-img-top" alt="<?php echo nameStudent::get_student_name($row_arrange_nohn['student_id']); ?>" />
                        </a>

                      </div>
                      <div class="col-md-8">
                        <div class="card-body">

                        <font size = "2"> <?php echo set_format_date($row_arrange_nohn['arrange_nohn_date']);?> (<?php echo $row_arrange_nohn['arrange_nohn_time_type']; ?> <?php echo $row_arrange_nohn['arrange_nohn_time']; ?>)</font> 

                          <p class="card-text">
                            <b><?php echo $row_arrange_nohn['student_id']; ?></b> <br>
                            <?php echo nameStudent::get_student_name($row_arrange_nohn['student_id']); ?> <br>

                          </p>
                        </div>
                      </div>
                    </div>



                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"> <?php echo $row_arrange_nohn['plan_name']; ?> </li>
                      <li class="list-group-item"> <?php
                                                    $arrange_nohn_check_eval = $row_arrange_nohn['arrange_nohn_check_eval'];
                                                    switch ($arrange_nohn_check_eval) { // Harder page
                                                      case 1:
                                                        echo  "<i class='fas fa-check-circle' style='font-size:18px;color:green'> ประเมินแล้ว </i>";
                                                        break;
                                                      case 0:
                                                        echo  "<i class='fas fa-history' style='font-size:18px;color:gray'> รอรับการประเมิน </i>";
                                                        break;
                                                      default:
                                                        echo  "<i class='fas fa-history'></i> -";
                                                        break;
                                                    }
                                                    ?></li>

                    </ul>

                  </div>

                </div>










              <?php } ?>

            </div>


          </div>
        </div>

      </div>
















      <div class="col-4">

        <div class="card card-success">

          <div class="card-header">
            <h3 class="card-title">ประเมินคะแนนนักศึกษาแล้ว</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
          </div>

          <div class="card-body">

            <div class="row">

              <?php

              // แสดงข้อมูล นักศึกษาที่ ส่งงานมาตามวันที่เลือก
              include "config.inc.php";
              $sql_arrange_nohn = " SELECT a.* ,  p.* , f.*  ";
              $sql_arrange_nohn .= " FROM (SELECT * FROM tbl_arrange_nohn where arrange_nohn_date = '$arrange_nohn_date' and arrange_nohn_time_type = '$arrange_nohn_time_type' and teacher_id = $teacher_id  and arrange_nohn_check_eval = 1) AS a ";
              $sql_arrange_nohn .= " INNER JOIN tbl_plan as p ON p.plan_id = a.plan_id ";
              $sql_arrange_nohn .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id ";
              $sql_arrange_nohn .= " ORDER BY a.arrange_nohn_time ASC ";
              $query_arrange_nohn = $conn->query($sql_arrange_nohn);
              while ($row_arrange_nohn = $query_arrange_nohn->fetch_assoc()) {
              ?>



                <div class="col-12 col-sm-6 col-md-6">




                  <div class="card mb-6">

                    <div class="row g-0">

                      <div class="col-md-12">
                        <div class="card-body">

                          <a href="evaluate_nohn.php?student_id=<?php echo $row_arrange_nohn['student_id']; ?>&plan_id=<?php echo $row_arrange_nohn['plan_id']; ?>&arrange_nohn_date=<?php echo $row_arrange_nohn['arrange_nohn_date']; ?>&arrange_nohn_id=<?php echo $row_arrange_nohn['arrange_nohn_id']; ?>">

                            <p class="card-text">
                              <b><?php echo $row_arrange_nohn['student_id']; ?></b> <br>
                              <?php echo nameStudent::get_student_name($row_arrange_nohn['student_id']); ?> <br>

                            </p>
                          </a>
                        </div>
                      </div>
                    </div>



                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"> <?php echo $row_arrange_nohn['plan_name']; ?> </li>
                      <li class="list-group-item"> <?php
                                                    $arrange_nohn_check_eval = $row_arrange_nohn['arrange_nohn_check_eval'];
                                                    switch ($arrange_nohn_check_eval) { // Harder page
                                                      case 1:
                                                        echo  "<i class='fas fa-check-circle' style='font-size:18px;color:green'> ประเมินแล้ว </i>";
                                                        break;
                                                      case 0:
                                                        echo  "<i class='fas fa-history' style='font-size:18px;color:gray'> รอรับการประเมิน </i>";
                                                        break;
                                                      default:
                                                        echo  "<i class='fas fa-history'></i> -";
                                                        break;
                                                    }
                                                    ?></li>

                    </ul>

                  </div>

                </div>










              <?php } ?>

            </div>
          </div>

        </div>



      </div>


    </div>

















    <div class="row">




      <div class="col-12">


        <div class="card card-warning">

          <div class="card-header">
            <h3 class="card-title">ค้างประเมินคะแนนนักศึกษากรณีไม่มีผู้ป่วย</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
          </div>

          <div class="card-body">




            <div class="row">

              <?php
              // แสดงข้อมูล นักศึกษาที่ ส่งงานมาตามวันที่เลือก
              include "config.inc.php";
              $sql_arrange_nohn = " SELECT a.* ,  p.* , f.*  ";
              $sql_arrange_nohn .= " FROM (SELECT * FROM tbl_arrange_nohn where  arrange_nohn_date != '$arrange_nohn_date' and teacher_id = $teacher_id  and arrange_nohn_check_eval = 0) AS a ";
              $sql_arrange_nohn .= " INNER JOIN tbl_plan as p ON p.plan_id = a.plan_id ";
              $sql_arrange_nohn .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id ";
              $sql_arrange_nohn .= " ORDER BY a.arrange_nohn_time ASC ";
              $query_arrange_nohn = $conn->query($sql_arrange_nohn);
              while ($row_arrange_nohn = $query_arrange_nohn->fetch_assoc()) {
              ?>


                <div class="col-12 col-sm-6 col-md-3">

                  <div class="card mb-3">
 
                    <div class="row g-0">
                      <div class="col-md-4">

                        <a href="evaluate_nohn.php?student_id=<?php echo $row_arrange_nohn['student_id']; ?>&plan_id=<?php echo $row_arrange_nohn['plan_id']; ?>&arrange_nohn_date=<?php echo $row_arrange_nohn['arrange_nohn_date']; ?>&arrange_nohn_id=<?php echo $row_arrange_nohn['arrange_nohn_id']; ?>">
                          <img src="../pic_students/<?php echo $row_arrange_nohn['student_id']; ?>.jpg" width="120" height="120" class="card-img-top" alt="<?php echo nameStudent::get_student_name($row_arrange_nohn['student_id']); ?>" />
                        </a>

                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                        <?php echo set_format_date($row_arrange_nohn['arrange_nohn_date']);?> (<?php echo $row_arrange_nohn['arrange_nohn_time_type']; ?>)
                        
                          <p class="card-text">
                            <b><?php echo $row_arrange_nohn['student_id']; ?></b> <br>
                            <?php echo nameStudent::get_student_name($row_arrange_nohn['student_id']); ?> <br>
                          </p>
                        </div>
                      </div>
                    </div>



                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"> <?php echo $row_arrange_nohn['plan_name']; ?> </li>
                      <li class="list-group-item"> <?php
                                                    $arrange_nohn_check_eval = $row_arrange_nohn['arrange_nohn_check_eval'];
                                                    switch ($arrange_nohn_check_eval) { // Harder page
                                                      case 1:
                                                        echo  "<i class='fas fa-check-circle' style='font-size:18px;color:green'> ประเมินแล้ว </i>";
                                                        break;
                                                      case 0:
                                                        echo  "<i class='fas fa-history' style='font-size:18px;color:gray'> รอรับการประเมิน </i>";
                                                        break;
                                                      default:
                                                        echo  "<i class='fas fa-history'></i> -";
                                                        break;
                                                    }
                                                    ?></li>

                    </ul>

                  </div>

                </div>










              <?php } ?>

            </div>


          </div>
        </div>

      </div>

     


    </div>





  </section>
  <!-- /.content -->





<?php include "footer2.php"; ?>




<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function() {
    // Summernote
    $('.textarea').summernote()
  })
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