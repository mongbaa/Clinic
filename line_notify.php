<?php
include "header.php";
include "_class_token.php";
?>



<!-- SweetAlert2 -->
<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">



<?php

echo "<script type='text/javascript'>";
echo "swal('Good job!', 'You clicked the button!', 'success')";
echo "</script>";

//echo '<meta http-equiv="refresh" content="1;url=line_notify.php" />';
?>

<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

<section class="content">
    <div class="container-fluid">
<?php

$notification_date = date('Y-m-d'); // to day
$notification_time = date('H:i:s'); // to day


include "config.inc.php";
//check arrange_check_eval = 1 to day
echo $sql_arrange = "SELECT * FROM tbl_arrange where  date(arrange_check_date_eval) =  '$notification_date' ";
$query_arrange = $conn->query($sql_arrange); 
while($row_arrange = $query_arrange->fetch_assoc()) {

	echo "<br>";

	$arrange_id = $row_arrange['arrange_id'];
	$detail_id = $row_arrange['detail_id'];
	$student_id = nameDetail_order::get_detail_order_name($detail_id);
	$teacher_id = $row_arrange['teacher_id'];
	$arrange_check_date_eval = $row_arrange['arrange_check_date_eval'];



	echo $sql_notification = "SELECT * FROM tbl_notification where arrange_id = $arrange_id ";
		$query_notification = $conn->query($sql_notification); 
		if($row_notification = $query_notification->fetch_assoc()) {


			echo "YYYYYYYYYY";
			echo $row_notification['student_id'];
			echo "---->";
			echo $row_notification['notification_message'];

		//	echo nameToken::get_token_line($student_id);

		}else{

			echo "NNNNNNNNN";

			$detail = nameDetail::get_detail_name($detail_id);
			$teacher = nameTeacher::get_teacher_name($teacher_id);
	  	  	$sMessages = ": E-Clinic\nรหัสงาน: $detail_id\n$detail\n$teacher\n$arrange_check_date_eval\nประเมินคะแนนเรียบร้อย";

			
			
			$sql= "INSERT INTO tbl_notification (notification_id, arrange_id, student_id, notification_message, notification_date, notification_time) VALUES (NULL, '$arrange_id', '$student_id', '$sMessages', '$notification_date', '$notification_time');";
			$conn->query($sql);

			
			//echo nameToken::get_token_line($student_id);
			$token_line_user = nameToken::get_token_line($student_id);
			//$token_line_user = "1z6GQgU7H8j3ZA1xVcCxpJj9N43oCZvqa9RROehQFwE";
			//$token_line_user = "";
			if($token_line_user!=""){
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);

				date_default_timezone_set("Asia/Bangkok");
				
				$sToken =$token_line_user;
				$sMessage = $sMessages;
				
				$chOne = curl_init(); 
				curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
				curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
				curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
				curl_setopt( $chOne, CURLOPT_POST, 1); 
				curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
				$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
				curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
				curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
				$result = curl_exec( $chOne ); 

				//Result error 
				if(curl_error($chOne)) 
				{ 
					echo 'error:' . curl_error($chOne); 
				} 
				else { 
					$result_ = json_decode($result, true); 
				//	echo "status : ".$result_['status']; echo "message : ". $result_['message'];
				} 
				curl_close( $chOne );   

			}//if



		}


}


/*
//check arrange_check_eval = 1 to day
echo $sql_arrange = "SELECT * FROM tbl_arrange where  arrange_check_eval = 1  and arrange_date = '2021-11-29' ";
$query_arrange = $conn->query($sql_arrange); 
while($row_arrange = $query_arrange->fetch_assoc()) {

 	$arrange_id = $row_arrange['arrange_id'];
	$detail_id = $row_arrange['detail_id'];
	$student_id = nameDetail_order::get_detail_order_name($detail_id);
	$teacher_id = $row_arrange['teacher_id'];
	$arrange_check_date_eval = $row_arrange['arrange_check_date_eval'];



		echo "<br>";
		echo $sql_notification = "SELECT * FROM tbl_notification where arrange_id = $arrange_id ";
		$query_notification = $conn->query($sql_notification); 
		if($row_notification = $query_notification->fetch_assoc()) {
			echo "YYYYYYYYYY";
			echo $detail_id;
			echo "-->";
			echo $student_id;
			echo "-->";
			//echo nameToken::get_token_line($student_id);
			echo $row_notification['notification_message'];



		}else{

		
		$notification_message =   "การประเมิน ID_DETAIL: ";
		$notification_message .=  $detail_id;
		$notification_message .=  " --> ID_STUDENT: ";
		$notification_message .=  $student_id;
		$notification_message .=  " --> DETAIL: ";
		$notification_message .=  $detail = nameDetail::get_detail_name($detail_id);
		$notification_message .=  " --> Teacher: ";
		$notification_message .=  $teacher = nameTeacher::get_teacher_name($teacher_id);
		$notification_message .=  " --> Date_time: ";
		$notification_message .=  $arrange_check_date_eval;

		
		$sMessages = "\nการประเมินรหัส: $detail_id\n$detail\nTeacher: $teacher\nDate_time: $arrange_check_date_eval";
		
	

			
		$sql= "INSERT INTO tbl_notification (notification_id, arrange_id, student_id, notification_message, notification_date, notification_time) VALUES (NULL, '$arrange_id', '$student_id', '$sMessages', '$notification_date', '$notification_time');";
		$conn->query($sql); 
		
		echo "NNNNNNNNN";
		echo "-->";
		echo $sMessage = $sMessages;
				
			   // $token_line_user = "1z6GQgU7H8j3ZA1xVcCxpJj9N43oCZvqa9RROehQFwE";
			        $token_line_user = "";
					if($token_line_user!=""){
						ini_set('display_errors', 1);
						ini_set('display_startup_errors', 1);
						error_reporting(E_ALL);

						date_default_timezone_set("Asia/Bangkok");
						
						$sToken =$token_line_user;
						$sMessage = $sMessages;
						
						$chOne = curl_init(); 
						curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
						curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
						curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
						curl_setopt( $chOne, CURLOPT_POST, 1); 
						curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
						$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
						curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
						curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
						$result = curl_exec( $chOne ); 

						//Result error 
						if(curl_error($chOne)) 
						{ 
							echo 'error:' . curl_error($chOne); 
						} 
						else { 
							$result_ = json_decode($result, true); 
						//	echo "status : ".$result_['status']; echo "message : ". $result_['message'];
						} 
						curl_close( $chOne );   

					}//if

		}




	


}
	
    
	

		
		
		

*/
	

?>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
		})
</script>