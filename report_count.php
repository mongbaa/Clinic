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
                <h1>  รายงานนับคาบ </h1>
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
                                <?php 
                                } 
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
        </style>



                <?PHP
                // สร้าง array 2 มิติ
                $type_work_array = array();
                include "config.inc.php";
                $sql_work =  " SELECT * FROM tbl_type_work ";
                $query_work = $conn->query($sql_work);
                while ($result_work = $query_work->fetch_assoc()) {

                    $type_work_array[] = array(
                        'type_work_name' => $result_work['type_work_name'],
                        'type_work_id' => $result_work['type_work_id']
                    );
                }
                // var_dump($type_work_array);
                $conn -> close(); 
                ?>






        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> รายงานนับคาบ  </h3>


            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" border="1" cellpadding="5">
                        <thead>
                            <tr>
                                <th Width="7%">รหัส</th>
                                <th Width="20%">ชื่อ-สกุล</th>
                                
                                <?php
                                foreach ($type_work_array as $values => $data) {
                                   $type_work_id = $data['type_work_id']; 
                                   $type_work_name = $data['type_work_name']; 
                                ?>
                                    <th>
                                        <div align="center"><?php echo $type_work_name; ?></div>
                                    </th>
                                <?php } ?>

                            </tr>

                            <tr>
                                <td>รหัส</td>
                                <td>ชื่อ-สกุล</td>
                                <?php
                                foreach ($type_work_array as $values => $data) {
                                   $type_work_id = $data['type_work_id']; 
                                   $type_work_name = $data['type_work_name']; 
                                ?>
                                     <td>
                                        <div align="center"><?php echo $type_work_name; ?> </div>
                                    </td>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $total = 0;
                            $sum = 0;
                            include "config.inc.php";
                            $i = 0;
                            $sql_student   =  " SELECT *FROM  tbl_student ";

                            if ($level_search == "all") {
                                $sql_student  .=  " ORDER BY student_id ASC   ";
                            } else if ($student_search != "") {
                                $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' or student_group like '%$student_search%'  ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            } else {
                                $sql_student   .=  " where student_id  like '$report_date_code%' and student_level != 7 ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            }

                            $query_student = $conn->query($sql_student);
                            while ($result_student = $query_student->fetch_assoc()) {
                                $i++;
                                $student_id = $result_student['student_id'];
                            ?>
                                <tr>
                                    <td> <?php echo $result_student['student_id']; ?> </td>
                                    <td> <?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?> </td>
                                   
                                    <?php
                                    foreach ($type_work_array as $values => $data) {
                                    $type_work_id = $data['type_work_id']; 
                                    $type_work_name = $data['type_work_name']; 
                                    ?>
                                     <td>
                                        <div align="center">
                                        <?php //echo $type_work_id; ?>
                                        <?php
                                        //$sql_holistic_count = " SELECT  h.*,  COUNT(h.holistic_id) As holistic_count , th.* ";
                                        $sql_holistic_count = " SELECT  h.*,  COUNT(h.holistic_id) As holistic_count ";
                                        $sql_holistic_count  .=  " FROM (SELECT * FROM tbl_holistic WHERE student_id = '$student_id' ";
                                        $sql_holistic_count  .=  " and (holistic_date BETWEEN '$date_start' AND '$date_end') and type_work_id = $type_work_id";
                                        $sql_holistic_count  .=  " ";
                                        $sql_holistic_count  .=  " ) as h ";
                                       // $sql_holistic_count  .=  " INNER JOIN (SELECT * FROM tbl_teacher WHERE type_work_id = $type_work_id) as th  ON  h.teacher_id = th.teacher_id";
                                        $query_holistic_count = $conn->query($sql_holistic_count);
                                        $result_holistic_count = $query_holistic_count->fetch_assoc();
                                        echo $result_holistic_count["holistic_count"];
                                        ?>
                                    
                                    
                                    
                                       </div>




                                    </td>
                                    <?php } ?>


                                </tr>
                            <?php
                            }

                            $conn -> close();
                            ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->

            </div><!-- /.card-body -->
        </div><!-- /.card -->







    </div><!-- /.container-fluid -->
</section>



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
            "buttons": [
            {
                extend: 'excelHtml5',
                title: 'รายงานนับคาบ'
            }
            ]


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


<!-- page script Tooltip -->
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<!-- page script Tooltip -->