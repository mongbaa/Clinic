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




<section class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-8">
                <h1>ข้อมูลงาน / Plan</h1>
            </div>

            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                    <li class="breadcrumb-item active">สร้างรายการ</li>
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
                <h3 class="card-title"> <i class="fas fa-plus"></i> ข้อมูลงาน / Plan </h3>
            </div>



            <div class="card-body">
                <?php

                if (isset($_GET['edit'])) {
                    include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                    $plan_id = $_GET['edit'];
                    $sql_edit = "SELECT * FROM tbl_plan where plan_id=$plan_id ";
                    $query_edit = $conn->query($sql_edit);
                    $result_edit = $query_edit->fetch_assoc();

                    $plan_name = $result_edit['plan_name'];
                    $type_work_id = $result_edit['type_work_id'];
                    $form_main_id = $result_edit['form_main_id'];
                    // $plan_sub=$result_edit['plan_sub'];

                } else {

                    $plan_name = "";
                    $type_work_id = "";
                    $form_main_id = "";
                    $plan_sub = "";
                }


                if (isset($_GET['del'])) {
                    include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                    $plan_id = $_GET['del'];
                    $sql_del = "DELETE FROM tbl_plan WHERE tbl_plan.plan_id = $plan_id";
                    $conn->query($sql_del);
                    echo "<script type='text/javascript'>";
                    //echo  "alert('บันทึกสำเร็จ');";
                    echo "window.location='plan.php'";
                    echo "</script>";
                }
                ?>




                <form name="form1" method="post" action="" enctype="multipart/form-data">

                    <input type="hidden" name="plan_id" value="<?php echo @$result_edit['plan_id']; ?>">

                    <div class="row">



                        <div class="col-sm-2">
                            <select name="type_work_id" id="select" class="form-control" required>
                                <option value=""> -- สาขาวิชา -- <?php echo $type_work_id; ?></option>
                                <?PHP
                                include "config.inc.php";
                                $sql_type_work = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                                $query_type_work = $conn->query($sql_type_work);
                                while ($result_type_work  = $query_type_work->fetch_assoc()) {
                                ?>
                                    <option value="<?= $result_type_work['type_work_id']; ?>" <?php if ($type_work_id == $result_type_work['type_work_id']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                        <?= $result_type_work['type_work_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>





                        <div class="col-sm-3">
                            <input type="text" name="plan_name" class="form-control" value="<?php echo $plan_name; ?>" placeholder="ชื่องาน" required>
                        </div>


                        <!-- /.card-body 
<div class="col-sm-2">
<select name="plan_sub" id="select" class="form-control">
<option value=""> -- งานย่อย -- </option>
<option value="0" <?php if (0 == $plan_sub) {
                        echo "selected";
                    } ?>> NO</option>
<option value="1" <?php if (1 == $plan_sub) {
                        echo "selected";
                    } ?>> YES SUB </option>

</select>
</div>-->



                        <?php if (isset($_GET['edit'])) { ?>
                            <div class="col-sm-2">
                                <div class="input-group my-colorpicker2">

                                    <select name="form_main_id" id="select" class="form-control">
                                        <option value="0"> -- ฟอร์มเชื่อมโยง -- </option>
                                        <?PHP

                                        include "config.inc.php";
                                        $sql_form_main = "SELECT * FROM tbl_form_main where   type_work_id=$type_work_id and form_main_confirm=1  ORDER BY tbl_form_main.form_main_id ASC ";
                                        $query_form_main = $conn->query($sql_form_main);
                                        while ($result_form_main  = $query_form_main->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $result_form_main['form_main_id']; ?>" <?php if ($result_form_main['form_main_id'] == $form_main_id) {
                                                                                                                echo "selected";
                                                                                                            } ?>>
                                                <?php echo $result_form_main['form_main_name']; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>


                        <?php } ?>




                        <div class="col-sm-2">

                            <?php if (isset($_GET['edit'])) { ?>

                                <input type="submit" name="submit" class="btn btn-info" id="button" value="แก้ไข">
                                <a href="?" class="btn btn-danger"> ยกเลิก </a>

                            <?php } else { ?>
                                <input type="submit" name="submit" class="btn btn-primary" id="button" value="เพิ่ม">
                            <?php } ?>
                        </div>

                    </div>
                </form>
                <?php

                if (isset($_POST['submit'])) {
                    include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 

                    if ($_POST['plan_id'] != "") {

                        $sql_update = "UPDATE tbl_plan SET type_work_id = '$_POST[type_work_id]' , plan_name = '$_POST[plan_name]' ,  form_main_id='$_POST[form_main_id]'   WHERE tbl_plan.plan_id = $_POST[plan_id]";
                        $conn->query($sql_update);

                        echo "<script type='text/javascript'>";
                        echo  "alert('บันทึกสำเร็จ');";
                        echo "window.location='plan.php'";
                        echo "</script>";
                    } else {


                        $sql_insert = "INSERT INTO tbl_plan (plan_id, type_work_id, plan_name, form_main_id ,plan_status) VALUES (NULL, '$_POST[type_work_id]' , '$_POST[plan_name]' , '0', 1 )";
                        $conn->query($sql_insert);
                        $plan_id = $conn->insert_id;

                        echo "<script type='text/javascript'>";
                        echo  "alert('บันทึกสำเร็จ');";
                        echo "window.location='plan.php?edit=$plan_id'";
                        echo "</script>";
                    }
                }
                ?>

            </div><!-- /.card-body -->

        </div><!-- /.card -->



        <div class="card card-default color-palette-box">


            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูลงาน เชื่อมโยง ฟอร์ม <a href="plan_detail.php" class="btn btn-info"> Plan All </a> </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <div align="center">ลำดับที่</div>
                            </th>
                            <th>สาขา</th>
                            <th>ชื่องาน</th>
                            <th>ชื่อฟอร์ม</th>
                            <th>จัดการข้อมูล</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?PHP
                        include "config.inc.php";
                        $sql   =  " SELECT * FROM tbl_plan as p ";
                        $sql  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                        $sql  .=  " LEFT  JOIN  tbl_form_main   AS f  ON  f.form_main_id = p.form_main_id ";
                        $sql  .=  " ORDER BY p.plan_id ASC ";
                        $query = $conn->query($sql);
                        $i = 0;
                        while ($result = $query->fetch_assoc()) {
                            $i++;
                        ?>

                            <tr class="odd gradeX">
                                <td align="center"><?= $i; ?></td>
                                <td><?php echo $result['type_work_name']; ?></td>
                                <td><?php echo $result['plan_name']; ?></td>
                                <td><?php echo $result['form_main_name']; ?></td>
                                <td class="center">



                                    <a href="?del=<?php echo $result['plan_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> ลบ </a>

                                    <a href="?edit=<?php echo $result['plan_id']; ?>" class="btn btn-info"> แก้ไข </a>






                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>

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