<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){
	$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$_POST['employee_id']."'"));
	$number = $emp_info['personal_Phone'];
	$petty_cash_transaction_id = mysqli_fetch_assoc($mysqli->query("SELECT transaction_id from advance_petty_cash_logs where id = '".$_POST['db_id']."' AND status = '1'"));
	$message = 'Advance Request Money is Accepted. Click the link to received balance, '.$home.'sms.employee.accept.money/'.rahat_encode(rahat_encode($emp_info['employee_id'])).'/'.rahat_encode($petty_cash_transaction_id['transaction_id']).'';
	if(!empty($number)){
		if(sendsms($number,$message)){
			echo 'OTP Resend Successfully!';
		}else{
			echo 'Something wrong in sms section! Please try again';
		}
	}else{
		echo 'Sorry! Employee phone number Not Found!';
	}	
}
?>