<?php include "header.php"; ?>



<?php


if (isset($_GET['arrange_date'])) {

	$detail_id = $_GET['detail_id'];
	$arrange_date = $_GET['arrange_date'];
} else {

	$detail_id = $_GET['detail_id'];
	$arrange_date = date('Y-m-d');
}


if (isset($_GET['arrange_id'])) {
	$arrange_id = $_GET['arrange_id'];
} else {
	$arrange_id = 0;
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
					<h1>ประเมินคะแนนนักศึกษา LAB </h1>
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
			$sql_arrange_detail = " SELECT a.* , d.* , p.* , f.*, o.* , t.* ";
			$sql_arrange_detail .= " FROM (SELECT * FROM tbl_arrange where arrange_id = '$arrange_id'  ) AS a ";
			$sql_arrange_detail .= " INNER JOIN tbl_detail as d ON d.detail_id = a.detail_id ";
			$sql_arrange_detail .= " INNER JOIN tbl_plan as p ON p.plan_id = d.plan_id ";
			$sql_arrange_detail .= " INNER JOIN tbl_form_main as f ON f.form_main_id = p.form_main_id";
			$sql_arrange_detail .= " INNER JOIN tbl_order as o ON o.order_id = d.order_id";
			$sql_arrange_detail .= " INNER JOIN tbl_type_work as t ON t.type_work_id = p.type_work_id ";
			$sql_arrange_detail .= " ORDER BY a.arrange_time ASC ";
			$query_arrange_detail = $conn->query($sql_arrange_detail);
			$row_arrange_detail = $query_arrange_detail->fetch_assoc();
			$arrange_teacher_id = $row_arrange_detail['teacher_id'];
			$arrange_detail = $row_arrange_detail['arrange_detail'];
			$student_id = $row_arrange_detail['student_id'];
			$arrange_time_type = $row_arrange_detail['arrange_time_type'];
			$arrange_type = $row_arrange_detail['arrange_type'];



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
										<a href="imges_student/img_1866.jpg" data-toggle="lightbox" data-title="HN : 620012121 นายทดสอบ จำลองผู้ป่วย" data-gallery="gallery">
											<img src="imges_student/img_1866.jpg" width="80" height="100" alt="นายทดสอบ จำลองผู้ป่วย" />
										</a>
									</div>

									<div class="info-box-content">
										<span class="info-box-text"> ผู้ป่วย Patient's Name </span>
										<span class="info-box-number">HN : <?php echo $row_arrange_detail['HN']; ?></span>
										<span class="info-box-text"><?php echo $row_arrange_detail['pname']; ?><?php echo $row_arrange_detail['fname']; ?> <?php echo $row_arrange_detail['lname']; ?></span>
										<span class="info-box-text">วันที่รับเข้า : <?php echo $row_arrange_detail['detail_date_work']; ?></span>

										<?php
										$order_osler = $row_arrange_detail['order_osler'];
										switch ($order_osler) { // Harder page
											case 1:
												echo  "<i class='fas fa-check-circle' style='font-size:24px;color:green'></i> OSLER";
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

									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>


							<div class="col-md-6 col-sm-6 col-12">
								<div class="info-box">

									<div class="col-sm-2">
										
											<img src="../pic_students/<?php echo $row_arrange_detail['student_id']; ?>.jpg" width="80" height="100" alt="5710810032 นทพ.ทดสอบ ระบบประเมิน" />

									</div>

									<div class="info-box-content">
										<span class="info-box-text"> ผู้ทำการรักษา Operator's Name </span>
										<span class="info-box-number">Code : <?php echo $row_arrange_detail['student_id']; ?></span>
										<span class="info-box-text">นทพ.<?php echo nameStudent::get_student_name($row_arrange_detail['student_id']); ?> </span>
									</div>

									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>


						</div> <!-- /.row -->






						<div class="row">

							<div class="col-md-6 col-sm-6 col-12">
								<div class="info-box">
									<div class="info-box-content">
										<span class="info-box-text">สาขา / Type Work : <b> <?php echo $row_arrange_detail['type_work_name']; ?> </b> </span>
										<span class="info-box-text">งาน / Plan : <b> <?php echo $plan_name; ?> </b> </span>
										<span class="info-box-text">อ.ผู้ประเมิน : <b> <?php echo nameTeacher::get_teacher_name($arrange_teacher_id); ?> </b></span>


										<?php if(!empty($arrange_detail)){?>
										<span class="info-box-text">
											<h5>รายละเอียด : <b><span class='badge bg-info'> <?php echo $arrange_detail; ?> </span></h5> </b>
										</span>
										<?php }?>



										<!-- /.	<span class="info-box-text">งานย่อย /Sub plan : <b>-</b> </span>-->
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>


							<?php
							$form_main_id = $row_arrange_detail['form_main_id'];
							include "config.inc.php"; // เช็ครายละเอียด
							$sql_form_main = "SELECT * FROM tbl_form_main where form_main_id='$form_main_id' ";
							$query_form_main = $conn->query($sql_form_main);
							$result_form_main = $query_form_main->fetch_assoc();


							$form_main_detail = $result_form_main['form_main_detail'];
							$array_form_main_detail = json_decode($form_main_detail, true);
							?>





















							<div class="col-md-6 col-sm-6 col-12">
								<div class="info-box">
									<div class="info-box-content">
										<span class="info-box-text"> วันที่ประเมินล่าสุด : <b> 12-08-2020 </b> </span>
										<span class="info-box-text"> ผู้ประเมินล่าสุด : <b> อ.ทดสอบ ผู้ประเมิน </b> </span>
										<span class="info-box-text">
											<?php if (in_array("t", $array_form_main_detail)) { ?>


												Tooth :



												<?php
												$array_detail_tooth = (array)json_decode($row_arrange_detail['detail_tooth']);
												?>
												<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal_tooth">
													Open tooth (<?php echo $array_detail_tooth[0]; ?>)
												</button>
											<?php } ?>

											<!-- The Modal -->
											<div class="modal" id="myModal_tooth">
												<div class="modal-dialog modal-xl">
													<div class="modal-content">

														<!-- Modal Header -->
														<div class="modal-header">
															<h4 class="modal-title"> Tooth </h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>

														<!-- Modal body -->
														<div class="modal-body">

														<?php include "tooth.php";?>
															
														</div>




														<!-- Modal footer -->
														<div class="modal-footer">
															<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
														</div>

													</div>
												</div>
											</div>



											<?php if (in_array("c", $array_form_main_detail)) { ?> Class : <b> <?php echo $row_arrange_detail['class_id']; ?> </b> <?php } ?>
											<?php if (in_array("s", $array_form_main_detail)) { ?> Surface : <b> <?php echo $row_arrange_detail['detail_surface']; ?> </b> <?php } ?>
											<?php if (in_array("r", $array_form_main_detail)) { ?> Root : <b> <?php echo $row_arrange_detail['detail_root']; ?> </b> <?php } ?>


											<?php include "evaluate_edit.php"; ?>
										</span>
									</div>
									<!-- /.info-box-content -->
								</div>
								<!-- /.info-box -->
							</div>


						</div> <!-- /.row -->


					</div>
				</div><!-- Default box -->




				<form id="form1" name="form1" method="post" action="form_evaluate_lab_q.php">

					<input type="hidden" name="student_id" value="<?php echo $student_id; ?>"> <?php // echo $arrange_id;
																								?>
					<input type="hidden" name="teacher_id" value="<?php echo $arrange_teacher_id; ?>"> <?php // echo $arrange_id;
																										?>
					<input type="hidden" name="arrange_time_type" value="<?php echo $arrange_time_type; ?>"> <?php // echo $arrange_time_type;
																												?>


					<?php include "form_evaluate_more.php"; ?>
					<?php include "form_evaluate_main.php"; ?>
					<?php //include "form_evaluate_holistic.php"; ?>
					<?php //include "form_evaluate_conduct.php"; ?>




					<!-- บันทึกข้อมูลการประเมินคะแนน card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"> บันทึกข้อมูล และ แสดงความคิดเห็น</h3>
						</div>
						<div class="card-body">
							<?php 
							
							if ($row_arrange_detail['detail_complete'] == 0) {
								$detail_complete = "";
							} else {
								$detail_complete = "checked";
							}

							if ($row_arrange_detail['detail_competency'] == 0) {
								$detail_competency = "";
							} else {
								$detail_competency = "checked";
							}



							
							?>

							<div class="row">

								<div class="form-group clearfix">
									<div class="icheck-danger d-inline">
										<input type="checkbox" name="Complete" id="Complete" value="1" <?php echo $detail_complete; ?>>
										<label for="Complete">
											Complete
										</label>
									</div>
								</div>
								
							</div>


						<!--
							<div class="row">

								<div class="form-group clearfix">
									<div class="icheck-success d-inline">
										<input type="checkbox" name="competency" id="competency" value="1" <?php echo $detail_competency; ?>>
										<label for="competency">
										Competency
										</label>
									</div>
								</div>
								
							</div>
						-->


						<?php if($type_work_id!=6){ // สาขา CB ไม่ติ๊ก Competency หน้าประเมิน ?>
							<div class="row">
								<div class="form-group clearfix">
									<div class="icheck-success d-inline">
										<input type="checkbox" name="competency" id="competency" value="1" <?php echo $detail_competency; ?>>
										<label for="competency">
											Competency 
										</label>
										<font color="blue">(**เมื่อติ๊ก Competency หมายถึง ต้องการนับงานนี้เป็น Competency )</font>
									</div>
								</div>
							</div>
						<?php } ?>




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
											<a href="?redone=<?php echo $detail_id; ?>&detail_id=<?php echo $detail_id; ?>&plan_id=<?php echo $plan_id; ?>&arrange_date=<?php echo $arrange_date; ?>&arrange_id=<?php echo $arrange_id; ?>" onClick="return confirm('กรุณายืนยันการ Redone อีกครั้ง !!!')" class="btn btn-info">Redone</a>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>




					<!-- //บันทึกข้อมูลการประเมินคะแนน card -->

				</form>



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