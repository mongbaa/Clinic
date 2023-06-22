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

<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">




<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">

			<div class="col-sm-8">
				<h1>หักคะแนนนักศึกษา</h1>
			</div>

			<div class="col-sm-4">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
					<li class="breadcrumb-item active">หักคะแนนนักศึกษา</li>
				</ol>
			</div>

		</div>
	</div><!-- /.container-fluid -->
</section>



<?php
include "sweetalert.php"; //

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

if (isset($_GET['type_work_id'])) {
	$type_work_id = $_GET['type_work_id'];
} else {
	$type_work_id = "";
}

$student_id = $student_search;

$arrange_teacher_id = $_SESSION["user_id"];

$arrange_date = date('Y-m-d');

$timestamp = time();
$arrange_time_type = date('A', $timestamp);

?>

<section class="content">
	<div class="row">
		<div class="col-md-12">


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
							</div>

							<input type="hidden" name="level_search" value="<?php echo $level_search; ?>">


							<div class="col-sm-3">
								<div class="form-group">

									<select name="type_work_id" id="type_work_id" class="form-control select2" onchange="this.form.submit()" required>
										<option value="0"> ทุกสาขา </option>
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
										$conn->close();
										?>
									</select>
								</div>
							</div>



							<div class="col-sm-3">
								<div class="form-group">
									<select name="student_search" id="student_search" class="form-control select2" onchange="this.form.submit()" required>

										<option value=""> เลือก </option>
										<?php include "config.inc.php";
										$sql_student = "SELECT * FROM  tbl_student where student_active = 1 and student_level = $level_search";
										$query_student = $conn->query($sql_student);
										while ($result_student = $query_student->fetch_assoc()) {
										?>
											<option value="<?php echo $result_student['student_id']; ?>" <?php if (!(strcmp($result_student['student_id'], $student_id))) {
																												echo "selected=\"selected\"";
																											} ?>>
												<?php echo $result_student['student_id']; ?> <?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></option>
										<?php } ?>
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



			<?php include "form_evaluate_conduct.php"; ?>


		</div>
	</div>
</section>







<?php include "footer2.php"; ?>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>



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



<script>
	$(function() {
		// Summernote
		$('.textarea').summernote({
			placeholder: 'แสดงความคิดเห็น',
			tabsize: 2,
			height: 200
		})
	})
</script>







<!-- page script Tooltip -->
<script type="text/javascript">
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
<!-- page script Tooltip -->


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
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
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


<!-- page script Tooltip -->
<script type="text/javascript">
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
<!-- page script Tooltip -->

</body>

</html>