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
$teacher_id = $_POST['teacher_id']; //arrange_time_type
$arrange_time_type = $_POST['arrange_time_type']; //arrange_time_type


$detail_by_teacher = $teacher_id;

if (!empty($_POST['Complete'])) {
	$detail_date_complete = $last_date;
	$detail_complete = 1;
	$causes_of_pay_id = 7;
} else {
	$detail_date_complete = "0000-00-00";
	$detail_complete = 0;
	$causes_of_pay_id = 0;
}


if (!empty($_POST['competency'])) {
	$detail_competency = 1;
} else {
	$detail_competency = 0;
}



$arrange_check_date_eval = date('Y-m-d H:i:s');

// อัพเดทสถานะการประเมิน
$sql_update_arrange = "UPDATE db_clinic.tbl_arrange SET arrange_check_eval = '1', arrange_check_date_eval = '$arrange_check_date_eval' WHERE tbl_arrange.arrange_id = $arrange_id ";
$conn->query($sql_update_arrange);




////หากมี ฟอร์มอืนๆส่งค่ามา ให้บันทึกข้อมูล  ฟอร์ม  ที่เกี่ยวข้อง	/////////////////////////////////////////////////////////////////////////
if (isset($_POST['form_more_id']) && !empty($_POST['form_more_id'])) {

	$form_more_id =  $_POST['form_more_id'];
	// ดึงฟอร์มอื่นๆ ที่เกี่ยวข้อง		   
	$sql_form_more   =  " SELECT fm.*  ";
	$sql_form_more  .=  " FROM (SELECT f.*   FROM tbl_form_more AS f WHERE f.form_more_status = 'Y' and f.form_more_id = '$form_more_id') AS fm ";
	$query_form_more = $conn->query($sql_form_more);
	$row_form_more = $query_form_more->fetch_assoc();
	$tbl_more = $row_form_more['form_more_table'];
	$field_id_more = $tbl_more . "_id";



	////Update
	if (isset($_POST['field_id_more']) && !empty($_POST['field_id_more'])) {  // if  เงื่อนไข หาก  field_id ที่ ส่งมา มีค่า หรือ ไม่เท่ากับ ว่าง แสดงว่า เป้นการบันทึกข้อมูลเพื่อแก้ไข

		$field_id_up = $_POST['field_id_more'];

		$sql_up_more = "UPDATE  tbl_$tbl_more SET  ";

		//ดึงชื่อตาราง ชื่อฟิลด
		$sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
		$query_form_detail_more = $conn->query($sql_form_detail_more);
		while ($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

		      	$field_more_up = $tbl_more . "_" . $row_form_detail_more['form_detail_more_field'];
			// echo " --  ";
		

			if (!empty($_POST["$field_more_up"])) {
				 $more_field = json_encode($_POST["$field_more_up"], JSON_UNESCAPED_UNICODE);
			} else {
				 $more_field = json_encode([]);
			}

			
			//echo "<br>";


			$sql_up_more .=  $field_more_up . " = '{$more_field}', ";
		}



		 $sql_up_more .= "  last_date = '{$last_date}' where $field_id_more = $field_id_up ";
		//echo	$sql_up_more;
		$conn->query($sql_up_more);
	} else {


		$sql_in_more = "INSERT INTO tbl_$tbl_more ( $field_id_more , detail_id, ";

		$sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
		$query_form_detail_more = $conn->query($sql_form_detail_more);
		while ($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

			$more_field = $tbl_more . "_" . $row_form_detail_more['form_detail_more_field'];


			$sql_in_more .=  $more_field . ", ";
		}


		$sql_in_more .= " last_date ) VALUES (NULL, '{$detail_id}' , ";



		$sql_form_detail_more = "SELECT * FROM tbl_form_detail_more where tbl_form_detail_more.form_more_id=$form_more_id";
		$query_form_detail_more = $conn->query($sql_form_detail_more);
		while ($row_form_detail_more = $query_form_detail_more->fetch_assoc()) {

			$more_field = $tbl_more . "_" . $row_form_detail_more['form_detail_more_field'];



			if (!empty($_POST["{$more_field}"])) {
				$more_field = json_encode($_POST["{$more_field}"]);
			} else {
				$more_field = json_encode([]);
			}

			$sql_in_more .=  " '{$more_field}' , ";
		}




		echo $sql_in_more .= "  '{$last_date}' )";
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
$table = $row_form_main['form_main_table'];
//echo "<br>";
$field_id = $table . "_id";
//echo "<br>";
//echo $_POST['field_id'];


////Update
if (isset($_POST['field_id']) && !empty($_POST['field_id'])) {  // if  เงื่อนไข หาก  field_id ที่ ส่งมา มีค่า หรือ ไม่เท่ากับ ว่าง แสดงว่า เป้นการบันทึกข้อมูลเพื่อแก้ไข

	//echo "Update";
	//echo "<br>";

	$field_id_up = $_POST['field_id'];


	$sql = "UPDATE  tbl_$table SET  ";
	//ดึงชื่อตาราง ชื่อฟิลด
	$sql_form_detail   =  " SELECT * FROM tbl_form_detail WHERE form_main_id = $form_main_id ORDER BY tbl_form_detail.form_detail_order ASC ";
	$query_form_detail = $conn->query($sql_form_detail);
	while ($row_form_detail = $query_form_detail->fetch_assoc()) {
		$field = $row_form_main['form_main_table'] . "_" . $row_form_detail['form_detail_field'];


		// field น้ำหนักมีค่า
		//if ($row_form_detail['weight_type_id'] != "") {
			$field_weight = $field . "_weight"; // ชื่อfield ในฐานข้อมูล
			$weight = " $field_weight = '{$_POST[$field_weight]}', ";
		//} else {
		//	$weight = "";
		//}

		// field extra
		/*if ($row_form_detail['form_detail_extra'] == "Y") {
			$field_extra = $field . "_extra"; // ชื่อfield ในฐานข้อมูล
			$extra = " $field_extra = '{$_POST[$field_extra]}', ";
		} else {
			$extra = "";
		}*/

		// field competency
		if ($row_form_detail['form_detail_competency'] == "Y") {
			$field_competency = $field . "_competency"; // ชื่อfield ในฐานข้อมูล
			$competency = " $field_competency = '{$_POST[$field_competency]}', ";
		} else {
			$competency = "";
		}


		// field complete
		if ($row_form_detail['form_detail_complete'] == "Y") {
			$field_complete = $field . "_complete"; // ชื่อfield ในฐานข้อมูล
			$complete = " $field_complete = '{$_POST[$field_complete]}', ";
		} else {
			$complete = "";
		}



		$field_grade = $field . "_grade";
		$field_grades = $field . "_grades";
		$field_teacher = $field . "_teacher";
		$field_teachers = $field . "_teachers";
		$field_date = $field . "_date";

		//echo $_POST[$field_grade];
		//echo $_POST[$field_grades];


		//echo "<br>";


		if (isset($_POST[$field_grade]) && !empty($_POST[$field_grade])) {
			$sql .= $weight;
			//$sql .= $extra;
			$sql .=  " $field_grade = '{$_POST[$field_grade]}', ";

			if ($_POST[$field_grade] != $_POST[$field_grades]) {  // เปลี่ยนชื่ออาจารย์หากมีการแก้ไขคะแนน

				$sql .=  " $field_teacher = '{$_POST[$field_teachers]}', ";
			} else {
				$sql .=  " $field_teacher = '{$_POST[$field_teacher]}', ";
			}

			$date_time = $_POST["$field_date"] . " " . date('H:i:s');
			$sql .=  " $field_date = '{$date_time}', ";
			$sql .= $competency;
			$sql .= $complete;
		}
	}

	
	$field_comment = $table . "_comment";
	
	$last_date = $_POST['last_date']; //last_date

	$comment = $_POST['comment']; // comment


	//if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){ //เช็คสาขา UPDATE

		//last_time
	    $last_time = $_POST['arrange_time_type'];   
		$sql .= " $field_comment = '{$comment}',  last_date = '{$last_date}', last_time = '{$last_time}'  where $field_id = $field_id_up ";

	//}else{

	//	$sql .= " $field_comment = '{$comment}',  last_date = '{$last_date}' where $field_id = $field_id_up ";


	//}

	
	//echo $sql;
	$conn->query($sql);



} else {






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

	//}else{

	//	$sql .= " $table" . "_comment,  last_date, $table" . "_log ) VALUES (NULL, '{$detail_id}' , ";

	//}
	


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


    //'{$last_time}', 

	

	//if($type_work_id == 1 || $type_work_id == 4 || $type_work_id == 7 || $type_work_id == 9 || $type_work_id == 10 || $type_work_id == 11 ){//เช็คสาขา UPDATE

		
		$last_time = $_POST['arrange_time_type'];   

		$sql .= " '{$comment}', '{$last_date}', '{$last_time}', '{$log}')";

	//}else{

//		$sql .= " '{$comment}', '{$last_date}', '{$log}')";

//	}

	//echo $sql;
	$conn->query($sql);
} // else if  เงื่อนไข หาก  field_id ที่ ส่งมา มีค่า หรือ ไม่เท่ากับ ว่าง แสดงว่า เป้นการบันทึกข้อมูลเพื่อแก้ไข

////ดึงชื่อตารางหลักลงฐานข้อมูล หลัก--------------------

//////////////////////////////////////////  ฟอร์ม หลัก	/////////////////////////////////////////////////////////////////////////










//////////////////////////////////////////  ฟอร์ม  holistic 	/////////////////////////////////////////////////////////////////////////


include "config.inc.php";
$holistic_date = $last_date;
$holistic_time = date('H:i:s');
$holistic_time_type = $arrange_time_type;

//////////////////////////////////////////  UPDATE 
if (isset($_POST['holistic_id']) && !empty($_POST['holistic_id'])) {

	$holistic_id = $_POST['holistic_id'];

	$sql_up_holistic = "UPDATE tbl_holistic SET  ";

	$sql_holistic = "SELECT * FROM tbl_form_holistic ORDER BY tbl_form_holistic.form_holistic_order ASC";
	$query_holistic = $conn->query($sql_holistic);
	while ($row_holistic = $query_holistic->fetch_assoc()) {

		$holisticfield = $row_holistic['form_holistic_field'];
		$holistic_field = "ho" . $row_holistic['form_holistic_field'];
		$value_ho = $_POST["{$holistic_field}"];

		$holistic_note = $row_holistic['form_holistic_field'] . "_note";
		$value_note = $_POST["{$holistic_note}"];

		$sql_up_holistic .= " $holisticfield = '$value_ho', $holistic_note = '$value_note', ";
	}
	$sql_up_holistic = substr("$sql_up_holistic", 0, -2); // ตัด , ตัวสุดท้ายออก
	$sql_up_holistic .= " WHERE holistic_id = $holistic_id";
	$conn->query($sql_up_holistic);
} else {
	//////////////////////////////////////////  INSERT 
	$sql_in_holistic = "INSERT INTO tbl_holistic ( holistic_id , type_work_id, teacher_id, student_id, holistic_date,  holistic_time, holistic_time_type, detail_id,  ";

	$sql_holistic = "SELECT * FROM tbl_form_holistic ORDER BY tbl_form_holistic.form_holistic_order ASC";
	$query_holistic = $conn->query($sql_holistic);
	while ($row_holistic = $query_holistic->fetch_assoc()) {
		$holistic_field = $row_holistic['form_holistic_field'];
		$holistic_note = $row_holistic['form_holistic_field'] . "_note";

		$sql_in_holistic .=  $holistic_field . ", " . $holistic_note . ", ";
	}

	$sql_in_holistic = substr("$sql_in_holistic", 0, -2); // ตัด , ตัวสุดท้ายออก
	$sql_in_holistic .= " ) VALUES (NULL, '$type_work_id', '$teacher_id', '$student_id', '$holistic_date', '$holistic_time', '$holistic_time_type', '$detail_id',  ";



	$query_holistic = $conn->query($sql_holistic);
	while ($row_holistic = $query_holistic->fetch_assoc()) {
		$holistic_field = "ho" . $row_holistic['form_holistic_field'];
		$value_ho = $_POST["{$holistic_field}"];

		$holistic_note = $row_holistic['form_holistic_field'] . "_note";
		$value_note = $_POST["{$holistic_note}"];

		$sql_in_holistic .=  " '{$value_ho}', '{$value_note}', ";
	}
	$sql_in_holistic = substr("$sql_in_holistic", 0, -2); // ตัด , ตัวสุดท้ายออก
	$sql_in_holistic .= "  )";
	$conn->query($sql_in_holistic);
}
//////////////////////////////////////////  ฟอร์ม  holistic 	/////////////////////////////////////////////////////////////////////////








//////////////////////////////////////////   ข้อมูล Conduct & Knowledge สาขาวิชา 	/////////////////////////////////////////////////////////////////////////
if (isset($_POST['ck'])) {
	include "config.inc.php";

	foreach ($_POST as $key => $value) {
		$_POST[$key] = $conn->real_escape_string($value);
	}


	$ck_date = $last_date;
	$ck_time = date('H:i:s');
	$ck_time_type = $arrange_time_type;


	$teacher_id = $teacher_id;
	$student_id = $student_id;
	$type_work_id = $type_work_id;
	$detail_id = $detail_id;



	//////////////////////////////////////////  UPDATE 
	if (isset($_POST['ck_id']) && !empty($_POST['ck_id'])) {

    $ck_id = $_POST['ck_id'];

	$row_ck_id =  "ck_".$type_work_id."_id";
   


		$sql_up_ck = "UPDATE tbl_ck_$type_work_id SET  ";

			$sql_ck   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
			$sql_ck  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
			$sql_ck  .=  " ORDER BY c.form_conduct_knowledge_order ASC ";
			$query_ck = $conn->query($sql_ck);
			while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {

		    $field = $row_conduct_knowledge['form_conduct_knowledge_field'];
			$field_  = $_POST["{$field}"];
				$sql_up_ck .= " $field = '$field_', ";
			}

		$sql_up_ck = substr("$sql_up_ck", 0, -2); // ตัด , ตัวสุดท้ายออก
		$sql_up_ck .= " WHERE $row_ck_id = $ck_id";
		$conn->query($sql_up_ck);



	} else {

		$sql_in_ck = "INSERT INTO tbl_ck_$type_work_id( ck_" . $type_work_id . "_id , teacher_id, student_id, detail_id, ck_date, ck_time, ck_time_type, ";
		
		$sql_ck   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
		$sql_ck  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
		$sql_ck  .=  " ORDER BY c.form_conduct_knowledge_id ASC ";
		$query_ck = $conn->query($sql_ck);
		$sql_in_ck1 = "";
		while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {
			
			$field = $row_conduct_knowledge['form_conduct_knowledge_field'];

			// $field_  = $_POST["{$field}"];
			$sql_in_ck1 .=  $field . ", ";
		}
		$sql_in_ck2  = substr($sql_in_ck1, 0, -2); //ตัด , ตัวสุดท้ายออก

		$sql_in_ck .= $sql_in_ck2 . ") VALUES (NULL, '{$teacher_id}' , '{$student_id}' ,'{$detail_id}' ,'{$ck_date}' ,'{$ck_time}' ,'{$ck_time_type}' ,";
		$query_ck = $conn->query($sql_ck);
		$sql_in_ck3 = "";
		while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {

			$field = $row_conduct_knowledge['form_conduct_knowledge_field'];
			$field_  = $_POST["{$field}"];
			$sql_in_ck3 .=  " '{$field_}' , ";
		}
		$sql_in_ck4  = substr($sql_in_ck3, 0, -2); //ตัด , ตัวสุดท้ายออก
		$sql_in_ck .= $sql_in_ck4 . " )";

		//echo  $sql_in_ck .= " ";
		$conn->query($sql_in_ck);

	}


}
//////////////////////////////////////////   ข้อมูล Conduct & Knowledge สาขาวิชา 	/////////////////////////////////////////////////////////////////////////











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




//echo "<META http-equiv=refresh content=3;url=evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$last_date&arrange_id=$arrange_id&id_form=$id_form>";


//if($type_work_id == 7){ 

	//echo "<script type='text/javascript'>";
	//echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
	//echo "window.location='evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$last_date&arrange_id=$arrange_id&id_form=$id_form&do=success'";
	//echo "</script>";


//}else{


	echo "<script type='text/javascript'>";
	//echo  "alert('สร้างฟอร์มหลักสำเร็จ');";
	echo "window.location='evaluate.php?detail_id=$detail_id&plan_id=$plan_id&arrange_date=$last_date&arrange_id=$arrange_id&id_form=$id_form&do=success'";
	echo "</script>";

//}



?>

<p class="card-text">กรุณารอสักครู่....!! <img src="images/01-progress.gif" width="120" height="100" /></p>