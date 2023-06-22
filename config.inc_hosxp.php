<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?PHP

//$serverName = "10.151.122.213";
$serverName = "10.0.1.103";
$userName = "hosxpview";
$userPassword = "HosXp**2021";


//$serverName = "10.151.127.203";
//$userName = "bms";
//$userPassword = "bmshosxp";

$dbName = "hosdent"; 

$conn_hosxp = new mysqli($serverName,$userName,$userPassword,$dbName);


if ($conn_hosxp->connect_error) {
 throw new Exception(" Error connect_error   ");
}


if (!$conn_hosxp->set_charset("utf8")) {
    printf("  Error loadung UTF8   ");
    exit();
}



date_default_timezone_set('Asia/Bangkok');






/*mysqli_set_charset($conn_hosxp,"utf8");
if ($conn_hosxp->connect_errno) {

echo $conn_hosxp->connect_error;
exit;
} else {

}*/




?>