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

<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

<?php

if (isset($_GET['edit'])) {

    include "config.inc.php";

    $sql_edit = "SELECT * FROM tbl_support where support_id='$_GET[edit]' ";
    $query_edit = $conn->query($sql_edit);
    $result_edit = $query_edit->fetch_assoc();

    $support_id = $result_edit['support_id'];
    $support_title_id = $result_edit['support_title_id'];
    $support_detail = $result_edit['support_detail'];
    $support_date = $result_edit['support_date'];
    $support_time = $result_edit['support_time'];
    $support_ip = $result_edit['support_ip'];
    $support_level_user = $result_edit['support_level_user'];
    $support_user_id = $result_edit['support_user_id'];
    $support_status = $result_edit['support_status'];
    $support_reply = $result_edit['support_reply'];
    $support_admin_id = $result_edit['support_admin_id'];
    $readonly = "";
} else {

    $support_id = "";
    $support_title_id = "";
    $support_detail = "";
    $support_date = date('Y-m-d');
    $support_time = date('H:i:s');
    $support_ip = $REMOTE_ADDR;
    $support_level_user =  $_SESSION['level_user'];
    $support_user_id = $_SESSION['loginname'];
    $support_status = 0;
    $support_reply = "";
    $support_admin_id = "";

    $readonly = "readonly";
}

if (isset($_GET['del'])) {

    include "config.inc.php";
    $sql_del = "DELETE FROM tbl_support WHERE tbl_support.support_id = $_GET[del]";
    $conn->query($sql_del);

    echo "<script type='text/javascript'>";
    // echo "alert('[บันทึกข้อมูสำเร็จ]');";
    echo "window.location='support.php';";
    echo "</script>";
}

?>



<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1><i class="fas fa-chalkboard-teacher"></i> แจ้งปัญหาการใช้งานระบบ ***ที่เกิดจากการผิดพลาดของระบบเท่านั้น...!!</h1>
            </div>
            <div class="col-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Data support</li>
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




                <form name="form1" method="post" action="" enctype="multipart/form-data">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title"> แจ้งปัญหาการใช้งานระบบ กรอกข้อมูลให้ครบถ้วน</h3>

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
                                    <h3 class="card-title"> เพิ่มข้อมูล support</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">


                                    <div class="row">


                                        <input name="support_id" type="hidden" value="<?php echo $support_id; ?>" />







                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>เรื่องปัญหาที่ต้องการแจ้ง </label>
                                                <select name="support_title_id" id="support_title_id" class="form-control select2" required>
                                                    <option value=""> เลือก เรื่องปัญหาที่ต้องการแจ้ง </option>
                                                    <?php include "config.inc.php";
                                                    $sql_support_title = "SELECT * FROM  tbl_support_title where support_title_status = 1";
                                                    $query_support_title = $conn->query($sql_support_title);
                                                    while ($result_support_title  = $query_support_title->fetch_assoc()) {
                                                    ?>
                                                        <option value="<?php echo $result_support_title['support_title_id']; ?>" <?php if (!(strcmp($result_support_title['support_title_id'], $support_title_id))) {
                                                                                                                                        echo "selected=\"selected\"";
                                                                                                                                    } ?>>
                                                            <?php echo $result_support_title['support_title_name']; ?>
                                                        </option>
                                                    <?php  }  ?>
                                                </select>
                                            </div>
                                        </div>





                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>วันที่</label>
                                                <input type="date" name="support_date" class="form-control" placeholder="วันที่" value="<?php echo $support_date; ?>" <?php echo $readonly; ?>>
                                            </div>
                                        </div>





                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>เวลา</label>
                                                <input type="time" name="support_time" class="form-control" placeholder="เวลา" value="<?php echo $support_time; ?>" <?php echo $readonly; ?>>
                                            </div>
                                        </div>



                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>รายละเอียด</label>
                                                <textarea id="summernote" name="support_detail" class="form-control"><?php echo $support_detail; ?></textarea>
                                            </div>
                                        </div>

                                        <font color="red" size="5px">สามารถ Caption ภาพหน้าจอ โดย กดปุ่มบน Keyboard (Print Sceen) หรือ (Shift + Windows + S) Caption จอภาพ (Ctrl + V) ใน รายละเอียดได้</font>



                                        <input name="support_ip" type="hidden" value="<?php echo $support_ip; ?>" />
                                        <input name="support_level_user" type="hidden" value="<?php echo $support_level_user; ?>" />
                                        <input name="support_user_id" type="hidden" value="<?php echo $support_user_id; ?>" />


                                        <?php //เป็น  ระดับ Admin ระดับ 2
                                        if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 2)) {
                                        ?>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>สถานะ</label>
                                                    <select name="support_status" id="support_status" class="form-control select2" required>
                                                        <option value=""> เลือก สถานะ </option>
                                                        <option value="0" <?php if (!(strcmp(0, $support_status))) {
                                                                                echo "selected=\"selected\"";
                                                                            } ?>>
                                                            รอตรวจสอบ</option>
                                                        <option value="1" <?php if (!(strcmp(1, $support_status))) {
                                                                                echo "selected=\"selected\"";
                                                                            } ?>>
                                                            กำลังดำเนินการ</option>
                                                        <option value="2" <?php if (!(strcmp(2, $support_status))) {
                                                                                echo "selected=\"selected\"";
                                                                            } ?>>
                                                            ดำเนินการสำเร็จ</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>ตอบกลับ</label>
                                                    <input type="text" name="support_reply" class="form-control" placeholder="ตอบกลับ" value="<?php echo $support_reply; ?>" required>
                                                </div>
                                            </div>


                                            <input name="support_admin_id" type="hidden" value="<?php echo $support_user_id; ?>" />

                                        <?php } ?>







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
                                                    ยืนยันการแจ้งปัญหา </button>
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



                    if (isset($_POST['support_id'])  && !empty($_POST['support_id'])) {
                        $support_id = $conn->real_escape_string($_POST['support_id']);
                    } else {
                        $support_id = 0;
                    }

                    if (isset($_POST['support_title_id'])  && !empty($_POST['support_title_id'])) {
                        $support_title_id = $conn->real_escape_string($_POST['support_title_id']);
                    } else {
                        $support_title_id = 0;
                    }

                    /* $support_detail = $_POST['support_detail'];*/

                    if (isset($_POST['support_detail'])  && !empty($_POST['support_detail'])) {
                        $support_detail = $conn->real_escape_string($_POST['support_detail']);
                    } else {
                        $support_detail = '';
                    }

                    if (isset($_POST['support_date'])  && !empty($_POST['support_date'])) {
                        $support_date = $conn->real_escape_string($_POST['support_date']);
                    } else {
                        $support_date = '';
                    }

                    if (isset($_POST['support_time'])  && !empty($_POST['support_time'])) {
                        $support_time = $conn->real_escape_string($_POST['support_time']);
                    } else {
                        $support_time = '';
                    }

                    if (isset($_POST['support_ip'])  && !empty($_POST['support_ip'])) {
                        $support_ip = $conn->real_escape_string($_POST['support_ip']);
                    } else {
                        $support_ip = '';
                    }

                    if (isset($_POST['support_level_user'])  && !empty($_POST['support_level_user'])) {
                        $support_level_user = $conn->real_escape_string($_POST['support_level_user']);
                    } else {
                        $support_level_user = '';
                    }

                    if (isset($_POST['support_user_id'])  && !empty($_POST['support_user_id'])) {
                        $support_user_id = $conn->real_escape_string($_POST['support_user_id']);
                    } else {
                        $support_user_id = 0;
                    }

                    if (isset($_POST['support_status'])  && !empty($_POST['support_status'])) {
                        $support_status = $conn->real_escape_string($_POST['support_status']);
                    } else {
                        $support_status = 0;
                    }

                    if (isset($_POST['support_reply'])  && !empty($_POST['support_reply'])) {
                        $support_reply = $conn->real_escape_string($_POST['support_reply']);
                    } else {
                        $support_reply = '';
                    }

                    if (isset($_POST['support_admin_id'])  && !empty($_POST['support_admin_id'])) {
                        $support_admin_id = $conn->real_escape_string($_POST['support_admin_id']);
                    } else {
                        $support_admin_id = 0;
                    }


                    if (!empty($support_id)) {

                        $sql_up = "UPDATE tbl_support SET support_title_id = '$support_title_id', support_detail = '$support_detail', support_date = '$support_date', support_time = '$support_time', support_ip = '$support_ip', support_level_user = '$support_level_user', support_user_id = '$support_user_id', support_status = '$support_status', support_reply = '$support_reply', support_admin_id = '$support_admin_id' WHERE  support_id = '$support_id'";
                        $conn->query($sql_up);
                    } else {

                        $sql_in = " INSERT INTO tbl_support (support_id,support_title_id,support_detail,support_date,support_time,support_ip,support_level_user,support_user_id,support_status,support_reply,support_admin_id) VALUES (NULL,'$support_title_id','$support_detail','$support_date','$support_time','$support_ip','$support_level_user','$support_user_id','$support_status','$support_reply','$support_admin_id')";
                        $conn->query($sql_in);
                    }


                    echo "<script type='text/javascript'>";
                    echo "alert('[บันทึกข้อมูสำเร็จ]');";
                    echo "window.location='support.php';";
                    echo "</script>";
                }

                ?>








                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Data SUPPORT</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <th>เรื่อง</th>
                                    <th>รายละเอียด</th>
                                    <th>วันที่</th>
                                    <th>เวลา</th>
                                    <th>ip</th>
                                    <th>กลุ่มผู้แจ้ง</th>
                                    <th>รหัสสผู้แจ้ง</th>
                                    <th>สถานะ</th>
                                    <th>ตอบกลับ</th>
                                    <th>จัดการข้อมูล</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?PHP include "config.inc.php";

                                $level_user = $_SESSION['level_user'];
                                $loginname = $_SESSION['loginname'];


                                $sql = " SELECT sp.*, t.* ";
                               
                              
                                if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 2)) {
                                    $sql .= " FROM (SELECT * FROM tbl_support ) AS sp ";
                                }else{

                                    $sql .= " FROM (SELECT * FROM tbl_support where  support_level_user = '$level_user' and  support_user_id = '$loginname' ) AS sp ";
                                }

                                $sql .= " INNER JOIN tbl_support_title as t ON sp.support_title_id = t.support_title_id ";
                                $sql .= " ORDER BY sp.support_id ASC ";
                                $query = $conn->query($sql);
                                $i = 0;
                                while ($result = $query->fetch_assoc()) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                        <td><?php echo $result['support_title_name']; ?> </td>
                                        <td>
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-xl<?php echo $result['support_id'];?>">
                                            รายละเอียด
                                            </button>

                                            <!-- /.modal -->

                                            <div class="modal fade" id="modal-xl<?php echo $result['support_id'];?>">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">รายละเอียด</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <?php echo $result['support_detail']; ?>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->

                                            


                                        </td>
                                        <td><?php echo $result['support_date']; ?> </td>
                                        <td><?php echo $result['support_time']; ?> </td>
                                        <td><?php echo $result['support_ip']; ?> </td>
                                        <td><?php echo $result['support_level_user']; ?> </td>
                                        <td><?php echo $result['support_user_id']; ?> </td>
                                        <td>
                                            <?php
                                            $manage_store_status = $result['support_status'];
                                            switch ($manage_store_status) { // Harder page
                                                case 0:
                                                    echo  "รอตรวจสอบ";
                                                    break;
                                                case 1:
                                                    echo  "กำลังดำเนินการ";
                                                    break;
                                                case 2:
                                                    echo  "ดำเนินการสำเร็จ";
                                                    break;
                                                default:
                                                    echo  "-";
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $result['support_reply']; ?> </td>
                                        <td>

                                        <?php   if ($_SESSION['level_user'] != "Staff")  { ?>
                                            <?php if ($manage_store_status == 0) { ?>
                                                <a href="?edit=<?php echo $result['support_id']; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> Edit </a>
                                                <a href="?del=<?php echo $result['support_id']; ?>" class="btn btn-danger" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> Delete </a>
                                            <?php } ?>
                                        <?php } ?>


                                        <?php   if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 2)) { ?>
                                                <a href="?edit=<?php echo $result['support_id']; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> Edit </a>
                                                <a href="?del=<?php echo $result['support_id']; ?>" class="btn btn-danger" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> Delete </a>
                                        <?php } ?>
                                          
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





<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>

<!-- Page specific script Summernote -->
<script>
    $('#summernote').summernote({
        placeholder: 'รายละเอียด',
        tabsize: 2,
        height: 200
    });
</script>




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