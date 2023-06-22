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
                    <h1>Conduct</h1>
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
                    <h3 class="card-title"> <i class="fas fa-plus"></i> ข้อมูล Conduct </h3>
                </div>



                <div class="card-body">
                    <?php

                    if (isset($_GET['edit'])) {

                        include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                        $form_conduct_id = $_GET['edit'];
                        $sql_edit = "SELECT * FROM tbl_form_conduct where form_conduct_id=$form_conduct_id ";
                        $query_edit = $conn->query($sql_edit);
                        $result_edit = $query_edit->fetch_assoc();

                        $form_conduct_id = $result_edit['form_conduct_id'];
                        $form_conduct_group = $result_edit['form_conduct_group'];
                        $form_conduct_type = $result_edit['form_conduct_type'];

                        $type_work_id = $result_edit['type_work_id'];
                        $form_conduct_name = $result_edit['form_conduct_name'];
                        $form_conduct_score = $result_edit['form_conduct_score'];
                        $form_conduct_status = $result_edit['form_conduct_status'];
                        $form_conduct_log = $result_edit['form_conduct_log'];
                    } else {


                        $form_conduct_id = "";
                        $form_conduct_group = "";
                        $form_conduct_type = "";
                        $type_work_id = "";
                        $form_conduct_name = "";
                        $form_conduct_score = 0;
                        $form_conduct_status = "";
                        $form_conduct_log = "";
                    }


                    if (isset($_GET['del'])) {
                        include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                        $form_conduct_id = $_GET['del'];
                        $sql_del = "DELETE FROM tbl_form_conduct WHERE tbl_form_conduct.form_conduct_id = $form_conduct_id";
                        $conn->query($sql_del);
                        echo "<script type='text/javascript'>";
                        //echo  "alert('บันทึกสำเร็จ');";
                        echo "window.location='form_conduct.php'";
                        echo "</script>";
                    }
                    ?>


                    <form name="form1" method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" name="form_conduct_id" value="<?php echo $form_conduct_id; ?>">
                        <div class="row">


                            <div class="col-sm-2">
                                <select name="type_work_id" id="select" class="form-control">
                                    <option value="" <?php if ($type_work_id == "") {
                                                            echo "selected";
                                                        } ?>> -- Conduct ส่วนกลาง -- </option>
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
                                <select name="form_conduct_group" id="select" class="form-control">
                                    <option value="1" <?php if ($form_conduct_group == 1) {
                                                            echo "selected";
                                                        } ?>> -- หมวดที่ 1 ความประพฤติทั่วไป -- </option>
                                    <option value="2" <?php if ($form_conduct_group == 2) {
                                                            echo "selected";
                                                        } ?>> -- หมวดที่ 2 ความผิดร้ายแรง -- </option>
                                    <option value="3" <?php if ($form_conduct_group == 3) {
                                                            echo "selected";
                                                        } ?>> -- หมวดที่ 3 การประเมินเจตคติตามข้อบังคับของสาขา -- </option>
                                </select>
                            </div>



                            <div class="col-sm-2">
                                <select name="form_conduct_type" id="select" class="form-control">
                                    <option value="1" <?php if ($form_conduct_type == 1) {
                                                            echo "selected";
                                                        } ?>> -- เวชระเบียน -- </option>
                                    <option value="2" <?php if ($form_conduct_type == 2) {
                                                            echo "selected";
                                                        } ?>> -- การปฏิบัติงานในคลินิก -- </option>
                                    <option value="3" <?php if ($form_conduct_type == 3) {
                                                            echo "selected";
                                                        } ?>> -- ความผิดอื่นๆ -- </option>
                                    <option value="4" <?php if ($form_conduct_type == 4) {
                                                            echo "selected";
                                                        } ?>> -- ความผิดในการปฏิบัติงาน -- </option>
                                    <option value="5" <?php if ($form_conduct_type == 5) {
                                                            echo "selected";
                                                        } ?>> -- ความผิดตามข้อบังคับวินัยนักศึกษา ของมหาวิทยาลัย -- </option>
                                    <option value="6" <?php if ($form_conduct_type == 6) {
                                                            echo "selected";
                                                        } ?>> -- เฉพาะสาขา -- </option>
                                </select>
                            </div>



                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="form_conduct_name" class="form-control" value="<?php echo $form_conduct_name; ?>" placeholder="รายละเอียด" required>
                                </div>
                            </div>


                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" name="form_conduct_score" class="form-control" value="<?php echo $form_conduct_score; ?>" placeholder="คะแนน" required>
                                </div>
                            </div>


                            <div class="col-sm-2">
                                <div class="form-group">

                                    <select name="form_conduct_status" id="form_conduct_status" class="form-control select2" required>
                                        <option value=""> สถานะ </option>
                                        <option value="0" <?php if (!(strcmp(0, $form_conduct_status))) {
                                                                echo "selected=\"selected\"";
                                                            } ?>>
                                            ปิดการใช้งาน</option>
                                        <option value="1" <?php if (!(strcmp(1, $form_conduct_status))) {
                                                                echo "selected=\"selected\"";
                                                            } ?>>
                                            เปิดการใช้งาน</option>
                                    </select>
                                </div>
                            </div>





                            <div class="col-sm-2">
                                <div class="form-group">
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



                        if (isset($_POST['form_conduct_group'])  && !empty($_POST['form_conduct_group'])) {
                            $form_conduct_group = $conn->real_escape_string($_POST['form_conduct_group']);
                        } else {
                            $form_conduct_group = 0;
                        }


                        if (isset($_POST['form_conduct_type'])  && !empty($_POST['form_conduct_type'])) {
                            $form_conduct_type = $conn->real_escape_string($_POST['form_conduct_type']);
                        } else {
                            $form_conduct_type = 1;
                        }



                        if (isset($_POST['type_work_id'])  && !empty($_POST['type_work_id'])) {
                            $type_work_id = $conn->real_escape_string($_POST['type_work_id']);
                        } else {
                            $type_work_id = 0;
                        }


                        if (isset($_POST['form_conduct_name'])  && !empty($_POST['form_conduct_name'])) {
                            $form_conduct_name = $conn->real_escape_string($_POST['form_conduct_name']);
                        } else {
                            $form_conduct_name = "";
                        }


                        if (isset($_POST['form_conduct_score'])  && !empty($_POST['form_conduct_score'])) {
                            $form_conduct_score = $conn->real_escape_string($_POST['form_conduct_score']);
                        } else {
                            $form_conduct_score = 0;
                        }


                        if (isset($_POST['form_conduct_status'])  && !empty($_POST['form_conduct_status'])) {
                            $form_conduct_status = $conn->real_escape_string($_POST['form_conduct_status']);
                        } else {
                            $form_conduct_status = 0;
                        }


                        $date_log = date('Y-m-d H:i:s');
                        $by = $_SESSION['username'];



                        if ($_POST['form_conduct_id'] != "") {


                            $form_conduct_log   =  "UP|$date_log|$by|/";



                            $sql_update = "UPDATE tbl_form_conduct SET form_conduct_group = '$form_conduct_group',
                            form_conduct_type = '$form_conduct_type',
                            type_work_id = '$type_work_id', 
                            form_conduct_name = '$form_conduct_name',
                            form_conduct_score = '$form_conduct_score',
                            form_conduct_status = '$form_conduct_status',
                            form_conduct_log = replace(form_conduct_log, '/','$form_conduct_log')
                            
                            
                             WHERE tbl_form_conduct.form_conduct_id = $form_conduct_id;";
                            $conn->query($sql_update);

                            echo "<script type='text/javascript'>";
                            echo  "alert('บันทึกสำเร็จ');";
                            echo "window.location='form_conduct.php'";
                            echo "</script>";
                        } else {


                            $form_conduct_log   =  "IN|$date_log|$by|/";


                            $sql_insert = "INSERT INTO tbl_form_conduct (form_conduct_id, form_conduct_group, form_conduct_type, type_work_id, form_conduct_name, form_conduct_score, form_conduct_status, form_conduct_log) VALUES (NULL, '$form_conduct_group', '$form_conduct_type', '$type_work_id', '$form_conduct_name', '$form_conduct_score', '$form_conduct_status', '$form_conduct_log');";
                            $conn->query($sql_insert);
                            $plan_id = $conn->insert_id;

                            echo "<script type='text/javascript'>";
                            echo  "alert('บันทึกสำเร็จ');";
                            echo "window.location='form_conduct.php'";
                            echo "</script>";
                        }
                    }
                    ?>

                </div><!-- /.card-body -->

            </div><!-- /.card -->



            <div class="card card-default color-palette-box">


                <div class="card-header">
                    <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูล Conduct </h3>
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
                                <th>หมวด</th>
                                <th>ประเภท</th>
                                <th>เรื่อง</th>
                                <th>คะแนน</th>
                                <th>สถานะ</th>
                                <th>จัดการข้อมูล</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?PHP
                            include "config.inc.php";
                            $sql   =  " SELECT * FROM tbl_form_conduct as c ";
                            $sql  .=  " LEFT JOIN  tbl_type_work   AS t  ON  t.type_work_id = c.type_work_id ";
                            $sql  .=  " ORDER BY c.form_conduct_id ASC ";
                            $query = $conn->query($sql);
                            $i = 0;
                            while ($result = $query->fetch_assoc()) {
                            $i++;
                            ?>
                                <tr class="odd gradeX">
                                    <td align="center"><?= $i; ?></td>
                                    <td><?php echo $result['type_work_name']; ?></td>

                                    <td>
                                        <?php
                                            $form_conduct_group = $result['form_conduct_group'];
                                            switch ($form_conduct_group) { // Harder page
                                                case 0:
                                                    echo  " -- ";
                                                    break;
                                                case 1:
                                                    echo  "หมวดที่ 1 ความประพฤติทั่วไป";
                                                    break;
                                                case 2:
                                                    echo  "หมวดที่ 2 ความผิดร้ายแรง";
                                                    break;
                                                case 3:
                                                    echo  "หมวดที่ 3 การประเมินเจตคติตามข้อบังคับของสาขา";
                                                    break;
                                                default:
                                                    echo  "-";
                                                    break;
                                            }
                                        ?>
                                    </td>


                                    <td>
                                        <?php
                                            $form_conduct_type = $result['form_conduct_type'];
                                            switch ($form_conduct_type) { // Harder page
                                                case 0:
                                                    echo  " -- ";
                                                    break;
                                                case 1:
                                                    echo  "เวชระเบียน";
                                                    break;
                                                case 2:
                                                    echo  "การปฏิบัติงานในคลินิก";
                                                    break;
                                                case 3:
                                                    echo  "ความผิดอื่นๆ";
                                                    break;
                                                case 4:
                                                    echo  "ความผิดในการปฏิบัติงาน";
                                                    break;
                                                case 5:
                                                    echo  "ความผิดตามข้อบังคับวินัยนักศึกษา ของมหาวิทยาลัย";
                                                    break;
                                                case 6:
                                                    echo  "เฉพาะสาขา";
                                                    break;
                                                default:
                                                    echo  "-";
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td> <?php echo $result['form_conduct_name'];  ?>  </td>
                                    <td> <?php echo $result['form_conduct_score']; ?>  </td>
                                    <td>
                                        <?php
                                        $form_conduct_status = $result['form_conduct_status'];
                                        switch ($form_conduct_status) { // Harder page
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
                                    <td class="center">
                                        <a href="?del=<?php echo $result['form_conduct_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> ลบ </a>
                                        <a href="?edit=<?php echo $result['form_conduct_id']; ?>" class="btn btn-info"> แก้ไข </a>
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
                    'Last $ Days': [moment().subtract(6, 'days'), moment()],
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