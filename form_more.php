<?php include'header.php';?>

<link rel="stylesheet" href="plugins/ekko-lightbox/ekko-lightbox.css">


<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">



<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">

            <div class="col-sm-6">
                <h1>สร้างฟอร์ม ที่เกี่ยวข้อง ข้อมูลเพิ่มเติม </h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Project Detail</li>
                </ol>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</section>





<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">







                <form id="form1" name="form1" method="post" action="form_more_q.php">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">กรอกข้อมูลการสร้างเกี่ยวข้อง</h3>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>สาขา</label>
                                        <select name="type_work_id" class="form-control" required>
                                            <option value="">-- เลือกสาขา --</option>
                                            <?php
                                         include"config.inc.php";
                                         $sql_type_work = "select  *  from tbl_type_work  ";
                                         $query_type_work = $conn->query($sql_type_work); 
                                         while($result_type_work = $query_type_work->fetch_assoc()) {
                                         ?>

                                            <option value="<?php echo $result_type_work['type_work_id'];?> ">
                                                <?php echo $result_type_work['type_work_name'];?>
                                            </option>

                                            <?php }?>
                                        </select>


                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">ชื่อฟอร์ม</label>
                                        <input type="text" name="form_more_name" class="form-control"
                                            id="exampleInputEmail1" placeholder="ชื่อฟอร์ม / งาน" required>
                                    </div>
                                </div>



                            </div>

                            <div class="row">





                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">สถานะฟอร์ม</label>
                                        <select name="form_more_status" class="form-control" required>
                                            <option value="">-- เลือกสถานะฟอร์ม --</option>
                                            <option value="Y">ใช้งานอยู่ในปัจุบัน</option>
                                            <option value="N">ไม่ใช้งานแล้ว ยกเลิก ไม่มีการประเมินแล้ว</option>
                                        </select>

                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">ชื่อ Table</label>
                                        <input type="text" name="form_more_table" class="form-control"
                                            id="exampleInputEmail1" placeholder="ชื่อ Table" required>
                                    </div>
                                </div>





                            </div>



                            <div class="card-footer">

                                <input type="submit" name="Submit" class="btn btn-info" value="สร้างฟอร์ม" />

                                <input type="reset" name="Submit2" class="btn btn-primary" value="Cancel" />

                            </div>


                        </div>

                </form>

            </div>






            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">รายการฟอร์มประเมินคะแนน</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ลำดับที่</th>
                                <th>สาขา</th>
                                <th>ชื่อฟอร์ม/งาน(s)</th>
                                <th>สถานะฟอร์ม</th>
                                <th>Table</th>

                                <th>ข้อมูลประเมิน</th>

                                <th>จัดการข้อมูล</th>
                            </tr>
                        </thead>



                        <tbody>
                            <?php 
include "config.inc.php"; 
$sql_form_more = "SELECT * FROM tbl_form_more , tbl_type_work where tbl_form_more.type_work_id=tbl_type_work.type_work_id";
$query_form_more = $conn->query($sql_form_more); 
$i=0;
while($row_form_more = $query_form_more->fetch_assoc()) {
$i++;
?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row_form_more['type_work_name'];?> </td>
                                <td><?php echo $row_form_more['form_more_name'];?></td>
                                <td><?php echo $row_form_more['form_more_status'];?></td>
                                <td><?php echo $row_form_more['form_more_table'];?></td>

                                <td>
                                    <a href="form_more_detail.php?form_more_id=<?php echo $row_form_more['form_more_id'];?>"
                                        class="btn btn-info">เพิ่มรายการ</a>
                                </td>

                                <td>
                                    <a href="" class="btn btn-info">ลบ</a>
                                    <a href="" class="btn btn-info">แก้ไข</a>
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
    </div>
    </div>
</section>



<?php include 'footer.php';?>


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