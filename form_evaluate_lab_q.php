<?PHP session_start(); ?>
<meta charset="utf-8">
<?php
include "config.inc.php";

 
$plan_id = $_POST['plan_id'];
$form_main_id = $_POST['form_main_id']; //form_main_id
$type_work_id = $_POST['type_work_id']; //type_work_id
$detail_id = $_POST['detail_id']; //detail_id
$last_date = $_POST['last_date']; //last_date
$comment = $_POST['comment']; //comment
$arrange_id = $_POST['arrange_id']; //arrange_id
$id_form = $_POST['id_form']; //id_form
$arrange_type = $_POST['$arrange_type']; //arrange_type
$student_id = $_POST['student_id']; //arrange_type
$teacher_id = $_POST['teacher_id']; //teacher_id
$arrange_time_type = $_POST['arrange_time_type']; //teacher_id


$detail_by_teacher = $teacher_id;

if(!empty($_POST['Complete'])){
	$detail_date_complete = $last_date;
	$detail_complete = 1;
	$causes_of_pay_id = 7;
}else{
	$detail_date_complete = "0000-00-00";
	$detail_complete = 0;
	$causes_of_pay_id = 0;
}


if(!empty($_POST['competency'])){
	$detail_competency = 1;
}else{
	$detail_competency = 0;
}



 

// อัพเดทสถานะการประเมิน
//$sql_update_arrange= "UPDATE db_clinic.tbl_arrange SET arrange_check_eval = '1' WHERE tbl_arrange.arrange_id = $arrange_id ";
//$conn->query($sql_update_arrange); 


$arrange_check_date_eval = date('Y-m-d H:i:s');

// อัพเดทสถานะการประเมิน
$sql_update_arrange= "UPDATE tbl_arrange SET arrange_check_eval = '1', arrange_check_date_eval = '$arrange_check_date_eval' WHERE tbl_arrange.arrange_id = $arrange_id ";
$conn->query($sql_update_arrange); 
                        






////หากมี ฟอร์มอืนๆส่งค่ามา ให้บันทึกข้อมูล  ฟอร์ม  ที่เกี่ยวข้อง	/////////////////////////////////////////////////////////////////////////
if(isset($_POST['form_more_id']) && !empty($_POST['form_more_id'])){ 

	$form_more_id =  $_POST['form_more_id'];
	    // ดึงฟอร์มอื่นๆ ที่เกี่ยวข้อง		   
		$sql_form_more   =  " SELECT fm.*  ";
		$sql_form_more  .=  " FROM (SELECT f.*   FROM tbl_form_more AS f WHERE f.form_more_status = 'Y' and f.form_more_id = '$form_more_id') AS fm ";
		$query_form_more = $conn->query($sql_form_more); 
		$row_form_more = $query_form_more->fetch_assoc();
		$tbl_more=$row_form_more['form_more_table'];
		$field_id_more = $tbl_more."_id";
	
		


	////Update
	if(isset($_POST['field_id_more']) && !empty($_POST['field_id_more'])){  // if  เงื่อนไข หาก  field_id ที่ ส่งมา มีค่า หรือ ไม่เท่ากับ ว่าง แสดงว่า เป้นการบันทึกข้อมูลเพื่อแก้ไข

		$field_id_up = $_POST['field_id_more'];

		$sql_up_more= "UPDATE  tbl_$tbl_more SET  ";

				//ดึงชื่อตาราง ชื่อฟิลด
				$sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
				$query_form_detail_more = $conn->query($sql_form_detail_more); 
				while($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

				$field_more_up = $tbl_more."_".$row_form_detail_more['form_detail_more_field'];

				if(isset($_POST["{$field_more_up}"])){ $more_field = json_encode($_POST["{$field_more_up}"]); }else{ $more_field = json_encode([]);  }

				$sql_up_more.=  $field_more_up." = '{$more_field}', ";

				}

				$sql_up_more.= "  last_date = '{$last_date}' where $field_id_more = $field_id_up ";
			//echo	$sql_up_more;
				$conn->query($sql_up_more); 
		


				



	}else{


		$sql_in_more= "INSERT INTO tbl_$tbl_more ( $field_id_more , detail_id, ";
	
				$sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
				$query_form_detail_more = $conn->query($sql_form_detail_more); 
				while($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

					$more_field = $tbl_more."_".$row_form_detail_more['form_detail_more_field'];

					
					$sql_in_more.=  $more_field.", ";
					


				}

	
		$sql_in_more.= " last_date ) VALUES (NULL, '{$detail_id}' , ";


	
		$sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
		$query_form_detail_more = $conn->query($sql_form_detail_more); 
		while($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

			$more_field = $tbl_more."_".$row_form_detail_more['form_detail_more_field'];

		if(isset($_POST["{$more_field}"])){ $more_field = json_encode($_POST["{$more_field}"]); }else{ $more_field = json_encode([]);  }
    
			$sql_in_more.=  " '{$more_field}' , ";


		}




		$sql_in_more.= "  '{$last_date}' )";
		//echo $sql_in_more;
		$conn->query($sql_in_more); 




	}



}

//////////////////////////////////////////  ฟอร์ม  ที่เกี่ยวข้อง	/////////////////////////////////////////////////////////////////////////







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
/*if($row_form_detail['weight_type_id']!=""){   
	$field_weight = $field."_weight"; // ชื่อfield ในฐานข้อมูล
	$weight = " $field_weight = '{$_POST[$field_weight]}', ";
}else{  
	$weight = ""; 
}		
*/


$field_weight = $field . "_weight"; // ชื่อfield ในฐานข้อมูล
$weight = " $field_weight = '{$_POST[$field_weight]}', ";


/*
// field extra
if($row_form_detail['form_detail_extra']=="Y"){  
	$field_extra = $field."_extra"; // ชื่อfield ในฐานข้อมูล
	$extra = " $field_extra = '{$_POST[$field_extra]}', ";
}else{  
	$extra = ""; 
}	
*/

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
				
					$date_time = $_POST["$field_date"]." ".date('H:i:s');
					$sql.=  " $field_date = '{$date_time}', ";
					$sql.= $competency;
					$sql.= $complete;
			}

}

$field_comment = $table."_comment";   
$last_date = $_POST['last_date']; //last_date
$comment = $_POST['comment']; // comment




//if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){ //เช็คสาขา UPDATE

	//last_time
	$last_time = 'LAB';   
	$sql .= " $field_comment = '{$comment}',  last_date = '{$last_date}', last_time = '{$last_time}'  where $field_id = $field_id_up ";

//}else{

//	$sql .= " $field_comment = '{$comment}',  last_date = '{$last_date}' where $field_id = $field_id_up ";

//}



//echo $sql;
$conn->query($sql); 


}else{ 


	$sql = "INSERT INTO tbl_$table ( $field_id , detail_id, ";

	//ดึงชื่อตาราง ชื่อฟิลด
	$sql_form_detail   =  " SELECT * FROM tbl_form_detail WHERE form_main_id = $form_main_id ORDER BY tbl_form_detail.form_detail_order ASC ";
	$query_form_detail = $conn->query($sql_form_detail);
	while ($row_form_detail = $query_form_detail->fetch_assoc()) {
		$field = $row_form_main['form_main_table'] . "_" . $row_form_detail['form_detail_field'];

		// field น้ำหนักมีค่า
		//if ($row_form_detail['weight_type_id'] != 1) {
			$field_weight = $field . "_weight, ";
		//} else {
		//	$field_weight = "";
		//}

		if ($row_form_detail['form_detail_extra'] == "Y") {
		//	$field_extra = $field . "_extra, ";
		} else {
		//	$field_extra = "";
		}
		if ($row_form_detail['form_detail_competency'] == "Y") {
			$field_competency = $field . "_competency, ";
		} else {
			$field_competency = "";
		}
		if ($row_form_detail['form_detail_complete'] == "Y") {
			$field_complete = $field . "_complete, ";
		} else {
			$field_complete = "";
		}

		$sql .= $field_weight;
		//$sql .= $field_extra;
		$sql .= $field_grade = " $field" . "_grade, ";
		$sql .= $field_teacher = " $field" . "_teacher, ";
		$sql .= $field_date = " $field" . "_date, ";
		$sql .= $field_competency;
		$sql .= $field_complete;
	}

	$table = $row_form_main['form_main_table'];

	
	    //if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){//เช็คสาขา UPDATE

		$sql .= " $table" . "_comment,  last_date, last_time, $table" . "_log ) VALUES (NULL, '{$detail_id}' , ";


				
				
				
		$grades_log = "";
		//ดึงชื่อตาราง ชื่อฟิลด
		$sql_form_detail  =  " SELECT * FROM tbl_form_detail WHERE form_main_id = $form_main_id ORDER BY tbl_form_detail.form_detail_order ASC ";
		$query_form_detail = $conn->query($sql_form_detail);
		while ($row_form_detail = $query_form_detail->fetch_assoc()) {
	
			$field = $row_form_main['form_main_table'] . "_" . $row_form_detail['form_detail_field'];
			//$field=$row_form_detail['form_detail_field'];
	
			$field_grade = $field . "_grade";
			$field_teacher = $field . "_teacher";
			$field_date = $field . "_date";
	
	
			echo "<br>";
	
			if (isset($_POST[$field_grade]) && !empty($_POST[$field_grade])) {


	
					//if ($row_form_detail['weight_type_id'] != "") {
						$field_weight = $field . "_weight";
						$weight = " '{$_POST[$field_weight]}', ";
					//} else {
					//	$weight = "";
					//}
					if ($row_form_detail['form_detail_extra'] == "Y") {
						//$field_extra = $field . "_extra";
						//$extra = "'{$_POST[$field_extra]}', ";
					} else {
						//$extra = "";
					}
					if ($row_form_detail['form_detail_competency'] == "Y") {
						$field_competency = $field . "_competency";
						$competency = "'{$_POST[$field_competency]}', ";
					} else {
						$competency = "";
					}
					if ($row_form_detail['form_detail_complete'] == "Y") {
						$field_complete = $field . "_complete";
						$complete = "'{$_POST[$field_complete]}', ";
					} else {
						$complete = "";
					}

		
		
					$date_time = $_POST[$field_date] . " " . date('H:i:s');

			$sql .= $weight;
		//	$sql .= $extra;
			$sql .= $grade = " '{$_POST[$field_grade]}', ";
			$sql .= $teacher = " '{$_POST[$field_teacher]}', ";
			$sql .= $date = " '$date_time', ";

			//$last_time = $_POST['arrange_time_type']; //   , last_time = '{$last_time}'
			//$sql .= $last_time = " '$last_time', ";
			$sql .= $competency;
			$sql .= $complete;


		} else { //if


			if ($row_form_detail['weight_type_id'] != "") {
				$field_weight = $field . "_weight";
				$weight = "'', ";
			} else {
				$weight = "";
			}
			if ($row_form_detail['form_detail_extra'] == "Y") {
				//$field_extra = $field . "_extra";
				//$extra = "'', ";
			} else {
				$extra = "";
			}
			if ($row_form_detail['form_detail_competency'] == "Y") {
				$field_competency = $field . "_competency";
				$competency = "'', ";
			} else {
				$competency = "";
			}
			if ($row_form_detail['form_detail_complete'] == "Y") {
				$field_complete = $field . "_complete";
				$complete = "'', ";
			} else {
				$complete = "";
			}

			$sql .= $weight;
			//$sql .= $extra;
			$sql .= " '', ";
			$sql .= " '', ";
			$sql .= " '', ";
			$sql .= $competency;
			$sql .= $complete;
		} //else

	} // while




	if ($arrange_type == 0) {
		$date_time_now = date('Y-m-d');
		$field_date_s = $_POST['$field_date'];
		if ($field_date_s == $date_time_now) {
			$ss = "normal";
		} else {
			$ss = "back";
		}
		$ss = "Normal";
		$type_ss = "Clinic";
	} else {
		$ss = "Normal";
		$type_ss = "LAB";
	}
	$date_time_now = date('Y-m-d H:i:s');
	$log .= "$date_time_now|$date_time|$ss|$type_ss,/";


     

    //if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){ //เช็คสาขา UPDATE

		$last_time = 'LAB';
		$last_time = $_POST['arrange_time_type'];   

		//$sql .= " '{$comment}', '{$last_date}', '{$last_time}', '{$log}')";
		$sql .= " '{$comment}', '{$last_date}', '{$last_time}', '{$log}')";

	//}else{

	//	$sql .= " '{$comment}', '{$last_date}', '{$log}')";

	//}

 
	  // echo $sql;
	     
	   $conn->query($sql); 

} // else if  เงื่อนไข หาก  field_id ที่ ส่งมา มีค่า หรือ ไม่เท่ากับ ว่าง แสดงว่า เป้นการบันทึกข้อมูลเพื่อแก้ไข

////ดึงชื่อตารางหลักลงฐานข้อมูล หลัก--------------------

//////////////////////////////////////////  ฟอร์ม หลัก	/////////////////////////////////////////////////////////////////////////










//////////////////////////////////////////  คำนวนคะแนน 	/////////////////////////////////////////////////////////////////////////
echo "<br>";

// ดึงชื่อตาราง
$sql_tabel   = " SELECT * FROM tbl_form_main  WHERE form_main_id = '$form_main_id' ";
$query_tabel = $conn->query($sql_tabel);
$row_tabel   = $query_tabel->fetch_assoc();

$tbl = $row_tabel['form_main_table']; // ชื่อตาราง
$tbl_id = $tbl . "_id"; // Id ของตาราง


if ($type_work_id == 1) { // สาขา X-ray ดึง จำนวนฟิมล์มาแสดงด้วย  
	include "summary_xray.php";
}

if ($type_work_id == 2) { // สาขา pedo ดึง คะแนนทั่วไป
	include "summary_pedo.php";
}

if ($type_work_id == 3) { // สาขา Ortho ดึง คะแนนทั่วไป
	include "summary_ortho.php";
}

if ($type_work_id == 4) { // สาขา oper ดึง คะแนนทั่วไป
	include "summary_oper.php";
}

if ($type_work_id == 5) { // สาขา endo ดึง คะแนนทั่วไป
	include "summary_endo.php";
}

if ($type_work_id == 6) { // สาขา Crown and Bridge ดึง คะแนนทั่วไป
	include "summary_cb.php";
}

if ($type_work_id == 7) { // สาขา perio ดึง คะแนนทั่วไป
	include "summary_perio.php";
}

if ($type_work_id == 8) { // สาขา Prosthodontics ดึง คะแนนทั่วไป
	include "summary_prosth.php";
}

if ($type_work_id == 9) { // สาขา os ดึง คะแนนทั่วไป
	include "summary_os.php";
}

if ($type_work_id == 10) { // สาขา od ดึงคะแนนครั้งล่าสุดมาคำนวน
	include "summary_od.php";
}

if ($type_work_id == 11) { // สาขา prevent ดึง คะแนนทั่วไป
	include "summary_prevent.php";
}
 
if ($type_work_id == 12) { // สาขา opd ดึง คะแนนทั่วไป
	include "summary_opd.php";
}


$detail_date_last = $last_date;
$detail_score = $total_score;
$detail_weight = $total_weight;
$detail_total = $sum_sw;

// อัพเดทสถานะ Complete และ คะแนน
$sql_update_complete = " UPDATE tbl_detail SET detail_complete = '$detail_complete', detail_date_complete = '$detail_date_complete' ,causes_of_pay_id = '$causes_of_pay_id', detail_competency = '$detail_competency' , detail_by_teacher = '$detail_by_teacher' ";
$sql_update_complete .= " ,detail_score = '$detail_score' ";
$sql_update_complete .= " ,detail_weight = '$detail_weight' ";
$sql_update_complete .= " ,detail_total = '$detail_total' ";
$sql_update_complete .= " ,detail_date_last = '$detail_date_last' ";
$sql_update_complete .= "  WHERE detail_id = $detail_id ";
$conn->query($sql_update_complete);








echo "<script type='text/javascript'>";
//echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
echo "window.location='evaluate_lab.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$last_date&arrange_id=$arrange_id&id_form=$id_form&do=success'";
echo "</script>";

?>