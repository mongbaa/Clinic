<?php




$uploaddir = "../pic_students1"; //Image upload directory

foreach ($_FILES['photos']['name'] as $name => $value)
{

    $filename = stripslashes($_FILES['photos']['name'][$name]);

    $file_name1 = substr($filename,0,10);
	
    
	$newname = $uploaddir.$file_name1.".jpg";

echo $newname;
echo "<br>";

/*	
if(move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname))
{

include "config.inc.php";
$sql_update = " UPDATE estudent.tbl_student  SET STUD_IMAGES='$file_name1' where STUDENT_ID = $file_name1 ";
$conn->query($sql_update);
	
}*/



}
