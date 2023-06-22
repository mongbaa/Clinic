



                <?php

                include "config.inc.php"; 

               
            
                $sql_ck_cherk = "SELECT * FROM tbl_ck_$type_work_id  where student_id = '$student_id' and ck_date = '$arrange_date' and ck_time_type = '$arrange_time_type' ";
                $query_ck_cherk = $conn->query($sql_ck_cherk); 
                if($row_ck_cherk = $query_ck_cherk->fetch_assoc()){
                    
                    $row_ck_id =  "ck_" . $type_work_id . "_id";
                    $ck_id = $row_ck_cherk["$row_ck_id"];

                }else{
                
                    $ck_id = "";

                }
                ?>

 

            <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
            <input name="type_work_id" type="hidden" value="<?php echo $type_work_id; ?>" />
            <input name="ck" type="hidden" value="<?php echo $type_work_id; ?>" />
            <input name="ck_id" type="hidden" value="<?php echo $ck_id; ?>" />
            <input name="ck_time_type" type="hidden" value="<?php echo $arrange_time_type; ?>" />
            

            <?php //echo $ck_id; ?>


            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> ข้อมูล Conduct & Knowledge สาขาวิชา > <B><?php echo nameType_work::get_type_work_name($type_work_id); ?></B> </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">



                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th Width="5%">
                                    <div align="center">ลำดับ</div>
                                </th>
                                <th Width="10%"> Type </th>
                                <th Width="30%"> รายการประเมิน</th>
                                <th Width="4%">
                                    <div align="center"> คะแนน </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?PHP


                            $conduct_knowledge_array = array();
                            include "config.inc.php";
                            $sql   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
                            $sql  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
                            $sql  .=  " ORDER BY c.form_conduct_knowledge_order ASC ";
                            $query = $conn->query($sql);
                            $i = 0;
                            while ($row_conduct_knowledge = $query->fetch_assoc()) {
                            $i++;

                            $conduct_knowledge_array[] = array(
                                'name_array' => $row_conduct_knowledge['form_conduct_knowledge_name'],
                                'field_array' => $row_conduct_knowledge['form_conduct_knowledge_field']
                            );


                            
                             $field_field = $row_conduct_knowledge['form_conduct_knowledge_field'];
                             $ck_field_s = $row_ck_cherk["{$field_field}"]; // สร้าง ฟิวคะแนนออกมา

                            if(isset($ck_field_s)){ // เช็คมี ค่าหรือไม่
                              $ck_field = $ck_field_s;
                            }else{
                              $ck_field = "";
                            }
                            //echo $ck_field;
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
                                        <select name="<?php echo $row_conduct_knowledge['form_conduct_knowledge_field']; ?>" id="<?php echo $row_conduct_knowledge['form_conduct_knowledge_field']; ?>" class="form-control">
                                            <option value=""> N/A </option> 
                                            <?php
                                            $row_conduct_knowledge['form_conduct_knowledge_score'];
                                            $ck_score1 = explode(",", $row_conduct_knowledge['form_conduct_knowledge_score']); // แยกครั้งที่ 1
                                            $count_ck_score1 = count($ck_score1);

                                            for ($ct = 0; $ct <= $count_ck_score1; $ct++) {
                                                $step_ck_score1 = @$ck_score1[$ct];  
                                                if ($step_ck_score1 != "") {
                                                    $ck_score2 = explode("=", $step_ck_score1); // แยกครั้งที่ 2
                                            ?>
                                                    <option value="<?php echo @$ck_score2[1]; ?>" <?php if(@$ck_score2[1] == $ck_field){ echo "selected ";}else{  }?> ><?php echo @$ck_score2[0];?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                            <?php } ?>


                        </tbody>

                    </table>


                   



                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->


















