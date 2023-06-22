<?php include "header.php"; 

if (!isset($_SESSION['level_user'])) {
    //header('Location: index.php');
    exit;
}

?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons 
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
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
<!-- Google Font: Source Sans Pro 
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,$00" rel="stylesheet">-->




<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">

			<div class="col-sm-8">
				<h1>ระบบบันทึกกรณีไม่มีผู้ป่วยส่วนกลาง</h1>
			</div>

			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
					<li class="breadcrumb-item active">ข้อมูลบันทึกกรณีไม่มีผู้ป่วย</li>
				</ol>
			</div>

		</div>
	</div><!-- /.container-fluid -->
</section>



<?php
include "sweetalert.php"; //


if ($_SESSION['level_user'] == "Student") {
 $student_id = $_SESSION['user_id'];
}


if (($_SESSION['level_user'] == "Staff") && ($_SESSION['staff_level'] == 2)) {
	$student_id = '5510810060';
}



$teacher_id = $_SESSION["user_id"];
$no_patient_date = date('Y-m-d');
$no_patient_time = time('H:i:s');
$timestamp = time();
$no_patient_time_type = date('A', $timestamp);
$action_plan_edit = 0;
$clinic_id_edit = 0;
$cause_id_edit = 0;
$location_id_edit = 0;


if (!empty($student_id)) {
	include "config.inc.php";
	$sql_check_tell   =  " SELECT  * ";
	$sql_check_tell  .=  " FROM tbl_no_patient as np where  student_id = '$student_id' ORDER BY no_patient_id DESC LIMIT 1;";
	$query_check_tell = $conn->query($sql_check_tell);
	if ($result_check_tell = $query_check_tell->fetch_assoc()) {
		$check_tell  = $result_check_tell['no_patient_tell'];
	} else {
		$check_tell  = '';
	}
} else {
	$check_tell  = '';
}

									
?>


<section class="content">
	<div class="row">
		<div class="col-md-12">





			<div class="row">

				<div class="col-3">
					<div class="card card-default color-palette-box">
						<div class="card-header bg-info">
							<h3 class="card-title"> <i class="fa fa-address-book"></i> บันทึกกรณีไม่มีผู้ป่วยส่วนกลาง </h3>
						</div>
						<div class="card-body">


							<form name="myForm" id="myForm" action="" method="POST">

								<div class="col-12">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>รหัสนักศึกษา</label>
												<input type="text" name="student_id" class="form-control " id="student_id" value="<?php echo $student_id; ?>" readonly required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>เบอร์ติดต่อ</label>
												<input type="text" name="no_patient_tell" class="form-control " id="no_patient_tell" value="<?php echo $check_tell;?>" placeholder="เบอร์ติดต่อ ระบุ... " required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>วันที่ </label>
												<input type="date" name="no_patient_date" class="form-control" placeholder="วันที่" value="<?php echo date('Y-m-d'); ?>" readonly>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>ช่วงเวลา </label>
												<select name="no_patient_time_type" class="form-control select2" style="width: 100%;" required>
													<option value="AM" selected="selected"> เช้า </option>
													<option value="PM"> บ่าย </option>
												</select>
											</div>
										</div>
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label>คลินิกที่ลงปฏิบัติงานตามตาราง</label>
										<select name="clinic_id" id="clinic_id" class="form-control select2" required>
											<option value=""> เลือก งานของสาขา </option>
											<?php
											include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
											$sql_clinic = "SELECT * FROM tbl_clinic where clinic_status = 1 ";
											$query_clinic = $conn->query($sql_clinic);
											while ($result_clinic = $query_clinic->fetch_assoc()) {
											?>
												<option value="<?php echo $result_clinic['clinic_id']; ?>">
													<?php echo $result_clinic['clinic_name']; ?>
												</option>
											<?php
											}
											?>
										</select>
									</div>
								</div>


								<!-- jQuery -->
								<script src="plugins/jquery/jquery.min.js"></script>
								<script type="text/javascript">
									function update() {
										var select = document.getElementById('cause_id');
										var option = select.options[select.selectedIndex];
										var cause_other = document.getElementById("cause_other");
										if (option.value == 6) {
											console.log(option.value);
											cause_other.disabled = false;
											cause_other.focus();
											document.getElementById('div_hide').style.display = 'block';
										} else {
											cause_other.disabled = true;
											document.getElementById('div_hide').style.display = 'none';
										}
									}
									update();
								</script>

								<style>
									.hide {
										display: none;
									}
								</style>


								<div class="col-md-12">
									<div class="form-group">
										<label> สาเหตุ </label>
										<select name="cause_id" id="cause_id" class="form-control select2" required onChange="update()">
											<option value=""> เลือก งานของสาขา </option>
											<?php
											include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
											$sql_cause = "SELECT * FROM tbl_cause where cause_status = 1 ";
											$query_cause = $conn->query($sql_cause);
											while ($result_cause = $query_cause->fetch_assoc()) {
											?>
												<option value="<?php echo $result_cause['cause_id']; ?>">
													<?php echo $result_cause['cause_name']; ?>
												</option>
											<?php
											}
											?>
										</select>
									</div>

									<div id="div_hide" class="hide">
										<div class="col-md-12">
											<div class="form-group">
												<div class="form-group">
													<label class="col-form-label" for=""> สาเหตุอื่นๆ ระบุ... </label>
													<input type="text" name="cause_other" class="form-control " id="cause_other" disabled="disabled" value="" placeholder="ระบุ ..." required>
												</div>
												<hr>
											</div>
										</div>
									</div>
								</div>


				
								<script type="text/javascript">
									function action_plan() {
										var select = document.getElementById('action_plan_id');
										var option = select.options[select.selectedIndex];
										var action_other = document.getElementById("action_other");
										if (option.value == 7) {
											console.log(option.value);
											action_other.disabled = false;
											action_other.focus();
											document.getElementById('div_hide_action').style.display = 'block';
										} else {
											action_other.disabled = true;
											document.getElementById('div_hide_action').style.display = 'none';
										}
									}
									update();
								</script>

								<style>
									.hide {
										display: none;
									}
								</style>

								<div class="col-md-12">
									<div class="form-group">
										<label> แผนการปฏิบัติงานอื่นในคาบ </label>
										<select name="action_plan_id" id="action_plan_id" class="form-control select2" required onChange="action_plan()">
											<option value=""> เลือก แผนการปฏิบัติงานอื่นในคาบ </option>
											<?php
											include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
											$sql_action_plan = "SELECT * FROM tbl_action_plan where action_plan_status = 1 ";
											$query_action_plan = $conn->query($sql_action_plan);
											while ($result_action_plan = $query_action_plan->fetch_assoc()) {
											?>
												<option value="<?php echo $result_action_plan['action_plan_id']; ?>">
													<?php echo $result_action_plan['action_plan_name']; ?>
												</option>
											<?php
											}
											?>
										</select>
									</div>
									<div id="div_hide_action" class="hide">
										<div class="col-md-12">
											<div class="form-group">
												<div class="form-group">
													<label class="col-form-label" for=""> แผนการปฏิบัติงานอื่นในคาบ อื่นๆ ระบุ... </label>
													<input type="text" name="action_other" class="form-control " id="action_other" disabled="disabled" value="" placeholder="ระบุ ..." required>
												</div>
												<hr>
											</div>
										</div>
									</div>
								</div>



								<script type="text/javascript">
									function location_() {
										var select = document.getElementById('location_id');
										var option = select.options[select.selectedIndex];
										var location_clinic = document.getElementById("location_clinic");
										var location_other = document.getElementById("location_other");



										if (option.value == 6) { //คลินิก (โปรดระบุสาขา)
											console.log(option.value);
											location_clinic.disabled = false;
											location_clinic.focus();
											document.getElementById('div_hide_clinic').style.display = 'block';
										} else {
											location_clinic.disabled = true;
											document.getElementById('div_hide_clinic').style.display = 'none';
										}


										if (option.value == 7) { //อื่นๆ โปรดระบุ ......
											console.log(option.value);
											location_other.disabled = false;
											location_other.focus();
											document.getElementById('div_hide_location').style.display = 'block';
										} else {
											location_other.disabled = true;
											document.getElementById('div_hide_location').style.display = 'none';
										}


									}
									update();
								</script>

								<div class="col-md-12">
									<div class="form-group">
										<label> สถานที่ที่ปฏิบัติงาน </label>
										<select name="location_id" id="location_id" class="form-control select2" required onChange="location_()">
											<option value=""> เลือก สถานที่ที่ปฏิบัติงาน </option>
											<?php
											include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
											$sql_location = "SELECT * FROM tbl_location where location_status = 1 ";
											$query_location = $conn->query($sql_location);
											while ($result_location = $query_location->fetch_assoc()) {
											?>
												<option value="<?php echo $result_location['location_id']; ?>" <?php if (!(strcmp($result_location['location_id'], $location_id_edit))) {
																													echo "selected=\"selected\"";
																												} ?>>
													<?php echo $result_location['location_name']; ?>
												</option>
											<?php
											}
											?>
										</select>
									</div>


									<div id="div_hide_clinic" class="hide">
										<div class="col-md-12">
											<div class="form-group">
												<div class="form-group">
													<label class="col-form-label" for=""> สาขาที่ปฏิบัติงาน หรือ คลินิกที่ปฏิบัติงาน </label>
													<select name="location_clinic" id="location_clinic" class="form-control select2" disabled="disabled" required>
														<option value=""> เลือก สาขาที่ปฏิบัติงาน หรือ คลินิกที่ปฏิบัติงาน </option>
														<?php
														include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
														$sql_type_work = "SELECT * FROM tbl_type_work ";
														$query_type_work = $conn->query($sql_type_work);
														while ($result_type_work = $query_type_work->fetch_assoc()) {
														?>
															<option value="<?php echo $result_type_work['type_work_name']; ?>">
																<?php echo $result_type_work['type_work_name']; ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
												<hr>
											</div>
										</div>
									</div>



									<div id="div_hide_location" class="hide">
										<div class="col-md-12">
											<div class="form-group">
												<div class="form-group">
													<label class="col-form-label" for=""> สถานที่อื่นๆ ระบุ... </label>
													<input type="text" name="location_other" class="form-control " id="location_other" disabled="disabled" value="" placeholder="ระบุ ..." required>
												</div>
												<hr>
											</div>
										</div>
									</div>


								</div>


								<div class="col-12">
									<div align="center">
										<input type="submit" name="Submit_no_patient" class="btn btn-outline-primary  btn-block" value="บันทึกกรณีไม่มีผู้ป่วยส่วนกลาง" />
									</div>
								</div>


							</form>



						</div>
					</div>
				</div>









				<?php
				if (isset($_POST['Submit_no_patient'])) {


					include "config.inc.php";

					/*
	foreach($_POST as $key => $value) {
		$_POST[$key] = $conn->real_escape_string($value);
	}
	*/

					if (isset($_POST['no_patient_id'])  && !empty($_POST['no_patient_id'])) {
						$no_patient_id = $conn->real_escape_string($_POST['no_patient_id']);
					} else {
						$no_patient_id = "";
					}

					if (isset($_POST['student_id'])  && !empty($_POST['student_id'])) {
						$student_id = $conn->real_escape_string($_POST['student_id']);
					} else {
						$student_id = "";
					}
					if (isset($_POST['teacher_id'])  && !empty($_POST['teacher_id'])) {
						$teacher_id = $conn->real_escape_string($_POST['teacher_id']);
					} else {
						$teacher_id = "";
					}
					if (isset($_POST['clinic_id'])  && !empty($_POST['clinic_id'])) {
						$clinic_id = $conn->real_escape_string($_POST['clinic_id']);
					} else {
						$clinic_id = 0;
					}
					if (isset($_POST['cause_id'])  && !empty($_POST['cause_id'])) {
						$cause_id = $conn->real_escape_string($_POST['cause_id']);
					} else {
						$cause_id = 0;
					}
					if (isset($_POST['cause_other'])  && !empty($_POST['cause_other'])) {
						$cause_other = $conn->real_escape_string($_POST['cause_other']);
					} else {
						$cause_other = '';
					}
					if (isset($_POST['action_plan_id'])  && !empty($_POST['action_plan_id'])) {
						$action_plan_id = $conn->real_escape_string($_POST['action_plan_id']);
					} else {
						$action_plan_id = 0;
					}
					if (isset($_POST['action_other'])  && !empty($_POST['action_other'])) {
						$action_other = $conn->real_escape_string($_POST['action_other']);
					} else {
						$action_other = '';
					}
					if (isset($_POST['location_id'])  && !empty($_POST['location_id'])) {
						$location_id = $conn->real_escape_string($_POST['location_id']);
					} else {
						$location_id = 0;
					}
					if (isset($_POST['location_clinic'])  && !empty($_POST['location_clinic'])) {
						$location_other = $conn->real_escape_string($_POST['location_clinic']);
					} else {
						
						
						if (isset($_POST['location_other'])  && !empty($_POST['location_other'])) {
							$location_other = $conn->real_escape_string($_POST['location_other']);
						} else {
							$location_other = "";
						}

					}
					
					if (isset($_POST['no_patient_tell'])  && !empty($_POST['no_patient_tell'])) {
						$no_patient_tell = $conn->real_escape_string($_POST['no_patient_tell']);
					} else {
						$no_patient_tell = "";
					}
					if (isset($_POST['no_patient_date'])  && !empty($_POST['no_patient_date'])) {
						$no_patient_date = $conn->real_escape_string($_POST['no_patient_date']);
					} else {
						$no_patient_date = date('Y-m-d');
					}
					if (isset($_POST['no_patient_time'])  && !empty($_POST['no_patient_time'])) {
						$no_patient_time = $conn->real_escape_string($_POST['no_patient_time']);
					} else {
						$no_patient_time = date('H:i:s');
					}
					if (isset($_POST['no_patient_time_type'])  && !empty($_POST['no_patient_time_type'])) {
						$no_patient_time_type = $conn->real_escape_string($_POST['no_patient_time_type']);
					} else {
						$no_patient_time_type = '';
					}


					$no_patient_status = 1;
					$ip_log   = $_SERVER['REMOTE_ADDR'];
					$date_log = date('Y-m-d H:i:s');
					$by_log   = $_SESSION['username'];


					if (isset($no_patient_id)  && !empty($no_patient_id)) {

						$no_patient_log  = "UP|" . $date_log . "|" . $ip_log . "|$by_log/";

						$sql = "";
					} else {

						$no_patient_log  = "IN|" . $date_log . "|" . $ip_log . "|$by_log/";

						$sql = "INSERT INTO tbl_no_patient (no_patient_id, teacher_id, student_id, clinic_id, cause_id, cause_other, action_plan_id, action_other, location_id, location_other, no_patient_tell, no_patient_date, no_patient_time, no_patient_time_type, no_patient_status, no_patient_log) VALUES (NULL, '$teacher_id', '$student_id', '$clinic_id', '$cause_id', '$cause_other', '$action_plan_id', '$action_other', '$location_id', '$location_other', '$no_patient_tell', '$no_patient_date', '$no_patient_time', '$no_patient_time_type', '$no_patient_status', '$no_patient_log');";
						$conn->query($sql);

						$_SESSION['do'] = 'success';
					}

					$conn->close();
					echo "<script type='text/javascript'>";
					echo "window.location='no_patient.php?do=success';";
					echo "</script>";

				}
				?>


<?php if (!empty($student_id)) { ?>
				<div class="col-9">

					<div class="card card-default color-palette-box">
						<div class="card-header">
							<h3 class="card-title"> <i class="fa fa-address-book"></i>  ข้อมูลบันทึกกรณีไม่มีผู้ป่วยส่วนกลาง </h3>
						</div>
						<div class="card-body">

							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>
											<div align="center">#</div>
										</th>
										<th >วันที่</th>
										<th style="width:20%;">รหัส</th>
										<th>ตารางคลินิก</th>
										<th>สาเหตุ</th>
										<th>ปฏิบัติงาน</th>
										<th>สถานที่</th>
										<th>สถานะ</th>
									</tr>
								</thead>

								<tbody>
									<?PHP
									include "config.inc.php";
									$sql   =  " SELECT  * ";
									$sql  .=  " FROM tbl_no_patient as np ";
									$sql  .=  " INNER JOIN  tbl_clinic      	AS cli 		ON  np.clinic_id 		= cli.clinic_id ";
									$sql  .=  " INNER JOIN  tbl_cause        	AS cau  	ON  np.cause_id	 		= cau.cause_id ";
									$sql  .=  " INNER JOIN  tbl_action_plan  	AS ac   	ON  np.action_plan_id	= ac.action_plan_id ";
									$sql  .=  " INNER JOIN  tbl_location  		AS l  		ON  np.location_id 		= l.location_id ";
									$sql  .=  " INNER JOIN  tbl_student 		AS s  		ON  np.student_id 		= s.student_id ";
									$sql  .=  " where  1=1  and np.student_id = $student_id ";
									$sql  .=  " ORDER BY np.no_patient_id ASC ";
									$query = $conn->query($sql);
									$i = 0;
									while ($result = $query->fetch_assoc()) {
										$i++;
									?>

										<tr class="odd gradeX">
											<td align="center"><?php echo $i; ?></td>
											<td> <?php $date = date_create($result['no_patient_date']);
													echo date_format($date, "d-m-Y"); ?> (<?php echo $result['no_patient_time_type']; ?>)</td>
											<td> <?php echo $result['student_id']; ?> <br> <?php echo $result['student_name']; ?> <?php echo $result['student_lastname']; ?></td>
											<td> <?php echo $result['clinic_name']; ?> </td>
											<td> <?php echo $result['cause_name']; ?> <?php echo $result['cause_other']; ?> </td>
											<td> <?php echo $result['action_plan_name']; ?> <?php echo $result['action_other']; ?> </td>
											<td> <?php echo $result['location_name']; ?> <?php echo $result['location_other']; ?> </td>
											<td> <?php echo $result['no_patient_tell']; ?> </td>
										</tr>
									<?php } ?>

								</tbody>
							</table>



						</div><!-- /.card-body -->
					</div><!-- /.card -->


				</div>
<?php } ?>

			</div>

		</div>
	</div>
</section>

<?php include 'footer.php'; ?>


<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<!-- page script -->
<script>
	$(function() {
		$("#example1").DataTable();
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false,
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

	})
</script>






<script>
	$(document).ready(function() {
		$("#myModal").modal('show');
	});
</script>




<script type="text/javascript">
	/*$(document).ready(function() {
$('#type_work_id').change(function() {
$.ajax({
type: 'POST',
data: {type_work_id: $(this).val()},
url: 'select_plan.php',
success: function(data) {
$('#plan_id').html(data);
}
});
return false;
});
});*/
</script>


</body>

</html>