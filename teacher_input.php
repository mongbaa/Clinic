<?php
include "config.inc.php";
include "config.inc_hosxp.php";
              
                  $sql = "  SELECT  o.loginname, o.passweb, o.doctorcode,	d.pname, d.fname, d.lname, d.doctor_type_id";
                  $sql .=	" FROM opduser o LEFT JOIN doctor d ON d.code = o.doctorcode";
                  $sql .=	" WHERE d.active = 'Y' AND d.doctor_type_id  IN (3,4) and o.loginname NOT IN ('nunthachai','mos','som','suthisa.j','mazza','tanawut.s','noppasit.c','ddent1','ratchada.r','mongkol.th') ";
                  $sql .=	"  and o.loginname NOT LIKE '1%'";
                  
                  $query = mysqli_query($conn_hosxp, $sql);
                  $rows = mysqli_num_rows($query);
                  while($result = mysqli_fetch_assoc($query))
                  {
				
                   // echo	$result["doctor_type_id"];
                   // echo "<br>"; 
                        $teacher_doctorcode = $result["doctorcode"];
                        $teacher_loginname = $result["loginname"];
                        $teacher_name = $result["fname"];
                        $teacher_surname =  $result["lname"];
                        $teacher_log = date('Y-m-d H:i:s');

                  // echo "<br>"; 

                  $sql_chk = " SELECT * FROM tbl_teacher where teacher_doctorcode = '$teacher_doctorcode' ";
                  $query_chk = $conn->query($sql_chk);
                  if($result_chk = $query_chk->fetch_assoc()){

                    $teacher_doctorcode;

                    }else{ 

                    $sql_in = "INSERT INTO tbl_teacher (teacher_id, teacher_doctorcode, teacher_loginname, teacher_name, teacher_surname, type_work_id, type_work_id_array, teacher_licences_status, teacher_status, teacher_log) VALUES (NULL, '$teacher_doctorcode', '$teacher_loginname', '$teacher_name', '$teacher_surname', '0', '[]', '0', '0', '$teacher_log');";
                    $conn->query($sql_in); 

                    }


                    }

                    echo "<script language='javascript'>";
                    //echo "window.location='index.php' ";
                    echo "window.location='teacher.php' ";
                    echo "</script>";

?>