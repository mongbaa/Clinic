<?php include"header.php";?>


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
                <h1> การจ่ายเคสผู้ป่วย </h1>
            </div>

            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                    <li class="breadcrumb-item active">การจ่ายเคสผู้ป่วย</li>
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
                <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูลผผู้ป่วย </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <div align="center">ลำดับที่</div>
                            </th>
                            <th>HN</th>
                            <th>pname</th>
                            <th>fname</th>
                            <th>lname</th>
                            <th>นทพ.</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?PHP
                        include "config.inc.php";
                        $sql   =  " SELECT * FROM tbl_order as o ";
                        $sql  .=  " WHERE order_type = 0 GROUP BY HN ";
                     //   $sql  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                      //  $sql  .=  " LEFT  JOIN  tbl_form_main   AS f  ON  f.form_main_id = p.form_main_id ";
                       // $sql  .=  " ORDER BY p.plan_id ASC ";
                        $query = $conn->query($sql);
                        $i=0;
                        while($result = $query->fetch_assoc())
                        {
                        $i++;
                        ?>

                        <tr class="odd gradeX">
                            <td align="center">
                                    
                                <?php echo $i;?>

                                            <?php
                                            
                                               /* include "config.inc_hosxp.php";
                                                $sql_img = "SELECT * FROM patient_image where hn = '$result[HN]' ";
                                                $query_img = $conn_hosxp->query($sql_img);
                                                $result_img  = $query_img->fetch_assoc();
                                                echo '<img src="data:image/jpeg;base64,'.base64_encode( $result_img['image'] ).'" width="80" height="90"/>';
                                               */

                                            ?>
                            
                            </td>
                            <td><?php echo $result['HN'];?></td>
                            <td><?php echo $result['pname'];?></td>
                            <td><?php echo $result['fname'];?></td>
                            <td><?php echo $result['lname'];?></td>
                            
                            <td>

                            <?PHP
                            $HN = $result['HN'];
                            include "config.inc.php";
                            $sql_order_student   =  " SELECT * FROM tbl_order as o ";
                            $sql_order_student  .=  " WHERE HN = $HN ";
                            $query_order_student= $conn->query($sql_order_student);
                            while($result_order_student = $query_order_student->fetch_assoc())
                            {
                            ?>

                          

                             <b><?php echo $result_order_student['student_id']; ?></b> 
                             <?php echo nameStudent::get_student_name($result_order_student['student_id']); ?>
                             <?php //echo $result_order_student['order_id']; ?>


                                    <?PHP
                                    $order_id = $result_order_student['order_id'];
                                    include "config.inc.php";
                                    $sql_detail   =  " SELECT * FROM tbl_detail as d ";
                                    $sql_detail  .=  " WHERE order_id = $order_id ";
                                    $query_detail= $conn->query($sql_detail);
                                    while($result_detail = $query_detail->fetch_assoc())
                                    {
                                    ?>
                                    <br>
                                    <?php echo $result_detail['detail_id'];?>

                                    <?php echo nameDetail::get_detail_name($result_detail['detail_id']); ?>
                                    <?php }?>

                            <br>
                            <br>


                            <?php }?>


                            </td>
                        </tr>

                        <?php }?>

                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

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