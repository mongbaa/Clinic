<?php include"header.php";?>


  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">DB Clinic New 2021</h1>
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
<?PHP 
include "config.inc.php"; 	
$tables = array();
$sql="SHOW TABLES FROM {$dbName};"; 
$query= $conn->query($sql); 
while($result = $query->fetch_assoc()) 
{ 
 $Tables=$result["Tables_in_{$dbName}"];


$sql_size="SELECT table_name AS {$Tables},round(((data_length + index_length) / 1024 / 1024), 2) Size_in_MB
FROM information_schema.TABLES WHERE table_schema = '{$dbName}' AND table_name = '{$Tables}'";
$query_size= $conn->query($sql_size); 
$result_size = $query_size->fetch_assoc();
	
	
//(postgres)
	
	
?>

				<div class="col-12 col-sm-3 col-md-2">
						<div class="info-box">
						  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

							  <div class="info-box-content">
								<span class="info-box-text"> <?php echo $Tables;  ?></span>
								<span class="info-box-number">
								<?php echo $result_size['Size_in_MB'];?> Size in MB
								 
								</span>
							  </div>
						  <!-- /.info-box-content -->
						</div>
					<!-- /.info-box -->
				  </div>
<?php } ?>	
	
</div>								
										
									
		</div>
	</section>
</div>  
	  
	  
 <?php include"footer.php";?>


<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- page script -->
<script>
  $(function () {
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
</body>
</html>
