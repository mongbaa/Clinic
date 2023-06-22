<meta charset="utf-8">
<?php

if (isset($_GET['act'])) {
    if ($_GET['act'] == 'excel') {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=export_$type_work_name.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
}
?>

<?PHP
// สร้าง array 2 มิติ
$holistic_array = array();
include "config.inc.php";
$sql_form_holistic   =  " SELECT * FROM tbl_form_holistic ";
$query_form_holistic = $conn->query($sql_form_holistic);
while ($result_form_holistic = $query_form_holistic->fetch_assoc()) {

    $holistic_array[] = array(
        'name' => $result_form_holistic['form_holistic_name'],
        'field' => $result_form_holistic['form_holistic_field'],
        'detail' => $result_form_holistic['form_holistic_detail']
    );
}
// var_dump($holistic_array);
?>
 
<?php
//ตัวแปรเงื่อนไขการค้นหา

if (isset($_GET['type_work_id'])) {
    $type_work_id = $_GET['type_work_id'];
} else {
    $type_work_id = 1;
}


if (isset($_GET['level_search'])) {
    $level_search = $_GET['level_search'];
} else {
    $level_search = 4;
}

if (isset($_GET['student_group'])) {
    $student_group = $_GET['student_group'];
} else {
    $student_group = "";
}


if (isset($_GET['student_search'])) {
    $student_search = $_GET['student_search'];
} else {
    $student_search = "";
}


if (isset($_GET['report_date_id'])) {
    $report_date_id = $_GET['report_date_id'];
} else {
    $report_date_id = '';
}




if (isset($_GET['report_date_id'])) {


    $report_date_id = $_GET['report_date_id'];


    include "config.inc.php";
    $sql_report_date = "SELECT * FROM tbl_report_date  WHERE  report_date_id = $report_date_id ";
    $query_report_date = $conn->query($sql_report_date);
    $result_report_date  = $query_report_date->fetch_assoc();



    $date_start = $result_report_date['report_date_start'];
    $date_end = $result_report_date['report_date_end'];


    $report_date_code = $result_report_date['report_date_code'];
    $report_date_year = $result_report_date['report_date_code'];
} else {




    if (isset($_GET['report_date_code'])) {
        $report_date_code = $_GET['report_date_code'];
    } else {
        $report_date_code = "55";
    }


    if (isset($_GET['date_start'])) {
        $date_start = $_GET['date_start'];
    } else {
        $date_start = date('Y-m-d');
    }

    if (isset($_GET['date_end'])) {
        $date_end = $_GET['date_end'];
    } else {
        $date_end = date('Y-m-d');
    }
}

?>

<table id="example1" border="1" cellpadding="5">
    <thead>



        <tr>
            <th Width="7%">รหัส</th>
            <th Width="20%">ชื่อ-สกุล</th>
            <th>นับคาบ</th>
            <?php
            foreach ($holistic_array as $values => $data) {
            ?>
                <th colspan="3">
                    <div align="center"><?php echo $data['name']; ?></div>
                </th>
            <?php } ?>
            <th>Holistic Total(2)</th>
            <th>Holistic Total(10)</th>
            <th>หัก Conduct</th>
            <th>Conduct (10)</th>
        </tr>




    </thead>



    <tr>
        <td>รหัส</td>
        <td>ชื่อ-สกุล</td>
        <td>นับคาบ</td>
        <?php
        foreach ($holistic_array as $values => $data) {
        ?>
            <td>จำนวนครั้งที่ประเมิน</td>
            <td>คะแนนที่ได้</td>
            <td>รวมคะแนน</td>
        <?php } ?>
        <td>Holistic Total(2)</td>
        <td>Holistic Total(10)</td>
        <td>หัก Conduct</td>
        <td>Conduct(10)</td>
    </tr>


    <tbody>
        <?php
        $total = 0;
        $sum = 0;
        include "config.inc.php";
        $i = 0;
        $sql_student   =  " SELECT *FROM  tbl_student ";

        if ($level_search == "all") {
            $sql_student  .=  " ORDER BY student_id ASC   ";
        } else if ($student_search != "") {
            $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' or student_group like '%$student_search%'  ";
            $sql_student  .=  " ORDER BY student_id ASC  ";
        } else {
            $sql_student   .=  " where student_id  like '$report_date_code%' and student_level != 7 ";
            $sql_student  .=  " ORDER BY student_id ASC  ";
        }

        
        $query_student = $conn->query($sql_student);
        while ($result_student = $query_student->fetch_assoc()) {
            $i++;
            $student_id = $result_student['student_id'];
        ?>
            <tr>
                <td> <?php echo $result_student['student_id']; ?> </td>
                <td> <?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?> </td>


                <td align="center">
                    <?php
                        /* 
                        $sql_holistic_count = " SELECT  h.*,  COUNT(h.holistic_id) As holistic_count , th.* ";
                        $sql_holistic_count  .=  " FROM (SELECT * FROM tbl_holistic WHERE student_id = '$student_id' ";
                        $sql_holistic_count  .=  " and (holistic_date BETWEEN '$date_start' AND '$date_end') ";
                        $sql_holistic_count  .=  " ";
                        $sql_holistic_count  .=  " ) as h ";
                        $sql_holistic_count  .=  " INNER JOIN (SELECT * FROM tbl_teacher WHERE type_work_id = $type_work_id) as th  ON  h.teacher_id = th.teacher_id";
                        $query_holistic_count = $conn->query($sql_holistic_count);
                        $result_holistic_count = $query_holistic_count->fetch_assoc();
                        echo $result_holistic_count["holistic_count"];
                        */

                      //$sql_holistic_count = " SELECT  h.*,  COUNT(h.holistic_id) As holistic_count , th.* ";
                      $sql_holistic_count = " SELECT  h.*,  COUNT(h.holistic_id) As holistic_count  ";
                      $sql_holistic_count  .=  " FROM (SELECT * FROM tbl_holistic WHERE student_id = '$student_id' ";
                      $sql_holistic_count  .=  " and (DATE_FORMAT(holistic_date,'%Y-%m-%d') BETWEEN '$date_start' AND '$date_end' ) and type_work_id = $type_work_id ";
                      $sql_holistic_count  .=  " ";
                      $sql_holistic_count  .=  " ) as h ";
                      // $sql_holistic_count  .=  " INNER JOIN (SELECT * FROM tbl_teacher WHERE type_work_id = $type_work_id) as th  ON  h.teacher_id = th.teacher_id";
                      $query_holistic_count = $conn->query($sql_holistic_count);
                      $result_holistic_count = $query_holistic_count->fetch_assoc();
                      echo $result_holistic_count["holistic_count"];
                    ?>
                </td>




                <?php
                $countstep2  = 0;
                $totalstep = 0;
                $total_countstep2 = 0;
                $total = 0;
                $total_sumstep = 0;
                $total_ = 0;
                foreach ($holistic_array as $values => $data) {
                ?>

                    <td align="center">
                        <?php
                       // $field = $data['field'];  // field เก็บคะแนน
                       // $sql_holistic  = " SELECT  h.student_id, h.$field, h.teacher_id, th.teacher_id, sum(h.$field) As sumstep,  count(h.$field) As countstep ";
                       // $sql_holistic .=  " FROM (SELECT * FROM tbl_holistic where student_id = '$student_id' and $field != 'missing') AS h ";
                       // $sql_holistic .=  " INNER JOIN (SELECT * FROM tbl_teacher WHERE type_work_id = $type_work_id) as th  ON  h.teacher_id = th.teacher_id";
                       // $sql_holistic;

                        $field = $data['field'];  // field เก็บคะแนน
                        $sql_holistic  = " SELECT  student_id, $field, teacher_id, sum($field) As sumstep,  count($field) As countstep ";
                        $sql_holistic .=  " FROM tbl_holistic where student_id = '$student_id' and $field != 'missing' and type_work_id = $type_work_id  ";
                        $sql_holistic .=  " and (DATE_FORMAT(holistic_date,'%Y-%m-%d') BETWEEN '$date_start' AND '$date_end' )  ";

                        //  $sql_holistic   =  " SELECT * FROM tbl_holistic  ";
                        /*$sql_holistic = " SELECT sum(h.$field) As sumstep, h.$field, h.student_id, h.holistic_date, th.teacher_id, th.type_work_id ";
                                            $sql_holistic  .=  " FROM (SELECT * FROM tbl_holistic WHERE student_id = '$student_id' ";
                                            $sql_holistic  .=  " and (holistic_date BETWEEN '$date_start' AND '$date_end') ";
                                            $sql_holistic  .=  " ";
                                            $sql_holistic  .=  " ) as h ";
                                            $sql_holistic  .=  " INNER JOIN (SELECT * FROM tbl_teacher WHERE type_work_id = $type_work_id) as th  ON  h.teacher_id = th.teacher_id";
                                            */


                        $query_holistic = $conn->query($sql_holistic);
                        $result_holistic = $query_holistic->fetch_assoc();
                        $countstep = $result_holistic["countstep"];
                        //echo " * 2 = ";
                        //$countstep2 = $result_holistic["countstep"]*2; //คูณคะแนนเต็ม 2 
                        $countstep2 = $result_holistic["countstep"];
                        //echo "  / ";
                        if (isset($result_holistic["sumstep"])) {
                            $sumstep = $result_holistic["sumstep"];
                        } else {
                            $sumstep = 0;
                        }


                        //echo " <br> ";
                        if (isset($result_holistic["sumstep"])) {
                            $totalstep =  $result_holistic["sumstep"] / $countstep2;
                        } else {
                            $totalstep = 0;
                        }
                        //echo "  =  ";

                        echo $countstep2;
                        ?>

                    
                    </td>
                    <td align="center"><?php echo round($sumstep, 2); ?></td>
                    <td align="center" bgcolor="#E0FFFF"><?php echo round($totalstep, 2); ?></td>


                <?php
                    $total_countstep2 = $total_countstep2 +   $countstep2;
                    $total = $total + $totalstep;
                    $total_sumstep  = $total_sumstep + $sumstep;
                }
                $sum = 0;
                ?>





                <td align="center">

                    <?php


                    $total_10 =  $total * 10; //คะแนนรวม * 10

                    $totall = $total_10 / $total_countstep2;

                    //echo $total_countstep2;
                    //echo " / ";
                    //echo $total_sumstep;  
                    //echo " = ";
                    $total_ = $total_sumstep / $total_countstep2;
                    echo round($total_, 2);


                    ?>


                </td>


                <td align="center">

                    <?php

                    $total_ = $total_sumstep / $total_countstep2;
                    $total_5 = $total_ * 5;
                    echo round($total_5, 2);


                    ?>


                </td>
                <td align="center">

                    <?php
                    $sql_holistic_conduct =  " SELECT SUM(conduct_score) As sum_score FROM tbl_conduct ";
                    $sql_holistic_conduct  .=  " WHERE student_id = '$student_id' ";
                    $sql_holistic_conduct  .=  " and  type_work_id = $type_work_id";
                    $sql_holistic_conduct  .=  " and  conduct_status = 1";
                    $sql_holistic_conduct  .=  " and (conduct_date BETWEEN '$date_start' AND '$date_end') ";
                    $query_holistic_conduct = $conn->query($sql_holistic_conduct);
                    $result_holistic_conduct = $query_holistic_conduct->fetch_assoc();
                    if (!empty($result_holistic_conduct["sum_score"])) {
                        echo "-" . $result_holistic_conduct["sum_score"];
                    } else {
                        echo "0";
                    }
                    ?>


                </td>

                <td align="center">

                    <?php

                    $number_conduct = 10 - $result_holistic_conduct["sum_score"];
                    echo number_format($number_conduct, 2);

                    ?>

                </td>





            </tr>
        <?php
            $sum = 0;
            $total = 0;
            $total_ = 0;
            $total_5 = 0;
        }
        ?>
    </tbody>



</table>