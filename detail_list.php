<?php include "header.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!empty($_GET['order_id'])) {
  $order_id = $_GET['order_id'];
} else {
  $order_id = "";
}


if (isset($_GET['del'])) {
  include "config.inc.php";
  $sql_del = "DELETE FROM tbl_detail WHERE tbl_detail.detail_id = $_GET[del]";
  $conn->query($sql_del);

  echo "<script type='text/javascript'>";
  //echo  "alert('[บันทึกข้อมูสำเร็จ]');";
  echo "window.location='detail_list.php';";
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


<!-- Content Wrapper. Contains page content -->

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> ส่งงานประเมินในคลินิก </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
            <li class="breadcrumb-item active">รายการ งานทั้งหมด </li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->

        <form name="myForm" id="myForm" action="" method="get">
          <div class="col-md-6">
            <div class="form-group">
              <label> เลือกผู้ป่วยที่ต้องการแสดงข้อมูล </label>
              <select name="order_id" id="order_id" class="form-control select2" required onchange="this.form.submit();">
                <option value=""> เลือกผู้ป่วยที่ต้องการแสดงข้อมูล </option>


                <?php
                $student_id = $_SESSION['loginname'];
                include "config.inc.php";
                $sql_order = " SELECT *  FROM tbl_order WHERE  student_id = $student_id  and ";
                $sql_order .= "  causes_of_pay_id = '0' ";
                $query_order = $conn->query($sql_order);
                while ($result_order = $query_order->fetch_assoc()) {
                ?>
                  <option value="<?php echo $result_order['order_id']; ?>" <?php if (!(strcmp($result_order['order_id'], $order_id))) {
                                                                            echo "selected=\"selected\"";
                                                                          } ?>>
                    HN : <?php echo $result_order['HN']; ?> <?php echo $result_order['fname']; ?>
                    <?php echo $result_order['lname']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>

        <?php if (!empty($_GET['order_id'])) { ?>

          <div class="card card-primary color-palette-box">


            <div class="card-header">
              <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูลงานให้ผู้ป่วย Detail </h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>
                      <div align="center">ลำดับที่</div>
                    </th>
                    <th>รหัสงาน</th>
                    <th>HN</th>
                    <th>ฟอร์มสาขา</th>
                    <th>ลงปฏิบัติงาน</th>
                    <th>plan</th>
                    <th>รายละเอีดงาน</th>
                    <th>วันที่ เพิ่มข้อมูลงาน</th>
                    <th>complete</th>
                    <th>ส่งงาน</th>
                  </tr>
                </thead>

                <tbody>

                  <?PHP

                  include "config.inc.php";
                  $sql   = " SELECT d.*, p.* FROM  ";
                  if (!empty($_GET['order_id'])) {
                    $sql  .= " ( SELECT * FROM tbl_detail where order_id = $order_id ) as d ";
                  } else {
                    $sql  .= " ( SELECT * FROM tbl_detail ) as d ";
                  }
                  $sql  .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id ";
                 


                  //  $sql  .=  " INNER  JOIN  tbl_form_main   AS f  ON  f.form_main_id = p.form_main_id ";
                  $sql  .=  " ORDER BY d.detail_id DESC ";
                  $query = $conn->query($sql);
                  $i = 0;
                  while ($result = $query->fetch_assoc()) {
                    $i++;


                    if($result['detail_date_complete']=="0000-00-00"){
                       
                      $tablebg ="";
                  
                     }else{

                
                     $tablebg ="table-success";

                     }

                  ?>

                  <tr class="<?php echo $tablebg;?>">
                      <td align="center"><?php echo $i; ?> </td>
                      <td><?php echo $result['detail_id']; ?></td>
                      <td><?php echo $result['HN']; ?></td>
                      
                      <td><?php echo nameType_work::get_type_work_name($result['type_work_id']);?>  </td>
                      <td><h5><span class='badge bg-success'><?php  echo nameType_work::get_type_work_name($result['detail_type_work_id']);?></span></h5></td>
                      <td><?php echo namePlan::get_plan_name($result['plan_id']);?></td>

                      <td>  
                                <?php if (!empty($result['detail_surface'])) { ?>
                                   Surface : <?php echo $result['detail_surface']; ?><br> 
                                <?php }?>

                                <?php if (!empty($result['detail_root'])) { ?>
                                   Root : <?php echo $result['detail_root']; ?> <br> 
                                <?php }?>

                                <?php if (!empty($result['class_id'])) { ?>
                                   Class : <?php  echo nameClass::get_class_name($result['class_id']);?> <br> 
                                <?php }?>

                              
                                <?php if (!empty($result['detail_tooth'])) {  ?>
                                  
                                    <?php
                                    $array_detail_tooth = (array)json_decode($result['detail_tooth']);
                                    $toothh ="";
                                      foreach ($array_detail_tooth as $id => $value) {
                                      $toothh .= $value.", ";
                                      } 
                                    ?>
                                Tooth :   <?php echo substr($toothh, 0 ,-2);?>

                       


                                <br>
                                <?php
                                }
                                ?>
                      
                      </td>


                      <td><?php echo set_format_date($result['detail_date_work']);?></td>
                      <td><?php echo set_format_date($result['detail_date_complete']);?> 
                      <?php if($result['detail_date_complete'] != "0000-00-00"){ ?>

                         <i class='fas fa-check-circle' style='font-size:24px;color:green'></i><br>
                         <?php  echo nameCauses_of_pay::get_causes_of_pay_name($result['causes_of_pay_id']);?>
                      
                      <?php }
                      ?>
                     </td>
                   
                      <td>
                      <?PHP

                        if($result['detail_date_complete'] == "0000-00-00"){
                        $arrange_date = date('Y-m-d');
                        $detail_id = $result['detail_id'];

                        include "config.inc.php";
                        $sql_arrange_ckAM   =  " SELECT * FROM tbl_arrange where arrange_date = '$arrange_date' and arrange_time_type = 'AM' and detail_id = $detail_id and arrange_check_eval = 0 ";
                        $query_arrange_ckAM = $conn->query($sql_arrange_ckAM);

                        
                        $sql_arrange_ckPM   =  " SELECT * FROM tbl_arrange where arrange_date = '$arrange_date' and arrange_time_type = 'PM' and detail_id = $detail_id and arrange_check_eval = 0 ";
                        $query_arrange_ckPM = $conn->query($sql_arrange_ckPM);

                       
                        $sql_arrange_ckPMs  =  " SELECT * FROM tbl_arrange where arrange_date = '$arrange_date' and arrange_time_type = 'AM' and arrange_check_eval = 0 and detail_id = $detail_id ";
                        $query_arrange_ckPMs = $conn->query($sql_arrange_ckPMs);

                        ?>

                        
                       


                        
                            <div class="input-group-prepend">
                              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Action </button>
                              
                              <div class="dropdown-menu">

                              <?php  if($result_arrange_ckAM = $query_arrange_ckAM->fetch_assoc()){  }else{ ?>
                               <a href="" class="dropdown-item" data-toggle="modal" data-target="#modal-default_1_<?php echo $result['detail_id']; ?>"><i class="fas fa-edit"></i> ส่งงานประเมิน (เช้า) </a>
                              <?php }?>
                              

                        
                              <div class="dropdown-divider"></div>

                              <?php  if($result_arrange_ckPMs = $query_arrange_ckPMs->fetch_assoc()){  ?>


                          


                              <?php }else{?>



                                <?php  if($result_arrange_ckPM = $query_arrange_ckPM->fetch_assoc()){ 

                                 }else{ ?>
                                  <a href="" class="dropdown-item" data-toggle="modal" data-target="#modal-default_2_<?php echo $result['detail_id']; ?>"><i class="fas fa-edit"></i> ส่งงานประเมิน (บ่าย) </a>
                                <?php }?>


                              <?php }?>

                              <div class="dropdown-divider"></div>

                              <a href="" class="dropdown-item" data-toggle="modal" data-target="#modal-default_lab_<?php echo $result['detail_id']; ?>"><i class="fas fa-edit"></i> ส่งงานประเมิน LAB </a>

                              </div>
                            </div>
                        <?php }?>

                     
                      </td>
                    </tr>




<?php
for ($x = 1; $x <= 2; $x++) {
  $plan_id = $result['plan_id'];
  $detail_id = $result['detail_id'];
  $order_id = $result['order_id'];
  $detail_surface = $result['detail_surface'];
  $detail_root = $result['detail_root'];
  $class_id  = $result['class_id'];
  $detail_tooth = $result['detail_tooth'];
  $detail_date_complete = $result['detail_date_complete'];
  $causes_of_pay_id  = $result['causes_of_pay_id'];
  $detail_type_work_id  = $result['detail_type_work_id'];

  if($x == 1){ $arrange_time_type = "AM";}  
  else if($x == 2){ $arrange_time_type = "PM";} 
  else {  $arrange_time_type = ""; }
?>


                    <div class="modal fade" id="modal-default_<?php echo $x;?>_<?php echo $result['detail_id']; ?>">
                      <div class="modal-dialog modal-xl">

                        <form name="form<?php echo $result['detail_id']; ?>" method="post" action="arrange_add_q.php" enctype="multipart/form-data">

                          <input name="detail_id" type="hidden" value="<?php echo $result['detail_id']; ?>" />
                          <input name="arrange_time_type" type="hidden" value="<?php echo $arrange_time_type;?>" />
                          <input name="arrange_type" type="hidden" value="0" />
                          

                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"> <?php echo nameType_work::get_type_work_name($result['type_work_id']);?> :
                                <?php echo $result['plan_name']; ?>
                                (<?php echo $result['detail_id']; ?>) </h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                            


                              <h3><span class='badge bg-success'><?php echo $arrange_time_type;?><br></span></h3>



                              HN : <?php echo $result['HN']; ?> <br>

                              <?php if (!empty($detail_surface)) { ?>
                              surface : <?php echo $result['detail_surface']; ?><br>
                              <?php }?>

                              <?php if (!empty($detail_root)) { ?>
                              root : <?php echo $result['detail_root']; ?><br>
                              <?php }?>

                              <?php if (!empty($class_id)) { ?>
                              class : <?php  echo nameClass::get_class_name($result['class_id']);?><br>
                              <?php }?>

                              tooth : <br>
                              <?php
                              $toothh ="";
                              foreach ($array_detail_tooth as $id => $value) {
                               $toothh .= $value.", ";
                              }
                              ?>
                             <?php //echo $toothh;?>
                              <?php include "tooth.php";?>
                              <br>
                            <?php if($result['type_work_id']==1){  //แสดงเฉพาะสาขา X-ray เท่านั้น ?>
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <input type="number" name="arrange_detail" class="form-control" placeholder="ระบุจำนวน" value="1">
                                  </div>
                                </div>
                              </div>
                            <?php }?>


                              
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <input type="date" name="arrange_date" class="form-control" placeholder="วันที่" value="<?php echo date('Y-m-d');?>">
                                  </div>
                                </div>
                              </div>

                            

                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <select name="teacher_id" class="form-control select2" style="width: 100%;" required>
                                      <option value="" selected="selected">
                                        เลือกอาจารย์ผู้ประเมิน</option>

                                      <?PHP
                                     /* include "config.inc.php";
                                      $sql_t =  "SELECT * FROM tbl_teacher where type_work_id = $detail_type_work_id";
                                      //$sql_t =  "SELECT * FROM tbl_teacher where type_work_id_array like '%$detail_type_work_id'";
                                      $query_t = $conn->query($sql_t);
                                      while ($result_t = $query_t->fetch_assoc()) {
                                        
                                      ?>

                                        <option value="<?php echo $result_t['teacher_id']; ?>">
                                          <?php echo $result_t['teacher_name']; ?>
                                          <?php echo $result_t['teacher_surname']; ?>
                                        </option>

                                      <?php  // } */?>


                                      <?PHP
                                      $type_work_idss = sprintf("%02d", $detail_type_work_id);
                                      include "config.inc.php";
                                      $sql_tt =  "SELECT * FROM tbl_teacher where  teacher_status = 1 and type_work_id_array like '%$type_work_idss%'";
                                      $query_tt = $conn->query($sql_tt);
                                      while ($result_tt = $query_tt->fetch_assoc()) {
                                      ?>
                                        <option value="<?php echo $result_tt['teacher_id']; ?>">
                                        <?php echo $result_tt['teacher_name']; ?>
                                          <?php echo $result_tt['teacher_surname']; ?>
                                        </option>
                                      <?php   } ?>

                                    </select>
                                  </div>
                                </div>
                              </div>


                              
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <select name="arrange_type" class="form-control" style="width: 100%;"   readonly>
                                      <option value="0" selected="selected"> ประเมินคะแนนในคลินิก </option>
                                    </select>
                                  </div>
                                </div>
                              </div>


                            </div>

                     

                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <input type="submit" name="submit" class="btn btn-primary" id="button" value="ส่งรายงาน ประเมินคะแนน">
                            </div>


                          </div>
                          <!-- /.modal-content -->

                        </form>

                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->




<?php }?>





<div class="modal fade" id="modal-default_lab_<?php echo $result['detail_id']; ?>">
                      <div class="modal-dialog modal-xl">

                        <form name="form<?php echo $result['detail_id']; ?>" method="post" action="arrange_add_q.php" enctype="multipart/form-data">

                          <input name="detail_id" type="hidden" value="<?php echo $result['detail_id']; ?>" />
                          <input name="arrange_time_type" type="hidden" value="<?php echo $arrange_time_type;?>" />
                          <?php echo $arrange_time_type;?>
                          
                          

                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"> <?php echo nameType_work::get_type_work_name($result['type_work_id']);?> :
                                <?php echo $result['plan_name']; ?>
                                (<?php echo $result['detail_id']; ?>) </h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <h3><span class='badge bg-success'>LAB<br></span></h3>
                             
                              HN : <?php echo $result['HN']; ?> <br>

                              <?php if (!empty($detail_surface)) { ?>
                              surface : <?php echo $result['detail_surface']; ?><br>
                              <?php }?>

                              <?php if (!empty($detail_root)) { ?>
                              root : <?php echo $result['detail_root']; ?><br>
                              <?php }?>

                              <?php if (!empty($class_id)) { ?>
                              class : <?php  echo nameClass::get_class_name($result['class_id']);?><br>
                              <?php }?>

                              tooth : <br>
                              <?php
                              $toothh ="";
                              foreach ($array_detail_tooth as $id => $value) {
                               $toothh .= $value.", ";
                              }
                              
                              ?>
                              <?php include "tooth.php";?>
                              <br>
                              <br>
                      
                             


                              <input name="arrange_date" type="hidden" value="<?php echo date('Y-m-d');?>" />



                              
                            <?php if($result['type_work_id']==1){  //แสดงเฉพาะสาขา X-ray เท่านั้น ?>
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <input type="number" name="arrange_detail" class="form-control" placeholder="ระบุจำนวน" value="1" >
                                  </div>
                                </div>
                              </div>
                            <?php }?>




                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <select name="teacher_id" class="form-control select2" style="width: 100%;" required>
                                      <option value="" selected="selected">
                                        เลือกอาจารย์ผู้ประเมิน</option>

                                      <?PHP
                                     // include "config.inc.php";
                                     // $sql_t =  "SELECT * FROM tbl_teacher where type_work_id = $detail_type_work_id";
                                     // $query_t = $conn->query($sql_t);
                                     // while ($result_t = $query_t->fetch_assoc()) {

                                      ?>

                                      <?PHP
                                      $type_work_idss = sprintf("%02d", $detail_type_work_id);
                                      include "config.inc.php";
                                      $sql_tt =  "SELECT * FROM tbl_teacher where  teacher_status = 1 and type_work_id_array like '%$type_work_idss%'";
                                      $query_tt = $conn->query($sql_tt);
                                      while ($result_tt = $query_tt->fetch_assoc()) {
                                      ?>

                                        <option value="<?php echo $result_tt['teacher_id']; ?>">
                                          <?php echo $result_tt['teacher_name']; ?>
                                          <?php echo $result_tt['teacher_surname']; ?>
                                        </option>

                                      <?php   } ?>

                                    </select>
                                  </div>
                                </div>
                              </div>



                              
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <select name="arrange_type" class="form-control" style="width: 100%;" readonly>
                                      <option value="1"> ประเมินคะแนน LAB </option>
                                    </select>
                                  </div>
                                </div>
                              </div>


                            </div>

                     

                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <input type="submit" name="submit" class="btn btn-primary" id="button" value="ส่งรายงาน ประเมินคะแนน">
                            </div>


                          </div>
                          <!-- /.modal-content -->

                        </form>

                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->












                  <?php } ?>

                </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
      </div>
    <?php } ?>




</div><!-- /.container-fluid -->




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