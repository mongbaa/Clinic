<?PHP

$serverName = "localhost";
$userName = "root";
$userPassword = "root2018*mysql";
//$userPassword = "";
$dbName = "db_clinic"; 


date_default_timezone_set('Asia/Bangkok');
 
$conn = new mysqli($serverName,$userName,$userPassword,$dbName);

mysqli_set_charset($conn,"utf8");
if ($conn->connect_errno) {
echo $conn->connect_error;
exit;
} else {

}
?> 