<?php include "header.php";?>	

<!-- Google Font: Source Sans Pro 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,$00&display=fallback">-->
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


<?php
if (isset($_GET['edit'])) {
    
    include "config.inc.php";
    $sql_edit = "SELECT * FROM  tbl_student  where student_id='$_GET[edit]' ";
    $query_edit = $conn->query($sql_edit);
    $result_edit = $query_edit->fetch_assoc();
    $student_id = $result_edit['student_id'];
    $student_name = $result_edit['student_name'];
    $student_lastname = $result_edit['student_lastname'];
    $student_level = $result_edit['student_level'];
    $student_group = $result_edit['student_group'];
    $student_active = $result_edit['student_active'];
    $lstudent_licences = $result_edit['lstudent_licences'];
    $student_doctorcode = $result_edit['student_doctorcode'];
    $student_status = $result_edit['student_status'];
    $student_log = $result_edit['student_log'];
  

} else {

   // $student_id = "";

    $student_id = "";
    $student_name = "";
    $student_lastname = "";
    $student_level = "";
    $student_group = "";
    $student_active = "";
    $lstudent_licences = "";
    $student_doctorcode = "";
    $student_status = "";
    $student_log = "";

}

?>





<?php 
//ตัวแปรเงื่อนไขการค้นหา
if(isset($_GET['level_search'])){
$level_search=$_GET['level_search'];
}else{
$level_search=1;
}

if(isset($_GET['student_search'])){
$student_search=$_GET['student_search'];
}else{
$student_search="";
}
?>






                          <section class="content-header">
                                <div class="container-fluid">
                              
                                  <div class="row mb-2">
                                    
                                    <div class="col-sm-8">
										<h1>ข้อมูลนักศึกษา</h1>
                                    </div>
                                
                                    <div class="col-sm-4">
                                      <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                                        <li class="breadcrumb-item student_active">ข้อมูลนักศึกษา</li>
                                      </ol>
                                    </div>
                                
                                  </div>
                                </div><!-- /.container-fluid -->
                          </section>



      <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


		<div class="card card-default color-palette-box">
					<div class="card-header">
						<h3 class="card-title">	<i class="fas fa-search"></i> ค้นหาข้อมูล </h3>
				 	 </div>

                    <div class="card-body">																
                        <form  method="get" action="<?php echo $_SERVER['PHP_SELF']?>" >
                                    
                            <div class="row">

                                <div class="col-sm-4">
                                    <?php for($i=4; $i<=6; $i++){?>
                                    <a href="?level_search=<?php echo $i;?>" <?php if($level_search==$i){ ?> class="btn btn-primary" <?php }else{?> class="btn btn-default"  <?php }?>> ชั้นปีที่ <?php echo $i;?> </a>  
                                    <?php }?>
                                    <a href="?level_search=all" <?php if($level_search=="all"){ ?> class="btn btn-primary" <?php }else{?> class="btn btn-default"  <?php }?>> ทุกชั้นปี </a>  
                                </div>
                                
                                <div class="col-sm-4">
                                <input class="form-control" type="search" name="student_search" placeholder="รหัส , ชื่อ , สกุล" value="<?php echo $student_search;?>" aria-label="Search">
                                </div>

                                    
                                <div class="col-sm-4">
                                <button class="btn btn-info" type="submit">Search</button>
                                <a href="student_input.php" class="btn btn-danger" onclick="return confirm('กรุณายืนยันอีกครั้ง !!!')"> นำเข้ารายชื่อนักศึกษาปี </a>
                                </div>

                               

                            </div>

                        </form>	
                    </div><!-- /.card-body -->
		</div><!-- /.card -->











<?php if (isset($_GET['edit'])) {?>

        <div class="card card-default color-palette-box">
					<div class="card-header">
						<h3 class="card-title">	<i class="fas fa-plus"></i> จัดการข้อมูลนักศึกษา </h3>
				 	 </div>

                    <div class="card-body">				

                        <form name="frmSearch" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
                            
                            
                            <div class="row">
                            
                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
          
                            <div class="col-md-2">
                                <input name="student_name" type="text" id="student_name"  class="form-control"  placeholder="ชื่อ"  value="<?php echo $student_name;?>" required>
                            </div>
   
                            <div class="col-md-2">
                                <input name="student_lastname" type="text" id="student_lastname"  class="form-control"  placeholder="นามสกุล"  value="<?php echo $student_lastname;?>" required>
                            </div>
                                

                            <div class="col-md-2">
                                <select name="student_level"  class="form-control" required>
                                <option value="">--เลือกชั้นปี--</option>
                                    
                                <?php for ($x = 4; $x <= 7; $x++) { ?>
                                    
                                <option value="<?=$x;?>" <?php if($x==$student_level){ echo "selected";}?>><?=$x;?></option>
                                
                                <?php	} ?>									
                                </select>
                            </div>
                                
                            </div>	
                                
                                
                                
                            <br>
                                                                    
                            <div class="row">

                            <div class="col-md-2">
                                <input name="student_group" type="text" id="student_group"  class="form-control"  placeholder="student_group"  value="<?php echo $student_group;?>">
                            </div>
                                
                            <div class="col-md-2">
                                <input name="student_active" type="text" id="student_active"  class="form-control"  placeholder="student_active"  value="<?php echo $student_active;?>">
                            </div>	
                                
                            <div class="col-md-2">
                                <input name="lstudent_licences" type="text" id="lstudent_licences"  class="form-control"  placeholder="lstudent_licences"  value="<?php echo $lstudent_licences;?>">
                            </div>	
                                
                                
                            <div class="col-md-2">
                                <input type="submit" name="Submitss" class="btn btn-default" value="Submit" />
                                <input type="reset" name="Submit2" class="btn btn-default" value="Reset" />
                                <input type="hidden" name="student_add" id="student_id" value="1">
                                <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                            </div>

                            </div> 
                        </form>
                    </div><!-- /.card-body -->
		</div><!-- /.card -->
        
<?php } ?>




     <?php

            if (isset($_POST['student_add'])) {
                
                include "config.inc.php";

                if (isset($_POST['student_id'])  && !empty($_POST['student_id'])) {
                    $student_id = $conn->real_escape_string($_POST['student_id']);
                } else {
                    $student_id = "";
                }


                
                if (isset($_POST['student_level'])  && !empty($_POST['student_level'])) {
                    $student_level = $conn->real_escape_string($_POST['student_level']);
                } else {
                    $student_level = "";
                }



                if (isset($_POST['student_group'])  && !empty($_POST['student_group'])) {
                    $student_group = $conn->real_escape_string($_POST['student_group']);
                } else {
                    $student_group = "";
                }


                if (isset($_POST['student_active'])  && !empty($_POST['student_active'])) {
                    $student_active = $conn->real_escape_string($_POST['student_active']);
                } else {
                    $student_active = "";
                }

                if (isset($_POST['lstudent_licences'])  && !empty($_POST['lstudent_licences'])) {
                    $lstudent_licences = $conn->real_escape_string($_POST['lstudent_licences']);
                } else {
                    $lstudent_licences = "";
                }

                if (isset($_POST['student_status'])  && !empty($_POST['student_status'])) {
                    $student_status = $conn->real_escape_string($_POST['student_status']);
                } else {
                    $student_status = "";
                }


              


                if (!empty($student_id)) {

                    $sql_up = "UPDATE tbl_student  SET student_level = '$student_level', student_group = '$student_group', student_active = '$student_active', lstudent_licences = '$lstudent_licences', student_status = '$student_status'  WHERE  student_id = '$student_id'";
                    $conn->query($sql_up);
         
                }



                echo "<script type='text/javascript'>";
                echo "alert('[ OK Success]');";
                echo "window.location='student_list.php';";
                echo "</script>";
            }

            ?>

			
			




            <script language="JavaScript">
                    function ClickCheckAll(vol) {

                        var i = 1;
                        for (i = 1; i <= document.frmMain.hdnCount.value; i++) {
                            if (vol.checked == true) {
                                eval("document.frmMain.chkclass" + i + ".checked=true");
                            } else {
                                eval("document.frmMain.chkclass" + i + ".checked=false");
                            }
                        }
                    }

                    function onDelete() {
                        if (confirm('ยืนยันการ เปลี่ยน ชั้นปี อีกครั้ง?') == true) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                </script>



<form name="frmMain" action="up_class_q.php" method="post" OnSubmit="return onDelete();">

                <div class="card border-primary mb-3">
                    <div class="card-body text-primary">
                    <div class="row">


                        <div class="col-sm-2">
                            <div class="form-group">
                             <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" class="form-control" onClick="ClickCheckAll(this);">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <select name="student_level" class="form-control" required>
                                    <option value="" <?php if ($student_level == "") echo "selected"; ?>> -- เลือก ชั้นปี
                                        --
                                    </option>
                                  
                                    <option value="4"> ชั้นปี 4 </option>
                                    <option value="5"> ชั้นปี 5 </option>
                                    <option value="6"> ชั้นปี 6 </option>
                                    <option value="7" <?php if ($student_level == "") echo "selected"; ?>> จบ  </option>
                                  
                                </select>
                            </div>
                        </div>



                        <div class="col-sm-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mb-2">Update Class</button>
                            </div>
                        </div>


                    </div>

                    </div>
                </div>





			
			<div class="card card-default color-palette-box">
				  
			
			<div class="card-header">
				<h3 class="card-title">	<i class="fas fa-list-alt"></i> รายการข้อมูลนักศึกษา </h3>
			</div>
              <!-- /.card-header -->
           <div class="card-body">
			 <table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
                <th width="4%">รหัส</th>
								<th width="33%">ชื่อ - สกุล</th>
								<th width="5%">ชั้นปี</th>
								<th width="4%">group</th>
								<th width="4%">active</th>
								<th width="5%">licences</th>
								<th width="5%">edit</th>
								<th width="5%">	
                 <div align="center">
                
                   </div>
                 </th>
							</tr>
						</thead>
                 
						<tbody>
						                        
                        <?php 
                            include "config.inc.php";
                                $i=0;
                               
                                $sql_student   =  " SELECT *FROM  tbl_student ";
                                if($level_search=="all"){
                                    $sql_student  .=  " ORDER BY student_id ASC   "; 
                                }else if($student_search!=""){
                                    $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' ";
                                    $sql_student  .=  " ORDER BY student_id ASC  ";
                                }else{
                                    $sql_student   .=  " where student_level=$level_search ";
                                    $sql_student  .=  " ORDER BY student_id ASC  "; 
                                }  
                                $query_student = $conn->query($sql_student);
                                while($result_student = $query_student->fetch_assoc()) {
                                $i++;
                        ?>

							<tr class="odd gradeX">
                <td><?php echo $result_student['student_id'];?></td>
						
							  <td> <?php echo $result_student['student_name'];?> <?php echo $result_student['student_lastname'];?></td>
							  <td> <?php echo $result_student['student_level'];?></td>
							  <td> <?php echo $result_student['student_group'];?></td>
							  <td> <?php echo $result_student['student_active'];?></td>
							  <td> <?php echo $result_student['lstudent_licences'];?></td>
							  <td> 
                <a href="?edit=<?php echo $result_student['student_id'];?>&level_search=<?php echo $result_student['student_level'];?>" class="btn btn-default"> แก้ไข</a>
                 </td>
							  <td>
			
                  <input type="checkbox" name="chkclass[]" id="chkclass<?php echo $i; ?>" value="<?php echo $result_student['student_id'];?>" class="form-control sm">

							  </td>		 
							</tr>
							
						<?php }?>
							
						</tbody>
					</table>


                      
	                    <?php echo $i;?>
			   
			     </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <input type="hidden" name="hdnCount" value="<?php echo $i; ?>">

</form>





























      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php  include "footer.php";?>	

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


<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            "paging": true,
            "pageLength": 50,
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





<script>
    $(document).ready(function() {
        $("#myModal").modal('show');
    });
</script>




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
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
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
                    'Last $ Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ]
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