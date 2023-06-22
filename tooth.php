<?php if (in_array("All / Full mouth", $array_detail_tooth)) {
        
        echo "All / Full mouth";
        $array_detail_tooth = array(18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28, 48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38,);
 
}else{

         $array_detail_tooth = $array_detail_tooth;

         $toothh ="";
         foreach ($array_detail_tooth as $id => $value) {
          $toothh .= $value.", ";
         }
         echo $toothh;
 }

?>

<center>
<?php  //ซี่ที่ 11 - 18
for ($a = 18, $b = 1; $a >= 11, $b <= 8; $a--, $b++) {
?>                               
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/blue_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>

<?php } $a = 0 ;?>






<?php   //ซี่ที่ 21 - 28
 for ($a = 21, $b = 9; $a <= 28, $b <= 16; $a++, $b++) {
?>                               
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/blue_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>
        
<?php } $a = 0 ;?>


<BR>

<?php   //ซี่ที่ 41 - 48
 for ($a = 48, $b = 17; $a >= 41, $b <= 24; $a--, $b++) {
?>                               
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/blue_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>
        
<?php } $a = 0 ;?>



<?php   //ซี่ที่ 31 - 38
 for ($a = 31, $b = 25; $a <= 38, $b <= 32; $a++, $b++) {
?>                               
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/blue_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>        
<?php } $a = 0 ;?>


<BR>

<?php   //ซี่ที่ 51 - 55
  for ($a = 55, $b = 1; $a >= 51, $b <= 5; $a--, $b++) {
?>                               
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/yellow_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>
        
<?php } $a = 0 ;?>



<?php   //ซี่ที่ 61 - 58
   for ($a = 61, $b = 6; $a <= 58, $b <= 10; $a++, $b++) {
?>                               
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/yellow_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>        
<?php } $a = 0 ;?>







<BR>

<?php  //ซี่ที่ 85 - 81
  for ($a = 85, $b = 11; $a >= 81, $b <= 15; $a--, $b++) {
?>                            
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/yellow_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>
        
<?php } $a = 0 ;?>



<?php  //ซี่ที่ 71 - 75
  for ($a = 71, $b = 16; $a <= 75, $b <= 20; $a++, $b++) {
?>                             
        <?php if (in_array($a, $array_detail_tooth)) {?>
        <img src="images/yellow_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }else{?>
        <img src="images/grey_<?php echo $a;?>.png" width="58" height="58" alt=""/>
        <?php }?>        
<?php } $a = 0 ;?>

</center>




