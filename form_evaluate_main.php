<?php			
   include "config.inc.php"; //ติดต่อฐานข้อมูล


   //  ดึงฟอร์มหลัก			   
   $sql_form_main   =  " SELECT fm.*  , tw.* ";
   $sql_form_main  .=  " FROM (SELECT f.*   FROM tbl_form_main AS f WHERE f.form_main_id = '$form_main_id') AS fm ";
   $sql_form_main  .=  " INNER JOIN  tbl_type_work   AS tw  ON  tw.type_work_id = fm.type_work_id ";
   $query_form_main = $conn->query($sql_form_main); 
   $row_form_main = $query_form_main->fetch_assoc();
	
   
    //echo "รูปแบบการประเมิน : "; 
    $form_main_format = $row_form_main['form_main_format'];	// รูปแบบการประเมิน	 รูปแบบการบันทึกข้อมูล 2 เป็นการดึงข้อมูล เดิมมาประเมินต่อ 1 จะเป้นการบันทึกข้อมูลใหม่	
    //echo "<br>";						   

	//เช็คหากมีการประเมินแล้วให้แสดงคะแนนเดิม	 ดึงชื่อตารางของฟอร์ม
	$tbl=$row_form_main['form_main_table'];

	$tbl_id = $tbl."_id"; // Id สร้าง id มาเช็คการประเมินก่อนหน้า 



	if($form_main_format == 1){ //1 จะเป็นการบันทึกข้อมูลใหม่	

		if(!empty($nohn)){  //ไม่มีผู้ป่วย

			    $detail_id = $arrange_nohn_id;
				$sql_check_d = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and student_id = $student_id and last_date = '$arrange_date' ";
				
		}else{  //มีผู้ป่วย

			if($arrange_type==1){  // LAB
				$arrange_time_type = "LAB";
			}else{
				$arrange_time_type = $arrange_time_type;
			}

					//$type_work_id_chk = $row_form_main['type_work_id']; //รหัสสาขา  
					//เช็คสาขา UPDATE
					//if($type_work_id_chk == 1 || $type_work_id_chk == 4 || $type_work_id_chk == 7 || $type_work_id_chk == 9 || $type_work_id_chk == 10 || $type_work_id_chk == 11 ){
						 
						$sql_check_d = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and last_date = '$arrange_date' and last_time =  '$arrange_time_type' ";

					//}else{

					//	$sql_check_d = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and last_date = '$arrange_date' ";
					//}

			
				//$sql_check_d = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and last_date = '2002-20-22' ";
		} 

		
		 $query_check_d = $conn->query($sql_check_d); 
		 $row_check_d = $query_check_d->fetch_assoc();
		 $tbl_id = $tbl."_id"; 
		 $field_id = $row_check_d["$tbl_id"];  // ID
		 $field_idss = $row_check_d["$tbl_id"]; // ID


	}else{


		
		if(!empty($nohn)){  

			 $detail_id = $arrange_nohn_id;
			 $sql_check_d = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and student_id = $student_id";
			 
		}else{
			 $sql_check_d = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id ";
		} 
		
		 $query_check_d = $conn->query($sql_check_d); 
		 $row_check_d = $query_check_d->fetch_assoc();
		 $tbl_id = $tbl."_id";
		 $field_id = $row_check_d["$tbl_id"]; // ID
		 $field_idss = $row_check_d["$tbl_id"]; // ID

	}

//echo "<br>";











//เงื่อนไข ถ้าหาก มีการ่สงค่า  id_form ให้ ดึงข้อมูลจาก ค่าที่ส่ง แต่ถ้าไม่มีให้ ดึงจากค่า จาก id_form ที่ น.ศ.ส่งมา

if(!empty($_GET['id_form'])){  $id_form = $_GET['id_form'];  }else{  $id_form = $field_id;  }

if(!empty($_GET['id_form'])){  $id_formss = $_GET['id_form'];  }else{  $id_formss = $field_id;  }



$sql_check_main = "SELECT * FROM tbl_".$tbl." where $tbl_id = '$id_form' ";
$query_check_main = $conn->query($sql_check_main); 

		if($row_check_main = $query_check_main->fetch_assoc()){  // หากได้รับการประเมินคะแนนมาแล้ว
			
			$check= "Y";
			$field_id = $row_check_main["$tbl_id"];

			$tbl_comment = $tbl."_comment";
			$field_comment = $row_check_main["$tbl_comment"];


		}else{ // หากไม่มีข้อมูล

			 $check = "N";
			 $field_id = "";
			 $field_comment = "";

		}		

?>





<input type="hidden" name="plan_id" value="<?php echo $plan_id;?>">
<input type="hidden" name="form_main_id" value="<?php echo $form_main_id;?>">	
<input type="hidden" name="type_work_id" value="<?php echo $type_work_id;?>">	
<input type="hidden" name="last_date" value="<?php echo $arrange_date;?>">	
<input type="hidden" name="detail_id" value="<?php echo $detail_id;?>"> <?php // echo $detail_id;?>
<input type="hidden" name="field_id" value="<?php echo $field_id;?>"> <?php // echo $field_id;?>
<input type="hidden" name="arrange_id" value="<?php echo $arrange_id;?>"> <?php // echo $arrange_id;?>
<input type="hidden" name="id_form" value="<?php echo $id_form;?>"> <?php // echo $arrange_id;?>
<input type="hidden" name="arrange_type" value="<?php echo $arrange_type;?>"> <?php // echo $arrange_id;?>



<!-- ฟอร์มเกี่ยวข้อง card -->
<!-- ส่วนแสดงแบบฟอร์มหลักการประเมิน  -//////////////////////////////////////--->	
<div class="card">
	  
		<div class="card-header">
				<h3 class="card-title">
					รายการฟอร์มประเมินคะแนน สาขา : <?php echo $row_form_main['type_work_name'];?>
					ชื่อฟอร์ม : <?php echo $row_form_main['form_main_name'];?>
		        </h3> 
			    <div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
						<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>

					<?php if(isset($_GET['show_step'])){  // กด show step ?>  
						<a href="?detail_id=<?php echo $detail_id;?>&plan_id=<?php echo $plan_id;?>&arrange_date=<?php echo $arrange_date;?>&arrange_id=<?php echo $arrange_id;?>&id_form=<?php echo $id_form;?>" class="btn btn-info"> Hide </a>				
					<?php }else{ ?>
						<a href="?show_step=1&detail_id=<?php echo $detail_id;?>&plan_id=<?php echo $plan_id;?>&arrange_date=<?php echo $arrange_date;?>&arrange_id=<?php echo $arrange_id;?>&id_form=<?php echo $id_form;?>" class="btn btn-info"> Show </a>				

					<?php } ?>
				</div>
		</div>




		

<div class="card-body">
<div class="row">
<div class="col-md-12 col-sm-6 col-12">
	
	
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
					<th Width="5%"><div align="center">ลำดับ</div></th>
					<th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>

					<?php 
					include "config.inc.php"; 
					$sql_check_w = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id  and weight_type_id!=1";
					$query_check_w = $conn->query($sql_check_w); 
					if($row_check_w = $query_check_w->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  น้ำหนัก,ครั้ง,คะแนน ให้แสดง
					?>



					<th Width="5%"><div align="center">
					<?php if($type_work_id==4){?> ครั้ง <?php }else{ ?>  น้ำหนัก <?php }?>
				    </div></th>


					<?php }?>

			

					<th Width="8%"><div align="center">คะแนน</div></th>


					<?php 
					include "config.inc.php"; 
					$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
					$query_check_ex = $conn->query($sql_check_ex); 
					if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
					?>
					<th Width="5%"><div align="center">Competency</div></th>       
					<?php }?> 




					<?php 
					include "config.inc.php"; 
					$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
					$query_check_ex = $conn->query($sql_check_ex); 
					if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Complete ให้แสดง
					?>
					<th Width="5%"><div align="center">Complete</div></th>      
					<?php }?> 



					<th width="10%"><div align="center">ผู้ประเมิน  </div></th>
					<th width="5%"><div align="center">วันที่   </div></th>
                 
                </tr>
                </thead>



				
				

<tbody>
<?php 
//echo $arrange_teacher_id;
include "config.inc.php"; 
$sql_form_detail = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id ";
if(isset($_GET['show_step'])){ }else{  // กด show step 
$sql_form_detail.=" and tbl_form_detail.form_detail_extra!='Y' ";
}


$sql_form_detail.=" ORDER BY form_detail_order ASC ";
$query_form_detail = $conn->query($sql_form_detail); 
$i=0;
while($row_form_detail = $query_form_detail->fetch_assoc()) {
$i++;
   $field=$tbl."_".$row_form_detail['form_detail_field'];
   $form_detail_id =$row_form_detail['form_detail_id'];
    

				if($check== "Y"){  // หากมีข้อมูล

						
								 if($row_form_detail['weight_type_id']!=1){  // weight

								 $field_weights = $field."_weight"; 

								 $weight = $row_check_main["$field_weights"];

								 }else{  $weight = ""; }
					
								 $field_grade = $field."_grade"; 
								 $grade = $row_check_main["$field_grade"];

								 $field_teacher = $field."_teacher"; 
								 $teacher = $row_check_main["$field_teacher"];  // ดึงข้อมูลอาจารย์มาแสดง
								 

								 $field_date = $field."_date"; 
								 $datee = $row_check_main["$field_date"]; // ดึงข้อมูลอาจารย์มาแสดง
								 $date =  $arrange_date;
					
									  
						}else{ // หากไม่มีข้อมูล

							    $teacher = "";
								$weight = "";
								$grade = "";
								$date =  $arrange_date;
								$datee = "";

						}	  
				
	                  //  if($datee == $arrange_date){  $disabled = ""; }else{  $disabled = "readonly"; } // วันที่ที่บันทึกต้องตรงกัน กับค่าวันที่ ที่ส่งมาถึงจะให้แก้ไข

			 ?>

                <tr>

				<td>

				

				<?php 
				
				
				if($teacher != 0){ ?> 

				<a href="form_evaluate_cancel.php
				?field_id=<?php echo $field_id;?>
				&detail_id=<?php echo $detail_id;?>
				&form_main_id=<?php echo $form_main_id;?>
				&form_detail_id=<?php echo $form_detail_id;?>
				&plan_id=<?php echo $plan_id;?>
				&arrange_date=<?php echo $arrange_date;?>
				&arrange_id=<?php echo $arrange_id;?>
				&field_teacher=<?php echo $teacher;?>
				&field_weight=<?php echo $weight;?>
				&field_grade=<?php echo $grade;?>
				&field_date=<?php echo $date;?>
				&cancel_user=<?php echo $arrange_teacher_id;?>
				&type_work_id=<?php echo $type_work_id;?> 
				"
			    class="btn btn-danger btn-xs" onClick="return confirm('กรุณายืนยันการยกเลิกคะแนนอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> </a>

			    <?php }?>


				<?php echo $i;?>  <?php echo $row_form_detail['form_detail_extra'];?>
				
				

				</td>




					<td><?php echo $row_form_detail['form_detail_topic'];?>   </td>
					




					<?php if($row_form_detail['weight_type_id'] == 1){ ?>
					<td>
						<input type="hidden" name="<?php echo $field."_weight";?>" value="">		
					</td>
					<?php }?>





					<?php if($row_form_detail['weight_type_id']==2){ ?>
					<td>
								    <div align="center"><?php echo $row_form_detail['form_detail_weight'];?></div>
									<?php if(isset($weight) && !empty($weight) ){  // หาก weight มีค่า ให้  value มี ค่า weight ?> 

										<input type="hidden" name="<?php echo $field."_weight";?>" value="<?php echo $weight;?>">
										<?php //echo $field."_weight";?>

									<?php }else{ // หาก weight ไม่มีค่า ให้  value มี ค่า form_detail_weight ของตัวมันเอง ?>

										<?php //echo $field."_weight";?>
										<input type="hidden" name="<?php echo $field."_weight";?>" value="<?php echo $row_form_detail['form_detail_weight'];?>">
									<?php }?>
					</td>
					<?php }?>



				
					



					
					<?php if($row_form_detail['weight_type_id']==3){ ?>
						
					<td>
					    <?php //echo $row_form_detail['form_detail_field']."_weight";?>
						<select name="<?php echo $field."_weight";?>" class="form-control">
						<?php 
						$step1 = explode(",", $row_form_detail['form_detail_weight']); // แยก   
						$step2 = count($step1);
						for( $ct= 0 ; $ct <= $step2 ; $ct++ ){
						$step = $step1[$ct];
								if($step!=""){ 						   
						?> 
						<option value="<?php echo $step;?>" <?php if($step ==$weight){ echo "selected"; } ?> ><?php echo $step;?></option>
						<?php
							} //if
						} //for
						?>
						</select>
					</td>
					<?php }?>
 




		



				  

				<?php  if(!empty($teacher)){   
							
							if($teacher != $arrange_teacher_id){ 
								$disabled = "disabled"; 

								//$disabled = ""; 
								
							}else{ 

								$disabled = ""; 

							}

						}else{ 

							$disabled = ""; 
						}
				
				
				?> 


                <td><div align="center">
		
				    <?php // การเลือกคะแนน ?> 
                    <?php  $row_form_detail['score_type_id'];?> 


                    <?php   $score_id = $row_form_detail['score_id'];?>	
					
						
                    <?php if($row_form_detail['score_type_id']==1){ // รูปแบบการเลือกเกรด ?>



                      <select name="<?php echo $field."_grade";?>" class="form-control" <?php echo $disabled;?> >
                        <option value="">-- N/A --</option>
						<?php
                        include"config.inc.php";
						$sql_score_d = "select  *  from tbl_score_detail where score_id = $score_id"; 
                        $query_score_d = $conn->query($sql_score_d); 
                        while($result_score_d = $query_score_d->fetch_assoc()) {
						?>
                        <option value="<?php echo $result_score_d['score_detail_rate'];?>"  
						<?php 
						$str = $grade;
						$score = $result_score_d['score_detail_rate'];

						if ($str == $score) { echo "selected"; }

						//if (strpos($str, $score) === 0 ) { echo 'selected';} 
						?>
						>
						<?php echo $result_score_d['score_detail_name'];?>
						</option> 
                        <?php }?>
                      </select>






                    <?php }?>





					<?php if($row_form_detail['score_type_id']==4){?>
                      <select name="<?php echo $field."_grade";?>" class="form-control" <?php echo $disabled;?> >
                        <option value="">-- N/A --</option>
						<?php
                        include"config.inc.php";
						$sql_score_d = "select  *  from tbl_score_detail where score_id=$score_id";
                        $query_score_d = $conn->query($sql_score_d); 
                        while($result_score_d = $query_score_d->fetch_assoc()) {
						?>
                        <option value="<?php echo $result_score_d['score_detail_rate'];?>"  
						<?php 
						$str = $grade;
						$score = $result_score_d['score_detail_rate'];

						if ($str == $score) { echo "selected"; }

						//if (strpos($str, $score) === 0 ) { echo 'selected';} 
						?>
						>
						<?php echo $result_score_d['score_detail_name'];?>
						</option> 
                        <?php }?>
                      </select>
                    <?php }?>





					<?php // echo $field."_grade";?>
                    </div>




					<input type="hidden" name="<?php echo $field."_grades";?>" value="<?php echo $grade;?>">


				 </td>







					
					<?php 
					include "config.inc.php"; 
					$sql_check_cy= "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
					$query_check_cy = $conn->query($sql_check_cy); 
					if($row_check_cy = $query_check_cy->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
					?>
                    
                    <td>
                    <?php if($row_form_detail['form_detail_competency']=="Y"){?>
					<?php //echo $row_form_detail['form_detail_field']."_competency";?>
                    <input type="checkbox" name="<?php echo $field."_competency";?>" class="form-control" value="checkbox" />
                    <?php } ?> 
                    </td>

					<?php }?> 




					<?php 
					include "config.inc.php"; 
					$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
					$query_check_ex = $conn->query($sql_check_ex); 
					if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คมีการเลือก  Competency ให้แสดง
					?> 
                    <td>






                    <?php if($row_form_detail['form_detail_complete']=="Y"){?>
					<?php //echo $row_form_detail['form_detail_field']."_complete";?>
                    <input type="checkbox" name="<?php echo $field."_complete";?>" class="form-control" value="checkbox" />
                     <?php }?>
                    </td>
					<?php }?> 






                    <td>
					<div align="center">
					<!-- อ.ผู้ประเมิน   --> 				
					
				
					<?php  if(!empty($teacher)){ // ถ้าข้อมูล มีค่า?>
					
					<?php  echo nameTeacher::get_teacher_name($teacher);?>
					<input type="hidden" name="<?php echo $field."_teacher";?>" value="<?php echo $teacher;?>">
					<input type="hidden" name="<?php echo $field."_teachers";?>" value="<?php echo $arrange_teacher_id;?>">

			

					<?php }else if($teacher == 0){ ?>

					<input type="hidden" name="<?php echo $field."_teacher";?>" value="<?php echo $arrange_teacher_id;?>">
					<input type="hidden" name="<?php echo $field."_teachers";?>" value="<?php echo $arrange_teacher_id;?>">

					<?php }else{?>

					<input type="hidden" name="<?php echo $field."_teacher";?>" value="<?php echo $teacher;?>">
					
					<?php }?>
					
					
					</div>
					</td>
					



		  



					<td width="12%">
					<div align="center">
				

					<?php  if(empty($datee)){ ?>
					<input type="hidden" name="<?php echo $field."_date";?>" value="<?php echo $date;?>"> 
					<?php  }else if($datee == "0000-00-00 00:00:00"){ ?>
					<input type="hidden" name="<?php echo $field."_date";?>" value="<?php echo $date;?>"> 
					<?php }else{?>

					<?php  
					$dateformat = new DateTime($datee);
					echo $dateformat->format('d-m-Y H:i:s');
					?>

					
					<input type="hidden" name="<?php echo $field."_date";?>" value="<?php echo $datee;?>"> 

					<?php }?>

					</div>
					</td>





                 </tr>

<?php } ?>
</tbody>
          
    
              
              </table>

					
	
				
			</div> <!-- /.row -->
</div><!-- row-body -->
</div> <!-- card-body -->
</div><!-- card -->
<!-- ส่วนแสดงแบบฟอร์มหลักการประเมิน  -//////////////////////////////////////-->	




