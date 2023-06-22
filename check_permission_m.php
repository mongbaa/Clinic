<?PHP include "header.php";

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

//$username = $_SESSION['username'];

include "config.inc.php";

//$doctorcode = $_SESSION["doctorcode"];

// ตรวจสอบ ระดับ 


$sql_teacher = "SELECT * FROM tbl_teacher where teacher_loginname = '{$_POST["username"]}' ";
$query_teacher = $conn->query($sql_teacher);

$sql_student = "SELECT * FROM tbl_student where student_id = '{$_POST["username"]}' ";
$query_student = $conn->query($sql_student);

$sql_staff = "SELECT * FROM tbl_staff where staff_loginname = '{$_POST["username"]}' ";
$query_staff = $conn->query($sql_staff);




/*
$sql_teacher = "SELECT * FROM tbl_teacher where teacher_doctorcode ='$doctorcode' and teacher_status = 1 ";
$query_teacher = $conn->query($sql_teacher);

$sql_student = "SELECT * FROM tbl_student where student_doctorcode = '$doctorcode'  ";
$query_student = $conn->query($sql_student);

$sql_staff = "SELECT * FROM tbl_staff where staff_doctorcode = '$doctorcode' and staff_status = 1 ";
$query_staff = $conn->query($sql_staff);
*/


if ($result_teacher  = $query_teacher->fetch_assoc()) {

 $_SESSION["type_work_id"] = $result_teacher['type_work_id'];
 $_SESSION["teacher"] = 1;
 $_SESSION["user_id"] = $result_teacher['teacher_id'];
 $_SESSION["level_user"] = "Teacher";
 $level = "Teacher";
 $permission = "Y";


 $_SESSION["sessid"] = session_id();
 $_SESSION["doctorcode"] = $result_teacher["teacher_doctorcode"];
 $_SESSION["loginname"] = $result_teacher["teacher_loginname"];
 $_SESSION['pname'] = "อ.";
 $_SESSION['fname'] = $result_teacher["teacher_name"];
 $_SESSION['lname'] = $result_teacher["teacher_surname"];
 $_SESSION['doctor_type_id'] = 3;
 

} else if ($result_student  = $query_student->fetch_assoc()) {
  
 $_SESSION["student"] = 1;
 $_SESSION["user_id"] = $result_student['student_id'];
 $_SESSION["level_user"] = "Student";
 $level = "Student";
 $permission = "Y";

$_SESSION['username'] = $result_student["student_id"];



 $_SESSION["sessid"] = session_id();
 $_SESSION["doctorcode"] = $result_student["student_doctorcode"];
 $_SESSION["loginname"] = $result_student["student_id"];
 $_SESSION['pname'] = "นทพ.";
 $_SESSION['fname'] = $result_student["student_name"];
 $_SESSION['lname'] = $result_student["student_lastname"];
 $_SESSION['doctor_type_id'] = 1;



 
} else if ($result_staff = $query_staff->fetch_assoc()) {
   

   
 $_SESSION["staff"] = 1;
 $_SESSION["user_id"] = $result_staff['staff_id'];
 $_SESSION["level_user"] = "Staff";
 $level = "Staff";
 $permission = "Y";
 $_SESSION["staff_level"] = $result_staff['staff_level'];

 

 $_SESSION["sessid"] = session_id();
 $_SESSION["doctorcode"] = $result_staff["staff_doctorcode"];
 $_SESSION["loginname"] = $result_staff["staff_loginname"];
 $_SESSION['pname'] = "";
 $_SESSION['fname'] = $result_staff["staff_name"];
 $_SESSION['lname'] = $result_staff["staff_surname"];
 $_SESSION['doctor_type_id'] = 4;




} else {

 $level = "N";
 $permission = "N";

 echo "<META http-equiv=refresh content=1;url=login_m.php>";
 exit();

}

?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">ตรวจสอบสิทธิเข้าใช้งานระบบ</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<section class="content">
    <div class="container-fluid">



        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        ตรวจสอบสิทธิเข้าใช้งานระบบ
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            ยินดีต้อนรับเข้าใช้งานระบบ คลีนิกรวมนักศึกษา (e-clinic)
                        </h5>
                        <br>

                        <h1>
                            <?php echo  $_SESSION['loginname']; ?> :
                            <?php echo  $_SESSION['fname']; ?> <?php echo  $_SESSION['lname'];?> -->>
                            <?php echo  $level;?>

                        </h1>


                        <?PHP if ($permission == "Y") { ?>
                        <p class="card-text" style="color:blue"> ท่านมีสิทธิในการเข้าใช้ระบบ!! </p>
                      
   

 <?php // อนุญาติให้เข้าใช้ระบบ
    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR']; 
    echo "<b>IP Address :</b> ".$REMOTE_ADDR; 
    echo " >> ";
    $REMOTE_ADDR_substr = substr($REMOTE_ADDR, 0,6);
 ?>

<?php if( $REMOTE_ADDR_substr == "10.151"){ ?>
ท่านเข้าระบบภายนอกโรงพยาบาล
<?php }else{ ?>
ท่านเข้าระบบภายในโรงพยาบาล
<?php } ?>

   

<?php echo "<META http-equiv=refresh content=1;url=index.php>";?>



















                        <?php }else{?>
                        <p class="card-text" style="color:red"> ท่านยังไม่มีสิทธิในการเข้าใช้ระบบ
                            กรุณาติดต่อเจ้าหน้าที่..!! </p>
                        <?php echo "<META http-equiv=refresh content=6;url=logout.php>";?>
                        <?php }?>
                        <p class="card-text">กรุณารอสักครู่....!! <img src="images/01-progress.gif" width="120"
                                height="100" /></p>
                        <a href="logout.php" class="btn btn-primary">ออกจากระบบ</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>








<?php include "footer.php";?>


<script>
$(document).ready(function() {
    $("#myModal").modal('show');
});
</script>