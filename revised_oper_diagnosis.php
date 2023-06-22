<meta charset="utf-8">
<?php



include "config.inc.php";
echo $sql_oper_diagnosis  = "SELECT * FROM tbl_oper_diagnosis ORDER BY tbl_oper_diagnosis.oper_diagnosis_id DESC ";
$query_oper_diagnosis = $conn->query($sql_oper_diagnosis);
echo $num_rows_oper_diagnosis = $query_oper_diagnosis->num_rows;

while ($row_oper_diagnosis = $query_oper_diagnosis->fetch_assoc()) {


    echo "<br>";
    echo $oper_diagnosis_id = $row_oper_diagnosis['oper_diagnosis_id'];

    echo "--";
    echo $oper_diagnosis_difficulty = $row_oper_diagnosis['oper_diagnosis_difficulty'];
    
    echo " = ";

   // $newStr = str_replace(" ", "", $oper_diagnosis_caries);

   //$newStr = ereg_replace('[[:space:]]+', ' ', trim($oper_diagnosis_caries)); //หน้า + หลัง
    
   // $newStr = ereg_replace('[[:space:]]+', '', trim($oper_diagnosis_caries));
   // $newStr = ereg_replace('caries', ' caries', $newStr);


   //$newStr = ereg_replace('[[:space:]]+', '', trim($oper_diagnosis_noncarious));


  /* $newStr = ereg_replace('[[:space:]]+', '', trim($oper_diagnosis_defect));
   $newStr = ereg_replace('Others', 'Others ', $newStr);
   $newStr = ereg_replace('pit&', '  pit & ', $newStr);
   $newStr = ereg_replace('line', ' line', $newStr);
   $newStr = ereg_replace('fracture', ' fracture', $newStr);
   */


/*
  $newStr = ereg_replace('[[:space:]]+', '', trim($oper_diagnosis_replacement));
  $newStr = ereg_replace('of', ' of ', $newStr);
  $newStr = ereg_replace('fracture', ' fracture', $newStr);
  $newStr = ereg_replace('dislodged', 'dislodged ', $newStr);
  $newStr = ereg_replace('defective', ' defective ', $newStr);
  $newStr = ereg_replace('staining', ' staining ', $newStr);
  $newStr = ereg_replace('colored', 'colored ', $newStr);
  $newStr = ereg_replace('fracturedrestoration', 'fractured restoration', $newStr);
  $newStr = ereg_replace('improper', 'improper ', $newStr);
  $newStr = ereg_replace('endodonticwork', 'endodontic work', $newStr);
  $newStr = ereg_replace('marginalleakag', 'marginal leakag', $newStr);
  $newStr = ereg_replace('estheticsconcern', 'esthetics concern', $newStr);
  $newStr = ereg_replace('others', 'others ', $newStr);
*/


/*
    $newStr = ereg_replace('[[:space:]]+', '', trim($oper_diagnosis_polish));
    $newStr = ereg_replace('"None"', '["None"]', $newStr);
    $newStr = ereg_replace('"Indirect"', '["Indirect"]', $newStr);
    */
  
    /*
    $newStr = ereg_replace('[[:space:]]+', '', trim($oper_diagnosis_osler));
    $newStr = ereg_replace('"N"', '["N"]', $newStr);
    */

    $newStr = ereg_replace('[[:space:]]+', '', trim($oper_diagnosis_difficulty));
    
    $newStr = ereg_replace(' ', '[]', $newStr);

    $newStr = ereg_replace('""', '[]', $newStr);
    $newStr = ereg_replace('"0"', '["0"]', $newStr);
    $newStr = ereg_replace('"1"', '["1"]', $newStr);

    
    $newStr = ereg_replace('"0.1"', '["0.1"]', $newStr);
    $newStr = ereg_replace('"-0.1"', '["-0.1"]', $newStr);

    $newStr = ereg_replace('"0.2"', '["0.2"]', $newStr);
    $newStr = ereg_replace('"-0.2"', '["-0.2"]', $newStr);

    $newStr = ereg_replace('"0.25"', '["0.25"]', $newStr);
    $newStr = ereg_replace('"-0.25"', '["-0.25"]', $newStr);

    $newStr = ereg_replace('"0.5"', '["0.5"]', $newStr);
    $newStr = ereg_replace('"-0.5"', '["-0.5"]', $newStr);

    





    echo $sql_update  = "UPDATE tbl_oper_diagnosis SET oper_diagnosis_difficulty = '$newStr' WHERE oper_diagnosis_id = $oper_diagnosis_id";
    //$conn->query($sql_update);


    echo "<br>";



}

$conn->close();

?>