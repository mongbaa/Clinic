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







<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1>  รายงานคะแนน Conduct & Knowledge </h1>
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
                        <?php } ?>
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








<!-- Main content -->
<section class="content">
    <div class="container-fluid">


        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-search"></i> แสดงข้อมูลคะแนน </h3>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th Width="7%">รหัส</th>
                                <th Width="15%">ชื่อ-สกุล</th>
                                <th > คาบ  </th>
                                <th colspan="5">  Conduct </th>
                                <th colspan="5">  Knowledge </th>
                            </tr>


                            <tr>
                                <th Width="7%">รหัส</th>
                                <th Width="15%">ชื่อ-สกุล</th>
                                <th> COUNT </th>

                                <th> A </th>
                                <th> B </th>
                                <th> C </th>
                                <th> F </th>
                                <th>  Conduct </th>


                                <th> A </th>
                                <th> B </th>
                                <th> C </th>
                                <th> F </th>
                                <th> Knowledge </th>

                            </tr>

                        </thead>

                        <tbody>


                            <?php
                            include "config.inc.php";
                            $i = 0;

                            $total_stepp_c = 0;
                            $total_stepp_k  = 0;

                            $sum_conduct_steppA = 0;
                            $sum_conduct_steppB = 0;
                            $sum_conduct_steppC = 0;
                            $sum_conduct_steppF = 0;

                            $sum_conduct_stepp1A = 0;  $sum_conduct_stepp1B = 0;  $sum_conduct_stepp1C = 0; $sum_conduct_stepp1F = 0;
                            $sum_conduct_stepp2A = 0;  $sum_conduct_stepp2B = 0;  $sum_conduct_stepp2C = 0; $sum_conduct_stepp2F = 0;
                            $sum_conduct_stepp3A = 0;  $sum_conduct_stepp3B = 0;  $sum_conduct_stepp3C = 0; $sum_conduct_stepp3F = 0;
                            $sum_conduct_stepp4A = 0;  $sum_conduct_stepp4B = 0;  $sum_conduct_stepp4C = 0; $sum_conduct_stepp4F = 0;
                            $sum_conduct_stepp5A = 0;  $sum_conduct_stepp5B = 0;  $sum_conduct_stepp5C = 0; $sum_conduct_stepp5F = 0;
                            $sum_conduct_stepp6A = 0;  $sum_conduct_stepp6B = 0;  $sum_conduct_stepp6C = 0; $sum_conduct_stepp6F = 0;
                           
                            
                            $sum_knowledge_A = 0;
                            $sum_knowledge_B = 0;
                            $sum_knowledge_C = 0;
                            $sum_knowledge_F = 0;
                        
                         

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
                                    <td Width="7%"> <?php echo $result_student['student_id']; ?></td>
                                    <td Width="15%"><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?> </td>

                                
                                    <td>  
                                        <?php

                                            $conduct_sum = 0;
                                            $knowledge_sum = 0;

                                            $conduct_total = 0;
                                            $knowledge_total = 0;
                                           

                                            //$sql_ck_4   =  " SELECT * FROM tbl_ck_4 where student_id = '$student_id' ";
                                            $sql_ck_4 = " SELECT * FROM tbl_ck_4 where student_id = '$student_id' and (ck_date BETWEEN '$date_start' AND '$date_end')";

                                            $query_ck_4 = $conn->query($sql_ck_4);
                                           echo $num_rows = $query_ck_4->num_rows;
                                            while ($result_ck_4 = $query_ck_4->fetch_assoc()) {

                                            $conduct_sum = $result_ck_4['step1']+$result_ck_4['step2']+$result_ck_4['step3']+$result_ck_4['step4']+ $result_ck_4['step5']+ $result_ck_4['step6'];
                                            $knowledge_sum = $result_ck_4['step7']; 


                                            if($result_ck_4['step1']==4){  $sum_conduct_stepp1A++; 
                                            } else if ($result_ck_4['step1'] == 3) { $sum_conduct_stepp1B++; 
                                            } else if ($result_ck_4['step1'] == 2) { $sum_conduct_stepp1C++; 
                                            } else if ($result_ck_4['step1'] == 0) { $sum_conduct_stepp1F++; 
                                            } else {  }

                                            if($result_ck_4['step2']==4){  $sum_conduct_stepp2A++; 
                                            } else if ($result_ck_4['step2'] == 3) { $sum_conduct_stepp2B++; 
                                            } else if ($result_ck_4['step2'] == 2) { $sum_conduct_stepp2C++; 
                                            } else if ($result_ck_4['step2'] == 0) { $sum_conduct_stepp2F++; 
                                            } else {  }


                                            if($result_ck_4['step3']==4){  $sum_conduct_stepp3A++; 
                                            } else if ($result_ck_4['step3'] == 3) { $sum_conduct_stepp3B++; 
                                            } else if ($result_ck_4['step3'] == 2) { $sum_conduct_stepp3C++; 
                                            } else if ($result_ck_4['step3'] == 0) { $sum_conduct_stepp3F++; 
                                            } else {  }
                                            

                                            if($result_ck_4['step4']==4){  $sum_conduct_stepp4A++; 
                                            } else if ($result_ck_4['step4'] == 3) { $sum_conduct_stepp4B++; 
                                            } else if ($result_ck_4['step4'] == 2) { $sum_conduct_stepp4C++; 
                                            } else if ($result_ck_4['step4'] == 0) { $sum_conduct_stepp4F++; 
                                            } else {  }


                                            if($result_ck_4['step5']==4){  $sum_conduct_stepp5A++; 
                                            } else if ($result_ck_4['step5'] == 3) { $sum_conduct_stepp5B++; 
                                            } else if ($result_ck_4['step5'] == 2) { $sum_conduct_stepp5C++; 
                                            } else if ($result_ck_4['step5'] == 0) { $sum_conduct_stepp5F++; 
                                            } else {  }


                                            if($result_ck_4['step6']==4){  $sum_conduct_stepp6A++; 
                                            } else if ($result_ck_4['step6'] == 3) { $sum_conduct_stepp6B++; 
                                            } else if ($result_ck_4['step6'] == 2) { $sum_conduct_stepp6C++; 
                                            } else if ($result_ck_4['step6'] == 0) { $sum_conduct_stepp6F++; 
                                            } else {  }
        
                                         
                                            $sum_conduct_steppA = $sum_conduct_stepp1A + $sum_conduct_stepp2A + $sum_conduct_stepp3A + $sum_conduct_stepp4A + $sum_conduct_stepp5A + $sum_conduct_stepp6A;
                                            $sum_conduct_steppB = $sum_conduct_stepp1B + $sum_conduct_stepp2B + $sum_conduct_stepp3B + $sum_conduct_stepp4B + $sum_conduct_stepp5B + $sum_conduct_stepp6B;
                                            $sum_conduct_steppC = $sum_conduct_stepp1C + $sum_conduct_stepp2C + $sum_conduct_stepp3C + $sum_conduct_stepp4C + $sum_conduct_stepp5C + $sum_conduct_stepp6C;
                                            $sum_conduct_steppF = $sum_conduct_stepp1F + $sum_conduct_stepp2F + $sum_conduct_stepp3F + $sum_conduct_stepp4F + $sum_conduct_stepp5F + $sum_conduct_stepp6F;

                                            $total_stepp_c = $sum_conduct_steppA + $sum_conduct_steppB + $sum_conduct_steppC + $sum_conduct_steppF;

                                           
                                           


                                            if($result_ck_4['step7']==4){  $sum_knowledge_A++; 
                                            } else if ($result_ck_4['step7'] == 3) { $sum_knowledge_B++; 
                                            } else if ($result_ck_4['step7'] == 2) { $sum_knowledge_C++; 
                                            } else if ($result_ck_4['step7'] == 0) { $sum_knowledge_F++; 
                                            } else {  }


                                            $total_stepp_k = $sum_knowledge_A + $sum_knowledge_B + $sum_knowledge_C + $sum_knowledge_F;
                                            



                                            $conduct_total = $conduct_total + $conduct_sum;
                                            $knowledge_total = $knowledge_total + $knowledge_sum;

                                            $num_rows = 0;
                                            $conduct_sum = 0;
                                            $knowledge_sum = 0;



                                            }
                                        ?>

                                    </td>


                                    <td><?php echo $sum_conduct_steppA;?></td>
                                    <td><?php echo $sum_conduct_steppB;?></td>
                                    <td><?php echo $sum_conduct_steppC;?></td>
                                    <td><?php echo $sum_conduct_steppF;?></td>
                                    <td>
                                    <?php 
                                    
                                        $SC4 = $total_stepp_c * 4;
                            
                                        if (!empty($conduct_total)) {
                                            $percent = ($conduct_total * 100) / $SC4;
                                            echo round($percent, 2);
                                        } else {
                                            echo 0;
                                        }

                                    ?>
                                    </td>


                                    <td><?php echo  $sum_knowledge_A;?> </td>
                                    <td><?php echo  $sum_knowledge_B;?> </td>
                                    <td><?php echo  $sum_knowledge_C;?> </td>
                                    <td><?php echo  $sum_knowledge_F;?>  </td>
                                    
                                    <td> 
                                    <?php 
                                    $SK4 = $total_stepp_k * 4;
                                    if (!empty($knowledge_total)) {
                                        $percent_k = ($knowledge_total * 100) / $SK4;
                                        echo round($percent_k, 2);
                                    } else {
                                        echo 0;
                                    } 
                                    ?>
                                    </td>



                                </tr>


                            <?php 

                            $sum_conduct_steppA = 0;
                            $sum_conduct_steppB = 0;
                            $sum_conduct_steppC = 0;
                            $sum_conduct_steppF = 0;

                            $sum_conduct_stepp1A = 0;  $sum_conduct_stepp1B = 0;  $sum_conduct_stepp1C = 0; $sum_conduct_stepp1F = 0;
                            $sum_conduct_stepp2A = 0;  $sum_conduct_stepp2B = 0;  $sum_conduct_stepp2C = 0; $sum_conduct_stepp2F = 0;
                            $sum_conduct_stepp3A = 0;  $sum_conduct_stepp3B = 0;  $sum_conduct_stepp3C = 0; $sum_conduct_stepp3F = 0;
                            $sum_conduct_stepp4A = 0;  $sum_conduct_stepp4B = 0;  $sum_conduct_stepp4C = 0; $sum_conduct_stepp4F = 0;
                            $sum_conduct_stepp5A = 0;  $sum_conduct_stepp5B = 0;  $sum_conduct_stepp5C = 0; $sum_conduct_stepp5F = 0;
                            $sum_conduct_stepp6A = 0;  $sum_conduct_stepp6B = 0;  $sum_conduct_stepp6C = 0; $sum_conduct_stepp6F = 0;


                            $total_steppA = 0;
                            $total_steppB = 0;
                            $total_steppC = 0;
                           
                            $SC4 = 0;
                            $SK4 = 0;

                            $total_stepp_c = 0;
                            $total_stepp_k = 0;



                            $sum_knowledge_A = 0;
                            $sum_knowledge_B = 0;
                            $sum_knowledge_C = 0;
                            $sum_knowledge_F = 0;
                        
                        
                        
                        } ?>


                        <tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
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

<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            "paging": true,
            "pageLength": 100,
            "lengthChange": true,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            "buttons": ["excel"]
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

<!-- page script Tooltip -->
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<!-- page script Tooltip -->

</body>

</html>