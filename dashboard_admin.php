<?php include "header.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


<style>
    section {
        font-family: 'Kanit', sans-serif !important;
        background-image: url("images/12234.jpg");
        /* 5816231.jpg  17545  4882066.jpg*/
        background-color: #cccccc;
        /* Used if the image is unavailable  height: 900px;*/
       
        /* You must set a specified height */
        background-position: inherit;
        /* Center the image */
        /*background-repeat: no-repeat;  Do not repeat the image */
        background-size: container;
        /* Resize the background image to cover the entire container */


    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: rgb(255 255 255 / 50%);
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 2rem;
        box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
    }

    .info-box {
        position: relative;
        background-color: rgb(255 255 255 / 50%);
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 2rem;
        box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
    }



    .gradiant-bg {
        font-size: 18px;
        font-weight: bold;
        background: linear-gradient(45deg, #012a4a, #013a63, #01497c, #014f86, #00b4d8);
        background-size: 40%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradient 5s infinite;
    }

    .gradiant2-bg {
        font-size: 18px;
        font-weight: bold;
        background: linear-gradient(45deg, #03045e, #023e8a, #0077b6, #0096c7, #00b4d8);
        background-size: 90%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradient 5s infinite;
    }


    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        100% {
            background-position: 100% 50%;
        }
    }
</style>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <i class="fas fa-address-card"></i> Dashboard Admin E-Clinic</h1>
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
        <br>




        <div class="row">

            <?PHP
            $work_array = array();

            include "config.inc.php";
            $sql_work = "SELECT * FROM tbl_type_work ";
            $query_work = $conn->query($sql_work);
            while ($result_work = $query_work->fetch_assoc()) {

                $type_work_id   = $result_work['type_work_id'];
                $type_work_name = $result_work['type_work_name'];

                $sql_detail_count   =  " SELECT  count(*) as detail_count ";
                $sql_detail_count  .=  " FROM tbl_detail  as d ";
                $sql_detail_count  .=  " WHERE detail_type_work_id = $type_work_id";
                $query_detail_count = $conn->query($sql_detail_count);
                $result_detail_count = $query_detail_count->fetch_assoc();
                if (!empty($result_detail_count["detail_count"])) {
                    $detail_count = $result_detail_count["detail_count"];
                } else {
                    $detail_count = 0;
                }


                $work_array[] = array(
                    'type_work_id' => $result_work['type_work_id'],
                    'type_work_name' => $result_work['type_work_name'],
                    'detail_count' => $detail_count
                );


                $sql_main_id   =  " SELECT  count(f.form_main_id) as count_main_id ";
                $sql_main_id  .=  " FROM tbl_form_main  as f ";
               // $sql_main_id  .=  " WHERE type_work_id = $type_work_id and form_main_confirm = 1";
                $sql_main_id  .=  " WHERE type_work_id = $type_work_id ";
                $query_main_id = $conn->query($sql_main_id);
                $result_main_id = $query_main_id->fetch_assoc();
                if (!empty($result_main_id["count_main_id"])) {
                    $count_main_id = $result_main_id["count_main_id"];
                } else {
                    $count_main_id = 0;
                }

                $sql_teacher   =  " SELECT  count(t.teacher_id) as count_teacher ";
                $sql_teacher  .=  " FROM tbl_teacher  as t ";
                $sql_teacher  .=  " WHERE t.type_work_id = $type_work_id and t.teacher_status = 1";
                $query_teacher = $conn->query($sql_teacher);
                $result_teacher = $query_teacher->fetch_assoc();
                if (!empty($result_teacher["count_teacher"])) {
                    $count_teacher = $result_teacher["count_teacher"];
                } else {
                    $count_teacher = 0;
                }

            ?>

                <div class="col-12 col-sm-3 col-md-2">
                    <div class="info-box">
                        <span class="info-box-icon">
                            <img src="images/dent2.png" class="img-circle" width="50" height="50">
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                <div class="gradiant2-bg"> <?php echo $type_work_name; ?> </div>
                            </span>
                            <span class="info-box-text"> งาน <B><?php echo $count_main_id; ?></B></span>
                            <span class="info-box-text"> อาจารย์ <B><?php echo $count_teacher; ?></B></span>
                        </div>
                    </div>
                </div>
                
            <?php } ?>


        </div>



        <div class="row">


            <div class="col-12 col-sm-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?PHP
                            include "config.inc.php";
                            $sql_order_hn = "SELECT  COUNT(DISTINCT HN) as count_order FROM tbl_order where order_type = 0 ";
                            $query_order_hn = $conn->query($sql_order_hn);
                            $result_order_hn = $query_order_hn->fetch_assoc();
                            if (!empty($result_order_hn["count_order"])) {
                                $count_order_hn = $result_order_hn["count_order"];
                            } else {
                                $count_order_hn = 0;
                            }




                            $sql_order = "SELECT  count(order_id) as count_order FROM tbl_order where order_type = 0 ";
                            $query_order = $conn->query($sql_order);
                            $result_order = $query_order->fetch_assoc();
                            if (!empty($result_order["count_order"])) {
                                $count_order = $result_order["count_order"];
                            } else {
                                $count_order = 0;
                            }



                            $sql_order_pay = "SELECT  count(order_id) as count_order FROM tbl_order where order_type = 0 and order_pay_by != 0 ";
                            $query_order_pay = $conn->query($sql_order_pay);
                            $result_order_pay = $query_order_pay->fetch_assoc();
                            if (!empty($result_order_pay["count_order"])) {
                                $count_order_pay = $result_order_pay["count_order"];
                            } else {
                                $count_order_pay = 0;
                            }
                            $sum_pay = 0;
                            $sum_pay =  $count_order - $count_order_pay;

                            $conn->close();

                            $percen_pay = 0;
                            $percen_pay = ($count_order_pay / $count_order) * 100;
                            $percen_pay = round($percen_pay);

                            $percen_sumpay = 0;
                            $percen_sumpay = ($sum_pay / $count_order) * 100;
                            $percen_sumpay = round($percen_sumpay);

                            ?>

                            <h5 class="card-title">จำนวนการรับผู้ป่วย</h5>
                            <p class="card-text"> </p>
                            <p class="card-text"> จำนวนผู้ป่วย : <?php echo $count_order_hn; ?> HN</p>

                            <div class="progress-group">
                                จำนวนการรับเข้าผู้ป่วยทั้งหมด
                                <span class="float-right"><b><?php echo number_format($count_order); ?></b> / HN</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>
                            <p class="card-text"> </p>

                            <div class="progress-group">
                                จ่ายออกผู้ป่วย
                                <span class="float-right"><b><?php echo number_format($count_order_pay); ?></b> / HN </span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" style="width: <?php echo $percen_pay; ?>%"></div>
                                </div>
                            </div>
                            <p class="card-text"> </p>

                            <div class="progress-group">
                                ยังไม่จ่ายออกผู้ป่วย
                                <span class="float-right"><b><?php echo number_format($sum_pay); ?></b> / HN</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: <?php echo $percen_sumpay; ?>%"></div>
                                </div>
                            </div>



                        </div>

                    </div>

                </div>


                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            
                          

                            <h5 class="card-title">จำนวนนักศึกษา</h5>
                            <p class="card-text"> </p>
                           


                            <?php  
                                include "config.inc.php";
                                $sql_student = "SELECT Count(*) as count_student FROM tbl_student  where student_active = 1 and student_level != 7";
                                $query_student= $conn->query($sql_student);
                                $result_student = $query_student->fetch_assoc();

                                    if (!empty($result_student["count_student"])) {
                                        $count_student = $result_student["count_student"];
                                    } else {
                                        $count_student = 0;
                                    }

                            ?>



                            <div class="progress-group">
                                จำนวนนักศึกษา
                                <span class="float-right"><b><?php echo number_format($count_student); ?></b> / User </span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>
                            <p class="card-text"> </p>




                            <?php
                            
                            $sql_student_level = "SELECT Count(*) as count_student_level, student_level  FROM tbl_student  where student_active = 1  and student_level != 7 group by student_level ";
                            $query_student_level = $conn->query($sql_student_level);
                            while ($result_student_level = $query_student_level -> fetch_assoc()) {

                                if (!empty($result_student_level["count_student_level"])) {
                                    $count_student_level = $result_student_level["count_student_level"];
                                } else {
                                    $count_student_level = 0;
                                }


                                $percen_count_student_level = 0;
                                $percen_count_student_level = ($count_student_level / $count_student) * 100;
                                $percen_count_student_level = round($percen_count_student_level);
    
                             

                            ?>

                            <div class="progress-group">
                                ปี <?php echo $result_student_level["student_level"];?> <?php echo $percen_count_student_level;?>%
                                <span class="float-right"><b><?php echo number_format($count_student_level); ?></b> / User </span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width: <?php echo $percen_count_student_level;?>%"></div>
                                </div>
                            </div>
                            <p class="card-text"> </p>


                            <?php } $conn->close(); ?>

                       
                            <p class="card-text"> </p>

                           
                        </div>
                    </div>
                </div>


            </div>




            <div class="col-12 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> จำนวน Case แยกตามสาขา </h5>
                        <canvas id="myChart" style="width:100%;"></canvas>
                    </div>
                    <script>
                        var xValues = [<?php foreach ($work_array as $values => $data) { ?> "<?php echo $data['type_work_name']; ?>", <?php } ?>];
                        var yValues = [<?php foreach ($work_array as $values => $data) { ?> <?php echo $data['detail_count']; ?>, <?php } ?>];
                        var barColors = [
                            "#b91d47",
                            "#00aba9",
                            "#2b5797",
                            "#e8c3b9",
                            "#1e7170",
                            "#c43fb5",
                            "#4844c2",
                            "#4e9cbf",
                            "#d6a13e",
                            "#d6643e",
                            "#d6643e",
                            "#d15a5a"
                        ];

                        new Chart("myChart", {
                            type: "doughnut",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: "จำนวน Case แยกตามสาขา"
                                }
                            }
                        });
                    </script>
                </div>
            </div>



        </div>



    </div>
</section>



<?php include "footer.php"; ?>