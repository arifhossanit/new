<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['go_back'])){
	unset($_SESSION['set_employee_id']);
}
if(isset($_POST['otp_id'])){
	unset($_SESSION['set_employee_id']);
	$get_otp = rahat_decode(rahat_decode($_POST['otp_id']));
	$check_employee = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$get_otp."' and status = '1'"));
	if(!empty($check_employee['employee_id'])){
		unset($_SESSION['set_employee_id']);
		$otp = 'i-'.rand(1111,9999);
		$otp = strval($otp);
		$number = $check_employee['personal_Phone'];
		$message = 'Neways Login Credential(OTP): '.$otp.'';
		if(sendsms($number,$message)){
			$user_otp = array(
				'employee_id' => rahat_encode($check_employee['employee_id']),
				'employee_opt' => rahat_encode($otp),
				'employee_photo' => rahat_encode($check_employee['photo'])
			);
			$_SESSION['set_employee_id'] = $user_otp;
			echo 'Login OTP sended successfully';
		}else{
			echo 'Something Wrong to send OTP! Please Try again';
		}
	}else{
		echo 'Your Employee ID not found! Please contact with HR Department';
	}
}
?>