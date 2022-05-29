<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['otp_phn'])){
	$phone_number = $_POST['otp_phn'];
	if(!empty($phone_number)){
		if((int)strlen($phone_number) == '11'){
			$otp = rand(1111,9999);
			$otp = strval($otp);
			$number = $phone_number;
			$message = 'Super Home Booking One Time Password(OTP): '.$otp.'';
			if(otp_sendsms($number,$message)){
				$_SESSION['booking_otp_number'] = $otp;
				echo '1_____<span style="font-size: 15px;"><span style="color:green;">OTP SEND Successfully to "<b style="color:#f00;">'.$number.'</b>" </span><a onclick="return resend_otp()" href="#">Resend OTP?</a></span>_____'.$otp;
			}else{
				echo '0_____<span><span style="color:red;">OTP NOT SEND</span><a onclick="return resend_otp()" href="#">Resend OTP?</a></span>_____0';
			}
		}
	}
} 


if(isset($_POST['otp_phn_demo_ipo'])){
	$phone_number = $_POST['otp_phn_demo_ipo'];
	if(!empty($phone_number)){
		if((int)strlen($phone_number) == '11'){
			$otp = rand(1111,9999);
			$number = $phone_number;
			$message = 'One Time Password(OTP): '.$otp.'';
			if(otp_sendsms($number,$message)){
				echo '1_____<span style="font-size: 15px;"><span style="color:green;">OTP SEND Successfully to "<b style="color:#f00;">'.$number.'</b>" </span><a onclick="return resend_otp()" href="#">Resend OTP?</a></span>_____'.$otp;
			}else{
				echo '0_____<span><span style="color:red;">OTP NOT SEND</span><a onclick="return resend_otp()" href="#">Resend OTP?</a></span>_____0';
			}
		}
	}
} 

if(isset($_POST['submit_ipo_demo_first_form'])){
	$ipo_id = date('d_m_Y__h_i_s_A').'_'.rand().'_'.rand() * time().'_'.md5(time());	
	$generated_password = spc_chr_mm_v2(6);
	$card_number = rand(11111,99999);	
	$demo_data = array(
		'ipo_id' => $ipo_id,
		'personal_full_name' => $_POST['full_name'],
		'personal_phone_number' => $_POST['demo_phonenumber'],
		'personal_email' => $_POST['demo_email'],
		'generated_password' => $generated_password,
		'card_number' => $card_number
	);
	$_SESSION['demo_ipo_first_form'] = $demo_data;
	if(!empty($_SESSION['demo_ipo_first_form']['personal_full_name'])){ 
		echo $_SESSION['demo_ipo_first_form']['personal_full_name'];
	}
}


if(isset($_POST['submit_ipo_demo_complete_form'])){
	if(!empty($_SESSION['demo_ipo_first_form'])){ 
		
		$ipo_member_information_sql = "insert into demo_ipo_member_directory values(
			'',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['ipo_id'])."',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['personal_full_name'])."',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['personal_phone_number'])."',
			'',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['personal_email'])."',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['generated_password'])."',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['card_number'])."',
			'',
			'',
			'1',
			'0',
			'0',
			'',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";
		$purses_code = md5(rand() * time());
		$mysqli->query("insert into demo_ipo_agreement_information values(
			'',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['ipo_id'])."',
			'".$mysqli->real_escape_string($purses_code)."',											
			'',
			'',											
			'',
			'',
			'',
			'',
			'',
			'',											
			'".$mysqli->real_escape_string($_POST['investor_type'])."',
			'".$mysqli->real_escape_string($_POST['widthdraw_type'])."',											
			'General Investment',
			'".$mysqli->real_escape_string($_POST['agreement_type'])."',											
			'".$mysqli->real_escape_string($_POST['amount'])."',											
			'1',
			'".$mysqli->real_escape_string($_POST['ipo_demo_commission'])."',
			'".$mysqli->real_escape_string($_POST['amount'])."',
			'".$mysqli->real_escape_string($_POST['tenor'])."',
			'',
			'',
			'1',
			'',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)");
		
		$ipo_purses_information = "insert into demo_ipo_purses_information values(
			'',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['ipo_id'])."',
			'".$mysqli->real_escape_string($purses_code)."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."',
			'".$mysqli->real_escape_string($_POST['amount'])."',
			'".$mysqli->real_escape_string($_POST['amount'])."',
			'',				
			'',
			'',
			'',
			'',
			'1',
			'',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";
		$ipo_member_balance_information = "insert into demo_ipo_member_balance values(
			'',
			'".$mysqli->real_escape_string($_SESSION['demo_ipo_first_form']['ipo_id'])."',
			'0',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";
		if(
			$mysqli->query($ipo_member_information_sql)
			AND
			$mysqli->query($ipo_purses_information)
			AND
			$mysqli->query($ipo_member_balance_information)
		){
			$number = $_SESSION['demo_ipo_first_form']['personal_phone_number'];
			$message = 'Dear, '.$_SESSION['demo_ipo_first_form']['personal_full_name'].', You have successfully registred as a Demo Investor of SUPER HOME. Your Login Information:: Username: '.$_SESSION['demo_ipo_first_form']['card_number'].' , Password: '.$_SESSION['demo_ipo_first_form']['generated_password'].'';
			if(sendsms($number, $message)){
				unset($_SESSION['demo_ipo_first_form']);
				echo 'Registration Successfull! Check SMS.';
			}else{
				echo '';
			}
		}else{
			echo '';
		}		
	}else{
		echo '';
	}
}
?>