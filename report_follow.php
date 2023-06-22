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
if (isset($_GET['level_search'])) {
    $level_search = $_GET['level_search'];
} else {
    $level_search = 4;
}

if (isset($_GET['student_search'])) {
    $student_search = $_GET['student_search'];
    $student_id = $student_search;
} else {
    $student_search = "";
    $student_id = "";
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


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1> ติดตามงานนักศึกษาและผู้ป่วย </h1>
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


        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-search"></i> ค้นหาข้อมูล </h3>
            </div>

            <div class="card-body">
                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="row">


                        <input type="hidden" name="level_search" value="<?php echo $level_search; ?>">


                        <div class="col-sm-3">
                            <?php for ($i = 4; $i <= 6; $i++) { ?>
                                <a href="?level_search=<?php echo $i; ?>" <?php if ($level_search == $i) { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ชั้นปีที่ <?php echo $i; ?> </a>
                            <?php } ?>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <select name="student_search" id="student_search" class="form-control select2" onchange="this.form.submit()" required>

                                    <option value=""> เลือก </option>
                                    <?php include "config.inc.php";
                                    $sql_student = "SELECT * FROM  tbl_student where student_status = 0 and student_level = $level_search and student_active = 1";
                                    $query_student = $conn->query($sql_student);
                                    while ($result_student  = $query_student->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $result_student['student_id']; ?>" <?php if (!(strcmp($result_student['student_id'], $student_id))) {
                                                                                                            echo "selected=\"selected\"";
                                                                                                        } ?>>
                                            <?php echo $result_student['student_id']; ?> <?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></option>
                                    <?php  }
                                    $conn->close();
                                    ?>
                                </select>
                            </div>
                        </div>




                                    <?php
                                    if (isset($_GET['type_work_id'])) {
                                        $type_work_id = $_GET['type_work_id'];
                                        $type_work_id_implode = implode(', ', $type_work_id);
                                        $type_work_id_arrary = explode(",", $type_work_id_implode);
                                    } else {
                                        $type_work_id = 1;
                                        $type_work_id_implode = "";
                                        $type_work_id_arrary = array("1", "2", "4", "5");
                                    }
                                    ?>
                                    <div class="col-sm-10">
                                        <label> <input type="checkbox" id="checkbox_type_work_id3"> Select All </label>
                                        <script src="plugins/jquery/jquery.min.js"></script>
                                        <script>
                                            $(document).ready(function() {
                                                $("#checkbox_type_work_id3").click(function() {
                                                    if ($("#checkbox_type_work_id3").is(
                                                            ':checked')) { //select all
                                                        $("#etype_work_id").find('option').prop("selected", true);
                                                        $("#etype_work_id").trigger('change');
                                                    } else { //deselect all
                                                        $("#etype_work_id").find('option').prop("selected", false);
                                                        $("#etype_work_id").trigger('change');
                                                    }
                                                });
                                            });
                                        </script>
                                        <div class="form-group">
                                            <div class="select2-purple">



                                            <select name="type_work_id[]" id="etype_work_id" class="select2" multiple="multiple" data-placeholder=" เลือก  " data-dropdown-css-class="select2-purple" style="width: 100%;">



                                            <?PHP
                                            include "config.inc.php";
                                            $sql_type_work = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                                            $query_type_work = $conn->query($sql_type_work);
                                            while ($result_type_work  = $query_type_work->fetch_assoc()) {

                                                
                                                    $type_work_id = $result_type_work['type_work_id'];
                                                    $type_work_name = $result_type_work['type_work_name'];
                                                
                                            ?>
                                                    <option value="<?php echo $type_work_id;?>" <?php if (in_array($type_work_id, $type_work_id_arrary)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>> <?php echo $type_work_name;?> </option>


                                            <?php } $conn->close(); ?>
                                                   
                                                   

                                                </select>
                                            </div>
                                        </div>
                                    </div>


                        <div class="col-sm-2">
                            <button class="btn btn-info" type="submit">Search</button>
                        </div>

                    </div>
                </form>

            </div><!-- /.card-body -->
        </div><!-- /.card -->
 


        <style>
            .table-responsive {
                height: 800px;
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


         if (!empty($type_work_id_implode)) {
            $sql_type_work_id = " WHERE type_work_id in ($type_work_id_implode) ";
        } else {
            $sql_type_work_id = "";
        }



        // สร้าง array 2 มิติ
        $type_work_array = array();
        include "config.inc.php";
        $sql_work =  " SELECT * FROM tbl_type_work $sql_type_work_id ";
        $query_work = $conn->query($sql_work);
        while ($result_work = $query_work->fetch_assoc()) {

            $type_work_array[] = array(
                'type_work_name' => $result_work['type_work_name'],
                'type_work_id' => $result_work['type_work_id']
            );
        }
        // var_dump($type_work_array);
        $conn->close();
        ?>





        <?php
        include "config.inc.php";
        $sql_student   =  " SELECT * FROM  tbl_student where student_id = '$student_id' ";
        $sql_student  .=  " ORDER BY student_id ASC   ";
        $query_student = $conn->query($sql_student);
        if ($result_student = $query_student->fetch_assoc()) {

            $student_id = $result_student['student_id'];
            $student_name = $result_student['student_name'];
            $student_lastname = $result_student['student_lastname'];
            $student_level = $result_student['student_level'];
            $student_group = $result_student['student_group'];

        } else {

            $student_id = "9999999";
            $student_name = "";
            $student_lastname = "";
            $student_level = "";
            $student_group = "";
        }

        $conn->close();
        ?>








        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> <?php echo $student_id . " : " . $student_name . " " . $student_lastname; ?> </h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">


                    <table id="example13" border="0" cellpadding="0" class="table">
                        <thead>
                            <tr>
                                <th Width="10%">ชื่อ สกุล ผู้ป่วย </th>
                                

                                <?php
                                foreach ($type_work_array as $values => $data) {
                                    $type_work_id = $data['type_work_id'];
                                    $type_work_name = $data['type_work_name'];
                                ?>
                                    <th width="5%">
                                        <div align="center"><?php echo $type_work_name; ?></div>
                                    </th>
                                <?php } ?>

                            </tr>




                            <tr>
                              
                            
                                <td Width="10%">ชื่อ สกุล</td>
                             

                                <?php
                                foreach ($type_work_array as $values => $data) {
                                    $type_work_id = $data['type_work_id'];
                                    $type_work_name = $data['type_work_name'];
                                ?>
                                    <td width="5%">
                                        <div align="center"><?php echo $type_work_name; ?></div>
                                    </td>
                                <?php } ?>

                            </tr>


                        </thead>

                        <tbody>
                            <?php
                            include "config.inc.php";
                            $sql_order  =  " SELECT * FROM tbl_order WHERE student_id = $student_id ORDER BY order_date DESC";
                            $query_order = $conn->query($sql_order);
                            while ($result_order = $query_order->fetch_assoc()) {

                                if($result_order['causes_of_pay_id']!=0)
                                $bgcolor = "#B5EAD7";
                                else
                                $bgcolor = "#FF9AA2";
                                
                            ?>
                                <tr style="background-color:<?php echo $bgcolor;?>">
                                   
                                  
                                    <td width="10%">
                                        
                                    <?php echo $result_order['HN']; ?> 
                                    
                                    <br> <?php echo $result_order['fname']; ?> <?php echo $result_order['lname']; ?> 
                                    <br> <?php echo $result_order['order_date']; ?>
                                    <br> <?php  echo nameCauses_of_pay::get_causes_of_pay_name($result_order['causes_of_pay_id']);?>
                                
                                
                                </td>
                                   
                                  
                                  <?php
                                    foreach ($type_work_array as $values => $data) {
                                        $type_work_id = $data['type_work_id'];
                                        $type_work_name = $data['type_work_name'];
                                    ?>
                                        <td>
                                            <div align="center">
                                                

                                                    <?PHP
                                                    $order_id = $result_order['order_id'];
                                                    $sql_detail   = " SELECT d.*, p.*  FROM  ";
                                                    $sql_detail  .= "  ( SELECT * FROM tbl_detail where order_id = $order_id and detail_type_work_id = $type_work_id) as d ";
                                                    $sql_detail  .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id ";
                                                    $sql_detail  .=  " ORDER BY d.detail_id DESC  ";
                                                    $query_detail = $conn->query($sql_detail);
                                                    while ($result_detail = $query_detail->fetch_assoc()) {

                                                        if($result_detail['causes_of_pay_id']!=0)
                                                        $bgcolor_d = "#7ad6b5";
                                                        else
                                                        $bgcolor_d = "#f76f7a";
                                                    ?>
                                                        

                                                        <div class="card card-default">
                                                            <div class="card-header" style="background-color:<?php echo $bgcolor_d;?>">

                                                            
                                                            <font size = "2">
                                                                <B><?php echo namePlan::get_plan_name($result_detail['plan_id']); ?></B>  
                                                              
                                                            <br>
                                                                <?php
                                                                $array_detail_tooth = (array)json_decode($result_detail['detail_tooth']);
                                                                $toothh = "";
                                                                foreach ($array_detail_tooth as $id => $value) {
                                                                $toothh .= $value . ", ";
                                                                }
                                                                ?>
                                                                 <b><?php echo substr($toothh, 0, -2); ?></b>

                                                                 </font>
                                                              

                                                           

                                                            </div>

                                                            <div class="card-body">
                                                                 
                                                         

                                                                <?PHP
                                                                $detail_id = $result_detail['detail_id'];
                                                                include "config.inc.php";
                                                                $sql__arrange   =  " SELECT * FROM tbl_arrange where  detail_id = $detail_id ";
                                                                $query__arrange = $conn->query($sql__arrange);
                                                                while ($result_arrange= $query__arrange->fetch_assoc()) {
                                                                ?>


                                                                    <font size = "2"><?php echo $result_arrange['arrange_date']; ?> 
                                                                
                                                                
                                                                
                                                                <?php $teacher = nameTeacher::get_teacher_name($result_arrange['teacher_id']); 
                                                                
                                                                 $arrange_check_eval = $result_arrange['arrange_check_eval'];
                                                                 switch ($arrange_check_eval) { // Harder page
                                                                   case 1:
                                                                     echo  "<a href='#' data-toggle='tooltip' title='$teacher'><i class='fas fa-check-circle' style='font-size:20px;color:green'></i></a>";
                                                                     break;
                                                                   case 0:
                                                                     echo  "<a href='#' data-toggle='tooltip' title='$teacher'><i class='fas fa-history' style='font-size:20px;color:gray'></i></a>";
                                                                     break;
                                                                   default:
                                                                     echo  "<i class='fas fa-history'></i> -";
                                                                     break;
                                                                 }
                                                                ?>
                                                                
                                                                </font>
                                                                    <br>
                                                                   

                                                              


                                                                    
                                                                 
                                                                    <br>
                                                                  


                                                                <?php 
                                                                }
                                                                ?>



                                                            </div>

                                                        </div>


                                                        



                                                    <?php }?>

                                        
                                            </div>
                                        </td>
                                    <?php } ?>

                                </tr>
                            <?php
                            }
                            $conn->close();
                            ?>
                        </tbody>
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