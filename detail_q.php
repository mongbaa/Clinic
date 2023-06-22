<?php include "header.php";
include "config.inc.php";	

if(isset($_POST['order_id'])){ 
     
    $order_id = $_POST['order_id'];
    
    $sql_order = " SELECT *  FROM tbl_order WHERE order_id =  $order_id  ";
    $query_order = $conn->query($sql_order);
    $result_order = $query_order->fetch_assoc();
    $HN = $result_order['HN'];

}else{ 

   
    $order_id = 0;
    $HN = 0;
    
}


if(isset($_POST['plan_id'])){   $plan_id = $conn -> real_escape_string($_POST['plan_id']);  }else{  $plan_id = 0; }
if(isset($_POST['arrange_date'])){   $arrange_date = $conn -> real_escape_string($_POST['arrange_date']);  }else{  $arrange_date = date('Y-m-d'); }
if(isset($_POST['arrange_id'])){   $arrange_id = $conn -> real_escape_string($_POST['arrange_id']);  }else{  $arrange_id = 0; }


 if(isset($_POST['detail_tooth'])){
    
        $detail_tooth = json_encode($_POST['detail_tooth']);  // implode(', ', $_POST['detail_tooth']);

    }else{ 

        $detail_tooth = json_encode([]);

    }



        for( $i= 1 ; $i <= 6 ; $i++ ){ 
        
            if(isset($_POST["surface_id$i"]) && !empty($_POST["surface_id$i"])){ 

                @$surface_ids.=$_POST["surface_id$i"].", ";

             }else{

                @$surface_ids.="";


            }
        }
    



       if(isset($surface_ids)){ $surface_ids = $surface_ids;}else{ $surface_ids = "";}


       // echo $surface_ids;
       // echo "<br>";
         $detail_surface = substr("{$surface_ids}", 0, -2);
       // echo "<br>";


if(isset($_POST['detail_root'])){ $detail_root = $conn -> real_escape_string($_POST['detail_root']); }else{ $detail_root = "";}
if(isset($_POST['class_id'])){ $class_id = $conn -> real_escape_string($_POST['class_id']); }else{ $class_id = 0;}
if(isset($_POST['detail_date_complete'])){ $detail_date_complete = $conn -> real_escape_string($_POST['detail_date_complete']); }else{ $detail_date_complete = "";}
if(isset($_POST['causes_of_pay_id'])){ $causes_of_pay_id = $conn -> real_escape_string($_POST['causes_of_pay_id']); }else{ $causes_of_pay_id = 0;}

if(!empty($_SESSION['student'])){ $detail_by_student = $_SESSION['user_id']; }else{ $detail_by_student = 0;}
if(!empty($_SESSION['teacher'])){ $detail_by_teacher = $_SESSION['user_id']; }else{ $detail_by_teacher = 0;}
if(!empty($_SESSION['staff'])){ $detail_by_staff = $_SESSION['user_id']; }else{ $detail_by_staff = 0;}






if(isset($_POST['detail_type_work_id'])){ $detail_type_work_id = $conn -> real_escape_string($_POST['detail_type_work_id']); }else{ $detail_type_work_id = 0;}
if(isset($_POST['student_id'])){ $student_id = $conn -> real_escape_string($_POST['student_id']); }else{ $student_id = 0;}

if(isset($_POST['detail_competency'])){ $detail_competency = $conn -> real_escape_string($_POST['detail_competency']); }else{ $detail_competency = 0;}




$detail_date_work = date("Y-m-d");
$detail_difficult = "";
echo "<br>";

            if($detail_date_complete==""){ 
                $detail_by_complete = 0; 
            }else{   
                $detail_by_complete = $_SESSION['user_id']; 
                }




if(isset($_POST['detail_id']) && !empty($_POST['detail_id']) ){  

    $detail_id = $_POST['detail_id'];


    $sql= " UPDATE tbl_detail SET order_id = '$order_id',
    HN = '$HN',
    detail_tooth = '$detail_tooth',
    detail_surface = '$detail_surface',
    detail_root = '$detail_root',
    class_id = '$class_id',
    detail_type_work_id = '$detail_type_work_id',
    detail_date_work = '$detail_date_work',
    detail_date_complete = '$detail_date_complete',
    causes_of_pay_id = '$causes_of_pay_id',
    detail_difficult = '$detail_difficult',
    detail_competency = '$detail_competency',
    detail_by_complete = '$detail_by_complete'
    WHERE tbl_detail.detail_id = $detail_id ";
    
    
}else{


    $sql= "INSERT INTO tbl_detail (detail_id, order_id, HN, plan_id, detail_tooth, detail_surface, detail_root, class_id, detail_type_work_id,  detail_date_work, detail_date_complete, causes_of_pay_id, detail_difficult, detail_competency, detail_by_student, detail_by_staff, detail_by_teacher) VALUES (NULL, '$order_id', '$HN', '$plan_id', '$detail_tooth', '$detail_surface', '$detail_root', '$class_id', '$detail_type_work_id', '$detail_date_work', '$detail_date_complete', '$causes_of_pay_id', '$detail_difficult' ,'$detail_competency','$detail_by_student', '$detail_by_staff', '$detail_by_teacher');";
    

}

$conn->query($sql); 






    if(isset($_POST['evaluate_edit']) && !empty($_POST['evaluate_edit']) ){  


    echo "<script type='text/javascript'>";
    //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
    echo "window.location='evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$arrange_date&arrange_id=$arrange_id&do=success'";
    echo "</script>";



  }else{  




    
    echo "<script type='text/javascript'>";
    //echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
    echo "window.location='detail.php?order_id=$order_id&student_id=$student_id&do=success'";
    echo "</script>";




  }










?>