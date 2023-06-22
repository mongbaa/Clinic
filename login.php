<?php include "header.php";
$dark = 1;
?>



<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">ยินดีต้อนรับ</h1>
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




      <div class="col-sm-12">
        <?php if (isset($_SESSION['level_user'])) { ?>




 <!-- Default box -->
 <div class="card">
            <div class="card-header">
              <h3 class="card-title">

                ยินดีต้อนรับ เข้าสู่ระบบประเมินคะแนนนักศึกษาในคลินิก (E-Clinic)

              </h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">
            <?php if (isset($_SESSION['level_user']) && !empty($_SESSION['level_user'])) { ?>
              <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                <?php  if ($_SESSION['level_user'] == "Student") { // เป็น Student  ?>    
                  <div class="image">
                   

                    <!--  <img src="http://10.151.127.134/estudent/pic_students/<?php echo $_SESSION['loginname'];?>.jpg" class="img-circle elevation-2" alt="User Image">-->
                    <img src="../pic_students/<?php echo $_SESSION['loginname'];?>.jpg" class="img-circle elevation-2" alt="User Image">
                    
                  </div>
                <?php } ?>

                
                <div class="info">
                  <a href="#" class="d-block"><?php echo  $_SESSION['loginname']; ?> <br>
                  <?php echo  $_SESSION['fname']; ?> <?php echo  $_SESSION['lname'];?></a>
                </div>

              </div>
        <?php } ?>

     
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
             


             
                <a href="logout.php"  class="btn btn-default">
                  <i class="fa fa-unlock nav-icon"></i> ออกจากระบบ
                </a>
              



            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->









        <?php }else{ ?>

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">

                ยินดีต้อนรับ กรุณาเข้าสู่ระบบ โดยใช้  Username และ Password ของ ระบบ Hosxp

              </h3> 

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body">

              <form name="form1" method="post" action="check_login.php">


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


          <?php }?>
















        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->



<?php include "footer.php"; ?>