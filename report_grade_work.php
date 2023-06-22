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



<?PHP
if (isset($_GET['type_work_id'])) { 

    include "config.inc.php";
    $type_work_id = $_GET['type_work_id'];
    $sql_type_work = "SELECT * FROM tbl_type_work  where type_work_id = $type_work_id ";
    $query_type_work = $conn->query($sql_type_work);
    $result_type_work  = $query_type_work->fetch_assoc();
    $type_work_id = $result_type_work['type_work_id'];
    $type_work_name = $result_type_work['type_work_name'];

    $conn -> close();

} else {

    $type_work_name = "";
    $type_work_id = "";

}
?>




<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1> Score By Work > <?php echo $type_work_name; ?></h1>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">



        <?php
        //ตัวแปรเงื่อนไขการค้นหา





        if (isset($_GET['type_work_id'])) {
            $type_work_id = $_GET['type_work_id'];
        } else {
            $type_work_id = 1;
        }


        if (isset($_GET['level_search'])) {
            $level_search = $_GET['level_search'];
        } else {
            $level_search = 4;
        }

        if (isset($_GET['student_group'])) {
            $student_group = $_GET['student_group'];
        } else {
            $student_group = "";
        }


        if (isset($_GET['student_search'])) {
            $student_search = $_GET['student_search'];
        } else {
            $student_search = "";
        }


        if (isset($_GET['report_date_id'])) {
            $report_date_id = $_GET['report_date_id'];
        } else {
            $report_date_id = '';
        }

        if (isset($_GET['student_group'])) {
            $student_group = $_GET['student_group'];
        } else {
            $student_group = '';
        }


        



        if (isset($_GET['report_date_id'])) {


            $report_date_id = $_GET['report_date_id'];


            include "config.inc.php";
            $sql_report_date = "SELECT * FROM tbl_report_date  WHERE  report_date_id = $report_date_id ";
            $query_report_date = $conn->query($sql_report_date);
            $result_report_date  = $query_report_date->fetch_assoc();



            $date_start = $result_report_date['report_date_start'];
            $date_end = $result_report_date['report_date_end'];


            $report_date_code = $result_report_date['report_date_code'];
            $report_date_year = $result_report_date['report_date_code'];

            $conn -> close();

        } else {




            if (isset($_GET['report_date_code'])) {
                $report_date_code = $_GET['report_date_code'];
            } else {
                $report_date_code = "55";
            }


            if (isset($_GET['date_start'])) {
                $date_start = $_GET['date_start'];
            } else {
                $date_start = date('Y-m-d');
            }

            if (isset($_GET['date_end'])) {
                $date_end = $_GET['date_end'];
            } else {
                $date_end = date('Y-m-d');
            }
        }


        ?>


        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-search"></i> ค้นหาข้อมูล </h3>
            </div>
            <div class="card-body">
                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
                    <div class="row">


                        <div class="col-sm-4">
                            <select name="report_date_id" id="report_date_id" class="select2" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                                <option value="" <?php if ($report_date_id == "") {
                                                        echo "selected";
                                                    } ?>> -- เลือกช่วงวันที่ -- <?php echo $report_date_id; ?></option>
                                <?PHP
                                include "config.inc.php";
                                $sql_report_date = "SELECT * FROM tbl_report_date  ORDER BY tbl_report_date.report_date_id ASC ";
                                $query_report_date = $conn->query($sql_report_date);
                                while ($result_report_date  = $query_report_date->fetch_assoc()) {

                                    $report_date_start = date_create($result_report_date['report_date_start']);
                                    $report_date_start = date_format($report_date_start, "d-m-Y");

                                    $report_date_end = date_create($result_report_date['report_date_end']);
                                    $report_date_end = date_format($report_date_end, "d-m-Y");

                                ?>
                                    <option value="<?php echo $result_report_date['report_date_id']; ?>" <?php if ($report_date_id == $result_report_date['report_date_id']) {
                                                                                                            echo "selected";
                                                                                                        } ?>>
                                        รหัส <?php echo $result_report_date['report_date_code']; ?> ชั้นปี: <?php echo $result_report_date['report_date_year']; ?> (<?php echo $report_date_start; ?> - <?php echo $report_date_end; ?>) </option>
                                <?php } 
                                $conn -> close();
                                ?>
                            </select>
                        </div>


                        <!--
                        <div class="col-sm-4">
                            <?php for ($i = 4; $i <= 6; $i++) { ?>
                                <a href="?level_search=<?php echo $i; ?>&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == $i) { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ชั้นปีที่ <?php echo $i; ?> </a>
                            <?php } ?>
                            <a href="?level_search=all&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == "all") { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ทุกชั้นปี </a>
                        </div>
                       -->




                        <div class="col-sm-2">
                            <button class="btn btn-info" type="submit">เลือก</button>
                        </div>





                    </div>

                </form>
                <br>
                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">


                    <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
                    <input type="hidden" name="student_search" value="<?php echo $student_search; ?>">



                    <div class="row">

                        <div class="col-sm-2">
                            <input class="form-control" type="search" name="report_date_code" placeholder="รหัส" value="<?php echo $report_date_code; ?>" aria-label="Search">
                        </div>


                        <div class="col-sm-2">
                            <input type="date" name="date_start" value="<?php echo $date_start; ?>" class="form-control">
                        </div>

                        <div class="col-sm-2">
                            <input type="date" name="date_end" value="<?php echo $date_end; ?>" class="form-control">
                        </div>



                        <div class="col-sm-3">
                            <input class="form-control" type="search" name="student_search" placeholder="รหัส , ชื่อ , สกุล , กลุ่ม" value="<?php echo $student_search; ?>" aria-label="Search">
                        </div>


                        <div class="col-sm-2">
                            <button class="btn btn-info" type="submit"> ยืนยัน </button>
                        </div>

                    </div>

                </form>
                <font color="red">*** เลือกช่วงวันที่ และ กดยืนยันอีกครั้ง เพื่อดึงข้อมูล </font>
            </div><!-- /.card-body -->
        </div><!-- /.card -->


        <style>
            .table-responsive {
                height: 500px;
                overflow: scroll;
            }

            thead tr:nth-child(1) th {
                background: white;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td,
            th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #dddddd;
                color: black;
            }

            th:first-child,


            td:first-child {
                position: sticky;
                left: 0px;
            }

            td:first-child {
                background-color: whitesmoke;
                color: black;
            }


            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                border-style: dotted;

            }
        </style>


 
        <?php
        switch ($type_work_id) { // Harder page
            case 1:
                echo " <a href='report_grade_work_xray.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_xray.php";
                break;


            case 2:
                echo " <a href='report_grade_work_pedo2.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code&student_group=$student_group' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_pedo2.php";
                break;


            case 4:
                //echo " <a href='report_grade_work_xray.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_oper.php";
                break;

            case 5:
                echo " <a href='report_grade_work_endo.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_endo.php";
                break;
                

                
            case 6:
                echo " <a href='report_grade_work_cb.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_cb.php";
                break;


            case 7:
                echo " <a href='report_grade_work_perio.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_perio.php";
                break;

            case 8:
               // echo " <a href='report_grade_work_surgery.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_prostho.php";
                break;

            case 9:
                echo " <a href='report_grade_work_surgery.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include "report_grade_work_surgery.php";
                break;


            case 10:
                echo " <a href='report_grade_work_oral_diagnosis.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include  "report_grade_work_oral_diagnosis.php";
                break;
                    
            case 11:
                echo " <a href='report_grade_work_preventive.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include  "report_grade_work_preventive.php";
                break;


            case 12:
                echo " <a href='report_grade_work_opd.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include  "report_grade_work_opd.php";
                break;

           



            default:
                echo " <a href='report_grade_work_default.php?act=excel&type_work_id=$type_work_id&level_search=$level_search&student_search=$student_search&student_group=$student_group&date_start=$date_start&date_end=$date_end&report_date_code=$report_date_code' class='btn btn-primary'> Export->Excel </a>";
                include  "report_grade_work_default.php";
                break;
        }
        ?>





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






<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            "paging": true,
            "lengthChange": true,
            "pageLength": 50,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            "buttons": ["copy", "csv",
                {
                    extend: 'excel',
                    messageTop: 'รายงานคะแนนนักศึกษา',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }, "print"
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


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


<!-- page script Tooltip -->
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<!-- page script Tooltip -->