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
                <h1><i class="fas fa-chalkboard-teacher"></i> Daily Report </h1>
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
            $level_search = 1;
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
        ?>


        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-search"></i> ค้นหาข้อมูล </h3>
            </div>

            <div class="card-body">





                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
                    <input type="hidden" name="level_search" value="<?php echo $level_search; ?>">
                    <div class="row">

                        <div class="col-sm-4">
                            <?php for ($i = 4; $i <= 6; $i++) { ?>
                                <a href="?level_search=<?php echo $i; ?>&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == $i) { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ชั้นปีที่ <?php echo $i; ?> </a>
                            <?php } ?>
                            <a href="?level_search=all&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == "all") { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ทุกชั้นปี </a>
                        </div>


                        <div class="col-sm-4">
                            <input class="form-control" type="search" name="student_search" placeholder="รหัส , ชื่อ , สกุล" value="<?php echo $student_search; ?>" aria-label="Search">
                        </div>


                        <div class="col-sm-2">
                            <input class="form-control" type="search" name="student_group" placeholder="กลุ่ม" value="<?php echo $student_group; ?>" aria-label="Search">
                        </div>


                        <div class="col-sm-2">
                            <button class="btn btn-info" type="submit">Search</button>
                        </div>



                    </div>

                </form>

                <br>

                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">


                    <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
                    <input type="hidden" name="level_search" value="<?php echo $level_search; ?>">
                    <input type="hidden" name="student_search" value="<?php echo $student_search; ?>">
                    <input type="hidden" name="student_group" value="<?php echo $student_group; ?>">


                    <div class="row">
                        <div class="col-sm-3">
                            <input type="date" name="date_start" value="<?php echo $date_start; ?>" class="form-control">
                        </div>

                        <div class="col-sm-3">
                            <input type="date" name="date_end" value="<?php echo $date_end; ?>" class="form-control">
                        </div>


                        <div class="col-sm-4">
                            <button class="btn btn-info" type="submit"> เลือกวันที่ </button>
                        </div>

                    </div>

                </form>







            </div><!-- /.card-body -->
        </div><!-- /.card -->



        <style>
.table-responsive{
 height:480px;
  overflow:scroll;
}
	 
 thead tr:nth-child(1) th{
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

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
th
{
background-color:black;
color:black;
}
th:first-child, td:first-child
{
  position:sticky;
  left:0px;
 
}
 td:first-child
 {
  background-color:whitesmoke;
  color:white;
 }
</style>

        <div class="card card-default color-palette-box">


            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> Daily Report </h3>
            </div>

            <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                           
                            <th>รหัส</th>
                            <th>ชื่อ-สกุล</th>
                            <th> LOGIN </th>

                            <?PHP
                            foreach ($plan_work_header as $values => $data) {
                                $type_work_id_arr =  $data['type_work_id'];
                                $type_work_name_arr =  $data['type_work_name'];
                            ?>
                                <th colspan="3"> <?php echo $type_work_name_arr; ?> </th>
                            <?php } ?>

                        </tr>


                    </thead>

                    <tbody>


                    
                     <tr>
                           
                            <td></td>
                            <td></td>
                            <td></td>

                            <?PHP
                            foreach ($plan_work_header as $values => $data) {
                                $type_work_id_arr =  $data['type_work_id'];
                                $type_work_name_arr =  $data['type_work_name'];
                            ?>
                                <td>ADD</td>
                                <td> HN  </td>
                                <td> No HN </td>
                            <?php } ?>

                        </tr>


                        <?php
                        include "config.inc.php";
                        $i = 0;
                        $sql_student   =  " SELECT *FROM  tbl_student ";

                        if ($level_search == "all") {
                            $sql_student  .=  " where  student_active = 1";
                            $sql_student  .=  " ORDER BY student_id ASC   ";
                        } else if ($student_search != "") {
                            $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' and student_active = 1";
                            $sql_student  .=  " ORDER BY student_id ASC  ";
                        } else {
                            $sql_student   .=  " where student_level=$level_search and student_active = 1";
                            $sql_student  .=  " ORDER BY student_id ASC  ";
                        }
                          //echo $sql_student;

                        $query_student = $conn->query($sql_student);
                        while ($result_student = $query_student->fetch_assoc()) {
                            $i++;
                            $student_id = $result_student['student_id'];
                        ?>


                            <tr>
                          
                                <td> <a href="report_student.php?type_work_id=<?php echo $type_work_id; ?>&student_id=<?php echo $result_student['student_id']; ?>" target="_blank"><?php echo $result_student['student_id']; ?></a></td>
                                <td><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></td>


                                <td align="center">

                                    <?php
                                    $today = date('Y-m-d');
                                    $date = date_create($result_student['student_log']);
                                    $student_log = date_format($date, "Y-m-d");

                                    $student_log_time = date_format($date, "H:i:s");
                                    if ($student_log == $today) {
                                        echo "<font color='green' size='3'> <i class='fas fa-grin'></i> </font>".$student_log_time;
                                    } else {

                                    }
                                    ?>

                                </td>


                                <?PHP
                                foreach ($plan_work_header as $values => $data) {
                                $type_work_id_arr =  $data['type_work_id'];
                                $type_work_name_arr =  $data['type_work_name'];
                                ?>

                                    <td align="center">
                                     <?php //echo $type_work_id_arr; ?> 
                                    <?php 
                                    $sql_detail   =  " SELECT * FROM tbl_detail WHERE  detail_by_student = '$student_id' and  detail_type_work_id = '$type_work_id_arr'  AND ( detail_date_work  BETWEEN '$date_start' AND '$date_end')  ";
                                    $sql_detail  .=  " ORDER BY detail_id ASC ";
                                    $query_detail = $conn->query($sql_detail);
                                    while ($result_detail = $query_detail->fetch_assoc()) {
                                     
                                        $detail_date_work=date_create($result_detail['detail_date_work']);
                                        $detail_date_work =date_format($detail_date_work,"d-m-Y");
                                       
                                        $detail_id = $result_detail['detail_id'];
                                        $detail_ =nameDetail::get_detail_name($detail_id);
                                        
                                        $detaill = $detail_date_work.">".$detail_;
                                        echo "<a href='#' data-toggle='tooltip' title='$detaill'><i class='fas fa-check-circle' style='font-size:20px;color:green'> </i></a>";
                                      }
                                     ?>
                                    </td>


                                    
                                    <td align="center" >
                                    <?php 
                                    $sql_arrange  = " SELECT a.*, d.*, p.*   FROM";
                                    $sql_arrange  .=  " (SELECT * FROM tbl_arrange WHERE  arrange_date  BETWEEN '$date_start' AND '$date_end') as a ";
                                    $sql_arrange  .=  " INNER JOIN (SELECT * FROM tbl_detail  WHERE detail_by_student = '$student_id' and  detail_type_work_id = '$type_work_id_arr'  ) AS d  ON  d.detail_id = a.detail_id ";
                                    $sql_arrange  .=  " INNER JOIN  tbl_plan as p  ON  p.plan_id = d.plan_id";
                                    $sql_arrange  .=  " ORDER BY a.arrange_id ASC ";
                                    $query_arrange = $conn->query($sql_arrange);
                                    while ($result_arrange = $query_arrange->fetch_assoc()) {
                                        // echo $result_arrange['arrange_id']; 
                                        // echo "==>";

                                        $arrange_date=date_create($result_arrange['arrange_date']);
                                        $arrange_date = date_format($arrange_date,"d-m-Y");
                                        
                                        $arrange_time = $result_arrange['arrange_time'];
                                        

                                        $detail_id = $result_arrange['detail_id'];
                                        $detail_ =  nameDetail::get_detail_name($detail_id);

                                        $teacher_id = $result_arrange['teacher_id'];
                                        $teacher =  nameTeacher::get_teacher_name($teacher_id);
                                       


                                        $detaill =  $arrange_date.":".$arrange_time.">".$detail_.">".$teacher;

                                        $arrange_check_eval = $result_arrange['arrange_check_eval'];
                                        switch ($arrange_check_eval) { // Harder page
                                          case 1:
                                            echo  "<a href='#' data-toggle='tooltip' title='$detaill'><i class='fas fa-check-circle' style='font-size:20px;color:green'> </i></a>";
                                            

                                            break;
                                          case 0:
                                            echo  "<a href='#' data-toggle='tooltip' title='$detaill'><i class='fas fa-history' style='font-size:20px;color:gray'></i></a>";

                                            break;
                                          default:
                                            echo  "<i class='fas fa-history'></i> -";
                                            break;
                                        }



                                        echo "<br>";

                                      }
                                     ?>
                                    </td>





                                    <td align="center" >
                                    <?php 
                                    $sql_arrange_nohn  = " SELECT a.*, p.*   FROM";
                                    $sql_arrange_nohn  .=  " (SELECT * FROM tbl_arrange_nohn WHERE student_id = '$student_id' and  type_work_id = '$type_work_id_arr'  and (arrange_nohn_date  BETWEEN '$date_start' AND '$date_end') ) as a ";
                                    $sql_arrange_nohn  .=  " INNER JOIN  tbl_plan as p  ON  p.plan_id = a.plan_id";
                                    $sql_arrange_nohn  .=  " ORDER BY a.arrange_nohn_id ASC ";
                                    $query_arrange_nohn = $conn->query($sql_arrange_nohn);
                                    while ($result_arrange_nohn = $query_arrange_nohn->fetch_assoc()) {
                                        // echo $result_arrange['arrange_id']; 
                                        // echo "==>";

                                        $arrange_nohn_date = date_create($result_arrange_nohn['arrange_nohn_date']);
                                        $arrange_nohn_date = date_format($arrange_nohn_date,"d-m-Y");
                                        $arrange_nohn_time = $result_arrange_nohn['arrange_nohn_time'];
                                        $plan_name = $result_arrange_nohn['plan_name'];
                                        $teacher_id = $result_arrange_nohn['teacher_id'];
                                        $teacher = nameTeacher::get_teacher_name($teacher_id);

                                        $detaill = $arrange_nohn_date.":".$arrange_nohn_time.":".$plan_name.">".$teacher;
                                       

                                        $arrange_nohn_check_eval = $result_arrange_nohn['arrange_nohn_check_eval'];
                                        switch ($arrange_nohn_check_eval) { // Harder page
                                          case 1:
                                            echo  "<a href='#' data-toggle='tooltip' title='$detaill'><i class='fas fa-check-circle' style='font-size:20px;color:green'></i></a>";
                                            break;
                                          case 0:
                                            echo  "<a href='#' data-toggle='tooltip' title='$detaill'><i class='fas fa-history' style='font-size:20px;color:gray'></i></a>";
                                            break;
                                          default:
                                            echo  "<i class='fas fa-history'></i> -";
                                            break;
                                        }



                                        echo "<br>";

                                      }
                                     ?>
                                  

                                    </td>

                                  


                                <?php }    ?>

                            </tr>


                        <?php } $conn->close(); ?>

                    </tbody>
                </table>

            </div>
            </div><!-- /.card-body -->

        </div><!-- /.card -->




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
            "pageLength": 5,
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

<!-- page script Tooltip -->
<script type="text/javascript">
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
<!-- page script Tooltip -->

</body>

</html>