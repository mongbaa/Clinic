<?php include 'header.php'; ?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">






  <?php
  if (isset($_GET['form_main_id'])) {
    $form_main_id = $_GET['form_main_id'];
  } else {
    $form_main_id = "";
  }

  include "config.inc.php";
  $sql_form_main = "SELECT * FROM tbl_form_main , tbl_type_work where tbl_form_main.type_work_id=tbl_type_work.type_work_id and  tbl_form_main.form_main_id=$form_main_id";
  $query_form_main = $conn->query($sql_form_main);
  $row_form_main = $query_form_main->fetch_assoc();




  if (isset($_GET['del'])) {

    $form_detail_id = $_GET['del'];
    echo $sql_del = "DELETE FROM tbl_form_detail WHERE tbl_form_detail.form_detail_id = $form_detail_id";
    $conn->query($sql_del);

    echo "<script type='text/javascript'>";
    //echo  "alert('สร้างรายการประเมินสำเร็จ');";
    echo "window.location='form_main_detail.php?form_main_id=$form_main_id'";
    echo "</script>";
  }


  if (isset($_GET['edit'])) {

    $form_detail_id = $_GET['edit'];
    $sql_form_detail = "SELECT *  FROM tbl_form_detail where form_detail_id=$form_detail_id";
    $query_form_detail = $conn->query($sql_form_detail);
    $row_form_detail = $query_form_detail->fetch_assoc();

    $form_detail_id = $row_form_detail['form_detail_id'];
    $form_detail_topic = $row_form_detail['form_detail_topic'];
    $form_detail_field = $row_form_detail['form_detail_field'];
    $form_detail_order = $row_form_detail['form_detail_order'];
  } else {


    $sql_form_detail = "SELECT *   FROM tbl_form_detail where form_main_id=$form_main_id ORDER BY tbl_form_detail.form_detail_id DESC  LIMIT 0 , 1";
    $query_form_detail = $conn->query($sql_form_detail);
    $row_form_detail = $query_form_detail->fetch_assoc();



    $sql_form_detail_rows = "SELECT * FROM tbl_form_detail where  form_main_id=$form_main_id ";
    $query_form_detail_rows = $conn->query($sql_form_detail_rows);
    $row_form_detail_rows = $query_form_detail_rows->fetch_assoc();
    $row_cnt = $query_form_detail_rows->num_rows;
    $numstep = $row_cnt + 1;

    $form_detail_id = "";
    $form_detail_topic = "";
    $form_detail_field = "step" . $numstep;
    $form_detail_order = $numstep;
  }

  /*

  
  
  }*/


  ?>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-10">
          <h1>สร้างขั้นตอนการประเมินคะแนน สาขา : <?php echo $row_form_main['type_work_name']; ?>
            ชื่อฟอร์ม : <?php echo $row_form_main['form_main_name']; ?> </h1>
        </div>

        <div class="col-sm-2">
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

      <form id="form1" name="form1" method="post" action="form_main_detail_q.php">

        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th Width="6%">
                <div align="center">ลำดับ</div>
              </th>
              <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>
              <th Width="15%">
                <div align="center">น้ำหนัก,ครั้ง,คะแนน</div>
              </th>
              <th Width="6%">
                <div align="center">Hidden</div>
              </th>
              <th Width="10%">
                <div align="center">คะแนน</div>
              </th>
              <th Width="10%">
                <div align="center">Competency</div>
              </th>
              <th Width="10%">
                <div align="center">Complete</div>
              </th>
              <th>
                <div align="center">จัดการข้อมูล</div>
              </th>
            </tr>
          </thead>


          <tbody>

            <tr class="table-success">
              <td Width="6%">
                <div align="center"> </div>
              </td>

              <td Width="30%">
                <input type="hidden" name="form_detail_id" value="<?php echo $form_detail_id; ?>">
                <input type="text" name="form_detail_topic" class="form-control" id="form_detail_topic" value="<?php echo $form_detail_topic; ?>" placeholder="หัวข้อการประเมิน / ขั้นตอน" required>
                <input type="hidden" name="form_main_id" value="<?php echo $row_form_main['form_main_id']; ?>">



                <input type="text" name="form_detail_field" class="form-control" id="form_detail_field" value="<?php echo $form_detail_field; ?>" placeholder="ชื่อ Field" required>
                <input type="text" name="form_detail_order" class="form-control" id="form_detail_order" value="<?php echo $form_detail_order; ?>" placeholder=" ลำดับ " required>




              </td>


              <td Width="15%">
                <div align="center">

                  <select name="weight_type_id" class="form-control" required>
                    <option value="" <?php if ($row_form_detail['form_detail_topic'] == "") echo "selected"; ?>>-- เลือกประเภทน้ำหนัก / ครั้ง --</option>
                    <?php
                    include "config.inc.php";
                    $sql_weight_type = "select  *  from tbl_weight_type  ";
                    $query_weight_type = $conn->query($sql_weight_type);
                    while ($result_weight_type = $query_weight_type->fetch_assoc()) {
                    ?>

                      <option value="<?php echo $result_weight_type['weight_type_id']; ?> " <?php if ($row_form_detail['weight_type_id'] == $result_weight_type['weight_type_id']) echo "selected"; ?>>
                        <?php echo $result_weight_type['weight_type_name']; ?>
                      </option>

                    <?php } ?>
                  </select>


                  <input type="text" name="form_detail_weight" class="form-control" id="form_detail_weight" value="<?php echo $row_form_detail['form_detail_weight']; ?>" placeholder="ค่าน้ำหนัก/ครั้ง 0.1,0.5" required>
                </div>
              </td>

              <td Width="6%">
                <div align="center">
                  <input type="checkbox" name="form_detail_extra" class="form-control" value="Y" <?php if ($row_form_detail['form_detail_extra'] == "Y") echo "checked"; ?> />
                </div>
              </td>


              <td Width="10%">
                <div align="center">
                  <select name="score_type_id" class="form-control" required>

                    <?php
                    include "config.inc.php";
                    $sql_score_type = "select  *  from tbl_score_type where score_type_id=1 ";
                    $query_score_type = $conn->query($sql_score_type);
                    while ($result_score_type = $query_score_type->fetch_assoc()) {
                    ?>
                      <option value="<?php echo $result_score_type['score_type_id']; ?> " <?php if ($row_form_detail['score_type_id'] == $result_score_type['score_type_id']) echo "selected"; ?>>
                        <?php echo $result_score_type['score_type_name']; ?>
                      </option>
                    <?php } ?>
                  </select>


                  <select name="score_id" class="form-control" required>
                    <?php
                    include "config.inc.php";
                    $sql_score = "select  *  from tbl_score ";
                    $query_score = $conn->query($sql_score);
                    while ($result_score = $query_score->fetch_assoc()) {
                    ?>

                      <option value="<?php echo $result_score['score_id']; ?> " <?php if ($row_form_detail['score_id'] == $result_score['score_id']) echo "selected"; ?>>
                        <?php echo $result_score['score_name']; ?>
                      </option>

                    <?php } ?>
                  </select>

                </div>
              </td>



              <td Width="10%">
                <div align="center">
                  <input type="checkbox" name="form_detail_competency" class="form-control" value="Y" <?php if ($row_form_detail['form_detail_competency'] == "Y") echo "checked"; ?> />
                </div>
              </td>





              <td Width="10%">
                <div align="center">
                  <input type="checkbox" name="form_detail_complete" class="form-control" value="Y" <?php if ($row_form_detail['form_detail_complete'] == "Y") echo "checked"; ?> />
                </div>
              </td>



              <td>
                <div align="center">

                  <?php if (isset($_GET['edit'])) { ?>

                    <input type="submit" name="Submit" class="btn btn-info" value="Edit" />
                    <a href="?form_main_id=<?php echo $form_main_id; ?>" class="btn btn-danger">cancel</a>

                  <?php } else { ?>
                    <input type="submit" name="Submit" class="btn btn-info" value="Add" />
                  <?php } ?>







                </div>
              </td>
            </tr>
          <tbody>
        </table>

      </form>




      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">รายการฟอร์มประเมินคะแนน สาขา : <?php echo $row_form_main['type_work_name']; ?>
            ชื่อฟอร์ม : <?php echo $row_form_main['form_main_name']; ?> </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th Width="6%">
                  <div align="center">ลำดับ</div>
                </th>
                <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>
                <th Width="15%">
                  <div align="center">น้ำหนัก,ครั้ง,คะแนน</div>
                </th>
                <th Width="6%">
                  <div align="center">Hidden</div>
                </th>
                <th Width="10%">
                  <div align="center">คะแนน</div>
                </th>
                <th Width="10%">
                  <div align="center">Competency</div>
                </th>
                <th Width="10%">
                  <div align="center">Complete</div>
                </th>
                <th>
                  <div align="center">จัดการข้อมูล</div>
                </th>
              </tr>
            </thead>


            <tbody>













              <?php
              include "config.inc.php";
              $sql_form_detail = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id ORDER BY tbl_form_detail.form_detail_order ASC";
              $query_form_detail = $conn->query($sql_form_detail);
              $i = 0;
              while ($row_form_detail = $query_form_detail->fetch_assoc()) {
                $i++;
              ?>

                <tr>
                  <td>
                    <div align="center"><?php echo sprintf("%02d", $row_form_detail['form_detail_order']); ?></div>
                  </td>
                  <td><?php echo $row_form_detail['form_detail_topic']; ?> (<?php echo $row_form_detail['form_detail_field']; ?>) </td>


                  <td>
                    <div align="center">
                      <?php if ($row_form_detail['weight_type_id'] == 1) {
                        echo "";
                      } ?>

                      <?php if ($row_form_detail['weight_type_id'] == 2) { ?>

                        <?php echo $row_form_detail['form_detail_weight']; ?>

                      <?php } ?>

                      <?php if ($row_form_detail['weight_type_id'] == 3) { ?>

                        <select name="form_weight" class="form-control" required>
                          <option value=""> เลือก </option>

                          <?php
                          $step1 = explode(",", $row_form_detail['form_detail_weight']); // แยก   
                          $step2 = count($step1);
                          for ($ct = 0; $ct <= $step2; $ct++) {
                            $step = $step1[$ct];
                            if ($step != "") {
                          ?>

                              <option value="<?php echo $step; ?>"><?php echo $step; ?></option>

                          <?php
                            } //if
                          } //for
                          ?>

                        </select>

                      <?php } ?>




                      <?php if ($row_form_detail['weight_type_id'] == 4) { ?>

                        <input type="number" name="inputName" min="0.01" step="0.01" value="<?php echo $row_form_detail['form_detail_weight']; ?>">

                      <?php } ?>







                    </div>
                  </td>



                  <td>
                    <div align="center">

                      <?php if ($row_form_detail['form_detail_extra'] == "Y") { ?>
                        Hidden
                      <?php } ?>

                    </div>
                  </td>







                  <td>
                    <div align="center"> <?php // การเลือกคะแนน 
                                          ?>
                      <?php $row_form_detail['score_type_id']; ?>
                      <?php $score_id = $row_form_detail['score_id']; ?>

                      <?php if ($row_form_detail['score_type_id'] == 1) { ?>
                        <select name="score_id" class="form-control" required>
                          <option value="">-- N/A --</option>
                          <?php
                          include "config.inc.php";
                          $sql_score_d = "select  *  from tbl_score_detail where score_id=$score_id  ";
                          $query_score_d = $conn->query($sql_score_d);
                          while ($result_score_d = $query_score_d->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $result_score_d['score_detail_rate']; ?> "><?php echo $result_score_d['score_detail_name']; ?> </option>
                          <?php } ?>
                        </select>
                      <?php } ?>

                      <?php if ($row_form_detail['score_type_id'] == 2) { ?>
                        <input type="text" name="score" class="form-control" placeholder="">
                      <?php } ?>

                    </div>
                  </td>













                  <td>
                    <div align="center">
                      <?php if ($row_form_detail['form_detail_competency'] == "Y") { ?>
                        <input type="checkbox" name="competency" class="form-control" value="checkbox" />
                      <?php } ?>
                    </div>
                  </td>



                  <td>
                    <div align="center">
                      <?php if ($row_form_detail['form_detail_complete'] == "Y") { ?>
                        <input type="checkbox" name="complete" class="form-control" value="checkbox" />
                      <?php } ?>
                    </div>
                  </td>



                  <td>
                    <div align="center">

                      <?php if ($row_form_main['form_main_confirm'] == 1) {?>

                         <a href="?form_main_id=<?php echo $row_form_detail['form_main_id']; ?>&edit=<?php echo $row_form_detail['form_detail_id']; ?>" class="btn btn-info">แก้ไข</a>

                      <?php } else { ?>
                        <a href="?form_main_id=<?php echo $row_form_detail['form_main_id']; ?>&del=<?php echo $row_form_detail['form_detail_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">ลบ</a>
                        <a href="?form_main_id=<?php echo $row_form_detail['form_main_id']; ?>&edit=<?php echo $row_form_detail['form_detail_id']; ?>" class="btn btn-info">แก้ไข</a>
                      <?php } ?>

                    </div>
                  </td>
                </tr>





              <?php } ?>


            </tbody>

          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->











      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title"> SQL CREATE TABLE

            <?php if ($row_form_main['form_main_confirm'] == 1) {
              
            } else { ?>

            <a href="?confirm=1&form_main_id=<?php echo $form_main_id; ?>" class="btn btn-success" onClick="return confirm('กรุณายืนยัน การสร้าง Table อีกครั้ง...!!!')"> <i class="fab fa-angellist"></i> Confirm </i> </a>
            <?php } ?>
            <a href="?template=1&form_main_id=<?php echo $form_main_id; ?>" class="btn btn-info" onClick="return confirm('กรุณายืนยัน การสร้าง Table อีกครั้ง...!!!')"> .template </a>

          </h3>


        </div>
        <!-- /.card-header -->
        <div class="card-body">

          <?php

          $tbl = "tbl_" . $row_form_main['form_main_table']; //ชื่อตาราง
          $id = $row_form_main['form_main_table'] . "_id"; //ชื่อ ID ของตาราง
          $table = $row_form_main['form_main_table'];



          $create = "CREATE TABLE $tbl ("; //ชื่อตารางเก็บข้อมูล

          $create .= " $id INT NOT NULL AUTO_INCREMENT , "; //

          $create .= " student_id  VARCHAR(20) NOT NULL , "; // รหัสนักศึกษา

          $create .= " detail_id  INT(20) NOT NULL , "; // รหัสงาน



          include "config.inc.php";
          $sql_form_detail = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id ORDER BY tbl_form_detail.form_detail_order ASC";
          $query_form_detail = $conn->query($sql_form_detail);
          while ($row_form_detail = $query_form_detail->fetch_assoc()) {

            $field = $table . "_" . $row_form_detail['form_detail_field'];

           // if ($row_form_detail['weight_type_id'] != 1) {
              $create .= " $field" . "_weight FLOAT NOT NULL , "; // น้ำหนัก / ครั้ง / คะแนนเต็ม
           // }



            if ($row_form_detail['form_detail_extra'] == "Y") {
            //  $create .= " $field" . "_extra FLOAT NOT NULL , ";
            }

            $create .= " $field" . "_grade VARCHAR(2) NOT NULL ,"; //เกรดที่ได้รับ
            $create .= " $field" . "_teacher INT NOT NULL , ";  // รหัสอาจารย์ผู้ประเมิน
            $create .= " $field" . "_date DATETIME NOT NULL , ";  // วันที่บันทึก // เวลาที่บันทึก



            if ($row_form_detail['form_detail_competency'] == "Y") {
              $create .= " $field" . "_competency VARCHAR(2) NOT NULL , ";
            }


            if ($row_form_detail['form_detail_complete'] == "Y") {
              $create .= " $field" . "_complete VARCHAR(2) NOT NULL , ";
            }
          }


          $create .= " $table" . "_comment   TEXT  NOT NULL , "; // commint
          $create .= " last_date DATE NOT NULL , last_time TEXT NOT NULL , "; // วันที่ล่าสุด
          $create .= " $table" . "_log TEXT NOT NULL , "; // log
          $create .= " PRIMARY KEY ($id)";
          $create .= ") ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

 

          ?>

          <code> <?php echo $create; ?> </code>


          <?php
          if (isset($_GET['confirm'])) {

            $form_main_id = $_GET['form_main_id'];

            $sql_create = "{$create}";
            $conn->query($sql_create);

            $sql_update = "UPDATE tbl_form_main SET form_main_confirm = '1' WHERE form_main_id =$form_main_id;";
            $conn->query($sql_update);



            echo "<script type='text/javascript'>";
            echo  "alert('[สร้าง Table สำเร็จ]');";
            echo "window.location='form_main_detail.php?form_main_id=$form_main_id';";
            echo "</script>";
          }
          ?>







        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->


      <?php
      if (isset($_GET['template'])) {

        $form_main_id = $_GET['form_main_id'];



        include "config.inc.php";
        $sql_form_main = "SELECT * FROM tbl_form_main where tbl_form_main.form_main_id=$form_main_id ";
        $query_form_main = $conn->query($sql_form_main);
        $row_form_main = $query_form_main->fetch_assoc();
        $type_work_id = $row_form_main['type_work_id'];
        $form_main_name = $row_form_main['form_main_name'] . date('YmdHis');
        $form_main_format = $row_form_main['form_main_format'];
        $form_main_type = $row_form_main['form_main_type'];
        $form_main_status = $row_form_main['form_main_status'];
        $form_main_table = $row_form_main['form_main_table'] . date('YmdHis');
        $form_main_detail = $row_form_main['form_main_detail'];
        $form_main_confirm = 0;

        $sql = "INSERT INTO tbl_form_main (form_main_id, type_work_id, form_main_name, form_main_format, form_main_type, form_main_status, form_main_table, form_main_detail, form_main_confirm) VALUES (NULL, '$type_work_id', '$form_main_name', '$form_main_format', '$form_main_type', '$form_main_status', '$form_main_table', '$form_main_detail', '$form_main_confirm');";
        $conn->query($sql);
        $insert_id = $conn->insert_id;




        $sql_form_detail = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id ORDER BY tbl_form_detail.form_detail_order ASC";
        $query_form_detail = $conn->query($sql_form_detail);
        while ($row_form_detail = $query_form_detail->fetch_assoc()) {

          $form_main_id = $insert_id;
          $form_detail_topic = $row_form_detail['form_detail_topic'];
          $weight_type_id = $row_form_detail['weight_type_id'];
          $form_detail_weight = $row_form_detail['form_detail_weight'];
          $form_detail_extra = $row_form_detail['form_detail_extra'];
          $score_type_id = $row_form_detail['score_type_id'];
          $score_id = $row_form_detail['score_id'];
          $form_detail_competency = $row_form_detail['form_detail_competency'];
          $form_detail_complete = $row_form_detail['form_detail_complete'];
          $form_detail_field = $row_form_detail['form_detail_field'];
          $form_detail_order = $row_form_detail['form_detail_order'];

          echo "<br>";
          $sql_detail = "INSERT INTO tbl_form_detail (form_detail_id, form_main_id, form_detail_topic, weight_type_id, form_detail_weight, form_detail_extra, score_type_id, score_id, form_detail_competency, form_detail_complete, form_detail_field, form_detail_order) VALUES (NULL, '$form_main_id', '$form_detail_topic', '$weight_type_id', '$form_detail_weight', '$form_detail_extra', '$score_type_id', '$score_id', '$form_detail_competency', '$form_detail_complete', '$form_detail_field', '$form_detail_order');";
          $conn->query($sql_detail);
        }


        echo "<script type='text/javascript'>";
        //  echo  "alert('[สร้าง Table สำเร็จ]');";
        echo "window.location='form_main_detail.php?form_main_id=$form_main_id';";
        echo "</script>";
      }
      ?>


    </div>
</div>
</div>
</section>





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