<?php include 'header.php'; ?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">



  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

      <div class="row mb-2">


        <div class="col-sm-8">
          <h1>สร้างขั้นตอนการประเมินคะแนน Holistic approach and professionalism </h1>
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

  if (isset($_GET['del'])) {

    $form_holistic_id = $_GET['del'];

    include "config.inc.php";
    $sql_show_field = "SELECT * FROM tbl_form_holistic where  form_holistic_id = $form_holistic_id";
    $query_show = $conn->query($sql_show_field);
    $row_show = $query_show->fetch_assoc();
    $form_holistic_field = $row_show['form_holistic_field'];


    $sql_del = "DELETE FROM tbl_form_holistic WHERE form_holistic_id = $form_holistic_id";
    $conn->query($sql_del);


    $note = $form_holistic_field . "_note";



    $sql_DROP = "ALTER TABLE tbl_holistic DROP $form_holistic_field , DROP $note ";
    $conn->query($sql_DROP);

    echo "<script type='text/javascript'>";
    //echo  "alert('สร้างรายการประเมินสำเร็จ');";
    echo "window.location='form_holistic.php'";
    echo "</script>";
  }

  ?>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">





      <?php
      include "config.inc.php";
      $sql_holistic_numstep = "SELECT * FROM tbl_form_holistic ORDER BY form_holistic_id DESC ";
      $query_holistic_numstep = $conn->query($sql_holistic_numstep);
      $row_holistic_numstep = $query_holistic_numstep->fetch_assoc();
      $row_cnt = $query_holistic_numstep->num_rows;
      $numstep = $row_cnt + 1;
      $form_holistic_field = "step" . $numstep;
      $form_holistic_order = $numstep;

      $form_holistic_group = $row_holistic_numstep['form_holistic_group'];
      $form_holistic_score = $row_holistic_numstep['form_holistic_score'];
      $form_holistic_note = $row_holistic_numstep['form_holistic_note'];
      $form_holistic_status = $row_holistic_numstep['form_holistic_status'];
      ?>



      <div class="card card-warning">
        <div class="card-header">
          <h3 class="card-title">รายการฟอร์มประเมินคะแนน Holistic </h3>
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
                  <div align="center">หมายเหตุ</div>
                </th>
                <th Width="10%">
                  <div align="center">status</div>
                </th>
                <th Width="10%">
                  <div align="center">AFTER</div>
                </th>
                <th>
                  <div align="center">จัดการข้อมูล</div>
                </th>
              </tr>
            </thead>


            <tbody>




              <form id="form1" name="form1" method="post" action="form_holistic_q.php">
                <input type="hidden" name="form_holistic_id" value="<?php echo $row_form_main['form_holistic_id']; ?>">

                <tr class="table-success">

                  <td Width="6%">
                    <div align="center">
                      <input type="text" name="form_holistic_order" class="form-control" id="form_holistic_order" value="<?php echo $form_holistic_order; ?>" placeholder=" ลำดับ " required>
                      <input type="text" name="form_holistic_field" class="form-control" id="form_holistic_field" value="<?php echo $form_holistic_field; ?>" placeholder="ชื่อ Field" required>
                    </div>
                  </td>


                  <td Width="30%">
                    <input type="text" name="form_holistic_group" class="form-control" id="form_holistic_group" value="<?php echo $form_holistic_group; ?>" placeholder="Domain" required>

                    <input type="text" name="form_holistic_name" class="form-control" id="form_holistic_name" value="<?php //echo $form_holistic_name; ?>" placeholder="Stressing points" required>
                  </td>


                  <td Width="10%">
                    <div align="center">
                      <input type="text" name="form_holistic_score" class="form-control" id="form_holistic_score" value="<?php echo $form_holistic_score; ?>" placeholder="ค่าคะแนน Good=3,Weak=1" required>

                      <textarea name="form_holistic_detail" id="form_holistic_detail" class="form-control" rows="4" cols="50"></textarea>
                    </div>
                  </td>


                  <td Width="10%">
                    <div align="center">
                      <input type="text" name="form_holistic_note" class="form-control" id="form_holistic_note" value="<?php echo $form_holistic_note; ?>" placeholder="หมายเหตุ" required>
                    </div>
                  </td>







                  <td Width="10%">
                    <div align="center">
                      <select name="form_holistic_status" id="form_holistic_status" class="form-control" required>
                        <option value=""> เลือกสถานะ </option>
                        <option value="1" <?php if (!(strcmp("1", $form_holistic_status))) {
                                            echo "selected=\"selected\"";
                                          } ?>> เปิดใช้งาน </option>
                        <option value="0" <?php if (!(strcmp("0", $form_holistic_status))) {
                                            echo "selected=\"selected\"";
                                          } ?>> ปิดใช้งาน </option>
                      </select>
                    </div>
                  </td>


             

                  <td Width="10%">
                    <div align="center">
                      <select name="AFTER" id="AFTER" class="form-control">
                        <option value=""> เลือกหลัง Field </option>
                        <?php
                        include "config.inc.php";
                        $sql_AFTER = "SELECT * FROM tbl_form_holistic ORDER BY tbl_form_holistic.form_holistic_id ASC";
                        $query_AFTER = $conn->query($sql_AFTER);
                        while ($row_AFTER = $query_AFTER->fetch_assoc()) {
                        ?>
                          <option value="<?php echo $row_AFTER['form_holistic_field']; ?>"><?php echo $row_AFTER['form_holistic_field']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </td>








                  <td Width="10%">
                    <div align="center">
                      <?php if (isset($_GET['edit'])) { ?>
                        <input type="submit" name="Submit" class="btn btn-info" value="Edit" />
                        <a href="_holistic.php" class="btn btn-danger">Cancel</a>
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
          <h3 class="card-title"> Holistic approach and professionalism (10%) (default = N/A)</h3>
          <h4 class="card-title">คำชี้แจง ขอให้ทำเครื่องหมาย  ใน • ที่นักศึกษาได้แสดงถึงความสามารถและพฤติกรรมตามรายละเอียดที่กำหนด</h4>


        </div>
        <!-- /.card-header -->
        <div class="card-body">




          <script type="text/javascript" language="javascript">
            function checkall(st) {

              if (st == '3') {
                /* <?php for ($x = 1; $x <= 10; $x++) { ?>*/
                document.getElementById('step<?php echo $x; ?>_3').checked = true;
                /* <?php } ?>*/
              }


              if (st == '2') {
                /* <?php for ($x = 1; $x <= 10; $x++) { ?>*/
                document.getElementById('step<?php echo $x; ?>_2').checked = true;
                /* <?php } ?>*/
              }



              if (st == '1') {
                /* <?php for ($x = 1; $x <= 10; $x++) { ?>*/
                document.getElementById('step<?php echo $x; ?>_1').checked = true;
                /* <?php } ?>*/
              }


              if (st == '0') {
                /* <?php for ($x = 1; $x <= 10; $x++) { ?>*/
                document.getElementById('step<?php echo $x; ?>_0').checked = true;
                /* <?php } ?>*/
              }

            }
          </script>










          <table id="example1" class="table table-bordered table-striped">

            <thead>
              <tr>
                <th Width="5%">
                  <div align="center">ลำดับ</div>
                </th>
                <th Width="10%">Domain </th>
                <th Width="30%">Stressing points</th>
                <th Width="4%">
                  <div align="center"><a href="javascript:checkall('3')">Good<br>(3)</a></div>
                </th>
                <th Width="4%">
                  <div align="center"><a href="javascript:checkall('2')">Average<br>(2)</a></div>
                </th>
                <th Width="4%">
                  <div align="center"><a href="javascript:checkall('1')">Weak<br>(1)</a></div>
                </th>
                <th Width="4%">
                  <div align="center"><a href="javascript:checkall('0')">N/A<br>(0)</a></div>
                </th>
                <th Width="15%">
                  <div align="center">หมายเหตุ</div>
                </th>
                <th Width="10%">
                  <div align="center">จัดการข้อมูล</div>
                </th>
              </tr>
            </thead>


            <tbody>


              <?php
              include "config.inc.php";
              $sql_holistic = "SELECT * FROM tbl_form_holistic ORDER BY tbl_form_holistic.form_holistic_order ASC";
              $query_holistic = $conn->query($sql_holistic);
              $i = 0;
              while ($row_holistic = $query_holistic->fetch_assoc()) {
                $i++;

                $step_detail = explode(",", $row_holistic['form_holistic_detail']); // แยก   



              ?>

                <tr>
                  <td>
                    <div align="center"><?php echo $i; ?> (<?php echo $row_holistic['form_holistic_order']; ?>)</div>
                  </td>
                  <td>
                    <div align="center"><?php echo $row_holistic['form_holistic_group']; ?></div>
                  </td>
                  <td><?php echo $row_holistic['form_holistic_name']; ?> (<?php echo $row_holistic['form_holistic_field']; ?>) </td>


                  <td>
                    <a href="#" data-toggle="tooltip" title="<?php echo $step_detail[0]; ?>">
                      <input type="radio" name="<?php echo $row_holistic['form_holistic_field']; ?>" id="<?php echo $row_holistic['form_holistic_field'] . "_3"; ?>" class="form-control" checked value="3">
                    </a>
                  </td>

                  <td>
                    <a href="#" data-toggle="tooltip" title="<?php echo $step_detail[1]; ?>">
                      <input type="radio" name="<?php echo $row_holistic['form_holistic_field']; ?>" id="<?php echo $row_holistic['form_holistic_field'] . "_2"; ?>" class="form-control" checked value="2">
                    </a>
                  </td>

                  <td>
                    <a href="#" data-toggle="tooltip" title="<?php echo $step_detail[2]; ?>">
                      <input type="radio" name="<?php echo $row_holistic['form_holistic_field']; ?>" id="<?php echo $row_holistic['form_holistic_field'] . "_1"; ?>" class="form-control" checked value="1">
                    </a>
                  </td>

                  <td>
                    <a href="#" data-toggle="tooltip" title="<?php echo $step_detail[3]; ?>">
                      <input type="radio" name="<?php echo $row_holistic['form_holistic_field']; ?>" id="<?php echo $row_holistic['form_holistic_field'] . "_0"; ?>" class="form-control" checked value="0">
                    </a>
                  </td>

                  <td>
                    <textarea name=" <?php echo $row_holistic['form_holistic_field'] . "_note"; ?>" class="form-control"> </textarea>
                  </td>





                  <td>
                    <div align="center">
                    
                        <a href="?form_holistic_id=<?php echo $row_holistic['form_holistic_id']; ?>&del=<?php echo $row_holistic['form_holistic_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">ลบ</a>
                        <a href="?form_holistic_id=<?php echo $row_holistic['form_holistic_id']; ?>&edit=<?php echo $row_holistic['form_holistic_id']; ?>" class="btn btn-info">แก้ไข</a>
                   
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