<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));	
	$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$_POST['new_branch']."'"));
	if(!empty($_POST['checkout_iteam'])){
		$checkout_iteam = implode(',',$_POST['checkout_iteam']);
	}else{
		$checkout_iteam = '';
	}
	if(!empty($_POST['diposit_js'])){
		$amount = $_POST['diposit_js'];
	}else{
		$amount = '0';
	}
	//--------payment method------
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
	$utime = sprintf('%.4f', microtime(TRUE)); 
	$raw_time = DateTime::createFromFormat('U.u', $utime); 
	$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
	$today = $raw_time->format('dmy-his-u');
	if(!empty($_SESSION['super_admin']['branch'])){
		$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
	}else{
		$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$member_info['branch_id']."'"));
	}
	$transaction_id = $bc['branch_code'].'-'.$today;
	$transaction_idO = $transaction_id;
	$payment_method = '';
	$data_one = '';
	$data_two = '';
	$data_three = '';
	$payment_details = '';
	$p_branch_id = $member_info['branch_id'];
	$p_booking_id = $member_info['booking_id'];
	$p_uploader_info = $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
	$p_table = 'branch_change_info';
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
			if($_POST['card_amount'][$row] > 0){
				payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,$_POST['card_amount'][$row],'','','',$p_uploader_info,$p_table);
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
	//--------end payment method------	
	$branch_change = "insert into branch_change_info values(
		'',
		'".$mysqli->real_escape_string($member_info['booking_id'])."',
		'".$mysqli->real_escape_string($member_info['branch_id'])."',
		'".$mysqli->real_escape_string($member_info['branch_name'])."',
		'".$mysqli->real_escape_string($branch_info['branch_id'])."',
		'".$mysqli->real_escape_string($branch_info['branch_name'])."',
		'".$mysqli->real_escape_string($_POST['shifting_date'])."',
		'".$mysqli->real_escape_string($checkout_iteam)."',
		'".$mysqli->real_escape_string($amount)."',		
		'',
		'1',
		'".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)";	
	$mem_info = "update member_directory set
		branch_id = '".$mysqli->real_escape_string($branch_info['branch_id'])."',
		branch_name = '".$mysqli->real_escape_string($branch_info['branch_name'])."',
		floor_id = '',
		floor_name = '',
		unit_id = '',
		unit_name = '',
		room_id = '',
		room_name = '',
		bed_id = '',
		bed_name = '',
		package_category = '',
		package = '',
		package_name = '',
		bet_type = '',
		security_deposit = '0',
		rent_amount = '0',
		parking = '0',
		parking_amount = '0',
		total_amount = '0'	
		where booking_id = '".$member_info['booking_id']."'
	";		
	if($_POST['diposit_js'] > 0){
		$mysqli->query("insert into transaction values(
			'',
			'".$mysqli->real_escape_string($transaction_idO)."',
			'".$mysqli->real_escape_string($member_info['branch_id'])."',
			'".$mysqli->real_escape_string($member_info['booking_id'])."',
			'".$mysqli->real_escape_string($member_info['branch_name'])."',
			'Defult',
			'Defult',
			'".$mysqli->real_escape_string($_POST['diposit_js'])."',
			'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
			'Credit',
			'Rental Account',
			'".$mysqli->real_escape_string($payment_method)."',
			'".$mysqli->real_escape_string($data_one)."',
			'".$mysqli->real_escape_string($data_two)."',
			'".$mysqli->real_escape_string($data_three)."',
			'Branch Change Money Collection',
			'1',
			'".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)");
	}	
	$activity_log = "insert into activity_log values(
		'',
		'".$mysqli->real_escape_string($member_info['branch_id'])."',
		'".$mysqli->real_escape_string($member_info['branch_name'])."',
		'".$mysqli->real_escape_string($member_info['full_name']." is booked by ".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
		'".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)";	
	if(
		$mysqli->query($branch_change) AND
		$mysqli->query($mem_info) AND
		$mysqli->query("update booking_info set branch_id = '".$branch_info['branch_id']."', branch_name = '".$branch_info['branch_name']."' where booking_id = '".$member_info['booking_id']."'") AND
		$mysqli->query("update beds set uses = '0' where id = '".$member_info['bed_id']."'") AND
		$mysqli->query($activity_log)
	){
		if(sendsms($member_info['phone_number'],'Mr. '.$member_info['full_name'].', Branch Successfully Changed! Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.')){
			$message = 'Mr. '.$member_info['full_name'].', Branch Successfully Changed! Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';
			if(main_email('SUPER HOME MEMBER: BRANCH CHANGE INFORMATION',$message,'','',$member_info['email'],$member_info['full_name'])){
				echo 'Branch Change Submitted Successfully!';
			}else{
				echo 'Something Wrong In MAIL section! Branch Change Submitted Successfully!';
			}				
		}else{
			echo 'Something Wrong In SMS section! Branch Change Submitted Successfully!';
		}		
	}else{
		echo 'Something Wrong! Please Try Again';
	}
}
?>