<?php include "header.php"; ?>




<?php

//เงื่อนไขตรวจสอบเวลา

$time_check = date('H:i:s');

if ($time_check <= "13:00:00") {
  $time_check_s = "AM";
} else {
  $time_check_s = "PM";
}

$teacher_id = $_SESSION['user_id'];


if (isset($_GET['arrange_date'])) {
  $arrange_date = $_GET['arrange_date'];
} else {
  $arrange_date = date('Y-m-d');
}

if (isset($_GET['arrange_time_type'])) {
  $arrange_time_type = $_GET['arrange_time_type'];
} else {



  $arrange_time_type = $time_check_s;
}

if (isset($_GET['arrange_id'])) {
  $arrange_id = $_GET['arrange_id'];
} else {
  $arrange_id = 0;
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



<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">






<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">

      <div class="col-sm-8">
        <h1>ประเมินคะแนนนักศึกษา (ในคลินิก) </h1>
      </div>

      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
          <li class="breadcrumb-item active">ประเมินคะแนนนักศึกษา (<?php echo $time_check; ?>) </li>
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
            <input type="date" name="arrange_date" class="form-control" value="<?php echo $arrange_date; ?>" placeholder="date">

            <select name="arrange_time_type" id="arrange_time_type" class="form-control select2" required>
              <option value=""> เลือก ช่วงเวลา </option>
              <option value="AM" <?php if (!(strcmp("AM", $arrange_time_type))) {
                                    echo "selected=\"selected\"";
                                  } ?>>เช้า</option>
              <option value="PM" <?php if (!(strcmp("PM", $arrange_time_type))) {
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
    <div class="col-12">
      <div class="card card-primary">

        <div class="card-header">
          <h3 class="card-title">รอประเมินคะแนนนักศึกษา</h3>
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
            $sql_arrange = " SELECT a.* , d.* , p.* , f.* , o.* ";
            $sql_arrange .= " FROM (SELECT * FROM tbl_arrange where arrange_date = '$arrange_date' and arrange_time_type = '$arrange_time_type' and teacher_id = $teacher_id and arrange_type = 0 and arrange_check_eval = 0) AS a ";
            $sql_arrange .= " INNER JOIN tbl_detail as d ON d.detail_id = a.detail_id ";
            $sql_arrange .= " INNER JOIN tbl_plan as p ON p.plan_id = d.plan_id ";
            $sql_arrange .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id ";
            $sql_arrange .= " INNER JOIN tbl_order as o ON o.order_id = d.order_id";
            $sql_arrange .= " ORDER BY a.arrange_time ASC ";
            $query_arrange = $conn->query($sql_arrange);
            while ($row_arrange = $query_arrange->fetch_assoc()) {
            ?>



              <div class="col-12 col-sm-4 col-md-3">





                <div class="card mb-3">

                  <div class="row g-0">
                    <div class="col-md-4">
                      <a href="evaluate.php?detail_id=<?php echo $row_arrange['detail_id']; ?>&plan_id=<?php echo $row_arrange['plan_id']; ?>&arrange_date=<?php echo $row_arrange['arrange_date']; ?>&arrange_id=<?php echo $row_arrange['arrange_id']; ?>">
                        <img src="../pic_students/<?php echo $row_arrange['student_id']; ?>.jpg" width="120" height="120" class="card-img-top" alt="" />
                      </a>

                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <font size="2"> <?php echo set_format_date($row_arrange['arrange_date']); ?> (<?php echo $row_arrange['arrange_time_type']; ?> <?php echo $row_arrange['arrange_time']; ?>)</font>

                        <p class="card-text">


                          <?php if ($row_arrange['arrange_record_date'] > $row_arrange['arrange_date']) {

                            $arrange_record_date = $row_arrange['arrange_record_date'];
                            echo "<font color='red'> ย้อนหลัง ($arrange_record_date)</font><br>";
                          } else {
                            echo "";
                          }  ?>
                          <b><?php echo $row_arrange['student_id']; ?></b> <br>
                          <?php echo nameStudent::get_student_name($row_arrange['student_id']); ?>
                          <br>
                          <b><?php echo $row_arrange['HN']; ?></b> <br>
                          <?php echo $row_arrange['fname']; ?>
                          <?php echo $row_arrange['lname']; ?> <br>
                        </p>
                      </div>
                    </div>
                  </div>




                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"> <?php echo $row_arrange['plan_name']; ?>

                      <?php $form_main_detail = $row_arrange['form_main_detail'];
                      $array_form_main_detail = json_decode($form_main_detail, true);
                      ?>

                      <?php if (in_array("c", $array_form_main_detail)) { ?> <br> Class : <b> <?php echo nameClass::get_class_name($row_arrange['class_id']); ?> </b> <?php } ?>
                      <?php if (in_array("s", $array_form_main_detail)) { ?> Surface : <b> <?php echo $row_arrange['detail_surface']; ?> </b> <?php } ?>
                      <?php if (in_array("r", $array_form_main_detail)) { ?> <br> Root : <b> <?php echo $row_arrange['detail_root']; ?> </b> <?php } ?>
                      <?php if (in_array("t", $array_form_main_detail)) { ?>
                        <?php
                        $array_detail_tooth = (array)json_decode($row_arrange['detail_tooth']);
                        $toothh = "";
                        foreach ($array_detail_tooth as $id => $value) {
                          $toothh .= $value . ", ";
                        }
                        ?>
                        <br> Tooth : <b><?php echo substr($toothh, 0, -2); ?></b>
                      <?php } ?>

                    </li>
                    <li class="list-group-item"> <?php
                                                  $arrange_check_eval = $row_arrange['arrange_check_eval'];
                                                  switch ($arrange_check_eval) { // Harder page
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
                    <li class="list-group-item">

                      <?php if ($row_arrange['detail_complete'] == 0) {
                        echo   $detail_complete = "";
                      } else {
                        echo  $detail_complete = " <i class='fas fa-check-circle' style='font-size:18px;color:red'> Complete </i> ";
                      }
                      ?>
                    </li>


                  </ul>


                </div>

              </div>










            <?php } ?>

          </div>


        </div>
      </div>

    </div>
















    <div class="col-12">

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
            $sql_arrange = " SELECT a.* , d.* , p.* , f.* , o.* ";
            $sql_arrange .= " FROM (SELECT * FROM tbl_arrange where arrange_date = '$arrange_date' and arrange_time_type = '$arrange_time_type' and teacher_id = $teacher_id and arrange_type = 0 and arrange_check_eval = 1) AS a ";
            $sql_arrange .= " INNER JOIN tbl_detail as d ON d.detail_id = a.detail_id ";
            $sql_arrange .= " INNER JOIN tbl_plan as p ON p.plan_id = d.plan_id ";
            $sql_arrange .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id ";
            $sql_arrange .= " INNER JOIN tbl_order as o ON o.order_id = d.order_id";
            $sql_arrange .= " ORDER BY o.student_id ASC ";
            $query_arrange = $conn->query($sql_arrange);
            while ($row_arrange = $query_arrange->fetch_assoc()) {
            ?>

              <br>

              <div class="col-3">
                <div class="card">
                  <div class="card-body">
                    <a href="evaluate.php?detail_id=<?php echo $row_arrange['detail_id']; ?>&plan_id=<?php echo $row_arrange['plan_id']; ?>&arrange_date=<?php echo $row_arrange['arrange_date']; ?>&arrange_id=<?php echo $row_arrange['arrange_id']; ?>">

                      นทพ. <?php echo $row_arrange['student_id']; ?>
                      <?php echo nameStudent::get_student_name($row_arrange['student_id']); ?>

                      <br>
                      HN : <?php echo $row_arrange['HN']; ?>
                      <?php echo $row_arrange['fname']; ?>
                      <?php echo $row_arrange['lname']; ?>





                    </a>
                    <br>
                    <?php echo $row_arrange['plan_name']; ?>


                    <?php $form_main_detail = $row_arrange['form_main_detail'];
                    $array_form_main_detail = json_decode($form_main_detail, true);
                    ?>
                    <?php if (in_array("c", $array_form_main_detail)) { ?> <br> Class : <b> <?php echo nameClass::get_class_name($row_arrange['class_id']); ?> </b> <?php } ?>
                    <?php if (in_array("s", $array_form_main_detail)) { ?> Surface : <b> <?php echo $row_arrange['detail_surface']; ?> </b> <?php } ?>
                    <?php if (in_array("r", $array_form_main_detail)) { ?> <br> Root : <b> <?php echo $row_arrange['detail_root']; ?> </b> <?php } ?>
                    <?php if (in_array("t", $array_form_main_detail)) { ?>
                      <?php
                      $array_detail_tooth = (array)json_decode($row_arrange['detail_tooth']);
                      $toothh = "";
                      foreach ($array_detail_tooth as $id => $value) {
                        $toothh .= $value . ", ";
                      }
                      ?>
                      Tooth : <b><?php echo substr($toothh, 0, -2); ?></b>
                    <?php } ?>
                    <br>

                    <?php
                    $arrange_check_eval = $row_arrange['arrange_check_eval'];
                    switch ($arrange_check_eval) { // Harder page
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
                    ?>



                    <?php if ($row_arrange['detail_complete'] == 0) {
                      echo   $detail_complete = "";
                    } else {
                      echo  $detail_complete = " <i class='fas fa-check-circle' style='font-size:18px;color:red'> Complete </i> ";
                    }
                    ?>


                    <?php if ($row_arrange['detail_competency'] == 0) {
                      echo   $detail_competency = "";
                    } else {
                      echo  $detail_competency = " <i class='fas fa-check-circle' style='font-size:18px;color:blue'> Competency </i> ";
                    }
                    ?>
                  </div>
                </div>
              </div>


              <!---  
                <div class="col-12 col-sm-6 col-md-6">




                  <div class="card mb-3">

                    <div class="row g-0">

                      <div class="col-md-12">
                        <a href="evaluate.php?detail_id=<?php echo $row_arrange['detail_id']; ?>&plan_id=<?php echo $row_arrange['plan_id']; ?>&arrange_date=<?php echo $row_arrange['arrange_date']; ?>&arrange_id=<?php echo $row_arrange['arrange_id']; ?>">


                          <div class="card-body">
                            <p class="card-text">
                            <?php echo set_format_date($row_arrange['arrange_date']); ?> (<?php echo $row_arrange['arrange_time_type']; ?> <?php echo $row_arrange['arrange_time']; ?>)
                              <b><?php echo $row_arrange['student_id']; ?></b> <br>
                              <?php echo nameStudent::get_student_name($row_arrange['student_id']); ?>
                              <br>
                              <b><?php echo $row_arrange['HN']; ?></b> <br>
                              <?php echo $row_arrange['fname']; ?>
                              <?php echo $row_arrange['lname']; ?> <br>
                            </p>
                          </div>


                        </a>

                      </div>
                    </div>



                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"> <?php echo $row_arrange['plan_name']; ?>
                    
                      <?php $form_main_detail = $row_arrange['form_main_detail'];
                      $array_form_main_detail = json_decode($form_main_detail, true);
                      ?>
                    	<?php if (in_array("c", $array_form_main_detail)) { ?> <br> Class : <b> <?php echo nameClass::get_class_name($row_arrange['class_id']); ?> </b> <?php } ?>
											<?php if (in_array("s", $array_form_main_detail)) { ?> Surface : <b> <?php echo $row_arrange['detail_surface']; ?> </b> <?php } ?>
											<?php if (in_array("r", $array_form_main_detail)) { ?> <br> Root : <b> <?php echo $row_arrange['detail_root']; ?> </b> <?php } ?>
                      <?php if (in_array("t", $array_form_main_detail)) { ?>
                      <?php
                        $array_detail_tooth = (array)json_decode($row_arrange['detail_tooth']);
                        $toothh = "";
                        foreach ($array_detail_tooth as $id => $value) {
                          $toothh .= $value . ", ";
                        }
                      ?>
                         Tooth :  <b><?php echo substr($toothh, 0, -2); ?></b>
                      <?php } ?>
                    
                    
                    </li>
                      <li class="list-group-item"> <?php
                                                    $arrange_check_eval = $row_arrange['arrange_check_eval'];
                                                    switch ($arrange_check_eval) { // Harder page
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
                      <li class="list-group-item">

                        <?php if ($row_arrange['detail_competency'] == 0) {
                          echo   $detail_competency = "";
                        } else {
                          echo  $detail_competency = " <i class='fas fa-check-circle' style='font-size:18px;color:red'> Competency </i> ";
                        }
                        ?>
                      </li>
                    </ul>

                  </div>


                </div>

-->






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
          <h3 class="card-title">ค้างประเมินคะแนนนักศึกษา</h3>
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
            $sql_arrange = " SELECT a.* , d.* , p.* , f.* , o.* ";
            $sql_arrange .= " FROM (SELECT * FROM tbl_arrange where arrange_date != '$arrange_date' and teacher_id = $teacher_id and arrange_type = 0 and arrange_check_eval = 0) AS a ";
            $sql_arrange .= " INNER JOIN tbl_detail as d ON d.detail_id = a.detail_id ";
            $sql_arrange .= " INNER JOIN tbl_plan as p ON p.plan_id = d.plan_id ";
            $sql_arrange .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id ";
            $sql_arrange .= " INNER JOIN tbl_order as o ON o.order_id = d.order_id";
            $sql_arrange .= " ORDER BY a.arrange_time ASC ";
            $query_arrange = $conn->query($sql_arrange);
            while ($row_arrange = $query_arrange->fetch_assoc()) {
            ?>



              <div class="col-12 col-sm-3 col-md-3">




                <div class="card mb-3">

                  <div class="row g-0">
                    <div class="col-md-4">
                      <a href="evaluate.php?detail_id=<?php echo $row_arrange['detail_id']; ?>&plan_id=<?php echo $row_arrange['plan_id']; ?>&arrange_date=<?php echo $row_arrange['arrange_date']; ?>&arrange_id=<?php echo $row_arrange['arrange_id']; ?>">
                        <img src="../pic_students/<?php echo $row_arrange['student_id']; ?>.jpg" width="120" height="120" class="card-img-top" alt="" />
                      </a>

                    </div>
                    <div class="col-md-8">
                      <div class="card-body">

                        <?php echo set_format_date($row_arrange['arrange_date']); ?> (<?php echo $row_arrange['arrange_time_type']; ?> <?php echo $row_arrange['arrange_time']; ?>)


                        <p class="card-text">

                          <?php if ($row_arrange['arrange_record_date'] > $row_arrange['arrange_date']) {

                            $arrange_record_date = set_format_date($row_arrange['arrange_record_date']);
                            echo "<font color='red'><B> ย้อนหลัง ($arrange_record_date) </B></font><br>";
                          } else {
                            echo "";
                          }  ?>

                          <b><?php echo $row_arrange['student_id']; ?></b> <br>
                          <?php echo nameStudent::get_student_name($row_arrange['student_id']); ?>
                          <br>
                          <b><?php echo $row_arrange['HN']; ?></b> <br>
                          <?php echo $row_arrange['fname']; ?>
                          <?php echo $row_arrange['lname']; ?> <br>
                        </p>
                      </div>
                    </div>
                  </div>



                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"> <?php echo $row_arrange['plan_name']; ?>


                      <?php $form_main_detail = $row_arrange['form_main_detail'];
                      $array_form_main_detail = json_decode($form_main_detail, true);
                      ?>
                      <?php if (in_array("c", $array_form_main_detail)) { ?> <br> Class : <b> <?php echo nameClass::get_class_name($row_arrange['class_id']); ?> </b> <?php } ?>
                      <?php if (in_array("s", $array_form_main_detail)) { ?> Surface : <b> <?php echo $row_arrange['detail_surface']; ?> </b> <?php } ?>
                      <?php if (in_array("r", $array_form_main_detail)) { ?> <br> Root : <b> <?php echo $row_arrange['detail_root']; ?> </b> <?php } ?>
                      <?php if (in_array("t", $array_form_main_detail)) { ?>
                        <?php
                        $array_detail_tooth = (array)json_decode($row_arrange['detail_tooth']);
                        $toothh = "";
                        foreach ($array_detail_tooth as $id => $value) {
                          $toothh .= $value . ", ";
                        }
                        ?>
                        Tooth : <b><?php echo substr($toothh, 0, -2); ?></b>
                      <?php } ?>
                    </li>
                    <li class="list-group-item"> <?php
                                                  $arrange_check_eval = $row_arrange['arrange_check_eval'];
                                                  switch ($arrange_check_eval) { // Harder page
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
                    <li class="list-group-item">

                      <?php if ($row_arrange['detail_complete'] == 0) {
                        echo   $detail_complete = "";
                      } else {
                        echo  $detail_complete = " <i class='fas fa-check-circle' style='font-size:18px;color:red'> Complete </i> ";
                      }
                      ?>
                    </li>


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




<!-- /.wrapper -->
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



<script>
  $(function() {
    // Summernote
    $('.textarea').summernote({
      placeholder: 'แสดงความคิดเห็น',
      tabsize: 2,
      height: 200
    })
  })
</script>







<!-- page script Tooltip -->
<script type="text/javascript">
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<!-- page script Tooltip -->


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
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
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



</body>

</html>