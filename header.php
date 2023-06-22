<?PHP
session_start(); 
?>
<!DOCTYPE html>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//กรณีต้องการเก็บ log file
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
//เริ่มต้นการใช้งาน แทรกส่วนนี้ไว้ตอนต้นๆของเพจ ก่อนการประมวลผล
include 'class_Timer.php';
$bm = new Timer; // เรียกใช้งาน class
$bm->start(); // เริ่มต้นจับเวลา
include "_class_student.php";
include "_class_teacher.php";
include "_class_class.php";
include "_class_type_work.php";
include "_class_plan.php";
include "_class_causes_of_pay.php";
include "_class_detail.php";
include "_class_detail_order.php";
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบประเมินคะแนนนักศึกษาในคลินิก</title>
    <!-- Google Font: Source Sans Pro 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons 
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>

<!--<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-footer-fixed">-->





<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">


    <div class="wrapper">

  <!-- Preloader
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/loading-36.gif" alt="AdminLTELogo" height="150" width="150">
  </div> -->


        <!-- Navbar -->
        <!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">-->
        <nav class="main-header navbar navbar-expand navbar-dark">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link"><i class="nav-icon fas fa-tooth"></i> คลินิกรวมนักศึกษา (E-Clinic) </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link">
                        <?php // อนุญาติให้เข้าใช้ระบบ
                        echo "<b>IP Address :</b> " . $REMOTE_ADDR;
                        // echo " >> ";
                        // echo $REMOTE_ADDR_substr = substr($REMOTE_ADDR, 0,5);
                        ?>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link">
                        <?php // print_r($_SESSION); 
                        ?>
                    </a>
                </li>


            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->

                <?php if (isset($_SESSION['level_user']) && !empty($_SESSION['level_user'])) { ?>
                    <li class="nav-item">
                        <a href="support.php" class="nav-link active bg-danger" role="button">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            แจ้งปัญหา
                        </a>
                    </li>
                <?php } ?>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>


            </ul>

        </nav>
        <!-- /.navbar -->




        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">


            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 100">
                <span class="brand-text font-weight-light"> คลินิกรวมนักศึกษา </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->


                <?php if (isset($_SESSION['level_user']) && !empty($_SESSION['level_user'])) { ?>
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <?php if ($_SESSION['level_user'] == "Student") { // เป็น Student  
                        ?>
                            <div class="image">
                                <!--  <img src="http://10.151.127.134/estudent/pic_students/<?php echo $_SESSION['loginname']; ?>.jpg" class="img-circle elevation-2" alt="User Image">-->
                                <img src="../pic_students/<?php echo $_SESSION['loginname']; ?>.jpg" class="img-circle elevation-2" alt="User Image">
                            </div>
                        <?php } ?>
                        <div class="info">
                            <a href="#" class="d-block"><?php echo  $_SESSION['loginname']; ?> <br>
                                <?php echo  $_SESSION['fname']; ?> <?php echo  $_SESSION['lname']; ?></a>
                        </div>
                    </div>
                <?php } ?>






                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">
                                <i class="fa fa-home nav-icon"></i>
                                <p>หน้าแรก</p>
                            </a>
                        </li>

                        <?php if (isset($_SESSION['level_user']) && !empty($_SESSION['level_user'])) { ?>


                            <?php //เป็น  ระดับ Admin
                            if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 2)) {
                            ?>



                                <li class="nav-item">
                                    <a href="report_date.php" class="nav-link bg-purple">
                                        <i class="fas fa-clock nav-icon"></i>
                                        <p>ตั้งค่าวันที่รายงาน</p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="calendar.php" class="nav-link bg-warning">
                                        <i class="fas fa-calendar nav-icon"></i>
                                        <p>ปฎิทินการประเมิน</p>
                                    </a>
                                </li>


                                <li class="nav-item ">
                                    <a href="index_code.php" class="nav-link active bg-danger">
                                        <i class="nav-icon fas fa-database"></i>
                                        <p> DB E-Clinic </p>
                                    </a>
                                </li>


 

                                <li class="nav-item">
                                    <a href="support_title.php" class="nav-link active bg-danger">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p> หัวข้อปัญหา </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="support.php" class="nav-link active bg-danger">
                                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                        <p> แจ้งปัญหา </p>
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="line_notify.php" class="nav-link active bg-success">
                                        <i class="nav-icon fas fa-bell"></i>
                                        <p> Line notify </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="update_version.php" class="nav-link active bg-info">
                                        <i class="nav-icon fas fa-code-branch"></i>
                                        <p> Up_version </p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="revised.php" class="nav-link active bg-secondary">
                                        <i class="nav-icon fas fa-sync"></i>
                                        <p>Revised</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="dashboard.php" class="nav-link  bg-pink">
                                        <i class="nav-icon fas fa-address-card"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>




                                <li class="nav-item">
                                    <a href="form_main.php" class="nav-link active bg-warning">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p> Create Form Main </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="form_more.php" class="nav-link active bg-warning">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>Create Form Other </p>
                                    </a>
                                </li>


                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link active bg-warning">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Holistic & Conduct
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href="form_holistic.php" class="nav-link active">
                                                <i class="nav-icon fas fa-th"></i>
                                                <p>Create Form holistic </p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="form_conduct.php" class="nav-link active">
                                                <i class="nav-icon fas fa-th"></i>
                                                <p>Create Form Conduct </p>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a href="form_conduct_knowledge.php" class="nav-link active">
                                                <i class="nav-icon fas fa-th"></i>
                                                <p>Create Form C & Kn </p>
                                            </a>
                                        </li>



                                    </ul>
                                </li>






                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link  bg-orange">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>
                                            ผู้ใช้งานระบบ
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">


                                        <li class="nav-item">
                                            <a href="student_list.php" class="nav-link active">
                                                <i class="nav-icon fas fa-user"></i>
                                                <p> Student</p>
                                            </a>
                                        </li>



                                        <li class="nav-item">
                                            <a href="teacher.php" class="nav-link active">
                                                <i class="nav-icon fas fa-user"></i>
                                                <p>Teacher</p>
                                            </a>
                                        </li>



                                        <li class="nav-item">
                                            <a href="staff.php" class="nav-link active">
                                                <i class="nav-icon fas fa-user"></i>
                                                <p>Staff</p>
                                            </a>
                                        </li>



                                    </ul>
                                </li>


                                <li class="nav-item">
                                    <a href="plan.php" class="nav-link">
                                        <i class="nav-icon fas fa-th"></i>
                                        <p>Plan </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="class.php" class="nav-link">
                                        <i class="nav-icon fas fa-tooth"></i>
                                        <p>Class</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="report_count.php" class="nav-link bg-pink">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p> นับคาบ </p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="report_follow.php" class="nav-link bg-pink">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p> ติดตาม </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="competency_cb.php" class="nav-link bg-success">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p> Competency CB</p>
                                    </a>
                                </li>


                            <?php  } ?>





                            <?php  // เป็น Staff  และ ระดับ Admin
                            if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 2)) {
                            ?>


                                <li class="nav-item">
                                    <a href="conduct.php" class="nav-link bg-pink">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p> ติดตาม </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="conduct.php" class="nav-link bg-danger">
                                    <i class="nav-icon  fas fa-frown"></i>  
                                        <p>หักคะแนนนอกคาบ</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="no_patient.php" class="nav-link bg-danger">
                                    <i class="nav-icon fas fa-user-slash"></i>
                                        <p>ไม่มีผู้ป่วยส่วนกลาง</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="order.php" class="nav-link bg-secondary">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>จ่ายเคสนักศึกษา </p>
                                    </a>
                                </li>


                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Report Dashboard
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?PHP
                                        $plan_work_header = array();
                                        include "config.inc.php";
                                        $sql_type_work_h = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                                        $query_type_work_h = $conn->query($sql_type_work_h);
                                        while ($result_type_work_h  = $query_type_work_h->fetch_assoc()) {

                                            $plan_work_header[] = array(
                                                'type_work_id' => $result_type_work_h['type_work_id'],
                                                'type_work_name' => $result_type_work_h['type_work_name']
                                            );
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_type_work.php?type_work_id=<?php echo $result_type_work_h['type_work_id']; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $result_type_work_h['type_work_name']; ?></p>
                                                </a>
                                            </li>
                                        <?php }
                                        $conn->close();
                                        ?>
                                    </ul>
                                </li>






                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Report Score Work
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP
                                        foreach ($plan_work_header as $values => $data) {
                                            $type_work_id_arr =  $data['type_work_id'];
                                            $type_work_name_arr =  $data['type_work_name'];
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_grade_work.php?type_work_id=<?php echo $type_work_id_arr; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $type_work_name_arr; ?></p>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </li>







                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Holistic & Conduct
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP

                                        foreach ($plan_work_header as $values => $data) {
                                            $type_work_id_arr =  $data['type_work_id'];
                                            $type_work_name_arr =  $data['type_work_name'];
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_holistic.php?type_work_id=<?php echo $type_work_id_arr; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $type_work_name_arr; ?></p>
                                                </a>
                                            </li>

                                        <?php } ?>

                                    </ul>
                                </li>





                                <li class="nav-item">
                                    <a href="report_daily.php" class="nav-link">
                                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                        <p>Daily Report</p>
                                    </a>
                                </li>

                            <?php } ?>


                            <?php  // เป็น Staff  และ ระดับ สาขาวิชา
                            if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 6)) {
                            ?>

                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Report Dashboard
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP
                                        $plan_work_header = array();
                                        include "config.inc.php";
                                        $sql_type_work_h = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                                        $query_type_work_h = $conn->query($sql_type_work_h);
                                        while ($result_type_work_h  = $query_type_work_h->fetch_assoc()) {

                                            $plan_work_header[] = array(
                                                'type_work_id' => $result_type_work_h['type_work_id'],
                                                'type_work_name' => $result_type_work_h['type_work_name']
                                            );
                                        ?>


                                            <li class="nav-item">
                                                <a href="report_type_work.php?type_work_id=<?php echo $result_type_work_h['type_work_id']; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $result_type_work_h['type_work_name']; ?></p>
                                                </a>
                                            </li>


                                        <?php }
                                        $conn->close();
                                        ?>

                                    </ul>
                                </li>






                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Report Score Work
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP
                                        foreach ($plan_work_header as $values => $data) {
                                            $type_work_id_arr =  $data['type_work_id'];
                                            $type_work_name_arr =  $data['type_work_name'];
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_grade_work.php?type_work_id=<?php echo $type_work_id_arr; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $type_work_name_arr; ?></p>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </li>







                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Holistic & Conduct
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP

                                        foreach ($plan_work_header as $values => $data) {
                                            $type_work_id_arr =  $data['type_work_id'];
                                            $type_work_name_arr =  $data['type_work_name'];
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_holistic.php?type_work_id=<?php echo $type_work_id_arr; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $type_work_name_arr; ?></p>
                                                </a>
                                            </li>

                                        <?php } ?>

                                    </ul>
                                </li>

                            <?php } ?>









                            <?php  // เป็น Staff  และ ระดับ Admin
                            if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 1)) {
                            ?>


                                <li class="nav-item">
                                    <a href="order.php" class="nav-link bg-warning">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>จ่ายเคสนักศึกษา </p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="case_order_serverside.php" class="nav-link bg-info">
                                        <i class="fas fa-file nav-icon"></i>
                                        <p>รายการจ่ายเคสผู้ป่วย</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="report_follow.php" class="nav-link bg-pink">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p> ติดตาม </p>
                                    </a>
                                </li>


                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Report Dashboard
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?PHP
                                        $plan_work_header = array();
                                        include "config.inc.php";
                                        $sql_type_work_h = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                                        $query_type_work_h = $conn->query($sql_type_work_h);
                                        while ($result_type_work_h  = $query_type_work_h->fetch_assoc()) {

                                            $plan_work_header[] = array(
                                                'type_work_id' => $result_type_work_h['type_work_id'],
                                                'type_work_name' => $result_type_work_h['type_work_name']
                                            );
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_type_work.php?type_work_id=<?php echo $result_type_work_h['type_work_id']; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $result_type_work_h['type_work_name']; ?></p>
                                                </a>
                                            </li>
                                        <?php }
                                        $conn->close();
                                        ?>
                                    </ul>
                                </li>



                            <?php } ?>






                            <?php  // เป็น Student  
                            if ($_SESSION['level_user'] == "Student") {
                            ?>



                                <!--   <li class="nav-item">
                                <a href="order.php" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>เพิ่มผู้ป่วย </p>
                                </a>
                            </li> -->

                                <li class="nav-item">
                                    <a href="detail.php" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p> เพิ่มงานให้ผู้ป่วย </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="detail_list.php" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>ส่งงานประเมิน</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="no_hn.php" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>กรณีไม่มีผู้ป่วย</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="arrange_add.php" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>ประวัติการส่งงานในคลินิก</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="arrange_send_lab.php" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>ประวัติการส่งงาน LAB</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="score_prosth.php" class="nav-link">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p>จัดการคะแนน Prosth</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="no_patient.php" class="nav-link bg-danger">
                                    <i class="nav-icon fas fa-user-slash"></i>
                                        <p>ไม่มีผู้ป่วยส่วนกลาง</p>
                                    </a>
                                </li>













                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            ตรวจสอบคะแนน
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP
                                        include "config.inc.php";
                                        $sql_type_work_h = "SELECT * FROM tbl_type_work  ORDER BY tbl_type_work.type_work_id ASC ";
                                        $query_type_work_h = $conn->query($sql_type_work_h);
                                        while ($result_type_work_h  = $query_type_work_h->fetch_assoc()) {
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_student.php?type_work_id=<?php echo $result_type_work_h['type_work_id']; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $result_type_work_h['type_work_name']; ?></p>
                                                </a>
                                            </li>

                                        <?php }
                                        $conn->close();
                                        ?>

                                    </ul>
                                </li>






                            <?php  } ?>








                            <?php  // เป็น Teacher  
                            if ($_SESSION['level_user'] == "Teacher") {
                            ?>


                                <li class="nav-item">
                                    <a href="arrange_calendar.php" class="nav-link bg-warning">
                                        <i class="fas fa-calendar nav-icon"></i>
                                        <p>ปฎิทินการประเมิน</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="arrange.php" class="nav-link bg-info">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p> ประเมินคะแนน ในคลินิก</p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="arrange_no_hn.php" class="nav-link bg-secondary">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p> ประเมินกรณีไม่มีผู้ป่วย</p>
                                    </a>
                                </li> 

                                <li class="nav-item">
                                    <a href="arrange_lab.php" class="nav-link bg-success">
                                        <i class="nav-icon fas fa-edit"></i>
                                        <p> ประเมินคะแนน LAB</p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="dashboard.php" class="nav-link  bg-pink">
                                        <i class="nav-icon fas fa-address-card"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="case_order_serverside.php" class="nav-link bg-pink">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>รายการจ่ายเคสผู้ป่วย</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="report_count.php" class="nav-link bg-pink">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p> นับคาบ </p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="report_follow.php" class="nav-link bg-pink">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p> ติดตาม </p>
                                    </a>
                                </li>



                                <?php if($_SESSION['doctorcode'] == '0074'){ ?>
                                    <li class="nav-item">
                                        <a href="competency_cb.php" class="nav-link bg-success">
                                            <i class="nav-icon fas fa-edit"></i>
                                            <p> Competency CB</p>
                                        </a>
                                    </li>
                                <?php  } ?>



                              
                                    <li class="nav-item">
                                        <a href="conduct.php" class="nav-link bg-danger">
                                        <i class="nav-icon  fas fa-frown"></i>  
                                            <p>หักคะแนนนอกคาบ</p>
                                        </a>
                                    </li>
                            




                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Report Dashboard
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?PHP
                                        $plan_work_header = array();
                                        include "config.inc.php";
                                        $type_work_id_ss = $_SESSION['type_work_id'];
                                        $sql_type_work_h = "SELECT * FROM tbl_type_work where type_work_id = $type_work_id_ss ORDER BY tbl_type_work.type_work_id ASC ";
                                        $query_type_work_h = $conn->query($sql_type_work_h);
                                        while ($result_type_work_h  = $query_type_work_h->fetch_assoc()) {
                                            $plan_work_header[] = array(
                                                'type_work_id' => $result_type_work_h['type_work_id'],
                                                'type_work_name' => $result_type_work_h['type_work_name']
                                            );
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_type_work.php?type_work_id=<?php echo $result_type_work_h['type_work_id']; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $result_type_work_h['type_work_name']; ?></p>
                                                </a>
                                            </li>
                                        <?php }
                                        $conn->close();
                                        ?>
                                    </ul>
                                </li>






                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Report Grade Work
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP
                                        foreach ($plan_work_header as $values => $data) {
                                            $type_work_id_arr =  $data['type_work_id'];
                                            $type_work_name_arr =  $data['type_work_name'];
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_grade_work.php?type_work_id=<?php echo $type_work_id_arr; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $type_work_name_arr; ?></p>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </li>



                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>
                                            Holistic & Conduct
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?PHP

                                        foreach ($plan_work_header as $values => $data) {
                                            $type_work_id_arr =  $data['type_work_id'];
                                            $type_work_name_arr =  $data['type_work_name'];
                                        ?>
                                            <li class="nav-item">
                                                <a href="report_holistic.php?type_work_id=<?php echo $type_work_id_arr; ?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?php echo $type_work_name_arr; ?></p>
                                                </a>
                                            </li>

                                        <?php } ?>

                                    </ul>
                                </li>





                            <?php } ?>





                            <li class="nav-item">
                                <a href="logout.php" class="nav-link">
                                    <i class="fa fa-unlock nav-icon"></i>
                                    <p>ออกจากระบบ</p>
                                </a>
                            </li>

                        <?php } else { ?>

                            <li class="nav-item">
                                <a href="login.php" class="nav-link active">
                                    <i class="fa fa-lock nav-icon"> </i>
                                    <p>เข้าสู่ระบบ</p>
                                </a>
                            </li>




                        <?php } ?>






                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>






        <style>
            .content-wrapper {
                font-family: 'Kanit', sans-serif !important;
                background-image: url("images/12234.jpg");
                /* 5816231.jpg  17545  4882066.jpg*/
                background-color: #cccccc;
                /* Used if the image is unavailable  height: 900px;*/

                /* You must set a specified height */
                background-position: inherit;
                /* Center the image */
                /*background-repeat: no-repeat;  Do not repeat the image */
                background-size: container;
                padding-top: 7.5;
                /* Resize the background image to cover the entire container */


            }

            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: rgb(255 255 255 / 50%);
                background-clip: border-box;
                border: 1px solid rgba(0, 0, 0, .125);
                border-radius: 2rem;
                box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
            }

            .info-box {
                position: relative;
                background-color: rgb(255 255 255 / 50%);
                background-clip: border-box;
                border: 1px solid rgba(0, 0, 0, .125);
                border-radius: 2rem;
                box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
            }



            .gradiant-bg {
                font-size: 18px;
                font-weight: bold;
                background: linear-gradient(45deg, #012a4a, #013a63, #01497c, #014f86, #00b4d8);
                background-size: 40%;
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: gradient 5s infinite;
            }

            .gradiant2-bg {
                font-size: 18px;
                font-weight: bold;
                background: linear-gradient(45deg, #03045e, #023e8a, #0077b6, #0096c7, #00b4d8);
                background-size: 90%;
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: gradient 5s infinite;
            }


            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                100% {
                    background-position: 100% 50%;
                }
            }
        </style>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">


        <?php //include "dent_form.php";?>