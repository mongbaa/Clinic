<?php
ini_set('display_errors', 0); 
include "config.inc.php"; 		
$requestData = $_REQUEST;



$columns = array( 
 0 =>  'HN',
 1 =>  'pname',
 2 =>  'fname',
 3 =>  'lname',
 4 =>  'student_id'
);



$sql = "SELECT order_id, HN, pname, fname, lname, student_id ";
$sql.=" FROM tbl_order where order_type = 0 ";
$query=mysqli_query($conn, $sql) or die("tag-grid-data.php: get tags1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;


$sql = "SELECT order_id, HN, pname, fname, lname, student_id ";
$sql.=" FROM tbl_order WHERE order_type = 0 and 1=1";



if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
 $sql.=" AND ( HN LIKE '".$requestData['search']['value']."%' ";    
 $sql.=" OR pname LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR fname LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR lname LIKE '".$requestData['search']['value']."%' ";
 $sql.=" OR student_id LIKE '%".$requestData['search']['value']."%') ";
}

$query=mysqli_query($conn, $sql) or die("tag-grid-data.php: get tags2");
$totalFiltered = mysqli_num_rows($query);


//$sql.=" ORDER BY order_id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";



$query = mysqli_query($conn, $sql) or die("tag-grid-data.php: get tags3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
 $nestedData=array(); 



        $student_id = $row["student_id"];

        $sql_student = " SELECT * FROM tbl_student where student_id = $student_id";
        $query_student = $conn->query($sql_student);
        $row_student = $query_student->fetch_assoc();
        $student = $row_student['student_id']." ".$row_student['student_name']." ".$row_student['student_lastname'];

 
 $nestedData[] = $row["HN"];
 $nestedData[] = $row["pname"];
 $nestedData[] = $row["fname"];
 $nestedData[] = $row["lname"];
 $nestedData[] = $student;
 $data[] = $nestedData;


}


    $json_data = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => intval( $totalrnData ),
        "recordsFiltered" => intval( $totalFiltered ),
        "data" => $data
    );

echo json_encode($json_data);  // send data as json format 




?>