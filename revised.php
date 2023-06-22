<?php include "header.php"; ?>






<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1> คำนวนคะแนนใหม่ </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Data report_date</li>
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




                <div class="card card-default color-palette-box">
                    <div class="card-header">
                        <h3 class="card-title"> <i class="fas fa-chalkboard-teacher"></i> คำนวนคะแนนใหม่ </h3>
                    </div>

                    <div class="card-body">
                        <h3><a href="revised_nohn.php" target="_blank">- คะแนนไม่มีผู้ป่วย</a></h3>


                        <h3><a href="revised_oper_diagnosis.php" target="_blank">- oper_diagnosis</a></h3>


                        <?PHP
                        foreach ($plan_work_header as $values => $data) {
                            $type_work_id_arr =  $data['type_work_id'];
                            $type_work_name_arr =  $data['type_work_name'];
                        ?>
                        <h3><a href="update_grade.php?type_work_id=<?php echo $type_work_id_arr; ?>" target="_blank">- update_grade <?php echo $type_work_name_arr; ?></a></h3>
                        <?php } ?>


                        
                        

                    </div>
                </div>





            </div>

        </div>
    </div>
</section>