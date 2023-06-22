
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบประเมินคะแนนนักศึกษาในคลินิก</title>
</head>
<?php
//ตัวแปรเงื่อนไขการค้นหา
if (isset($_GET['level_search'])) {
    $level_search = $_GET['level_search'];
} else {
    $level_search = 4;
}


if (isset($_GET['student_search'])) {
    $student_search = $_GET['student_search'];
} else {
    $student_search = '';
}

if(isset($_GET['act'])){
	if($_GET['act']== 'excel'){
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=export_prosth_". $level_search ."_.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
}
?>







<?PHP 


include "config.inc.php";
$plan_array = array();
$sql_plan = " SELECT p.* , t.* , f.*";
$sql_plan  .=  " FROM (SELECT * FROM tbl_plan WHERE type_work_id = 8  ) as p ";
$sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
$sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
$sql_plan  .=  " ORDER BY p.plan_id ASC ";
$query_plan = $conn->query($sql_plan);
while ($result_plan = $query_plan->fetch_assoc()) {
    $plan_array[] = array(
        'plan_id' => $result_plan['plan_id'],
        'plan_name' => $result_plan['plan_name'],
        'form_main_id' => $result_plan['form_main_id']
    );
}
?>


<style>
            .table-responsive {
                height: 500px;
                overflow: scroll;
            }


            /* หัวตาราง ที่ 1 */
            thead tr:nth-child(1) th {
                position: sticky;
                top: 0px;
                z-index: auto;
            }

            
            /* หัวตาราง ที่ 2 */
            thead tr:nth-child(2) th {
                position: sticky;
                top: 40px;
                z-index: auto;
            }


            td,
            th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #dddddd;
                color: black;
                
            }

            th,
            td:nth-child(1) {
                position: sticky;
                top: 80px;
                left: 0px;
                padding: 5px;
                z-index: auto;
                background-color: whitesmoke;
                color: black;
            }


            td:nth-child(2) {
                position: sticky;
                top: 80px; left: 100px;
                z-index: auto;
                background-color: whitesmoke;
                color: black;
            }

         

            table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            border-style: dotted;
            padding: 10px;
            }

        </style>
                <table id="example" class="stripe row-border order-column" style="width:100%">

                        <thead>
                            <tr>
                                <th Width="7%"></th>
                                <th Width="15%"></th>
                                <?PHP
                                foreach ($plan_array as $values => $data) {
                                    $plan_id_arr =  $data['plan_id'];
                                    $plan_name_arr =  $data['plan_name'];
                                    $form_main_id_arr =  $data['form_main_id'];
                                ?>
                                    <th align="center" colspan="3"><?php echo $plan_name_arr; ?></th>

                                <?php } ?>
                                <th align="center" colspan="4">Total</th>
                            </tr>

                            <tr>
                                <th Width="7%">รหัส</th>
                                <th Width="15%">ชื่อ-สกุล</th>
                                <?PHP
                                foreach ($plan_array as $values => $data) {
                                    $plan_id_arr =  $data['plan_id'];
                                    $plan_name_arr =  $data['plan_name'];
                                    $form_main_id_arr =  $data['form_main_id'];

                                ?>

                                    <th>C</th>
                                    <th>W</th>
                                    <th>S</th>

                                <?php } ?>
                                <th align="center" colspan="4">Total</th>
                            </tr>

                        </thead>
          

                        <tbody>


                            <?php
                            include "config.inc.php";
                            $i = 0;
                            $sql_student   =  " SELECT *FROM  tbl_student ";

                            if ($level_search == "all") {
                                $sql_student  .=  " ORDER BY student_id ASC   ";

                            } else if ($student_search != "") {

                                $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' or student_group like '%$student_search%'  ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";

                            } else {

                                $sql_student   .=  " where student_level  = $level_search  and student_level != 7 ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            }

                            $query_student = $conn->query($sql_student);
                            while ($result_student = $query_student->fetch_assoc()) {
                                $i++;
                                $student_id = $result_student['student_id'];
                            ?>


                                <tr>
                                    <td Width="7%"> <?php echo $result_student['student_id']; ?></td>
                                    <td Width="15%"><?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?> </td>
                                    <?PHP
                                    foreach ($plan_array as $values => $data) {
                                    $plan_id_arr =  $data['plan_id'];
                                    $plan_name_arr =  $data['plan_name'];
                                    $form_main_id_arr =  $data['form_main_id'];
                                    ?>

                                    <td>
                                        
                                    <?php 
                                     $count = 0;
                                     $check_prosth_array = array();
                                     $sql_check_prosth = " SELECT * FROM tbl_check_prosth AS cp ";
                                     $sql_check_prosth .= " INNER JOIN tbl_detail AS d ON cp.detail_id = d.detail_id  ";
                                     $sql_check_prosth .= " where cp.check_complete = 1 and cp.student_id = $student_id and cp.check_prosth_year = $level_search ";
                                     $sql_check_prosth .= " and d.plan_id = $plan_id_arr ";
                                     $sql_check_prosth .= "  ORDER BY cp.detail_id ASC ";
                                     $query_check_prosth = $conn->query($sql_check_prosth);
                                     
                                     while ($row_check_prosth = $query_check_prosth->fetch_assoc()) {
                                     $count ++;

                                        $check_prosth_array[] = array(
                                            'prosth_weight' => $row_check_prosth['check_prosth_weight'],
                                            'prosth_score' => $row_check_prosth['check_prosth_score'],
                                            'prosth_count' => $count
                                        );

                                        echo  $count ."<br>"; 

                                    }
                                     ?>
                                       
                                    </td>
                                    <td><?php foreach ($check_prosth_array as $values => $data) {  echo $data['prosth_weight']."<br>";  }  ?></td>
                                    <td><?php foreach ($check_prosth_array as $values => $data) {  echo $data['prosth_score']."<br>";  }  ?></td>
                                    
                                           

                                <?php } ?>
                                <td></td>
                                </tr>


                            <?php } ?>


                        <tbody>
                    </table>
          