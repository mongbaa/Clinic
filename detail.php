<?php include "header.php";

if (!empty($_GET['order_id'])) {
  $order_id = $_GET['order_id'];
} else {
  $order_id = "";
}
 


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
  $detail_id = $_GET['del'];
  $sql_del = "DELETE FROM tbl_detail WHERE tbl_detail.detail_id = $detail_id";
  $conn->query($sql_del);
  echo "<script type='text/javascript'>";
  //echo  "alert('บันทึกสำเร็จ');";
  echo "window.history.back(1)";
  echo "</script>";
}


//ยกเลิก Complete
if (!empty($_GET['complete'])) {
  include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
  $detail_id = $_GET['complete'];
  $sql_complete = "UPDATE tbl_detail SET detail_date_complete = '0000-00-00' WHERE tbl_detail.detail_id =$detail_id  ";
  $conn->query($sql_complete);
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
  echo  "alert('เข้าสู่ระบบก่อนใช้งาน....!');";
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


<?php  include "sweetalert.php"; //  ?>

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



  <!-- Content Header (Page header) -->
  <section class="content-header">


    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> เพิ่มข้อมูลงานให้ผู้ป่วย Detail </h1>
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
               <form name="myForm" id="myForm" action="" method="get">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </label>
                      <select name="order_id" id="order_id" class="form-control select2" required onchange="this.form.submit();">
                        <option value=""> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </option>
                        <?php
                        include "config.inc.php";
                        $sql_order = " SELECT *  FROM tbl_order WHERE  student_id = $student_id and ";
                        $sql_order .= "  causes_of_pay_id = '0' ";
                        $query_order = $conn->query($sql_order);
                        while ($result_order = $query_order->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $result_order['order_id']; ?>" <?php if (!(strcmp($result_order['order_id'], $order_id))) {
                                                                                      echo "selected=\"selected\"";
                                                                                    } ?>>
                            HN : <?php echo $result_order['HN']; ?> <?php echo $result_order['fname']; ?> <?php echo $result_order['lname']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </form>


                <?php if (!empty($_GET['order_id'])) { ?>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label> เลือก งานของสาขา </label>
                      <form name="myForm1" id="myForm1" action="" method="GET">
                        <input name="order_id" type="hidden" value="<?php echo $order_id; ?>" />
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
                <?php } ?>





                <?php if (isset($_GET['type_work_id'])) { ?>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label> เลือกงาน</label>
                      <!-- <span class="info-box-text">เลือกงาน ในสาขา</span>-->
                      <form name="myForm2" id="myForm2" action="" method="GET">

                        <input name="order_id" type="hidden" value="<?php echo $order_id; ?>" />
                        <input name="type_work_id" type="hidden" value="<?php echo $type_work_id; ?>" />
                        <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />

                        <select name="plan_ids" id="plan_ids" class="form-control select2" onchange="this.form.submit()" required>
                          <option value=""> เลือกงาน ในสาขา </option>
                          <?php
                          include "config.inc.php";
                          //$sql_plan = "SELECT * FROM tbl_plan as p  ";
                          //$sql_plan .= " where p.type_work_id = $type_work_id ";
                          $sql_plan = " SELECT p.* , t.* , f.*";
                          $sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p ";
                          $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                          $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_type = 1 and form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
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

                  <?php
                  $array_form_main_detail = json_decode($form_main_detail, true);
                  ?>


                  <form name="multilistbox" method="POST" action="detail_q.php">
                    <input name="plan_id" type="hidden" value="<?php echo $plan_id; ?>" />
                    <input name="order_id" type="hidden" value="<?php echo $order_id; ?>" />
                    <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />



                    <?php if (in_array("s", $array_form_main_detail)) { ?>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label> Surface </label>
                          <div class="row">
                            <?php for ($r = 1; $r <= 5; $r++) { ?>
                              <div class="col-md-2">
                                <select name="surface_id<?php echo $r; ?>" class="form-control">
                                  <option value="">---</option>
                                  <?php
                                  $sql_surf = "SELECT * FROM tbl_surface";
                                  $query_surf = $conn->query($sql_surf);
                                  while ($row_surf = $query_surf->fetch_assoc()) {
                                  ?>
                                    <option value="<?php echo $row_surf['surface_shortname']; ?>">
                                      <?php echo $row_surf['surface_shortname']; ?></option>
                                  <?php } ?>
                                 
                                   <!-- <option value="(other)">other</option> -->
                                </select>
                              </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    <?php  } else { ?>
                      <input name="surface_id" type="hidden" value="" />
                    <?php  } ?>







                    <?php if (in_array("r", $array_form_main_detail)) { ?>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label> Root </label>
                          <select name="detail_root" class="form-control" required>
                            <option value="">--เลือก--</option>
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                            <option value="4"> 4</option>
                          </select>
                        </div>
                      </div>
                    <?php  } else { ?>
                      <input name="surface_id" type="hidden" value="" />
                    <?php  } ?>









                    <?php if (in_array("c", $array_form_main_detail)) { ?>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label> Class </label>
                          <select name="class_id" class="form-control" required>
                            <option value="">--เลือก--</option>
                            <?php
                            $sql_class = "SELECT * FROM tbl_class order by class_id asc  ";
                            $query_class = $conn->query($sql_class);
                            while ($row_class = $query_class->fetch_assoc()) {
                            ?>
                              <option value="<?php echo $row_class['class_id']; ?>">
                                <?php echo $row_class['class_name']; ?></option>
                            <?php } ?>
                           
                             <!-- <option value="(other)">other</option> -->
                          </select>
                        </div>
                      </div>
                    <?php  } else { ?>
                      <input name="surface_id" type="hidden" value="" />
                    <?php  } ?>













                    <?php if (in_array("t", $array_form_main_detail)) { ?>



                      <label> <input type="checkbox" id="checkbox"> Select All Tooth </label>


                      <script src="plugins/jquery/jquery.min.js"></script>
                      <script>
                        $(document).ready(function() {
                          $("#checkbox").click(function() {
                            if ($("#checkbox").is(':checked')) { //select all
                              $("#e1").find('option').prop("selected", true);
                              $("#e1").trigger('change');
                            } else { //deselect all
                              $("#e1").find('option').prop("selected", false);
                              $("#e1").trigger('change');
                            }
                          });
                        });
                      </script>






                         


                      <div class="col-md-12">
                        <div class="form-group">
                          <label> Tooth </label>
                          <select name="detail_tooth[]" id="e1" class="select2" multiple="multiple" data-placeholder=" Tooth" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                            <!-- <select name="detail_tooth[]" size="10" multiple="multiple" class="duallistbox">-->
                           
                           
                            <?php $Tooth = array("All / Full mouth", "PQ1", "PQ2", "PQ3", "PQ4", "UA", "LA"); 
                            foreach ( $Tooth as $key => $value )
                              {
                                echo  "<option>$value</option>";
                              }
                            ?>

                            
                           
                           
                           <?php  //ซี่ที่ 11 - 18
                            for ($a = 18, $b = 1; $a >= 11, $b <= 8; $a--, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>

                            <?php } ?>


                            <?php  //ซี่ที่ 21 - 28
                            for ($a = 21, $b = 9; $a <= 28, $b <= 16; $a++, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>
                            <?php } ?>



                            <?php  //ซี่ที่ 41 - 48
                            for ($a = 48, $b = 17; $a >= 41, $b <= 24; $a--, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>
                            <?php } ?>



                            <?php //ซี่ที่ 31 - 38
                            for ($a = 31, $b = 25; $a <= 38, $b <= 32; $a++, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>
                            <?php } ?>





                             
                            <?php  //ซี่ที่ 51 - 55
                            for ($a = 55, $b = 1; $a >= 51, $b <= 5; $a--, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>

                            <?php } ?>


                            <?php  //ซี่ที่ 61 - 65
                            for ($a = 61, $b = 6; $a <= 65, $b <= 10; $a++, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>
                            <?php } ?>


                            <?php  //ซี่ที่ 85 - 81
                            for ($a = 85, $b = 11; $a >= 81, $b <= 15; $a--, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>
                            <?php } ?>



                            <?php  //ซี่ที่ 71 - 75
                            for ($a = 71, $b = 16; $a <= 75, $b <= 20; $a++, $b++) {
                            ?>
                              <option><?php echo $a; ?></option>
                            <?php } ?>





                          </select>
                        </div>
                      </div>
                    <?php  } else { ?>
                  
                      <input name="detail_tooth[]" type="hidden" value="" />
                    <?php  } ?>






                    <div class="col-md-12">
                      <div class="form-group">
                        <label>ลงปฏิบัติงานของสาขา </label>
                        <select name="detail_type_work_id" id="detail_type_work_id" class="form-control select2" required>
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
                      </div>
                    </div>




                    <div class="col-12">
                      <input type="submit" name="Submit" class="btn btn-info" value="Add Work" />
                    </div>

                  </form>


                <?php } ?>


              </div>
            </div>


          </div>












          <?php if (!empty($_GET['order_id'])) { ?>
            <div class="col-12 col-md-8">
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

                        <th>HN</th>
                        <th>ฟอร์มสาขา</th>
                        <th>ลงปฏิบัติงาน</th>
                        <th>งาน</th>
                        <th>Tooth</th>
                        <th>Complete</th>
                        <th>แก้ไข</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?PHP
                      include "config.inc.php";
                      $sql   = " SELECT d.*, p.*, cp.*  FROM  ";
                      if (!empty($_GET['order_id'])) {
                        $sql  .= " ( SELECT * FROM tbl_detail where order_id = $order_id ) as d ";
                      } else {
                        $sql  .= " ( SELECT * FROM tbl_detail ) as d ";
                      }
                      $sql  .= " INNER JOIN tbl_plan   AS p  ON  p.plan_id = d.plan_id ";
                      $sql  .= " LEFT JOIN  tbl_causes_of_pay   AS cp  ON  cp.causes_of_pay_id = d.causes_of_pay_id ";
                      //  $sql  .=  " INNER  JOIN  tbl_form_main   AS f  ON  f.form_main_id = p.form_main_id ";
                      $sql  .=  " ORDER BY d.detail_id DESC  ";
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
                          <td align="center"><?= $i; ?>  </td>

                          <td><?php echo $result['HN']; ?></td>
                          <td><?php echo nameType_work::get_type_work_name($result['type_work_id']); ?> </td>
                          <td><?php echo nameType_work::get_type_work_name($result['detail_type_work_id']); ?> </td>
                          <td><?php echo namePlan::get_plan_name($result['plan_id']); ?> </td>
                          <td>
                            <?php
                            $array_detail_tooth = (array)json_decode($result['detail_tooth']);
                            //$step_tooth = count($array_detail_tooth); // นับมีกี่ตัว
                            //for( $ct= 0 ; $ct <= $step_tooth ; $ct++ ){ echo @$array_detail_tooth[$ct]; }
                            ?>

                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal<?php echo $result['detail_id']; ?>">
                              (<?php echo $array_detail_tooth[0]; ?>)
                            </button>

                          </td>

                          <!-- The Modal -->
                          <div class="modal" id="myModal<?php echo $result['detail_id']; ?>">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title">ซี่ฟัน </h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                  <?php include "tooth.php";?>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                              </div>
                            </div>
                          </div>


                              <td>
                                <?php echo set_format_date($result['detail_date_complete']);?>
                                <?php echo $result['causes_of_pay_detail'];?>
                              </td>

                          <td>

                            <?PHP
                            $detail_id = $result['detail_id'];
                            include "config.inc.php";
                            $sql_detail_ck   =  " SELECT * FROM tbl_arrange where  detail_id = $detail_id ";
                            $query_detail_ck = $conn->query($sql_detail_ck);
                            if ($result_detail_ck = $query_detail_ck->fetch_assoc()) {
                             // echo "-";
                            } else {
                            ?>



                              <?php  // เป็น Teacher   Staff  
                                    if (($_SESSION['level_user'] == "Student")) {
                              ?>
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Action </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="?del=<?php echo $result['detail_id']; ?>&student_id=<?php echo $student_id; ?>" class="btn btn-danger" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> ลบ </a>
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item" href="?edit=<?php echo $result['detail_id']; ?>&order_id=<?php echo $order_id; ?>&student_id=<?php echo $student_id; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> แก้ไขงาน </a>
                                </div>
                              </div>
                              <?php } ?>

                            <?php } ?>








                     
                            <?php  // เป็น Teacher   Staff  
                                  if (($_SESSION['level_user'] == "Teacher") || ($_SESSION['level_user'] == "Staff")) {
                            ?>

                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"> Action </button>
                                <div class="dropdown-menu">


                                <?php if($result['detail_date_complete']=="0000-00-00"){?>
                                  <a class="dropdown-item" href="?edit=<?php echo $result['detail_id']; ?>&order_id=<?php echo $order_id; ?>&student_id=<?php echo $student_id; ?>" class="btn btn-info"> <i class="fas fa-edit"></i> จ่ายงานออก + แก้ไขงาน </a>
                                <?php }else{ ?>
                                  <a class="dropdown-item" href="#" class="btn btn-info"> จ่ายงานออกแล้ว </a>
                                <?php }?>
                                  
                                  
                                  <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="?complete=<?php echo $result['detail_id']; ?>&order_id=<?php echo $order_id; ?>&student_id=<?php echo $student_id; ?>" class="btn btn-info"> <i class="fas fa-trash"></i> ยกเลิก Complete</a>
                                </div>
                              </div>

                            <?php } ?>

                          </td>
                        </tr>


                      <?php } ?>

                    </tbody>
                  </table>
                  <font color="red">*** กรณีแก้ไขข้อมูล หรือ ลบ จะสามารถทำได้หาก งานยังไม่ส่งงานให้อ.ประเมินคะแนน </font>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
        </div>
      <?php } ?>






      </div>



      <?php if (isset($_GET['edit']) && !empty($_GET['edit'])) {

        $detail_id = $_GET['edit'];
        $student_id = $_GET['student_id'];



        include "config.inc.php";
        $sql   = " SELECT d.*, p.*, t.*, f.*   FROM  ";
        $sql  .= " ( SELECT * FROM tbl_detail where detail_id = $detail_id ) as d ";
        $sql  .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id ";
        $sql  .= " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
        $sql  .= " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_type = 1 and form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
        $sql  .=  " ORDER BY d.detail_id ASC ";
        $query = $conn->query($sql);
        $result = $query->fetch_assoc();

        $plan_id = $result['plan_id'];
        $detail_id = $result['detail_id'];
        $order_id = $result['order_id'];
        $detail_surface = $result['detail_surface'];
        $detail_root = $result['detail_root'];
        $class_id  = $result['class_id'];
        $detail_tooth = $result['detail_tooth'];
        $detail_date_complete = $result['detail_date_complete'];
        $causes_of_pay_id  = $result['causes_of_pay_id'];
        $detail_type_work_id = $result['detail_type_work_id'];
        $detail_competency = $result['detail_competency'];


        $form_main_detail = $result['form_main_detail']; // ค่ารายละเอียดงาน ที่ต้องเลือกเช่น ซี่ฟัน / ด้าน ราก
        $array_form_main_detail = json_decode($form_main_detail, true);
       
      ?>


        <form name="<?php echo $result['detail_id']; ?>" method="POST" action="detail_q.php">


          <input name="plan_id" type="hidden" value="<?php echo $plan_id; ?>" />
          <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />
          <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />


          <div class="modal fade" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content  ">
                <div class="modal-header bg-danger">
                  <h4 class="modal-title"> แก้ไขข้อมูลงานให้ผู้ป่วย Detail </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">


                  <h4>
                    <?php echo $result['type_work_name']; ?> :
                    <?php echo $result['plan_name']; ?>
                    (<?php echo $result['detail_id']; ?>)
                  </h4>



                  <div class="col-md-12">
                    <div class="form-group">
                      <label> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </label>
                      <select name="order_id" id="order_id" class="form-control select2" required>
                        <option value=""> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </option>
                        <?php
                        include "config.inc.php";
                        $sql_order = "SELECT * FROM tbl_order as p  ";
                        $sql_order .= " where p.causes_of_pay_id = 0 ";
                        $query_order = $conn->query($sql_order);
                        while ($result_order = $query_order->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $result_order['order_id']; ?>" <?php if (!(strcmp($result_order['order_id'], $order_id))) {
                                                                                      echo "selected=\"selected\"";
                                                                                    } ?>> HN : <?php echo $result_order['HN']; ?> <?php echo $result_order['pname']; ?> <?php echo $result_order['fname']; ?> <?php echo $result_order['lname']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>




                  <?php if (in_array("s", $array_form_main_detail)) { ?>
                
                    <?php //echo $detail_surface;
                    $step_surface1 = explode(", ", $detail_surface); // แยก
                    $step_surface2 = count($step_surface1); // นับมีกี่ตัว
                    //for( $ct= 0 ; $ct <= $step_surface2 ; $ct++ ){ $step = @$step1[$ct]; }
                    ?>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label> Surface </label>
                        <div class="row">
                          <?php for ($r = 1; $r <= 5; $r++) {
                            $rr = $r - 1; ?>
                            <?php if (isset($step_surface1["$rr"])) {
                              $surface = $step_surface1["$rr"];
                            } else {
                              $surface = "";
                            } ?>

                            <div class="col-md-2">
                              <select name="surface_id<?php echo $r; ?>" class="form-control">
                                <option value="">---</option>
                                <?php
                                $sql_surf = "SELECT * FROM tbl_surface";
                                $query_surf = $conn->query($sql_surf);
                                while ($row_surf = $query_surf->fetch_assoc()) {
                                ?>
                                  <option value="<?php echo $row_surf['surface_shortname']; ?>" <?php if (!(strcmp($row_surf['surface_shortname'], $surface))) {
                                                                                                  echo "selected=\"selected\"";
                                                                                                } ?>><?php echo $row_surf['surface_shortname']; ?></option>
                                <?php } ?>
                           
                              </select>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  <?php  } else { ?>
                    <input name="surface_id" type="hidden" value="" />
                  <?php  } ?>





                
                  <?php if (in_array("r", $array_form_main_detail)) { ?>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label> Root </label>
                        <select name="detail_root" class="form-control">
                          <option value="">--เลือก--</option>
                          <option value="1" <?php if (!(strcmp(1, $detail_root))) {
                                              echo "selected=\"selected\"";
                                            } ?>> 1</option>
                          <option value="2" <?php if (!(strcmp(2, $detail_root))) {
                                              echo "selected=\"selected\"";
                                            } ?>> 2</option>
                          <option value="3" <?php if (!(strcmp(3, $detail_root))) {
                                              echo "selected=\"selected\"";
                                            } ?>> 3</option>
                          <option value="4" <?php if (!(strcmp(4, $detail_root))) {
                                              echo "selected=\"selected\"";
                                            } ?>> 4</option>
                        </select>
                      </div>
                    </div>
                  <?php  } else { ?>
                    <input name="detail_root" type="hidden" value="" />
                  <?php  } ?>







                  <?php if (in_array("c", $array_form_main_detail)) { ?>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label> Class </label>
                        <select name="class_id" class="select2">
                          <option value="">--เลือก--</option>
                          <?php
                          $sql_class = "SELECT * FROM tbl_class order by class_id asc  ";
                          $query_class = $conn->query($sql_class);
                          while ($row_class = $query_class->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $row_class['class_id']; ?>" <?php if (!(strcmp($row_class['class_id'], $class_id))) {
                                                                                    echo "selected=\"selected\"";
                                                                                  } ?>><?php echo $row_class['class_name']; ?></option>
                          <?php } ?>
                       
                           <!-- <option value="(other)">other</option> -->
                        </select>
                      </div>
                    </div>
                  <?php  } else { ?>
                    <input name="class_id" type="hidden" value="" />
                  <?php  } ?>





                  <?php if (in_array("t", $array_form_main_detail)) { ?>
                  <?php $array_detail_tooth = json_decode($detail_tooth); ?>
                        
                    <div class="col-md-12">
                      <div class="form-group">


                        <label> <input type="checkbox" id="checkbox_<?php echo $result['detail_id']; ?>"> Select All Tooth </label>


                        <script src="plugins/jquery/jquery.min.js"></script>
                        <script>
                          $(document).ready(function() {
                            $("#checkbox_<?php echo $result['detail_id']; ?>").click(function() {
                              if ($("#checkbox_<?php echo $result['detail_id']; ?>").is(':checked')) { //select all
                                $("#ee<?php echo $result['detail_id']; ?>").find('option').prop("selected", true);
                                $("#ee<?php echo $result['detail_id']; ?>").trigger('change');
                              } else { //deselect all
                                $("#ee<?php echo $result['detail_id']; ?>").find('option').prop("selected", false);
                                $("#ee<?php echo $result['detail_id']; ?>").trigger('change');
                              }
                            });
                          });
                        </script>



                        <div class="select2-danger">

                          <select name="detail_tooth[]" id="ee<?php echo $result['detail_id']; ?>" class="select2" multiple="multiple" data-placeholder=" Tooth " data-dropdown-css-class="select2-danger" style="width: 100%;">

                          <?php //All / Full mouth
                            $Tooth = array("All / Full mouth", "PQ1", "PQ2", "PQ3", "PQ4", "UA", "LA"); 
                            foreach ( $Tooth as $key => $value ){ ?>
                            <option <?php if (in_array($value, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $value; ?></option>
                           <?php }  ?>


                            <?php  //ซี่ที่ 11 - 18
                            for ($a = 18, $b = 1; $a >= 11, $b <= 8; $a--, $b++) {
                            ?>
                              <option <?php if (in_array($a, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>> <?php echo $a; ?> </option>
                            <?php } ?>

                            <?php  //ซี่ที่ 21 - 28
                            for ($aa = 21, $b = 9; $aa <= 28, $b <= 16; $aa++, $b++) {
                            ?>
                              <option <?php if (in_array($aa, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $aa; ?></option>
                            <?php } ?>

                            <?php  //ซี่ที่ 41 - 48
                            for ($aaa = 48, $b = 17; $aaa >= 41, $b <= 24; $aaa--, $b++) {
                            ?>
                              <option <?php if (in_array($aaa, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $aaa; ?></option>
                            <?php } ?>



                            <?php //ซี่ที่ 31 - 38
                            for ($aaaa = 31, $b = 25; $aaaa <= 38, $b <= 32; $aaaa++, $b++) {
                            ?>
                              <option <?php if (in_array($aaaa, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $aaaa; ?></option>
                            <?php } ?>





  
                            <?php  //ซี่ที่ 51 - 55
                            for ($a = 55, $b = 1; $a >= 51, $b <= 5; $a--, $b++) {
                            ?>
                               <option <?php if (in_array($a, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $a; ?></option>

                            <?php } ?>


                            <?php  //ซี่ที่ 61 - 65
                            for ($a = 61, $b = 6; $a <= 65, $b <= 10; $a++, $b++) {
                            ?>
                              <option <?php if (in_array($a, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $a; ?></option>
                            <?php } ?>


                            <?php  //ซี่ที่ 85 - 81
                            for ($a = 85, $b = 11; $a >= 81, $b <= 15; $a--, $b++) {
                            ?>
                             <option <?php if (in_array($a, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $a; ?></option>
                            <?php } ?>



                            <?php  //ซี่ที่ 71 - 75
                            for ($a = 71, $b = 16; $a <= 75, $b <= 20; $a++, $b++) {
                            ?>
                             <option <?php if (in_array($a, $array_detail_tooth)) {
                                        echo "selected=\"selected\"";
                                      } ?>><?php echo $a; ?></option>
                            <?php } ?>






                          </select>
                        </div>

                      </div>
                    </div>


                  <?php  } else { ?>
                    <input name="detail_tooth[]" type="hidden" value="" />
                  <?php  } ?>





                  <div class="col-md-12">
                    <div class="form-group">
                      <label>ลงปฏิบัติงานของสาขา </label>
                      <select name="detail_type_work_id" id="detail_type_work_id" class="form-control select2" required>
                        <option value=""> เลือก งานของสาขา </option>
                        <?php
                        include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                        $sql_type_work = "SELECT * FROM tbl_type_work";
                        $query_type_work = $conn->query($sql_type_work);
                        while ($result_type_work = $query_type_work->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $result_type_work['type_work_id']; ?>" <?php if (!(strcmp($result_type_work['type_work_id'], $detail_type_work_id))) {
                                                                                              echo "selected=\"selected\"";
                                                                                            } ?>>
                            <?php echo $result_type_work['type_work_name']; ?>
                          </option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>



                  <?php  // เป็น Teacher   Staff  
                  if (($_SESSION['level_user'] == "Teacher") || ($_SESSION['level_user'] == "Staff")) {
                  ?>


                    <div class="col-md-12">
                      <div class="form-group">
                        <label> วันที่การจ่ายออกงาน <font color="red"> หากมีวันที่ ไม่ต้องเลือก </font></label>
                        <input type="date" name="detail_date_complete" id="detail_date_complete" value="<?php echo $detail_date_complete; ?>" class="form-control">
                      </div>
                    </div>



                    <div class="col-md-12">
                      <div class="form-group">
                        <label> สาเหตุการจ่ายออกงาน </label>
                        <select name="causes_of_pay_id" class="form-control select2">
                          <option value="">--เลือก causes_pay --</option>
                          <?php
                          $sql_causes = "SELECT * FROM tbl_causes_of_pay order by causes_of_pay_id asc  ";
                          $query_causes = $conn->query($sql_causes);
                          while ($row_causes = $query_causes->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $row_causes['causes_of_pay_id']; ?>" <?php if (!(strcmp($row_causes['causes_of_pay_id'], $causes_of_pay_id))) {
                                                                                              echo "selected=\"selected\"";
                                                                                            } ?>><?php echo $row_causes['causes_of_pay_detail']; ?></option>
                          <?php } ?>
                          
                           <!-- <option value="(other)">other</option> -->
                        </select>
                      </div>
                    </div>





                    <div class="col-md-12">
                      <div class="form-group">
                        <label> Competency </label>
                        <select name="detail_competency" class="form-control select2">

                          <option value="0" <?php if (!(strcmp(0, $detail_competency))) {
                                              echo "selected=\"selected\"";
                                            } ?>>No</option>
                          <option value="1" <?php if (!(strcmp(1, $detail_competency))) {
                                              echo "selected=\"selected\"";
                                            } ?>>YES</option>


                        </select>
                      </div>
                    </div>

                  <?php } ?>




                </div>
                <div class="modal-footer justify-content-between">
                  <button type="submit" class="btn btn-outline-danger"> แก้ไขข้อมูลงาน </button>
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                  <!-- <button type="button" class="btn btn-outline-danger"> OK </button>-->
                </div>
              </div>
              <!-- /.modal-content -->

            </div>
            <!-- /.modal-dialog -->

          </div>
          <!-- /.modal -->



        </form>



      <?php } ?>











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