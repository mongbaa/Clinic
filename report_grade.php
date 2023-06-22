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

    $type_work_id = $_GET['type_work_id'];
    $sql_type_work = "SELECT * FROM tbl_type_work  where type_work_id = $type_work_id ";
    $query_type_work = $conn->query($sql_type_work);
    $result_type_work  = $query_type_work->fetch_assoc();

    $type_work_id = $result_type_work['type_work_id'];
    $type_work_name = $result_type_work['type_work_name'];
} else {

    $type_work_name = "";
    $type_work_id = "";
}

?>




    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-8">
                    <h1> Grade <?php echo $type_work_name; ?></h1>
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
                $student_group = "A";
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






            <?PHP // ข้อมูล งานของแต่ละสาขา
            include "config.inc.php";
            $sql_plan = " SELECT p.* , t.* , f.*";
            $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p ";
            $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
            $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
            $sql_plan  .=  " ORDER BY p.plan_id ASC ";
            ?>

            <div class="card card-default color-palette-box">


                <div class="card-header">
                    <h3 class="card-title"> <i class="fas fa-plus"></i> Grade </h3>
                </div>

                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th Width="3%">#</th>
                                <th Width="7%">รหัส</th>
                                <th Width="15%">ชื่อ-สกุล</th>
                                <th Width="7%">จำนวนงานทั้งหมด</th>
                                <th Width="7%">คะแนนรวม </th>
                                <th Width="7%">คะแนนรวม / น้ำหนักรวม</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            include "config.inc.php";
                            $i = 0;
                            $sql_student   =  " SELECT *FROM  tbl_student ";

                            if ($level_search == "all") {
                                $sql_student  .=  " ORDER BY student_id ASC   ";
                            } else if ($student_search != "") {
                                $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            } else {
                                $sql_student   .=  " where student_level=$level_search ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            }

                            $query_student = $conn->query($sql_student);
                            while ($result_student = $query_student->fetch_assoc()) {
                                $i++;

                                $student_id = $result_student['student_id'];
                            ?>


                                <tr>
                                    <td align="center"><?php echo $i; ?></td>
                                    <td> <a href="report_student.php?type_work_id=<?php echo $type_work_id; ?>&student_id=<?php echo $result_student['student_id']; ?>" target="_blank"><?php echo $result_student['student_id']; ?></a></td>
                                    <td><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></td>
                                   
                                   
                                   
                               
                                    <td align="center">
                                    <?php
                                    $total_scoreweight = 0;
                                    $total_score_sum = 0;
                                    $total_scoreweight_sum = 0;
                                    $total_score = 0;
                                    $total_weigh = 0;

                                      include "config.inc.php";
                                      $sql_detail = " SELECT o.*, d.*, p.* , t.* , f.* FROM";
                                      $sql_detail  .=  " (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                                      $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail  WHERE detail_complete = 1  ) AS d  ON  d.order_id = o.order_id ";
                                      $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p  ON  p.plan_id = d.plan_id";
                                      $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                                      $sql_detail  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
                                      $sql_detail  .=  " ORDER BY d.detail_id ASC ";
                                      $query_detail = $conn->query($sql_detail);
                                      echo  $num_rows = $query_detail->num_rows;
                                      while ($result_detail = $query_detail->fetch_assoc()) {

                                   echo "<br>";
                                   echo  $tbl = $result_detail['form_main_table']; // ชื่อตาราง
                                        $tbl_id = $tbl . "_id"; // Id ของตาราง
                                        $detail_id = $result_detail['detail_id']; //รหัสงาน
                                        $form_main_id = $result_detail['form_main_id']; //รหัสฟอร์ม

                                  
                                        $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                        $sql_form_re .= " AND ( last_date  BETWEEN '$date_start' AND '$date_end') ";
                                        $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                        $query_form_re = $conn->query($sql_form_re);
                                        if ($row_form_re = $query_form_re->fetch_assoc()) {

                                            $total_weight = 0;
                                            $total_score = 0;
                                            $sum_score = 0;
                                            $total_step = 0;
                                            $i_re = 0; 
                                            // หาชื่อฟิลด์
                                            $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                                            $sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
                                            $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                                            //echo $sql_form_detail_re;
                                            $query_form_detail_re = $conn->query($sql_form_detail_re);
                                            while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                              $i_re++;

                                              $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์

                                              $field_grade = $field . "_grade";  //_grade

                                              $grade = $row_form_re["{$field_grade}"];
                                                if (isset($grade) && !empty($grade)) {
                                                    $field_weights = $field . "_weight";   //_weight
                                                    $weight = $row_form_re["{$field_weights}"];
                                                    $field_teacher = $field . "_teacher";  //_teacher
                                                    $teacher = $row_form_re["{$field_teacher}"];
                                                    $field_date = $field . "_date";  //_date
                                                    $datee = $row_form_re["{$field_date}"];
                                                } else {
                                                    $weight = "";
                                                    $teacher = "";
                                                    $datee = "";
                                                }


                                                if ($grade == "A") {
                                                    $score = 4;
                                                    $stepp = 1;
                                                    $weight_ss =  $weight;
                                                } else if ($grade == "B") {
                                                    $score = 3;
                                                    $stepp = 1;
                                                    $weight_ss =  $weight;
                                                } else if ($grade == "C") {
                                                    $score = 2;
                                                    $stepp = 1;
                                                    $weight_ss =  $weight;
                                                } else if ($grade == "F") {
                                                    $score = 1;
                                                    $stepp = 1;
                                                    $weight_ss =  $weight;
                                                } else {
                                                    $score = 0;
                                                    $stepp = 0;
                                                    $weight_ss =  0;
                                                }

                                                $sum_score = $weight * $score;

                                                $total_weight = $total_weight + $weight_ss;
                                                $total_step = $total_step + $stepp;
                                                $total_score = $total_score + $sum_score;
                                               

                                            } //while

                                            $total_score = $total_score;
                                            @$total_scoreweight = $total_score / $total_weight;


                                        }else{//if

                                            $total_score = 0;
                                            $total_scoreweight = 0;

                                        }// else

                                        echo  " -  - ";
                                        echo  $total_score;
                                        echo  " -  - ";
                                        echo  $total_scoreweight;

                                        
                                        $total_score_sum = $total_score_sum  + $total_score;
                                        $total_scoreweight_sum = $total_scoreweight_sum  + $total_scoreweight;

                                      }//while
                                      ?>


                                    </td>
                                    <td align="center"> <?php echo $total_score_sum;?></td>
                                    <td align="center"> <?php echo $total_scoreweight_sum ; ?></td>
                                </tr>


                            <?php } ?>

                        </tbody>
                    </table>


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