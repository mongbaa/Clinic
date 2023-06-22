<?php include"header.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);





  
							
    if(isset($_GET['edit']))
                    {
                        include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                        $detail_id=$_GET['edit'];
                        $sql_edit="SELECT * FROM tbl_detail where detail_id=$detail_id ";
                        $query_edit = $conn->query($sql_edit);
                        $result_edit = $query_edit->fetch_assoc();
         

                        $detail_id=$result_edit['detail_id'];
                        $order_id=$result_edit['order_id'];
                        $plan_id=$result_edit['plan_id'];
                        $detail_tooth=$result_edit['detail_tooth'];
                        $detail_surface=$result_edit['detail_surface'];
                        $detail_root=$result_edit['detail_root'];
                        $class_id=$result_edit['class_id'];
                        $detail_date_work=$result_edit['detail_date_work'];
                        $detail_date_complete=$result_edit['detail_date_complete'];
                        $causes_of_pay_id=$result_edit['causes_of_pay_id'];
                        $detail_difficult=$result_edit['detail_difficult'];
         
        }else{



         
                        $detail_id="";
                        $order_id="";
                        $detail_tooth="";
                        $detail_surface="";
                        $detail_root="";
                        $detail_class="";
                        $detail_step="";
                        $detail_date_work="";
                        $detail_date_complete="";
                        $causes_of_pay_id="";
                        $detail_difficult="";
         
         }
          
     
        
  ?>		

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
               
  
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1> แก้ไขข้อมูลงานให้ผู้ป่วย Detail </h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                      <li class="breadcrumb-item active">แก้ไขข้อมูลงาน</li>
                      </ol>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->






    <!-- Main content -->
    <section class="content">
         <div class="container-fluid">
          
          
            <div class="row">
             <!-- left column -->
            <div class="col-md-12">

      

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title"> เลือก รายละเอียดงาน </h3>
                    </div>

                    <div class="card-body">

     
                        <form name="multilistbox" method="POST" action = "detail_q.php">
                        <input name="plan_id" type="hidden" value="<?php echo $plan_id;?>" />
                        <input name="detail_id" type="hidden" value="<?php echo $detail_id;?>" />



                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </label>
                                        <select name="order_id"  id="order_id" class="form-control select2"  required>		
                                        <option value="">  เลือกผู้ป่วยที่ต้องการเพิ่มงาน </option>  
                                        <?php 
                                        include"config.inc.php";
                                        $sql_order="SELECT * FROM tbl_order as p  ";
                                        $sql_order.=" where p.cause_pay_id = 0 ";
                                        $query_order=$conn->query($sql_order);
                                        while($result_order=$query_order->fetch_assoc()){
                                        ?>
                                         <option value="<?php echo $result_order['order_id'];?>,<?php echo $result_order['HN'];?>" <?php if (!(strcmp($result_order['order_id'], $order_id))) {echo "selected=\"selected\"";} ?>> HN : <?php echo $result_order['HN'];?></option>     
                                        <?php } ?>
                                        </select>
                                      </div>
                                    </div>





                                    <?php if(!empty($detail_surface)){?>
                                    <?php //echo $detail_surface;
                                    $step_surface1 = explode(", ", $detail_surface); // แยก
                                    $step_surface2 = count($step_surface1); // นับมีกี่ตัว
                                    //for( $ct= 0 ; $ct <= $step_surface2 ; $ct++ ){ $step = @$step1[$ct]; }
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                     <label> Surface </label>
                                                        <div class="row">
                                                        <?php  for($r=1;$r<=5;$r++){  $rr = $r-1; ?> 
                                                            <?php if(isset($step_surface1["$rr"])){ $surface = $step_surface1["$rr"];  }else{ $surface = "";    }?>

                                                            <div class="col-md-2">
                                                                <select name="surface_id<?php echo $r;?>" class="form-control">
                                                                <option value = "">---</option>
                                                                        <?php 
                                                                        $sql_surf="SELECT * FROM tbl_surface"; 
                                                                        $query_surf = $conn->query($sql_surf); 
                                                                        while($row_surf = $query_surf->fetch_assoc()) 
                                                                        { 
                                                                        ?>
                                                                        <option value="<?php echo $row_surf['surface_shortname'];?>" <?php if (!(strcmp($row_surf['surface_shortname'], $surface))) {echo "selected=\"selected\"";} ?>><?php echo $row_surf['surface_shortname'];?></option>
                                                                        <?php }?> 
                                                                <option value="(other)">other</option>
                                                                </select>
                                                            </div>
                                                            <?php }?>
                                                        </div>
                                        </div>
                                    </div>
                                    <?php  }else{ ?>
                                        <input name="surface_id" type="hidden" value="" />
                                    <?php  } ?>





                                    <?php if(!empty($detail_root)){?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                     <label> Root </label>
                                                     <select name="detail_root" class="form-control">
                                                        <option value="">--เลือก--</option>
                                                        <option value="1" <?php if (!(strcmp(1, $detail_root))) {echo "selected=\"selected\"";} ?>> 1</option>
                                                        <option value="2" <?php if (!(strcmp(2, $detail_root))) {echo "selected=\"selected\"";} ?>> 2</option>
                                                        <option value="3" <?php if (!(strcmp(3, $detail_root))) {echo "selected=\"selected\"";} ?>> 3</option>
                                                        <option value="4" <?php if (!(strcmp(4, $detail_root))) {echo "selected=\"selected\"";} ?>> 4</option>
                                                    </select>
                                        </div>
                                    </div>
                                    <?php  }else{ ?>
                                        <input name="surface_id" type="hidden" value="" />
                                    <?php  } ?>









                                    <?php if(!empty($class_id)){?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                    <label> Class </label>
                                                    <select name="class_id" class="form-control">
                                                        <option value="">--เลือก--</option>		  
                                                        <?php 
                                                        $sql_class="SELECT * FROM tbl_class order by class_id asc  "; 
                                                        $query_class = $conn->query($sql_class); 
                                                        while($row_class = $query_class->fetch_assoc()) 
                                                        { 
                                                        ?>
                                                         <option value="<?php echo $row_class['class_id'];?>" <?php if (!(strcmp($row_class['class_id'], $class_id))) {echo "selected=\"selected\"";} ?>><?php echo $row_class['class_name'];?></option>
                                                        <?php }?> 
                                                        <option value="(other)">other</option>
                                                    </select>
                                        </div>
                                    </div>
                                    <?php  }else{ ?>
                                        <input name="surface_id" type="hidden" value="" />
                                    <?php  } ?>






                                    <?php if(!empty($detail_tooth)){
                                    $array_detail_tooth = json_decode($detail_tooth);
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                    <label> Tooth </label>
                                                    <select name="detail_tooth[]" size="10" multiple="multiple" class="duallistbox">

                                                    <?php  //ซี่ที่ 11 - 18
                                                    for($a=18 , $b=1; $a>=11 , $b<=8 ;$a-- , $b++){  
                                                    ?>
                                                    <option <?php if (in_array($a, $array_detail_tooth)) {  echo "selected=\"selected\""; }?>> <?php echo $a;?> </option>

                                                    <?php }?>


                                                    <?php  //ซี่ที่ 21 - 28
                                                    for($aa=21, $b=9;  $aa<=28 , $b<=16 ;$aa++ , $b++){  
                                                    ?>
                                                    <option <?php if (in_array($aa, $array_detail_tooth)) {  echo "selected=\"selected\""; }?>><?php echo $aa;?></option>
                                                    <?php }?>



                                                    <?php  //ซี่ที่ 41 - 48
                                                    for($aaa=48 , $b=17;  $aaa>=41 , $b<=24; $aaa-- , $b++){     
                                                    ?>
                                                    <option <?php if (in_array($aaa, $array_detail_tooth)) {  echo "selected=\"selected\""; }?>><?php echo $aaa;?></option>
                                                    <?php }?>



                                                    <?php //ซี่ที่ 31 - 38
                                                    for($aaaa=31 , $b=25; $aaaa<=38 , $b<=32;  $aaaa++ , $b++){	 
                                                    ?>
                                                    <option <?php if (in_array($aaaa, $array_detail_tooth)) {  echo "selected=\"selected\""; }?>><?php echo $aaaa;?></option>
                                                    <?php }?>


                                                    </select>
                                        </div>
                                    </div>
                                    <?php  }else{ ?>
                                        <input name="detail_tooth" type="hidden" value="" />
                                    <?php  } ?>



                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                    <label> Date </label>
                                                    <input type="date" name="detail_date_complete" id="detail_date_complete" value="<?php echo $detail_date_complete;?>" class="form-control">
                                        </div>
                                    </div>






                                    <div class="col-md-6">
                                        <div class="form-group">
                                                    <label> causes of pay </label>
                                                    <select name="causes_of_pay_id" class="form-control select2">
                                                        <option value="">--เลือก causes_pay  --</option>		  
                                                        <?php 
                                                        $sql_causes="SELECT * FROM tbl_causes_of_pay order by causes_of_pay_id asc  "; 
                                                        $query_causes = $conn->query($sql_causes); 
                                                        while($row_causes = $query_causes->fetch_assoc()) 
                                                        { 
                                                        ?>
                                                        <option value="<?php echo $row_causes['causes_of_pay_id'];?>" <?php if (!(strcmp($row_causes['causes_of_pay_id'], $causes_of_pay_id))) {echo "selected=\"selected\"";} ?>><?php echo $row_causes['causes_of_pay_detail'];?></option>
                                                        <?php }?> 
                                                        <option value="(other)">other</option>
                                                    </select>
                                        </div>
                                    </div>
                                  




                                    <div class="col-12">
                                    <input type="submit" name="Submit"  class="btn btn-info" value="Edit Work" />
                                    </div>



















                        </form>



                










                    </div>
                </div>







             </div>
            </div>




                    
         




  
   







         </div>
    </section>




    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->













<?php  include'footer.php';?>


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