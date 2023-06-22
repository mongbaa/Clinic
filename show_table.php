<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบประเมินคะแนนนักศึกษาในคลินิก 2021 </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<?php
if (!empty($_GET['type_work_id'])) {
    $type_work_id = $_GET['type_work_id'];
} else {
    $type_work_id = "";
}
?>

<div class="container">


    7 สาขาแรก (OD, Xray, OPER, Prevent, OS, Perio, endo)

    <form name="myForm1" id="myForm1" action="" method="GET">
        <input name="order_id" type="hidden" value="<?php echo $order_id; ?>" />
        <select name="type_work_id" id="type_work_id" class="form-control select2" onchange="this.form.submit()" required>
            <option value=""> เลือก งานของสาขา </option>
            <?php
            include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
            $sql_type_work = "SELECT * FROM tbl_type_work";
            $query_type_work = $conn->query($sql_type_work);
            while ($result_type_work = $query_type_work->fetch_assoc()) {
            ?>
                <option value="<?php echo $result_type_work['type_work_id']; ?>" <?php if (!(strcmp($result_type_work['type_work_id'], $type_work_id))) {
                                                                                        echo "selected=\"selected\"";
                                                                                    } ?>>
                    <?php echo $result_type_work['type_work_name']; ?>
                </option>
            <?php
            }
            ?>
        </select>
    </form>

    <br>
    

    <?php
    $r = 0;
    include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
    $sql_form_main = "SELECT * FROM tbl_form_main where type_work_id = $type_work_id and form_main_status != 'N'";
    $query_form_main = $conn->query($sql_form_main);
    while ($result_form_main = $query_form_main->fetch_assoc()) {


        $tbl = $result_form_main['form_main_table']; // ชื่อตาราง
        $tbl_id = $tbl . "_id"; // Id ของตาราง
        $form_main_id = $result_form_main['form_main_id']; //รหัสฟอร์ม

        $r++;
    ?>

        <h2><span class='badge bg-info'>
                <?php echo $r;?>. <?php echo $result_form_main['form_main_name'];?> 
              
        </span></h2>

        <h3><span class='badge bg-success'>
                ประเภทฟอร์ม : 
                <?php
                $form_main_type = $result_form_main['form_main_type'];
                switch ($form_main_type) { // Harder page
                    case 1:
                        echo  "ฟอร์มประเมินมีผู้ป่วย";
                        break;
                    case 2:
                        echo  "กรณีไม่มีผู้ป่วย";
                        break;
                    default:
                        echo  "-";
                        break;
                }
                ?>
        </span></h3>


            <h4><span class='badge bg-warning'>
                ข้อมูล : 
                 <?php
                  $array_form_main_detail = json_decode($result_form_main['form_main_detail'], true);
                  if (in_array("t", $array_form_main_detail)) { echo "Tooth, "; }
                  if (in_array("s", $array_form_main_detail)) { echo "Surface, "; }
                  if (in_array("r", $array_form_main_detail)) { echo "Root, "; }
                  if (in_array("c", $array_form_main_detail)) { echo "Class "; }
                  ?>
            </span></h4>







        <table id="example3" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th Width="5%">
                        <div align="center">ลำดับ</div>
                    </th>
                    <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>

                    <?php
                    include "config.inc.php";
                    $sql_check_w = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id  and weight_type_id!=1";
                    $query_check_w = $conn->query($sql_check_w);
                    if ($row_check_w = $query_check_w->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  น้ำหนัก,ครั้ง,คะแนน ให้แสดง
                    ?>
                        <th Width="8%">
                            <div align="center">น้ำหนัก</div>
                        </th>
                    <?php } ?>


                    <th Width="8%">
                        <div align="center">คะแนน</div>
                    </th>


                    <?php
                    include "config.inc.php";
                    $sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
                    $query_check_ex = $conn->query($sql_check_ex);
                    if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
                    ?>
                        <th Width="5%">
                            <div align="center">Competency</div>
                        </th>
                    <?php } ?>


                    <?php
                    include "config.inc.php";
                    $sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
                    $query_check_ex = $conn->query($sql_check_ex);
                    if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Complete ให้แสดง
                    ?>
                        <th Width="5%">
                            <div align="center">Complete</div>
                        </th>
                    <?php } ?>



                    <th width="10%">
                        <div align="center">ผู้ประเมิน </div>
                    </th>
                    <th width="5%">
                        <div align="center">วันที่ </div>
                    </th>

                </tr>
            </thead>


            <tbody>
                <?php
                //echo $arrange_teacher_id;
                include "config.inc.php";
                $sql_form_detail = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id ";
                $sql_form_detail .= " ORDER BY form_detail_order ASC ";
                $query_form_detail = $conn->query($sql_form_detail);
                $i = 0;
                while ($row_form_detail = $query_form_detail->fetch_assoc()) {
                    $i++;
                    $field = $tbl . "_" . $row_form_detail['form_detail_field'];
                    $form_detail_id = $row_form_detail['form_detail_id'];
                ?>


                    <tr>
                        <td>
                            <?php echo $i; ?> <?php if(!empty($row_form_detail['form_detail_extra'])){ echo "Hidden"; } ?> 
                        </td>

                        <td><?php echo $row_form_detail['form_detail_topic']; ?> </td>


                        <?php if ($row_form_detail['weight_type_id'] == 2) { ?>
                            <td>
                                <div align="center"><?php echo $row_form_detail['form_detail_weight']; ?></div>
                                <?php if (isset($weight) && !empty($weight)) {  // หาก weight มีค่า ให้  value มี ค่า weight 
                                ?>

                                    <input type="hidden" name="<?php echo $field . "_weight"; ?>" value="<?php echo $weight; ?>">
                                    <?php //echo $field."_weight";
                                    ?>

                                <?php } else { // หาก weight ไม่มีค่า ให้  value มี ค่า form_detail_weight ของตัวมันเอง 
                                ?>

                                    <?php //echo $field."_weight";
                                    ?>
                                    <input type="hidden" name="<?php echo $field . "_weight"; ?>" value="<?php echo $row_form_detail['form_detail_weight']; ?>">
                                <?php } ?>
                            </td>
                        <?php } ?>




                        <?php if ($row_form_detail['weight_type_id'] == 3) { ?>

                            <td>
                                <?php echo $row_form_detail['form_detail_weight']; ?>
                            </td>
                            
                        <?php } ?>





                        <td>
                            <div align="center">
                                <?php $row_form_detail['score_type_id']; ?>
                                <?php $score_id = $row_form_detail['score_id']; ?>
                                <?php if ($row_form_detail['score_type_id'] == 1) { ?>
                                    <select name="<?php echo $field . "_grade"; ?>" class="form-control" <?php echo $disabled; ?>>
                                        <option value="">-- N/A --</option>
                                        <?php
                                        include "config.inc.php";
                                        $sql_score_d = "select  *  from tbl_score_detail where score_id=$score_id";
                                        $query_score_d = $conn->query($sql_score_d);
                                        while ($result_score_d = $query_score_d->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $result_score_d['score_detail_rate']; ?>" <?php
                                                                                                                $str = $grade;
                                                                                                                $score = $result_score_d['score_detail_rate'];
                                                                                                                if (strpos($str, $score) === 0) {
                                                                                                                    echo 'selected';
                                                                                                                }
                                                                                                                ?>>
                                                <?php echo $result_score_d['score_detail_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                                <?php // echo $field."_grade";
                                ?>
                            </div>
                            <input type="hidden" name="<?php echo $field . "_grades"; ?>" value="<?php echo $grade; ?>">

                        </td>


                        <?php
                        include "config.inc.php";
                        $sql_check_cy = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
                        $query_check_cy = $conn->query($sql_check_cy);
                        if ($row_check_cy = $query_check_cy->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
                        ?>
                            <td>
                                <?php if ($row_form_detail['form_detail_competency'] == "Y") { ?>
                                    <?php //echo $row_form_detail['form_detail_field']."_competency";
                                    ?>
                                    <input type="checkbox" name="<?php echo $field . "_competency"; ?>" class="form-control" value="checkbox" />
                                <?php } ?>
                            </td>

                        <?php } ?>



                        <?php
                        include "config.inc.php";
                        $sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
                        $query_check_ex = $conn->query($sql_check_ex);
                        if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คมีการเลือก  Competency ให้แสดง
                        ?>
                            <td>
                                <?php if ($row_form_detail['form_detail_complete'] == "Y") { ?>
                                    <?php //echo $row_form_detail['form_detail_field']."_complete";
                                    ?>
                                    <input type="checkbox" name="<?php echo $field . "_complete"; ?>" class="form-control" value="checkbox" />
                                <?php } ?>
                            </td>
                        <?php } ?>


                        <td>
                            <div align="center"></div>
                        </td>
                        <td>
                            <div align="center"> </div>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>



        </table>


        <br>
        <br>
        <hr>
        </hr>

    <?php } ?>


</div>