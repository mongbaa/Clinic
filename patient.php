<?PHP
 include "config.inc_hosxp.php";	


 /*$sql_patient="select COLUMN_NAME As cn from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'patient' ";	
 $query_patient = $conn_hosxp->query($sql_patient);
 while($result_patient  = $query_patient->fetch_assoc())
 {

    echo "<br>";
    echo $result_patient['cn'];

    
 }*/


         

        echo  $sql="SELECT * FROM patient ORDER BY patient.hn ASC LIMIT 30 ";	
              $query = $conn_hosxp->query($sql);
              while($result  = $query->fetch_assoc())
              {


              echo $result['hn'];

              echo $result['pname'];

              echo $result['fname'];


              echo $result['lname'];
              echo "<br>";
              

              }






?>
                            