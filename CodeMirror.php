<?php include "header.php"; ?>



<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
<!-- CodeMirror -->
<link rel="stylesheet" href="plugins/codemirror/codemirror.css">
<link rel="stylesheet" href="plugins/codemirror/theme/monokai.css">
<!-- SimpleMDE -->
<link rel="stylesheet" href="plugins/simplemde/simplemde.min.css">


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">E-tools Bestpower-engineering</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active"> <?php echo date('d-m-Y'); ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->




        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            โค้ดหน้าเพจหลัก
                        </h3>
                    </div>
                    <!-- /.card-header -->



                    <div class="card-body p-0">
                        <textarea  rows="30" cols="200">
<?php echo '<?php include "header.php"; ?>'; ?>    

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


  <!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
                                  


<?php echo '<?php'; ?>   

if(isset($_GET['edit']))  {

                                include "config.inc.php"; 
                                <?php
                                $Tables = $_GET['Tables'];
                                $id = substr($Tables, 4, 1000);
                                ?>

                                $sql_edit = "SELECT * FROM <?php echo $Tables; ?> where <?php echo $id; ?>_id='$_GET[edit]' "; 
                                $query_edit = $conn->query($sql_edit); 
                                $result_edit = $query_edit->fetch_assoc();

                                <?php
                               
                                $sql_t1 = "select COLUMN_NAME As field_name from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '{$Tables}' ";
                                $query_t1 = $conn->query($sql_t1);
                                while ($result_t1  = $query_t1->fetch_assoc()) {
                                  $field = $result_t1['field_name'];
                                ?>
$<?php echo $field; ?> = $result_edit['<?php echo $field; ?>'];
                                <?php } ?>

                          }else{
                                  
                                <?php
                                $query_t1 = $conn->query($sql_t1);
                                while ($result_t1  = $query_t1->fetch_assoc()) {
                                  $field = $result_t1['field_name'];
                                ?>
$<?php echo $field; ?> = "";
                                <?php } ?>

                          }
      
if(isset($_GET['del'])) {

                              include "config.inc.php"; 
                              $sql_del= "DELETE FROM <?php echo $Tables; ?> WHERE <?php echo $Tables; ?>.<?php echo $id; ?>_id = $_GET[del]";
                              $conn->query($sql_del); 
                          
                              echo <?php echo '"'; ?><script type='text/javascript'><?php echo '";'; ?>

                             // echo <?php echo '"alert('; ?>'[บันทึกข้อมูสำเร็จ]');<?php echo '";'; ?>

                              echo <?php echo '"'; ?>window.location='<?php echo $id; ?>.php';<?php echo '";'; ?>

                              echo <?php echo '"'; ?></script><?php echo '";'; ?>
        
                        }
    
<?php echo '?>'; ?>  


<?php
$Tables = $_GET['Tables'];
$name_page = substr($Tables, 4, 1000);
?>

 <!-- Content Header (Page header) -->
 <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo strtoupper($name_page); ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Data <?php echo $name_page; ?></li>
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



<?php
$Tables = $_GET['Tables'];
$name_page = substr($Tables, 4, 1000);
?>

<form name="form1" method="post" action="">  
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">เพิ่มข้อมูล <?php echo $name_page; ?> </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"> เพิ่มข้อมูล <?php echo $name_page; ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
           
       
			   <div class="row">
        
        <?php
        $choice = "";
        
        $sql_t1 = "SELECT COLUMN_NAME As field_name, DATA_TYPE As field_type , COLUMN_COMMENT As field_commint FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '{$Tables}' ";
        $query_t1 = $conn->query($sql_t1);
        while ($result_t1  = $query_t1->fetch_assoc()) {
          $field_name = $result_t1['field_name'];

          $commints = "";
          $field_commints = $result_t1['field_commint'];
          $commints = explode(",", $field_commints);

          if (isset($commints[0])) {     //field_commint
            $field_commint = $commints[0];
          }

          if (isset($commints[1])) {    //field_types
            $field_types = $commints[1];
          }

          if (isset($commints[2])) {   //field_choice
            $field_choice = $commints[2];
          } else {
            $field_choice = "";
          }
          $field_type = $result_t1['field_type'];
        ?>

                <?php if ($field_types == "hidden") {   // hidden  
                ?>
                <input name="<?php echo $field_name; ?>" type="<?php echo $field_types; ?>" value="<?php echo "<?php echo $$field_name;?>"; ?>" />


                <?php } else if ($field_types == "select") {  // select 




                  $field_name_id  = substr($field_name, -2);
                  $field_name_id_table  = substr($field_name, 0, -3);
                  if ($field_name_id == "id") {  // หากฟิลที่แสดงเป็น ID ให้แสดง list ของ ตารางนั้น
                ?>

                                  <div class="col-sm-3">
                                      <div class="form-group">
                                      <label><?php echo $field_commint; ?> </label>
                                        <select name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" class="form-control select2"  required>
                                          <option value=""> เลือก <?php echo $field_commint; ?> </option>
                                           <?php echo '<?php include "config.inc.php";'; ?> 
                                           $sql_<?php echo $field_name_id_table; ?> = "SELECT * FROM  tbl_<?php echo $field_name_id_table; ?> where <?php echo $field_name_id_table; ?>_status = 1";
                                           $query_<?php echo $field_name_id_table; ?> = $conn->query($sql_<?php echo $field_name_id_table; ?>);
                                           while ($result_<?php echo $field_name_id_table; ?>  = $query_<?php echo $field_name_id_table; ?>->fetch_assoc()) {
                                           <?php echo '?>'; ?> 
                                              <option value="<?php echo '<?php echo $result_' . $field_name_id_table . '[' . "'$field_name'" . '];?>'; ?>" <?php echo '<?php if (!(strcmp($result_' . $field_name_id_table . '[' . "'$field_name'" . '],$' . $field_name . '))) {echo "selected=\"selected\""; }?>'; ?>> <?php echo '<?php echo $result_' . $field_name_id_table . '[' . "'{$field_name_id_table}_name'];?>"; ?></option>               
                                          <?php echo '<?php  }  ?>'; ?> 
                                          </select>
                                      </div>
                                    </div>




                                  <?php
                                } else { /// หากไม่ใช่ ID แสดงค่า ที่ใส่ไว้
                                  ?>
                                    <div class="col-sm-3">
                                      <div class="form-group">
                                      <label><?php echo $field_commint; ?></label>
                                        <select name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" class="form-control select2" required>
                                          <option value=""> เลือก <?php echo $field_commint; ?> </option>
                                          <?php
                                          $choice = explode(":", $field_choice);
                                          for ($i_c = 0; $i_c < count($choice); $i_c++) {

                                            if (isset($field_choice)) {

                                              $choice_list = explode("=", $choice[$i_c]);

                                              if (isset($choice_list[0])) {
                                                $choice_list0 = $choice_list[0];
                                              }
                                              if (isset($choice_list[1])) {
                                                $choice_list1 = $choice_list[1];
                                              }
                                          ?>
                                              <option value="<?php echo $choice_list0; ?>" <?php echo '<?php if (!(strcmp(' . $choice_list0 . ',$' . $field_name . '))) { echo "selected=\"selected\""; } ?>'; ?>><?php echo $choice_list1; ?></option>
                                          <?php
                                              $choice_list0 = "";
                                              $choice_list1 = "";
                                            }
                                          } ?>
                                        </select>
                                      </div>
                                    </div>
                                  <?php } ?>
              <?php } else if ($field_types == "number") {  // select  ?>
              <div class="col-sm-3">
                        <div class="form-group">
                        <label><?php echo $field_commint; ?></label>
                          <input type="<?php echo $field_types; ?>" name="<?php echo $field_name; ?>" class="form-control" placeholder="<?php echo $field_commint; ?>"  step="0.01" value="<?php echo "<?php echo $$field_name;?>"; ?>" required>
                        </div>
                      </div>
              
               <?php } else { // text ?>
              <div class="col-sm-3">
                        <div class="form-group">
                        <label><?php echo $field_commint; ?></label>
                          <input type="<?php echo $field_types; ?>" name="<?php echo $field_name; ?>" class="form-control" placeholder="<?php echo $field_commint; ?>"  value="<?php echo "<?php echo $$field_name;?>"; ?>" required>
                        </div>
                      </div>
               <?php } ?>



               
 <?php } ?>



				</div>
     
                            </div><!-- /.card-body -->

        <div class="card-footer text-muted">
                <div class="col-sm-12">
                      <div class="form-group">
                    
                      <?php echo '<?php if (isset($_GET['; ?>'edit'])){?>
                        <button name="submit" type="submit" value="submit" class="btn btn-info"> Edit</button>   
                        <a href="?" class="btn btn-default"></i> Cancel </a>
                      <?php echo '<?php }else{ ?>'; ?> 
                        <button name="submit" type="submit" value="submit" class="btn btn-info"> Submit </button>   
                        <button type="reset" class="btn btn-default"> Reset </button>                   
                      <?php echo '<?php } ?>'; ?> 
                      
                      </div>
                </div>

      </div>


                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card card-secondary -->

</form>

<?php echo '<?php'; ?>   

if(isset($_POST['submit']))  {
include "config.inc.php"; 


<?php

$sql_t1 = "SELECT COLUMN_NAME As field_name, DATA_TYPE As field_type , COLUMN_COMMENT As field_commint FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '{$Tables}' ";
$query_t1 = $conn->query($sql_t1);
while ($result_t1  = $query_t1->fetch_assoc()) {
  $field_name = $result_t1['field_name'];
  $field_commint = $result_t1['field_commint'];
  $field_type = $result_t1['field_type'];
  if ($field_type == 'int') {
    $values = 0;
  } else {
    $values = "''";
  }
?>

if( isset($_POST['<?php echo $field_name; ?>'])  && !empty($_POST['<?php echo $field_name; ?>']) ){ $<?php echo $field_name; ?> = $conn -> real_escape_string($_POST['<?php echo $field_name; ?>']); }else{ $<?php echo $field_name; ?> = <?php echo $values; ?>;}
<?php } ?>



<?php
$field_name_list = "INSERT INTO $Tables (";
$field_name_value = "";
$field_name_up = "UPDATE $Tables SET ";

$sql_t1 = "SELECT COLUMN_NAME As field_name, DATA_TYPE As field_type , COLUMN_COMMENT As field_commint FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '{$Tables}' ";
$query_t1 = $conn->query($sql_t1);
while ($result_t1  = $query_t1->fetch_assoc()) {
  $field_name = $result_t1['field_name'];
  $field_commint = $result_t1['field_commint'];
  $field_type = $result_t1['field_type'];



  $field_name_list .= "$field_name,";

  $check_id = $name_page . "_id";
  if ($field_name == $check_id) {

    $field_name_up .= "";
    $field_name_value .= "NULL,";
  } else {
    $field_name_value .= "'$$field_name',";
    $field_name_up .= "$field_name = '$$field_name', ";
  }
}
$field_name_list .= "";
$field_name_list_s = substr($field_name_list, 0, -1);

$field_name_value .= "";
$field_name_value = substr($field_name_value, 0, -1);


$field_name_up .= "";
$field_name_up_s = substr($field_name_up, 0, -2);

?>

if(!empty($<?php echo $name_page; ?>_id)){  

$sql_up= "<?php echo $field_name_up_s; ?> WHERE  <?php echo $check_id; ?> = '$<?php echo $check_id; ?>'";
$conn->query($sql_up); 

}else{

$sql_in= " <?php echo $field_name_list_s; ?>) VALUES (<?php echo $field_name_value; ?>)";
$conn->query($sql_in); 	

}



echo <?php echo '"'; ?><script type='text/javascript'><?php echo '";'; ?>

echo <?php echo '"alert('; ?>'[บันทึกข้อมูสำเร็จ]');<?php echo '";'; ?>

echo <?php echo '"'; ?>window.location='<?php echo $id; ?>.php';<?php echo '";'; ?>

echo <?php echo '"'; ?></script><?php echo '";'; ?>


}

<?php echo '?>'; ?>   













<?php
$Tables = $_GET['Tables'];
$name_page = substr($Tables, 4, 1000);
?>


   <!-- Default box -->
      <div class="card">
            <div class="card-header">
              <h3 class="card-title"> Data <?php echo strtoupper($name_page); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
           <tr>
              <th>#</th>
    <?php
    include "config.inc.php";
    $sql_t1 = "SELECT COLUMN_NAME As field_name, DATA_TYPE As field_type , COLUMN_COMMENT As field_commint FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '{$Tables}' ";
    $query_t1 = $conn->query($sql_t1);
    while ($result_t1  = $query_t1->fetch_assoc()) {
      $field_name = $result_t1['field_name'];
      // $field_commint = $result_t1['field_commint'];
      $field_type = $result_t1['field_type'];





      $commints = "";
      $field_commints = $result_t1['field_commint'];
      $commints = explode(",", $field_commints);

      if (isset($commints[0])) {     //field_commint
        $field_commint = $commints[0];
      }

      if (isset($commints[1])) {    //field_types
        $field_types = $commints[1];
      }

      if (isset($commints[2])) {   //field_choice
        $field_choice = $commints[2];
      } else {
        $field_choice = "";
      }
      $field_type = $result_t1['field_type'];




      $check_id = $name_page . "_id"; // สร้างตัวแปร ID ขึ้นมาใหม่
      if ($field_name != $check_id) {  // ถ้าตัวแปร ไม่ตรงกัน กับ ID ให้ แสดง ข้อมูล
    ?>
                <th><?php echo $field_commint; ?></th>
    <?PHP }
    } ?>
                <th>จัดการข้อมูล</th>
            </tr>
          </thead>
          <tbody>

          <?PHP echo "<?PHP"; ?>
          include "config.inc.php"; 				
          $sql =" SELECT * FROM <?php echo $Tables; ?> as <?php echo $name_page; ?> ";
          $sql.=" ORDER BY <?php echo $name_page; ?>.<?php echo $name_page; ?>_id ASC ";							
          $query= $conn->query($sql); 
          $i=0;
          while($result = $query->fetch_assoc()) 
          { $i++;
          ?> 
          <tr>
           <td><?php echo '<?php echo $i;?>'; ?></td>
   <?php
    include "config.inc.php";
    $sql_t1 = "SELECT COLUMN_NAME As field_name, DATA_TYPE As field_type , COLUMN_COMMENT As field_commint FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '{$Tables}' ";
    $query_t1 = $conn->query($sql_t1);
    while ($result_t1  = $query_t1->fetch_assoc()) {
      $field_name = $result_t1['field_name'];
      //$field_commint = $result_t1['field_commint'];
      $field_type = $result_t1['field_type'];

      $check_id = $name_page . "_id"; // สร้างตัวแปร ID ขึ้นมาใหม่
      if ($field_name != $check_id) {  // ถ้าตัวแปร ไม่ตรงกัน กับ ID ให้ แสดง ข้อมูล

        $commints = "";
        $field_commints = $result_t1['field_commint'];
        $commints = explode(",", $field_commints);

        if (isset($commints[0])) {     //field_commint
          $field_commint = $commints[0];
        }

        if (isset($commints[1])) {    //field_types
          $field_types = $commints[1];
        }

        if (isset($commints[2])) {   //field_choice
          $field_choice = $commints[2];
        } else {
          $field_choice = "";
        }
        $field_type = $result_t1['field_type'];

    ?>
            <?php
            if ($field_types == "select") {  // select 
              $field_name_id  = substr($field_name, -2);
              if ($field_name_id == "id") {  // หากฟิลที่แสดงเป็น ID 
            ?>
                <td><?php echo '<?php echo '; ?>$result['<?PHP echo $field_name; ?>']; <?php echo '?>'; ?> </td>
                <?php } else { ?>
                  <td>
                  <?php echo '<?php'; ?>  
                          $manage_store_status = $result['<?PHP echo $field_name; ?>'];
                          switch ($manage_store_status) { // Harder page
                            <?php
                            $choice = explode(":", $field_choice);
                            for ($i_c = 0; $i_c < count($choice); $i_c++) {
                              if (isset($field_choice)) {
                                $choice_list = explode("=", $choice[$i_c]);

                                if (isset($choice_list[0])) {
                                  $choice_list0 = $choice_list[0];
                                }
                                if (isset($choice_list[1])) {
                                  $choice_list1 = $choice_list[1];
                                }
                            ?>
                          case <?php echo $choice_list0; ?> :   echo  "<?php echo $choice_list1; ?>"; break;
                          <?php
                                $choice_list0 = "";
                                $choice_list1 = "";
                              }
                            } ?>
                          default :  echo  "-"; break;	  
                          }
                    <?php echo '?>'; ?>  
                    </td>
                <?php } ?>
           <?php } else { ?>
                    <td><?php echo '<?php echo '; ?>$result['<?PHP echo $field_name; ?>']; <?php echo '?>'; ?> </td>
           <?php } ?>
   <?PHP }
    } ?>
          <td>
            <a href="?edit=<?php echo '<?php echo '; ?>$result['<?PHP echo $name_page; ?>_id'];<?php echo '?>'; ?>" class="btn btn-info">  <i class="fas fa-edit"></i> Edit </a>
            <a href="?del=<?php echo '<?php echo '; ?>$result['<?PHP echo $name_page; ?>_id'];<?php echo '?>'; ?>"  class="btn btn-danger" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> <i class="fas fa-trash-alt"></i> Delete </a>  
            </td>
          </tr>
          <?PHP echo "<?php } ?>"; ?>

          </tbody>
          </table>
          </div><!-- /.card-body -->

<!-- /.card-footer-->
</div>
<!-- /.card -->












         </div>
            <!-- /.col-12 -->
      </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
   </section>
<!-- /.content -->


<?php echo '<?php include "footer.php"; ?>'; ?>       
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

<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>



<!-- Page specific script -->
<script>
$(function () {
  $("#example1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "ordering": true,
    "paging": true,
    "lengthChange": true,
    //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });
  $('#example3').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  });
});
</script>      




    <!-- Page specific script -->
    <script>
        $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
        });
    </script>            
</textarea>
                    </div>
                    <div class="card-footer">
                        โค้ดหน้าเพจหลัก รวม SQL ดึงข้อมูลการแก้ไขและลบรายการ ในหน้าเดียวกัน
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->







    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->



<?php include "footer.php"; ?>


<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- CodeMirror -->
<script src="plugins/codemirror/codemirror.js"></script>
<script src="plugins/codemirror/mode/css/css.js"></script>
<script src="plugins/codemirror/mode/xml/xml.js"></script>
<script src="plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function() {
    // Summernote
    $('#summernote').summernote()


    
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai",
        

    });




    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo1"), {
        mode: "htmlmixed",
        theme: "monokai"
    });


    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo2"), {
        height: 500,
        mode: "htmlmixed",
        theme: "monokai"
    });



    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo3"), {
        mode: "htmlmixed",
        theme: "monokai"
    });

   // CodeMirror.setSize(500, 300);
    CodeMirror.setSize("100%", "100%");

})
</script>

