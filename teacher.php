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

if (isset($_GET['edit'])) {

    include "config.inc.php";

    $sql_edit = "SELECT * FROM tbl_teacher where teacher_id='$_GET[edit]' ";
    $query_edit = $conn->query($sql_edit);
    $result_edit = $query_edit->fetch_assoc();
    $teacher_id = $result_edit['teacher_id'];
    $teacher_doctorcode = $result_edit['teacher_doctorcode'];
    $teacher_loginname = $result_edit['teacher_loginname'];
    $teacher_name = $result_edit['teacher_name'];
    $teacher_surname = $result_edit['teacher_surname'];
    $type_work_id = $result_edit['type_work_id'];
    $teacher_licences_status = $result_edit['teacher_licences_status'];
    $teacher_status = $result_edit['teacher_status'];
    $teacher_log = $result_edit['teacher_log'];


        if(!empty($result_edit['type_work_id_array'])){
            $type_work_id_array = $result_edit['type_work_id_array'];
        }else{
            $type_work_id_array = "[]";
        }
    

} else {

    $teacher_id = "";
    $teacher_doctorcode = "";
    $teacher_loginname = "";
    $teacher_name = "";
    $teacher_surname = "";
    $type_work_id = "";
    $teacher_licences_status = "";
    $teacher_status = "";
    $teacher_log = "";
    $type_work_id_array = "[]";
}

?>







    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-8">
                    <h1>Data teacher</h1>
                </div>

                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                        <li class="breadcrumb-item student_active">Data teacher</li>
                    </ol>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">





            <form name="form1" method="post" action="">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"> Teacher </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"> Teacher </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">


                                <div class="row">

                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

                                    <input name="teacher_id" type="hidden" value="<?php echo $teacher_id; ?>" />


                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Doctorcode</label>
                                            <input type="text" name="teacher_doctorcode" class="form-control" placeholder="Doctorcode" value="<?php echo $teacher_doctorcode; ?>" required>
                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Loginname</label>
                                            <input type="text" name="teacher_loginname" class="form-control" placeholder="Loginname" value="<?php echo $teacher_loginname; ?>" required>
                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>ชื่อ</label>
                                            <input type="text" name="teacher_name" class="form-control" placeholder="ชื่อ" value="<?php echo $teacher_name; ?>" required>
                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>นามสกุล</label>
                                            <input type="text" name="teacher_surname" class="form-control" placeholder="นามสกุล" value="<?php echo $teacher_surname; ?>" required>
                                        </div>
                                    </div>



                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>สาขาวิชาหลัก</label>
                                            <select name="type_work_id" id="type_work_id" class="form-control select2" required>
                                                <option value="">  สาขาวิชา </option>
                                                <?php include "config.inc.php";
                                                $sql_type_work = "SELECT * FROM  tbl_type_work ";
                                                $query_type_work = $conn->query($sql_type_work);
                                                while ($result_type_work  = $query_type_work->fetch_assoc()) {
                                                ?>
                                                    <option value="<?php echo $result_type_work['type_work_id']; ?>" <?php if (!(strcmp($result_type_work['type_work_id'], $type_work_id))) {
                                                                                                                            echo "selected=\"selected\"";
                                                                                                                        } ?>>
                                                        <?php echo $result_type_work['type_work_name']; ?></option>
                                                <?php  }  ?>
                                            </select>
                                        </div>
                                    </div>



                                    <?php  
                                    
                                
                                    
                                    $array_type_work_id = json_decode($type_work_id_array, true);
                                    //var_dump($array_type_work_id);

                                    ?>
                                    
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>สาขาวิชา ประเมินคะแนน</label>
                                            <select name="type_work_id_array[]" class="select2" multiple="multiple" data-placeholder="สาขา" data-dropdown-css-class="select2-purple" style="width: 100%;">

                                                <option value="">  สาขาวิชา </option>
                                                <?php include "config.inc.php";
                                                $sql_type_work = "SELECT * FROM  tbl_type_work  ";
                                                $query_type_work = $conn->query($sql_type_work);
                                                while ($result_type_work  = $query_type_work->fetch_assoc()) {

                                                    echo $type_work_idss = sprintf("%02d", $result_type_work['type_work_id']);
                                                   // echo $type_work_idss = $result_type_work['type_work_id'];

                                                ?>
                                                    <option value="<?php echo $type_work_idss; ?>"  <?php if (in_array($type_work_idss, $array_type_work_id)) { echo " selected "; }?> >
                                                        <?php echo $result_type_work['type_work_name']; ?> </option>
                                                <?php  }  ?>
                                            </select>
                                        </div>
                                    </div>










                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>licences</label>
                                            <input type="text" name="teacher_licences_status" class="form-control" placeholder="licences" value="<?php echo $teacher_licences_status; ?>" required>
                                        </div>
                                    </div>





                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>สถานะ</label>
                                            <select name="teacher_status" id="teacher_status" class="form-control select2" required>
                                                <option value=""> สถานะ </option>
                                                <option value="0" <?php if (!(strcmp(0, $teacher_status))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>
                                                    ปิดการใช้งาน</option>
                                                <option value="1" <?php if (!(strcmp(1, $teacher_status))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>
                                                    เปิดการใช้งาน</option>
                                            </select>
                                        </div>
                                    </div>

                                    <input name="teacher_log" type="hidden" value="<?php echo $teacher_log; ?>" />

                                </div>

                            </div><!-- /.card-body -->

                            <div class="card-footer text-muted">
                                <div class="col-sm-12">
                                    <div class="form-group">

                                        <?php if (isset($_GET['edit'])) { ?>
                                            <button name="submit" type="submit" value="submit" class="btn btn-info">
                                                Edit</button>
                                            <a href="?" class="btn btn-default"></i> Cancel </a>
                                        <?php } else { ?>
                                            <button name="submit" type="submit" value="submit" class="btn btn-info"> Submit
                                            </button>
                                            <button type="reset" class="btn btn-default"> Reset </button>
                                        <?php } ?>

                                    </div>
                                </div>

                            </div>


                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card card-secondary -->

            </form>





            <?php

            if (isset($_POST['submit'])) {
                include "config.inc.php";

                if (isset($_POST['teacher_id'])  && !empty($_POST['teacher_id'])) {
                    $teacher_id = $conn->real_escape_string($_POST['teacher_id']);
                } else {
                    $teacher_id = 0;
                }

                if (isset($_POST['teacher_doctorcode'])  && !empty($_POST['teacher_doctorcode'])) {
                    $teacher_doctorcode = $conn->real_escape_string($_POST['teacher_doctorcode']);
                } else {
                    $teacher_doctorcode = '';
                }

                if (isset($_POST['teacher_loginname'])  && !empty($_POST['teacher_loginname'])) {
                    $teacher_loginname = $conn->real_escape_string($_POST['teacher_loginname']);
                } else {
                    $teacher_loginname = '';
                }

                if (isset($_POST['teacher_name'])  && !empty($_POST['teacher_name'])) {
                    $teacher_name = $conn->real_escape_string($_POST['teacher_name']);
                } else {
                    $teacher_name = '';
                }

                if (isset($_POST['teacher_surname'])  && !empty($_POST['teacher_surname'])) {
                    $teacher_surname = $conn->real_escape_string($_POST['teacher_surname']);
                } else {
                    $teacher_surname = '';
                }

                if (isset($_POST['type_work_id'])  && !empty($_POST['type_work_id'])) {
                    $type_work_id = $conn->real_escape_string($_POST['type_work_id']);
                } else {
                    $type_work_id = 0;
                }

                
                if(isset($_POST['type_work_id_array'])){

                    $type_work_id_array = json_encode($_POST['type_work_id_array']);  // implode(', ', $_POST['type_work_id_array']);
            
                }else{ 
            
                    $type_work_id_array = json_encode([]);
            
                }



                if (isset($_POST['teacher_licences_status'])  && !empty($_POST['teacher_licences_status'])) {
                    $teacher_licences_status = $conn->real_escape_string($_POST['teacher_licences_status']);
                } else {
                    $teacher_licences_status = 0;
                }

                if (isset($_POST['teacher_status'])  && !empty($_POST['teacher_status'])) {
                    $teacher_status = $conn->real_escape_string($_POST['teacher_status']);
                } else {
                    $teacher_status = 0;
                }

                if (isset($_POST['teacher_log'])  && !empty($_POST['teacher_log'])) {
                    $teacher_log = $conn->real_escape_string($_POST['teacher_log']);
                } else {
                    $teacher_log = '';
                }


                if (!empty($teacher_id)) {
                    

                    $sql_up = "UPDATE tbl_teacher SET teacher_doctorcode = '$teacher_doctorcode', teacher_loginname = '$teacher_loginname', teacher_name = '$teacher_name', teacher_surname = '$teacher_surname', type_work_id = '$type_work_id', type_work_id_array = '$type_work_id_array', teacher_licences_status = '$teacher_licences_status', teacher_status = '$teacher_status', teacher_log = '$teacher_log' WHERE  teacher_id = '$teacher_id'";
                    $conn->query($sql_up);
                } else {

                    $sql_in = " INSERT INTO tbl_teacher (teacher_id,teacher_doctorcode,teacher_loginname,teacher_name,teacher_surname,type_work_id, type_work_id_array, teacher_licences_status,teacher_status,teacher_log) VALUES (NULL,'$teacher_doctorcode','$teacher_loginname','$teacher_name','$teacher_surname','$type_work_id', '$type_work_id_array', '$teacher_licences_status','$teacher_status','$teacher_log')";
                    $conn->query($sql_in);
                }



                echo "<script type='text/javascript'>";
                //echo "alert('[ OK Success]');";
                echo "window.location='teacher.php';";
                echo "</script>";
            }

            ?>




<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />





            <!-- Default box -->
            <div class="card">
                <div class="card-header">

                    <h3 class="card-title">
                    Data TEACHER   
                    <a href="teacher_input.php" class="btn btn-danger" onclick="return confirm('กรุณายืนยันอีกครั้ง !!!')"> + นำเข้ารายชื่ออาจารย์ </a>
                    </h3>


                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Doctorcode</th>
                                <th>Loginname</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>สาขาวิชา</th>
                                <th>สาขาวิชาประเมิน</th>
                                <th>licences</th>
                                <th>สถานะ</th>
                                <th>log</th>
                                <th>จัดการข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?PHP include "config.inc.php";
                            $sql = " SELECT * FROM tbl_teacher as teacher ";
                            $sql .= " ORDER BY teacher.teacher_id ASC ";
                            $query = $conn->query($sql);
                            $i = 0;
                            while ($result = $query->fetch_assoc()) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                    <td><?php echo $result['teacher_doctorcode']; ?> </td>
                                    <td><?php echo $result['teacher_loginname']; ?> </td>
                                    <td><?php echo $result['teacher_name']; ?> </td>
                                    <td><?php echo $result['teacher_surname']; ?> </td>
                                    <td>
                                        
                                     <?php 
                                     
                                     echo nameType_work::get_type_work_name($result['type_work_id']);





                                   /*  echo "<br>";
                                     echo  $ii = sprintf("%02d", $result['type_work_id']);
                                     echo "<br>";
                                     if(!empty($result['type_work_id'])){
                                        echo $type_work_id_array = json_encode([$ii]); 
                                    }else{ 
                                        echo $type_work_id_array = json_encode([]);
                                    }
                
                                    echo  $sql_up = "UPDATE  tbl_teacher SET type_work_id_array = '$type_work_id_array'  WHERE  teacher_id = '$result[teacher_id]'";
                                      $conn->query($sql_up);
                                     
                                    */
                                     
                                     
                                     ?>
                                
                                
                                
                                
                                    </td>

                                    <td>
                                    <?php 
                                    $type_work_id_array = $result['type_work_id_array'];                                 
                                    $array_type_work_id = json_decode($type_work_id_array, true);
                                    foreach ($array_type_work_id as $value) {
                                        echo nameType_work::get_type_work_name($value);
                                        echo "<br>";
                                      }
                                    ?> 
                                   </td>
                                    
                                    <td><?php echo $result['teacher_licences_status']; ?> </td>
                                    <td>
                                        <?php
                                        $manage_store_status = $result['teacher_status'];
                                        switch ($manage_store_status) { // Harder page
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
                                    <td><?php echo $result['teacher_log']; ?> </td>
                                    <td>
                                        <a href="?edit=<?php echo $result['teacher_id']; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> Edit </a>
                                    <!--     <a href="?del=<?php echo $result['teacher_id']; ?>" class="btn btn-danger" onClick="return confirm('ยืนยันการลบอีกครั้ง..!!!')">
                                            <i class="fas fa-trash-alt"></i> Delete </a>-->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
            <!-- /.card -->








        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


<?php include "footer.php"; ?>

<!-- DataTables -->

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