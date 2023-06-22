<?php


    include "config.inc.php";
    $sql_holistic_count = " SELECT * FROM tbl_holistic_650912 WHERE  type_work_id = 0 ";
    $query_holistic_count = $conn->query($sql_holistic_count);
    while($result_holistic_count = $query_holistic_count->fetch_assoc()){


         echo "holistic_id: ".$result_holistic_count["holistic_id"];
         echo "<br>";
         echo "detail_id: ".$result_holistic_count["detail_id"];


         echo "<br>";
         echo "type_work_id: ";
         $arrange_nohn_id = $result_holistic_count["detail_id"];
         $sql_arrange_nohn = " SELECT * FROM tbl_arrange_nohn WHERE  arrange_nohn_id = $arrange_nohn_id ";
         $query_arrange_nohn = $conn->query($sql_arrange_nohn);
         $result_arrange_nohn = $query_arrange_nohn->fetch_assoc();
        echo $type_work_id = $result_arrange_nohn['type_work_id'];

        echo "<br>";
        $holistic_id = $result_holistic_count["holistic_id"];
        echo $sql_update = "UPDATE tbl_holistic_650912 SET type_work_id = '$type_work_id' WHERE tbl_holistic_650912.holistic_id = $holistic_id";
        $conn->query($sql_update);


         echo "<br>";
         echo "<br>";


    }
?>
