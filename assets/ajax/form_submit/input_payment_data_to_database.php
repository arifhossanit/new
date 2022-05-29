<?php
include("../../../application/config/ajax_config.php");
function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){
	global $mysqli;
	global $db;
	$invoice_id = mysqli_fetch_assoc($mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$table."'"));
	$inv_id = date('dmY').$invoice_id['AUTO_INCREMENT'];
	if($mysqli->query("insert into payment_received_method values(
		'',
		'".$mysqli->real_escape_string($tnsid)."',
		'".$mysqli->real_escape_string($branch_id)."',
		'".$mysqli->real_escape_string($booking_id)."',
		'".$mysqli->real_escape_string($payment_method)."',
		'".$mysqli->real_escape_string($payment_details)."',
		'".$mysqli->real_escape_string($card_amount)."',
		'".$mysqli->real_escape_string($cash_amount)."',
		'".$mysqli->real_escape_string($mobile_amount)."',
		'".$mysqli->real_escape_string($check_amount)."',
		'".$mysqli->real_escape_string($inv_id)."',
		'',
		'1',
		'".$mysqli->real_escape_string($uploader_info)."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)")){
		return true;
	}else{
		return false;
	}		
}
if(isset($_POST['payment_type'])){
	$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['card_number']."'"));
	if(!empty($mem['id'])){
		$branch_id = $mem['branch_id'];
		$booking_id = $mem['booking_id'];
		$card_number = $mem['card_number'];
		$amount = (float)$_POST['amount'];
		$uploader_info = $_POST['uploader_info'];
		$full_name = $mem['full_name'];
		if($amount > 0){
			$utime = sprintf('%.4f', microtime(TRUE)); 
			$raw_time = DateTime::createFromFormat('U.u', $utime); 
			$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
			$today = $raw_time->format('dmy-his-u');			
			if(!empty($_SESSION['super_admin']['branch'])){
				$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
			}else{
				$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$mem['branch_id']."'"));
			}
			$transaction_id = $bc['branch_code'].'-'.$today;
			$transaction_idO = $transaction_id;
			$payment_method = '';
			$data_one = '';
			$data_two = '';
			$data_three = '';
			$payment_details = '';
			$p_branch_id = $branch_id;
			$p_booking_id = $booking_id;
			$p_uploader_info = $uploader_info;
			$p_table = 'booking_info';
			foreach($_POST['payment_method'] as $row => $value){		
				if($_POST['payment_method'][$row] == 'Mobile Banking'){ 
					$payment_details = 'Agent Name: '.$_POST['agent'][$row].', Mobile Banking Number: '.$_POST['mobile_banking_number'][$row].' Transaction Id: '.$_POST['transaction_id'][$row].'';			
					$data_one .= $_POST['payment_method'][$row].' | Agent Name | '.$_POST['agent'][$row].',';
					$data_two .= $_POST['payment_method'][$row].' | Mobile Banking Number | '.$_POST['mobile_banking_number'][$row].',';
					$data_three .= $_POST['payment_method'][$row].' | Transaction Id | '.$_POST['transaction_id'][$row].' | Amount | '.$_POST['mobile_amount'][$row].',';
					$payment_method .= $_POST['payment_method'][$row].',';
					if($_POST['mobile_amount'][$row] > 0){
						payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','',$_POST['mobile_amount'][$row],'',$p_uploader_info,$p_table);
					}
				}else if($_POST['payment_method'][$row] == 'Credit / Debit Card'){			
					$payment_details = 'Credit Card Number: '.$_POST['credit_card_number'][$row].' Card Secret: '.$_POST['card_secret'][$row].' Expiry Date: '.$_POST['Expiry_Date'][$row].'';			
					$data_one .= $_POST['payment_method'][$row].' | Credit Card Number | '.$_POST['credit_card_number'][$row].',';
					$data_two .= $_POST['payment_method'][$row].' | Card Secret | '.$_POST['card_secret'][$row].',';
					$data_three .= $_POST['payment_method'][$row].' | Expiry Date | '.$_POST['Expiry_Date'][$row].' | Amount | '.$_POST['card_amount'][$row].',';
					$payment_method .= $_POST['payment_method'][$row].',';
					if($_POST['Expiry_Date'][$row] > 0){
						payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,(float)$_POST['card_amount'][$row] + (float)$_POST['Expiry_Date'][$row],'','','',$p_uploader_info,$p_table);
					}
				}else if($_POST['payment_method'][$row] == 'Check'){			
					$payment_details = 'Bank Name: '.$_POST['bank_name'][$row].' Check Number: '.$_POST['check_number'][$row].' Withdraw Date: '.$_POST['withdraw_date'][$row].'';
					$data_one .= $_POST['payment_method'][$row].' | Bank Name | '.$_POST['bank_name'][$row].',';
					$data_two .= $_POST['payment_method'][$row].' | Check Number | '.$_POST['check_number'][$row].',';
					$data_three .= $_POST['payment_method'][$row].' | Withdraw Date | '.$_POST['withdraw_date'][$row].' | Amount | '.$_POST['check_amount'][$row].',';
					$payment_method .= $_POST['payment_method'][$row].',';
					if($_POST['check_amount'][$row] > 0){
						payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','','',$_POST['check_amount'][$row],$p_uploader_info,$p_table);
					}
				}else{			
					if(!empty($_POST['cash_other_information_remarks'][$row])){
						$cash_other_information_remarks = $_POST['cash_other_information_remarks'][$row];
					}else{
						$cash_other_information_remarks = 'N / A';
					}
					$data_one .= $_POST['payment_method'][$row].' | More Information | '.$_POST['cash_other_information_remarks'][$row].' | Amount | '.$_POST['cash_amount'][$row].',';
					$data_two .= '';
					$data_three .= '';	
					$payment_details = 'More Information: '.$cash_other_information_remarks.'';
					$payment_method .= $_POST['payment_method'][$row].',';
					if($_POST['cash_amount'][$row] > 0){
						payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'',$_POST['cash_amount'][$row],'','',$p_uploader_info,$p_table);
					}
				}
			}
			$mysqli->query("insert into transaction values(
				'',
				'".$mysqli->real_escape_string($transaction_idO)."',
				'".$mysqli->real_escape_string($branch_id)."',
				'".$mysqli->real_escape_string($booking_id)."',
				'".$mysqli->real_escape_string($full_name)."',
				'Defult',
				'Defult',
				'".$mysqli->real_escape_string($amount)."',
				'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
				'Credit',
				'Booking Account (Add Payment)',
				'".$mysqli->real_escape_string($payment_method)."',
				'".$mysqli->real_escape_string($data_one)."',
				'".$mysqli->real_escape_string($data_two)."',
				'".$mysqli->real_escape_string($data_three)."',
				'".$_POST['payment_type']." Money Collection',
				'1',
				'".$mysqli->real_escape_string($uploader_info)."',
				'".$mysqli->real_escape_string(date('d/m/Y'))."'
			)");
		}else{
			$payment_method = '';
			$data_one = '';
			$data_two = '';
			$data_three = '';
		}		//12002906
		if($mysqli->query("INSERT INTO payment_logs VALUES(
			'',
			'".$mysqli->real_escape_string($branch_id)."',
			'".$mysqli->real_escape_string($booking_id)."',
			'".$mysqli->real_escape_string($_POST['payment_type'])."',
			'".$mysqli->real_escape_string($card_number)."',
			'".$mysqli->real_escape_string($amount)."',
			'1',
			'1',
			'".$mysqli->real_escape_string($payment_method)."',
			'".$mysqli->real_escape_string($data_one)."',
			'".$mysqli->real_escape_string($transaction_idO)."',
			'".$mysqli->real_escape_string($data_three)."',
			'".$mysqli->real_escape_string($_POST['remarks'])."',
			'',
			'1',
			'".$mysqli->real_escape_string($uploader_info)."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)")){
			$number = $mem['phone_number'];
			$message = 'Dear, '.$mem['full_name'].', We received '.money($amount).' As '.$_POST['payment_type'].' | Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/  NB: This message only for experimental research & If you gotten any wrong message/information then we will maintain it officially.';
			sendsms($number,$message);
			echo 'Payment Submitted Successfully!____0';
		}else{
			echo 'Something Wrong! PLease Try Again____1';
		}
	}else{
		echo 'Card number not exixt with any Member____1';
	}
}
?>