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
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>


<?php
if (isset($_GET['form_more_id'])) {
    $form_more_id = $_GET['form_more_id'];
} else {
    $form_more_id = "";
}

include "config.inc.php";
$sql_form_more = "SELECT * FROM tbl_form_more , tbl_type_work where tbl_form_more.type_work_id=tbl_type_work.type_work_id and  tbl_form_more.form_more_id=$form_more_id";
$query_form_more = $conn->query($sql_form_more);
$row_form_more = $query_form_more->fetch_assoc();




if (isset($_GET['del'])) {

    $form_detail_more_id = $_GET['del'];
    $sql_del = "DELETE FROM tbl_form_detail_more WHERE tbl_form_detail_more.form_detail_more_id = $form_detail_more_id";
    $conn->query($sql_del);

    echo "<script type='text/javascript'>";
    //echo  "alert('สร้างรายการประเมินสำเร็จ');";
    echo "window.location='form_more_detail.php?form_more_id=$form_more_id'";
    echo "</script>";
}


if (isset($_GET['edit'])) {

    $form_detail_more_id = $_GET['edit'];
    $sql_form_detail_more = "SELECT *  FROM tbl_form_detail_more where form_detail_more_id=$form_detail_more_id";
    $query_form_detail_more = $conn->query($sql_form_detail_more);
    $row_form_detail_more = $query_form_detail_more->fetch_assoc();

    $form_detail_more_id = $row_form_detail_more['form_detail_more_id'];
    $form_detail_more_topic = $row_form_detail_more['form_detail_more_topic'];
    $form_detail_more_field = $row_form_detail_more['form_detail_more_field'];
    $form_detail_more = $row_form_detail_more['form_detail_more'];
    $form_detail_more_format = $row_form_detail_more['form_detail_more_format'];
} else {




    $sql_form_detail_rows = "SELECT * FROM tbl_form_detail_more where  form_more_id=$form_more_id ";
    $query_form_detail_rows = $conn->query($sql_form_detail_rows);
    $row_form_detail_rows = $query_form_detail_rows->fetch_assoc();
    $row_cnt = $query_form_detail_rows->num_rows;
    $numstep = $row_cnt + 1;


    $form_detail_more_id = "";
    $form_detail_more_topic = "";
    $form_detail_more_field = "step" . $numstep;
    $form_detail_more = "";
    $form_detail_more_format = "";
}

/*
 
  
  
  }*/


?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-8">
                <h1>สร้างรายการ ฟอร์มเกี่ยวข้อง สาขา : <?php echo $row_form_more['type_work_name']; ?> ชื่อฟอร์ม :
                    <?php echo $row_form_more['form_more_name']; ?> </h1>
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




        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">รายการฟอร์มประเมินคะแนน สาขา : <?php echo $row_form_more['type_work_name']; ?>
                    ชื่อฟอร์ม : <?php echo $row_form_more['form_more_name']; ?> </h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body">

                <form id="formx" name="formx" method="post" action="form_more_detail_more_q.php">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th Width="6%">
                                    <div align="center">ลำดับ</div>
                                </th>
                                <th Width="30%"> หัวข้อ topic </th>
                                <th Width="15%">
                                    <div align="center">field</div>
                                </th>
                                <th Width="6%">
                                    <div align="center"> detail </div>
                                </th>
                                <th Width="10%">
                                    <div align="center"> format </div>
                                </th>
                                <th>
                                    <div align="center">จัดการข้อมูล</div>
                                </th>
                            </tr>
                        </thead>


                        <tbody>



                            <tr class="table-success">
                                <td>
                                    -
                                </td>

                                <td Width="30%">
                                    <input type="hidden" name="form_detail_more_id" value="<?php echo $form_detail_more_id; ?>">
                                    <input type="text" name="form_detail_more_topic" class="form-control" id="form_detail_more_topic" value="<?php echo $form_detail_more_topic; ?>" placeholder="หัวข้อ" required>
                                    <input type="hidden" name="form_more_id" value="<?php echo $row_form_more['form_more_id']; ?>">
                                </td>

                                <td>
                                    <input type="text" name="form_detail_more_field" class="form-control" id="exampleInputEmail1" value="<?php echo $form_detail_more_field; ?>" placeholder="ชื่อ Field">
                                </td>



                                <td Width="20%">
                                    <div align="center">
                                        <textarea name="form_detail_more" class="form-control" placeholder="<?php echo "a=1,b=2"; ?>"><?php echo $form_detail_more; ?></textarea>
                                    </div>
                                </td>



                                <td Width="15%">
                                   
                                    <div align="center">
                                        <select name="form_detail_more_format" class="form-control" required>
                                            <option value="" <?php if ($form_detail_more_format == "") echo "selected"; ?>>
                                                -- เลือกค่า --</option>
                                            <option value="N" <?php if ($form_detail_more_format == "N") echo "selected"; ?>>
                                                ตัวเลือกเลือกได้ 1 ค่า (radio)</option>

                                            <option value="CHK"<?php if ($form_detail_more_format == "CHK") echo "selected"; ?>>
                                            ตัวเลือกเลือกได้ 1 ค่า (checkbox)</option>

                                            <option value="M" <?php if ($form_detail_more_format == "M") echo "selected"; ?>>
                                                ตัวเลือกเลือกได้มากกว่า 1 ค่า (checkbox) </option>>
                                            <option value="ML" <?php if ($form_detail_more_format == "ML") echo "selected"; ?>>
                                                ตัวเลือกเลือกได้มากกว่า 1 ค่า (List) </option>
                                            <option value="L" <?php if ($form_detail_more_format == "L") echo "selected"; ?>>
                                                รายการให้เลือก (List)</option><br>
                                            <option value="T" <?php if ($form_detail_more_format == "T") echo "selected"; ?>>
                                                ช่องกรอกข้อมูล (Text)</option>
                                            <option value="D" <?php if ($form_detail_more_format == "D") echo "selected"; ?>>
                                                ช่องกรอกข้อมูล (Detail)</option>
                                        </select>
                                    </div>
                                </td>




                                <td>
                                    <?php if (isset($_GET['edit'])) { ?>

                                        <input type="submit" name="Submit" class="btn btn-info" value="Edit" />
                                        <a href="?form_more_id=<?php echo $form_more_id; ?>" class="btn btn-danger">cancel</a>

                                    <?php } else { ?>

                                        <input type="submit" name="Submit" class="btn btn-info" value="Add" />

                                    <?php } ?>
                                </td>

                            </tr>

                        </tbody>

                    </table>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->





        <!-- ฟอร์มเกี่ยวข้อง card -->
        <?php
        $type_work_id = $row_form_more['type_work_id'];
        include "config.inc.php";
        $sql_form_more = "SELECT * FROM tbl_form_more , tbl_type_work where tbl_form_more.type_work_id=tbl_type_work.type_work_id and  tbl_form_more.type_work_id=$type_work_id";
        $query_form_more = $conn->query($sql_form_more);
        while ($row_form_more = $query_form_more->fetch_assoc()) {

        ?>
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">รายการฟอร์ม <?php echo $row_form_more['form_more_name']; ?></h3>
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
                        $form_more_id = $row_form_more['form_more_id'];
                        $sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
                        $query_form_detail_more = $conn->query($sql_form_detail_more);
                        $i = 0;
                        while ($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {
                            $i++;

                            $form_detail_more_topic = $row_form_detail_more['form_detail_more_topic'];
                            $form_detail_more_field = $row_form_detail_more['form_detail_more_field'];
                        ?>




                            <div class="col-md-8  col-12">
                                <div class="info-box">

                                    <div class="col-sm-3">
                                        <?php echo $row_form_detail_more['form_detail_more_topic']; ?>
                                    </div>

                                    <div class="col-sm-9">





                                        <?php if ($row_form_detail_more['form_detail_more_format'] == "L") { ?>



                                            <select name="score" class="select2" style="width: 100%;" required>
                                                <option value="">-- เลือก --</option>
                                                <?php

                                                $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                                $step2 = count($step1);
                                                for ($ct = 0; $ct <= $step2; $ct++) {
                                                    $step = $step1[$ct];
                                                    if ($step != "") {
                                                ?>
                                                        <option value="<?php echo $step; ?>"><?php echo $step; ?> </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        <?php } ?>




                                        <?php if ($row_form_detail_more['form_detail_more_format'] == "M") { ?>

                                            <div class="row"> 
                                                <?php
                                                $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                                $step2 = count($step1);
                                                for ($ct = 0; $ct <= $step2; $ct++) {
                                                    $step = @$step1[$ct];
                                                    if ($step != "") {
                                                ?>


                                                        <div class="col-sm-3">
                                                            <!-- checkbox -->
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-success d-inline">
                                                                    <input type="checkbox" name="<?php echo $form_detail_more_field; ?>" id="<?php echo $form_detail_more_field; ?><?php echo $step; ?>" value="<?php echo $step; ?>">
                                                                    <label for="<?php echo $form_detail_more_field; ?><?php echo $step; ?>">
                                                                        <?php echo $step; ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>



                                                <?php
                                                    }
                                                }
                                                ?>

                                            </div>


                                        <?php } ?>




                                        <?php if ($row_form_detail_more['form_detail_more_format'] == "ML") { ?>




                                            <select name="<?php $form_detail_more_field; ?>[]" id="" class="select2" multiple="multiple" data-placeholder=" <?php echo $form_detail_more_topic ?> " data-dropdown-css-class="select2-purple" style="width: 100%;">


                                                <?php

                                                $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                                $step2 = count($step1);
                                                for ($ct = 0; $ct <= $step2; $ct++) {
                                                    $step = $step1[$ct];
                                                    if ($step != "") {
                                                ?>

                                                        <option value="<?php echo $step; ?>"><?php echo $step; ?> </option>



                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>



                                        <?php } ?>






                                        <?php if ($row_form_detail_more['form_detail_more_format'] == "N") { ?>

                                            <div class="row">
                                                <?php
                                                $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                                $step2 = count($step1);
                                                for ($ct = 0; $ct <= $step2; $ct++) {
                                                    $step = @$step1[$ct];
                                                    if ($step != "") {
                                                ?>
                                                        <div class="col-sm-3">
                                                            <!-- checkbox -->
                                                            <div class="form-group clearfix">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" name="<?php echo $form_detail_more_field; ?>" id="<?php echo $form_detail_more_field; ?><?php echo $step; ?>" checked value="<?php echo $step; ?>">
                                                                    <label for="<?php echo $form_detail_more_field; ?><?php echo $step; ?>">
                                                                        <?php echo $step; ?>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php } ?>



                                        <?php if ($row_form_detail_more['form_detail_more_format'] == "CHK") { ?>
                                        <div class="row">
                                            <?php
                                            $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                            $step2 = count($step1);
                                            for ($ct = 0; $ct <= $step2; $ct++) {
                                                $step = @$step1[$ct];
                                                if ($step != "") {
                                            ?>
                                                    <div class="col-sm-3">
                                                        <!-- checkbox -->
                                                        <div class="form-group clearfix">
                                                            <div class="icheck-primary d-inline">


                                                                <input type="checkbox" name="<?php echo $form_detail_more_field; ?>" id="<?php echo $form_detail_more_field; ?><?php echo $step; ?>" checked value="<?php echo $step; ?>">
                                                                <label for="<?php echo $form_detail_more_field; ?><?php echo $step; ?>">
                                                                    <?php echo $step; ?>
                                                                </label>


                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php } ?>





                                        <?php if ($row_form_detail_more['form_detail_more_format'] == "T") { ?>
                                            <input type="text" name="<?php echo $row_form_detail_more['form_detail_more_field']; ?>" class="form-control">
                                        <?php } ?>


                                        <?php if ($row_form_detail_more['form_detail_more_format'] == "D") { ?>
                                            <textarea name="<?php echo $row_form_detail_more['form_detail_more_field']; ?>" class="form-control"> </textarea>
                                        <?php } ?>


                                    </div>

                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>


                            <div class="col-md-4  col-12">
                                <div class="info-box">
                                    <div class="col-sm-4">
                                        <a href="?form_more_id=<?php echo $row_form_detail_more['form_more_id']; ?>&del=<?php echo $row_form_detail_more['form_detail_more_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">ลบ</a>
                                        <a href="?form_more_id=<?php echo $row_form_detail_more['form_more_id']; ?>&edit=<?php echo $row_form_detail_more['form_detail_more_id']; ?>" class="btn btn-info">แก้ไข</a>
                                    </div>
                                </div>
                            </div>



                        <?php } ?>




                        <!-- /.row -->
                    </div>
                </div>

            </div> <!-- card -->
            <!-- ฟอร์มเกี่ยวข้อง card -->

        <?php } ?>
        <!-- ฟอร์มเกี่ยวข้อง card -->











        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title"> SQL CREATE TABLE </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <?php
                include "config.inc.php";
                $sql_form_more = "SELECT * FROM tbl_form_more , tbl_type_work where tbl_form_more.type_work_id=tbl_type_work.type_work_id and  tbl_form_more.form_more_id=$form_more_id";
                $query_form_more = $conn->query($sql_form_more);
                $row_form_more = $query_form_more->fetch_assoc();

                $tbl = "tbl_" . $row_form_more['form_more_table']; //ชื่อตาราง
                $id = $row_form_more['form_more_table'] . "_id"; //ชื่อ ID ของตาราง



                $create = "CREATE TABLE $tbl ("; //ชื่อตารางเก็บข้อมูล

                $create .= " $id INT NOT NULL AUTO_INCREMENT , "; //

                $create .= " detail_id  INT(20) NOT NULL , "; //


                include "config.inc.php";
                $sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
                $query_form_detail_more = $conn->query($sql_form_detail_more);
                while ($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

                    $field = $row_form_more['form_more_table'] . "_" . $row_form_detail_more['form_detail_more_field'];

                    $create .= " $field text COLLATE utf8_unicode_ci NOT NULL, ";
                }

                $create .= " last_date DATE NOT NULL , ";


                $create .= " PRIMARY KEY ($id)";


                echo $create .= ") ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";



                ?>







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