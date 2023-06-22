<?php include "header.php"; ?>


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



    $type_work_id = 8; //Report Prosthodontics

    // ข้อมูลงานที่มีในสาขาที่ส่งค่ามา
    $plan_oper_array = array();

    include "config.inc.php";
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


                        <div class="col-sm-2">
                            <div class="form-group">
                                <select name="check_prosth_year" id="check_prosth_year" class="form-control select2" required>
                                    <option value=""> เลือกชั้นปี </option>
                                    <option value="5" <?php if (!(strcmp(5, $check_prosth_year))) {
                                                            echo "selected=\"selected\"";
                                                        } ?>> ปี 5 </option>
                                    <option value="6" <?php if (!(strcmp(6, $check_prosth_year))) {
                                                            echo "selected=\"selected\"";
                                                        } ?>> ปี 6 </option>
                                </select>
                            </div>
                        </div>



                        <div class="col-sm-3">
                            <div class="form-group">
                                <select name="student_search" id="student_search" class="form-control select2" onchange="this.form.submit()" required>

                                    <option value=""> เลือก </option>
                                    <?php include "config.inc.php";
                                    $sql_student = "SELECT * FROM  tbl_student where student_status = 0 and student_level = $level_search";
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

                                    echo    $tbl = $result_detail['form_main_table']; // ชื่อตาราง
                                    $tbl_id = $tbl . "_id"; // Id ของตาราง
                                    echo " : ";

                                    echo $detail_id = $result_detail['detail_id']; //รหัสงาน
                                    $form_main_id = $result_detail['form_main_id']; //รหัสฟอร์ม

                                    $detail_score = $result_detail['detail_score']; //คะแนนรวม
                                    $detail_weight = $result_detail['detail_weight']; //น้ำหนักรวม
                                    $detail_total = $result_detail['detail_total']; //คะแนนรวม / น้ำหนักรวม




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
                                            <span class="badge badge-danger"> Complete <?php echo $result_detail['detail_date_complete']; ?></span>
                                            <?php echo $result_detail['causes_of_pay_detail']; ?>



                                        <?php }  ?>

                                        <?php if ($result_detail['detail_competency'] == 1) { ?>
                                            <span class="badge badge-success"> Competency </span>
                                        <?php }  ?>


                                    </a>
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
                //  echo $_GET['tbl_s'];

                //echo $tbl_s = isset($_GET['tbl_s']) ? $tbl_s : "default";




                if (isset($_GET['tbl_s'])) {
                    $tbl_s          = $_GET['tbl_s'];
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
                                <h3 class="card-title"> เลือก Step ที่ได้รับคะแนน</h3>
                            </div>

                            <div class="card-body">

                                <?php

                                include "config.inc.php";
                                $sql_check_prosth = "SELECT * FROM tbl_check_prosth where detail_id = $detail_id_s and check_prosth_year = $check_prosth_year";
                                $query_check_prosth = $conn->query($sql_check_prosth);
                                if ($row_check_prosth = $query_check_prosth->fetch_assoc()) {

                                    $check_prosth_id = $row_check_prosth['check_prosth_id'];

                                    $form_detail_id = $row_check_prosth['form_detail_id'];

                                    if (!empty($form_detail_id)) {
                                        $array_row_field = json_decode("$form_detail_id");
                                    } else {
                                        $jsond = '[]';
                                        $array_row_field =  json_decode("$jsond");
                                    }

                                    $check_complete = $row_check_prosth['check_complete'];

                                    $check_prosth_weight_ss  = $row_check_prosth['check_prosth_weight'];
                                    $check_prosth_score_ss  = $row_check_prosth['check_prosth_score'];
                                } else {

                                    $form_detail_id =  "";
                                    $check_prosth_id = "";
                                    $jsond = '[]';
                                    $array_row_field = json_decode("$jsond");

                                    $check_complete = 0;


                                    $check_prosth_weight_ss = 0;



                                    $check_prosth_score_ss  = 0;
                                }


                                //เช็ค ปิดเคสการคิดคะแนนในปีถัดไป (ไม่สามารใช้ฟอร์มงานคิดคะแนนได้ในครั้งถัดไป)
                                $sql_check_prosth_close  = "SELECT * FROM tbl_check_prosth where detail_id = $detail_id_s";
                                $query_check_prosth_close  = $conn->query($sql_check_prosth_close);
                                if ($row_check_prosth_close  = $query_check_prosth_close->fetch_assoc()) {
                                    $check_prosth_close = $row_check_prosth_close['check_prosth_close'];
                                } else {
                                    $check_prosth_close = 0;
                                }



                                $conn->close();

                                ?>





                                <div class="row">

                                    <?php
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
                                            <span class="badge badge-danger"> Complete <?php echo $result_detail_show['detail_date_complete']; ?></span>
                                            <?php echo $result_detail_show['causes_of_pay_detail']; ?>



                                        <?php }  ?>

                                        <?php if ($result_detail_show['detail_competency'] == 1) { ?>
                                            <span class="badge badge-success"> Competency </span>
                                        <?php }  ?>

                                    </div>

                                </div>

                                <br>



                                <form id="form1" name="form1" method="post" action="">





                                    <div class="row">


                                        <div class="col-sm-8">
                                            <div class="form-group clearfix">
                                                <div class="icheck-success d-inline">

                                                    <input type="checkbox" name="check_complete" id="check_complete" <?php if ($check_complete == 1) {
                                                                                                                            echo "checked";
                                                                                                                        } ?> value="1">
                                                    <label for="check_complete">

                                                        ยืนยันคะแนน ปี <?php echo $check_prosth_year; ?> (<?php echo $check_prosth_weight_ss; ?> / <?php echo $check_prosth_score_ss; ?>)

                                                        <?php if ($check_complete == 1) {
                                                            echo '<font color="green"><i class="fas fa-check-circle"></i></font>';
                                                        } else {
                                                            echo '<font color="red"><i class="fas fa-times-circle"></i></font>';
                                                        } ?>


                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-sm-8">
                                            <div class="form-group clearfix">
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" name="check_prosth_close" id="check_prosth_close" <?php if ($check_prosth_close == 1) {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> value="1">
                                                    <label for="check_prosth_close">
                                                        ปิดเคสการคิดคะแนนในปีถัดไป <font color="red">(ไม่สามารใช้ฟอร์มงานคิดคะแนนได้ในครั้งถัดไป)</font>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>






                                        <div class="col-sm-4">


                                            <?php if ($check_prosth_close == 1 || $check_complete == 1) {  ?>
                                                <button name="complete" type="submit" class="btn btn-success mb-3" style="float:right;" value="complete" disabled> <i class="fas fa-save"></i> บันทึกข้อมูลคะแนน </button>
                                          

                                                <button name="submit" type="submit" class="btn btn-info mb-3" style="float:right;" value="submit"> <i class="fas fa-save"></i> บันทึกข้อมูลคะแนน </button>

                                          
                                                <?php } else { ?>
                                                <button name="submit" type="submit" class="btn btn-success mb-3" style="float:right;" value="submit"> <i class="fas fa-save"></i> บันทึกข้อมูลคะแนน </button>
                                            <?php } ?>
                                        </div>






                                    </div>














                                    <input type="hidden" name="check_prosth_id" value="<?php echo $check_prosth_id; ?>">
                                    <input type="hidden" name="student_id" value="<?php echo $student_search; ?>">
                                    <input type="hidden" name="detail_id" value="<?php echo $detail_id_s; ?>">
                                    <input type="hidden" name="check_prosth_year" value="<?php echo $check_prosth_year; ?>">

                                    <?php echo $detail_id; ?> : <?php echo $check_prosth_id; ?> / <?php echo $form_detail_id; ?>

                                    <div class="table-responsive-lg">
                                        <table id="example3" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th Width="3%">
                                                        <div align="center">ลำดับ</div>
                                                    </th>
                                                    <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>

                                                    <?php
                                                    include "config.inc.php";
                                                    $sql_form_re = "SELECT * FROM tbl_" . $tbl_s . " where detail_id = $detail_id_s";
                                                    $sql_form_re  .=  " ORDER BY $tbl_id_s  ASC ";
                                                    $query_form_re = $conn->query($sql_form_re);
                                                    while ($row_form_re = $query_form_re->fetch_assoc()) {
                                                        $last_date = $row_form_re['last_date'];
                                                        $id_form_re = $row_form_re["{$tbl_id_s}"];
                                                    ?>

                                                        <th Width="7%">
                                                            <div align="center"> <?php if ($type_work_id == 4) { ?> ครั้ง <?php } else { ?> น้ำหนัก <?php } ?></div>
                                                        </th>

                                                        <th Width="7%">
                                                            <div align="center">คะแนน</div>
                                                        </th>


                                                        <th Width="5%"> รวม </th>
                                                    <?php }
                                                    $conn->close(); // $sql_form_re   
                                                    ?>

                                                    <th Width="5%"> รวมทั้งหมด </th>


                                                </tr>

                                            </thead>


                                            <tbody>



                                                <?php
                                                include "config.inc.php";
                                                $i_re = 0;
                                                $sum_score_total = 0;
                                                $sum_score = 0;
                                                $sum_weight_total = 0;
                                                // หาชื่อฟิลด์
                                                $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                                                $sql_form_detail_re  .=  " FROM (SELECT f.* FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id_s') AS fd ";
                                                $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                                                $query_form_detail_re = $conn->query($sql_form_detail_re);
                                                while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                                    $i_re++;
                                                    $field = $tbl_s . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                                                    $form_detail_id = $row_form_detail_re['form_detail_id'];
                                                ?>


                                                    <tr <?php

                                                        if (in_array($form_detail_id, $array_row_field)) {
                                                            echo 'class="table-primary"';
                                                        } else {
                                                            echo '';
                                                        }

                                                        ?>>

                                                        <td>

                                                            <?php echo $i_re; ?>
                                                            <?php echo $form_detail_id; ?>

                                                        </td>


                                                        <td><?php echo $row_form_detail_re['form_detail_topic']; ?> (<?php echo $row_form_detail_re['form_detail_field']; ?>) </td>


                                                        <?php
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





                                                        ?>


                                                            <td>
                                                                <div align="center"><?php echo $weight; ?>
                                                            </td>
                                                            <td>
                                                                <div align="center">
                                                                    <a href="#" data-toggle="tooltip" title=" <?php echo nameTeacher::get_teacher_name($teacher); ?> / <?php echo $datee; ?>"> <?php echo $grade; ?> (<?php echo $score; ?>) </a>
                                                                </div>
                                                            </td>


                                                            <td class="<?php echo $claass; ?>"> <?php echo  $sum_score; ?> </td>


                                                        <?php
                                                            $sum_weight_total = $sum_weight_total + $weight_ss;
                                                            $sum_score_total = $sum_score_total + $sum_score;
                                                        }


                                                        ?>

                                                        <td class="table-warning">


                                                            <?php if ($sum_score_total != 0) { // แสดงเฉพาะคะแนนที่ได้ 
                                                            ?>




                                                                <?php if ($check_prosth_close == 1) { // ปิดเคสการคิดคะแนนในปีถัดไป (ไม่สามารใช้ฟอร์มงานคิดคะแนนได้ในครั้งถัดไป) 
                                                                ?>

                                                                    <div class="form-group clearfix">
                                                                        <div class="icheck-success d-inline">
                                                                            <input type="checkbox" name="form_detail_ids[]" id="<?php echo $i_re; ?>" <?php if (in_array($form_detail_id, $array_row_field)) {
                                                                                                                                                            echo "checked";
                                                                                                                                                        }  ?> <?php if ($check_prosth_close == 1) {
                                                                                                                                                                    echo "disabled";
                                                                                                                                                                } ?> value="<?php echo $form_detail_id; ?>">
                                                                            <label for="<?php echo $i_re; ?>">
                                                                                <B><?php echo  $sum_score_total; ?></B>
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" name="form_detail_id[]" <?php if (in_array($form_detail_id, $array_row_field)) { ?> value="<?php echo $form_detail_id; ?>" <?php } ?>>


                                                                <?php } else { // ไม่ ปิดเคสการคิดคะแนนในปีถัดไป
                                                                ?>





                                                                    <?php
                                                                    //เช็คได้รับการประเมิน
                                                                    include "config.inc.php";
                                                                    $sql_check_prosth_s = "SELECT * ";
                                                                    $sql_check_prosth_s .= " FROM tbl_check_prosth ";
                                                                    $sql_check_prosth_s .= " WHERE ";
                                                                    $sql_check_prosth_s .= " detail_id = $detail_id_s and check_prosth_year != $check_prosth_year ";
                                                                    //$sql_check_prosth_s .= " and form_detail_id REGEXP '\\[(\"[[:digit:]]*\",)?\"$form_detail_id\"' ";
                                                                    $sql_check_prosth_s .= " and form_detail_id REGEXP  \"\\\"({$form_detail_id})+\\\"\" ";
                                                                    //echo $sql_check_prosth_s;
                                                                    $query_check_prosth_s = $conn->query($sql_check_prosth_s);
                                                                    if ($row_check_prosth_s = $query_check_prosth_s->fetch_assoc()) {

                                                                        echo '<font color="green"><i class="fas fa-check-circle"></i></font>';
                                                                        echo  ' (' . $row_check_prosth_s['check_prosth_year'] . ")";
                                                                    ?>



                                                                    <?php  } else { ?>


                                                                        <div class="form-group clearfix">
                                                                            <div class="icheck-success d-inline">
                                                                                <input type="checkbox" name="form_detail_id[]" id="<?php echo $i_re; ?>" <?php if (in_array($form_detail_id, $array_row_field)) {
                                                                                                                                                                echo "checked";
                                                                                                                                                            } ?> value="<?php echo $form_detail_id; ?>">
                                                                                <label for="<?php echo $i_re; ?>">
                                                                                    <B><?php echo  $sum_score_total; ?></B>
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                    <?php  }  ?>






                                                                <?php } ?>





                                                            <?php } ?>









                                                            <input type="hidden" name="check_prosth_weight_<?php echo $form_detail_id; ?>" value="<?php echo $sum_weight_total; ?>">
                                                            <input type="hidden" name="check_prosth_score_<?php echo $form_detail_id; ?>" value="<?php echo $sum_score_total; ?>">

                                                        </td>


                                                    </tr>






                                                <?php } //row_form_detail_re
                                                ?>



                                            </tbody>

                                        </table>
                                    </div>



                                    <?php if ($check_prosth_close == 1 || $check_complete == 1) {  ?>
                                        <button name="complete" type="submit" class="btn btn-success mb-3" style="float:right;" value="complete" disabled> <i class="fas fa-save"></i> บันทึกข้อมูลคะแนน </button>
                                    <?php } else { ?>
                                        <button name="submit" type="submit" class="btn btn-success mb-3" style="float:right;" value="submit"> <i class="fas fa-save"></i> บันทึกข้อมูลคะแนน </button>
                                    <?php } ?>




                                </form>

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



            if (!empty($_POST['form_detail_id'])) {
                $form_detail_id = json_encode($_POST['form_detail_id']);
                $form_detail_id_array = $_POST['form_detail_id'];



                echo $form_detail_id;

            } else {
                $form_detail_id = json_encode([]);
                $form_detail_id_array = [];
            }

            if (!empty($_POST['detail_id'])) {
                $detail_id = $_POST['detail_id'];
            } else {
                $detail_id = 0;
            }
            if (!empty($_POST['student_id'])) {
                $student_id = $_POST['student_id'];
            } else {
                $student_id = 0;
            }
            if (!empty($_POST['check_prosth_year'])) {
                $check_prosth_year = $_POST['check_prosth_year'];
            } else {
                $check_prosth_year = 1;
            }


            if (!empty($_POST['check_prosth_grade'])) {
                $check_prosth_grade = $_POST['check_prosth_grade'];
            } else {
                $check_prosth_grade = 0;
            }


            if (!empty($_POST['check_prosth_id'])) {
                $check_prosth_id = $_POST['check_prosth_id'];
            } else {
                $check_prosth_id = '';
            }


            if (!empty($_POST['check_prosth_close'])) {
                $check_prosth_close = $_POST['check_prosth_close'];
            } else {
                $check_prosth_close = 0;
            }


            if (!empty($_POST['check_complete'])) {
                $check_complete = $_POST['check_complete'];
            } else {
                $check_complete = 0;
            }


            foreach ($form_detail_id_array as $n) {

                if (!empty($_POST["check_prosth_weight_$n"])) {
                    $check_prosth_weight[] = $_POST["check_prosth_weight_$n"];
                } else {
                    $check_prosth_weight[] = 0;
                }


                if (!empty($_POST["check_prosth_score_$n"])) {
                    $check_prosth_score[] = $_POST["check_prosth_score_$n"];
                } else {
                    $check_prosth_score[] = 0;
                }


            }




            if (!empty($check_prosth_weight)) {
                $check_prosth_weight = array_sum($check_prosth_weight);
            } else {
                $check_prosth_weight = 0;
            }

            if (!empty($check_prosth_score)) {
                $check_prosth_score  = array_sum($check_prosth_score);
            } else {
                $check_prosth_score = 0;
            }






            $sum_sww = $check_prosth_score / $check_prosth_weight;
            $check_prosth_grade = round($sum_sww, 2);

            $check_prosth_date = date('Y-m-d H:i:s');

            //$username = $_SESSION['username'];

            if (!empty($check_prosth_id)) {

                $check_prosth_log  = "UPDATE|$check_prosth_date|$username/";
               $sql = "UPDATE tbl_check_prosth SET form_detail_id = '$form_detail_id', check_prosth_weight = $check_prosth_weight, check_prosth_score = $check_prosth_score,  check_prosth_grade = $check_prosth_grade , check_complete = $check_complete, check_prosth_date = '$check_prosth_date',  check_prosth_close = $check_prosth_close, check_prosth_log = replace(check_prosth_log, '/','$check_prosth_log')  WHERE check_prosth_id = $check_prosth_id";
                $conn->query($sql);


            } else {


                $check_prosth_status = 0;
                $check_prosth_log  = "INSERT|$check_prosth_date|$username/";

                $sql = "INSERT INTO tbl_check_prosth (check_prosth_id, detail_id, student_id, check_prosth_year, form_detail_id, check_prosth_weight, check_prosth_score, check_prosth_grade, check_complete, check_prosth_date, check_prosth_close, check_prosth_status, check_prosth_log) VALUES (NULL, '$detail_id', '$student_id', '$check_prosth_year', '$form_detail_id', '$check_prosth_weight', '$check_prosth_score', '$check_prosth_grade', '$check_complete', '$check_prosth_date', '$check_prosth_close', '$check_prosth_status', '$check_prosth_log');";
               $conn->query($sql);
            }




            $conn->close();

            echo "<script type='text/javascript'>";
            //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
            echo "window.history.back(1)";
            echo "</script>";
        }
        ?>





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