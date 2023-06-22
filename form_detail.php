<?php include'header.php';?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">


<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	
<?php 
if(isset($_GET['form_main_id'])){
$form_main_id=$_GET['form_main_id'];

}else{
$form_main_id="";
}

include "config.inc.php"; 
	
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
            <h1>แบบฟอร์มการประเมินคะแนนนักศึกษาในคลินิก สาขา : <?php echo $row_form_main['type_work_name'];?> </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
 
 
 
<section class="content">
<!-- ส่วนแสดงแบบฟอร์มหลักการประเมิน  -//////////////////////////////////////--->	
<div class="card">
	  
	  <div class="card-header">
          <h3 class="card-title">รายการฟอร์มประเมินคะแนน สาขา   : <?php echo $row_form_main['type_work_name'];?>
 ชื่อฟอร์ม : <?php echo $row_form_main['form_main_name'];?></h3>





			  <div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
				  <i class="fas fa-times"></i></button>



          <?php if(isset($_GET['show_step'])){  // กด show step ?>  
						<a href="?form_main_id=<?php echo $form_main_id;?>" class="btn btn-info btn-sm"> Hide </a>				
					<?php }else{ ?>
						<a href="?show_step=1&form_main_id=<?php echo $form_main_id;?>" class="btn btn-info btn-sm"> Show </a>				
					<?php } ?>

			  </div>

        
        </div>
		

<div class="card-body">
<div class="row">
<div class="col-md-12 col-sm-6 col-12">
	
				
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>

                <th Width="6%"><div align="center">ลำดับ</div></th>

                    <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>
<?php 
include "config.inc.php"; 
$sql_check_w = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and weight_type_id!=1";
$query_check_w = $conn->query($sql_check_w); 
if($row_check_w = $query_check_w->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  น้ำหนัก,ครั้ง,คะแนน ให้แสดง
?>

                    <th Width="15%"><div align="center">น้ำหนัก,ครั้ง,คะแนน</div></th>

<?php }?>




<?php 
include "config.inc.php"; 
$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_extra='Y'";
$query_check_ex = $conn->query($sql_check_ex); 
if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Extra ให้แสดง
?>

                    <th Width="6%"><div align="center">Extra</div></th>

<?php }?>

					<th Width="10%"><div align="center">คะแนน</div></th>

<?php 
include "config.inc.php"; 
$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
$query_check_ex = $conn->query($sql_check_ex); 
if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
?>

                    <th Width="10%"><div align="center">Competency</div></th>       

<?php }?> 



<?php 
include "config.inc.php"; 
$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
$query_check_ex = $conn->query($sql_check_ex); 
if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Complete ให้แสดง
?>

                        <th Width="10%"><div align="center">Complete</div></th>      

<?php }?> 


                        <th width="13%"><div align="center">ผู้ประเมิน</div></th>
                        <th width="14%"><div align="center">วันที่</div></th>
                      
                      
                     
                </tr>
                </thead>

























<tbody>
<?php 
include "config.inc.php"; 
$sql_form_detail = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id ORDER BY form_detail_order ASC";
$query_form_detail = $conn->query($sql_form_detail); 
$i=0;
while($row_form_detail = $query_form_detail->fetch_assoc()) {
$i++;
?>


                <tr>
                  <td><?php echo $i;?></td>

                  <td><?php echo $row_form_detail['form_detail_topic'];?>  (<?php echo $row_form_detail['form_detail_field'];?>) </td>



                  <?php if($row_form_detail['weight_type_id']==2){ ?>
                  <td><?php echo $row_form_detail['form_detail_weight'];?></td>
                  <?php }?>

                  <?php if($row_form_detail['weight_type_id']==3){ ?>
                  <td>
                  <select name="form_weight" class="form-control" required>
                    <option value=""> เลือก </option>

                    <?php 
                    $step1 = explode(",", $row_form_detail['form_detail_weight']); // แยก   
                    $step2 = count($step1);
                    for( $ct= 0 ; $ct <= $step2 ; $ct++ ){
                    $step = $step1[$ct];
				          	if($step!=""){ 						   
                    ?> 

                    <option value="<?php echo $step;?>"><?php echo $step;?></option>

                    <?php
                        } //if
                    } //for
                    ?>
                    
                    </select></td>
                  <?php }?>









<?php  // / เช็ค มีการเลือก  Extra ให้แสดง
include "config.inc.php"; 
$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_extra='Y'";
$query_check_ex = $conn->query($sql_check_ex); 
if($row_check_ex = $query_check_ex->fetch_assoc()){  
?>
					
                   <?php if($row_form_detail['form_detail_extra']=="Y"){?>
                  <td><input type="text" name="extra" class="form-control"  placeholder=""></td>
                  <?php }else{?>
				  <td> </td>
				  <?php }?>

<?php }?>
					


                  





                    <td><div align="center"> <?php // การเลือกคะแนน ?> 
                    <?php  $row_form_detail['score_type_id'];?> 
                    <?php  $score_id=$row_form_detail['score_id'];?>

                    <?php if($row_form_detail['score_type_id']==1){?>
                      <select name="score" class="form-control" required>
                        <option value="">-- N/A --</option>
                        <?php
                        include"config.inc.php";
                        $sql_score_d = "select  *  from tbl_score_detail where score_id=$score_id  ";
                        $query_score_d = $conn->query($sql_score_d); 
                        while($result_score_d = $query_score_d->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result_score_d['score_detail_rate'];?> "><?php echo $result_score_d['score_detail_name'];?> </option> 
                        <?php }?>
                      </select>
                    <?php }?>

                    <?php if($row_form_detail['score_type_id']==2){?>
                      
                      <input type="text" name="score" class="form-control"  placeholder="">
                    <?php }?>

                    </div></td>

					
					
					



<?php 
include "config.inc.php"; 
$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_competency='Y'";
$query_check_ex = $conn->query($sql_check_ex); 
if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
?>
                    
                    <td>
                    <?php if($row_form_detail['form_detail_competency']=="Y"){?>
                    <input type="checkbox" name="competency" class="form-control" value="checkbox" />
                    <?php }?> 
                    </td>

<?php }?> 
                          



					
					
					

<?php 
include "config.inc.php"; 
$sql_check_ex = "SELECT * FROM tbl_form_detail where tbl_form_detail.form_main_id=$form_main_id and form_detail_complete='Y'";
$query_check_ex = $conn->query($sql_check_ex); 
if($row_check_ex = $query_check_ex->fetch_assoc()){  // เช็คหัวตาราง มีการเลือก  Competency ให้แสดง
?>
                    
                    <td>
                    <?php if($row_form_detail['form_detail_complete']=="Y"){?>
                    <input type="checkbox" name="competency" class="form-control" value="checkbox" />
                     <?php }?>
                    </td>
                    
<?php }?> 
                  

                    <td><div align="center">อ.ผู้ประเมิน </div></td>
                    <td><div align="center"><input type="date" name="checkbox2" class="form-control" value="<?php echo date('Y-m-d');?>"/></div></td>

                 </tr>

<?php } ?>
</tbody>
          
              
              
              
              
              
              
              
              
              </table>
				
			</div> <!-- /.row -->
</div><!-- row-body -->
</div> <!-- card-body -->
</div><!-- card -->
<!-- ส่วนแสดงแบบฟอร์มหลักการประเมิน  -//////////////////////////////////////-	







</section>
</div>


<?php  include'footer.php';?>


<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<!-- page script -->
<script>
  $(function () {
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



