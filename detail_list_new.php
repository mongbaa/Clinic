<?php include "header.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!empty($_GET['order_id'])) {
  $order_id = $_GET['order_id'];
} else {
  $order_id = "";
}
?>



<?php
if (isset($_SESSION['sessid']) && !empty($_SESSION['level_user'])) {

 
} else {
  echo "<script type='text/javascript'>";
  echo  "alert('เช้าสู่ระบบก่อนใช้งาน....!');";
  echo "window.location='login.php'";
  echo "</script>";
}
?>


<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons 
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
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
<!-- Google Font: Source Sans Pro 
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->




<style>
    .table-responsive {
        height: 700px;
        overflow: scroll;
    }

    thead tr:nth-child(1) th {
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #dddddd;
        color: black;
    }

    th:first-child,


    td:first-child {
        position: sticky;
        left: 0px;
    }

    td:first-child {
        background-color: whitesmoke;
        color: black;
    }


    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        border-style: dotted;

    }
</style>



<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1> ส่งงานประเมินในคลินิก </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href=javascript:history.back(1)>ย้อนกลับ</a></li>
          <li class="breadcrumb-item active">รายการ งานทั้งหมด </li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>




<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->


    <div class="col-12">

      <div class="row">

        <div class="col-sm-2">

          <div class="card card-primary color-palette-box">
            <div class="card-header">
              <h3 class="card-title"> <i class="fas fa-list-alt"></i> ชื่อผู้ป่วย </h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">

                 <div class="table-responsive">

                 
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $student_id = $_SESSION['loginname'];
                        include "config.inc.php";
                        $sql_order  = " SELECT *  FROM tbl_order WHERE  student_id = $student_id ";
                        $sql_order .= " and causes_of_pay_id = '0' ";
                        $query_order = $conn->query($sql_order);
                        while ($result_order = $query_order->fetch_assoc()) {

                          

                        ?>
                          <tr>
                            <td> 
                            
                            <!--<a href="javascript:void();" data-id="'.$tools_set_detail_id.'"    class="btn btn-info editbtn" -->
                            <a href="?order_id=<?php echo $result_order['order_id'];?>">
                            HN : <?php echo $result_order['HN']; ?> <br> <?php echo $result_order['fname']; ?> <?php echo $result_order['lname']; ?>
                          
                            </a>
                          
                          </td>

                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                </div>

            </div>
          </div>

        </div>




















        <div class="col-sm-10">



          <div class="card card-primary color-palette-box">
            <div class="card-header">
              <h3 class="card-title"> <i class="fas fa-list-alt"></i> ข้อมูลงานให้ผู้ป่วย Detail </h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">

            <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
            <?php echo $order_id; ?>
            <table id="example" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>
                      <div align="center">ลำดับที่</div>
                    </th>
                    <th>รหัสงาน</th>
                    <th>HN</th>
                    <th>ฟอร์มสาขา</th>
                    <th>ลงปฏิบัติงาน</th>
                    <th>งาน</th>
                    <th>รายละเอีดงาน</th>
                    <th>วันที่</th>
                    <th>Complete</th>
                    <th>ส่งงาน</th>
                  </tr>
                  
                </thead>
            </table>




            </div>



          </div>



        </div>

      </div>

    </div>



  </div>
</section>


<?php include "footer.php"; ?>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script type="text/javascript">




  $(document).ready(function() {


    $(document).on('submit', '#add_company_', function(e) {
    e.preventDefault();

    var order_id = $(this).data('order_id');
    var order_id = $('#order_id').val();
    var order_id = $('#order_id').val();

    
  });


    $('#example').DataTable({
      "fnCreatedRow": function( nRow, aData, iDataIndex ) {
          $(nRow).attr('id', aData[0]);
      },
      "autoWidth": true,
      'responsive': true,
      'serverSide': 'true',
      'processing': 'true',
      'paging': 'true',
      "order": [
        [0, "desc"]
      ],
      'ajax': {
        'url': 'backend/detail_list_fetch_data.php',
        "data": function(d) {
                    return $.extend({}, d, {
                        "order_id": $("#order_id").val().toLowerCase(),
                    });
                },
        'type': 'post',
      },
    });
  });



</script>
