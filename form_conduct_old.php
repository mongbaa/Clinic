<?php include'header.php';?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">


<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

                                <!-- Content Header (Page header) -->
                          <section class="content-header">
                                <div class="container-fluid">
                              
                                  <div class="row mb-2">
                                    
                                    <div class="col-sm-8">
                                    <h1> สร้างขั้นตอนการประเมินคะแนน  Conduct </h1>
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

if(isset($_GET['del']))
  {

$form_conduct_id=$_GET['del'];

include "config.inc.php"; 
$sql_show_field = "SELECT * FROM tbl_form_conduct where  form_conduct_id = $form_conduct_id";
$query_show = $conn->query($sql_show_field); 
$row_show = $query_show->fetch_assoc();
$form_conduct_field = $row_show['form_conduct_field'];

$sql_del= "DELETE FROM tbl_form_conduct WHERE form_conduct_id = $form_conduct_id";
$conn->query($sql_del); 

$sql_DROP= "ALTER TABLE tbl_conduct DROP $form_conduct_field";
$conn->query($sql_DROP); 
 
 echo "<script type='text/javascript'>";
 //echo  "alert('สร้างรายการประเมินสำเร็จ');";
 echo "window.location='form_conduct.php'";
 echo "</script>";

  }

?>

              <!-- Main content -->
              <section class="content">
                    <div class="container-fluid">
                     
                      



            <?php
            include "config.inc.php"; 
            $sql_conduct_numstep = "SELECT * FROM tbl_form_conduct ORDER BY form_conduct_id DESC ";
            $query_conduct_numstep = $conn->query($sql_conduct_numstep); 
            $row_conduct_numstep = $query_conduct_numstep->fetch_assoc();
            $row_cnt = $query_conduct_numstep->num_rows;
            $numstep=$row_cnt+1;
            $form_conduct_field="step".$numstep;
            $form_conduct_order = $numstep;

            $form_conduct_score = $row_conduct_numstep['form_conduct_score'];
            $form_conduct_note = $row_conduct_numstep['form_conduct_note'];
            $form_conduct_status = $row_conduct_numstep['form_conduct_status'];
            ?>


            <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">รายการฟอร์มประเมินคะแนน Conduct </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                    <tr>
                      <th Width="6%"><div align="center">ลำดับ</div></th>
                      <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>
                      <th Width="30%"><div align="center">คะแนน</div></th>
                      <th Width="10%"><div align="center">หมายเหตุ</div></th>
                      <th Width="10%"><div align="center">status</div></th>
                      <th Width="10%"><div align="center">AFTER</div></th>
                      <th><div align="center">จัดการข้อมูล</div></th>
                    </tr>
              </thead>


              <tbody>




              <form id="form1" name="form1" method="post" action="form_conduct_q.php">
              <input type="hidden" name="form_conduct_id" value="<?php echo $row_form_main['form_conduct_id'];?>">

                 <tr class="table-success">
                
                    <td Width="6%"><div align="center">
                    <input type="text" name="form_conduct_order" class="form-control" id="form_conduct_order" value="<?php echo $form_conduct_order;?>" placeholder=" ลำดับ " required>
                    <input type="text" name="form_conduct_field" class="form-control" id="form_conduct_field" value="<?php echo $form_conduct_field;?>" placeholder="ชื่อ Field" required>

                    </div></td>


                    <td Width="30%">
                    <input type="text" name="form_conduct_name" class="form-control" id="form_conduct_name" value="<?php echo $form_conduct_name;?>" placeholder="รายละเอียดการประเมิน" required>
                    </td>


                      <td Width="10%">
                      <div align="center">
                      <input type="text" name="form_conduct_score" class="form-control" id="form_conduct_score" value="<?php echo $form_conduct_score;?>" placeholder="0,0.1" required>
                      </div></td>


                      <td Width="10%"><div align="center">
                      <input type="text" name="form_conduct_note" class="form-control" id="form_conduct_note" value="<?php echo $form_conduct_note;?>" placeholder="หมายเหตุ" required>
                      </div></td>







                      <td Width="10%">
                      <div align="center">
                        <select name="form_conduct_status" id="form_conduct_status" class="form-control" required>					
                        <option value=""> เลือกสถานะ </option>  
                        <option value="1" <?php if (!(strcmp("1", $form_conduct_status))) {echo "selected=\"selected\"";} ?>>   เปิดใช้งาน </option>
                        <option value="0" <?php if (!(strcmp("0", $form_conduct_status))) {echo "selected=\"selected\"";} ?> >  ปิดใช้งาน </option>  
                        </select>
                      </div>
                      </td>



                      <td Width="10%"><div align="center">
                        <select name="AFTER" id="AFTER" class="form-control">					
						            <option value=""> เลือกหลัง Field  </option>  
                        <?php 
                        include "config.inc.php"; 
                        $sql_AFTER = "SELECT * FROM tbl_form_conduct ORDER BY tbl_form_conduct.form_conduct_id ASC";
                        $query_AFTER = $conn->query($sql_AFTER); 
                        while($row_AFTER = $query_AFTER->fetch_assoc()) {
                        ?>
					            	<option value="<?php echo $row_AFTER['form_conduct_field'];?>"><?php echo $row_AFTER['form_conduct_field'];?></option>
                        <?php }?>
						            </select>
                      </div></td>




                     



                      <td Width="10%"><div align="center">
                        <?php   if(isset($_GET['edit']))  {?>                        
                        <input type="submit" name="Submit"  class="btn btn-info" value="Edit" />
                        <a href="_conduct.php" class="btn btn-danger">Cancel</a>
                        <?php }else{?>
                        <input type="submit" name="Submit"  class="btn btn-info" value="Add" />
                        <?php }?>
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
              <h3 class="card-title"> Conduct (default = 0)</h3>

              <h4 class="card-title">
              นักศึกษาได้คะแนนตั้งต้น 10 คะแนน 
              หากมีการการทำผิดจะหักคะแนนโดยการทาเครื่องหมายลงในช่องที่มีเครื่องหมายลบ (-) 
              ในช่องนั้น หากนักศึกษาไม่กระทำการใด ๆ ที่ผิดก็ให้ทาเครื่องหมายลงในช่องที่มีเลขศูนย์ (0) 
              ในทุกคาบที่นักศึกษาปฏิบัติงาน นักศึกษาจะต้องได้รับการประเมินเจตคติ
             </h4>




            </div>
            <!-- /.card-header -->
            <div class="card-body">




            <script type="text/javascript" language="javascript">

                      function checkall(st){


                              if(st=='1'){
                              /* <?php  for ($x = 1; $x <= 10; $x++) { ?>*/
                                document.getElementById('step<?php echo $x;?>_1').checked=true;
                              /* <?php }?>*/
                              }


                              if(st=='0'){
                              /* <?php  for ($x = 1; $x <= 10; $x++) { ?>*/
                                document.getElementById('step<?php echo $x;?>_0').checked=true;
                              /* <?php }?>*/
                              }

                      }

             </script>




            





          <table id="example1" class="table table-bordered table-striped">

                  <thead>
                        <tr>
                          <th Width="5%"><div align="center">ลำดับ</div></th>
                          <th Width="30%">รายละเอียดการประเมิน</th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall('1')">( - )</a></div></th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall('0')">( 0 )</a></div></th>
                          <th Width="10%"><div align="center">จัดการข้อมูล</div></th>
                        </tr>
                  </thead>


                   <tbody>


                  <?php 
                  include "config.inc.php"; 
                  $sql_conduct = "SELECT * FROM tbl_form_conduct ORDER BY tbl_form_conduct.form_conduct_order ASC";
                  $query_conduct = $conn->query($sql_conduct); 
                  $i=0;
                  while($row_conduct = $query_conduct->fetch_assoc()) {
                  $i++;

                  $step_detail = explode(",", $row_conduct['form_conduct_detail']); // แยก   
                 


                  ?>
         
                        <tr>

                          <td><div align="center"><?php echo $i;?>  (<?php echo $row_conduct['form_conduct_order'];?>)</div></td>
                          <td><?php echo $row_conduct['form_conduct_name'];?> (<?php echo $row_conduct['form_conduct_field'];?>) </td>
                          
        
                        <td>
                            <input type="radio" name="<?php echo $row_conduct['form_conduct_field'];?>" id="<?php echo $row_conduct['form_conduct_field']."_1";?>"  class="form-control" checked value="3">            
                        </td>


                        <td>
                            <input type="radio" name="<?php echo $row_conduct['form_conduct_field'];?>" id="<?php echo $row_conduct['form_conduct_field']."_0";?>"  class="form-control" checked value="0">
                        </td>


                        
                        
                      

                      
                          <td><div align="center">
                          <?php if($row_form_main['form_main_confirm']==1){  }else{?>
                          <a href="?form_conduct_id=<?php echo $row_conduct['form_conduct_id'];?>&del=<?php echo $row_conduct['form_conduct_id'];?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">ลบ</a>
                          <a href="?form_conduct_id=<?php echo $row_conduct['form_conduct_id'];?>&edit=<?php echo $row_conduct['form_conduct_id'];?>" class="btn btn-info">แก้ไข</a>
                          <?php }?>
                          </div></td>
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
 



  <!-- Content Wrapper. Contains page content -->
</div >




<?php  include 'footer.php';?>




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
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<!-- page script Tooltip -->



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



