<?php
ini_set('display_errors', 0); 
include "../config.inc.php";	
include "../_class_student.php";
include "../_class_teacher.php";
include "../_class_class.php";
include "../_class_type_work.php";
include "../_class_plan.php";
include "../_class_causes_of_pay.php";
include "../_class_detail.php";
include "../_class_detail_order.php";


$requestData = $_REQUEST;

$order_id = $_REQUEST['order_id'];

if (!empty($order_id)) {
    $order_id = $order_id;
} else {
    $order_id = 0;
}

$columns = array( 
 0 =>  'd.detail_id', 
 1 =>  'd.detail_id',
 2 =>  'p.type_work_id',
 3 =>  'd.detail_type_work_id',
 4 =>  'd.detail_date_work',
 5 =>  'd.plan_id',
 6 =>  'd.plan_id',
 7 =>  'd.plan_id',
 8 =>  'd.plan_id'
 
);
 



$sql  = " SELECT d.*, p.* FROM tbl_detail as d  ";
$sql .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id";
$sql .= " WHERE order_id = $order_id ";
$query = mysqli_query($conn, $sql) or die("tag-grid-data.php: get tags1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;



$sql  = " SELECT d.*, p.* FROM tbl_detail as d  ";
$sql .= " INNER JOIN  tbl_plan   AS p  ON  p.plan_id = d.plan_id";
$sql .= " WHERE 1=1 and order_id = $order_id ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
 $sql.=" AND ( d.detail_id LIKE '".$requestData['search']['value']."%' ";    
 $sql.=" OR p.plan_name LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR p.plan_name LIKE '%".$requestData['search']['value']."%') ";
}

$query=mysqli_query($conn, $sql) or die("tag-grid-data.php: get tags2");
$totalFiltered = mysqli_num_rows($query);


$i=$requestData['start'];
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$query = mysqli_query($conn, $sql) or die("tag-grid-data.php: get tags3");
$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
$i++;

$row["detail_id"];


        $detail_type_work_id = '<h5><span class="badge bg-success">'.nameType_work::get_type_work_name($row["detail_type_work_id"]).'</span></h5>';     

        $detail = "";
        if (!empty($row['detail_surface'])) {  $detail .= "Surface :".$row['detail_surface']."<br>";  }
        if (!empty($row['detail_root'])) {     $detail .= "Surface :".$row['detail_root']."<br>";  }
        if (!empty($row['class_id'])) {        $detail .= "Class :".nameClass::get_class_name($row['class_id'])."<br>";  }


        if (!empty($row['detail_tooth'])) {   
            
            $array_detail_tooth = (array)json_decode($row['detail_tooth']);
            $toothh ="";

              foreach ($array_detail_tooth as $id => $value) {
                 $toothh .= $value.", ";
              } 
            
            $detail .= "Tooth  :".substr($toothh, 0 ,-2);  
        
        }



        $detail_date_work = date_create($row["detail_date_work"]);
        $detail_date_work = date_format($detail_date_work,"d-m-Y");


       

         if($row['detail_date_complete'] != "0000-00-00"){ 
            $detail_date_complete = date_create($row["detail_date_complete"]);
            $detail_date_complete = date_format($detail_date_complete,"d-m-Y");
            $detail_date_complete = '<i class="fas fa-check-circle" style="font-size:24px;color:green"></i><br>'.nameCauses_of_pay::get_causes_of_pay_name($row['causes_of_pay_id']);
         }else{
            $detail_date_complete = "";
         }
        
        


        $detail_id = $row["detail_id"];
        $nestedData = array(); 
        $nestedData[] = $i;
        $nestedData[] = $row["detail_id"]; 
        $nestedData[] = $row["HN"]; 
        $nestedData[] = nameType_work::get_type_work_name($row['type_work_id']);;
        $nestedData[] = $detail_type_work_id ; 
        $nestedData[] = $row["plan_name"]; 
        $nestedData[] = $detail; 
        $nestedData[] = $detail_date_work; 
        $nestedData[] = $detail_date_complete; 
        $nestedData[] = "";
        $data[] = $nestedData;

}

$conn-> close();

    $json_data = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => intval( $totalrnData ),
        "recordsFiltered" => intval( $totalFiltered ),
        "data" => $data
    );

echo json_encode($json_data);  // send data as json format 




?>