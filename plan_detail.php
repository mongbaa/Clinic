<?php include "header.php"; 

if(isset($_GET['type_work_id'])){


  $type_work_id  = $_GET['type_work_id'];

}else{

  $type_work_id  = '';

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



  <section class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-8">
          <h1>ข้อมูลงานทั้งหมดที่มีการเชื่อมโยงฟอร์มแล้ว</h1>
        </div>

        <div class="col-sm-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
            <li class="breadcrumb-item active"> TBL FROM</li>
          </ol>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>



  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">



      <div class="card card-default color-palette-box">


        <div class="card-header">
          <h3 class="card-title"> <i class="fas fa-search"></i> เลือกสาขา </h3>
        </div>



        <div class="card-body">



          <form name="form1" method="GET" action="" enctype="multipart/form-data">


            <div class="row">



              <div class="col-sm-2">
                <select name="type_work_id" id="select" class="form-control">
                  <option value=""> -- สาขาวิชา -- <?php echo $type_work_id; ?></option>
                  <?PHP
                  include "config.inc.php";
                  $sql_type_work = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                  $query_type_work = $conn->query($sql_type_work);
                  while ($result_type_work  = $query_type_work->fetch_assoc()) {
                  ?>
                    <option value="<?= $result_type_work['type_work_id']; ?>" <?php if ($type_work_id == $result_type_work['type_work_id']) {
                                                                              echo "selected";
                                                                            } ?>><?= $result_type_work['type_work_name']; ?></option>
                  <?php } ?>
                </select>
              </div>



              <div class="col-sm-2">

                <input type="submit" name="submit" class="btn btn-primary" id="button" value="ค้นหา">

              </div>

            </div>
          </form>


        </div><!-- /.card-body -->

      </div><!-- /.card -->



      <div class="card card-default color-palette-box">


        <div class="card-header">
          <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูลงาน เชื่อมโยง ฟอร์ม </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">

            <?PHP
          
            include "config.inc.php";
            $sql = " SELECT p.* , t.* , f.*";

            if (!empty($type_work_id)) {
              $sql  .=  " FROM (SELECT * FROM tbl_plan where type_work_id = $type_work_id) as p ";
            } else {
              $sql  .=  " FROM (SELECT * FROM tbl_plan ) as p ";
            }
            $sql  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
            $sql  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
            $sql  .=  " ORDER BY p.plan_id ASC ";
            $query = $conn->query($sql);
            while ($result = $query->fetch_assoc()) {

              $form_main_table = $result['form_main_table'];

              $sql_tb  =  " SELECT COUNT( {$form_main_table}_id ) AS count_row, MAX( last_date ) AS max_last_date ";
              $sql_tb  .= " FROM tbl_{$form_main_table} ";
              $sql_tb  .= " ORDER BY {$form_main_table}_id DESC ";
              $query_tb = $conn->query($sql_tb);
              $result_tb = $query_tb->fetch_assoc();

            ?>



              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">

                  <span class="info-box-icon bg-info elevation-1">
                    <a href="form_detail.php?form_main_id=<?php echo $result['form_main_id']; ?>" target="_blank">
                      <i class="fas fa-cog"></i>
                    </a>
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text"><?php echo $result['type_work_name']; ?> (<?php echo $result_tb['max_last_date']; ?>)</span>
                    <span class="info-box-text"> <small> <?php echo $result['plan_name']; ?> (<?php echo number_format($result_tb['count_row']); ?>) </small> </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->




            <?php } ?>


          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->


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

<!-- page script -->

</body>

</html>