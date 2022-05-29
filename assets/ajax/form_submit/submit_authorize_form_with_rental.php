<?php //error_reporting(0);@ini_set('display_errors', 0);
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'Octaber'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$check_existing_card = $mysqli->query("SELECT id from member_directory where card_number = ".$_POST['card_numberss']);
if($check_existing_card->num_rows > 0){
	echo 'error____error';
}else{
	if(isset($_POST['card_numberss'])){
	$booking_info = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$_POST['booking_id']."'"));
	$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));	
	$member_infoooe = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$booking_info['booking_id']."'"));
	$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking_info['package']."'"));		
		$booking_id = $booking_info['booking_id'];
		$booking_checkin_date = date('d/m/Y');
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
			$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$member_infoooe['branch_id']."'"));
		}
		$transaction_id = $bc['branch_code'].'-'.$today;
		$transaction_idO = $transaction_id;
		$payment_method = '';
		$data_one = '';
		$data_two = '';
		$data_three = '';
		$payment_details = '';
		$p_branch_id = $member_infoooe['branch_id'];
		$p_booking_id = $member_infoooe['booking_id'];
		$p_uploader_info = base64_decode($_POST['uploader_infoe']);
		$p_table = 'rent_info';
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
				$payment_details = 'Credit Card Number: '.$_POST['credit_card_number'][$row].' Card Secret: '.$_POST['card_secret'][$row].' Amount: '.$_POST['Expiry_Date'][$row].'';			
				$data_one .= $_POST['payment_method'][$row].' | Credit Card Number | '.$_POST['credit_card_number'][$row].',';
				$data_two .= $_POST['payment_method'][$row].' | Card Secret | '.$_POST['card_secret'][$row].',';
				$data_three .= $_POST['payment_method'][$row].' | Card Charge | '.$_POST['card_amount'][$row].' | Amount | '.$_POST['Expiry_Date'][$row].',';
				$payment_method .= $_POST['payment_method'][$row].',';
				if($_POST['Expiry_Date'][$row] > 0){
					payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,$_POST['Expiry_Date'][$row],'','','',$p_uploader_info,$p_table);
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
		$transactione = "insert into transaction values(
			'',
			'".$mysqli->real_escape_string($transaction_idO)."',
			'".$mysqli->real_escape_string($member_infoooe['branch_id'])."',
			'".$mysqli->real_escape_string($member_infoooe['booking_id'])."',
			'".$mysqli->real_escape_string($booking_info['m_name'])."',
			'Defult',
			'Defult',
			'".$mysqli->real_escape_string($_POST['sent_total_amount'])."',
			'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
			'Credit',
			'Authorize Account',
			'".$mysqli->real_escape_string($payment_method)."',
			'".$mysqli->real_escape_string($data_one)."',
			'".$mysqli->real_escape_string($data_two)."',
			'".$mysqli->real_escape_string($data_three)."',
			'Rental Money Collection',
			'1',
			'".$mysqli->real_escape_string(base64_decode($_POST['uploader_infoe']))."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";
		$old_blnc = $account_info['balance'];
		$new_blnc = $old_blnc + $_POST['sent_total_amount'];
		$account_information = "update accounts set
			balance = '".$new_blnc."'
			where id = '1'
		";	
		
		$check_discount = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$booking_info['booking_id']."'"));
		if(!empty($check_discount['id'])){
			if($_POST['payment_pattern_athu'] == 0){
				$mysqli->query("update discount_member set discount_pattern = 'A' where booking_id = '".$booking_info['booking_id']."'");
			}else if($_POST['payment_pattern_athu'] == 1){
				$mysqli->query("update discount_member set discount_pattern = 'B' where booking_id = '".$booking_info['booking_id']."'");
			}
		}
		
		if($package_info['try_us'] == 0){
			if($_POST['payment_pattern_athu'] == 0){
				$minus_days = 15;
			}else if($_POST['payment_pattern_athu'] == 1){
				$minus_days = 0;
			}else if($_POST['payment_pattern_athu'] == 3){
				$minus_days = 0;
			}
			$number_of_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y')) - $minus_days;		
			$recharge_days = $number_of_month - date("d");		
		}else{
			if($package_info['package_days'] == 30){
				if($_POST['payment_pattern_athu'] == 0){
					$recharge_days = (int)$package_info['package_days'] / 2;
				}else{
					$recharge_days = (int)$package_info['package_days'];
				}
			}else{
				$recharge_days = (int)$package_info['package_days'];
			}
		}
		$set_checkOut = date('d/m/Y', strtotime(date('Y/m/d'). ' + '.(int)$package_info['package_days'].' days'));
		
		if($_POST['get_discount_amount'] > 0){
			$dis_amnt = 1;
		}else{
			$dis_amnt = 1;
		}
		
		if($package_info['aggreement'] == 1){
			if($_POST['payment_pattern_athu'] == 1){
				$payment_condition_type = 'Full';
			}else{
				$payment_condition_type = 'Half';
			}
			$mysqli->query("insert into aggreement_monthly_deposit_back values(
				'',
				'".$mysqli->real_escape_string($member_infoooe['booking_id'])."',
				'1000',
				'".$payment_condition_type."',
				'',
				'1',
				'".uploader_info()."',
				'".date('d/m/Y')."'
			)");
			$set_get_dip_a = (int)$member_infoooe['security_deposit'] - 1000;
			$mysqli->query("update member_directory set security_deposit = '".$set_get_dip_a."' where booking_id = '".$member_infoooe['booking_id']."'");
			$mysqli->query("update booking_info set security_deposit = '".$set_get_dip_a."' where booking_id = '".$member_infoooe['booking_id']."'");
			$utime1 = sprintf('%.4f', microtime(TRUE)); 
			$raw_time1 = DateTime::createFromFormat('U.u', $utime1); 
			$raw_time1->setTimezone(new DateTimeZone('Asia/Dhaka')); 
			$today1 = $raw_time1->format('dmy-his-u');
			$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
			$transaction_id1 = $bc['branch_code'].'-'.$today1;
			$mysqli->query("insert into transaction values(
				'', 
				'".$transaction_id1."', 
				'".$mysqli->real_escape_string($bc['branch_id'])."', 
				'".$mysqli->real_escape_string($member_infoooe['booking_id'])."', 
				'".$mysqli->real_escape_string($booking_info['m_name'])."', 
				'Defult', 
				'Defult', 
				'1000', 
				'".date('l, d/m/Y h:i:sa')."', 
				'Debit', 
				'Deposit Money Return to Agreement Member', 
				'Auto By Software', 
				'', 
				'', 
				'', 
				'', 
				'1', 
				'".uploader_info()."', 
				'".date('d/m/Y')."' 
			)");					
		}
		
		$rent_information = "insert into rent_info values(
			'',
			'".$mysqli->real_escape_string($booking_info['booking_id'])."',
			'".$mysqli->real_escape_string($booking_info['branch_id'])."',
			'".$mysqli->real_escape_string($booking_info['branch_name'])."',
			'".$mysqli->real_escape_string($booking_checkin_date)."',
			'".$mysqli->real_escape_string($set_checkOut)."',
			'".$mysqli->real_escape_string($booking_info['package_category'])."',
			'".$mysqli->real_escape_string($booking_info['package_category_name'])."',
			'".$mysqli->real_escape_string($booking_info['package'])."',
			'".$mysqli->real_escape_string($booking_info['package_name'])."',
			'".$mysqli->real_escape_string($_POST['card_numberss'])."',
			'".$mysqli->real_escape_string($booking_info['m_name'])."',
			'".$mysqli->real_escape_string($_POST['sent_rent_amount'])."',
			'".$mysqli->real_escape_string($_POST['sent_parking_amount'])."',
			'0',
			'0',
			'".$mysqli->real_escape_string($_POST['sent_total_amount'])."',
			'0',
			'0',
			'0',
			'".$mysqli->real_escape_string($recharge_days)."',
			'Paid',
			'".$mysqli->real_escape_string($_POST['payment_pattern_athu'])."',
			'1',
			'1',
			'".$mysqli->real_escape_string($payment_method)."',
			'".$mysqli->real_escape_string($data_one)."',
			'".$mysqli->real_escape_string($transaction_idO)."',
			'".$mysqli->real_escape_string($data_three)."',
			'',
			'',
			'1',
			'".$mysqli->real_escape_string(base64_decode($_POST['uploader_infoe']))."',
			'".$mysqli->real_escape_string(month_name(date('m')))."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."',
			'".$dis_amnt."',
			'B',
			'".$_POST['get_discount_amount']."'
		)";
		$activity_logd = "insert into activity_log values(
			'',
			'".$mysqli->real_escape_string($booking_info['branch_id'])."',
			'".$mysqli->real_escape_string($booking_info['branch_name'])."',
			'".$mysqli->real_escape_string(base64_decode($_POST['uploader_infoe'])." is received rent from ".$booking_info['m_name'])."',
			'".$mysqli->real_escape_string(base64_decode($_POST['uploader_infoe']))."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";	
		$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$booking_info['branch_id']."'"));
		if(!empty($branch['branch_phone_number'])){
			$phone_numbera = $branch['branch_phone_number'];
		}else{
			$phone_numbera = '+8809638666333';
		}
		if($package_info['try_us'] == '1'){
			if(
				$mysqli->query("update beds set uses = '3' where id = '".$member_infoooe['bed_id']."'")
				AND
				$mysqli->query("update booking_info set card_no = '".$_POST['card_numberss']."', checkin_date = '".$booking_checkin_date."', checkout_date = '".$set_checkOut."', available_days = '".$recharge_days."' where booking_id = '".$booking_info['booking_id']."'")
				AND
				$mysqli->query("update member_directory set card_number = '".$_POST['card_numberss']."', check_in_date = '".$booking_checkin_date."', check_out_date = '".$set_checkOut."' where booking_id = '".$booking_info['booking_id']."'")
				AND
				$mysqli->query($rent_information)
				AND
				$mysqli->query($activity_logd)
				AND
				$mysqli->query($transactione)			
			){
				$bK_id = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$booking_id."'"));
				if(sendsms($member_infoooe['phone_number'],'Dear, '.$booking_info['m_name'].' your athorization successfully done, We received your total rent amount is BDT '.round($_POST['sent_total_amount'],2).'. Thank you for stay with us. For any query feel free to call us '.$phone_numbera.' & for more details visit here: https://www.superhomebd.com/')){
					$message = 'Dear, '.$booking_info['m_name'].' your athorization successfully done, We received your total rent amount is BDT '.round($_POST['sent_total_amount'],2).'. Thank you for stay with us. For any query feel free to call us '.$phone_numbera.' & for more details visit here: https://www.superhomebd.com/';									
					if(main_email('SUPER HOME MEMBER Athorozation & Rent Collection information',$message,'','',$member_infoooe['email'],$member_infoooe['full_name'])){
						echo 'Athorized Successfeully Done in Try Us Package.____0____'.$bK_id['id'].'';
					}else{
						echo 'Something Wrong In MAIL section! Athorized Successfeully Done in Try Us Package.____0____'.$bK_id['id'].'';
					}				
				}else{
					echo 'Something Wrong In SMS section! Athorized Successfeully Done in Try Us Package.____0____'.$bK_id['id'].'';
				}			
			}else{			
				echo 'Something Wrong! Please Try again.____1';
			}
		}else{
			$card_chaeck = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['card_numberss']."'"));
			if(!empty($card_chaeck['card_number']) AND $card_chaeck['card_number'] == $_POST['card_numberss']){
				echo 'Card Number Already Exixt! Please Try again.____1';
			}else{
				if(
					$mysqli->query("update beds set uses = '3' where id = '".$member_infoooe['bed_id']."'")
					AND
					$mysqli->query("update booking_info set card_no = '".$_POST['card_numberss']."', checkin_date = '".$booking_checkin_date."' where booking_id = '".$booking_info['booking_id']."'")
					AND
					$mysqli->query("update member_directory set card_number = '".$_POST['card_numberss']."', check_in_date = '".$booking_checkin_date."' where booking_id = '".$booking_info['booking_id']."'")
					AND
					$mysqli->query($rent_information)
					AND
					$mysqli->query($activity_logd)
					AND
					$mysqli->query($transactione)			
				){
					$bK_id = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$booking_id."'"));
					if(sendsms($member_infoooe['phone_number'],'Dear. '.$booking_info['m_name'].' your athorization successfully done, We received your total rent amount is BDT '.round($_POST['sent_total_amount'],2).'. Thank you for stay with us. For any query feel free to call us '.$phone_numbera.' & for more details visit here: https://www.superhomebd.com/')){
						$message = 'Dear. '.$booking_info['m_name'].' your athorization successfully done, We received your total rent amount is BDT '.round($_POST['sent_total_amount'],2).'. Thank you for stay with us. for any query feel free to call us '.$phone_numbera.' & for more details visit here: https://www.superhomebd.com/';									
						if(main_email('SUPER HOME MEMBER Athorozation & Rent Collection information',$message,'','',$member_infoooe['email'],$member_infoooe['full_name'])){
							echo 'Athorized Successfeully Done.____0____'.$bK_id['id'].'';
						}else{
							echo 'Something Wrong In MAIL section! Athorized Successfeully Done.____0____'.$bK_id['id'].'';
						}				
					}else{
						echo 'Something Wrong In SMS section! Athorized Successfeully Done.____0____'.$bK_id['id'].'';
					}			
				}else{			
					echo 'Something Wrong! Please Try again.____1';
				}
			}		
		}	
	}
}
?>