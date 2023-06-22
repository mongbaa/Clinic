<div class="card card-danger">
 
    <div class="card-header ">
        <h3 class="card-title"> <i class="fas fa-frown"></i> Conduct </h3>



        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
        </div>
    </div>



    <div class="card-body">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Conduct
                </h3>
            </div>


            <div class="card-body">

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#conduct1">
                    <i class="fas fa-pen-square"></i> หมวดที่ 1 ความประพฤติทั่วไป
                </button>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#conduct2">
                    <i class="fas fa-pen-square"></i> หมวดที่ 2 ความผิดร้ายแรง
                </button>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#conduct3">
                    <i class="fas fa-pen-square"></i> หมวดที่ 3 การประเมินเจตคติตามข้อบังคับของสาขา
                </button>


                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#conduct4">
                    <i class="fas fa-pen-square"></i> กรณีอื่นๆ
                </button>



                <div class="text-muted mt-3">
                    เลือกหมวด Conduct
                </div>

            </div>
            <!-- /.card -->
        </div>

        <?php
        for ($x = 1; $x <= 4; $x++) {
        ?>

                   

            <form name="form_conduct<?php echo $x; ?>" method="POST" action="form_evaluate_conduct_q.php">


                <input name="plan_id" type="hidden" value="<?php echo $plan_id; ?>" />
                <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />
                <input name="arrange_id" type="hidden" value="<?php echo $arrange_id; ?>" />
                <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
                <input name="arrange_date" type="hidden" value="<?php echo $arrange_date; ?>" />
                <input name="teacher_id" type="hidden" value="<?php echo $arrange_teacher_id; ?>" />
                <input name="arrange_time_type" type="hidden" value="<?php echo $arrange_time_type; ?>" />
                <input name="arrange_date" type="hidden" value="<?php echo $arrange_date; ?>" />



                <div class="modal fade" id="conduct<?php echo $x; ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content  ">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title">  
                                

                                <?php
                            $form_group_x = $x;
                            switch ($form_group_x) { // Harder page
                                case 0:
                                    echo  " -- ";
                                    break;
                                case 1:
                                    echo  "หมวดที่ 1 ความประพฤติทั่วไป";
                                    break;
                                case 2:
                                    echo  "หมวดที่ 2 ความผิดร้ายแรง</p>";
                                    break;
                                case 3:
                                    echo  "หมวดที่ 3 การประเมินเจตคติตามข้อบังคับของสาขา";
                                    break;
                                case 4:
                                    echo  "กรณีอื่นๆ";
                                    break;
                                default:
                                    echo  "-";
                                    break;
                            }
                            ?>
                            
                            </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">


                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div align="center">#</div>
                                            </th>
                                            <th>ประเภท</th>
                                            <th>เรื่อง</th>
                                            <th>คะแนน</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?PHP
                                        include "config.inc.php";
                                        $sql   =  " SELECT * FROM tbl_form_conduct as c ";
                                        $sql  .=  " LEFT JOIN  tbl_type_work   AS t  ON  t.type_work_id = c.type_work_id ";

                                        if ($x == 3) { // หมวดที่ 3 แยกตามสาขา
                                            $sql  .=  " WHERE c.form_conduct_status = 1 and c.form_conduct_group = $x and c.type_work_id = $type_work_id ORDER BY c.form_conduct_name ASC ";
                                        } else {
                                            $sql  .=  " WHERE c.form_conduct_status = 1 and c.form_conduct_group = $x  ORDER BY  c.form_conduct_no + 0 ASC  ";
                                            //$sql  .=  " WHERE c.form_conduct_status = 1 and c.form_conduct_group = $x  ORDER BY  LENGTH(c.form_conduct_name) ASC, c.form_conduct_name ASC  ";
                                            //$sql  .=  " WHERE c.form_conduct_status = 1 and c.form_conduct_group = $x  ORDER BY  LEFT( c.form_conduct_name , LOCATE(' ', c.form_conduct_name ) - 1) ASC  ";
                                            //$sql  .=  " WHERE c.form_conduct_status = 1 and c.form_conduct_group = $x  ORDER BY  cast(c.form_conduct_name as unsigned) , c.form_conduct_type, c.form_conduct_name ASC ";
                                        }
                                        // $sql;
                                        $query = $conn->query($sql);
                                        $i = 0;
                                        while ($result = $query->fetch_assoc()) {
                                            $i++;
                                        ?>
                                            <tr class="odd gradeX">
                                                <td align="center"><?php echo $i; ?></td>

                                                <td> 
                                                    <?php
                                                    $form_conduct_type = $result['form_conduct_type'];
                                                    switch ($form_conduct_type) { // Harder page
                                                        case 0:
                                                            echo  " -- ";
                                                            break;
                                                        case 1:
                                                            echo  "เวชระเบียน";
                                                            break;
                                                        case 2:
                                                            echo  "การปฏิบัติงานในคลินิก";
                                                            break;
                                                        case 3:
                                                            echo  "ความผิดอื่นๆ";
                                                            break;
                                                        case 4:
                                                            echo  "ความผิดในการปฏิบัติงาน";
                                                            break;
                                                        case 5:
                                                            echo  "ความผิดตามข้อบังคับวินัยนักศึกษา ของมหาวิทยาลัย";
                                                            break;
                                                        case 6:
                                                            echo  "เฉพาะสาขา";
                                                            break;
                                                        case 7:
                                                            echo  "กรณีอื่นๆ";
                                                            break;
                                                        default:
                                                            echo  "-";
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                   <td>


                                                    <?php if ($result['form_conduct_id'] == 10) {  // ID = 10  อื่นๆๆ
                                                    ?>
                                                        <input type="text" id="conduct_note<?php echo $i; ?>" name="conduct_note<?php echo $i; ?>" value="<?php echo $result['form_conduct_name']; ?>" class="form-control">
                                                   
                                                    <?php } else if ($result['form_conduct_id'] == 22) { ?>


                                                         <input type="text" id="conduct_note<?php echo $i; ?>" name="conduct_note<?php echo $i; ?>" value="<?php echo $result['form_conduct_name']; ?>" class="form-control">

                                                
                                                   
                                                    <?php } else { ?>

                                                        <?php echo $result['form_conduct_name']; ?>
                                                        <input type="hidden" name="conduct_note<?php echo $i; ?>" value="">

                                                    <?php } ?>


                                                </td>
                                                <td>
                                                    <input type="hidden" name="form_conduct_id<?php echo $i; ?>" value="<?php echo $result['form_conduct_id']; ?>">
                                                    <input type="hidden" name="form_conduct_group<?php echo $i; ?>" value="<?php echo $result['form_conduct_group']; ?>">
                                                    <input type="hidden" name="type_work_id<?php echo $i; ?>" value="<?php echo $type_work_id; ?>">

                                                    
                                                    <select name="conduct_score<?php echo $i; ?>" class="form-control">

                                                  
                                                        <option value="">--- N/A ---</option>
                                                        <?php
                                                        $step1 = explode(",", $result['form_conduct_score']); // แยก   
                                                        $step2 = count($step1);
                                                        for ($ct = 0; $ct <= $step2; $ct++) {
                                                            $step = $step1[$ct];
                                                            if ($step != "") {
                                                        ?>
                                                                <option value="<?php echo $step; ?>"> - <?php echo $step; ?> </option>
                                                        <?php
                                                            } //if
                                                        } //for
                                                        ?>
                                                    </select>


                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>


                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="submit" class="btn btn-outline-danger"> ยืนยัน </button>
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                                <!-- <button type="button" class="btn btn-outline-danger"> OK </button>-->
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->

                </div>
                <!-- /.modal -->



            </form>


        <?php
        }
        ?>









        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>
                        <div align="center">ลำดับที่</div>
                    </th>
                    <th>วันที่</th>
                    <th>ผู้ประเมิน</th>
                    <th>สาขา</th>
                    <th>หมวด</th>
                    <th>ประเภท</th>
                    <th>เรื่อง</th>
                    <th>คะแนน</th>
                    <th>จัดการข้อมูล</th>
                </tr>
            </thead>

            <tbody>
                <?PHP
                include "config.inc.php";
                $sql   =  " SELECT  c.*, fc.form_conduct_id, fc.form_conduct_group, fc.form_conduct_type, fc.form_conduct_name  ";
                $sql  .=  " FROM tbl_conduct as c ";
                $sql  .=  " INNER JOIN  tbl_form_conduct   AS fc  ON  fc.form_conduct_id = c.form_conduct_id ";
              //  $sql  .=  " where c.type_work_id = $type_work_id  and c.conduct_date = '$arrange_date' and student_id = '$student_id' and c.conduct_status = 1";
                $sql  .=  " where  1=1 ";

                if(!empty($type_work_id)){

                $sql  .=  " and c.type_work_id = $type_work_id   and student_id = '$student_id' and c.conduct_status = 1";

                }else{

                $sql  .=  " and student_id = '$student_id' and c.conduct_status = 1";

                }



                $sql  .=  " ORDER BY c.conduct_id ASC ";
                $query = $conn->query($sql);
                $i = 0;
                while ($result = $query->fetch_assoc()) {
                    $i++;
                ?>
                    <tr class="odd gradeX">

                        <td align="center"><?php echo $i; ?></td>
                        <td>
                            <?php
                            // echo set_format_date($result['conduct_date']);
                            $date = date_create($result['conduct_date']);
                            echo date_format($date,"d-m-Y");
                            
                            ?>
                    
                    
                        </td>
                        <td><?php echo nameTeacher::get_teacher_name($result['teacher_id']); ?></td>
                        <td><?php echo nameType_work::get_type_work_name($result['type_work_id']); ?></td>
                        
                        <td>
                            <?php
                            $form_conduct_group = $result['form_conduct_group'];
                            switch ($form_conduct_group) { // Harder page
                                case 0:
                                    echo  " -- ";
                                    break;
                                case 1:
                                    echo  "หมวดที่ 1 ความประพฤติทั่วไป";
                                    break;
                                case 2:
                                    echo  "<p style='color:red'>หมวดที่ 2 ความผิดร้ายแรง</p>";
                                    break;
                                case 3:
                                    echo  "<p style='color:red'>หมวดที่ 3 การประเมินเจตคติตามข้อบังคับของสาขา</p>";
                                    break;
                                case 4:
                                    echo  "<p style='color:red'><B>หักนอกคาบ</B></p>";
                                    break;
                                default:
                                    echo  "-";
                                    break;
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            $form_conduct_type = $result['form_conduct_type'];
                            switch ($form_conduct_type) { // Harder page
                                case 0:
                                    echo  " -- ";
                                    break;
                                case 1:
                                    echo  "เวชระเบียน";
                                    break;
                                case 2:
                                    echo  "การปฏิบัติงานในคลินิก";
                                    break;
                                case 3:
                                    echo  "ความผิดอื่นๆ";
                                    break;
                                case 4:
                                    echo  "ความผิดในการปฏิบัติงาน";
                                    break;
                                case 5:
                                    echo  "ความผิดตามข้อบังคับวินัยนักศึกษา ของมหาวิทยาลัย";
                                    break;
                                case 6:
                                    echo  "เฉพาะสาขา";
                                    break;
                                case 7:
                                    echo  "<p style='color:red'><B>หักนอกคาบ</B></p>";
                                    break;
                                default:
                                    echo  "-";
                                    break;
                            }
                            ?>
                        </td>


                        <td>
                            <?php if ($result['form_conduct_id'] == 10) {  // ID = 10  อื่นๆๆ ?>
                                <?php echo $result['conduct_note']; ?>   
                            <?php } else if ($result['form_conduct_id'] == 22) { ?>
                                <?php echo $result['conduct_note']; ?>
                            <?php } else { ?>
                                <?php echo $result['form_conduct_name']; ?>
                            <?php } ?>
                        </td>


                        <td>
                            <?php 
                            if($result['conduct_score']==0){  
                                echo "<p style='color:red'> รอผล </p>";
                            }else{
                                echo "- ";
                                echo $result['conduct_score'];
                            }
                            ?>
                        </td>


                        <td class="center">
                            <?php if($result['teacher_id']==$arrange_teacher_id){?> 
                                <a href="form_evaluate_conduct_del.php?del_conduct=<?php echo $result['conduct_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการยกเลิกอีกครั้ง !!!')"> ยกเลิก </a>
                            <?php }?>
                        </td>




                    </tr>
                <?php } ?>

            </tbody>
        </table>


    </div>
</div>
<!-- /.card -->






<!-- page script Tooltip -->
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>