<?php include 'header.php'; ?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">


<?php
if (isset($_GET['type_work_id'])) {

    $type_work_id = $_GET['type_work_id'];
} else {

    $type_work_id = 1;
}
?>



  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1>สร้างขั้นตอนการประเมินคะแนน Conduct & Knowledge สาขาวิชา </h1>
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

  <?php
if (isset($_GET['edit'])) {

    include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
    $form_conduct_knowledge_id = $_GET['edit'];
    $sql_edit = "SELECT * FROM tbl_form_conduct_knowledge where form_conduct_knowledge_id=$form_conduct_knowledge_id ";
    $query_edit = $conn->query($sql_edit);
    $result_edit = $query_edit->fetch_assoc();

    $form_conduct_knowledge_id = $result_edit['form_conduct_knowledge_id'];
    $form_conduct_knowledge_type = $result_edit['form_conduct_knowledge_type'];
    $type_work_id = $result_edit['type_work_id'];
    $form_conduct_knowledge_order = $result_edit['form_conduct_knowledge_order'];
    $form_conduct_knowledge_field = $result_edit['form_conduct_knowledge_field'];
    $form_conduct_knowledge_name = $result_edit['form_conduct_knowledge_name'];
    $form_conduct_knowledge_score = $result_edit['form_conduct_knowledge_score'];
    $form_conduct_knowledge_status = $result_edit['form_conduct_knowledge_status'];
    $form_conduct_knowledge_log = $result_edit['form_conduct_knowledge_log'];

} else {

    include "config.inc.php";
    $sql_ck_numstep = "SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id  ORDER BY form_conduct_knowledge_id DESC ";
    $query_ck_numstep = $conn->query($sql_ck_numstep);
    $row_ck_numstep = $query_ck_numstep->fetch_assoc();
    $row_cnt = $query_ck_numstep->num_rows;
    $numstep = $row_cnt + 1;

    $form_conduct_knowledge_type = $row_ck_numstep['form_conduct_knowledge_type'];
    $form_conduct_knowledge_score = $row_ck_numstep['form_conduct_knowledge_score'];
    $form_conduct_knowledge_status = $row_ck_numstep['form_conduct_knowledge_status'];

    $form_conduct_knowledge_order = $numstep;
    $form_conduct_knowledge_field = "step" . $numstep;


    $form_conduct_knowledge_id = "";
    $type_work_id = $type_work_id;
    $form_conduct_knowledge_name = "";
    $form_conduct_knowledge_log = "";
    
}

/*
if (isset($_GET['del'])) {
    include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
    $form_conduct_knowledge_id = $_GET['del'];
    $sql_del = "DELETE FROM tbl_form_conduct_knowledge WHERE tbl_form_conduct_knowledge.form_conduct_knowledge_id = $form_conduct_knowledge_id";
    $conn->query($sql_del);
    echo "<script type='text/javascript'>";
    //echo  "alert('บันทึกสำเร็จ');";
    echo "window.location='form_conduct_knowledge.php'";
    echo "</script>";
}*/
?>


  <?php

  if (isset($_GET['del'])) {

    $form_conduct_knowledge_id = $_GET['del'];

    include "config.inc.php";
    $sql_show_field = "SELECT * FROM tbl_form_conduct_knowledge where  form_conduct_knowledge_id = $form_conduct_knowledge_id";
    $query_show = $conn->query($sql_show_field);
    $row_show = $query_show->fetch_assoc();

    $form_conduct_knowledge_field = $row_show['form_conduct_knowledge_field'];
    $type_work_ids = $row_show['type_work_id'];

    $sql_del = "DELETE FROM tbl_form_conduct_knowledge WHERE form_conduct_knowledge_id = $form_conduct_knowledge_id";
    $conn->query($sql_del);

    $sql_DROP = "ALTER TABLE tbl_ck_$type_work_id  DROP $form_conduct_knowledge_field  ";
    $conn->query($sql_DROP);

    echo "<script type='text/javascript'>";
    //echo  "alert('สร้างรายการประเมินสำเร็จ');";
    echo "window.location='form_conduct_knowledge.php?type_work_id=$type_work_ids'";
    echo "</script>";

  }

  ?>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">


    <form name="myForm" id="myForm" action="" method="get">
            <div class="row">
                <div class="col-sm-2">
                    <select name="type_work_id" id="select" class="form-control select2" required onchange="this.form.submit();">
                        <?PHP
                        include "config.inc.php";
                        $sql_type_work = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                        $query_type_work = $conn->query($sql_type_work);
                        while ($result_type_work  = $query_type_work->fetch_assoc()) {
                        ?>
                            <option value="<?= $result_type_work['type_work_id']; ?>" <?php if ($type_work_id == $result_type_work['type_work_id']) {
                                                                                            echo "selected";
                                                                                        } ?>><?= $result_type_work['type_work_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>




      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">รายการฟอร์มประเมินคะแนน  Conduct & Knowledge สาขาวิชา > <B><?php echo nameType_work::get_type_work_name($type_work_id);?></B> 
          <a href="conduct_knowledge.php?type_work_id=<?php echo $type_work_id; ?>" class="btn btn-info" target="_blank"> บันทึกข้อมูลย้อนหลัง </a>
          </h3>
        
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

                <th Width="30%">
                  <div align="center">คะแนน</div>
                </th>

                <th Width="10%">
                  <div align="center">status</div>
                </th>
              
                <th>
                  <div align="center">จัดการข้อมูล</div>
                </th>

              </tr>
            </thead>


            <tbody>




              <form id="form1" name="form1" method="post" action="form_conduct_knowledge_q.php">

                <input type="hidden" name="form_conduct_knowledge_id" value="<?php echo $form_conduct_knowledge_id; ?>">
                <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
                <tr class="table-success">
                  <td Width="6%">
                    <div align="center">
                      <input type="text" name="form_conduct_knowledge_order" class="form-control" id="form_conduct_knowledge_order" value="<?php echo $form_conduct_knowledge_order; ?>" placeholder=" ลำดับ " required>
                      <input type="text" name="form_conduct_knowledge_field" class="form-control" id="form_conduct_knowledge_field" value="<?php echo $form_conduct_knowledge_field; ?>" placeholder="ชื่อ Field" required>
                    </div>
                  </td>

                  <td Width="30%">
                                   <select name="form_conduct_knowledge_type" id="select" class="form-control">
                                <option value="1" <?php if ($form_conduct_knowledge_type == 1) {
                                                        echo "selected";
                                                    } ?>> -- Conduct -- </option>
                                <option value="2" <?php if ($form_conduct_knowledge_type == 2) {
                                                        echo "selected";
                                                    } ?>> -- Knowledge -- </option>
                            </select>
                    <input type="text" name="form_conduct_knowledge_name" class="form-control" id="form_conduct_knowledge_name" value="<?php echo $form_conduct_knowledge_name; ?>" placeholder="รายการประเมิน" required>
                  </td>



                  <td Width="10%">
                    <div align="center">
                      <input type="text" name="form_conduct_knowledge_score" class="form-control" id="form_conduct_knowledge_score" value="<?php echo $form_conduct_knowledge_score; ?>" placeholder="ค่าคะแนน Good=3,Weak=1" required>
                    </div>
                  </td>





                  <td Width="10%">
                    <div align="center">
                      <select name="form_conduct_knowledge_status" id="form_conduct_knowledge_status" class="form-control" required>
                        <option value=""> เลือกสถานะ </option>
                        <option value="1" <?php if (!(strcmp("1", $form_conduct_knowledge_status))) {
                                            echo "selected=\"selected\"";
                                          } ?>> เปิดใช้งาน </option>
                        <option value="0" <?php if (!(strcmp("0", $form_conduct_knowledge_status))) {
                                            echo "selected=\"selected\"";
                                          } ?>> ปิดใช้งาน </option>
                      </select>
                    </div>
                  </td>



                  

                  <td Width="10%">
                    <div align="center">
                      <?php if (isset($_GET['edit'])) { ?>
                        <input type="submit" name="Submit" class="btn btn-info" value="Edit" />
                        <a href="_conduct_knowledge.php" class="btn btn-danger">Cancel</a>
                      <?php } else { ?>
                        <input type="submit" name="Submit" class="btn btn-info" value="Add" />
                      <?php } ?>
                    </div>
                  </td>


                </tr>
              </form>
            </tbody>

          </table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->





      






      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title"> ข้อมูล Conduct & Knowledge สาขาวิชา > <B><?php echo nameType_work::get_type_work_name($type_work_id);?></B>  </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">







          <table id="example1" class="table table-bordered table-striped">

            <thead>
              <tr>
                <th Width="5%">
                  <div align="center">ลำดับ</div>
                </th>
                <th Width="10%"> ประเภท </th>
                <th Width="30%"> หัวข้อการประเมิน / ขั้นตอน </th>

                <th Width="4%">
                  <div align="center"> คะแนน </div>
                </th>
               
                <th Width="15%">
                  <div align="center">สถานะ</div>
                </th>
                <th Width="10%">
                  <div align="center">จัดการข้อมูล</div>
                </th>
              </tr>
            </thead>


            <tbody>

                <?PHP
                    include "config.inc.php";
                    $sql   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
                    $sql  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
                    $sql  .=  " ORDER BY c.form_conduct_knowledge_id ASC ";
                    $query = $conn->query($sql);
                    $i = 0;
                    while ($row_conduct_knowledge = $query->fetch_assoc()) {
                    $i++;
                ?>

                <tr>

                  <td>
                    <div align="center"><?php echo $i; ?> (<?php echo $row_conduct_knowledge['form_conduct_knowledge_order']; ?>)</div>
                  </td>

                  <td>
                    <div align="center">
                                    <?php
                                    $form_conduct_knowledge_type = $row_conduct_knowledge['form_conduct_knowledge_type'];
                                    switch ($form_conduct_knowledge_type) { // Harder page
                                        case 0:
                                            echo  " -- ";
                                            break;
                                        case 1:
                                            echo  "Conduct";
                                            break;
                                        case 2:
                                            echo  "Knowledge";
                                            break;
                                        default:
                                            echo  "-";
                                            break;
                                    }
                                    ?>
                    </div>
                  </td>
                  <td><?php echo $row_conduct_knowledge['form_conduct_knowledge_name']; ?> (<?php echo $row_conduct_knowledge['form_conduct_knowledge_field']; ?>) </td>
                  <td>
                  <?php echo $row_conduct_knowledge['form_conduct_knowledge_score']; ?>
                  </

                  <td>
                        <?php
                                    $form_conduct_knowledge_status = $row_conduct_knowledge['form_conduct_knowledge_status'];
                                    switch ($form_conduct_knowledge_status) { // Harder page
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


                  <td>
                    <div align="center">
                    
                        <a href="?form_conduct_knowledge_id=<?php echo $row_conduct_knowledge['form_conduct_knowledge_id']; ?>&del=<?php echo $row_conduct_knowledge['form_conduct_knowledge_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">ลบ</a>
                        <a href="?form_conduct_knowledge_id=<?php echo $row_conduct_knowledge['form_conduct_knowledge_id']; ?>&edit=<?php echo $row_conduct_knowledge['form_conduct_knowledge_id']; ?>" class="btn btn-info">แก้ไข</a>
                   
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




    </div>
</div>
</div>
</section>







<?php include 'footer.php'; ?>




<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>



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


<!-- page script Tooltip -->
<script type="text/javascript">
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<!-- page script Tooltip -->



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