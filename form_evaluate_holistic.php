

 <div class="card card-info">
    <div class="card-header ">
             <h3 class="card-title"> Holistic approach and professionalism (10%)  (default = N/A)</h3>
             
			    <div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
						<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
		</div>


  
            <!-- /.card-header -->
            <div class="card-body">




            <script type="text/javascript" language="javascript">

                      function checkall(st){

                              if(st=='3'){
                              /* <?php  for ($x = 1; $x <= 10; $x++) { ?>*/
                                document.getElementById('step<?php echo $x;?>_3').checked=true;
                              /* <?php }?>*/
                              }


                              if(st=='2'){
                              /* <?php  for ($x = 1; $x <= 10; $x++) { ?>*/
                                document.getElementById('step<?php echo $x;?>_2').checked=true;
                              /* <?php }?>*/
                              }



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



                  <?php

                  include "config.inc.php"; 

                  if(!empty($nohn)){  

                    //echo $arrange_nohn_time_type;
               
                    $holistic_time_type = $arrange_nohn_time_type;

                     $sql_holistic_cherk = "SELECT * FROM tbl_holistic where student_id = '$student_id' and holistic_date = '$arrange_date' and holistic_time_type = '$holistic_time_type' and type_work_id = '$type_work_id'";

                    }else{

                      //echo $arrange_time_type;

                      $holistic_time_type = $arrange_time_type;

                     $sql_holistic_cherk = "SELECT * FROM tbl_holistic where student_id = '$student_id' and holistic_date = '$arrange_date' and holistic_time_type = '$holistic_time_type' and type_work_id = '$type_work_id'";
                    } 

 
              

                  $query_holistic_cherk = $conn->query($sql_holistic_cherk); 
                  if($row_holistic_cherk = $query_holistic_cherk->fetch_assoc()){
                    
                    $holistic_id = $row_holistic_cherk['holistic_id'];

                  }else{
                   
                    $holistic_id = "";

                  }
                  ?>




          <input type="hidden" name="holistic_id" value="<?php echo $holistic_id;?>">
          <input type="hidden" name="type_work_id" value="<?php echo $type_work_id;?>">

          <table id="example1" class="table table-bordered table-striped">

                  <thead>
                        <tr>
                          <th Width="5%"><div align="center">ลำดับ</div></th>
                          <th Width="10%">Domain </th>
                          <th Width="30%">Stressing points</th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall('3')">Good<br>(2)</a></div></th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall('2')">Average<br>(1)</a></div></th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall('1')">Weak<br>(0)</a></div></th>
                          <th Width="4%"><div align="center"><a href="javascript:checkall('0')">N/A<br>(Missing)</a></div></th>
                          <th Width="15%"><div align="center">หมายเหตุ</div></th>
                          
                        </tr>
                  </thead>


                   <tbody>


                  <?php 
                  $sql_holistic = "SELECT * FROM tbl_form_holistic ORDER BY tbl_form_holistic.form_holistic_order ASC";
                  $query_holistic = $conn->query($sql_holistic); 
                  $i=0;
                  while($row_holistic = $query_holistic->fetch_assoc()) {
                  $i++;
                  $step_detail = explode(",", $row_holistic['form_holistic_detail']); // แยก   

                  
                  $form_holistic_field = $row_holistic['form_holistic_field'];

                    $ho_holistic_s = $row_holistic_cherk["{$form_holistic_field}"]; // สร้าง ฟิวคะแนนออกมา

                      if(isset($ho_holistic_s)){ // เช็คมี ค่าหรือไม่
                        $ho_holistic = $ho_holistic_s;
                      }else{
                        $ho_holistic = 'missing';
                      }

                      $holistic_field_note = $form_holistic_field."_note";
                      $holistic_field_note_s = $row_holistic_cherk["{$holistic_field_note}"]; // สร้าง ฟิว note

                      if(isset($holistic_field_note_s)){ // เช็คมี ค่าหรือไม่
                        $holistic_note = $holistic_field_note_s;
                      }else{
                        $holistic_note = "";
                      }



                  ?>
         
                        <tr>
                          <td><div align="center"><?php echo $i;?>  (<?php echo $row_holistic['form_holistic_order'];?>)</div></td>
                          <td><?php echo $row_holistic['form_holistic_group'];?></td>
                          <td><?php echo $row_holistic['form_holistic_name'];?></td>
                          
        
                        <td>
                         <a href="#" data-toggle="tooltip" title="<?php  echo $step_detail[0];?>"> 
                        <input type="radio" name="ho<?php echo $form_holistic_field;?>" id="<?php echo $row_holistic['form_holistic_field']."_3";?>"  class="form-control"  <?php if($ho_holistic == '2'){ echo "checked ";}else{  }?> value="2">            
                        </a>
                        </td>

                        <td>
                        <a href="#" data-toggle="tooltip" title="<?php  echo $step_detail[1];?>"> 
                          <input type="radio" name="ho<?php echo $form_holistic_field;?>" id="<?php echo $row_holistic['form_holistic_field']."_2";?>"  class="form-control" <?php if($ho_holistic == '1'){ echo "checked ";}else{  }?> value="1">
                        </a>
                        </td>

                        <td>
                        <a href="#" data-toggle="tooltip" title="<?php  echo $step_detail[2];?>"> 
                          <input type="radio" name="ho<?php echo $form_holistic_field;?>" id="<?php echo $row_holistic['form_holistic_field']."_1";?>"  class="form-control" <?php if($ho_holistic == 0){ echo "checked ";}else{  }?> value="0">
                        </a>
                        
                        </td>

                        <td>
                        <a href="#" data-toggle="tooltip" title="<?php  echo $step_detail[3];?>"> 
                          <input type="radio" name="ho<?php echo $form_holistic_field;?>" id="<?php echo $row_holistic['form_holistic_field']."_0";?>"  class="form-control" <?php if($ho_holistic == 'missing'){ echo "checked";}else{  }?> value="missing">
                        </a>
                        </td>

                        <td>
                        <textarea name=" <?php echo $form_holistic_field."_note";?>"  class="form-control"><?php echo $holistic_note;?></textarea>
                       
                        </td>
                        
          
                        </tr>
                      
                    
                  
               
                  
                    <?php } ?>


                </tbody>
          
              </table>
              </div>
           
            
            <!-- /.card-body -->
          </div>
          <!-- /.card -->







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



