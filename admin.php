<?php include "header.php";
$dark = 1;
?>



<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-10">
        <h1 class="m-0">ยินดีต้อนรับ (สำหรับเจ้าหน้าที่สาขาวิชา และ เจ้าหน้าที่หน่วยงานทะเบียนและประเมินผลนักศึกษา) </h1>
      </div><!-- /.col -->
      <div class="col-sm-2">
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
      <div class="col-sm-12">
        <?php if (isset($_SESSION['login_em'])) {
        } else { ?>

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                ยินดีต้อนรับ กรุณาเข้าสู่ระบบ โดยใช้  Username และ Password 
              </h3>


              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">

              <form name="form1" method="post" action="check_login_admin.php">


                <div class="row">
                  <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Username </label>
                      <input name="username" type="text" class="form-control" placeholder="Username" required>
                    </div>
                  </div>


                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Password </label>
                      <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <input type="hidden" name="id_member" value="<?php echo $id_member; ?>">
                      <button type="submit" class="btn btn-info">เข้าสู่ระบบ</button>
                    </div>
                  </div>
                </div>




              </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              -





            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        <?php } ?>


        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


</div>
<?php include "footer.php"; ?>