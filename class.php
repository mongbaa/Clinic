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
                <h1>ข้อมูลงาน / Class </h1>
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



        <div class="card card-default color-palette-box">


            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-plus"></i> ข้อมูล Class </h3>
            </div>



            <div class="card-body">
                <?php
							
					 if(isset($_GET['edit']))
                        {
						include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
						$class_id=$_GET['edit'];
            $sql_edit="SELECT * FROM tbl_class where class_id = $class_id ";
						$query_edit = $conn->query($sql_edit);
						$result_edit = $query_edit->fetch_assoc();
						 
             $class_id = $result_edit['class_id'];
						 $class_name = $result_edit['class_name'];
						 $class_score = $result_edit['class_score'];
						 $competency4 = $result_edit['competency4'];
             $competency5 = $result_edit['competency5'];
             $competency6 = $result_edit['competency6'];
						// $class_sub=$result_edit['class_sub'];
						 
						}else{

             $class_id = "";
						 $class_name = "";
						 $class_score = "";
						 $competency4 = "";
						 $competency5 = "";
             $competency6 = "";
						 
					   }
							
							
						if(isset($_GET['del']))
                        {
						include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
						$class_id=$_GET['del'];
            $sql_del="DELETE FROM tbl_class WHERE tbl_class.class_id = $class_id";
						$conn->query($sql_del); 
						echo "<script type='text/javascript'>";
						//echo  "alert('บันทึกสำเร็จ');";
						echo "window.location='class.php'";
						echo "</script>";
							 
						}
			?>




                <form name="form1" method="post" action="" enctype="multipart/form-data">

                    <input type="hidden" name="class_id" value="<?php echo @$result_edit['class_id'];?>">

                    <div class="row">



                        <div class="col-sm-3">
                            <input type="text" name="class_name" class="form-control" value="<?php echo $class_name;?>"
                                placeholder="ชื่องาน" required>
                        </div>

                        <div class="col-sm-1">
                            <input type="text" name="class_score" class="form-control"
                                value="<?php echo $class_score;?>" placeholder="หน่วย" required>
                        </div>

                        <div class="col-sm-1">
                            <input type="number" name="competency4" class="form-control"
                                value="<?php echo $competency4;?>" placeholder="c4" required>
                        </div>

                        <div class="col-sm-1">
                            <input type="number" name="competency5" class="form-control"
                                value="<?php echo $competency5;?>" placeholder="c5" required>
                        </div>

                        <div class="col-sm-1">
                            <input type="number" name="competency6" class="form-control"
                                value="<?php echo $competency6;?>" placeholder="c6" required>
                        </div>




                        <div class="col-sm-2">

                            <?php  if(isset($_GET['edit'])) {?>

                            <input type="submit" name="submit" class="btn btn-info" id="button" value="แก้ไข">
                            <a href="?" class="btn btn-danger"> ยกเลิก </a>

                            <?php }else{?>
                            <input type="submit" name="submit" class="btn btn-primary" id="button" value="เพิ่ม">
                            <?php }?>
                        </div>

                    </div>
                </form>
                <?php
							
					 if(isset($_POST['submit']))  
                        {
						  include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
						 
						if($_POST['class_id']!="")
                        {
						
                         $sql_update= "UPDATE tbl_class SET class_name = '$_POST[class_name]' , class_score = '$_POST[class_score]' ,  competency4='$_POST[competency4]' ,  competency5='$_POST[competency5]' ,  competency6='$_POST[competency6]'   WHERE tbl_class.class_id = $_POST[class_id]";
                         $conn->query($sql_update); 

                         echo "<script type='text/javascript'>";
                         echo  "alert('บันทึกสำเร็จ');";
                         echo "window.location='class.php'";
                         echo "</script>";
							
						}else{

							
                         $sql_insert= "INSERT INTO tbl_class (class_id, class_name, class_score, competency4, competency5 , competency6  ,class_status) VALUES (NULL, '$_POST[class_name]' , '$_POST[class_score]' , '$_POST[competency4]', '$_POST[competency5]', '$_POST[competency6]', 1 )";
                         $conn->query($sql_insert); 
                         $class_id = $conn -> insert_id;

                          echo "<script type='text/javascript'>";
                          echo  "alert('บันทึกสำเร็จ');";
                          echo "window.location='class.php?edit=$class_id'";
                          echo "</script>";
							
						}
								
						

						
							 
						}
			?>

            </div><!-- /.card-body -->

        </div><!-- /.card -->



        <div class="card card-default color-palette-box">


            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-teeth"></i> ข้อมูล Class </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <div align="center">ลำดับที่</div>
                            </th>
                            <th>ชื่อ Class</th>
                            <th>หน่วยงาน</th>
                            <th>Competency 4</th>
                            <th>Competency 5</th>
                            <th>Competency 6</th>
                            <th>จัดการข้อมูล</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?PHP
                        include "config.inc.php";
                        $sql   =  " SELECT * FROM tbl_class as c ";           
                        $sql  .=  " ORDER BY c.class_id ASC ";
                        $query = $conn->query($sql);
                        $i=0;
                        while($result = $query->fetch_assoc())
                        {
                        $i++;
                        ?>

                        <tr class="odd gradeX">
                            <td align="center"><?=$i;?></td>
                            <td><?php echo $result['class_name'];?></td>
                            <td><?php echo $result['class_score'];?></td>
                            <td><?php echo $result['competency4'];?></td>
                            <td><?php echo $result['competency5'];?></td>
                            <td><?php echo $result['competency6'];?></td>
                            <td class="center">
                                <a href="?del=<?php echo $result['class_id'];?>" class="btn btn-danger"
                                    onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> ลบ </a>
                                <a href="?edit=<?php echo $result['class_id'];?>" class="btn btn-info"> แก้ไข </a>
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


<?php include "footer.php";?>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
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