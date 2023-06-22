กรณีไม่มีผู้ป่วย



<?php
 echo $plan_name;
// echo "<br>";

include "config.inc.php";
/*$sql_detail = " SELECT o.*, d.*, p.* , t.* , f.*";
                    $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                    $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE plan_id = $plan_id $detail_work_ids) as d  ON  d.order_id = o.order_id";
                    $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p  ON  p.plan_id = d.plan_id";
                    $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                    $sql_detail  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
                    $sql_detail  .=  " ORDER BY d.detail_id ASC ";*/

$sql_from_nohn   =  " SELECT a.*, p.*, f.* ";
$sql_from_nohn  .=  " FROM (SELECT * FROM tbl_arrange_nohn WHERE student_id = $student_id and  type_work_id = $type_work_id and plan_id = $plan_id ) as a";
$sql_from_nohn  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p  ON  p.plan_id = a.plan_id";
$sql_from_nohn  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
//  echo  $sql_from_nohn;
$query_from_nohn = $conn->query($sql_from_nohn);
while ($result_from_nohn = $query_from_nohn->fetch_assoc()) {
    $tbl_nohn = $result_from_nohn['form_main_table']; // ชื่อตาราง
    $tbl_id_nohn = $tbl_nohn . "_id"; // Id ของตาราง
    $form_main_id = $result_from_nohn['form_main_id']; // ชื่อตาราง 
    $detail_id = $result_from_nohn['arrange_nohn_id']; // arrange_nohn_id เชื่อม detail_id
    
?>


    <div class="card-header">
        <h3>
            <span class='badge bg-warning'><?php echo namePlan::get_plan_name($result_from_nohn['plan_id']); ?></span>
        </h3>


        <h4>
            <span class="badge badge-secondary">Date : <?php echo set_format_date($result_from_nohn['arrange_nohn_record_date']); ?></span>
            <span class="badge badge-secondary">Time : <?php echo $result_from_nohn['arrange_nohn_time']; ?> (<?php echo $result_from_nohn['arrange_nohn_time_type']; ?>)</span>
            <span class="badge badge-success"><?php echo $result_from_nohn['sum_score_nohn'];?></span>

    
        </h4>


        <h2 class="card-title">
            รายละเอียด :
            <?php echo $result_from_nohn['arrange_nohn_detail']; ?>
        </h2>
        <br>




        <?php
        $sql_form_re_nohn = "SELECT * FROM tbl_" . $tbl_nohn . " where detail_id = $detail_id";
        $sql_form_re_nohn  .=  " ORDER BY $tbl_id_nohn  ASC ";
        $query_form_re_nohn = $conn->query($sql_form_re_nohn);
        if ($row_form_re_nohn = $query_form_re_nohn->fetch_assoc()) {
        ?>

            <!-- /.card-header -->
            <div class="card-body">
                <div class="callout callout-info">



                    <div class="table-responsive-xl">
                        <table id="example3" class="table table-bordered table-striped">



                            <thead>
                                <tr>
                                    <th Width="3%">
                                        <div align="center">ลำดับ</div>
                                    </th>
                                    <th Width="20%">หัวข้อการประเมิน / ขั้นตอน </th>

                                    <th Width="7%">
                                        <div align="center">น้ำหนัก</div>
                                    </th>
                                    <th Width="7%">
                                        <div align="center">คะแนน</div>
                                    </th>
                                    <th Width="7%">
                                        <div align="center">ผู้ประเมิน </div>
                                    </th>
                                    <th Width="7%">
                                        <div align="center">วันที่</div>
                                    </th>
                                    <th Width="5%"> Sum </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $sum_score = 0;
                                $total_score = 0;
                                $total_weight = 0;
                                $total_step = 0;

                                $i_re = 0;
                                $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                                $sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
                                $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                                //echo $sql_form_detail_re;
                                $query_form_detail_re = $conn->query($sql_form_detail_re);
                                while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                 
                                 
                                    $i_re++;
                                    $field = $tbl_nohn . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์

                                    $field_grade = $field . "_grade";  //_grade
                                    $grade = $row_form_re_nohn["{$field_grade}"];

                                    if (isset($grade) && !empty($grade)) {
                                        $field_weights = $field . "_weight";   //_weight
                                        $weight = $row_form_re_nohn["{$field_weights}"];
                                        $field_teacher = $field . "_teacher";  //_teacher
                                        $teacher = $row_form_re_nohn["{$field_teacher}"];
                                        $field_date = $field . "_date";  //_date
                                        $datee = $row_form_re_nohn["{$field_date}"];
                                    } else {
                                        $weight = "";
                                        $teacher = "";
                                        $datee = "";
                                    }

                                    if ($grade == "A") {
                                        $score = 4;
                                        $stepp = 1;
                                        $weight_ss =  $weight;
                                        $claass = "table-success";
                                    } else if ($grade == "B") {
                                        $score = 3;
                                        $stepp = 1;
                                        $weight_ss =  $weight;
                                        $claass = "table-success";
                                    } else if ($grade == "C") {
                                        $score = 2;
                                        $stepp = 1;
                                        $weight_ss =  $weight;
                                        $claass = "table-success";
                                    } else if ($grade == "F") {
                                        $score = 1;
                                        $stepp = 1;
                                        $weight_ss =  $weight;
                                        $claass = "table-success";
                                    } else {
                                        $score = 0;
                                        $stepp = 0;
                                        $weight_ss =  0;
                                        $claass = "";
                                    }
                             
                                    $sum_score = $weight * $score; // ผลคูณคะแนน

                                        ?>

                                    <tr>
                                        <td>
                                            <div align="center"> <?php echo $i_re; ?></div>
                                        </td>
                                        <td><?php echo $row_form_detail_re['form_detail_topic']; ?></td>
                                        <td>
                                            <div align="center"><?php echo $weight; ?>
                                        </td>
                                        <td>
                                            <div align="center"> <?php echo $grade; ?> (<?php echo $score; ?>) </div>
                                        </td>
                                        <td>
                                            <div align="center">
                                                <?php echo nameTeacher::get_teacher_name($teacher); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="center"> <?php echo $datee; ?></div>
                                        </td>

                                        <td>
                                            <?php
                                            echo $sum_score;
                                            ?>
                                        </td>


                                    </tr>

                                <?php 

                                $total_score = $total_score + $sum_score;
                                $total_weight = $total_weight + $weight_ss;
                                $total_step = $total_step + $stepp;

                              if (!empty($total_step)) {
                                $total_weights = $total_weight  / $total_step;
                              } else {
                                $total_weights = 0;
                              }
                    
                            } 
                                
                                ?>


                         
                            </tbody>

                        </table>

                        <?php echo $total_score;?>
                        /
                        <?php echo $total_weight;?>
                        =
                        <?php @$price = $total_score / $total_weight;   if(isset($price)){ echo round($price,2); }else{ echo "0"; }  ?>
                        
                    </div>




                </div>
            </div>
            <!-- /.card-body -->
        <?php } else { ?>


            <!-- /.card-header -->
            <div class="card-body">
                <div class="callout callout-danger">
                    ยังไม่ได้รับการประเมินคะแนน
                </div>
            </div>
            <!-- /.card-body -->

        <?php }  ?>




    </div>




<?php } ?>