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
if (isset($_SESSION['do'])) {

$do = $_SESSION['do'];

echo "<script>";
echo " Swal.fire({";
echo "  title: 'สำเร็จ!',";
echo "  text: '$do',";
echo "  icon: 'success',";
echo "  imageUrl: 'https://unsplash.it/400/200',";
echo "  imageWidth: 400,";
echo "  imageHeight: 200,";
echo "  imageAlt: 'Custom image',";
echo "  })";
echo " </script>";
unset($_SESSION['do']);
}


if (isset($_SESSION['error'])) {

echo   $error = $_SESSION['error'];

echo "<script>";
echo " Swal.fire({";
echo "  title: 'ไม่สำเร็จ!',";
echo "  text: '$error',";
echo "  icon: 'error',";
echo "  imageUrl: 'https://unsplash.it/400/200',";
echo "  imageWidth: 400,";
echo "  imageHeight: 200,";
echo "  imageAlt: 'Custom image',";
echo "  })";
echo " </script>";
unset($_SESSION['error']);
}


?>


    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-8">
                    <h1>Add Case เพิ่มผู้ป่วย</h1>
                </div>

                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                        <li class="breadcrumb-item active">จ่ายเคสนักศึกษา</li>
                    </ol>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">





            <?PHP
            if (isset($_GET['hn']) && !empty($_GET['hn'])) {
                include "config.inc_hosxp.php";
                $hn = $_GET['hn'];
                $sql_hn = "SELECT * FROM patient where hn = '$hn' ";
                $query_hn = $conn_hosxp->query($sql_hn);
                if ($result_hn  = $query_hn->fetch_assoc()) {
                    $hn = $result_hn['hn'];
                    $pname = $result_hn['pname'];
                    $fname = $result_hn['fname'];
                    $lname = $result_hn['lname'];

                    $status_hn = 1;
                } else {
                    $hn = "";
                    $pname = "";
                    $fname = "";
                    $lname = "";
                    $status_hn = 2;
                }
            } else {
                $hn = "";
                $pname = "";
                $fname = "";
                $lname = "";
                $status_hn = 0;
            }
            ?>









            <?php if ($_SESSION['level_user'] == "Student") { // เป็น Student  
                $student_id = $_SESSION['loginname'];
                $student_titel = "นทพ.";
                $student_name = $_SESSION['fname'];
                $student_lastname = $_SESSION['lname'];
                $status_student = 1;
            } else {






                if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
                    include "config.inc.php";

                    $student_id = $_GET['student_id'];
                    $sql_student = "SELECT * FROM tbl_student where student_id = '$student_id' ";
                    $query_student = $conn->query($sql_student);
                    if ($result_student  = $query_student->fetch_assoc()) {

                        $student_id = $result_student['student_id'];
                        $student_titel = "นทพ.";
                        $student_name = $result_student['student_name'];
                        $student_lastname = $result_student['student_lastname'];
                        $status_student = 1;
                    } else {
                        $student_id = "";
                        $student_titel = "";
                        $student_name = "";
                        $student_lastname = "";
                        $status_student = 2;
                    }
                } else {
                    $student_id = "";
                    $student_titel = "";
                    $student_name = "";
                    $student_lastname = "";
                    $status_student = 0;
                }
            }



            if (isset($_GET['osler'])) {

                include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                $order_osler = $_GET['osler'];
                $order_id = $_GET['order_id'];

                $sql_del = "UPDATE tbl_order SET order_osler = '$order_osler' WHERE tbl_order.order_id =$order_id;";
                $conn->query($sql_del);
                echo "<script type='text/javascript'>";
                //echo  "alert('บันทึกสำเร็จ');";
                echo "window.history.back(1)";
                echo "</script>";
            }







            if (!empty($_GET['del'])) {

                include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                $order_id = $_GET['del'];
                $sql_del = "DELETE FROM tbl_order WHERE tbl_order.order_id = $order_id";
                $conn->query($sql_del);
                echo "<script type='text/javascript'>";
                //echo  "alert('บันทึกสำเร็จ');";
                echo "window.history.back(1)";
                echo "</script>";
            }


            if (!empty($hn) && !empty($student_id)) {

                include "config.inc.php";


                $sql_order = "SELECT * FROM tbl_order where HN = $hn and student_id = '$student_id' and  causes_of_pay_id = 0";
                $query_order = $conn->query($sql_order);

                if ($result_order  = $query_order->fetch_assoc()) {

                    $status_order = 1;
                } else {

                    $status_order = 2;
                }


            } else {
                $status_order = 0;
            }
            ?>




            <div class="row">
                <div class="col-md-6">

                    <div class="card card-default color-palette-box">
                        <div class="card-header">
                            <h3 class="card-title"> <i class="fas fa-user"></i> จ่ายเคสนักศึกษา </h3>
                        </div>

                        <div class="card-body">
                            <form name="form1" method="get" action="" enctype="multipart/form-data">

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="hn" class="form-control" value="<?php echo $hn; ?>" placeholder="ระบุ HN ผู้ป่วย" >
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <?php
                                            switch ($status_hn) { // Harder page
                                                case 2:
                                                    echo  "<i class='fas fa-times-circle' style='font-size:24px;color:red'></i> ไม่พบ ";
                                                    break;
                                                case 1:
                                                    echo  "<i class='fas fa-check-circle' style='font-size:24px;color:green'></i> พบข้อมูล";
                                                    break;
                                                case 0:
                                                    echo  "";
                                                    break;
                                                default:
                                                    echo  "";
                                                    break;
                                            }
                                            ?>



                                            <?php
                                            if ($status_hn == 1) {
                                                include "config.inc_hosxp.php";
                                                $sql_img = "SELECT * FROM patient_image where hn = $hn ";
                                                $query_img = $conn_hosxp->query($sql_img);
                                                $result_img  = $query_img->fetch_assoc();
                                                //echo '<img src="data:image/jpeg;base64,'.base64_encode( $result_img['image'] ).'" width="80" height="90"/>';
                                            }
                                            ?>




                                        </div>
                                    </div>

                                </div>





                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <?php if ($_SESSION['level_user'] == "Student") { // เป็น Student  
                                            ?>
                                                <input type="text" name="student_idd" class="form-control" value="<?php echo $student_id; ?>" placeholder="ระบุ รหัสนักศึกษา" required disabled>
                                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                                            <?php } else { ?>
                                                <input type="text" name="student_id" class="form-control" value="<?php echo $student_id; ?>" placeholder="ระบุ รหัสนักศึกษา" required>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <?php
                                            switch ($status_student) { // Harder page
                                                case 2:
                                                    echo  "<i class='fas fa-times-circle' style='font-size:24px;color:red'></i> ไม่พบ ";
                                                    break;
                                                case 1:
                                                    echo  "<i class='fas fa-check-circle' style='font-size:24px;color:green'></i> พบข้อมูล";
                                                    break;
                                                case 0:
                                                    echo  "";
                                                    break;
                                                default:
                                                    echo  "";
                                                    break;
                                            }
                                            ?>
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="submit" name="submit" class="btn btn-primary" id="button" value="ค้นหา">
                                    </div>
                                </div>

                            </form>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->





                </div><!-- /.col-md-6-->
                <div class="col-md-6">

                    <div class="card card-default color-palette-box">
                        <div class="card-header">
                            <h3 class="card-title"> <i class="far fa-clipboard"></i>
                                <?php
                                switch ($status_order) { // Harder page
                                    case 1:
                                        echo  "มีการจ่ายผู้ป่วยให้ น.ศ. แล้ว ก่อนหน้า";
                                        break;
                                    case 2:
                                        echo  "ยืนยันการจ่ายผู้ป่วยใหม่";
                                        break;
                                    case 0:
                                        echo  "รอตรวจสอบข้อมูล";
                                        break;
                                    default:
                                        echo  "รอตรวจสอบข้อมูล";
                                        break;
                                }
                                ?>
                            </h3>
                        </div>


                        <div class="card-body">
                            <form name="form1" method="post" action="" enctype="multipart/form-data">

                                <input type="hidden" name="HN" value="<?php echo $hn; ?>">
                                <input type="hidden" name="pname" value="<?php echo $pname; ?>">
                                <input type="hidden" name="fname" value="<?php echo $fname; ?>">
                                <input type="hidden" name="lname" value="<?php echo $lname; ?>">
                                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php echo $hn; ?> : <?php echo $pname; ?> <?php echo $fname; ?>
                                            <?php echo $lname; ?>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php echo $student_id; ?> : <?php echo $student_titel; ?>
                                            <?php echo $student_name; ?> <?php echo $student_lastname; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">

                                        <?php if ($status_order == 2) { ?>
                                            <input type='submit' name='submit_add' class='btn btn-primary' id='button' value='ยืนยันการจ่ายผู้ป่วยใหม่'>
                                        <?php } ?>


                                        <?php if ($status_order == 1) { ?>
                                            <a href="#" class="btn btn-warning"> มีการจ่ายผู้ป่วยให้ น.ศ. แล้ว..!! </a>
                                        <?php } ?>


                                        <?php if(!empty($student_id)) { ?>
                                            <a href="?addmodle=<?php echo $student_id;?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการเพิ่มผู้ป่วยจำลองอีกครั้ง !!!')"> เพิ่มผู้ป่วยจำลอง </a>
                                        <?php } ?>

                                    </div>
                                </div>

                            </form>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->


                </div><!-- /.col-md-6-->







            </div><!-- /.row-->






            <?php


            if (isset($_GET['addmodle']) && !empty($_GET['addmodle'])) {

                $student_id = $_GET['addmodle'];
     
                $HN  = date('YmdHis');
                $pname  = "";
                $fname  = "ผู้ป่วยจำลอง";
                $lname  = "";

                $order_date = date('Y-m-d');
                $order_time = date('H:i:s');

                if (!empty($_SESSION["staff"])) {
                    $order_by_staff = $_SESSION["user_id"];
                } else {
                    $order_by_staff = 0;
                }
                if (!empty($_SESSION["student"])) {
                    $order_by_student = $_SESSION["user_id"];
                } else {
                    $order_by_student = 0;
                }
                

                include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                $sql_insert = "INSERT INTO tbl_order (order_id, student_id, HN, pname, fname, lname, causes_of_pay_id, date_pay, order_date, order_time, order_by_student,order_by_staff, order_pay_by, order_osler, order_type) VALUES (NULL, '$student_id', '$HN', '$pname', '$fname', '$lname', '0', '0', '$order_date', '$order_time','$order_by_student', '$order_by_staff', '0', '0', '1');";
                $conn->query($sql_insert);
                $conn->close();

                $_SESSION['do'] = 'บันทึกข้อมูลสำเร็จ';
                echo "<script type='text/javascript'>";
                //echo  "alert('บันทึกสำเร็จ');";
                echo "window.location='order.php?hn=$HN&student_id=$student_id'";
                echo "</script>";

            }





      

            if (isset($_POST['submit_add'])) {
                include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 

                $student_id   = $conn->real_escape_string($_POST['student_id']);
                $HN  = $conn->real_escape_string($_POST['HN']);
                $pname  = $conn->real_escape_string($_POST['pname']);
                $fname  = $conn->real_escape_string($_POST['fname']);
                $lname  = $conn->real_escape_string($_POST['lname']);

                $order_date = date('Y-m-d');
                $order_time = date('H:i:s');

                if (!empty($_SESSION["staff"])) {
                    $order_by_staff = $_SESSION["user_id"];
                } else {
                    $order_by_staff = 0;
                }
                if (!empty($_SESSION["student"])) {
                    $order_by_student = $_SESSION["user_id"];
                } else {
                    $order_by_student = 0;
                }


                $sql_insert = "INSERT INTO tbl_order (order_id, student_id, HN, pname, fname, lname, causes_of_pay_id, date_pay, order_date, order_time, order_by_student,order_by_staff) VALUES (NULL, '$student_id', '$HN', '$pname', '$fname', '$lname', '0', '0', '$order_date', '$order_time','$order_by_student', '$order_by_staff');";
                $conn->query($sql_insert);
                $plan_id = $conn->insert_id;

                echo "<script type='text/javascript'>";
                echo  "alert('บันทึกสำเร็จ');";
                echo "window.location='order.php?hn=$HN&student_id=$student_id'";
                echo "</script>";
            }
            ?>










            <?PHP
            if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
            ?>



                <div class="card card-default color-palette-box">


                    <div class="card-header">
                        <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูลผู้ป่วยของนักศึกษา </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example3" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <div align="center">ลำดับที่ / Order</div>
                                    </th>
                                    <th>HN</th>
                                    <th>คำนำหน้า</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>วันที่รับเข้า</th>
                                    <th>OSLER</th>
                                    <th>วันที่จ่ายออก</th>
                                    <th>สาเหตุ</th>
                                    <th>จัดการข้อมูล</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?PHP
                                include "config.inc.php";
                                $sql   =  " SELECT * FROM tbl_order as o ";
                                $sql  .=  " INNER JOIN  tbl_student   AS s  ON  s.student_id = o.student_id  ";
                                $sql  .=  " where  o.student_id = $student_id ORDER BY o.order_id ASC ";
                                $query = $conn->query($sql);
                                $i = 0;
                                while ($result = $query->fetch_assoc()) {
                                    $i++;
                                    if ($result['HN'] == $hn) {
                                        $bg = "table-success";
                                    } else {
                                        $bg = "";
                                    }
                                    $date_pay = $result['date_pay'];
                                    $causes_of_pay_id = $result['causes_of_pay_id'];
                                    $order_osler = $result['order_osler'];
                                ?>

                                    <tr class="<?php echo $bg; ?>">
                                        <td align="center"><?php echo $i; ?> (<?php echo $result['order_id']; ?>)</td>
                                        <td><?php echo $result['HN']; ?></td>
                                        <td><?php echo $result['pname']; ?></td>
                                        <td><?php echo $result['fname']; ?></td>
                                        <td><?php echo $result['lname']; ?></td>
                                        <td><?php echo $result['order_date']; ?></td>
                                        <td>


                                            <?php

                                            $order_id =  $result['order_id'];
                                            switch ($order_osler) { // Harder page
                                                case 1:
                                                    echo  " <a href='?osler=0&order_id=$order_id' class='btn btn-success'>  OSLER </a>";
                                                    break;
                                                case 0:
                                                    echo  " <a href='?osler=1&order_id=$order_id' class='btn btn-secondary'> NO OSLER </a>";
                                                    break;
                                                default:
                                                    echo  "";
                                                    break;
                                            }
                                            ?>
                                        </td>


                                        <td <?php if($causes_of_pay_id != 0){ echo "class='bg-danger'"; }?>><?php echo $result['date_pay']; ?></td>
                                        <td <?php if($causes_of_pay_id != 0){ echo "class='bg-danger'"; }?>><?php echo nameCauses_of_pay::get_causes_of_pay_name($result['causes_of_pay_id']); ?></td>
                                        <td class="center">

                                            <?PHP
                                            $order_id = $result['order_id'];
                                            include "config.inc.php";
                                            $sql_detail_ck   =  " SELECT * FROM tbl_detail where  order_id = $order_id ";
                                            $query_detail_ck = $conn->query($sql_detail_ck);
                                            if ($result_detail_ck = $query_detail_ck->fetch_assoc()) {
                                            } else {
                                            ?>
                                                <a href="?del=<?php echo $result['order_id']; ?>" class="btn btn-danger" onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> ลบ </a>

                                            <?php } ?>

                                            <?php  // เป็น Teacher  
                                            if (($_SESSION['level_user'] == "Teacher") || ($_SESSION['level_user'] == "Staff")) {
                                            ?>
                                                <a href="" data-toggle="modal" data-target="#modal-default<?php echo $result['order_id']; ?>" class="btn btn-info">
                                                    จ่ายผู้ป่วยออกทั้ง Case </a>


                                              <?php if($causes_of_pay_id != 0){?>
                                                <a href="" data-toggle="modal" data-target="#modal-cancel<?php echo $result['order_id']; ?>" class="btn btn-success"> Cancel จ่ายออก </a>                             
                                             <?php }?>


                                            <?php } ?>


                                            <?php if($causes_of_pay_id == 0){?>
                                             <a href="detail.php?order_id=<?php echo $result['order_id']; ?>&student_id=<?php echo $result['student_id']; ?>" class="btn btn-warning"> เพิ่มงาน + จ่ายงานผู้ป่วยออกเฉพาะงาน  </a>
                                             <?php }?>


                                          

                                        </td>
                                    </tr>


                                    <div class="modal fade" id="modal-cancel<?php echo $result['order_id']; ?>">
                                        <div class="modal-dialog">
                                            <form name="form<?php echo $result['order_id']; ?>" method="post" action="" enctype="multipart/form-data">
                                                <input name="order_id" type="hidden" value="<?php echo $result['order_id']; ?>" />
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> ยืนยันยกเลิกจ่ายผู้ป่วยออก (<?php echo $result['order_id']; ?>)</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo $result['HN']; ?> :
                                                        <?php echo $result['pname']; ?>
                                                        <?php echo $result['fname']; ?>
                                                        <?php echo $result['lname']; ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> ระบุสาเหตุการยกเลิกจ่ายผู้ป่วยออก </label>
                                                                <input name="order_reason" type="text" class="form-control" value="" required >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button name="submit_cancel" type="submit" value="submit" class="btn btn-info"> ยืนยัน </button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                        <font color="red"> 
                                                            <B>คำเตือน..</B><br>
                                                            การยกเลิกจ่ายผู้ป่วยออก จะไม่ยกเลิกการจ่ายออกงาน <br> <B><u>ยกเลิกจ่ายออกงานอีกครั้ง</u></B> 
                                                        </font>
                                                    </div>
                                                </div> <!-- /.modal-content -->
                                            </form>
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    




                                    <div class="modal fade" id="modal-default<?php echo $result['order_id']; ?>">
                                        <div class="modal-dialog">
                                            <form name="form<?php echo $result['order_id']; ?>" method="post" action="" enctype="multipart/form-data">
                                                <input name="order_id" type="hidden" value="<?php echo $result['order_id']; ?>" />
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> จ่ายผู้ป่วยออก (<?php echo $result['order_id']; ?>)</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo $result['HN']; ?> :
                                                        <?php echo $result['pname']; ?>
                                                        <?php echo $result['fname']; ?>
                                                        <?php echo $result['lname']; ?>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> วันที่จ่ายผู้ป่วยออก <font color="red"> ระบุวันที่กรณี จ่ายออกทั้งงานเท่านั้น...!</font></label>
                                                                <input type="date" name="date_pay" id="detail_date_complete" value="<?php echo $date_pay; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label> สาเหตุการจ่ายผู้ป่วยออกทั้งเคส </label>
                                                                <select name="causes_of_pay_id" class="form-control select2">
                                                                    <option value=""> -- เลือก causes_pay -- </option>
                                                                    <?php
                                                                    $sql_causes = "SELECT * FROM tbl_causes_of_pay order by causes_of_pay_id asc  ";
                                                                    $query_causes = $conn->query($sql_causes);
                                                                    while ($row_causes = $query_causes->fetch_assoc()) {
                                                                    ?>
                                                                        <option value="<?php echo $row_causes['causes_of_pay_id']; ?>" <?php if (!(strcmp($row_causes['causes_of_pay_id'], $causes_of_pay_id))) {
                                                                                                                                            echo "selected=\"selected\"";
                                                                                                                                        } ?>>
                                                                            <?php echo $row_causes['causes_of_pay_detail']; ?></option>
                                                                    <?php } ?>
                                                                    <option value="(other)">other</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button name="submit_causes_pay" type="submit" value="submit" class="btn btn-info"> ยืนยัน </button>
                                                                <button type="reset" class="btn btn-default"> Reset </button>
                                                            </div>
                                                        </div>
                                                        <font color="red"> 
                                                            <B>คำเตือน..</B><br>
                                                            การจ่ายผู้ป่วยออกทั้งเคส หมายถึง การง่ายทั้งหมด ของนทพ. ในเคสนี้ <B><u>ออกทั้งหมด</u></B>
                                                            โปรดตรวจสอบให้แน่ใจก่อนทำรายการ อาจทำให้ นทพ.มีปัญหาในการส่งงานในครั้งต่อไปได้
                                                        </font>
                                                    </div>
                                                </div> <!-- /.modal-content -->
                                            </form>
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    





                                <?php } ?>

                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            <?php } ?>



            <?php
            if (isset($_POST['submit_cancel'])) {
                include "config.inc.php";

                if (isset($_POST['order_id'])  && !empty($_POST['order_id'])) {
                    $order_id = $conn->real_escape_string($_POST['order_id']);
                } else {
                    $order_id = "";
                }

                if (isset($_POST['order_reason'])  && !empty($_POST['order_reason'])) {
                    $order_reason = $conn->real_escape_string($_POST['order_reason']);
                } else {
                    $order_reason = "";
                }


                $order_reason_by = $_SESSION['user_id'];
                $order_reason_date = date('Y-m-d H:i:s');

                $sql_up = " UPDATE tbl_order SET 
                causes_of_pay_id = '0',
                date_pay = '0000-00-00',
                order_reason = '$order_reason',
                order_reason_by = '$order_reason_by',
                order_reason_date = '$order_reason_date' WHERE order_id = $order_id ";
                $conn->query($sql_up);
                $conn->close();

                echo "<script type='text/javascript'>";
                //echo "alert('[ OK Success]');";
                echo "window.history.back(1);";
                echo "</script>";

               
            }

          ?>


            <?php
            if (isset($_POST['submit_causes_pay'])) {
                include "config.inc.php";

                if (isset($_POST['order_id'])  && !empty($_POST['order_id'])) {
                    $order_id = $conn->real_escape_string($_POST['order_id']);
                } else {
                    $order_id = "";
                }

                if (isset($_POST['order_osler'])  && !empty($_POST['order_osler'])) {
                    $order_osler = $conn->real_escape_string($_POST['order_osler']);
                } else {
                    $order_osler = 0;
                }

                if (isset($_POST['date_pay'])  && !empty($_POST['date_pay'])) {
                    $date_pay = $conn->real_escape_string($_POST['date_pay']);
                } else {
                    $date_pay = "0000-00-00";
                }


                if (isset($_POST['causes_of_pay_id'])  && !empty($_POST['causes_of_pay_id'])) {
                    $causes_of_pay_id = $conn->real_escape_string($_POST['causes_of_pay_id']);
                } else {
                    $causes_of_pay_id = 0;
                }


                $order_pay_by = $_SESSION['user_id'];
                $detail_date_complete = $date_pay;

                $sql_detail= "SELECT * FROM tbl_detail where order_id = $order_id  ";
                $query_detail = $conn->query($sql_detail);
                while ($row_detail = $query_detail->fetch_assoc()) {


                if(isset($row_detail['causes_of_pay_id']) && !empty($row_detail['causes_of_pay_id'])){    }else{ 

                $detail_id = $row_detail['detail_id'];  

                $sql_up_detail = " UPDATE tbl_detail SET detail_date_complete = '$detail_date_complete' , causes_of_pay_id = '$causes_of_pay_id' , detail_by_staff = '$order_pay_by' WHERE detail_id = $detail_id";
                $conn->query($sql_up_detail);

              //echo "<br>";

                }

             

                }

               echo "<br>";

               echo  $sql_up = " UPDATE tbl_order SET causes_of_pay_id = '$causes_of_pay_id',
                                date_pay = '$date_pay',
                                order_pay_by = '$order_pay_by',
                                order_osler = '$order_osler' WHERE tbl_order.order_id = $order_id ";
                    $conn->query($sql_up);

                echo "<script type='text/javascript'>";
                //echo "alert('[ OK Success]');";
                echo "window.history.back(1);";
                echo "</script>";
            }

            ?>



        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


<?php include "footer.php"; ?>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>



<!-- Page script -->
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last $ Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
</script>

<!-- page script -->

</body>

</html>