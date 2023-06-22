<?php include "header.php"; ?>
<?php
if (isset($_SESSION['sessid']) && !empty($_SESSION['level_user'])) {
} else {
  echo "<script type='text/javascript'>";
  echo  "alert('เช้าสู่ระบบก่อนใช้งาน....!');";
  echo "window.location='login.php'";
  echo "</script>";
}
?>
 

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">


<?php
function mixTextColor($length)
{
    $colors = array('default', 'primary', 'secondary', 'success', 'info', 'danger', 'warning');
    // $result = substr(str_shuffle($text), 0, $length); 
    for ($i = 0; $i < $length; $i++) {
        echo $colors[array_rand($colors)];
    }
}
?>
<style>
    .table-responsive {
        height: 500px;
        overflow: scroll;
    }

    thead tr:nth-child(1) th {
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
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

    th:first-child,


    td:first-child {
        position: sticky;
        left: 0px;
    }

    td:first-child {
        background-color: whitesmoke;
        color: black;
    }


    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        border-style: dotted;

    }
</style>
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
    $student_search = "";
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

if (isset($_GET['check_prosth_year'])) {
    $check_prosth_year = $_GET['check_prosth_year'];
} else {
    $check_prosth_year = 5;
}


$student_id = $student_search;


?>


<?php
include "config.inc.php";
$sql_student   =  " SELECT * FROM  tbl_student where student_id = '$student_id' ";
$sql_student  .=  " ORDER BY student_id ASC   ";
$query_student = $conn->query($sql_student);
if ($result_student = $query_student->fetch_assoc()) {

    $result_students = 1;

    $student_id = $result_student['student_id'];
    $student_name = $result_student['student_name'];
    $student_lastname = $result_student['student_lastname'];
    $student_level = $result_student['student_level'];
    $student_group = $result_student['student_group'];



    $type_work_id = 6; //Report Crown and Bridge


    // ข้อมูลงานที่มีในสาขาที่ส่งค่ามา
    $plan_oper_array = array();
    $sql_plan = " SELECT o.*, d.*, COUNT( d.detail_id ) AS count_detail, p.*, t.*, f.* ";
    $sql_plan  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
    $sql_plan  .=  " INNER JOIN (SELECT detail_id, order_id, plan_id, detail_type_work_id  FROM tbl_detail ) as d  ON  d.order_id = o.order_id";
    $sql_plan  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = d.plan_id";
    $sql_plan  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
    $sql_plan  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y') AS f  ON  f.form_main_id = p.form_main_id ";
    $sql_plan  .=  " group by d.plan_id ";

    //echo   $sql_plan;
    $query_plan = $conn->query($sql_plan);
    while ($result_plan = $query_plan->fetch_assoc()) {

        //echo $result_plan['plan_id'];

        $plan_oper_array[] = array(
            'plan_id' => $result_plan['plan_id'],
            'plan_name' => $result_plan['plan_name'],
            'count_detail' => $result_plan['count_detail']
        );
    }



    // ข้อมูลงานไม่มีผู้ป่วย
    $plan_array_nohn = array();
    $sql_nohn = " SELECT count(n.arrange_nohn_id) as count_arrange_nohn_id, p.plan_id, p.plan_name FROM";
    $sql_nohn  .=  " (SELECT * FROM tbl_arrange_nohn WHERE student_id = $student_id ) as n ";
    $sql_nohn  .=  " INNER JOIN  (SELECT * FROM  tbl_plan  WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = n.plan_id ";
    $sql_nohn  .=  " GROUP BY n.plan_id ASC ";
    $query_nohn = $conn->query($sql_nohn);
    while ($result_nohn = $query_nohn->fetch_assoc()) {

        $plan_array_nohn[] = array(
        'plan_id' => $result_nohn['plan_id'],
        'plan_name' => $result_nohn['plan_name'],
        'count_detail' => $result_nohn['count_arrange_nohn_id']
        );

    }

        

} else {

    $student_name = "";
    $student_lastname = "";
    $student_level = "";
}


$conn->close();
?>




<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1> Report > <?php echo $student_id; ?> : <?php echo $student_name; ?> <?php echo $student_lastname; ?> ชั้นปี <?php echo $student_level; ?></h1>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>



<!-- Main content -->
<section class="content">
    <div class="container-fluid">


        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-search"></i> ค้นหาข้อมูล </h3>
            </div>
            <div class="card-body">
                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <?php for ($i = 4; $i <= 6; $i++) { ?>
                                <a href="?level_search=<?php echo $i; ?>" <?php if ($level_search == $i) { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ชั้นปีที่ <?php echo $i; ?> </a>
                            <?php } ?>
                            <a href="?level_search=all&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == "all") { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-default" <?php } ?>> ทุกชั้นปี </a>
                        </div>

                        <input type="hidden" name="level_search" value="<?php echo $level_search; ?>">





                        <div class="col-sm-3">
                            <div class="form-group">
                                <select name="student_search" id="student_search" class="form-control select2" onchange="this.form.submit()" required>

                                    <option value=""> เลือก </option>
                                    <?php include "config.inc.php";
                                    $sql_student = "SELECT * FROM  tbl_student where student_active = 1 and student_level = $level_search";
                                    $query_student = $conn->query($sql_student);
                                    while ($result_student  = $query_student->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $result_student['student_id']; ?>" <?php if (!(strcmp($result_student['student_id'], $student_id))) {
                                                                                                            echo "selected=\"selected\"";
                                                                                                        } ?>>
                                            <?php echo $result_student['student_id']; ?> <?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></option>
                                    <?php  }  ?>
                                </select>
                            </div>
                        </div>




                        <div class="col-sm-2">
                            <button class="btn btn-info" type="submit">Search</button>
                        </div>

                    </div>
                </form>
            </div><!-- /.card-body -->
        </div><!-- /.card -->



        <?php if (!empty($student_id)) { ?>

            <div class="row">


                <div class="col-lg-3 col-6">
                    <div class="card card-default color-palette-box">
                        <div class="card-header">
                            <h3 class="card-title"> งานและรายละเอียด </h3>
                            <div align="right">
                                <img src="../pic_students/<?php echo $student_id; ?>.jpg" width="100" height="120" alt="<?php echo $student_id; ?>" />
                            </div>
                        </div>

                        <div class="card-body">

                            <?php
                            foreach ($plan_oper_array as $values => $data) {
                                $plan_id =  $data['plan_id'];
                                $plan_name =  $data['plan_name'];
                                $count_detail =  $data['count_detail'];
                            ?>

                                <H4><?php echo $data['plan_name']; ?> (<?php echo $data['count_detail']; ?>) / <?php echo $data['plan_id']; ?></H4>
                                
                                <?php
                                include "config.inc.php";
                                $sql_detail = " SELECT o.*, d.*, p.* , t.* , f.*, causes_pay.*";
                                $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                                $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE plan_id = $plan_id) as d  ON  d.order_id = o.order_id";
                                $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_plan WHERE type_work_id = $type_work_id  ) as p  ON  p.plan_id = d.plan_id";
                                $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                                $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1  ) AS f  ON  f.form_main_id = p.form_main_id ";
                                $sql_detail  .=  " LEFT JOIN tbl_causes_of_pay AS  causes_pay on d.causes_of_pay_id = causes_pay.causes_of_pay_id ";
                                $sql_detail  .=  " ORDER BY d.detail_id ASC ";
                                $query_detail = $conn->query($sql_detail);
                                while ($result_detail = $query_detail->fetch_assoc()) {

                                    $tbl = $result_detail['form_main_table']; // ชื่อตาราง
                                    $tbl_id = $tbl . "_id"; // Id ของตาราง
                                   // echo " : ";
                                    $detail_id = $result_detail['detail_id']; //รหัสงาน
                                    $form_main_id = $result_detail['form_main_id']; //รหัสฟอร์ม
                                    $detail_score = $result_detail['detail_score']; //คะแนนรวม
                                    $detail_weight = $result_detail['detail_weight']; //น้ำหนักรวม
                                    $detail_total = $result_detail['detail_total']; //คะแนนรวม / น้ำหนักรวม


                                    //เช็คการประเมินคะแนน
                                    $sql_form_check   = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                    $sql_form_check  .=  " ORDER BY $tbl_id  ASC ";
                                    $query_form_check = $conn->query($sql_form_check);
                                    if ($row_form_check = $query_form_check->fetch_assoc()) {
                                     
                                ?>

                                    <a href="?level_search=<?php echo $level_search; ?>&student_search=<?php echo $student_search; ?>&plan_id=<?php echo $plan_id; ?>&detail_id_s=<?php echo $detail_id; ?>&tbl_s=<?php echo $tbl; ?>&tbl_id_s=<?php echo $tbl_id; ?>&form_main_id_s=<?php echo $form_main_id; ?>&check_prosth_year=<?php echo $check_prosth_year; ?>">

                                        <i class="fas fa-user"></i>
                                        HN : <?php echo $result_detail['HN']; ?> :
                                        <?php echo $result_detail['pname']; ?><?php echo $result_detail['fname']; ?>
                                        <?php echo $result_detail['lname']; ?>


                                        <?php if (!empty($result_detail['detail_surface'])) { ?>
                                            Surface : <?php echo $result_detail['detail_surface']; ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail['detail_root'])) { ?>
                                            Root : <?php echo $result_detail['detail_root']; ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail['class_id'])) { ?>
                                            Class : <?php echo nameClass::get_class_name($result_detail['class_id']); ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail['detail_tooth'])) {  ?>

                                            <?php
                                            $array_detail_tooth = (array)json_decode($result_detail['detail_tooth']);

                                            foreach ($array_detail_tooth as $id => $value) {
                                            ?>
                                                <span class="badge badge-success"> <?php echo $value; ?></span>

                                            <?php }  ?>

                                        <?php
                                        }
                                        ?>


                                        <span class="badge badge-info"> Date : <?php echo $result_detail['detail_date_work']; ?></span>

                                        <?php if ($result_detail['detail_date_complete'] != "0000-00-00") { ?>

                                            
                                        <?php if ($result_detail['causes_of_pay_detail'] == 7) { ?>
                                            <span class="badge badge-danger"> Complete <?php echo $result_detail['detail_date_complete']; ?></span>
                                        <?php }else{ ?>
                                            <span class="badge badge-danger"> จ่ายออก : <?php echo $result_detail['causes_of_pay_detail']; ?> </span> 
                                        <?php }  ?>


                                        <?php }  ?>

                                        <?php if ($result_detail['detail_competency'] == 1) { ?>
                                            <span class="badge badge-success"> Competency </span>
                                        <?php }  ?>


                                    </a>

                                    <?php } //เช็คการประเมินคะแนน ?>


                                    <br>
                                    <br>

                                <?php }
                                $conn->close(); ?>
                                <br>
                            <?php } ?>













                            

                            



                        </div>
                    </div>

                </div>



                <?php
         
                if (isset($_GET['tbl_s'])) {
                    $tbl_s  = $_GET['tbl_s'];
                } else {
                    $tbl_s = "";
                }
                if (isset($_GET['tbl_id_s'])) {
                    $tbl_id_s       = $_GET['tbl_id_s'];
                } else {
                    $tbl_id_s = 0;
                }
                if (isset($_GET['form_main_id_s'])) {
                    $form_main_id_s = $_GET['form_main_id_s'];
                } else {
                    $form_main_id_s = "";
                }
                if (isset($_GET['detail_id_s'])) {
                    $detail_id_s    = $_GET['detail_id_s'];
                } else {
                    $detail_id_s = "";
                }



                if (!empty($tbl_s)) { ?>
                    <div class="col-lg-9 col-12">

                        <div class="card card-default color-palette-box">
                            <div class="card-header">
                                <h3 class="card-title"> Competency </h3>
                            </div>

                            <div class="card-body">

                                <a href="competency_cb_export.php?tbl_s=<?php echo $tbl_s; ?>&tbl_id_s=<?php echo $tbl_id_s; ?>&form_main_id_s=<?php echo $form_main_id_s; ?>&detail_id_s=<?php echo $detail_id_s; ?>&student_search=<?php echo $student_search; ?>"  target="_blank" class="btn btn-info mb-3"> Export </a>
                           
                                <div class="row">
                                    <?php 
                                        $summary_full =  0;
                                        include "config.inc.php";
                                        $sql_detail_show = " SELECT  d.*, p.*, c.*, o.*";
                                        $sql_detail_show  .=  " FROM        tbl_detail        AS d ";
                                        $sql_detail_show  .=  " INNER JOIN  tbl_plan          AS p  ON  d.plan_id = p.plan_id";
                                        $sql_detail_show  .=  " LEFT  JOIN  tbl_causes_of_pay AS c  ON  d.causes_of_pay_id = c.causes_of_pay_id ";
                                        $sql_detail_show  .=  " INNER JOIN (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ON  d.order_id = o.order_id";
                                        $sql_detail_show  .=  " WHERE d.detail_id = $detail_id_s";
                                        $query_detail_show = $conn->query($sql_detail_show);
                                        $result_detail_show = $query_detail_show->fetch_assoc();
                                        $conn->close();
                                        $detail_competency = $result_detail_show['detail_competency'];
                                    ?>
                                    <div class="col-sm-12">

                                        <i class="fas fa-user"></i>
                                        HN : <?php echo $result_detail_show['HN']; ?> :
                                        <?php echo $result_detail_show['pname']; ?><?php echo $result_detail_show['fname']; ?>
                                        <?php echo $result_detail_show['lname']; ?>


                                        <?php if (!empty($result_detail_show['plan_name'])) { ?>
                                            Plan : <?php echo $result_detail_show['plan_name']; ?>
                                        <?php } ?>


                                        <?php if (!empty($result_detail_show['detail_surface'])) { ?>
                                            Surface : <?php echo $result_detail_show['detail_surface']; ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail_show['detail_root'])) { ?>
                                            Root : <?php echo $result_detail_show['detail_root']; ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail_show['class_id'])) { ?>
                                            Class : <?php echo nameClass::get_class_name($result_detail_show['class_id']); ?>
                                        <?php } ?>

                                        <?php if (!empty($result_detail_show['detail_tooth'])) {  ?>

                                            <?php
                                            $array_detail_tooth = (array)json_decode($result_detail_show['detail_tooth']);

                                            foreach ($array_detail_tooth as $id => $value) {
                                            ?>
                                                <span class="badge badge-success"> <?php echo $value; ?></span>

                                            <?php }  ?>

                                        <?php
                                        }
                                        ?>


                                        <span class="badge badge-info"> Date : <?php echo $result_detail_show['detail_date_work']; ?></span>

                                        <?php if ($result_detail_show['detail_date_complete'] != "0000-00-00") { ?>
                                        

                                        <?php if ($result_detail_show['causes_of_pay_detail'] == 7) { ?>
                                        <span class="badge badge-danger"> Complete <?php echo $result_detail_show['detail_date_complete']; ?></span>
                                        <?php }else{ ?>
                                            <span class="badge badge-danger"> จ่ายออก : <?php echo $result_detail_show['causes_of_pay_detail']; ?> </span> 
                                        <?php }  ?>




                                        <?php }  ?>

                                        <?php if ($result_detail_show['detail_competency'] == 1) { ?>
                                            <span class="badge badge-success"> Competency </span>
                                        <?php }  ?>

                                    </div>

                                </div>

                                <br>



                                <form id="form1" name="form1" method="post" action="">





                                    <div class="row">

                                        <input type="hidden" name="student_id" value="<?php echo $student_search; ?>">
                                        <input type="hidden" name="detail_id" value="<?php echo $detail_id_s; ?>">

                                        <div class="col-sm-8">
                                            <div class="form-group clearfix">
                                                <div class="icheck-success d-inline">

                                                    <input type="checkbox" name="detail_competency" id="detail_competency" <?php if ($detail_competency == 1) {
                                                                                                                                echo "checked";
                                                                                                                            } ?> value="1">
                                                    <label for="detail_competency">


                                                        <?php if ($detail_competency == 1) {
                                                            echo '<font color="green"> Competency <i class="fas fa-check-circle"></i> </font>';
                                                        } else {
                                                            echo '<font color="red">   Competency <i class="fas fa-times-circle"></i>  </font>';
                                                        } ?>



                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <button name="submit" type="submit" class="btn btn-success mb-3" style="float:right;" value="submit"> <i class="fas fa-save"></i> บันทึก Competency </button>
                                        </div>
                                    </div>

                                </form>


                                <?php echo $detail_id_s; ?>

                                <div style="overflow-x:auto;">
                                    <table id="example3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th Width="3%">
                                                    <div align="center">ลำดับ</div>
                                                </th>
                                                <th Width="30%">หัวข้อการประเมิน / น้ำหนัก </th>

                                                <?php
                                                include "config.inc.php";
                                                $i_count = 0;
                                                $sql_form_re = "SELECT * FROM tbl_" . $tbl_s . " where detail_id = $detail_id_s";
                                                $sql_form_re  .=  " ORDER BY $tbl_id_s  ASC ";
                                                $query_form_re = $conn->query($sql_form_re);
                                                while ($row_form_re = $query_form_re->fetch_assoc()) {
                                                    $i_count++;
                                                    $last_date = $row_form_re['last_date'];
                                                    $id_form_re = $row_form_re["{$tbl_id_s}"];
                                                ?>
                                                    <th Width="7%">
                                                        <div align="center"><?php echo $i_count; ?></div>
                                                    </th>
                                                <?php }
                                                $conn->close(); // $sql_form_re   
                                                ?>
                                                <th Width="5%"> ครั้ง </th>
                                                <!--   <th Width="5%"> คะแนนเต็ม </th> -->
                                                <!--    <th Width="5%"> คะแนนเต็มจริง </th>-->
                                                <!--    <th Width="5%"> คะแนนที่ได้ </th>-->
                                                <th Width="5%"> คะแนน</th>
                                                <!--    <th Width="5%"> % </th> -->
                                            </tr>

                                        </thead>


                                        <tbody>



                                            <?php
                                            include "config.inc.php";
                                            $i_re = 0;
                                            $sum_score_total = 0;
                                            $sum_score = 0;
                                            $sum_weight_total = 0;

                                            $st = 0;
                                           

                                            $summary_score  =  0;
                                            $summary_full =  0;


                                            // หาชื่อฟิลด์
                                            $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order, fd.form_detail_weight";
                                            $sql_form_detail_re  .=  " FROM (SELECT f.* FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id_s') AS fd ";
                                            $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                                            $query_form_detail_re = $conn->query($sql_form_detail_re);
                                            while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                                $i_re++;
                                                $field = $tbl_s . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                                                $form_detail_id = $row_form_detail_re['form_detail_id'];
                                            ?>


                                                <tr>

                                                    <td>

                                                        <?php echo $i_re; ?>
                                                        <?php //echo $form_detail_id; 
                                                        ?>

                                                    </td>


                                                    <td><?php echo $row_form_detail_re['form_detail_topic']; ?> / (<?php echo $row_form_detail_re['form_detail_weight']; ?>) </td>


                                                    <?php
                                                    $total_stepp_full = 0;
                                                    $total_score = 0;
                                                    $total_score_full = 0;
                                                    $total_full_stepp = 0;

                                                  
                                                


                                                  
                                                    $sum_weight_total = 0;
                                                    $sum_score_total = 0;
                                                    $sum_score = 0;
                                                    $sql_form_re_ = "SELECT * FROM tbl_" . $tbl_s . " where detail_id = $detail_id_s";
                                                    $sql_form_re_  .=  " ORDER BY $tbl_id_s  ASC ";
                                                    $query_form_re = $conn->query($sql_form_re_);
                                                    while ($row_form_re = $query_form_re->fetch_assoc()) {


                                                        $last_date = $row_form_re['last_date'];
                                                        $id_form_re = $row_form_re["{$tbl_id_s}"];
                                                        $field_grade = $field . "_grade";  //_grade
                                                        $grade = $row_form_re["{$field_grade}"];


                                                        if (isset($grade) && !empty($grade)) {
                                                            $field_weights = $field . "_weight";   //_weight
                                                            $weight = $row_form_re["{$field_weights}"];
                                                            $field_teacher = $field . "_teacher";  //_teacher
                                                            $teacher = $row_form_re["{$field_teacher}"];
                                                            $field_date = $field . "_date";  //_date
                                                            $datee = $row_form_re["{$field_date}"];
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
                                                        } else if ($grade == "B+") {
                                                            $score = 3.5;
                                                            $stepp = 1;
                                                            $weight_ss =  $weight;
                                                            $claass = "table-success";
                                                        } else if ($grade == "B") {
                                                            $score = 3;
                                                            $stepp = 1;
                                                            $weight_ss =  $weight;
                                                            $claass = "table-success";
                                                        } else if ($grade == "C+") {
                                                            $score = 2.5;
                                                            $stepp = 1;
                                                            $weight_ss =  $weight;
                                                            $claass = "table-success";
                                                        } else if ($grade == "C") {
                                                            $score = 2;
                                                            $stepp = 1;
                                                            $weight_ss =  $weight;
                                                            $claass = "table-success";
                                                        } else if ($grade == "F") {
                                                            $score = 0;
                                                            $stepp = 1;
                                                            $weight_ss =  $weight;
                                                            $claass = "table-success";
                                                        } else {
                                                            $score = 0;
                                                            $stepp = 0;
                                                            $weight_ss =  0;
                                                            $claass = "";
                                                        }



                                                        $sum_score = $weight * $score;
                                                        $sum_stepp = $stepp++; // รวม จำนวนครั้ง


                                                        $sum_score_full = $weight * 4;   //คะแนนเต็ม

                                                    ?>



                                                        <td class="<?php echo $claass; ?>">
                                                            <div align="center">
                                                                <a href="#" data-toggle="tooltip" title=" <?php echo $weight; ?> x <?php echo $grade; ?> (<?php echo $score; ?>) | <?php echo nameTeacher::get_teacher_name($teacher); ?> | <?php echo $datee; ?> | "> <?php echo  $sum_score; ?> </a>
                                                            </div>
                                                        </td>




                                                    <?php
                                                        $sum_weight_total = $sum_weight_total + $weight_ss;
                                                        $sum_score_total = $sum_score_total + $sum_score;

                                                        $total_score_full = $total_score_full + $sum_score_full;   //คะแนนเต็มในขั้นตอนรวมกัน
                                                        $total_score = $total_score + $sum_score;  //คะแนนรวมในขั้นตอน
                                                        $total_stepp_full = $total_stepp_full + $sum_stepp;   //จำนวนครั้งในขั้นตอนรวมกัน
                                                    }


                                                    ?>

                                                    <td class="table-danger">
                                                        <div align="center"><?php echo  $total_stepp_full; ?></div>
                                                    </td>

                                                    <!--  
                                                        <td class="table-warning">
                                                            <div align="center"><?php echo  $total_score_full; ?></div>
                                                        </td>
                                                         -->

                                                    <!--  
                                                        <td class="table-success">
                                                            <div align="center">
                                                                <?php
                                                                if ($total_stepp_full == 0) {
                                                                    $total_full_stepp =  0;
                                                                } else {
                                                                    $total_full_stepp =  $total_score_full / $total_stepp_full; //คะแนนเต็มหารจำนวนครั้ง
                                                                }
                                                                echo $total_full_stepp;
                                                                ?>
                                                            </div>
                                                        </td>
                                                        -->






                                                    <!-- 
                                                    <td class="table-info">
                                                        <div align="center"><?php echo  $total_score; ?></div>
                                                    </td>
                                                        -->

                                                    <td class="table-success">
                                                        <div align="center">
                                                            <?php
                                                            if ($total_stepp_full == 0) {
                                                                $total_score_stepp =  0;
                                                            } else {
                                                                $total_score_stepp =  $total_score / $total_stepp_full; //คะแนนจริงที่หารจำนวนครั้ง
                                                            }
                                                            echo $total_score_stepp;
                                                            ?>
                                                        </div>
                                                    </td>

                                                    <!-- 
                                                    <td class="table-success">
                                                        <div align="center">
                                                            <?php
                                                            if ($total_score_full == 0) {
                                                                $total_full_full =  0;
                                                            } else {
                                                                $total_full_full =  ($total_score_stepp / $total_score_full) * 100;
                                                            }
                                                            echo $total_full_full;
                                                            ?> %
                                                        </div>
                                                    </td>
                                                    -->
                                                </tr>



                                            <?php


                                                $summary_score  =  $summary_score + $total_score_stepp;
                                                $summary_full  =   $summary_full  + $total_full_stepp;
                                            } //row_form_detail_re
                                            ?>


                                        </tbody>

                                    </table>
                                </div>

                                <?php echo $summary_score; ?> /   <?php echo $summary_full; ?> =  
                                
                                <?php   
                                if(!empty($summary_score)){
                                $st = $summary_score / $summary_full;    
                                }else{
                                $st = 0; 
                                }
                                ?> 
                              

                                <?php  echo @$st = round($st,4); ?> ค่าเฉลี่ย
                                <br>
                                <?php  $st100 = ($st*100) ; echo  number_format($st100,2);?>  %

                            </div>
                        </div>

                    </div>
                    <?php
                    $sum_score_total = 0;
                    $conn->close(); ?>
                <?php }  ?>



            </div> <!-- ./row -->

        <?php }  ?>




        <?php
        if (!empty($_POST['submit'])) {

            include "config.inc.php";



            if (!empty($_POST['detail_id'])) {
                $detail_id = $_POST['detail_id'];
            } else {
                $detail_id = 0;
            }


            if (!empty($_POST['detail_competency'])) {
                $detail_competency = $_POST['detail_competency'];
            } else {
                $detail_competency = 0;
            }



            if (!empty($detail_id)) {

                $sql = "UPDATE tbl_detail SET detail_competency = '$detail_competency'  WHERE detail_id = $detail_id";
                $conn->query($sql);
            }

            $conn->close();

            echo "<script type='text/javascript'>";
            //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
            echo "window.history.back(1)";
            echo "</script>";
        }
        ?>




<?php if(!empty($student_idqq)){?>
        <div class="card card-primary color-palette-box">
				
              <div class="card-header">
                <h3 class="card-title">	<i class="fas fa-list-alt"></i> ข้อมูลประวัติการส่งงานประเมินคะแนน </h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><div align="center">ลำดับที่</div></th>
                                    <th>ลงปฏิบัติงาน</th>
                                    <th>งาน</th>
                                    <th>ประเภท</th>
                                    <th>วันที่ลงปฎิบัติงาน</th>
                                    <th>วันเวลาส่ง</th>
                                    <th>สถานะการประเมิน</th>
                                </tr>
                            </thead>
                                
                            <tbody>        
                                <?PHP
                                include "config.inc.php";
                                $sql   = " SELECT a.*, d.*, p.*, t.*, o.* FROM  ( SELECT * FROM tbl_arrange where  arrange_type = 0 )  as a  ";
                                $sql  .= " INNER JOIN  tbl_detail   AS d  ON  a.detail_id = d.detail_id ";
                                $sql  .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id ";
                                $sql  .= " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                                $sql  .= " INNER JOIN  ( SELECT *  FROM tbl_order WHERE  student_id = $student_id   )  AS o  ON  d.order_id = o.order_id ";
                                $sql  .= " WHERE t.type_work_id = 6 ORDER BY a.arrange_id DESC";
                                $query = $conn->query($sql);
                                $i=0;
                                while($result = $query->fetch_assoc())
                                {
                                $i++;
                                ?>

                                <tr class="odd gradeX"> 
                                <td align="center"><?=$i;?></td>
                                <td>  
                                <h5><span class='badge bg-success'><?php echo nameType_work::get_type_work_name($result['detail_type_work_id']);?> </span></h5>
                                <?php echo $result['detail_id'];?>
                                </td>
                                <td>  
                                    <h5><span class='badge bg-info'><?php echo nameType_work::get_type_work_name($result['type_work_id']);?></span></h5>

                                    <?php echo $result['plan_name'];?>  

                                            <?php if (!empty($result['detail_surface'])) { ?>
                                            <br>  Surface : <?php echo $result['detail_surface']; ?>
                                            <?php }?>

                                            <?php if (!empty($result['detail_root'])) { ?>
                                            <br> Root : <?php echo $result['detail_root']; ?>
                                            <?php }?>

                                            <?php if (!empty($result['class_id'])) { ?>
                                            <br> Class : <?php  echo nameClass::get_class_name($result['class_id']);?> 
                                            <?php }?>

                                        
                                            <?php if (!empty($result['detail_tooth'])) {  ?>
                                            
                                                <?php
                                                $array_detail_tooth = (array)json_decode($result['detail_tooth']);
                                                $toothh ="";
                                                foreach ($array_detail_tooth as $id => $value) {
                                                $toothh .= $value.", ";
                                                } 
                                                ?>
                                            <br> Tooth :   <?php echo substr($toothh, 0 ,-2);?>
                                            <br>
                                            <?php
                                            }
                                            ?>
                                </td>


                                <td>
                                        <?php
                                            $arrange_type = $result['arrange_type'];
                                            switch ($arrange_type) { // Harder page
                                                case 0:
                                                    echo  "<h5><span class='badge bg-info'>Clinic</span></h5>";
                                                    break;
                                                case 1:
                                                    echo  "<h5><span class='badge bg-danger'>LAB</span></h5>";
                                                    break;
                                                default:
                                                    echo  "<i class='fas fa-history'></i> -";
                                                    break;
                                            }
                                        ?>
                                </td>

                                <td> <?php echo $result['arrange_date']; ?> </td>
                                <td> <?php echo $result['arrange_record_date'];?> <?php echo $result['arrange_time'];?> </td>

                                <td>
                                    <?php
                                        $arrange_check_eval = $result['arrange_check_eval'];
                                        switch ($arrange_check_eval) { // Harder page
                                            case 1:
                                                echo  "<i class='fas fa-check-circle' style='font-size:18px;color:#27AE60'> ประเมินคะแนนแล้ว </i>";
                                                break;
                                            case 0:
                                                echo  "<i class='fas fa-times-circle' style='font-size:18px;color:red'> รอรับการประเมิน </i>";
                                                break;
                                            default:
                                                echo  "<i class='fas fa-history'></i> -";
                                                break;
                                        }
                                    ?>
                                </td>

                                
                            </tr>

                                
                            <?php }?>
                                
                            </tbody>
                    </table>
            
              </div>
              <!-- /.card-body -->
        </div>






      
           
            <div class="card card-primary color-palette-box">
                            

                
                        <div class="card-header">
                            <h3 class="card-title">	<i class="fas fa-list-alt"></i> ข้อมูลประวัติการส่งงานประเมินคะแนน LAB </h3>
                        </div>
                    <!-- /.card-header -->
                    
                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th><div align="center">ลำดับที่</div></th>
                            <th>ลงปฏิบัติงาน</th>
                            <th>งาน</th>
                            <th>ประเภท</th>
                            <th>วันที่ลงปฎิบัติงาน</th>
                            <th>วันเวลาส่ง</th>
                            <th>สถานะการประเมิน</th>
                        </tr>
                        </thead>
                            
                        <tbody>      
                        <?PHP
                        include "config.inc.php";
                        $sql   = " SELECT a.*, d.*, p.*, t.*, o.* FROM  ( SELECT * FROM tbl_arrange where  arrange_type = 1 )  as a  ";
                        $sql  .= " INNER JOIN  tbl_detail   AS d  ON  a.detail_id = d.detail_id ";
                        $sql  .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id ";
                        $sql  .= " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                        $sql  .= " INNER JOIN  ( SELECT *  FROM tbl_order WHERE  student_id = $student_id   )  AS o  ON  d.order_id = o.order_id ";
                        $sql  .= " WHERE t.type_work_id = 6 ORDER BY a.arrange_id DESC";
                        $query = $conn->query($sql);
                        $i=0;
                        while($result = $query->fetch_assoc())
                        {
                        $i++;
                        ?>

                            <tr class="odd gradeX"> 
                            <td align="center"><?=$i;?></td>

                            <td>  
                            <h5><span class='badge bg-success'><?php echo nameType_work::get_type_work_name($result['detail_type_work_id']);?></span></h5>
                            <?php echo $result['detail_id'];?>
                            </td>
                            <td>  
                            <h5><span class='badge bg-info'><?php echo nameType_work::get_type_work_name($result['type_work_id']);?></span></h5>

                            <?php echo $result['plan_name'];?>  

                                    <?php if (!empty($result['detail_surface'])) { ?>
                                    <br>  Surface : <?php echo $result['detail_surface']; ?>
                                    <?php }?>

                                    <?php if (!empty($result['detail_root'])) { ?>
                                    <br> Root : <?php echo $result['detail_root']; ?>
                                    <?php }?>

                                    <?php if (!empty($result['class_id'])) { ?>
                                    <br> Class : <?php  echo nameClass::get_class_name($result['class_id']);?> 
                                    <?php }?>
                                    <?php if (!empty($result['detail_tooth'])) {  ?>
                                        <?php
                                        $array_detail_tooth = (array)json_decode($result['detail_tooth']);
                                        $toothh ="";
                                        foreach ($array_detail_tooth as $id => $value) {
                                        $toothh .= $value.", ";
                                        } 
                                        ?>
                                    <br> Tooth :   <?php echo substr($toothh, 0 ,-2);?>
                                    <br>
                                    <?php
                                    }
                                    ?>
                            </td>


                            <td>
                                <?php
                                    $arrange_type = $result['arrange_type'];
                                    switch ($arrange_type) { // Harder page
                                        case 0:
                                            echo  "<h5><span class='badge bg-info'>Clinic</span></h5>";
                                            break;
                                        case 1:
                                            echo  "<h5><span class='badge bg-danger'>LAB</span></h5>";
                                            break;
                                        default:
                                            echo  "<i class='fas fa-history'></i> -";
                                            break;
                                    }
                                ?>
                            </td>



                            <td><?php echo $result['arrange_date'];?> </td>
                            <td><?php echo $result['arrange_record_date'];?> <?php echo $result['arrange_time'];?> </td>
                            <td>
                        
                            <?php
                                    $arrange_check_eval = $result['arrange_check_eval'];
                                    switch ($arrange_check_eval) { // Harder page
                                        case 1:
                                            echo  "<i class='fas fa-check-circle' style='font-size:18px;color:#27AE60'> ประเมินคะแนนแล้ว </i>";
                                            break;
                                        case 0:
                                            echo  "<i class='fas fa-times-circle' style='font-size:18px;color:red'> รอรับการประเมิน </i>";
                                            break;
                                        default:
                                            echo  "<i class='fas fa-history'></i> -";
                                            break;
                                    }
                                    ?>
                        </td>
                        
                        
                        </tr>

                        
                        <?php }?>
                        
                        </tbody>
                    </table>
                    
                        </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
<?php } ?>

    </div>
</section>


<?php include "footer.php"; ?>
<!-- page script Tooltip -->
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<!-- page script Tooltip -->


