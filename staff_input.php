<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
include "config.inc.php";
include "config.inc_hosxp.php";
              
              $sql = "  SELECT  o.loginname, o.passweb, o.doctorcode,	d.pname, d.fname, d.lname, d.doctor_type_id";
              $sql .=	" FROM opduser o INNER JOIN doctor d ON d.code = o.doctorcode  ";
              $sql .=	" WHERE d.active = 'Y' AND d.position_id != 2 and o.loginname NOT IN ('nunthachai','mos','som','suthisa.j','mazza','tanawut.s','noppasit.c','ddent1','ratchada.r','mongkol.th') and account_disable = 'N' ";
              
              //$sql .=	" and o.loginname NOT LIKE '1%'";



                echo $sql;
                  $query = mysqli_query($conn_hosxp, $sql);
                  $rows = mysqli_num_rows($query);
                  while($result = mysqli_fetch_assoc($query))
                  {
				
                   // echo	$result["doctor_type_id"];
                   // echo "<br>"; 
                        $staff_doctorcode = $result["doctorcode"];
                        $staff_loginname = $result["loginname"];
                        $staff_name = $result["fname"];
                        $staff_surname =  $result["lname"];
                        $staff_log = date('Y-m-d H:i:s');

                  // echo "<br>"; 

                  $sql_chk = " SELECT * FROM tbl_staff where staff_doctorcode = '$staff_doctorcode' ";
                  $query_chk = $conn->query($sql_chk);
                  if($result_chk = $query_chk->fetch_assoc()){

                    $staff_doctorcode;

                    }else{ 

                     $sql_in = "INSERT INTO tbl_staff (staff_id, staff_doctorcode, staff_loginname, staff_name, staff_surname,  staff_status, staff_log) VALUES (NULL, '$staff_doctorcode', '$staff_loginname', '$staff_name', '$staff_surname', '0', '$staff_log');";
                    $conn->query($sql_in); 


                    }


                  //  echo "<br>";
                    }

                    echo "<script language='javascript'>";
                    //echo "window.location='index.php' ";
                    echo "window.location='staff.php' ";
                    echo "</script>";

?>