<?php include "header.php"; ?>


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
    if (isset($_GET['edit'])) {

        include "config.inc.php";

        $sql_edit = "SELECT * FROM tbl_staff where staff_id='$_GET[edit]' ";
        $query_edit = $conn->query($sql_edit);
        $result_edit = $query_edit->fetch_assoc();

        $staff_id = $result_edit['staff_id'];
        $staff_doctorcode = $result_edit['staff_doctorcode'];
        $staff_loginname = $result_edit['staff_loginname'];
        $staff_name = $result_edit['staff_name'];
        $staff_surname = $result_edit['staff_surname'];
        $staff_level = $result_edit['staff_level'];
        $staff_status = $result_edit['staff_status'];
        $staff_log = $result_edit['staff_log'];

    } else {

        $staff_id = "";
        $staff_doctorcode = "";
        $staff_loginname = "";
        $staff_name = "";
        $staff_surname = "";
        $staff_level = "";
        $staff_status = "";
        $staff_log = "";

    }
?>







    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-8">
                    <h1>Data staff</h1>
                </div>

                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                        <li class="breadcrumb-item student_active">Data staff</li>
                    </ol>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">





            <form name="form1" method="post" action="">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">staff </h3>

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
                                <h3 class="card-title"> staff</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">


                                <div class="row">

                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

                                    <input name="staff_id" type="hidden" value="<?php echo $staff_id; ?>" />





                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Doctorcode</label>
                                            <input type="text" name="staff_doctorcode" class="form-control" placeholder="Doctorcode" value="<?php echo $staff_doctorcode; ?>" required>
                                        </div>
                                    </div>





                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Loginname</label>
                                            <input type="text" name="staff_loginname" class="form-control" placeholder="Loginname" value="<?php echo $staff_loginname; ?>" required>
                                        </div>
                                    </div>





                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ชื่อ</label>
                                            <input type="text" name="staff_name" class="form-control" placeholder="ชื่อ" value="<?php echo $staff_name; ?>" required>
                                        </div>
                                    </div>





                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>นามสกุล</label>
                                            <input type="text" name="staff_surname" class="form-control" placeholder="นามสกุล" value="<?php echo $staff_surname; ?>" required>
                                        </div>
                                    </div>





                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>level</label>
                                            <select name="staff_level" id="staff_level" class="form-control select2" required>
                                                <option value=""> level </option>
                                                <option value="1" <?php if (!(strcmp(1, $staff_level))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>
                                                    เจ้าหน้าที่คลินิก</option>
                                                    <option value="2" <?php if (!(strcmp(2, $staff_level))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>
                                                    เจ้าหน้าที่สาขา</option>
                                                    <option value="3" <?php if (!(strcmp(3, $staff_level))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>
                                                    เจ้าหน้าที่ทะเบียน</option>
                                            </select>
                                        </div>
                                    </div>





                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>สถานะ</label>
                                            <select name="staff_status" id="staff_status" class="form-control select2" required>
                                                <option value="">  สถานะ </option>
                                                <option value="0" <?php if (!(strcmp(0, $staff_status))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>
                                                    ปิดการใช้งาน</option>
                                                <option value="1" <?php if (!(strcmp(1, $staff_status))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>
                                                    เปิดการใช้งาน</option>
                                            </select>
                                        </div>
                                    </div>





                                    <input name="staff_log" type="hidden" value="<?php echo $staff_log; ?>" />







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

                if (isset($_POST['staff_id'])  && !empty($_POST['staff_id'])) {
                    $staff_id = $conn->real_escape_string($_POST['staff_id']);
                } else {
                    $staff_id = 0;
                }

                if (isset($_POST['staff_doctorcode'])  && !empty($_POST['staff_doctorcode'])) {
                    $staff_doctorcode = $conn->real_escape_string($_POST['staff_doctorcode']);
                } else {
                    $staff_doctorcode = '';
                }

                if (isset($_POST['staff_loginname'])  && !empty($_POST['staff_loginname'])) {
                    $staff_loginname = $conn->real_escape_string($_POST['staff_loginname']);
                } else {
                    $staff_loginname = '';
                }

                if (isset($_POST['staff_name'])  && !empty($_POST['staff_name'])) {
                    $staff_name = $conn->real_escape_string($_POST['staff_name']);
                } else {
                    $staff_name = '';
                }

                if (isset($_POST['staff_surname'])  && !empty($_POST['staff_surname'])) {
                    $staff_surname = $conn->real_escape_string($_POST['staff_surname']);
                } else {
                    $staff_surname = '';
                }

                if (isset($_POST['staff_level'])  && !empty($_POST['staff_level'])) {
                    $staff_level = $conn->real_escape_string($_POST['staff_level']);
                } else {
                    $staff_level = 0;
                }

                if (isset($_POST['staff_status'])  && !empty($_POST['staff_status'])) {
                    $staff_status = $conn->real_escape_string($_POST['staff_status']);
                } else {
                    $staff_status = 0;
                }

                if (isset($_POST['staff_log'])  && !empty($_POST['staff_log'])) {
                    $staff_log = $conn->real_escape_string($_POST['staff_log']);
                } else {
                    $staff_log = '';
                }



                if (!empty($staff_id)) {

                    $sql_up = "UPDATE tbl_staff SET staff_doctorcode = '$staff_doctorcode', staff_loginname = '$staff_loginname', staff_name = '$staff_name', staff_surname = '$staff_surname', staff_level = '$staff_level', staff_status = '$staff_status', staff_log = '$staff_log' WHERE  staff_id = '$staff_id'";
                    $conn->query($sql_up);

                } else {

                    $sql_in = " INSERT INTO tbl_staff (staff_id,staff_doctorcode,staff_loginname,staff_name,staff_surname,staff_level,staff_status,staff_log) VALUES (NULL,'$staff_doctorcode','$staff_loginname','$staff_name','$staff_surname','$staff_level','$staff_status','$staff_log')";
                    $conn->query($sql_in);

                }



                echo "<script type='text/javascript'>";
                //echo "alert('[OK]');";
                echo "window.location='staff.php';";
                echo "</script>";
            }

            ?>












            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> Data STAFF
                    <a href="staff_input.php" class="btn btn-danger" onclick="return confirm('กรุณายืนยันอีกครั้ง !!!')"> + นำเข้ารายชื่อเจ้าหน้าที่ </a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <th>Doctorcode</th>
                                <th>Loginname</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>level</th>
                                <th>สถานะ</th>
                                <th>log</th>
                                <th>จัดการข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?PHP include "config.inc.php";
                            $sql = " SELECT * FROM tbl_staff as staff ";
                            $sql .= " ORDER BY staff.staff_id ASC ";
                            $query = $conn->query($sql);
                            $i = 0;
                            while ($result = $query->fetch_assoc()) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <td><?php echo $result['staff_doctorcode']; ?> </td>
                                    <td><?php echo $result['staff_loginname']; ?> </td>
                                    <td><?php echo $result['staff_name']; ?> </td>
                                    <td><?php echo $result['staff_surname']; ?> </td>
                                    <td>
                                        <?php
                                        $manage_store_status = $result['staff_level'];
                                        switch ($manage_store_status) { // Harder page
                                            case 1:
                                                echo  "เจ้าหน้าที่คลินิก";
                                                break;
                                                case 2:
                                                    echo  "เจ้าหน้าที่สาขา";
                                                    break;
                                                    case 3:
                                                        echo  "เจ้าหน้าที่ทะเบียน";
                                                        break;
                                            default:
                                                echo  "-";
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $manage_store_status = $result['staff_status'];
                                        switch ($manage_store_status) { // Harder page
                                            case 0:
                                                echo  "ปิดการใช้งาน";
                                                break;
                                            case 1:
                                                echo  "เปิดการใช้งาน";
                                                break;
                                            default:
                                                echo  "-";
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $result['staff_log']; ?> </td>
                                    <td>
                                        <a href="?edit=<?php echo $result['staff_id']; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> Edit </a>
                                        <a href="?del=<?php echo $result['staff_id']; ?>" class="btn btn-danger" onClick="return confirm('à¸à¸£à¸¸à¸“à¸²à¸¢à¸·à¸™à¸¢à¸±à¸™à¸à¸²à¸£à¸¥à¸šà¸­à¸µà¸à¸„à¸£à¸±à¹‰à¸‡ !!!')">
                                            <i class="fas fa-trash-alt"></i> Delete </a>
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


<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            "paging": true,
            "pageLength": 50,
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

</body>

</html>