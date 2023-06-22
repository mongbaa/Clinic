<div class="card">
	  
      
	    <div class="card-header">
          <h3 class="card-title"> แสดงข้อมูลการประเมินคะแนน : <?php echo $row_form_main['type_work_name'];?>
            ชื่อฟอร์ม : <?php echo $row_form_main['form_main_name'];?></h3>
			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fas fa-times"></i></button>
			  </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-6 col-12">




                        <?php 
                            include "config.inc.php"; 
                            // หาชื่อตารางหลัก 
                            $sql_form_main_re   =  " SELECT fm.form_main_id, fm.form_main_table ";
                            $sql_form_main_re  .=  " FROM (SELECT f.*   FROM tbl_form_main AS f WHERE f.form_main_id = '$form_main_id') AS fm ";
                            $query_form_main_re = $conn->query($sql_form_main_re); 
                            $row_form_main_re = $query_form_main_re->fetch_assoc();
                            //echo $sql_form_main_re;
                              $tbl=$row_form_main_re['form_main_table']; // ชื่อตาราง
                           // echo "<br>";
                              $tbl_id = $tbl."_id"; // Id ของตาราง
                           // echo "<br>";
                        ?>


                       

                    <table id="example3" class="table table-bordered table-striped">
                        


                        <thead>

                            <tr>
                                <th Width="3%"><div align="center">ลำดับ</div></th>
                                <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>

                                <?php 
                                //  $sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id";
                                if(!empty($nohn)){  
                                        $detail_id = $arrange_nohn_id;
                                        $sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and student_id = $student_id";
                                }else{
                                    
                                        $sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id";
                                } 

                                $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                $query_form_re = $conn->query($sql_form_re); 
                                while($row_form_re = $query_form_re->fetch_assoc()){
                                $last_date = $row_form_re['last_date'];
                                $id_form_re = $row_form_re["{$tbl_id}"];
                                ?>
                                <th Width="7%"><div align="center">	<?php if($type_work_id==4){?> ครั้ง <?php }else{ ?>  น้ำหนัก<?php }?></div></th>
                                <th Width="7%"><div align="center">คะแนน</div></th>
                                <?php } // $sql_form_re?>
                            </tr>


                        </thead>

                        <tbody>
                            <?php 
                            $i_re = 0 ;
                            // หาชื่อฟิลด์
                            $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                            $sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
                            $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                            //echo $sql_form_detail_re;
                            $query_form_detail_re = $conn->query($sql_form_detail_re); 
                            while($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                            $i_re++;
                            $field = $tbl."_".$row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                            ?>


                            <tr>
                                <td><div align="center"> <?php echo $i_re;?></div></td>
                                <td><?php echo $row_form_detail_re['form_detail_topic'];?>  (<?php echo $row_form_detail_re['form_detail_field'];?>) </td>
                               




                               
                               <?php 
                               


                                if(!empty($nohn)){  

                                    $detail_id = $arrange_nohn_id;
                                    $sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and student_id = $student_id";
                                    //$sql_form_re = "SELECT * FROM tbl_".$tbl." where student_id = $student_id";

                               }else{
                                  
                                    $sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id";
                               } 


                                $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                $query_form_re = $conn->query($sql_form_re); 
                                while($row_form_re = $query_form_re->fetch_assoc()){


                                $field_grade = $field."_grade";  //_grade
                                $grade = $row_form_re["{$field_grade}"];

                                if( isset($grade) && !empty($grade) ){ 

                                    $field_weights = $field."_weight";   //_weight
                                    $weight = $row_form_re["{$field_weights}"];
   
                                    $field_teacher = $field."_teacher";  //_teacher
                                    $teacher = $row_form_re["{$field_teacher}"];  

                                    $field_date = $field."_date";  //_date
                                    $datee = $row_form_re["{$field_date}"];

                                }else{

                                    $weight = "";
                                    $teacher = "";
                                    $datee = "";
                                }
                                ?>


                                <td> <div align="center"><?php echo $weight;?></td>

                                <td> 
                                    <div align="center">
                                        <a href="#" data-toggle="tooltip" title="<?php  echo nameTeacher::get_teacher_name($teacher);?>   (<?php echo $datee;?>)"><?php echo $grade;?></a> 
                                       
                                        
                                    
                                       
                                    </div>
                                </td>



                                <?php } // $sql_form_re?>


                                                     
                                
                            </tr>



                            <?php } ?>









                            <tr>
                                <td></td>
                                <td></td>


                               <?php 
                                //$sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id";

                                if(!empty($nohn)){  

                                    $detail_id = $arrange_nohn_id;
                                    $sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id and student_id = $student_id";
                                    //$sql_form_re = "SELECT * FROM tbl_".$tbl." where student_id = $student_id";
                                    
                               }else{
                                  
                                    $sql_form_re = "SELECT * FROM tbl_".$tbl." where detail_id = $detail_id";
                               } 


                                $sql_form_re  .=  " ORDER BY $tbl_id  ASC ";
                                $query_form_re = $conn->query($sql_form_re); 
                                while($row_form_re = $query_form_re->fetch_assoc()){
                                $last_date = $row_form_re['last_date'];

                                $field_comment = $tbl."_comment"; // ชื่อ field comment
                                $comment = $row_form_re["{$field_comment}"];
                                $id_form_re = $row_form_re["{$tbl_id}"];

                                $id_form = $row_form_re["{$tbl_id}"];
                                ?>

                                <td>  <div align="center"> <?php echo $last_date;?> 
                                 
                                <?php echo $comment;?>
                               
                                
                                 </div> </td>
                                <td>  
                                
                                
                                <div align="center"> 
                                
                                
                                
                                <a href="?detail_id=<?php echo $detail_id;?>&plan_id=<?php echo $plan_id;?>&arrange_date=<?php echo $arrange_date;?>&arrange_id=<?php echo $arrange_id;?>&id_form=<?php echo $id_form;?>" class="btn btn-info" >  <i class="fas fa-edit"></i> </a>
                               





                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myDelete<?php echo $id_form;?>">
                        <i class="fas fa-trash"></i> Delete!
                        </button>

                        
                        


                        <form name="form<?php echo $id_form;?>" method="POST" action="form_evaluate_del.php">
                            <input name="id_form" type="hidden" value="<?php echo $id_form;?>" />
                            <input name="plan_id" type="hidden" value="<?php echo $plan_id; ?>" />
                            <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />
                            <input name="arrange_date" type="hidden" value="<?php echo $arrange_date; ?>" />
                            <input name="arrange_id" type="hidden" value="<?php echo $arrange_id; ?>" />
                            <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />
                            <input name="evaluate_del_user" type="hidden" value="<?php echo $arrange_teacher_id; ?>" />

                            <div class="modal fade" id="myDelete<?php echo $id_form;?>">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h4 class="modal-title"> ลบใบงานการประเมิน </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body"> 
                                    ระบุเหตุผลการลบใบงานการประเมินครั้งนี้ <?php echo $last_date;?> 
                                    <textarea id="evaluate_del_detail" class="form-control" name="evaluate_del_detail" rows="4" cols="50" required></textarea>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-outline-danger"> ยืนยันการลบ </button>
                                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </form>







                                <?PHP if($id_form == $id_formss){ }else{?>

                                <a href="?del=<?php echo $id_form;?>&detail_id=<?php echo $detail_id;?>&plan_id=<?php echo $plan_id;?>&arrange_date=<?php echo $arrange_date;?>&arrange_id=<?php echo $arrange_id;?>" class="btn btn-danger" onClick="return confirm('กรุณายืนยันการ ยกเลิก Redone <?php echo $last_date;?> อีกครั้ง !!!')">  <i class="fas fa-trash"></i> </a>
                               
                               
                                <?php }?>
                                
                                
                                </div> </td>

                                <?php } // $sql_form_re?>
                            </tr>
                         

                            


                        </tbody>



                    </table>





                </div>
            </div>
        </div>
</div>


