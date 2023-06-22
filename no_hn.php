<?php include "header.php";


if (!empty($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
} else {
    $student_id = $_SESSION['loginname'];
}


if (!empty($_GET['type_work_id'])) {
    $type_work_id = $_GET['type_work_id'];
} else {
    $type_work_id = "";
}

if (!empty($_GET['plan_ids'])) {
    $plan_ids = explode(',', $_GET['plan_ids']);
    $plan_id = $plan_ids[0];
    $form_main_id = $plan_ids[1];

    include "config.inc.php";
    $sql_form_main = "SELECT * FROM tbl_form_main where form_main_id='$form_main_id' ";
    $query_form_main = $conn->query($sql_form_main);
    $result_form_main = $query_form_main->fetch_assoc();
    $form_main_detail = $result_form_main['form_main_detail'];
} else {

    $plan_id = 0;
    $form_main_id = 0;
    $form_main_detail = 0;
}


if (!empty($_GET['del'])) {

    include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
    $arrange_nohn_id = $_GET['del'];
    $sql_del = "DELETE FROM tbl_arrange_nohn WHERE tbl_arrange_nohn.arrange_nohn_id = $arrange_nohn_id";
    $conn->query($sql_del);
    echo "<script type='text/javascript'>";
    //echo  "alert('บันทึกสำเร็จ');";
    echo "window.history.back(1)";
    echo "</script>";
}
?>


<?php 
if (isset($_SESSION['sessid']) && !empty($_SESSION['level_user'])) { 
}else{
  echo "<script type='text/javascript'>";
  echo  "alert('เช้าสู่ระบบก่อนใช้งาน....!');";
  echo "window.location='login.php'";
  echo "</script>";
}
?>


<?php		 
		function set_format_date($rub){
			if(!empty($rub)){
				list($yyy,$mmm,$ddd) = explode("-",$rub);
				$new_date = $ddd."-".$mmm."-".$yyy;
				return $new_date;
			}
		}
  ?>

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons 
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
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
<!-- Google Font: Source Sans Pro 
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->

<?php  include "sweetalert.php"; //  ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">


        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> กรณีไม่มีผู้ป่วย </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                        <li class="breadcrumb-item active">เพิ่มข้อมูลงาน</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->






        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-12 col-md-4">

                        <div class="card card-primary">

                            <div class="card-header">
                                <h3 class="card-title"> เลือก รายละเอียดงาน </h3>
                            </div>
                            <div class="card-body">








                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> เลือก งานของสาขา </label>
                                        <form name="myForm1" id="myForm1" action="" method="GET">

                                            <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
                                            <select name="type_work_id" id="type_work_id" class="form-control select2" onchange="this.form.submit()" required>
                                                <option value=""> เลือก งานของสาขา </option>
                                                <?php
                                                include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                                                $sql_type_work = "SELECT * FROM tbl_type_work";
                                                $query_type_work = $conn->query($sql_type_work);
                                                while ($result_type_work = $query_type_work->fetch_assoc()) {
                                                ?>
                                                    <option value="<?php echo $result_type_work['type_work_id']; ?>" <?php if (!(strcmp($result_type_work['type_work_id'], $type_work_id))) {
                                                                                                                            echo "selected=\"selected\"";
                                                                                                                        } ?>>
                                                        <?php echo $result_type_work['type_work_name']; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </form>
                                    </div>
                                </div>






                                <?php if (isset($_GET['type_work_id'])) { ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label> เลือกงาน กรณีไม่มีผู้ป่วย</label>
                                            
                                            <form name="myForm2" id="myForm2" action="" method="GET">

                                                <input name="type_work_id" type="hidden" value="<?php echo $type_work_id; ?>" />
                                                <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />

                                                <select name="plan_ids" id="plan_ids" class="form-control select2" onchange="this.form.submit()" required>
                                                    <option value=""> เลือกงาน  </option>
                                                    <?php
                                                    include "config.inc.php";
                                                    //  $sql_plan = "SELECT * FROM tbl_plan as p  ";
                                                    //  $sql_plan .= " where p.type_work_id = $type_work_id ";
                                                    $sql_plan = " SELECT p.* , t.* , f.*";
                                                    $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p ";
                                                    $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                                                    $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_type = 2 ) AS f  ON  f.form_main_id = p.form_main_id ";
                                                    $sql_plan  .=  " ORDER BY p.plan_id ASC ";
                                                    $query_plan = $conn->query($sql_plan);
                                                    $query_plan = $conn->query($sql_plan);
                                                    while ($result_plan = $query_plan->fetch_assoc()) {

                                                    ?>
                                                        <option value="<?php echo $result_plan['plan_id']; ?>,<?php echo $result_plan['form_main_id']; ?>" <?php if (!(strcmp($result_plan['plan_id'], $plan_id))) {
                                                                                                                                                                echo "selected=\"selected\"";
                                                                                                                                                            } ?>>
                                                            <?php echo $result_plan['plan_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                <?php } ?> 



                                <?php if (isset($_GET['plan_ids'])) { ?>



                                    <form name="multilistbox" method="POST" action="arrange_nohn_q.php">
                                        <input name="plan_id" type="hidden" value="<?php echo $plan_id; ?>" />
                                        <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
                                        <input name="arrange_nohn_type" type="hidden" value="2" />
                                        <input name="type_work_id" type="hidden" value="<?php echo $type_work_id; ?>" />

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <select name="arrange_nohn_time_type" class="form-control select2" style="width: 100%;" required>
                                                    <option value="AM" selected="selected"> เช้า </option>
                                                    <option value="PM"> บ่าย </option>
                                                   </select>
                                            </div>
                                         </div>
                                    

                                         
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="date" name="arrange_nohn_date" class="form-control" placeholder="วันที่" value="<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                        </div>


                                        
                                
                                        <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" name="arrange_nohn_detail" class="form-control" placeholder="รายละเอียด" value="">
                                        </div>
                                        </div>
                             



                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <select name="teacher_id" class="form-control select2" style="width: 100%;" required>
                                                    <option value="" selected="selected">
                                                        เลือกอาจารย์ผู้ประเมิน</option>

                                                    <?PHP
                                                    //include "config.inc.php";
                                                    //$sql_t =  "SELECT * FROM tbl_teacher where type_work_id = $type_work_id";

                                                    $detail_type_work_id  = $type_work_id;

                                                    $type_work_idss = sprintf("%02d", $detail_type_work_id);
                                                    include "config.inc.php";
                                                    $sql_t =  "SELECT * FROM tbl_teacher where  teacher_status = 1 and type_work_id_array like '%$type_work_idss%'";

                                                    $query_t = $conn->query($sql_t);
                                                    while ($result_t = $query_t->fetch_assoc()) {

                                                    ?>

                                                        <option value="<?php echo $result_t['teacher_id']; ?>">
                                                            <?php echo $result_t['teacher_name']; ?>
                                                            <?php echo $result_t['teacher_surname']; ?>
                                                        </option>

                                                    <?php   } ?>

                                                </select>
                                            </div>
                                        </div>






                                        <div class="col-12">
                                            <input type="submit" name="Submit" class="btn btn-info" value="ส่งประเมิน" />
                                        </div>

                                    </form>


                                <?php } ?>


                            </div>
                        </div>


                    </div>










                    <?php if (!empty($_GET['type_work_id'])) { ?>
                        <div class="col-12 col-md-8">
                            <div class="card card-primary color-palette-box">
                                <div class="card-header">
                                    <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูลการส่งประเมิน </h3>
                                </div>
                                <!-- /.card-header -->

                                <div class="card-body">
                                  

  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th><div align="center">ลำดับที่</div></th>
                      <th>งาน</th>
                      <th>วันที่ลงปฎิบัติงาน</th>
                      <th>วันเวลาส่ง</th>
                      <th>สถานะการประเมิน</th>
                      <th>อาจารย์</th>
                      <th>รายละเอียด</th>
                      <th>จัดการข้อมูล</th>
                    </tr>
                  </thead>
                      
                  <tbody>
                                          
                    <?PHP
                    include "config.inc.php";
                    $student_id = $_SESSION['loginname'];
                    $sql   = " SELECT a.*, p.*, t.* FROM  ( SELECT * FROM tbl_arrange_nohn where type_work_id = $type_work_id and student_id = $student_id )  as a  ";
                    $sql  .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = a.plan_id ";
                    $sql  .= " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                    $sql  .= " ORDER BY a.arrange_nohn_id DESC";

                 
                    $query = $conn->query($sql);
                    $i=0;
                    while($result = $query->fetch_assoc())
                    {
                    $i++;
                    ?>

                     <tr class="odd gradeX"> 
                      <td align="center"><?=$i;?></td>
                      <td>  
                      <h5><span class='badge bg-info'><?php echo nameType_work::get_type_work_name($result['type_work_id']);?></span></h5>
                      <?php echo $result['plan_name'];?>  
                      </td>

                      <td><?php echo set_format_date($result['arrange_nohn_date']);?> <?php echo $result['arrange_nohn_time_type'];?>  </td>
                      <td><?php echo set_format_date($result['arrange_nohn_record_date']);?> <?php echo $result['arrange_nohn_time'];?> </td>
                     
                      <td>
                      <?php
                                $arrange_nohn_check_eval = $result['arrange_nohn_check_eval'];
                                switch ($arrange_nohn_check_eval) { // Harder page
                                    case 1:
                                        echo  "<i class='fas fa-check-circle' style='font-size:18px;color:#27AE60'> ประเมินคะแนนแล้ว </i>";
                                        break;
                                    case 0:
                                        echo  "<i class='fas fa-times-circle' style='font-size:18px;color:red'> รอรับการประเมิน </i>";
                                        break;
                                    default:
                                        echo  "<i class='fas fa-history'></i> -";
                                        break;
                                }
                                ?>
                    
                    </td>
                      <td><?php  echo nameTeacher::get_teacher_name($result['teacher_id']);?>
                    
                    
                    </td>
                      <td><?php echo $result['arrange_nohn_detail'];?></td>
                      <td>
                      <?php if($result['arrange_nohn_check_eval']==0){?>
                      <a href="?del=<?php echo $result['arrange_nohn_id'];?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการยกเลิกอีกครั้ง !!!')"> ยกเลิกการส่งงาน </a>  
                      <?php }?>
                      </td>          
                    </tr>

                    
                  <?php }?>
                    
                  </tbody>
                </table>


                                    <font color="red">*** กรณี ลบ จะสามารถทำได้หาก อาจารย์ยังไม่ประเมินคะแนน </font>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                      </div>
                    <?php } ?>






            </div>



          













</div>
</section>




</section>
<!-- /.content -->

<!-- /.content-wrapper -->













<?php include 'footer.php'; ?>


<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<!-- page script -->
<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
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






<script>
    $(document).ready(function() {
        $("#myModal").modal('show');
    });
</script>




<script type="text/javascript">
    /*$(document).ready(function() {
$('#type_work_id').change(function() {
$.ajax({
type: 'POST',
data: {type_work_id: $(this).val()},
url: 'select_plan.php',
success: function(data) {
$('#plan_id').html(data);
}
});
return false;
});
});*/
</script>


</body>

</html>