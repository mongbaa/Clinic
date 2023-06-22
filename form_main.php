<?php include "header.php";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">
<!-- DataTables -->

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons 
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
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
<!-- Google Font: Source Sans Pro 
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
</head>


<?php

if (isset($_GET['edit'])) {

  include "config.inc.php";
  $sql_edit = "SELECT * FROM tbl_form_main where form_main_id='$_GET[edit]' ";
  $query_edit = $conn->query($sql_edit);
  $result_edit = $query_edit->fetch_assoc();

  $form_main_id = $result_edit['form_main_id'];
  $type_work_id = $result_edit['type_work_id'];
  $form_main_name = $result_edit['form_main_name'];
  $form_main_format = $result_edit['form_main_format'];
  $form_main_type = $result_edit['form_main_type'];
  $form_main_status = $result_edit['form_main_status'];
  $form_main_table = $result_edit['form_main_table'];
  $form_main_confirm = $result_edit['form_main_confirm'];
  $form_main_detail = $result_edit['form_main_detail'];
} else {

  $form_main_id = "";
  $type_work_id = "";
  $form_main_name = "";
  $form_main_format = "";
  $form_main_type = "";
  $form_main_status = "";
  $form_main_table = "";
  $form_main_confirm = "";

  $form_main_detail = "";
}



if (isset($_GET['del'])) {

  $form_main_table = $_GET['form_main_table'];

  include "config.inc.php";
  $sql_del = "DELETE FROM tbl_form_main WHERE tbl_form_main.form_main_id = $_GET[del]";
  $conn->query($sql_del);
  //echo "<br>";


  $sql_del2 = "DELETE FROM tbl_form_detail WHERE tbl_form_detail.form_main_id = $_GET[del]";
  $conn->query($sql_del2);
  // echo "<br>";


  $sql_dorp = "DROP TABLE {$form_main_table}";
  $conn->query($sql_dorp);


  echo "<script type='text/javascript'>";
  //echo  "alert('[บันทึกข้อมูสำเร็จ]');";
  echo "window.location='form_main.php';";
  echo "</script>";
}


?>




  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">
          <h1>สร้างฟอร์มหลักในการประเมินคะแนนนักศึกษา</h1>


          <a href="show_table.php" class="btn btn-warning">.show_table.php</a>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">สร้างฟอร์มหลัก</li>
          </ol>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>





  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">







          <form id="form1" name="form1" method="post" action="form_main_q.php">

            <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />
            <input name="form_main_confirm" type="hidden" value="<?php echo $form_main_confirm; ?>" />
            
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">กรอกข้อมูลการสร้างฟอร์มหลัก</h3>
              </div>
              <div class="card-body">

                <div class="row">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>สาขา</label>
                      <select name="type_work_id" class="form-control" required>
                        <option value="">-- เลือกสาขา --</option>
                        <?php
                        include "config.inc.php";
                        $sql_type_work = "select  *  from tbl_type_work  ";
                        $query_type_work = $conn->query($sql_type_work);
                        while ($result_type_work = $query_type_work->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $result_type_work['type_work_id']; ?> " <?php if (!(strcmp($result_type_work['type_work_id'], $type_work_id))) {
                                                                                              echo "selected=\"selected\"";
                                                                                            } ?>> <?php echo $result_type_work['type_work_name']; ?> </option>



                        <?php } ?>
                      </select>


                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">ชื่อฟอร์ม / งาน</label>
                      <input type="text" name="form_main_name" class="form-control" id="form_main_name" placeholder="ชื่อฟอร์ม / งาน" value="<?php echo $form_main_name; ?>" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">รูปแบบการประเมิน</label>

                      <select name="form_main_format" class="form-control" required>
                        <option value="" <?php if (!(strcmp("", $form_main_format))) {
                                            echo "selected=\"selected\"";
                                          } ?>>-- เลือกรูปแบบการประเมิน --</option>
                        <option value="1" <?php if (!(strcmp("1", $form_main_format))) {
                                            echo "selected=\"selected\"";
                                          } ?>>รูปแบบบันทึก Record ใหม่ ทุกครั้งที่ประเมิน</option>
                        <option value="2" <?php if (!(strcmp("2", $form_main_format))) {
                                            echo "selected=\"selected\"";
                                          } ?>>รูปแบบประเมิน Record เดิม เป็นการอัพเดทข้อมูล</option>
                      </select>

                    </div>
                  </div>


                </div>

                <div class="row">

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">ประเภทฟอร์ม</label>
                      <select name="form_main_type" class="form-control" required>
                        <option value="" <?php if (!(strcmp("", $form_main_type))) {
                                            echo "selected=\"selected\"";
                                          } ?>>-- เลือกประเภทฟอร์ม --</option>
                        <option value="1" <?php if (!(strcmp("1", $form_main_type))) {
                                            echo "selected=\"selected\"";
                                          } ?>>ฟอร์มประเมิน (แบบมีผู้ป่วย)</option>
                        <option value="2" <?php if (!(strcmp("2", $form_main_type))) {
                                            echo "selected=\"selected\"";
                                          } ?>>ฟอร์มประเมิน (กรณีไม่มีผู้ป่วย)</option>
                      </select>

                    </div>
                  </div>



                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">สถานะฟอร์ม</label>
                      <select name="form_main_status" class="form-control" required>
                        <option value="" <?php if (!(strcmp("", $form_main_status))) {
                                            echo "selected=\"selected\"";
                                          } ?>>-- เลือกสถานะฟอร์ม --</option>
                        <option value="Y" <?php if (!(strcmp("Y", $form_main_status))) {
                                            echo "selected=\"selected\"";
                                          } ?>>ใช้งานอยู่ในปัจุบัน</option>
                        <option value="N" <?php if (!(strcmp("N", $form_main_status))) {
                                            echo "selected=\"selected\"";
                                          } ?>>ไม่ใช้งานแล้ว ยกเลิก ไม่มีการประเมินแล้ว</option>
                      </select>

                    </div>
                  </div>


                  <?php if (isset($_GET['edit'])) {
                    $readonly = "readonly";
                  } else {
                    $readonly = "";
                  } ?>



                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">ชื่อ Table</label>
                      <input type="text" name="form_main_table" class="form-control" id="form_main_table" placeholder="ชื่อ Table" value="<?php echo $form_main_table; ?>" <?php echo $readonly; ?>> 
                    </div>
                  </div>




                  <div class="col-sm-12">


                    <?php
                    $array_form_main_detail = json_decode($form_main_detail, true);
                    $map = [
                      "t" => "tooth",
                      "s" => "surface",
                      "r" => "root",
                      "c" => "class"
                    ];
                    ?>

                    <div class="select2-purple">
                      <select name="form_main_detail[]" class="select2" multiple="multiple" data-placeholder=" Detail" data-dropdown-css-class="select2-purple" style="width: 100%;">
                        <!--
                      <option value="t" selected >tooth</option>
                      <option value="s">surface</option>
                      <option value="r">root</option>
                      <option value="c">class</option>
                      -->
                        <?php
                        foreach ($map as $ok => $ov) {
                          echo "<option value='{$ok}' " . (in_array($ok, $array_form_main_detail) ? " selected " : " ") . " >{$ov}</option>";
                        }

                        ?>
                      </select>
                    </div>
                  </div>


                </div>



                <div class="card-footer">

                  <?php if (isset($_GET['edit'])) { ?>

                    <input type="submit" name="Submit" class="btn btn-info" value="แก้ไขฟอร์ม" />
                    <a href="form_main.php" class="btn btn-danger"> ยกเลิก </a>
                  <?php } else { ?>

                    <input type="submit" name="Submit" class="btn btn-info" value="สร้างฟอร์ม" />


                  <?php } ?>

                  <input type="reset" name="Submit2" class="btn btn-primary" value="reset" />

                </div>


              </div>

          </form>

        </div>


<?php
if (!empty($_GET['type_work_id'])) {
   
    $_SESSION["main_type_work_id"] = $_GET['type_work_id'];

} else {
   
    $_SESSION["main_type_work_id"] = 1;
}


$main_type_work_id = $_SESSION["main_type_work_id"];

?>




        <div class="card">
          <div class="card-header">
            <h3 class="card-title">รายการฟอร์มประเมินคะแนน</h3>
          </div>

          <div class="card-header">
            <form name="myForm1" id="myForm1" action="" method="GET">
              
              <select name="type_work_id" id="type_work_id" class="form-control select2" onchange="this.form.submit()" required>
                <option value=""> เลือก งานของสาขา </option>
                <?php

               
                include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                $sql_type_work = "SELECT * FROM tbl_type_work";
                $query_type_work = $conn->query($sql_type_work);
                while ($result_type_work = $query_type_work->fetch_assoc()) {
                ?>
                  <option value="<?php echo $result_type_work['type_work_id']; ?>" <?php if (!(strcmp($result_type_work['type_work_id'], $main_type_work_id))) {
                                                                                      echo "selected=\"selected\"";
                                                                                    } ?>>
                    <?php echo $result_type_work['type_work_name']; ?>
                  </option>
                <?php
                }
                ?>
              </select>
            </form>
          </div>
          <!-- /.card-header -->
          <div class="card-body">


            <div class="table-responsive-lg">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ลำดับที่</th>
                    <th>สาขา</th>
                    <th>ชื่อฟอร์ม/งาน(s)</th>
                    <th>Detail</th>
                    <th>Type</th>
                    <th>สถานะฟอร์ม</th>
                    <th>Table</th>
                    <th>form_main_format</th>
                    <th>form confirm</th>       
                    <th>ข้อมูลประเมิน</th>
                    <th>จัดการข้อมูล</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  include "config.inc.php";
                  $sql_form_main = "SELECT * FROM tbl_form_main , tbl_type_work where tbl_form_main.type_work_id=tbl_type_work.type_work_id and tbl_type_work.type_work_id = $main_type_work_id";
                  $query_form_main = $conn->query($sql_form_main);
                  $i = 0;
                  while ($row_form_main = $query_form_main->fetch_assoc()) {
                    $i++;
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row_form_main['type_work_name']; ?> </td>
                      <td><?php echo $row_form_main['form_main_name']; ?></td>
                      <td><?php echo $row_form_main['form_main_detail']; ?></td>
                      <td><?php echo $row_form_main['form_main_type']; ?></td>
                      <td><?php echo $row_form_main['form_main_status']; ?></td>
                      <td><?php echo $row_form_main['form_main_table']; ?></td>
                      <td><?php echo $row_form_main['form_main_format']; ?></td>
                      
                      <td><?php echo $row_form_main['form_main_confirm']; ?></td>
                      <td>
                        <a href="form_main_detail.php?form_main_id=<?php echo $row_form_main['form_main_id']; ?>" class="btn btn-info">ขั้นตอนการประเมิน</a>
                        <!--  <a href="form_detail.php?form_main_id=<?php echo $row_form_main['form_main_id']; ?>" class="btn btn-warning">ดูตัวอย่าง</a> -->
                      </td>


                      <td>
                        <?php if ($row_form_main['form_main_confirm'] == 1) {
                        } else { ?>
                          <a href="?del=<?php echo $row_form_main['form_main_id']; ?>&form_main_table=<?php echo $row_form_main['form_main_table']; ?>" class="btn btn-danger" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> </a>
                        <?php } ?>

                        <a href="?edit=<?php echo $row_form_main['form_main_id']; ?>" class="btn btn-info"> <i class="fas fa-edit"></i></a>
                      </td>

                    </tr>
                  <?php } ?>


                </tbody>

              </table>

            </div>


          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

















      </div>
    </div>
</div>
</section>









<?php include 'footer.php'; ?>


<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<!-- page script -->
<script>
  $(function() {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
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






<script type="text/javascript">
  $(document).ready(function() {
    $('#type_work_id').change(function() {
      $.ajax({
        type: 'POST',
        data: {
          type_work_id: $(this).val()
        },
        url: 'select_plan.php',
        success: function(data) {
          $('#plan_id').html(data);
        }
      });
      return false;
    });
  });
</script>


</body>

</html>