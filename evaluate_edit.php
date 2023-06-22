<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myedit">
      Edit! 
</button>
 

 
<?php 

include "config.inc.php";
$sql   = " SELECT d.*, p.*, t.*, f.*  FROM  ";
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

<input name="evaluate_edit" type="hidden" value="evaluate_edit" />


<input name="plan_id" type="hidden" value="<?php echo $plan_id; ?>" />
<input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />
<input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />

<input name="arrange_date" type="hidden" value="<?php echo $arrange_date; ?>" />
<input name="arrange_id" type="hidden" value="<?php echo $arrange_id; ?>" />




<div class="modal fade" id="myedit">
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
              $sql_order = "SELECT * FROM tbl_order as o  ";
              $sql_order .= " where o.student_id = $student_id and o.causes_of_pay_id = 0 ";
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
        <?php 
          $array_detail_tooth = json_decode($detail_tooth);
        ?>
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
              <label> Date Complete </label>
              <input type="date" name="detail_date_complete" id="detail_date_complete" value="<?php echo $detail_date_complete; ?>" class="form-control">
            </div>
          </div>



          <div class="col-md-12">
            <div class="form-group">
              <label> Causes of pay </label>
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




