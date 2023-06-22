






 <div class="card card-info">
    <div class="card-header ">
      <h3 class="card-title"> Conduct (default = 0)</h3>
              
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
      </div>



            <div class="card-body">




            <script type="text/javascript" language="javascript">

                      function checkall_conduct(st_conduct){


                              if(st_conduct=='1'){
                              /* <?php  for ($x = 1; $x <= 10; $x++) { ?>*/
                                document.getElementById('step<?php echo $x;?>_11').checked=true;
                              /* <?php }?>*/
                              }


                              if(st_conduct=='0'){
                              /* <?php  for ($x = 1; $x <= 10; $x++) { ?>*/
                                document.getElementById('step<?php echo $x;?>_00').checked=true;
                              /* <?php }?>*/
                              }

                      }

             </script>



                  <?php

                  include "config.inc.php"; 

                 



                  if(!empty($nohn)){  
                      $sql_conduct_cherk = "SELECT * FROM tbl_conduct where student_id = '$student_id' and conduct_date = '$arrange_date'";
                    }else{
                      $sql_conduct_cherk = "SELECT * FROM tbl_conduct where detail_id = '$detail_id' and conduct_date = '$arrange_date'";
                    } 


                  $query_conduct_cherk = $conn->query($sql_conduct_cherk); 
                  if($row_conduct_cherk = $query_conduct_cherk->fetch_assoc()){
                    
                    $conduct_id = $row_conduct_cherk['conduct_id'];

                  }else{
                   
                    $conduct_id = "";

                  }
                  ?>
            


            <input type="hidden" name="conduct_id" value="<?php echo $conduct_id;?>">


          <table id="example1" class="table table-bordered table-striped">

                  <thead>
                        <tr>
                          <th Width="5%"><div align="center">ลำดับ</div></th>
                          <th Width="30%">รายละเอียดการประเมิน</th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall_conduct('1')">( - )</a></div></th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall_conduct('0')">( 0 )</a></div></th>
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

                  
                  $form_conduct_field = $row_conduct['form_conduct_field'];

                      $conduct_s = $row_conduct_cherk["{$form_conduct_field}"]; // สร้าง ฟิวคะแนนออกมา

                      if(!empty($conduct_s)){ // เช็คมี ค่าหรือไม่
                        $con_conduct = $conduct_s;
                      }else{
                        $con_conduct = 0;
                      }



                  ?>
         
                        <tr>

                          <td><div align="center"><?php echo $i;?>  (<?php echo $row_conduct['form_conduct_order'];?>)</div></td>
                          <td><?php echo $row_conduct['form_conduct_name'];?> (<?php echo $row_conduct['form_conduct_field'];?>) </td>

                        <td>
                            <input type="radio" name="con<?php echo $row_conduct['form_conduct_field'];?>" id="<?php echo $row_conduct['form_conduct_field']."_11";?>"  class="form-control" <?php if($con_conduct == 1){ echo "checked ";}else{  }?> value="1">            
                        </td>

                        <td>
                            <input type="radio" name="con<?php echo $row_conduct['form_conduct_field'];?>" id="<?php echo $row_conduct['form_conduct_field']."_00";?>"  class="form-control" <?php if($con_conduct == 0){ echo "checked ";}else{  }?> value="0">
                        </td>


                      
                        </tr>
                      
                    
                  
               
                  
                    <?php } ?>


                </tbody>
          
              </table>

                  <!-- /.card-body -->
       
              นักศึกษาได้คะแนนตั้งต้น 10 คะแนน 
              หากมีการการทำผิดจะหักคะแนนโดยการทาเครื่องหมายลงในช่องที่มีเครื่องหมายลบ (-) 
              ในช่องนั้น หากนักศึกษาไม่กระทำการใด ๆ ที่ผิดก็ให้ทาเครื่องหมายลงในช่องที่มีเลขศูนย์ (0) 
              ในทุกคาบที่นักศึกษาปฏิบัติงาน นักศึกษาจะต้องได้รับการประเมินเจตคติ
             
            </div>
        

          </div>
          <!-- /.card -->

        







<!-- page script Tooltip -->
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>







