<?php include "header.php"; ?>

<?php		 
		function set_format_date($rub){
			if(!empty($rub)){
				list($yyy,$mmm,$ddd) = explode("-",$rub);
				$new_date = $ddd."-".$mmm."-".$yyy;
				return $new_date;
			}
		}
  ?>

<?php

$nohn = 1;
if (isset($_GET['arrange_nohn_date'])) {

	$student_id = $_GET['student_id'];
	$arrange_date = $_GET['arrange_nohn_date'];
} else {

	$student_id = $_GET['student_id'];
	$arrange_date = date('Y-m-d');
}


if (isset($_GET['arrange_nohn_id'])) {
	$arrange_nohn_id = $_GET['arrange_nohn_id'];
} else {
	$arrange_nohn_id = 0;
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

<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">



<?php  include "sweetalert.php"; //  ?>


	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">

				<div class="col-sm-8">
					<h1>ประเมินคะแนนนักศึกษา กรณีไม่มีผู้ป่วย</h1>
				</div>

				<div class="col-sm-4">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
						<li class="breadcrumb-item active">ประเมินคะแนนนักศึกษา</li>
					</ol>
				</div>

			</div>
		</div><!-- /.container-fluid -->
	</section>



	<!-- Main content -->
	<section class="content">

		<div class="row">



			<?php
			include "config.inc.php";

			if (isset($_GET['plan_id'])) {
				$plan_id = $_GET['plan_id'];
			} else {
				$plan_id = "";
			}


			$sql_plan   =  " SELECT * ";
			$sql_plan  .=  " FROM tbl_plan  ";
			$sql_plan  .=  " WHERE plan_id = $plan_id ";
			$query_plan = $conn->query($sql_plan);

			if ($row_plan = $query_plan->fetch_assoc()) {
				$plan_name = $row_plan['plan_name'];
				/* if($row_plan['plan_sub']==1){
						// ค้นหา Sub_plan
						$form_main_id=$row_plan['form_main_id'];
					 }else{
						$form_main_id=$row_plan['form_main_id'];
					 }*/
			} else {

				$form_main_id = 0;
				$plan_name = "";
			}
			?>



			<?php
			// แสดงข้อมูล นักศึกษาที่ ส่งงานมาตามวันที่เลือก
			include "config.inc.php";
			$sql_arrange_nohn_detail = " SELECT a.* ,  p.* , f.*,  t.* ";
			$sql_arrange_nohn_detail .= " FROM (SELECT * FROM tbl_arrange_nohn where arrange_nohn_id = '$arrange_nohn_id'  ) AS a ";
			$sql_arrange_nohn_detail .= " INNER JOIN tbl_plan as p ON p.plan_id = a.plan_id ";
			$sql_arrange_nohn_detail .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id";
			$sql_arrange_nohn_detail .= " INNER JOIN tbl_type_work as t ON t.type_work_id = p.type_work_id ";
			$sql_arrange_nohn_detail .= " ORDER BY a.arrange_nohn_time ASC ";
			$query_arrange_nohn_detail = $conn->query($sql_arrange_nohn_detail);
			$row_arrange_nohn_detail = $query_arrange_nohn_detail->fetch_assoc();
			$arrange_nohn_teacher_id = $row_arrange_nohn_detail['teacher_id'];
			$arrange_teacher_id = $row_arrange_nohn_detail['teacher_id'];

			$type_work_id = $row_arrange_nohn_detail['type_work_id'];

			$arrange_nohn_detail = $row_arrange_nohn_detail['arrange_nohn_detail'];
			$student_id = $row_arrange_nohn_detail['student_id'];
			$arrange_nohn_time_type = $row_arrange_nohn_detail['arrange_nohn_time_type'];

			$form_main_id = $row_arrange_nohn_detail['form_main_id'];
			?>



			<div class="col-md-12">



				<div class="card card-primary">

					<div class="card-header">
						<h3 class="card-title">ข้อมูลผู้ทำการรักษา</h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
								<i class="fas fa-times"></i></button>
						</div>

					</div>



					<div class="card-body">


						<div class="row">


 

							<div class="col-md-6 col-sm-6 col-12">
								<div class="info-box">

									<div class="col-sm-2">

										<img src="../pic_students/<?php echo $row_arrange_nohn_detail['student_id']; ?>.jpg" width="80" height="100" alt="5710810032 นทพ.ทดสอบ ระบบประเมิน" />

									</div>

									<div class="info-box-content">
										<span class="info-box-text"> ผู้ทำการรักษา Operator's Name </span>
										<span class="info-box-number">Code : <?php echo $row_arrange_nohn_detail['student_id']; ?></span>
										<span class="info-box-text">นทพ.<?php echo nameStudent::get_student_name($row_arrange_nohn_detail['student_id']); ?> </span>
									</div>

									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>



							<div class="col-md-6 col-sm-6 col-12">
								<div class="info-box">
									<div class="info-box-content">
										<span class="info-box-text">สาขา / Type Work : <b> <?php echo $row_arrange_nohn_detail['type_work_name']; ?> </b> </span>
										<span class="info-box-text">งาน / Plan : <b> <?php echo $plan_name; ?> </b> </span>
										<span class="info-box-text">อ.ผู้ประเมิน : <b> <?php echo nameTeacher::get_teacher_name($arrange_nohn_teacher_id); ?> </b></span>
										<span class="info-box-text">
											<h5>รายละเอียด : <b><span class='badge bg-info'> <?php echo $arrange_nohn_detail; ?> </span></h5> </b>
										</span>
										<!-- /.	<span class="info-box-text">งานย่อย /Sub plan : <b>-</b> </span>-->
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>


						</div> <!-- /.row -->




					</div>
				</div><!-- Default box -->




				<form id="form1" name="form1" method="post" action="form_evaluate_nohn_q.php">


					<input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>"> <?php // echo $arrange_nohn_id;
																									?>
					<input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>"> <?php // echo $arrange_nohn_id;
																							?>
					<input type="hidden" name="student_id" value="<?php echo $student_id; ?>"> <?php // echo $arrange_nohn_id;?>
							 																	
					<input type="hidden" name="teacher_id" value="<?php echo $arrange_nohn_teacher_id; ?>"> <?php // echo $arrange_nohn_id;
																											?>
					<input type="hidden" name="arrange_nohn_id" value="<?php echo $arrange_nohn_id; ?>"> <?php // echo $arrange_nohn_time_type;
																											?>
					<input type="hidden" name="arrange_nohn_time_type" value="<?php echo $arrange_nohn_time_type; ?>"> <?php //echo $arrange_nohn_time_type;
																														?>
	
	
					<input type="hidden" name="type_nohn" value="1">


					<?php //include "form_evaluate_more.php"; 
					?>
					<?php include "form_evaluate_main.php"; ?>
					<?php include "form_evaluate_holistic.php"; ?>
					
					




					<!-- บันทึกข้อมูลการประเมินคะแนน card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"> บันทึกข้อมูล และ แสดงความคิดเห็น</h3>
						</div>
						<div class="card-body">

							<div class="row">
								แสดงความคิดเห็น
							</div>
							<div class="card-body pad">
								<div class="mb-3">
									<textarea name="comment" rows="20" class="textarea" style="width: 100%; height: 200%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 20px;" placeholder="แสดงความคิดเห็น"><?php echo $field_comment; ?></textarea>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3 col-sm-3 col-6">
									<input type="submit" name="submit" class="btn btn-success" id="button" value="บันทึกข้อมูลการประเมินคะแนน">
								</div>
								<?php if ($check == "Y") {  // หากได้รับการประเมินคะแนนมาแล้ว 
								?>
									<div class="col text-right">
										<?php if ($form_main_format != 1) { ?>
											<a href="?redone=<?php echo $detail_id; ?>&detail_id=<?php echo $detail_id; ?>&plan_id=<?php echo $plan_id; ?>&arrange_nohn_date=<?php echo $arrange_nohn_date; ?>&arrange_nohn_id=<?php echo $arrange_nohn_id; ?>" onClick="return confirm('กรุณายืนยันการ Redone อีกครั้ง !!!')" class="btn btn-info">Redone</a>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>




					<!-- //บันทึกข้อมูลการประเมินคะแนน card -->

				</form>

				<?php include "form_evaluate_conduct.php"; ?>

				<?php include "report_evaluate_main.php"; ?>
				








			</div><!-- /.col 9-->


		</div> <!-- /.row-->



	</section>
	<!-- /.content -->



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
		$('.textarea').summernote()
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



</body>

</html>