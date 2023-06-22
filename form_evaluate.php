<?php include 'header.php'; ?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">


<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

	<?php
	include "config.inc.php";

	if (isset($_GET['plan_id'])) {
		$plan_id = $_GET['plan_id'];
	} else {
		$plan_id = "";
	}

	$sql_plan   =  " SELECT * ";
	$sql_plan  .=  " FROM tbl_plan AS p ";
	$sql_plan  .=  " where plan_id=$plan_id ";
	$query_plan = $conn->query($sql_plan);

	if ($row_plan = $query_plan->fetch_assoc()) {

		$plan_name = $row_plan['plan_name'];

		if ($row_plan['plan_sub'] == 1) {
			// ค้นหา Sub_plan
			$form_main_id = $row_plan['form_main_id'];
		} else {
			$form_main_id = $row_plan['form_main_id'];
		}
	} else {
		$form_main_id = 0;
		$plan_name = "";
	}

	$sql_form_main   =  " SELECT fm.*  , tw.* ";
	$sql_form_main  .=  " FROM (SELECT f.*   FROM tbl_form_main AS f WHERE f.form_main_id = '$form_main_id') AS fm ";
	$sql_form_main  .=  " INNER JOIN  tbl_type_work   AS tw  ON  tw.type_work_id = fm.type_work_id ";
	$query_form_main = $conn->query($sql_form_main);
	$row_form_main = $query_form_main->fetch_assoc();

	?>


	<!-- ส่วนแสดงข้อมูล นักศึกษา  -//////////////////////////////////////->
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-12">
					<h1>แบบฟอร์มการประเมินคะแนนนักศึกษาในคลินิก สาขา : <?php echo $row_form_main['type_work_name']; ?> งาน : <?php echo $plan_name; ?> </h1>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<!-- ส่วนแสดงข้อมูล นักศึกษา  -//////////////////////////////////////->
      <!-- Default box -->

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
								<span class="info-box-number">HN : 620012121</span>
								<span class="info-box-text">นายทดสอบ จำลองผู้ป่วย</span>
							</div>

							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>


					<div class="col-md-6 col-sm-6 col-12">
						<div class="info-box">

							<div class="col-sm-2">
								<a href="imges_student/5710810032.jpg" data-toggle="lightbox" data-title="5710810032 นทพ.ทดสอบ ระบบประเมิน" data-gallery="gallery">
									<img src="imges_student/5710810032.jpg" width="80" height="100" alt="5710810032 นทพ.ทดสอบ ระบบประเมิน" />
								</a>
							</div>

							<div class="info-box-content">
								<span class="info-box-text"> ผู้ทำการรักษา Operator's Name </span>
								<span class="info-box-number">Code : 5710810032</span>
								<span class="info-box-text">นทพ.ทดสอบ ระบบประเมิน</span>
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
								<span class="info-box-text"> สาขา / Type Work : <b> <?php echo $row_form_main['type_work_name']; ?> </b> </span>
								<span class="info-box-text">งาน / Plan : <b> <?php echo $plan_name; ?> </b> </span>
								<span class="info-box-text">งานย่อย /Sub plan : <b>-</b> </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>



					<div class="col-md-6 col-sm-6 col-12">
						<div class="info-box">
							<div class="info-box-content">
								<span class="info-box-text"> วันที่ประเมินล่าสุด : <b>12-08-2020</b> </span>
								<span class="info-box-text"> ผู้ประเมินล่าสุด : <b>อ.ทดสอบ ผู้ประเมิน </b> </span>
								<span class="info-box-text"> Tooth : <b> 18 </b> Class : <b> I-Simple </b> Surface : <b> - </b> Root : <b> - </b> </span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>


				</div> <!-- /.row -->






			</div>



		</div><!-- Default box -->

		<!-- ส่วนแสดงข้อมูล นักศึกษา  -//////////////////////////////////////-->





		<form id="form1" name="form1" method="post" action="form_evaluate_q.php">

			<input type="date" name="last_date" value="" id="">
			<input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">
			<input type="hidden" name="form_main_id" value="<?php echo $form_main_id; ?>">
			<input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">
			<input type="hidden" name="detail_id" value="99999">

			<!-- ฟอร์มเกี่ยวข้อง card -->

			<?php
			$type_work_id = $row_form_main['type_work_id'];
			include "config.inc.php";
			$sql_form_more = "SELECT * FROM tbl_form_more , tbl_type_work where tbl_form_more.type_work_id=tbl_type_work.type_work_id and  tbl_form_more.type_work_id=$type_work_id";
			$query_form_more = $conn->query($sql_form_more);
			while ($row_form_more = $query_form_more->fetch_assoc()) {
			?>

				<div class="card">

					<div class="card-header">
						<h3 class="card-title">รายการฟอร์ม <?php echo $row_form_more['form_more_name']; ?></h3>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
							<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
								<i class="fas fa-times"></i></button>
						</div>
					</div>


					<div class="card-body">
						<div class="row">
							<?php
							$form_more_id = $row_form_more['form_more_id'];
							$sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
							$query_form_detail_more = $conn->query($sql_form_detail_more);
							$i = 0;
							while ($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {
								$i++;
							?>



								<div class="col-md-12  col-12">
									<div class="info-box">

										<div class="col-sm-3">
											<?php echo $row_form_detail_more['form_detail_more_topic']; ?>
										</div>

										<div class="col-sm-9">




											<?php if ($row_form_detail_more['form_detail_more_format'] == "L") { ?>
												<select name="score" class="form-control" required>
													<option value="">-- เลือก --</option>
													<?php

													$step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
													$step2 = count($step1);
													for ($ct = 0; $ct <= $step2; $ct++) {
														$step = $step1[$ct];
														if ($step != "") {
													?>
															<option value="<?php echo $step; ?>"><?php echo $step; ?> </option>
													<?php
														}
													}
													?>
												</select>

											<?php } ?>




											<?php if ($row_form_detail_more['form_detail_more_format'] == "M") { ?>


												<?php

												$stepm1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
												$stepm2 = count($stepm1);

												for ($m = 0; $m <= $stepm2; $m++) {
													if (isset($stepm1[$m])) {
												?>

														<label> <input type="checkbox" name="<?php echo $step; ?>" value="checkbox" id="CheckboxGroup1_0"> <?php echo $stepm1[$m]; ?> </label>
														&nbsp;
												<?php


													} //if
												} //for
												?>


											<?php } ?>







											<?php if ($row_form_detail_more['form_detail_more_format'] == "N") { ?>

												<?php
												$step1 = explode(",", $row_form_detail_more['form_detail_more']); // แยก   
												$step2 = count($step1);
												for ($ct = 0; $ct <= $step2; $ct++) {
													if (isset($step1[$ct])) {
														$step = $step1[$ct];
												?>


														<label>
															<input type="radio" name="<?php echo $row_form_detail_more['form_detail_more_field']; ?>" value="<?php echo $step; ?>" id="RadioGroup1_1">&nbsp; <?php echo $step; ?>
														</label>&nbsp;


												<?php
													}
												}
												?>





											<?php } ?>



											<?php if ($row_form_detail_more['form_detail_more_format'] == "T") { ?>
												<input type="text" name="<?php echo $row_form_detail_more['form_detail_more_field']; ?>" class="form-control">
											<?php } ?>


											<?php if ($row_form_detail_more['form_detail_more_format'] == "D") { ?>
												<textarea name="<?php echo $row_form_detail_more['form_detail_more_field']; ?>" class="form-control"></textarea>
											<?php } ?>




										</div>

										<!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>




							<?php } ?>

							<!-- /.row -->
						</div>
					</div>

				</div> <!-- card -->
				<!-- ฟอร์มเกี่ยวข้อง card -->
			<?php } ?>
			<!-- ฟอร์มเกี่ยวข้อง card -->



			<!-- ส่วนแสดงแบบฟอร์มหลักการประเมิน  -//////////////////////////////////////--->
			<div class="card">

				<div class="card-header">
					<h3 class="card-title">รายการฟอร์มประเมินคะแนน สาขา : <?php echo $row_form_main['type_work_name']; ?>
						ชื่อฟอร์ม : <?php echo $row_form_main['form_main_name']; ?></h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
						<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
							<i class="fas fa-times"></i></button>
					</div>
				</div>


				<div class="card-body">
					<div class="row">
						<div class="col-md-12 col-sm-6 col-12">








							<table id="example3" class="table table-bordered table-striped">
								<thead>
									<tr>

										<th Width="6%">
											<div align="center">ลำดับ</div>
										</th>


										<th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>
										<?php
										include "config.inc.php";
										$sql_check_w = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and weight_type_id!=1";
										$query_check_w = $conn->query($sql_check_w);
										if ($row_check_w = $query_check_w->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  น้ำหนัก,ครั้ง,คะแนน ให้แสดง
										?>

											<th Width="15%">
												<div align="center">น้ำหนัก,ครั้ง,คะแนน</div>
											</th>

										<?php } ?>




										<?php
										include "config.inc.php";
										$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_extra='Y'";
										$query_check_ex = $conn->query($sql_check_ex);
										if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Extra ให้แสดง
										?>

											<th Width="6%">
												<div align="center">Extra</div>
											</th>

										<?php } ?>

										<th Width="10%">
											<div align="center">คะแนน</div>
										</th>

										<?php
										include "config.inc.php";
										$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
										$query_check_ex = $conn->query($sql_check_ex);
										if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
										?>

											<th Width="10%">
												<div align="center">Competency</div>
											</th>

										<?php } ?>



										<?php
										include "config.inc.php";
										$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
										$query_check_ex = $conn->query($sql_check_ex);
										if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Complete ให้แสดง
										?>

											<th Width="10%">
												<div align="center">Complete</div>
											</th>

										<?php } ?>


										<th width="13%">
											<div align="center">ผู้ประเมิน </div>
										</th>
										<th width="14%">
											<div align="center">วันที่ </div>
										</th>



									</tr>
								</thead>





								<tbody>
									<?php
									include "config.inc.php";
									$sql_form_detail = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id ORDER BY form_detail_order ASC";
									$query_form_detail = $conn->query($sql_form_detail);
									$i = 0;
									while ($row_form_detail = $query_form_detail->fetch_assoc()) {
										$i++;
									?>


										<tr>
											<td><?php echo $i; ?></td>

											<td><?php echo $row_form_detail['form_detail_topic']; ?> (<?php echo $row_form_detail['form_detail_field']; ?>) </td>



											<?php if ($row_form_detail['weight_type_id'] == 2) { ?>
												<td>
													<?php echo $row_form_detail['form_detail_weight']; ?>
													<input type="hidden" name="<?php echo $row_form_detail['form_detail_field'] . "_weight"; ?>" value="">

												</td>
											<?php } ?>




											<?php if ($row_form_detail['weight_type_id'] == 3) { ?>
												<td>
													<?php //echo $row_form_detail['form_detail_field']."_weight";
													?>
													<select name="<?php echo $row_form_detail['form_detail_field'] . "_weight"; ?>" class="form-control">


														<?php
														$step1 = explode(",", $row_form_detail['form_detail_weight']); // แยก   
														$step2 = count($step1);
														for ($ct = 0; $ct <= $step2; $ct++) {
															$step = $step1[$ct];
															if ($step != "") {
														?>

																<option value="<?php echo $step; ?>"><?php echo $step; ?></option>

														<?php
															} //if
														} //for
														?>

													</select>
												</td>
											<?php } ?>






											<?php
											include "config.inc.php";
											$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_extra='Y'";
											$query_check_ex = $conn->query($sql_check_ex);
											if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Extra ให้แสดง
											?>

												<?php if ($row_form_detail['form_detail_extra'] == "Y") { ?>
													<td>
														<?php //echo $row_form_detail['form_detail_field']."_extra";
														?>
														<input type="text" name="<?php echo $row_form_detail['form_detail_field'] . "_extra"; ?>" class="form-control" placeholder="">
													</td>
												<?php } else { ?>
													<td></td>
												<?php } ?>

											<?php } ?>










											<td>
												<div align="center"> <?php // การเลือกคะแนน 
																		?>
													<?php $row_form_detail['score_type_id']; ?>
													<?php $score_id = $row_form_detail['score_id']; ?>


													<?php //echo $row_form_detail['form_detail_field']."_grade";
													?>

													<?php if ($row_form_detail['score_type_id'] == 1) { ?>
														<select name="<?php echo $row_form_detail['form_detail_field'] . "_grade"; ?>" class="form-control">
															<option value="">-- N/A --</option>
															<?php
															include "config.inc.php";
															$sql_score_d = "select  *  from tbl_score_detail where score_id=$score_id  ";
															$query_score_d = $conn->query($sql_score_d);
															while ($result_score_d = $query_score_d->fetch_assoc()) {
															?>
																<option value="<?php echo $result_score_d['score_detail_rate']; ?> "><?php echo $result_score_d['score_detail_name']; ?> </option>
															<?php } ?>
														</select>
													<?php } ?>





													<?php if ($row_form_detail['score_type_id'] == 2) { ?>
														<?php //echo $row_form_detail['form_detail_field']."_grade";
														?>
														<input type="text" name="<?php echo $row_form_detail['form_detail_field'] . "_grade"; ?>" class="form-control" placeholder="">
													<?php } ?>

												</div>
											</td>







											<?php
											include "config.inc.php";
											$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
											$query_check_ex = $conn->query($sql_check_ex);
											if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
											?>

												<td>
													<?php if ($row_form_detail['form_detail_competency'] == "Y") { ?>
														<?php //echo $row_form_detail['form_detail_field']."_competency";
														?>
														<input type="checkbox" name="<?php echo $row_form_detail['form_detail_field'] . "_competency"; ?>" class="form-control" value="checkbox" />
													<?php } ?>
												</td>

											<?php } ?>








											<?php
											include "config.inc.php";
											$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
											$query_check_ex = $conn->query($sql_check_ex);
											if ($row_check_ex = $query_check_ex->fetch_assoc()) {  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
											?>

												<td>
													<?php if ($row_form_detail['form_detail_complete'] == "Y") { ?>
														<?php //echo $row_form_detail['form_detail_field']."_complete";
														?>
														<input type="checkbox" name="<?php echo $row_form_detail['form_detail_field'] . "_complete"; ?>" class="form-control" value="checkbox" />
													<?php } ?>
												</td>

											<?php } ?>


											<td>
												<div align="center">

													อ.ผู้ประเมิน
													<?php //echo $row_form_detail['form_detail_field']."_teacher";
													?>
													<input type="hidden" name="<?php echo $row_form_detail['form_detail_field'] . "_teacher"; ?>" value="99">


												</div>
											</td>

											<td>

												<div align="center">
													<?php //echo $row_form_detail['form_detail_field']."_date";
													?>
													<input type="date" name="<?php echo $row_form_detail['form_detail_field'] . "_date"; ?>" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
												</div>

											</td>

										</tr>

									<?php } ?>
								</tbody>









							</table>

						</div> <!-- /.row -->
					</div><!-- row-body -->
				</div> <!-- card-body -->
			</div><!-- card -->
			<!-- ส่วนแสดงแบบฟอร์มหลักการประเมิน  -//////////////////////////////////////-->








			<!-- บันทึกข้อมูลการประเมินคะแนน card -->
			<div class="card">

				<div class="card-header">
					<h3 class="card-title"> บันทึกข้อมูล </h3>
				</div>


				<div class="card-body">
					<div class="row">

						<input type="submit" name="submit" class="btn btn-success" id="button" value="บันทึกข้อมูลการประเมินคะแนน">

					</div>
				</div>
			</div>
			<!-- //บันทึกข้อมูลการประเมินคะแนน card -->




		</form>




	</section>
</div>


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