<?php include "header.php"; ?>


<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">



<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

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





<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1> <i class="fas fa-sign-out-alt"></i>Send Order Div 2 </h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li class="breadcrumb-item active"> QR-code Tag</li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>



<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">




				<div class="card">
					<div class="card-header">
						<h3 class="card-title"> <i class="fas fa-tags"></i> Data JOB Tag </h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">

						<table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>HN</th>
								<th>คำนำหน้า</th>
								<th>ชื่อ</th>
								<th>นามสกุล</th>
								<th>นทพ.</th>
                        	</tr>
							</thead>
						</table>

					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->











			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>



<?php include "footer.php"; ?>


<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<!--<script src="dist/js/adminlte.min.js"></script>-->


<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>



<script>
$(document).ready(function() {
    $('#example1').DataTable( {
       responsive : true, "lengthChange": false, "autoWidth": false,
       ordering : true,
       paging : true,
       lengthChange : true,
       fixedHeader : true,
      
        processing : true,
		    serverSide : true,
        "ajax": {
				"url" : "case_order_serverside_aj.php",
				"type" : "POST"
		   	},

        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
      
        buttons: [
             {  extend : 'pageLength',
                text: 'Page',
                className:'red',
                className : 'btn btn-info'
             } ,'excel', 'print' , 

             {
                extend: 'colvis',
                text: 'Column',
                className : 'btn btn-info'
               
             }

             ],
            
    } );
} );
            





</script>










</body>

</html>