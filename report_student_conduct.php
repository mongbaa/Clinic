Conduct

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
   
</tr>
</thead>

<tbody>
<?PHP
include "config.inc.php";
$sql   =  " SELECT  c.*, fc.form_conduct_id, fc.form_conduct_group, fc.form_conduct_type, fc.form_conduct_name  ";
$sql  .=  " FROM tbl_conduct as c ";
$sql  .=  " INNER JOIN  tbl_form_conduct   AS fc  ON  fc.form_conduct_id = c.form_conduct_id ";
$sql  .=  " where c.type_work_id = $type_work_id   and student_id = '$student_id' and c.conduct_status = 1";
$sql  .=  " ORDER BY c.conduct_id ASC ";
$query = $conn->query($sql);
$i = 0;
while ($result = $query->fetch_assoc()) {
    $i++;
?>
    <tr class="odd gradeX">

        <td align="center"><?php echo $i; ?></td>
        <td><?php echo set_format_date($result['conduct_date']);?></td>
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
                default:
                    echo  "-";
                    break;
            }
            ?>
        </td>
        <td><?php echo $result['form_conduct_name']; ?></td>
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


      

    </tr>
<?php } ?>

</tbody>
</table>
