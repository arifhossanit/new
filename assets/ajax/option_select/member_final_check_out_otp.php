<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['number'])){
	$phone_number = $_POST['number'];
	if(!empty($phone_number)){
		if((int)strlen($phone_number) == '11'){
			$otp = rand(1111,9999);
			$number = $phone_number;
			$message = 'Super Home One Time Password (OTP) Refund: '.$otp.'';
			if(otp_sendsms($number,$message)){
				echo '1_____<span style="font-size: 15px;"><span style="color:green;">OTP SEND Successfully to "<b style="color:#f00;">'.$number.'</b>" </span><a onclick="return resend_otp()" href="#">Resend OTP?</a></span>_____'.$otp;
			}else{
				echo '0_____<span><span style="color:red;">OTP NOT SEND</span><a onclick="return resend_otp()" href="#">Resend OTP?</a></span>_____0';
			}
		}
	}
} 
?>