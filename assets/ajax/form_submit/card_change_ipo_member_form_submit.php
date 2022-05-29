<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['ipo_card_change_token'])){
$mem_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where id = '".$_POST['member_id']."'"));
if(empty($mem_info['card_number'])){
	echo 'Please Refresh The PopUp From, Old Card Number not found! Please Try again.____1';
}else{
$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));	
$ipo_id = $mem_info['ipo_id'];

	//--------payment method------
	function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){
		global $mysqli;
		global $db;
		$invoice_id = mysqli_fetch_assoc($mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$table."'"));
		$inv_id = date('dmY').$invoice_id['AUTO_INCREMENT'];
		if($mysqli->query("insert into ipo_payment_received_method values(
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
	$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
	$transaction_id = $bc['branch_code'].'-'.$today;
	$transaction_idO = $transaction_id;
	$payment_method = '';
	$data_one = '';
	$data_two = '';
	$data_three = '';
	$payment_details = '';
	$p_branch_id = $bc['branch_id'];
	$p_booking_id = $ipo_id;
	$p_uploader_info = uploader_info();
	$p_table = 'ipo_card_change_log';
	if($_POST['total_amount']){
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
		$old_blnc = $account_info['balance'];
		$new_blnc = $old_blnc + $_POST['booking_total_amount_c'];
		$mysqli->query("UPDATE accounts SET balance = '".$mysqli->real_escape_string($new_blnc)."'");
		$transactione = "insert into transaction values(
			'',
			'".$mysqli->real_escape_string($transaction_idO)."',
			'".$mysqli->real_escape_string($bc['branch_id'])."',
			'".$mysqli->real_escape_string($ipo_id)."',
			'".$mysqli->real_escape_string($mem_info['personal_full_name'])."',
			'Defult',
			'Defult',
			'".$mysqli->real_escape_string($_POST['booking_total_amount_c'])."',
			'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
			'Credit',
			'IPO Card Change Account',
			'".$mysqli->real_escape_string($payment_method)."',
			'".$mysqli->real_escape_string($data_one)."',
			'".$mysqli->real_escape_string($data_two)."',
			'".$mysqli->real_escape_string($data_three)."',
			'IPO Card Number Change Money Collection',
			'1',
			'".$mysqli->real_escape_string(uploader_info())."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";	
		$mysqli->query($transactione);
	}
	
	$card_change_log = "INSERT INTO ipo_card_change_log VALUES(
		'',
		'".$mysqli->real_escape_string($ipo_id)."',
		'".$mysqli->real_escape_string($mem_info['card_number'])."',
		'".$mysqli->real_escape_string($_POST['new_card'])."',
		'',
		'1',
		'".$mysqli->real_escape_string(uploader_info())."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)";
	$activity_logd = "insert into activity_log values(
		'',
		'".$bc['branch_id']."',
		'".$bc['branch_name']."',
		'".uploader_info()." is Change from ".$mem_info['card_number']." to ".$_POST['new_card']." for Mr. ".$mem_info['personal_full_name']." As IPO Member And give the new card',
		'".uploader_info()."',
		'".date('d/m/Y')."'
	)";	
	$card_chaeck = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where card_number = '".$_POST['new_card']."'"));
	if(!empty($card_chaeck['card_number']) AND $card_chaeck['card_number'] == $_POST['new_card']){
		echo 'Card Number Already Exixt! Please Try again.____1';
	}else{
		if(
			$mysqli->query("UPDATE ipo_member_directory SET 
				card_number = '".$mysqli->real_escape_string($_POST['new_card'])."' 
				WHERE ipo_id = '".$ipo_id."'
			")
			AND
			$mysqli->query($activity_logd)					
		){
			echo 'Successfeully Card Changed.____0';			
		}else{			
			echo 'Something Wrong! Please Try again.____1';
		}
	}		
}
}
?>