<?php include "header.php"; ?>

<!-- Google Font: Source Sans Pro -->
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

<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

<?php
if (isset($_GET['type_work_id'])) {

    $type_work_id = $_GET['type_work_id'];
} else {

    $type_work_id = 1;
}


if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
} else {
    $student_id = "6110810001";
}
?>
 
<?php

                        if(isset($_GET['del']))
                        {
						include "config.inc.php"; // ไฟล์ตดิตอ่ฐานข้อมลู 
                        $ck_id=$_GET['del'];
                        $type_work_id=$_GET['type_work_id'];
                        $student_id=$_GET['student_id'];
                        
                        $sql_del="DELETE FROM tbl_ck_$type_work_id WHERE ck_" . $type_work_id . "_id = $ck_id";
						$conn->query($sql_del); 
						echo "<script type='text/javascript'>";
						//echo  "alert('บันทึกสำเร็จ');";
						echo "window.location='conduct_knowledge_back.php?type_work_id=$type_work_id&student_id=$student_id&do=success'";
						echo "</script>";
							 
                        }
                        ?>


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1>ประเมินคะแนน Conduct & Knowledge สาขาวิชา <?php echo nameType_work::get_type_work_name($type_work_id); ?> ย้อนหลัง </h1>
            </div>

            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
                    <li class="breadcrumb-item active">สร้างรายการ</li>
                </ol>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <form name="myForm" id="myForm" action="" method="GET">
            <input name="type_work_id" type="hidden" value="<?php echo $type_work_id; ?>" />

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <select name="student_id" id="student_id" class="form-control select2" onchange="this.form.submit()" required>

                            <option value=""> เลือก </option>
                            <?php include "config.inc.php";
                            $sql_student = "SELECT * FROM  tbl_student where student_status = 0 and student_level = 4";
                            $query_student = $conn->query($sql_student);
                            while ($result_student  = $query_student->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $result_student['student_id']; ?>" <?php if (!(strcmp($result_student['student_id'], $student_id))) {
                                                                                                    echo "selected=\"selected\"";
                                                                                                } ?>>
                                    <?php echo $result_student['student_id']; ?> <?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?></option>
                            <?php  }  ?>
                        </select>
                    </div>
                </div>

            </div>
        </form>


        <form name="myForm" id="myForm" action="" method="POST">


            <div class="row">

                <div class="col-sm-3">
                    <div class="form-group">

                        <select name="teacher_id" id="teacher_id" class="form-control select2" required>
                            <option value="" selected="selected">
                                เลือกอาจารย์ผู้ประเมิน</option>

                            <?PHP
                            include "config.inc.php";
                            $sql_t =  "SELECT * FROM tbl_teacher where type_work_id = $type_work_id";
                            $query_t = $conn->query($sql_t);
                            while ($result_t = $query_t->fetch_assoc()) {

                            ?>

                                <option value="<?php echo $result_t['teacher_id']; ?>">
                                    <?php echo $result_t['teacher_name']; ?>
                                    <?php echo $result_t['teacher_surname']; ?>
                                </option>

                            <?php   } ?>

                        </select>
                    </div>
                </div>






                <div class="col-sm-3">
                    <div class="form-group">
                        <select name="ck_time_type" id="ck_time_type" class="form-control select2" required>
                            <option value=""> เลือก ช่วงเวลา </option>
                            <option value="AM">เช้า</option>
                            <option value="PM">บ่าย</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <input type="date" name="ck_date" class="form-control" value="" placeholder="date" required>
                    </div>
                </div>
            </div>




            <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
            <input name="type_work_id" type="hidden" value="<?php echo $type_work_id; ?>" />

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> ข้อมูล Conduct & Knowledge สาขาวิชา > <B><?php echo nameType_work::get_type_work_name($type_work_id); ?></B> </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">



                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th Width="5%">
                                    <div align="center">ลำดับ</div>
                                </th>
                                <th Width="10%"> Type </th>
                                <th Width="30%"> รายการประเมิน</th>
                                <th Width="4%">
                                    <div align="center"> คะแนน </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?PHP

                            $conduct_knowledge_array = array();

                            include "config.inc.php";
                            $sql   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
                            $sql  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
                            $sql  .=  " ORDER BY c.form_conduct_knowledge_order ASC ";



                            $query = $conn->query($sql);
                            $i = 0;
                            while ($row_conduct_knowledge = $query->fetch_assoc()) {
                            $i++;

                            $conduct_knowledge_array[] = array(
                                'name_array' => $row_conduct_knowledge['form_conduct_knowledge_name'],
                                'field_array' => $row_conduct_knowledge['form_conduct_knowledge_field']
                            );


                            ?>
                                        
                                <tr>
                                    <td>
                                        <div align="center"><?php echo $i; ?> (<?php echo $row_conduct_knowledge['form_conduct_knowledge_order']; ?>)</div>
                                    </td>

                                    <td>
                                        <div align="center">
                                            <?php
                                            $form_conduct_knowledge_type = $row_conduct_knowledge['form_conduct_knowledge_type'];
                                            switch ($form_conduct_knowledge_type) { // Harder page
                                                case 0:
                                                    echo  " -- ";
                                                    break;
                                                case 1:
                                                    echo  "Conduct";
                                                    break;
                                                case 2:
                                                    echo  "Knowledge";
                                                    break;
                                                default:
                                                    echo  "-";
                                                    break;
                                            }
                                            ?>
                                        </div>
                                    </td>

                                    <td><?php echo $row_conduct_knowledge['form_conduct_knowledge_name']; ?> (<?php echo $row_conduct_knowledge['form_conduct_knowledge_field']; ?>) </td>
                                    <td>
                                        <select name="<?php echo $row_conduct_knowledge['form_conduct_knowledge_field']; ?>" id="<?php echo $row_conduct_knowledge['form_conduct_knowledge_field']; ?>" class="form-control">
                                            <option value=""> N/A </option>
                                            <?php
                                            $row_conduct_knowledge['form_conduct_knowledge_score'];
                                            $ck_score1 = explode(",", $row_conduct_knowledge['form_conduct_knowledge_score']); // แยกครั้งที่ 1
                                            $count_ck_score1 = count($ck_score1);

                                            for ($ct = 0; $ct <= $count_ck_score1; $ct++) {
                                                $step_ck_score1 = @$ck_score1[$ct];
                                                if ($step_ck_score1 != "") {
                                                    $ck_score2 = explode("=", $step_ck_score1); // แยกครั้งที่ 2
                                            ?>
                                                    <option value="<?php echo @$ck_score2[1]; ?>"><?php echo @$ck_score2[0]; ?> = <?php echo @$ck_score2[1]; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>





                            <?php } ?>


                        </tbody>

                    </table>


                    <button name="submit" type="submit" value="submit" class="btn btn-info"> บันทึกคะแนน </button>



                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->



        </form>









        <?php
        if (isset($_POST['submit'])) {
            include "config.inc.php";

            foreach ($_POST as $key => $value) {
                $_POST[$key] = $conn->real_escape_string($value);
            }

            $ck_date = $_POST['ck_date'];
            $ck_time = date('H:i:s');
            $ck_time_type = $_POST['ck_time_type'];

            $teacher_id = $_POST['teacher_id'];
            $student_id = $_POST['student_id'];
            $type_work_id = $_POST['type_work_id'];

            $detail_id = 0;

            $sql_in_ck = "INSERT INTO tbl_ck_$type_work_id( ck_" . $type_work_id . "_id , teacher_id, student_id, detail_id, ck_date, ck_time, ck_time_type, ";



            $sql_ck   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
            $sql_ck  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
            $sql_ck  .=  " ORDER BY c.form_conduct_knowledge_id ASC ";
            $query_ck = $conn->query($sql_ck);
            $sql_in_ck1 = "";
            while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {

                $field = $row_conduct_knowledge['form_conduct_knowledge_field'];
                // $field_  = $_POST["{$field}"];

                $sql_in_ck1 .=  $field . ", ";
            }

            $sql_in_ck2  = substr($sql_in_ck1, 0, -2); //ตัด , ตัวสุดท้ายออก

            $sql_in_ck .= $sql_in_ck2 . ") VALUES (NULL, '{$teacher_id}' , '{$student_id}' ,'{$detail_id}' ,'{$ck_date}' ,'{$ck_time}' ,'{$ck_time_type}' ,";



            $query_ck = $conn->query($sql_ck);
            $sql_in_ck3 = "";
            while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {

                $field = $row_conduct_knowledge['form_conduct_knowledge_field'];
                $field_  = $_POST["{$field}"];


                $sql_in_ck3 .=  " '{$field_}' , ";
            }

            $sql_in_ck4  = substr($sql_in_ck3, 0, -2); //ตัด , ตัวสุดท้ายออก

            $sql_in_ck .= $sql_in_ck4 . " )";

            echo  $sql_in_ck .= " ";




            $conn->query($sql_in_ck);



            echo "<script type='text/javascript'>";
            //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
            echo "window.location='conduct_knowledge_back.php?type_work_id=$type_work_id&student_id=$student_id&do=success'";
            echo "</script>";



        }




        ?>
<?php  include "sweetalert.php"; //  ?>










        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"> รายการประเมินคะแนน </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">



                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>
                                <div align="center">วันที่</div>
                            </th>
                            <th>
                                <div align="center">ช่วงเวลา</div>
                            </th>
                            <?PHP
                                foreach ($conduct_knowledge_array as $values => $data) {
                                $name_array=  $data['name_array'];
                                $field_array=  $data['field_array'];
                            ?>
                            <th><a href="#" data-toggle="tooltip" title="<?php echo $name_array;?>"><?php echo $name_array;?></a></th>
                            <?php } ?>

                            <th> อาจารย์ผู้ประเมิน </th>
                            <th> ลบ </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            include "config.inc.php";
                            $sql_ck = "SELECT * FROM  tbl_ck_$type_work_id  where student_id = $student_id  ORDER BY ck_date ASC";
                            $query_ck = $conn->query($sql_ck);
                            while ($result_ck  = $query_ck->fetch_assoc()) {
                                
                        ?>
                        <tr>
                            <td><?php echo $result_ck['ck_date'];?></td>
                            <td><?php echo $result_ck['ck_time_type'];?></td>
                            <?PHP
                                foreach ($conduct_knowledge_array as $values => $data) {
                                $name_array = $data['name_array'];
                                $field_array = $data['field_array'];
                            ?>
                            <td><?php echo $result_ck["{$field_array}"];?></td>
                            <?php } ?>

                            <td><?php echo nameTeacher::get_teacher_name($result_ck['teacher_id']);?></td>
                            <td>
                            <a href="?del=<?php echo $result_ck["ck_".$type_work_id."_id"];?>&type_work_id=<?php echo $type_work_id;?>&student_id=<?php echo $student_id;?>" class="btn btn-danger"
                                    onclick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"> ลบ </a>
                        
                           </td>
                        </tr>

                        <?php } ?>



                    </tbody>

                </table>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->



    </div>







</section>







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

<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>





<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>

<!-- Page specific script Summernote -->
<script>
    $('#summernote').summernote({
        placeholder: 'รายละเอียด',
        tabsize: 2,
        height: 200
    });
</script>




<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
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



<!-- page script Tooltip -->
<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<!-- page script Tooltip -->