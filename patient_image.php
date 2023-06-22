<meta charset="utf-8">
<?PHP
 include "config.inc_hosxp.php";	


 $sql_patient="select COLUMN_NAME As cn from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = 'patient_image' ";	
 $query_patient = $conn_hosxp->query($sql_patient);
 while($result_patient  = $query_patient->fetch_assoc())
 {

    echo "<br>";
    echo $result_patient['cn'];

    
 }



         

        echo  $sql="SELECT * FROM patient_image ORDER BY patient_image.hn ASC LIMIT 10 ";	
              $query = $conn_hosxp->query($sql);
              while($result  = $query->fetch_assoc())
              {
             echo $result['hn'];
             echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['image'] ).'"/>';
    

              }






?>
                            