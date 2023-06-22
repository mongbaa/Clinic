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


    <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-sm-6">
            <h1 class="m-0">DB E-Clinic</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
               <li class="breadcrumb-item active"> <?php echo date('d-m-Y');?></li>
             </ol>
           </div><!-- /.col -->
         </div><!-- /.row -->
       </div><!-- /.container-fluid -->
    </div>
     <!-- /.content-header -->
          


          

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <?php
        function mixTextColor($length)
        {
         // $colors = array('default', 'primary', 'secondary', 'success', 'info', 'danger', 'warning');

          $colors = array('secondary');
          // $result = substr(str_shuffle($text), 0, $length); 
          for ($i = 0; $i < $length; $i++) {
            echo $colors[array_rand($colors)];
          }
        }
        ?>


        <!-- Small boxes (Stat box) -->
        <div class="row">

     
              <?PHP 

$id = "";
              include "config.inc.php"; 	
              $tables = array();
              $sql="SHOW TABLES FROM {$dbName};"; 
              $query= $conn->query($sql); 
              while($result = $query->fetch_assoc()) 
              { 

             $Tables=$result["Tables_in_{$dbName}"];

              $sql_size="SELECT table_name AS {$Tables},round(((data_length + index_length) / 1024 / 1024), 3) Size_in_MB
              FROM information_schema.TABLES WHERE table_schema = '{$dbName}' AND table_name = '{$Tables}'";
              $query_size= $conn->query($sql_size); 
              $result_size = $query_size->fetch_assoc();

              
        

              $id = substr($Tables,4,100)."_id";
              $name_tabel = substr($Tables,4,100);

            
              ?>

                      <div class="col-12 col-sm-3 col-md-2">
                          <div class="info-box">
                            <span class="info-box-icon bg-<?php echo mixTextColor(1); ?> elevation-1"><i class="fas fa-database"></i></span>

                              <div class="info-box-content">
                              <span class="info-box-text"> <?php echo $name_tabel;?> </span>
                              <span class="info-box-number">
                              <?php echo $result_size['Size_in_MB'];?> Size in MB 
                              </span>
                        
                               <a href="CodeMirror.php?Tables=<?php echo $Tables;?>">  CODE </a>
                             
                              </div>
                            <!-- /.info-box-content -->
                          </div>
                        <!-- /.info-box -->
                        </div>
                        
       <?php } ?>	
        
      
        </div>





          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->


      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

              
                
<?php include "footer.php";?>