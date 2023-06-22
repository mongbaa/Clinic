<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="dist/css/adminlte.min.css">

<script src="plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>



<?php


if (isset($_GET['do'])) {


    if ($_GET['do'] == "success") {

        echo "<script>";
        echo "Swal.fire({
            position: 'center',
            icon: 'success',
            title: '<strong> Success </strong>  ',
            text: 'ทำรายการสำเร็จ',
            showConfirmButton: false,
            timer: 2000
          }) ";
        echo "</script>";
        //echo '<meta http-equiv="refresh" content="1;url=member.php" />';

    }



    if ($_GET['do'] == "submit") {

        echo "<script>";
        echo "Swal.fire({
        position: 'center',
        icon: 'success',
        title: '<strong> Success </strong>  ',
        text: 'Something went wrong!',
        showConfirmButton: false,
        timer: 2000
      }) ";
        echo "</script>";
        //echo '<meta http-equiv="refresh" content="1;url=member.php" />';

    }




    if ($_GET['do'] == "del") {

        echo "<script>";
        echo "Swal.fire({
        position: 'center',
        icon: 'error',
        title: '<strong> Success </strong>  ',
        text: 'Something went wrong!',
        showConfirmButton: false,
        timer: 2000
      }) ";
        echo "</script>";
        //echo '<meta http-equiv="refresh" content="1;url=member.php" />';

    }
}


?>