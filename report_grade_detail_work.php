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

       
        if (isset($_GET['plan_id'])) {
          $plan_id = $_GET['plan_id'];
        } else {
          $plan_id = 1;
        }

        
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



        ?>


<?PHP
if (isset($_GET['type_work_id'])) {
    include "config.inc.php";


    $type_work_id = $_GET['type_work_id'];
    $sql_type_work = "SELECT * FROM tbl_type_work  where type_work_id = $type_work_id ";
    $query_type_work = $conn->query($sql_type_work);
    $result_type_work  = $query_type_work->fetch_assoc();
    $type_work_id = $result_type_work['type_work_id'];
    $type_work_name = $result_type_work['type_work_name'];

    $conn->close();

} else {
    $type_work_name = "";
    $type_work_id = "";
}
?>

        <?PHP // ข้อมูล งานของแต่ละสาขา
        include "config.inc.php";
        $sql_plan = " SELECT p.* , t.* , f.*";
        $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE plan_id = $plan_id  ) as p ";
        $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
        $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y') AS f  ON  f.form_main_id = p.form_main_id ";
        $sql_plan  .=  " ORDER BY p.plan_id ASC ";
        $query_plan = $conn->query($sql_plan);
        $result_plan = $query_plan->fetch_assoc();
        $plan_name =   $result_plan['plan_name'];
        ?>



<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1> Score By Detail Work >   <?php echo $type_work_name; ?> :: <?php echo $plan_name; ?></h1>
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


            table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            border-style: dotted;
            
            }

        </style>



<?php
if(isset($_GET['act'])){
	if($_GET['act']== 'excel'){
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=export.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
}
?>

 
<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> Score By Work  <?php echo $type_work_name; ?> :: <?php echo $plan_name; ?></h3>
    </div>

    <div class="card-body">

      


        <div class="table-responsive">


            <table id="example1" class="table table-hover" border = "1">

                <thead>

                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อ-สกุล</th>
                        <?php for ($x = 1; $x <= 15; $x++) {  ?>
                        <th><?php echo $x;?></th>
                        <?php } ?>
                        <th> Total </th>
                    </tr>
        




                </thead>


                <tbody>

                    <?php



/*
                    include "config.inc.php";
                    $i = 0;
                    $detail_total_s = 0;
                    $sql_student   =  " SELECT *FROM  tbl_student ";

                    if ($level_search == "all") {
                        $sql_student  .=  " ORDER BY student_id ASC   ";
                    } else if ($student_search != "") {
                        $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' or student_group like '%$student_search%'  ";
                        $sql_student  .=  " ORDER BY student_id ASC  ";
                    } else {
                        $sql_student   .=  " where student_level=$level_search ";
                        $sql_student  .=  " ORDER BY student_id ASC  ";
                    }

*/
                    include "config.inc.php";
                    $i = 0;
                    $detail_total_s = 0;
                    $sql_student   =  " SELECT *FROM  tbl_student ";
                    $sql_student   .=  " where student_id  like '$report_date_code%' and student_level != 7 ";
                    $sql_student  .=  " ORDER BY student_id ASC  ";
                   

                    $query_student = $conn->query($sql_student);
                    while ($result_student = $query_student->fetch_assoc()) {
                   
                        $student_id = $result_student['student_id'];
                    ?>
                        <tr>
                            <td width="10%"> <?php echo $result_student['student_id']; ?></td>
                            <td width="15%"><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></td>

                           


                            <?php
                                 include "config.inc.php";
                                 $sql_detail = " SELECT o.*, d.*, p.* , t.* , f.*";
                                 $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                                 $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE plan_id = $plan_id and (detail_complete = 1 or detail_date_complete!='0000-00-00') and (detail_date_last BETWEEN '$date_start' AND '$date_end') ) as d  ON  d.order_id = o.order_id";
                                 $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p  ON  p.plan_id = d.plan_id";
                                 $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                                 $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";


                                 $sql_detail  .=  " ORDER BY d.detail_id ASC ";
                                 $query_detail = $conn->query($sql_detail);
                                 $i=0;
                                 while ($result_detail = $query_detail->fetch_assoc()) {
                                 $i++;

                                   $detail_score = $result_detail['detail_score']; //คะแนนรวม
                                   $detail_date_work = $result_detail['detail_date_work']; //น้ำหนักรวม
                                   $detail_total = $result_detail['detail_total']; //คะแนนรวม / น้ำหนักรวม
                                   
                           ?>

                          <td  align="center"> 
                         
                          
                          <a href="#" data-toggle="tooltip" title="<?php echo $detail_date_work;?>"> <?php echo $detail_total;?> </a></td>



                           <?php
                           $detail_total_s = $detail_total_s + $detail_total;
                          
                          } 
                           
                           
                           ?>


                           <?php for ($x = 1; $x <= 15-$i; $x++) {  ?>
                            <td align="center"></td>
                           <?php } ?>

                           <td><?php echo $detail_total_s;?></td>
                       
                               
                                  
                               

                        </tr>
                    <?php 
                  $detail_total_s = 0;
                  
                  } ?>
                   
                </tbody>



            </table>

        </div><!-- /.table-responsive -->






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
             }, "print"]
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