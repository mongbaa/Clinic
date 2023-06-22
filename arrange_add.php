<?php include "header.php";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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

          <?php 
          if(isset($_GET['del']))
                      {

                          include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                          $arrange_id=$_GET['del'];
                          $sql_del="DELETE FROM tbl_arrange WHERE tbl_arrange.arrange_id = $arrange_id";
                          $conn->query($sql_del); 
                          echo "<script type='text/javascript'>";
                          //echo  "alert('บันทึกสำเร็จ');";
                          echo "window.location='arrange_add.php?do=success'";
                          echo "</script>"; 
                        
                      }

          ?>			
          
          
 <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
  <section class="content-header">
               
  
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1> ประวัติการส่งงานประเมินคะแนน </h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                      <li class="breadcrumb-item active">รายการ งานทั้งหมด </li>
                      </ol>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->






    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
      


        
        <div class="card card-primary color-palette-box">
				
              <div class="card-header">
                <h3 class="card-title">	<i class="fas fa-list-alt"></i> ข้อมูลประวัติการส่งงานประเมินคะแนน </h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th><div align="center">ลำดับที่</div></th>
                          
                          <th>ลงปฏิบัติงาน</th>
                          <th>งาน</th>
                          <th>ประเภท</th>
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
                        include "config.inc.php";
                        $student_id = $_SESSION['loginname'];
                        $sql   = " SELECT a.*, d.*, p.*, t.*, o.* FROM  ( SELECT * FROM tbl_arrange where  arrange_type = 0 )  as a  ";
                        $sql  .= " INNER JOIN  tbl_detail   AS d  ON  a.detail_id = d.detail_id ";
                        $sql  .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id ";
                        $sql  .= " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                        $sql  .= " INNER JOIN  ( SELECT *  FROM tbl_order WHERE  student_id = $student_id   )  AS o  ON  d.order_id = o.order_id ";
                        $sql  .= " ORDER BY a.arrange_id DESC";
                        $query = $conn->query($sql);
                        $i=0;
                        while($result = $query->fetch_assoc())
                        {
                        $i++;
                        ?>

                        <tr class="odd gradeX"> 
                          <td align="center"><?=$i;?></td>

                          <td>  
                          <h5><span class='badge bg-success'><?php echo nameType_work::get_type_work_name($result['detail_type_work_id']);?> </span></h5>
                          <?php echo $result['detail_id'];?>
                          </td>

                          <td>  
                            <h5><span class='badge bg-info'><?php echo nameType_work::get_type_work_name($result['type_work_id']);?></span></h5>
                            <?php echo $result['plan_name'];?>  

                                    <?php if (!empty($result['detail_surface'])) { ?>
                                      <br>  Surface : <?php echo $result['detail_surface']; ?>
                                    <?php }?>

                                    <?php if (!empty($result['detail_root'])) { ?>
                                      <br> Root : <?php echo $result['detail_root']; ?>
                                    <?php }?>

                                    <?php if (!empty($result['class_id'])) { ?>
                                      <br> Class : <?php  echo nameClass::get_class_name($result['class_id']);?> 
                                    <?php }?>

                                    <?php if (!empty($result['detail_tooth'])) {  ?>
                                      
                                        <?php
                                        $array_detail_tooth = (array)json_decode($result['detail_tooth']);
                                        $toothh ="";
                                          foreach ($array_detail_tooth as $id => $value) {
                                          $toothh .= $value.", ";
                                          } 
                                        ?>
                                    <br> Tooth :   <?php echo substr($toothh, 0 ,-2);?>
                                    <br>
                                    <?php
                                    }
                                    ?>
                          </td>


                          <td>
                                 <?php
                                    $arrange_type = $result['arrange_type'];
                                    switch ($arrange_type) { // Harder page
                                        case 0:
                                            echo  "<h5><span class='badge bg-info'>Clinic</span></h5>";
                                            break;
                                        case 1:
                                            echo  "<h5><span class='badge bg-danger'>LAB</span></h5>";
                                            break;
                                        default:
                                            echo  "<i class='fas fa-history'></i> -";
                                            break;
                                    }
                                  ?>
                          </td>



                          <td><?php echo set_format_date($result['arrange_date']);?> </td>
                          <td><?php echo set_format_date($result['arrange_record_date']);?> <?php echo $result['arrange_time'];?> </td>
                          <td>
                        
                          <?php
                                    $arrange_check_eval = $result['arrange_check_eval'];
                                    switch ($arrange_check_eval) { // Harder page
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
                          <td> 
                            <?php // echo $result['teacher_id']; ?><?php  echo nameTeacher::get_teacher_name($result['teacher_id']);?>
                          </td>

                          <td><?php echo $result['arrange_detail'];?></td>

                          <td>
                            <?php if($result['arrange_check_eval']==0){?>
                            <a href="?del=<?php echo $result['arrange_id'];?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการยกเลิกอีกครั้ง !!!')"> ยกเลิกการส่งงาน </a>  
                            <?php }?>
                          </td>   
                        
                        
                      </tr>

                        
                      <?php }?>
                        
                      </tbody>
                    </table>
            
              </div>
              <!-- /.card-body -->
        </div>



       
      </div><!-- /.container-fluid -->




    </section>
    <!-- /.content -->
 
  <!-- /.content-wrapper -->














  <?php include 'footer.php';?>


<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<!-- page script -->
<script>
  $(function () {
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
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()



    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
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
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
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

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })

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