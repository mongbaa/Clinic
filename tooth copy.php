

<table border="1" cellpadding="5" cellspacing="5" class="table">



<tr>
<?php  //ซี่ที่ 11 - 18
for ($a = 18, $b = 1; $a >= 11, $b <= 8; $a--, $b++) {
?>                               
<td class="css_tr_data" bgcolor="#E8F4EE" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>


<td  bgcolor="#FFFFFF" width="60" align="center"> </td>

<?php  //ซี่ที่ 21 - 28
 for ($a = 21, $b = 9; $a <= 28, $b <= 16; $a++, $b++) {
?>                             
<td class="css_tr_data" bgcolor="#FFFFCC" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>
</tr>














<tr>
<?php  //ซี่ที่ 41 - 48
for ($a = 48, $b = 17; $a >= 41, $b <= 24; $a--, $b++) {
?>                              
<td class="css_tr_data" bgcolor="#99CCFF" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>


<td  bgcolor="#FFFFFF" width="60" align="center"> </td>

<?php //ซี่ที่ 31 - 38
for ($a = 31, $b = 25; $a <= 38, $b <= 32; $a++, $b++) {
?>                         
<td class="css_tr_data" bgcolor="#FFCCCC" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>
</tr>







<tr>
<td  colspan="3"  bgcolor="#FFFFFF" width="60" align="center"> </td>
<?php  //ซี่ที่ 51 - 55
     for ($a = 55, $b = 1; $a >= 51, $b <= 5; $a--, $b++) {
?>                            
<td class="css_tr_data" bgcolor="#FF8083" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>


<td  bgcolor="#FFFFFF" width="60" align="center"> </td>

<?php  //ซี่ที่ 61 - 65
     for ($a = 61, $b = 6; $a <= 65, $b <= 10; $a++, $b++) {
?>                       
<td class="css_tr_data" bgcolor="#3399CC" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>
<td  colspan="3"  bgcolor="#FFFFFF" width="60" align="center"> </td>
</tr>





<tr>
<td  colspan="3"  bgcolor="#FFFFFF" width="60" align="center"> </td>
<?php  //ซี่ที่ 85 - 81
     for ($a = 85, $b = 11; $a >= 81, $b <= 15; $a--, $b++) {
?>                            
<td class="css_tr_data" bgcolor="#64D067" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>


<td  bgcolor="#FFFFFF" width="60" align="center"> </td>

<?php  //ซี่ที่ 71 - 75
     for ($a = 71, $b = 16; $a <= 75, $b <= 20; $a++, $b++) {
?>                       
<td class="css_tr_data" bgcolor="#FFFF9F" align="center">
    <label>
        <input name="tooth_id[]" type="checkbox" class="css_tooth_id" id="tooth_id<?php echo $a;?>" value="<?php echo $a;?>"/><br>
        <img src="images/dent.png" width="32" height="32" alt=""/><br>
        <b><?php echo $a;?></b>	
    </label>
</td>
<?php } $a = 0 ;?>
<td  colspan="3"  bgcolor="#FFFFFF" width="60" align="center"> </td>
</tr>









</table>
<script src="plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">  
$(function(){        
    
    var highlight_bgColor="#A6F83D";        // กำหนดสี highlight ที่ต้องการ
    $("#css_all_check").click(function(){ // เมื่อคลิกที่ checkbox ตัวควบคุม  
        if($(this).prop("checked")){ // ตรวจสอบค่า ว่ามีการคลิกเลือก  
            $(".css_tooth_id").prop("checked",true); // กำหนดให้ เลือก checkbox ที่ต้องการ ที่มี class ตามกำหนด   
            $(".css_tr_data").css("background-color",highlight_bgColor); // กำหนดสีพื้นหลังของแถวที่เลือก
        }else{ // ถ้าไม่มีการ ยกเลิกการเลือก  
            $(".css_tooth_id").prop("checked",false); // กำหนดให้ ยกเลิกการเลือก checkbox ที่ต้องการ ที่มี class ตามกำหนด              
            $(".css_tr_data").each(function(k_data,v_data){ // วนหลูปแถวที่มี class ชื่อ css_tr_data
                var old_bgColor=$(this).attr("bgcolor");        // เรียกสีพื้นหลังเดิมมาเก็บไว้ในตัวแปร         
                old_bgColor=(old_bgColor!=undefined)?old_bgColor:"";    // กำหนดค่าสีพื้นหลังเดิม กรณีไม่มี หรือมีค่า       
                $(this).css("background-color",old_bgColor); // ยกเลือกสีพื้นหลัง หรือกำหนดเป็นค่าเดิม
            });             
        }  
    });     
       
    $(".css_tooth_id").click(function(){  // เมื่อคลิก checkbox  ใดๆ       
        var parentTR=$(this).parents(".css_tr_data");  // หาแถวที่ checkbox นั้นๆที่คลิก อยู่ด้านใน
        var old_bgColor=parentTR.attr("bgcolor"); // เรียกสีพื้นหลังเดิมมาเก็บไว้ในตัวแปร
        old_bgColor=(old_bgColor!=undefined)?old_bgColor:""; // กำหนดค่าสีพื้นหลังเดิม กรณีไม่มี หรือมีค่า
        if($(this).prop("checked")){
            parentTR.css("background-color",highlight_bgColor); // กำหนดสีพื้นหลังของแถวที่เลือกทั้งหมด
        }else{
            parentTR.css("background-color",old_bgColor); // ยกเลือกสีพื้นหลัง หรือกำหนดเป็นค่าเดิม
        }
    });  
 
    $("#dropmsgform").submit(function(){ // เมื่อมีการส่งข้อมูลฟอร์ม  
        if($(".css_tooth_id:checked").length==0){ // ถ้าไม่มีการเลือก checkbox ใดๆ เลย  
            alert("ยังไม่ได้เลือกซี่ฟัน");  
            return false;     
        }  
		
		 if($(".css_tooth_id:checked").length>=8){ // ถ้าไม่มีการเลือก checkbox ใดๆ เลย  
            alert("เลือกซี่ฟันได้ไม่เกิน 8 ซี่");  
            return false;     
        }  
		
		
    });     
   
});  
</script> 