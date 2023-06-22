<?php include "header.php"; ?>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">



<?php

if (isset($_GET['edit'])) {

  include "config.inc.php";

  $sql_edit = "SELECT * FROM tbl_report_date where report_date_id='$_GET[edit]' ";
  $query_edit = $conn->query($sql_edit);
  $result_edit = $query_edit->fetch_assoc();

  $report_date_id = $result_edit['report_date_id'];
  $report_date_code = $result_edit['report_date_code'];
  $report_date_year = $result_edit['report_date_year'];
  $report_date_start = $result_edit['report_date_start'];
  $report_date_end = $result_edit['report_date_end'];
} else {

  $report_date_id = "";
  $report_date_code = "";
  $report_date_year = "";
  $report_date_start = "";
  $report_date_end = "";
}

if (isset($_GET['del'])) {

  include "config.inc.php";
  $sql_del = "DELETE FROM tbl_report_date WHERE tbl_report_date.report_date_id = $_GET[del]";
  $conn->query($sql_del);

  echo "<script type='text/javascript'>";
  // echo "alert('[บันทึกข้อมูสำเร็จ]');";
  echo "window.location='report_date.php';";
  echo "</script>";
}

?>



<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>REPORT_DATE ตั้งค่าวันที่เพื่อดึงรายงาน ตามชั้นปี </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Data report_date</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>



<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">




        <form name="form1" method="post" action="">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">เพิ่มข้อมูล report_date </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">


              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> เพิ่มข้อมูล report_date</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">


                  <div class="row">


                    <input name="report_date_id" type="hidden" value="<?php echo $report_date_id; ?>" />







                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>รหัส นทพ. 2 ตัวแรก</label>
                        <input type="text" name="report_date_code" class="form-control" placeholder="รหัส นทพ. 2 ตัวแรก" value="<?php echo $report_date_code; ?>" required>
                      </div>
                    </div>





                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>ชั้นปี</label>
                        <select name="report_date_year" id="report_date_year" class="form-control select2" required>
                          <option value=""> เลือก ชั้นปี </option>
                          <option value="4" <?php if (!(strcmp(4, $report_date_year))) {
                                              echo "selected=\"selected\"";
                                            } ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $report_date_year))) {
                                              echo "selected=\"selected\"";
                                            } ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $report_date_year))) {
                                              echo "selected=\"selected\"";
                                            } ?>>6</option>
                        </select>
                      </div>
                    </div>





                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>วันที่เริ่มต้น</label>
                        <input type="date" name="report_date_start" class="form-control" placeholder="วันที่เริ่มต้น" value="<?php echo $report_date_start; ?>" required>
                      </div>
                    </div>





                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>วันที่สิ้นสุด</label>
                        <input type="date" name="report_date_end" class="form-control" placeholder="วันที่สิ้นสุด" value="<?php echo $report_date_end; ?>" required>
                      </div>
                    </div>







                  </div>

                </div><!-- /.card-body -->

                <div class="card-footer text-muted">
                  <div class="col-sm-12">
                    <div class="form-group">

                      <?php if (isset($_GET['edit'])) { ?>
                        <button name="submit" type="submit" value="submit" class="btn btn-info"> Edit</button>
                        <a href="?" class="btn btn-default"></i> Cancel </a>
                      <?php } else { ?>
                        <button name="submit" type="submit" value="submit" class="btn btn-info"> Submit </button>
                        <button type="reset" class="btn btn-default"> Reset </button>
                      <?php } ?>

                    </div>
                  </div>

                </div>


              </div>
              <!-- /.card -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card card-secondary -->

        </form>

        <?php

        if (isset($_POST['submit'])) {
          include "config.inc.php";



          if (isset($_POST['report_date_id'])  && !empty($_POST['report_date_id'])) {
            $report_date_id = $conn->real_escape_string($_POST['report_date_id']);
          } else {
            $report_date_id = 0;
          }

          if (isset($_POST['report_date_code'])  && !empty($_POST['report_date_code'])) {
            $report_date_code = $conn->real_escape_string($_POST['report_date_code']);
          } else {
            $report_date_code = 0;
          }

          if (isset($_POST['report_date_year'])  && !empty($_POST['report_date_year'])) {
            $report_date_year = $conn->real_escape_string($_POST['report_date_year']);
          } else {
            $report_date_year = 0;
          }

          if (isset($_POST['report_date_start'])  && !empty($_POST['report_date_start'])) {
            $report_date_start = $conn->real_escape_string($_POST['report_date_start']);
          } else {
            $report_date_start = '';
          }

          if (isset($_POST['report_date_end'])  && !empty($_POST['report_date_end'])) {
            $report_date_end = $conn->real_escape_string($_POST['report_date_end']);
          } else {
            $report_date_end = '';
          }




          if (!empty($report_date_id)) {

            $sql_up = "UPDATE tbl_report_date SET report_date_code = '$report_date_code', report_date_year = '$report_date_year', report_date_start = '$report_date_start', report_date_end = '$report_date_end' WHERE  report_date_id = '$report_date_id'";
            $conn->query($sql_up);
          } else {

            $sql_in = " INSERT INTO tbl_report_date (report_date_id,report_date_code,report_date_year,report_date_start,report_date_end) VALUES (NULL,'$report_date_code','$report_date_year','$report_date_start','$report_date_end')";
            $conn->query($sql_in);
          }



          echo "<script type='text/javascript'>";
          echo "alert('[บันทึกข้อมูสำเร็จ]');";
          echo "window.location='report_date.php';";
          echo "</script>";
        }

        ?>















        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> Data REPORT_DATE</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>รหัส นทพ. 2 ตัวแรก</th>
                  <th>ชั้นปี</th>
                  <th>วันที่เริ่มต้น</th>
                  <th>วันที่สิ้นสุด</th>
                  <th>จัดการข้อมูล</th>
                </tr>
              </thead>
              <tbody>

                <?PHP include "config.inc.php";
                $sql = " SELECT * FROM tbl_report_date as report_date ";
                $sql .= " ORDER BY report_date.report_date_id ASC ";
                $query = $conn->query($sql);
                $i = 0;
                while ($result = $query->fetch_assoc()) {
                  $i++;
                ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['report_date_code']; ?> </td>
                    <td>
                      <?php
                      $manage_store_status = $result['report_date_year'];
                      switch ($manage_store_status) { // Harder page
                        case 4:
                          echo  "4";
                          break;
                        case 5:
                          echo  "5";
                          break;
                        case 6:
                          echo  "6";
                          break;
                        default:
                          echo  "-";
                          break;
                      }
                      ?>
                    </td>
                    <td><?php echo $result['report_date_start']; ?> </td>
                    <td><?php echo $result['report_date_end']; ?> </td>
                    <td>
                      <a href="?edit=<?php echo $result['report_date_id']; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> Edit </a>
                      <a href="?del=<?php echo $result['report_date_id']; ?>" class="btn btn-danger" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> Delete </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div><!-- /.card-body -->

          <!-- /.card-footer-->
        </div>
        <!-- /.card -->




      </div>
      <!-- /.col-12 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->


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
<!-- AdminLTE App -->

<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>



<!-- Page specific script -->
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "ordering": true,
      "paging": true,
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




<!-- Page specific script -->
<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
</script>