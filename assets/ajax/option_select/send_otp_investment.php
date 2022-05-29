<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['otp_phn'])){
	$phone_number = $_POST['otp_phn'];
	if(!empty($phone_number)){
		if((int)strlen($phone_number) == '11'){
			$otp = rand(1111,9999);
			$number = $phone_number;
			$message = 'Super Home Investor Credential: '.$otp.'';
			if(otp_sendsms($number,$message)){
				$_SESSION['investor_otp_number'] = $otp;
                $info = array(
                    'status' => '1',
                    'html' => '<div class="row"><span style="font-size: 15px;"><span style="color:green;">OTP SEND Successfully to "<b style="color:#f00;">'.$number.'</b>" </span><a onclick="return get_investment_otp()" href="#">Resend OTP?</a></span></div><div class="row"><input id="sent_otp" type="hidden" value="'.$otp.'"><div class="col-md-8"><input class="form-control" id="confirm_otp" placeholder="Enter OTP"></div><div class="col-md-4"><button type="button" class="ml-1 btn btn-primary" id="go_to_save" onclick="go_to_save_js()">Submit</button></div></div>',
                    'otp' => $otp,
                );
				echo json_encode($info);
			}else{
                $_SESSION['investor_otp_number'] = $otp;
                $info = array(
                    'status' => '0',
                    'html' => '<span><span style="color:red;">OTP NOT SEND</span><a onclick="return resend_otp()" href="#">Resend OTP?</a></span>',
                    'otp' => 'NaN',
                );
				echo json_encode($info);
			}
		}
	}
} 
// echo $_POST['otp_phn'];
?>