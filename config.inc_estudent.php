<?PHP

$serverName = "sys.dent.psu.ac.th";
$userName = "estudent_sys";
$userPassword = "eStudent@2021";
$dbName = "estudent"; 

date_default_timezone_set('Asia/Bangkok');

$conn_estudent = new mysqli($serverName,$userName,$userPassword,$dbName);
mysqli_set_charset($conn_estudent,"utf8");

if ($conn->connect_errno) {
echo $conn->connect_error;
exit;
} else {

}
?>