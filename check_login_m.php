<?PHP
 session_start();
 include "config.inc.php";


$sql_teacher = "SELECT * FROM tbl_teacher where teacher_loginname = '{$_POST["username"]}' ";
$query_teacher = $conn->query($sql_teacher);

$sql_student = "SELECT * FROM tbl_student where student_id = '{$_POST["username"]}' ";
$query_student = $conn->query($sql_student);

$sql_staff = "SELECT * FROM tbl_staff where staff_loginname = '{$_POST["username"]}' ";
$query_staff = $conn->query($sql_staff);



echo "<script language='javascript'>";
echo "window.location='index.php' ";
echo "</script>";


 /*
 include "config.inc_hosxp.php";	

					$sql =
						"   SELECT  o.loginname, o.passweb, o.doctorcode,
									d.pname, d.fname, d.lname, d.doctor_type_id
									FROM opduser o
										LEFT JOIN doctor d ON d.code = o.doctorcode
									WHERE d.active = 'Y'
									AND o.loginname = '{$_POST["username"]}'
									
									";

				//$sql .=	" AND d.doctor_type_id NOT IN ('1', '2', '3')  AND o.passweb = '" . md5($_POST["password"]) . "'";
				//mongkol	 $sql .=	"  AND o.passweb = '" . md5($_POST["password"]) . "'";
								
					$query = mysqli_query($conn_hosxp, $sql);
					$rows = mysqli_num_rows($query);
					$result = mysqli_fetch_assoc($query);
					if ($rows > 0) {

						$_SESSION["sessid"] = session_id();
						$_SESSION["doctorcode"] = $result["doctorcode"];
						$_SESSION["loginname"] = $result["loginname"];
						$_SESSION['pname'] = $result["pname"];
						$_SESSION['fname'] = $result["fname"];
						$_SESSION['lname'] = $result["lname"];
						$_SESSION['doctor_type_id'] = $result["doctor_type_id"];




					    $doctorcode = $result["doctorcode"];
						$doctor_type_id = $result["doctor_type_id"];

						if( $doctor_type_id == 1 || $doctor_type_id == 2 ) {

							$student_id = $result["loginname"];
							$student_name = $result["fname"];
							$student_lastname =  $result["lname"];
							$student_doctorcode = $result["doctorcode"];
							$student_log = date('Y-m-d H:i:s');

					     	$sql_student = "SELECT * FROM tbl_student where student_doctorcode = '$doctorcode' ";
							$query_student = $conn->query($sql_student);
							if ($result_student  = $query_student->fetch_assoc()) {

								$sql_update = "UPDATE tbl_student SET student_name = '$student_name', student_lastname = '$student_lastname', student_log = '$student_log' WHERE tbl_student.student_id = '$student_id'";
								$conn->query($sql_update); 

							}else{

								$sql_in = "INSERT INTO tbl_student (student_id, student_name, student_lastname, student_level, student_group, student_active, lstudent_licences, student_doctorcode, student_status, student_log) VALUES ('$student_id', '$student_name', '$student_lastname', '4', '', '0', '0', '$student_doctorcode', '1','$student_log');";
								$conn->query($sql_in); 

							}





						} else if ( $doctor_type_id == 3 || $doctor_type_id == 4) { 



							$teacher_doctorcode = $result["doctorcode"];
							$teacher_loginname = $result["loginname"];
							$teacher_name = $result["fname"];
							$teacher_surname =  $result["lname"];
							$teacher_log = date('Y-m-d H:i:s');


							$sql_teacher = "SELECT * FROM tbl_teacher where teacher_doctorcode ='$doctorcode' ";
							$query_teacher = $conn->query($sql_teacher);
							if ($result_teacher  = $query_teacher->fetch_assoc()) {
							
								$sql_update = "UPDATE tbl_teacher SET teacher_loginname = '$teacher_loginname', teacher_name = '$teacher_name',	teacher_surname = '$teacher_surname', teacher_log = '$teacher_log' WHERE tbl_teacher.teacher_doctorcode = $teacher_doctorcode";
								$conn->query($sql_update); 

							}else{

								$sql_in = "INSERT INTO tbl_teacher (teacher_id, teacher_doctorcode, teacher_loginname, teacher_name, teacher_surname, type_work_id, teacher_licences_status, teacher_status, teacher_log) VALUES (NULL, '$teacher_doctorcode', '$teacher_loginname', '$teacher_name', '$teacher_surname', '0', '0', '1', '$teacher_log');";
								$conn->query($sql_in); 

							}

						}else{  

							$staff_doctorcode = $result["doctorcode"];
							$staff_loginname = $result["loginname"];
							$staff_name = $result["fname"];
							$staff_surname =  $result["lname"];
							$staff_log = date('Y-m-d H:i:s');

							

							$sql_staff = "SELECT * FROM tbl_staff where staff_doctorcode = '$doctorcode' ";
							$query_staff = $conn->query($sql_staff);
							if ($result_staff  = $query_staff->fetch_assoc()) {

								$sql_update = "UPDATE tbl_staff SET staff_name = '$staff_name',	staff_surname = '$staff_surname', staff_log = '$staff_log' WHERE tbl_staff.staff_doctorcode = $staff_doctorcode";
								$conn->query($sql_update); 

							}else{
								
								$sql_in = "INSERT INTO tbl_staff (staff_id, staff_doctorcode, staff_loginname, staff_name, staff_surname, staff_level, staff_status, staff_log) VALUES (NULL, '$staff_doctorcode', '$staff_loginname', '$staff_name', '$staff_surname', '1', '1', '$staff_log');";
								$conn->query($sql_in); 

							}

						}






						if ($_SESSION['username'] = $result['loginname']) {
							echo "<script language='javascript'>";
							//echo "window.location='index.php' ";
							echo "window.location='check_permission_m.php' ";
							//echo "window.location='check_permission.php' ";
							echo "</script>";
						} else {
							echo "<script language='javascript'>";
							echo "alert('คุณไม่มีสิทธิ์เข้าใช้งานระบบ');window.location='index.php'";
							echo "</script>";
						}


						
					} else {
						echo "<script language='javascript'>";
						echo "alert('Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง..!!');window.location='login_m.php'";
						echo "</script>";
					}




*/







					
