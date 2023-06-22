
<?php 
include "_class_teacher.php";
?>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>

  <meta charset="utf-8">
<table id="example333" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> holistic_id </th>
            <th> type_work_id </th>
            <th> student_id </th>
            <th> holistic_date </th>
            <th> holistic_time_type </th>
            <th> teacher_id </th>
            <th> step1 </th>
            <th> step2 </th>
            <th> step3 </th>
            <th> step4 </th>
            <th> step5 </th>
            <th> step6 </th>
            <th> step7 </th>
        </tr>
    </thead>

    <?php
    include "config.inc.php";
    //$sql_holistic   =  " SELECT * FROM tbl_holistic  ";
    //$sql_holistic = " SELECT h.* ";
    //$sql_holistic  .=  " FROM (SELECT * FROM tbl_holistic3) as h ";
    //$sql_holistic  .=  " INNER JOIN (SELECT * FROM tbl_teacher) as th  ON  h.teacher_id = th.teacher_id";
        $sql_holistic   =  " SELECT * FROM tbl_holistic3 as h ";
   echo $sql_holistic  .=  " ORDER BY h.type_work_id ASC ";
    $query_holistic = $conn->query($sql_holistic);
    while ($result_holistic = $query_holistic->fetch_assoc()) {
    ?>

        <tbody>
            <tr>
                <td><?php echo $result_holistic['holistic_id']; ?></td>
                <td>
                    
                <?php echo $result_holistic['type_work_id']; ?>
                /
                <?php
                $teacher_id = $result_holistic['teacher_id'];
                $sql_teacher  =  " SELECT * FROM tbl_teacher where teacher_id = $teacher_id ";
                $query_teacher = $conn->query($sql_teacher);
                $result_teacher = $query_teacher->fetch_assoc();
                echo $result_teacher['type_work_id'];
                echo "/";
                echo $result_teacher['teacher_id'];
                ?>

                <?php
                if($result_holistic['type_work_id']==0){

                    $type_work_id_new = $result_teacher['type_work_id'];
                    $holistic_id = $result_holistic['holistic_id'];

                    echo $sql_update_tw = " UPDATE tbl_holistic3  SET type_work_id='$type_work_id_new' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_tw); 
                }                
                ?>

                </td> 



                <td><?php echo $result_holistic['student_id'];?></td>
                <td><?php echo $result_holistic['holistic_date'];?></td>
                <td><?php echo $result_holistic['holistic_time_type'];?></td>
                <td><?php echo $result_holistic['teacher_id'];?> / <?php echo nameTeacher::get_teacher_name($result_holistic['teacher_id']); ?>  </td>
            

                <td>
                <?php 
                echo $result_holistic['step1'];
                echo " = ";
                echo $result_holistic['step1_'];
                /*             
                if($result_holistic['step1']==0){
                    $holistic_id = $result_holistic['holistic_id'];
                    $sql_update_s1_n = " UPDATE tbl_holistic3  SET step1_='missing' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_s1_n); 
                }     
                    if($result_holistic['step1']==1){
                        $holistic_id = $result_holistic['holistic_id'];
                        $sql_update_s1_1 = " UPDATE tbl_holistic3  SET step1_='0' WHERE holistic_id='$holistic_id' ";
                        $conn->query($sql_update_s1_1); 
                    }     
                        if($result_holistic['step1']==2){
                            $holistic_id = $result_holistic['holistic_id'];
                            $sql_update_s1_2 = " UPDATE tbl_holistic3  SET step1_='1' WHERE holistic_id='$holistic_id' ";
                            $conn->query($sql_update_s1_2); 
                        }     

                            if($result_holistic['step1']==3){
                                $holistic_id = $result_holistic['holistic_id'];
                                $sql_update_s1_3 = " UPDATE tbl_holistic3  SET step1_='2' WHERE holistic_id='$holistic_id' ";
                                $conn->query($sql_update_s1_3); 
                            }    
               */   
                ?>
               </td>



               <td>
                <?php 
                echo $result_holistic['step2'];
                echo " = ";
                echo $result_holistic['step2_'];
                /*             
                if($result_holistic['step2']==0){
                    $holistic_id = $result_holistic['holistic_id'];
                    $sql_update_s1_n = " UPDATE tbl_holistic3  SET step2_='missing' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_s1_n); 
                }     
                    if($result_holistic['step2']==1){
                        $holistic_id = $result_holistic['holistic_id'];
                        $sql_update_s1_1 = " UPDATE tbl_holistic3  SET step2_='0' WHERE holistic_id='$holistic_id' ";
                        $conn->query($sql_update_s1_1); 
                    }     
                        if($result_holistic['step2']==2){
                            $holistic_id = $result_holistic['holistic_id'];
                            $sql_update_s1_2 = " UPDATE tbl_holistic3  SET step2_='1' WHERE holistic_id='$holistic_id' ";
                            $conn->query($sql_update_s1_2); 
                        }     

                            if($result_holistic['step2']==3){
                                $holistic_id = $result_holistic['holistic_id'];
                                $sql_update_s1_3 = " UPDATE tbl_holistic3  SET step2_='2' WHERE holistic_id='$holistic_id' ";
                                $conn->query($sql_update_s1_3); 
                            }    
               */   
                ?>
               </td>




               <td>
                <?php 
                echo $result_holistic['step3'];
                echo " = ";
                echo $result_holistic['step3_'];
                /*             
                if($result_holistic['step3']==0){
                    $holistic_id = $result_holistic['holistic_id'];
                    $sql_update_s1_n = " UPDATE tbl_holistic3  SET step3_='missing' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_s1_n); 
                }     
                    if($result_holistic['step3']==1){
                        $holistic_id = $result_holistic['holistic_id'];
                        $sql_update_s1_1 = " UPDATE tbl_holistic3  SET step3_='0' WHERE holistic_id='$holistic_id' ";
                        $conn->query($sql_update_s1_1); 
                    }     
                        if($result_holistic['step3']==2){
                            $holistic_id = $result_holistic['holistic_id'];
                            $sql_update_s1_2 = " UPDATE tbl_holistic3  SET step3_='1' WHERE holistic_id='$holistic_id' ";
                            $conn->query($sql_update_s1_2); 
                        }     

                            if($result_holistic['step3']==3){
                                $holistic_id = $result_holistic['holistic_id'];
                                $sql_update_s1_3 = " UPDATE tbl_holistic3  SET step3_='2' WHERE holistic_id='$holistic_id' ";
                                $conn->query($sql_update_s1_3); 
                            }    
               */   
                ?>
               </td>





               
               <td>
                <?php 
                echo $result_holistic['step4'];
                echo " = ";
                echo $result_holistic['step4_'];
                /*             
                if($result_holistic['step4']==0){
                    $holistic_id = $result_holistic['holistic_id'];
                    $sql_update_s1_n = " UPDATE tbl_holistic3  SET step4_='missing' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_s1_n); 
                }     
                    if($result_holistic['step4']==1){
                        $holistic_id = $result_holistic['holistic_id'];
                        $sql_update_s1_1 = " UPDATE tbl_holistic3  SET step4_='0' WHERE holistic_id='$holistic_id' ";
                        $conn->query($sql_update_s1_1); 
                    }     
                        if($result_holistic['step4']==2){
                            $holistic_id = $result_holistic['holistic_id'];
                            $sql_update_s1_2 = " UPDATE tbl_holistic3  SET step4_='1' WHERE holistic_id='$holistic_id' ";
                            $conn->query($sql_update_s1_2); 
                        }     

                            if($result_holistic['step4']==3){
                                $holistic_id = $result_holistic['holistic_id'];
                                $sql_update_s1_3 = " UPDATE tbl_holistic3  SET step4_='2' WHERE holistic_id='$holistic_id' ";
                                $conn->query($sql_update_s1_3); 
                            }    
               */   
                ?>
               </td>




               <td>
                <?php 
                echo $result_holistic['step5'];
                echo " = ";
                echo $result_holistic['step5_'];
                /*             
                if($result_holistic['step5']==0){
                    $holistic_id = $result_holistic['holistic_id'];
                    $sql_update_s1_n = " UPDATE tbl_holistic3  SET step5_='missing' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_s1_n); 
                }     
                    if($result_holistic['step5']==1){
                        $holistic_id = $result_holistic['holistic_id'];
                        $sql_update_s1_1 = " UPDATE tbl_holistic3  SET step5_='0' WHERE holistic_id='$holistic_id' ";
                        $conn->query($sql_update_s1_1); 
                    }     
                        if($result_holistic['step5']==2){
                            $holistic_id = $result_holistic['holistic_id'];
                            $sql_update_s1_2 = " UPDATE tbl_holistic3  SET step5_='1' WHERE holistic_id='$holistic_id' ";
                            $conn->query($sql_update_s1_2); 
                        }     

                            if($result_holistic['step5']==3){
                                $holistic_id = $result_holistic['holistic_id'];
                                $sql_update_s1_3 = " UPDATE tbl_holistic3  SET step5_='2' WHERE holistic_id='$holistic_id' ";
                                $conn->query($sql_update_s1_3); 
                            }    
               */   
                ?>
               </td>



               <td>
                <?php 
                echo $result_holistic['step6'];
                echo " = ";
                echo $result_holistic['step6_'];
                /*             
                if($result_holistic['step6']==0){
                    $holistic_id = $result_holistic['holistic_id'];
                    $sql_update_s1_n = " UPDATE tbl_holistic3  SET step6_='missing' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_s1_n); 
                }     
                    if($result_holistic['step6']==1){
                        $holistic_id = $result_holistic['holistic_id'];
                        $sql_update_s1_1 = " UPDATE tbl_holistic3  SET step6_='0' WHERE holistic_id='$holistic_id' ";
                        $conn->query($sql_update_s1_1); 
                    }     
                        if($result_holistic['step6']==2){
                            $holistic_id = $result_holistic['holistic_id'];
                            $sql_update_s1_2 = " UPDATE tbl_holistic3  SET step6_='1' WHERE holistic_id='$holistic_id' ";
                            $conn->query($sql_update_s1_2); 
                        }     

                            if($result_holistic['step6']==3){
                                $holistic_id = $result_holistic['holistic_id'];
                                $sql_update_s1_3 = " UPDATE tbl_holistic3  SET step6_='2' WHERE holistic_id='$holistic_id' ";
                                $conn->query($sql_update_s1_3); 
                            }    
               */   
                ?>
               </td>




               <td>
                <?php 
                echo $result_holistic['step7'];
                echo " = ";
                echo $result_holistic['step7_'];
                /*             
                if($result_holistic['step7']==0){
                    $holistic_id = $result_holistic['holistic_id'];
                    $sql_update_s1_n = " UPDATE tbl_holistic3  SET step7_='missing' WHERE holistic_id='$holistic_id' ";
                    $conn->query($sql_update_s1_n); 
                }     
                    if($result_holistic['step7']==1){
                        $holistic_id = $result_holistic['holistic_id'];
                        $sql_update_s1_1 = " UPDATE tbl_holistic3  SET step7_='0' WHERE holistic_id='$holistic_id' ";
                        $conn->query($sql_update_s1_1); 
                    }     
                        if($result_holistic['step7']==2){
                            $holistic_id = $result_holistic['holistic_id'];
                            $sql_update_s1_2 = " UPDATE tbl_holistic3  SET step7_='1' WHERE holistic_id='$holistic_id' ";
                            $conn->query($sql_update_s1_2); 
                        }     

                            if($result_holistic['step7']==3){
                                $holistic_id = $result_holistic['holistic_id'];
                                $sql_update_s1_3 = " UPDATE tbl_holistic3  SET step7_='2' WHERE holistic_id='$holistic_id' ";
                                $conn->query($sql_update_s1_3); 
                            }    
               */   
                ?>
               </td>






            </tr>
        <tbody>

        <?php } ?>
</table>