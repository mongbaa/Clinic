<?PHP
$serverName_dent_form = "localhost";
$userName_dent_form = "root";
$userPassword_dent_form = "root2018*mysql";
$dbName_dent_form = "db_dentform"; 

date_default_timezone_set('Asia/Bangkok');
$conn_dent_form = new mysqli($serverName_dent_form,$userName_dent_form,$userPassword_dent_form,$dbName_dent_form);
mysqli_set_charset($conn_dent_form,"utf8");

if ($conn_dent_form->connect_errno) {
echo $conn_dent_form->connect_error;
exit;
} else {

}
?>
