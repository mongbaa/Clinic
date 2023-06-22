<?php 
include "config.inc.php"; 



$plan_id = $_POST['plan_id'];
$form_main_id = $_POST['form_main_id'];  //form_main
$type_work_id = $_POST['type_work_id']; //form_more
$detail_id = $_POST['arrange_nohn_id']; //// เก็บแทน detail_id เพื่อเชื่อมระหว่างงาน
$last_date = $_POST['last_date']; //last_date
$comment = $_POST['comment']; //comment
$arrange_nohn_id = $_POST['arrange_nohn_id']; //arrange_id
$id_form = $_POST['id_form']; //id_form
$student_id = $_POST['student_id']; //arrange_type
$teacher_id = $_POST['teacher_id']; //teacher_id
$arrange_time_type = $_POST['arrange_nohn_time_type']; //teacher_id
$detail_by_teacher = $teacher_id;
$type_nohn = $_POST['type_nohn']; //teacher_id
//////////////////////////////////////////  ฟอร์ม หลัก	/////////////////////////////////////////////////////////////////////////



//ดึงชื่อตารางหลักลงฐานข้อมูล หลัก--------------------
$sql_form_main   =  " SELECT * FROM tbl_form_main WHERE form_main_id = $form_main_id ";
$query_form_main = $conn->query($sql_form_main); 
$row_form_main = $query_form_main->fetch_assoc();
$table=$row_form_main['form_main_table'];
//echo "<br>";
$field_id = $table."_id";
//echo "<br>";
//echo $_POST['field_id'];


////Update
if(isset($_POST['field_id']) && !empty($_POST['field_id'])){  // if  เงื่อนไข หาก  field_id ที่ ส่งมา มีค่า หรือ ไม่เท่ากับ ว่าง แสดงว่า เป้นการบันทึกข้อมูลเพื่อแก้ไข

//echo "Update";
//echo "<br>";

$field_id_up = $_POST['field_id'];


$sql= "UPDATE  tbl_$table SET  ";
//ดึงชื่อตาราง ชื่อฟิลด
$sql_form_detail   =  " SELECT * FROM tbl_form_detail WHERE form_main_id = $form_main_id ORDER BY tbl_form_detail.form_detail_order ASC ";
$query_form_detail = $conn->query($sql_form_detail); 
while($row_form_detail = $query_form_detail->fetch_assoc()){
$field = $row_form_main['form_main_table']."_".$row_form_detail['form_detail_field'];


// field น้ำหนักมีค่า
if($row_form_detail['weight_type_id']!=""){   
	$field_weight = $field."_weight"; // ชื่อfield ในฐานข้อมูล
	$weight = " $field_weight = '{$_POST[$field_weight]}', ";
}else{  
	$weight = ""; 
}		

// field extra
if($row_form_detail['form_detail_extra']=="Y"){  
	$field_extra = $field."_extra"; // ชื่อfield ในฐานข้อมูล
	$extra = " $field_extra = '{$_POST[$field_extra]}', ";
}else{  
	$extra = ""; 
}	

// field competency
if($row_form_detail['form_detail_competency']=="Y"){  
	$field_competency = $field."_competency"; // ชื่อfield ในฐานข้อมูล
	$competency = " $field_competency = '{$_POST[$field_competency]}', ";
}else{  
	$competency = ""; 
}	


// field complete
if($row_form_detail['form_detail_complete']=="Y"){  
	$field_complete = $field."_complete"; // ชื่อfield ในฐานข้อมูล
	$complete = " $field_complete = '{$_POST[$field_complete]}', ";
}else{  
	$complete = ""; 
}	
	


$field_grade = $field."_grade";    
$field_grades = $field."_grades";     
$field_teacher = $field."_teacher";
$field_teachers = $field."_teachers";
$field_date = $field."_date";

//echo $_POST[$field_grade];
//echo $_POST[$field_grades];


//echo "<br>";


			if( isset($_POST[$field_grade]) && !empty($_POST[$field_grade])){

					$sql.= $weight;
					$sql.= $extra;
					$sql.=  " $field_grade = '{$_POST[$field_grade]}', ";

					if($_POST[$field_grade]!=$_POST[$field_grades]){  // เปลี่ยนชื่ออาจารย์หากมีการแก้ไขคะแนน
					 
							$sql.=  " $field_teacher = '{$_POST[$field_teachers]}', ";
				     }else{  
							$sql.=  " $field_teacher = '{$_POST[$field_teacher]}', ";

					 }
									
			}else{

					$sql.= $weight;
					$sql.= $extra;
					$sql.=  " $field_grade = '', ";
					$sql.=  " $field_teacher = '', ";
			
					}


					$date_time = $_POST["$field_date"]." ".date('H:i:s');
					$sql.=  " $field_date = '{$date_time}', ";
					$sql.= $competency;
					$sql.= $complete;


			

}

$field_comment = $table."_comment";   
$last_date = $_POST['last_date']; //last_date
$comment = $_POST['comment']; // comment


//if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){ //เช็คสาขา UPDATE

	//last_time
	$last_time = $_POST['arrange_nohn_time_type'];   
	$sql .= " $field_comment = '{$comment}',  last_date = '{$last_date}', last_time = '{$last_time}'  where $field_id = $field_id_up ";

//}else{

//	$sql .= " $field_comment = '{$comment}',  last_date = '{$last_date}' where $field_id = $field_id_up ";

//}



//echo $sql;
$conn->query($sql); 

$id_insert_id = $field_id_up;


}else{ 



 $sql= "INSERT INTO tbl_$table ( $field_id , student_id, detail_id, ";



			//ดึงชื่อตาราง ชื่อฟิลด
			$sql_form_detail   =  " SELECT * FROM tbl_form_detail WHERE form_main_id = $form_main_id ORDER BY tbl_form_detail.form_detail_order ASC ";
			$query_form_detail = $conn->query($sql_form_detail); 
			while($row_form_detail = $query_form_detail->fetch_assoc()){
			$field=$row_form_main['form_main_table']."_".$row_form_detail['form_detail_field'];




					// field น้ำหนักมีค่า
					 if($row_form_detail['weight_type_id']!=1){ $field_weight = $field."_weight, "; }else{ $field_weight = ""; }
					 if($row_form_detail['form_detail_extra']=="Y"){ $field_extra = $field."_extra, "; }else{ $field_extra = ""; }
					 if($row_form_detail['form_detail_competency']=="Y"){ $field_competency = $field."_competency, "; }else{ $field_competency = ""; }
					 if($row_form_detail['form_detail_complete']=="Y"){ $field_complete = $field."_complete, "; }else{ $field_complete = ""; }



					  $sql.= $field_weight;
					  $sql.= $field_extra;
					  $sql.= $field_grade = " $field"."_grade, ";
					  $sql.= $field_teacher = " $field"."_teacher, "; 
					  $sql.= $field_date = " $field"."_date, ";
					  $sql.= $field_competency;
					  $sql.= $field_complete;


				}

					$table = $row_form_main['form_main_table'];




					//if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){ //เช็คสาขา UPDATE


						$sql .= " $table" . "_comment,  last_date, last_time, $table"."_log ) VALUES (NULL, '{$student_id}', '{$detail_id}' , ";
				
					//}else{
				

					//	$sql .= " $table" . "_comment,  last_date, $table"."_log ) VALUES (NULL, '{$student_id}', '{$detail_id}' , ";
				
				
					//}


                  
				
				
				$grades_log ="";
					//ดึงชื่อตาราง ชื่อฟิลด
                $sql_form_detail  =  " SELECT * FROM tbl_form_detail WHERE form_main_id = $form_main_id ORDER BY tbl_form_detail.form_detail_order ASC ";
				$query_form_detail = $conn->query($sql_form_detail); 
				while($row_form_detail = $query_form_detail->fetch_assoc()){
					
					$field=$row_form_main['form_main_table']."_".$row_form_detail['form_detail_field'];
					//$field=$row_form_detail['form_detail_field'];

		            $field_grade = $field."_grade";       
			        $field_teacher = $field."_teacher";
					$field_date = $field."_date";
			
					
					echo "<br>";
					
if(isset($_POST[$field_grade]) && !empty($_POST[$field_grade]) ){  
	

if($row_form_detail['weight_type_id']!=""){  $field_weight = $field."_weight";  $weight = " '{$_POST[$field_weight]}', ";  }else{  $weight = ""; }		
if($row_form_detail['form_detail_extra']=="Y"){  $field_extra = $field."_extra";  $extra = "'{$_POST[$field_extra]}', ";   }else{ $extra = ""; }
if($row_form_detail['form_detail_competency']=="Y"){ $field_competency = $field."_competency"; $competency = "'{$_POST[$field_competency]}', "; }else{ $competency = ""; }
if($row_form_detail['form_detail_complete']=="Y"){ $field_complete = $field."_complete";   $complete = "'{$_POST[$field_complete]}', "; }else{ $complete = ""; }
					

					$date_time = $_POST[$field_date]." ".date('H:i:s');
					
					$sql.= $weight;
					$sql.= $extra;
					$sql.= $grade = " '{$_POST[$field_grade]}', ";
                    $sql.= $teacher = " '{$_POST[$field_teacher]}', ";
                    $sql.= $date = " '$date_time', ";
					$sql.= $competency;
					$sql.= $complete;

				
					}else{ //if
			
						
if($row_form_detail['weight_type_id']!=""){  $field_weight = $field."_weight";     $weight = "'', ";  }else{  $weight = ""; }				
if($row_form_detail['form_detail_extra']=="Y"){  $field_extra = $field."_extra";  $extra = "'', ";   }else{ $extra = ""; }
if($row_form_detail['form_detail_competency']=="Y"){ $field_competency = $field."_competency"; $competency = "'', "; }else{ $competency = ""; }
if($row_form_detail['form_detail_complete']=="Y"){ $field_complete = $field."_complete";   $complete = "'', "; }else{ $complete = ""; }
									
					$sql.= $weight;
					$sql.= $extra;
					$sql.= " '', ";
                    $sql.= " '', ";
                    $sql.= " '', ";
					$sql.= $competency;
					$sql.= $complete;
						
			       } //else

}// while


if($arrange_type == 0) {
	$date_time_now = date('Y-m-d');
	$field_date_s = $_POST['$field_date'];
	if($field_date_s == $date_time_now ){ $ss="normal";}else{ $ss="back";	}
	$ss="Normal";
	$type_ss="Clinic";
}else{
	$ss="Normal";
	$type_ss="LAB";
}
$date_time_now = date('Y-m-d H:i:s');
$log .= "$date_time_now|$date_time|$ss|$type_ss,/";




 


    //if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){ //เช็คสาขา UPDATE
		$last_time = $_POST['arrange_nohn_time_type'];   

		$sql .= " '{$comment}', '{$last_date}', '{$last_time}', '{$log}')";

	//}else{

	//	$sql .= " '{$comment}', '{$last_date}', '{$log}')";
		
	//}




	   //echo $sql;
	   $conn->query($sql); 


	   $id_insert_id =  mysqli_insert_id($conn);

} // else if  เงื่อนไข หาก  field_id ที่ ส่งมา มีค่า หรือ ไม่เท่ากับ ว่าง แสดงว่า เป้นการบันทึกข้อมูลเพื่อแก้ไข

////ดึงชื่อตารางหลักลงฐานข้อมูล หลัก--------------------

//////////////////////////////////////////  ฟอร์ม หลัก	/////////////////////////////////////////////////////////////////////////













//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////
$sql_form_main   =  " SELECT * FROM tbl_form_main WHERE form_main_id = $form_main_id ";
$query_form_main = $conn->query($sql_form_main); 
$row_form_main = $query_form_main->fetch_assoc();

$table=$row_form_main['form_main_table'];
$field_id = $table."_id";

/*
 echo $id_insert_id;
 echo "<br>";
 echo "tbl_$table";
 echo "<br>";
 echo "$field_id";
 echo "<br>";
*/
 
 $sql_form_re_nohn = "SELECT * FROM tbl_" . $table . " where $field_id = $id_insert_id";
 $query_form_re_nohn = $conn->query($sql_form_re_nohn);
 if ($row_form_re_nohn = $query_form_re_nohn->fetch_assoc()) {

echo "<br>";
	$sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
	$sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
	$sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
	 $sql_form_detail_re;
	$query_form_detail_re = $conn->query($sql_form_detail_re);
	while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
		$i_re++;
		echo "<br>";
	

		$field = $table . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
		$field_grade = $field . "_grade";  //_grade
		echo	$grade = $row_form_re_nohn["{$field_grade}"];

		if (isset($grade) && !empty($grade)) {
			$field_weights = $field . "_weight";   //_weight
			$weight = $row_form_re_nohn["{$field_weights}"];
			$field_teacher = $field . "_teacher";  //_teacher
			$teacher = $row_form_re_nohn["{$field_teacher}"];
			$field_date = $field . "_date";  //_date
			$datee = $row_form_re_nohn["{$field_date}"];
		} else {
			$weight = "";
			$teacher = "";
			$datee = "";
		}

		
		if ($grade == "A") {
			$score = 4;
			$stepp = 1;
			$weight_ss =  $weight;
		
		} else if ($grade == "B") {
			$score = 3;
			$stepp = 1;
			$weight_ss =  $weight;
			
		} else if ($grade == "C") {
			$score = 2;
			$stepp = 1;
			$weight_ss =  $weight;
		
		} else if ($grade == "F") {
			$score = 1;
			$stepp = 1;
			$weight_ss =  $weight;
		
		} else {
			$score = 0;
			$stepp = 0;
			$weight_ss =  0;
		
		}
 
		/*echo "---";
		echo $weight_ss;
		echo "---";
		echo $score;
		echo " = ";*/
        $sum_score = $weight_ss * $score; // ผลคูณคะแนน

		$total_score = $total_score + $sum_score;
		$total_weight = $total_weight + $weight_ss;
		$total_step = $total_step + $stepp;

	}
	/*echo "<br>";
	echo  $total_score;
	echo "<br>";
	echo  $total_weight;
	echo "<br>";*/
	$sum_total_score = $total_score / $total_weight;


 }


 echo "<br>";
//////////////////////////////////////////   คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////



// ,sum_weight_nohn = '$total_weight',  sum_scores_nohn = '$total_score',  sum_grade_nohn = '$sum_total_score'
 


//////////////////////////////////////////  อัพเดทสถานะการประเมิน	///////////////////////////////////////////////////////////////////////// 
$sql_update_arrange= "UPDATE tbl_arrange_nohn SET arrange_nohn_check_eval = '1', sum_score_nohn = '$sum_total_score' ,sum_weight_nohn = '$total_weight',  sum_scores_nohn = '$total_score',  sum_grade_nohn = '$sum_total_score' WHERE tbl_arrange_nohn.arrange_nohn_id = $arrange_nohn_id ";
$conn->query($sql_update_arrange); 

//////////////////////////////////////////  อัพเดทสถานะการประเมิน	///////////////////////////////////////////////////////////////////////// 
























//////////////////////////////////////////  ฟอร์ม  holistic 	/////////////////////////////////////////////////////////////////////////


include "config.inc.php"; 
$holistic_date = $last_date;
$holistic_time = date('H:i:s');
$holistic_time_type = $arrange_time_type;




//////////////////////////////////////////  UPDATE 
if(isset($_POST['holistic_id']) && !empty($_POST['holistic_id'])){ 

            $holistic_id = $_POST['holistic_id'];

                $sql_up_holistic= "UPDATE tbl_holistic SET  ";

            $sql_holistic = "SELECT * FROM tbl_form_holistic ORDER BY tbl_form_holistic.form_holistic_order ASC";
            $query_holistic = $conn->query($sql_holistic); 
            while($row_holistic = $query_holistic->fetch_assoc()) {

                $holisticfield = $row_holistic['form_holistic_field'];
                $holistic_field = "ho".$row_holistic['form_holistic_field'];
                $value_ho = $_POST["{$holistic_field}"];

                $holistic_note = $row_holistic['form_holistic_field']."_note";
                $value_note = $_POST["{$holistic_note}"];

                $sql_up_holistic .= " $holisticfield = '$value_ho', $holistic_note = '$value_note', ";

                }
                $sql_up_holistic= substr("$sql_up_holistic",0,-2); // ตัด , ตัวสุดท้ายออก
				$sql_up_holistic .= " ,type_nohn = '$type_nohn'  WHERE holistic_id = $holistic_id";
                $conn->query($sql_up_holistic); 
}else{ 
//////////////////////////////////////////  INSERT 
                $sql_in_holistic = "INSERT INTO tbl_holistic ( holistic_id , type_work_id, teacher_id, student_id, holistic_date,  holistic_time, holistic_time_type, detail_id,  ";

                $sql_holistic = "SELECT * FROM tbl_form_holistic ORDER BY tbl_form_holistic.form_holistic_order ASC";
                $query_holistic = $conn->query($sql_holistic); 
                while($row_holistic = $query_holistic->fetch_assoc()) {
                $holistic_field = $row_holistic['form_holistic_field'];
                $holistic_note = $row_holistic['form_holistic_field']."_note";

                            $sql_in_holistic .=  $holistic_field.", ".$holistic_note.", ";
                }

                            $sql_in_holistic= substr("$sql_in_holistic",0,-2); // ตัด , ตัวสุดท้ายออก
                            $sql_in_holistic .= " , type_nohn ) VALUES (NULL, '$type_work_id', '$teacher_id', '$student_id', '$holistic_date', '$holistic_time', '$holistic_time_type', '$detail_id',  ";

                            

                $query_holistic = $conn->query($sql_holistic); 			
                while($row_holistic = $query_holistic->fetch_assoc()) {
                $holistic_field = "ho".$row_holistic['form_holistic_field'];
                $value_ho = $_POST["{$holistic_field}"];

                $holistic_note = $row_holistic['form_holistic_field']."_note";
                $value_note = $_POST["{$holistic_note}"];

                            $sql_in_holistic.=  " '{$value_ho}', '{$value_note}', ";
                }
                        $sql_in_holistic= substr("$sql_in_holistic",0,-2); // ตัด , ตัวสุดท้ายออก
                        $sql_in_holistic.= " ,'$type_nohn' )";
                        $conn->query($sql_in_holistic); 
}
//////////////////////////////////////////  ฟอร์ม  holistic 	/////////////////////////////////////////////////////////////////////////




echo "<script type='text/javascript'>";
//echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
echo "window.location='evaluate_nohn.php?student_id=$student_id&plan_id=$plan_id&arrange_nohn_date=$last_date&arrange_nohn_id=$arrange_nohn_id&id_form=$id_form&do=success'";

echo "</script>";

