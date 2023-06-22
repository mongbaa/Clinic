<meta charset="utf-8">
<?php			
   include "config.inc.php"; //ติดต่อฐานข้อมูล

      $type_work_id = $row_arrange_detail['type_work_id'];


      // ดึงฟอร์มอื่นๆ ที่เกี่ยวข้อง		   
      $sql_form_more   =  " SELECT fm.*  , tw.* ";
      $sql_form_more  .=  " FROM (SELECT f.*   FROM tbl_form_more AS f WHERE f.form_more_status = 'Y' and f.type_work_id = '$type_work_id') AS fm ";
      $sql_form_more  .=  " INNER JOIN  tbl_type_work   AS tw  ON  tw.type_work_id = fm.type_work_id ";
      $query_form_more = $conn->query($sql_form_more); 
      $num = mysqli_num_rows($query_form_more);
      $row_form_more = $query_form_more->fetch_assoc();
      
     // echo "<br>";

      if($num > 0){


    // ดึงข้อมุลการประเมิน
     $tbl_more=$row_form_more['form_more_table'];
     $form_more_id=$row_form_more['form_more_id'];
     

       $tbl_id_more = $tbl_more."_id";
   

      echo  $sql_tbl_more = "SELECT * FROM tbl_".$tbl_more." where detail_id = $detail_id ";
		 $query_tbl_more = $conn->query($sql_tbl_more); 
		 if($row_tbl_more = $query_tbl_more->fetch_assoc()){


            $field_id_more = $row_tbl_more["$tbl_id_more"];


         }else{

            $field_id_more = "";



         }




    ?>



<input type="hidden" name="detail_id" value="<?php echo $detail_id;?>"> <?php // echo $detail_id;?>
<input type="hidden" name="form_more_id" value="<?php echo $form_more_id;?>"> <?php // echo $form_more_id;?>
<input type="hidden" name="field_id_more" value="<?php echo $field_id_more;?>"> <?php // echo $form_more_id;?>
<?php  //echo $field_id_more;?>

<div class="card">
	  
	    <div class="card-header">
          <h3 class="card-title"><?php echo $row_form_more['form_more_name'];?></h3>
			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fas fa-times"></i></button>
			  </div>
        </div>


        <div class="card-body">
		<div class="row">	
            <?php 
            $form_more_id=$row_form_more['form_more_id'];
            $sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
            $query_form_detail_more = $conn->query($sql_form_detail_more); 
            while($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {
            
            $form_detail_more_topic = $row_form_detail_more['form_detail_more_topic'];
            $form_detail_more_field = $row_form_detail_more['form_detail_more_field'];
            $field_more =   $tbl_more."_".$row_form_detail_more['form_detail_more_field'];

            $row_field = $row_tbl_more["$field_more"];
            
            if(!empty($row_field)){
                $array_row_field = json_decode($row_field);
            }else{

                $jsond = '[]';

                $array_row_field =  json_decode($jsond);
            }
            
           
            ?>
            
                                 
           

            


                <div class="col-md-12  col-12">
					
                    <div class="info-box">

                        <div class="col-sm-3">
                        <?php echo $row_form_detail_more['form_detail_more_topic'];?>
                        </div>
                            
                        <div class="col-sm-9">
                        <?php //echo $row_form_detail_more['form_detail_more_format'];?> 
                        <?php //echo $tbl_more."_".$form_detail_more_field;?>


                        <?php if($row_form_detail_more['form_detail_more_format']=="L"){ ?>                       
                        <select name="<?php echo $tbl_more."_".$form_detail_more_field;?>[]" class="select2"  style="width: 100%;">
                            <option value="">-- เลือก --</option>
                            <?php 
                            $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                            $step2 = count($step1);
                            for( $ct= 0 ; $ct <= $step2 ; $ct++ ){
                            $step = $step1[$ct];
                             if($step!=""){ 	
                            ?>
                            <option value="<?php echo $step;?>" <?php if (in_array($step, $array_row_field)) {  echo "selected=\"selected\""; } ?>  ><?php echo $step;?> </option> 
                            <?php
                                         }
                            }
                            ?> 
                        </select>	
                        <?php }?>
 



                        <?php if($row_form_detail_more['form_detail_more_format']=="M"){ ?>
                        <div class="row">
                                <?php 
                                $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                $step2 = count($step1);
                                for( $ct= 0 ; $ct <= $step2 ; $ct++ ){
                                $step = @$step1[$ct];
                                if($step!=""){ 	
                                ?>
                        
                                <div class="col-sm-3">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">
                                    <div class="icheck-success d-inline">
                                    <input type="checkbox" name="<?php echo $tbl_more."_".$form_detail_more_field;?>[]" id="<?php echo $tbl_more."_".$form_detail_more_field;?><?php echo $step;?>"  
                                    <?php if (in_array($step, $array_row_field)) {  echo "checked"; } ?>   
                                    value="<?php echo $step;?>">
                                    <label for="<?php echo $tbl_more."_".$form_detail_more_field;?><?php echo $step;?>">
                                    <?php echo $step;?>
                                    </label>
                                    </div>
                                    </div>
                                </div>

                                <?php
                                    }
                                    }
                                 ?> 
                        </div>
                        <?php }?>








                        <?php if($row_form_detail_more['form_detail_more_format']=="ML"){ ?>
                                <select name ="<?php echo $tbl_more."_".$form_detail_more_field;?>[]" id="" class="select2" multiple="multiple" data-placeholder=" <?php echo $form_detail_more_topic ?> " data-dropdown-css-class="select2-purple" style="width: 100%;">
                                   <?php 
                                            $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                            $step2 = count($step1);
                                            for( $ct= 0 ; $ct <= $step2 ; $ct++ ){
                                            $step = $step1[$ct];
                                            if($step!=""){ 	
                                    ?>
                                    <option value="<?php echo $step;?>"  <?php if (in_array($step, $array_row_field)) {  echo "selected=\"selected\""; } ?>  ><?php echo $step;?> </option> 
                                    <?php
                                    }
                                    }
                                    ?> 
                                </select>	   
                        <?php }?>



                      


                        <?php if($row_form_detail_more['form_detail_more_format']=="N"){ ?>

                            

				        <div class="row"> 
                                <?php 
                                $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                $step2 = count($step1);
                                for( $ct= 0 ; $ct <= $step2 ; $ct++ ){
                                $step = @$step1[$ct];
                                    if($step!=""){ 	
                                ?>
                                <div class="col-sm-3">
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                <input type="radio" name="<?php echo $tbl_more."_".$form_detail_more_field;?>" id="<?php echo $tbl_more."_".$form_detail_more_field;?><?php echo $step;?>" 
                               
                                <?php //if ("$step" == $array_row_field) {  echo "checked"; } ?>  
                                
                                <?php if (in_array("$step", $array_row_field)) {  echo "checked"; } ?>
                                
                                value="<?php echo $step;?>">
                                
                                <label for="<?php echo $tbl_more."_".$form_detail_more_field;?><?php echo $step;?>">
                                <?php echo $step;?>
                                </label>
                                </div>
                                </div>
                                </div>

                                <?php
                                                }
                                }
                                ?> 
                        </div>
                        <?php }?>



                        <?php if ($row_form_detail_more['form_detail_more_format'] == "CHK") { ?>
                                        <div class="row">
                                            <?php
                                            $step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
                                            $step2 = count($step1);
                                            for ($ct = 0; $ct <= $step2; $ct++) {
                                                $step = @$step1[$ct];
                                                if ($step != "") {
                                            ?>
                                                    <div class="col-sm-3">
                                                        <!-- checkbox -->
                                                        <div class="form-group clearfix">
                                                            <div class="icheck-primary d-inline">

                                                    <input type="checkbox" name="<?php echo $tbl_more."_".$form_detail_more_field;?>[]" id="<?php echo $tbl_more."_".$form_detail_more_field;?><?php echo $step;?>" 
                                                    <?php //if ("$step" == $array_row_field) {  echo "checked"; } ?>  <?php if (in_array("$step", $array_row_field)) {  echo "checked"; } ?>    value="<?php echo $step;?>">
                                                    <label for="<?php echo $tbl_more."_".$form_detail_more_field;?><?php echo $step;?>">
                                                    <?php echo $step;?>
                                                    </label>

                                                   
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php } ?>
                 
                    

                            <?php if($row_form_detail_more['form_detail_more_format']=="T"){ 
                                //echo $row_tbl_more["$field_more"];
                                $field_more = $array_row_field[0];
                            ?>

                                <input type="text" name="<?php echo $tbl_more."_".$form_detail_more_field;?>[]" value="<?php echo $field_more; ?>"  class="form-control">
                            
                            
                            <?php }?>
                            
						

                            <?php if($row_form_detail_more['form_detail_more_format']=="D"){ 
                                 $field_more = $array_row_field[0];
                            ?>
                                <textarea name="<?php echo $tbl_more."_".$form_detail_more_field;?>"  class="form-control"> <?php echo $field_more;?> </textarea>
                            <?php } ?>


                        </div>




                        

                    </div>

                </div>







            <?php } ?>         
		
		


        <!-- /.row -->
        </div>
        </div>
 
</div> <!-- card --> <!-- ฟอร์มเกี่ยวข้อง card -->









<?php 

       }else{ 

       


       }
		


?>