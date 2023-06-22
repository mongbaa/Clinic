ss<?php
    include "config.inc.php";



    $detail_id = $_POST['detail_id'];
    $teacher_id = $_POST['teacher_id'];
    $arrange_time_type = $_POST['arrange_time_type'];
    $arrange_type = $_POST['arrange_type'];
    $arrange_detail  = $conn->real_escape_string($_POST['arrange_detail']);

    $arrange_date = $_POST['arrange_date'];
    $arrange_record_date = date('Y-m-d');
    $arrange_time = date('H:i:s');
    $arrange_check_eval = "0";


    $sql = "INSERT INTO tbl_arrange (arrange_id, detail_id, arrange_date, arrange_record_date, arrange_time, arrange_time_type, arrange_check_eval, teacher_id, arrange_type, arrange_detail) VALUES (NULL, '$detail_id', '$arrange_date', '$arrange_record_date', '$arrange_time', '$arrange_time_type', '$arrange_check_eval', '$teacher_id', '$arrange_type', '$arrange_detail');";
    $conn->query($sql);



    if ($arrange_type  == 1) {

        echo "<script type='text/javascript'>";
        //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
        echo "window.location='arrange_send_lab.php?do=success'";
        echo "</script>";
        
    } else {

        echo "<script type='text/javascript'>";
        //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
        echo "window.location='arrange_add.php?do=success'";
        echo "</script>";

    }








    ?>