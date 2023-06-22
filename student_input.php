<?php
include "config.inc.php";
include "config.inc_hosxp.php";
                       
                            $sql = "  SELECT  o.loginname, o.passweb, o.doctorcode,	d.pname, d.fname, d.lname, d.doctor_type_id";
                            $sql .=	" FROM opduser o LEFT JOIN doctor d ON d.code = o.doctorcode";
                            $sql .=	" WHERE d.active = 'Y' AND d.doctor_type_id  IN (1) and o.loginname NOT IN ('terapong','aa','logintest','case11','case22','case','sdent1') ";
						 
					$query = mysqli_query($conn_hosxp, $sql);
					$rows = mysqli_num_rows($query);
					while($result = mysqli_fetch_assoc($query))
					{
				
                    	$result["doctor_type_id"];

                        $student_id = $result["loginname"];
                        $student_name = $result["fname"];
                        $student_lastname =  $result["lname"];
                        $student_doctorcode = $result["doctorcode"];
                        $student_log = date('Y-m-d H:i:s');

                   // echo "<br>"; 
                    
                    $sql_in = "INSERT INTO tbl_student (student_id, student_name, student_lastname, student_level, student_group, student_active, lstudent_licences, student_doctorcode, student_status, student_log) VALUES ('$student_id', '$student_name', '$student_lastname', '4', '', '0', '0', '$student_doctorcode', '1','$student_log');";
				    $conn->query($sql_in);

                    }

                    echo "<script language='javascript'>";
                    //echo "window.location='index.php' ";
                    echo "window.location='student_list.php?level_search=4' ";
                    echo "</script>";

?>