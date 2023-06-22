<?php include "header.php"; ?>

<!-- Google Font: Source Sans Pro -->
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

    $sql_edit = "SELECT * FROM tbl_update_version where update_version_id='$_GET[edit]' ";
    $query_edit = $conn->query($sql_edit);
    $result_edit = $query_edit->fetch_assoc();

    $update_version_id = $result_edit['update_version_id'];
    $update_version_detail = $result_edit['update_version_detail'];
    $update_version_date = $result_edit['update_version_date'];
} else {

    $update_version_id = "";
    $update_version_detail = "";
    $update_version_date = "";
}

if (isset($_GET['del'])) {

    include "config.inc.php";
    $sql_del = "DELETE FROM tbl_update_version WHERE tbl_update_version.update_version_id = $_GET[del]";
    $conn->query($sql_del);

    echo "<script type='text/javascript'>";
    // echo "alert('[บันทึกข้อมูสำเร็จ]');";
    echo "window.location='update_version.php';";
    echo "</script>";
}

?>



<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>UPDATE_VERSION</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Data update_version</li>
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
                            <h3 class="card-title">เพิ่มข้อมูล update_version </h3>

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
                                    <h3 class="card-title"> เพิ่มข้อมูล update_version</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">


                                    <div class="row">


                                        <input name="update_version_id" type="hidden" value="<?php echo $update_version_id; ?>" />



 



                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label>เรื่อง</label>
                                                <div class="mb-3">
                                                <textarea name="update_version_detail" rows="20" class="textarea" style="width: 100%; height: 200%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 20px;" placeholder="เรื่อง"><?php echo $update_version_detail; ?></textarea>
                                                </div>
                                               <!-- <input type="text" name="update_version_detail" class="form-control" placeholder="เรื่อง" value="<?php echo $update_version_detail; ?>" required> -->
                                            </div>
                                        </div>





                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>วันที่</label>
                                                <input type="date" name="update_version_date" class="form-control" placeholder="วันที่" value="<?php echo $update_version_date; ?>" required>
                                            </div>
                                        </div>







                                    </div>

                                </div><!-- /.card-body -->

                                <div class="card-footer text-muted">
                                    <div class="col-sm-12">
                                        <div class="form-group">

                                            <?php if (isset($_GET['edit'])) { ?>
                                                <button name="submit" type="submit" value="submit" class="btn btn-info">
                                                    Edit</button>
                                                <a href="?" class="btn btn-default"></i> Cancel </a>
                                            <?php } else { ?>
                                                <button name="submit" type="submit" value="submit" class="btn btn-info">
                                                    Submit </button>
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



                    if (isset($_POST['update_version_id'])  && !empty($_POST['update_version_id'])) {
                        $update_version_id = $conn->real_escape_string($_POST['update_version_id']);
                    } else {
                        $update_version_id = 0;
                    }

                    if (isset($_POST['update_version_detail'])  && !empty($_POST['update_version_detail'])) {
                        $update_version_detail = $conn->real_escape_string($_POST['update_version_detail']);
                    } else {
                        $update_version_detail = '';
                    }

                    if (isset($_POST['update_version_date'])  && !empty($_POST['update_version_date'])) {
                        $update_version_date = $conn->real_escape_string($_POST['update_version_date']);
                    } else {
                        $update_version_date = '';
                    }




                    if (!empty($update_version_id)) {

                        $sql_up = "UPDATE tbl_update_version SET update_version_detail = '$update_version_detail', update_version_date = '$update_version_date' WHERE  update_version_id = '$update_version_id'";
                        $conn->query($sql_up);
                    } else {

                        $sql_in = " INSERT INTO tbl_update_version (update_version_id,update_version_detail,update_version_date) VALUES (NULL,'$update_version_detail','$update_version_date')";
                        $conn->query($sql_in);
                    }



                    echo "<script type='text/javascript'>";
                    echo "alert('[บันทึกข้อมูสำเร็จ]');";
                    echo "window.location='update_version.php';";
                    echo "</script>";
                }

                ?>















                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Data UPDATE_VERSION</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <th>เรื่อง</th>
                                    <th>วันที่</th>
                                    <th>จัดการข้อมูล</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?PHP include "config.inc.php";
                                $sql = " SELECT * FROM tbl_update_version as update_version ";
                                $sql .= " ORDER BY update_version.update_version_id ASC ";
                                $query = $conn->query($sql);
                                $i = 0;
                                while ($result = $query->fetch_assoc()) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                        <td><?php echo $result['update_version_detail']; ?> </td>
                                        <td><?php echo $result['update_version_date']; ?> </td>
                                        <td>
                                            <a href="?edit=<?php echo $result['update_version_id']; ?>" class="btn btn-info">
                                                <i class="fas fa-edit"></i> Edit </a>
                                            <a href="?del=<?php echo $result['update_version_id']; ?>" class="btn btn-danger" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> Delete </a>
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