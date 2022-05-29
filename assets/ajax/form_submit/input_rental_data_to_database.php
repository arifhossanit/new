<?php
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){ global $mysqli; global $db; $invoice_id = mysqli_fetch_assoc($mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$table."'")); $inv_id = date('dmy').$invoice_id['AUTO_INCREMENT']; if($mysqli->query("insert into payment_received_method values('', '".$mysqli->real_escape_string($tnsid)."', '".$mysqli->real_escape_string($branch_id)."', '".$mysqli->real_escape_string($booking_id)."', '".$mysqli->real_escape_string($payment_method)."', '".$mysqli->real_escape_string($payment_details)."', '".$mysqli->real_escape_string($card_amount)."', '".$mysqli->real_escape_string($cash_amount)."', '".$mysqli->real_escape_string($mobile_amount)."', '".$mysqli->real_escape_string($check_amount)."', '".$mysqli->real_escape_string($inv_id)."', '', '1', '".$mysqli->real_escape_string($uploader_info)."', '".$mysqli->real_escape_string(date('d/m/Y'))."' )")){ return true; }else{ return false; } }
//---------Start rent submittion----------------
if(isset($_POST['card_number'])){
		
	$card_number = $_POST['card_number'];
	$member_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory WHERE card_number = '".$card_number."'"));	
	$booking_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM booking_info WHERE booking_id = '".$member_info['booking_id']."'"));
	$check_cencel = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where member_id = '".$member_info['id']."'"));

	 $check_if_today_has_any_transection = mysqli_fetch_assoc($mysqli->query("SELECT * FROM transaction WHERE booking_id = '".$member_info['booking_id']."' AND transaction_category LIKE '%Rental Account%' order by id desc LIMIT 1 "));
	 if(!empty($check_if_today_has_any_transection)){

	 	$date_from_database = $check_if_today_has_any_transection['date'];
	 	$date_explode = (explode(",",$date_from_database));
		$making_space_before_am_pm = substr_replace($date_explode[1], ' ' . substr($date_explode[1], -2), -2);
		$dash_replace_and_to_mili_sec = strtotime(str_replace("/","-",$making_space_before_am_pm));

	 	$now = strtotime(date('Y-m-d h:m:s a'));
	 	$time_diff_in_minutes = intval((intval($now) - intval($dash_replace_and_to_mili_sec))/60);

	 	if($time_diff_in_minutes <= 59){
			$when_payment_will_be_possible = $time_diff_in_minutes - 59;
			print "<p style='color:red;font-size:20pt;font-weight:900;margin-bottom:10px;text-align:center;'>Sorry! Rent transaction against this card is not possible right now. Please try again after ".$when_payment_will_be_possible." minute/s if needed.</p>";
			exit();
		}
	 }

	if(!empty($check_cencel['id'])){
		echo 'Something wrong! Member is auto cancel. Please checkout fast!____1';
	}else{
		$utime = sprintf('%.4f', microtime(TRUE)); $raw_time = DateTime::createFromFormat('U.u', $utime); $raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); $today = $raw_time->format('dmy-his-u');
		if(!empty($_SESSION['super_admin']['branch'])){ $bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'")); }else{ $bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$member_info['branch_id']."'")); }
		$transaction_id = $bc['branch_code'].'-'.$today;
		if(!empty($_POST['uploader_info'])){ $uploader_info = rahat_decode($_POST['uploader_info']); }else{ $uploader_info = ''; }
		if(!empty($_POST['rent_amount_final'])){ $rent_amount = $_POST['rent_amount_final']; }else{ $rent_amount = '0'; }	
		if(!empty($_POST['parking_amount'])){ $parking_amountt = $_POST['parking_amount']; $parking_amount = $_POST['parking_amount']; }else{ $parking_amount = '0'; $parking_amountt = '0';}	
		if(!empty($_POST['panalty_amount'])){ $panalty_amount = $_POST['panalty_amount']; }else{ $panalty_amount = '0'; }		
		if(!empty($_POST['electricity_bill'])){ $electricity_bill = $_POST['electricity_bill']; }else{ $electricity_bill = '0'; }
		if(!empty($_POST['tea_coffee_bill'])){ $tea_coffee_bill = $_POST['tea_coffee_bill']; }else{ $tea_coffee_bill = '0'; }
		if(isset($_POST['soap'])){ $soap = 'Soap: YES |'; }else{ $soap = 'Soap: NO |'; }	
		if(isset($_POST['shampoo'])){ $shampoo = 'Shampoo : YES |'; }else{ $shampoo = 'Shampoo : NO |'; }	
		if(isset($_POST['tishue'])){ $tishue = 'Tishue : YES'; }else{ $tishue = 'Tishue : NO'; }	
		$other_info = $soap.$shampoo.$tishue;	
		if($_POST['payment_pattern'] == '3'){ $var_pen = ' ( This Member Got 50% Pendamic Discount! )'; }else{ $var_pen = ''; }
		if(!empty($_POST['rental_mpnth'])){ $m_d = explode("-",$_POST['rental_mpnth']); $month = $m_d[1]; $year = $m_d[0]; }else{ $month = date('m'); $year = date('Y'); }
		$card_p_amount = (float)$_POST['total_result'] - (float)$_POST['total_result_c'];
		if($card_p_amount > 0){ $card_p_amount = $card_p_amount; }else{ $card_p_amount = 0; }
		$payment_pattern = $_POST['payment_pattern'];
		$transaction_idO = $transaction_id;
		$payment_method = '';
		$data_one = '';
		$data_two = '';
		$data_three = '';
		$payment_details = '';
		$p_branch_id = $member_info['branch_id'];
		$p_booking_id = $member_info['booking_id'];
		$p_uploader_info = $uploader_info;
		$p_table = 'rent_info';
		foreach($_POST['payment_method'] as $row => $value){ if($_POST['payment_method'][$row] == 'Mobile Banking'){ $payment_details = 'Agent Name: '.$_POST['agent'][$row].', Mobile Banking Number: '.$_POST['mobile_banking_number'][$row].' Transaction Id: '.$_POST['transaction_id'][$row].''; $data_one .= $_POST['payment_method'][$row].' | Agent Name | '.$_POST['agent'][$row].','; $data_two .= $_POST['payment_method'][$row].' | Mobile Banking Number | '.$_POST['mobile_banking_number'][$row].','; $data_three .= $_POST['payment_method'][$row].' | Transaction Id | '.$_POST['transaction_id'][$row].' | Amount | '.$_POST['mobile_amount'][$row].','; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['mobile_amount'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','',$_POST['mobile_amount'][$row],'',$p_uploader_info,$p_table); } }else if($_POST['payment_method'][$row] == 'Credit / Debit Card'){ $payment_details = 'Credit Card Number: '.$_POST['credit_card_number'][$row].' Card Secret: '.$_POST['card_secret'][$row].' Expiry Date: '.$_POST['Expiry_Date'][$row].''; $data_one .= $_POST['payment_method'][$row].' | Credit Card Number | '.$_POST['credit_card_number'][$row].','; $data_two .= $_POST['payment_method'][$row].' | Card Secret | '.$_POST['card_secret'][$row].','; $data_three .= $_POST['payment_method'][$row].' | Expiry Date | '.$_POST['Expiry_Date'][$row].' | Amount | '.$_POST['card_amount'][$row].','; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['Expiry_Date'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,(float)$_POST['card_amount'][$row] + (float)$_POST['Expiry_Date'][$row],'','','',$p_uploader_info,$p_table); } }else if($_POST['payment_method'][$row] == 'Check'){ $payment_details = 'Bank Name: '.$_POST['bank_name'][$row].' Check Number: '.$_POST['check_number'][$row].' Withdraw Date: '.$_POST['withdraw_date'][$row].''; $data_one .= $_POST['payment_method'][$row].' | Bank Name | '.$_POST['bank_name'][$row].','; $data_two .= $_POST['payment_method'][$row].' | Check Number | '.$_POST['check_number'][$row].','; $data_three .= $_POST['payment_method'][$row].' | Withdraw Date | '.$_POST['withdraw_date'][$row].' | Amount | '.$_POST['check_amount'][$row].','; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['check_amount'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'','','',$_POST['check_amount'][$row],$p_uploader_info,$p_table); } }else{ if(!empty($_POST['cash_other_information_remarks'][$row])){ $cash_other_information_remarks = $_POST['cash_other_information_remarks'][$row]; }else{ $cash_other_information_remarks = 'N / A'; } $data_one .= $_POST['payment_method'][$row].' | More Information | '.$_POST['cash_other_information_remarks'][$row].' | Amount | '.$_POST['cash_amount'][$row].','; $data_two .= ''; $data_three .= ''; $payment_details = 'More Information: '.$cash_other_information_remarks.''; $payment_method .= $_POST['payment_method'][$row].','; if($_POST['cash_amount'][$row] > 0){ payment_varient($transaction_idO,$p_branch_id,$p_booking_id,$_POST['payment_method'][$row],$payment_details,'',$_POST['cash_amount'][$row],'','',$p_uploader_info,$p_table); } } }
		$mysqli->query("INSERT into transaction values('', '".$transaction_idO."', '".$mysqli->real_escape_string($member_info['branch_id'])."', '".$mysqli->real_escape_string($member_info['booking_id'])."', '".$mysqli->real_escape_string($booking_info['m_name'])."', 'Defult', 'Defult', '".$mysqli->real_escape_string($_POST['total_result'])."', '".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."', 'Credit', 'Rental Account', '".$mysqli->real_escape_string($payment_method)."', '".$mysqli->real_escape_string($data_one)."', '".$mysqli->real_escape_string($data_two)."', '".$mysqli->real_escape_string($data_three)."', 'Rent Collection', '1', '".$mysqli->real_escape_string($uploader_info)."', '".$mysqli->real_escape_string(date('d/m/Y'))."' )");
		if(!empty($_POST['package_extender'])){
			$pe_data = explode('____',$_POST['package_extender']);
			$package_id = $pe_data[0];
			$package_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$package_id."'"));
			$package_days = $package_info['package_days'];
			if($package_days == 30){
				if($_POST['payment_pattern'] == 0){
					$pre_rech = (int)$package_days / 2;
					$recharge_days = (int)$pre_rech;
				}else{
					$recharge_days = (int)$package_days;
				}
			}else{
				$recharge_days = (int)$package_days;
			}
			$time = explode('/',$member_info['check_out_date']);
			$pao = $time[2].'/'.$time[1].'/'.$time[0];
			$set_checkOut = date('d/m/Y', strtotime($pao. ' + '.(int)$package_days.' days'));		
			if($parking_amount > 0){
				$parking = " parking = '".$mysqli->real_escape_string(1)."',"; //$parking_amount
				$parking_amountd = " parking_amount = '".$mysqli->real_escape_string($parking_amount)."',";
			}else{
				$parking = "";
				$parking_amountd = "";
			}
			$old_package_category = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages_category WHERE id = '".$member_info['package_category']."'"));
			$old_package = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$member_info['package']."'"));
			$extend_package_note = 'Member extend from old Package '.$old_package_category['package_category_name'].' - '.$old_package['package_name'].' to new Package '.$old_package_category['package_category_name'].' - '.$package_info['package_name'];
			$mysqli->query("UPDATE member_directory set
				package = '".$mysqli->real_escape_string($package_info['id'])."',
				package_name = '".$mysqli->real_escape_string($package_info['package_name'])."',
				rent_amount = '".$mysqli->real_escape_string($package_info['monthly_rent'])."',
				$parking
				check_out_date = '".$mysqli->real_escape_string($set_checkOut)."'		
				where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."'
			"); // blank line above had a variable $parking
			$mysqli->query("UPDATE booking_info set
				checkout_date = '".$mysqli->real_escape_string($set_checkOut)."',
				$parking_amountd
				package = '".$mysqli->real_escape_string($package_info['id'])."',
				package_name = '".$mysqli->real_escape_string($package_info['package_name'])."'
				where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."'
			"); // blank line above had a variable $parking_amountd
			$days_add = $booking_info['available_days'] + (int)$recharge_days;
			$renew = 'renew';
			$package = $package_info['id'];
			$package_name = $package_info['package_name'];
			$checkout_date = $set_checkOut;
		}else{
			$package_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$member_info['package']."'"));
			if($package_info['try_us'] == 0){ // Monthly Membership 		
				$rent_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM rent_info WHERE booking_id = '".$member_info['booking_id']."' AND rent_status = 'Paid' ORDER BY id DESC"));
				if(!empty($rent_info)){
					$number_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
					if($_POST['payment_pattern'] == 0){
						$recharge_days = (int)$number_of_month / 2;
					}else if($_POST['payment_pattern'] == 1){
						$rent_checkt = mysqli_fetch_assoc($mysqli->query("SELECT * FROM rent_info WHERE booking_id = '".$member_info['booking_id']."' AND rent_status = 'Paid' ORDER BY id DESC"));
						if(!empty($rent_checkt['id'])){
							if($rent_checkt['payment_pattern'] == 0){
								$recharge_days = (int)$number_of_month / 2;
							}else{
								$recharge_days = (int)$number_of_month;
							}
						}else{
							$recharge_days = (int)$number_of_month;
						}					
					}else if($_POST['payment_pattern'] == 3){
						$recharge_days = (int)$number_of_month;
					}
				}else{
					if($_POST['payment_pattern'] == 0){
						$minus_days = 15;
					}else if($_POST['payment_pattern'] == 1){
						$minus_days = 0;
					}else if($_POST['payment_pattern'] == 3){
						$minus_days = 0;
					}
					$number_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
					$cin_date = explode('/',$member_info['check_in_date']);
					$recharge_days = (int)$number_of_month - $minus_days - $cin_date[0];			
				}
				if($parking_amount > 0){
					$parking = " parking = '".$mysqli->real_escape_string(1)."'"; //$parking_amount
					$parking_amount = " parking_amount = '".$mysqli->real_escape_string($parking_amount)."'";
				}else{
					$parking = "";
					$parking_amount = "";
				}
				$days_add = (int)$booking_info['available_days'] + (int)$recharge_days;
				$renew = '';
				$package = $package_info['id'];
				$package_name = $package_info['package_name'];
				$checkout_date = 'Not Confirm Yet';
				$mysqli->query("UPDATE member_directory set
					$parking
					check_out_date = '".$mysqli->real_escape_string($checkout_date)."'
					where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."'
				"); // above empty space had a variable $parking
				$mysqli->query("UPDATE booking_info set				
					$parking_amount
					checkout_date = '".$mysqli->real_escape_string($checkout_date)."'
					where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."'
				");			
			}else{ // TRY US Member ship
				$package_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$member_info['package']."'"));
				$package_days = $package_info['package_days'];
				if($package_days == 30){
					if($_POST['payment_pattern'] == 0){
						$recharge_days = (int)$package_days / 2;
					}else{
						$rent_checkt = mysqli_fetch_assoc($mysqli->query("SELECT * FROM rent_info WHERE booking_id = '".$member_info['booking_id']."' AND rent_status = 'Paid' ORDER BY id DESC"));
						if(!empty($rent_checkt['id'])){
							if($rent_checkt['payment_pattern'] == 0){
								$recharge_days = (int)$package_days / 2;
							}else{
								$recharge_days = (int)$package_days;
							}
						}else{
							$recharge_days = (int)$package_days;	
						}					
					}
				}else{
					$recharge_days = (int)$package_days;	
				}
				if($parking_amount > 0){
					$parking = " parking = '".$mysqli->real_escape_string(1)."'"; //$parking_amount
					$parking_amount = " parking_amount = '".$mysqli->real_escape_string($parking_amount)."'";
				}else{
					$parking = "";
					$parking_amount = "";
				}
				$time = explode('/',$member_info['check_out_date']);
				$pao = $time[2].'/'.$time[1].'/'.$time[0];
				$set_checkOut = date('d/m/Y', strtotime($pao. ' + '.(int)$package_days.' days'));
				$days_add = $booking_info['available_days'] + (int)$recharge_days;
				$renew = '';
				$package = $package_info['id'];
				$package_name = $package_info['package_name'];
				$checkout_date = $member_info['check_out_date']; //$set_checkOut;
				$mysqli->query("UPDATE member_directory set
					$parking
					where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."'
				"); // above empty space had a variable $parking
				$mysqli->query("UPDATE booking_info set				
					$parking_amount
					where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."'
				");	//checkout_date = '".$mysqli->real_escape_string($set_checkOut)."'
			}		
		}
		//Discount Management===========================
		if($_POST['disccount_money'] > 0){
			$check_discount = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$booking_info['booking_id']."'"));
			if($_POST['discount_pattern'] == 'YES'){
				if($_POST['payment_pattern'] == 0){
					$_UPDATE_DPATTERN = 'A';
					$_DISCOUNT_MONEY = $check_discount['amount'] / 2;
				}else{
					$_UPDATE_DPATTERN = 'B';
					$_DISCOUNT_MONEY = $check_discount['amount'];
				}
			} else if ($_POST['discount_pattern'] == 'A'){
				$_UPDATE_DPATTERN = 'AA';
				$_DISCOUNT_MONEY = $check_discount['amount'] / 2;
			} else if ($_POST['discount_pattern'] == 'B'){
				$_UPDATE_DPATTERN = 'B';
				$_DISCOUNT_MONEY = 0;
			} else {
				$_UPDATE_DPATTERN = 'B';
				$_DISCOUNT_MONEY = 0;
			}
			$mysqli->query("UPDATE discount_member SET discount_pattern = '".$_UPDATE_DPATTERN."' WHERE booking_id = '".$member_info['booking_id']."'");
		}else{
			$_UPDATE_DPATTERN = 'NO';
			$_DISCOUNT_MONEY = 0;
		}
		//End Discount Management===========================

		//Aggreement User Security Deposit Money Return Function//		
		if($package_info['aggreement'] == 1){
			$check_d_back = mysqli_fetch_assoc($mysqli->query("select * from aggreement_monthly_deposit_back where booking_id = '".$member_info['booking_id']."' order by id desc limit 01"));
			if(!empty($check_d_back['id'])){
				if($check_d_back['payment_condition'] == 'Full'){
					$allow_s_back = 1;
					if($_POST['payment_pattern'] == 1){
						$payment_condition_type = 'Full';
					}else{
						$payment_condition_type = 'Half';
					}
				}else{
					$mysqli->query("update aggreement_monthly_deposit_back set payment_condition = 'Full' where id = '".$check_d_back['id']."'");
					$allow_s_back = 0;
				}
			}else{
				$allow_s_back = 1;
				if($_POST['payment_pattern'] == 1){
					$payment_condition_type = 'Full';
				}else{
					$payment_condition_type = 'Half';
				}
			}		
			if($allow_s_back == 1){
				$mysqli->query("insert into aggreement_monthly_deposit_back values(
					'',
					'".$member_info['booking_id']."',
					'1000',
					'".$payment_condition_type."',
					'',
					'1',
					'".uploader_info()."',
					'".date('d/m/Y')."'
				)");
				$set_get_dip_a = (int)$member_info['security_deposit'] - 1000;

				$check_out_contract = DateTime::createFromFormat('d/m/Y', $member_info['check_out_date']);
				$check_out_contract->add(new DateInterval('P30D'));
				$checkout_date = $check_out_contract->format('d/m/Y');
				$tmp1 = $mysqli->query("UPDATE member_directory set security_deposit = '".$set_get_dip_a."', check_out_date = '".$check_out_contract->format('d/m/Y')."' where booking_id = '".$member_info['booking_id']."'");
				$mysqli->query("UPDATE booking_info set security_deposit = '".$set_get_dip_a."', checkout_date = '".$check_out_contract->format('d/m/Y')."' where booking_id = '".$member_info['booking_id']."'");
				$utime1 = sprintf('%.4f', microtime(TRUE)); 
				$raw_time1 = DateTime::createFromFormat('U.u', $utime1); 
				$raw_time1->setTimezone(new DateTimeZone('Asia/Dhaka')); 
				$today1 = $raw_time1->format('dmy-his-u');
				if(!empty($_SESSION['super_admin']['branch'])){
					$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
				}else{
					$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$member_info['branch_id']."'"));
				}
				$transaction_id1 = $bc['branch_code'].'-'.$today1;
				$mysqli->query("insert into transaction values(
					'', 
					'".$transaction_id1."', 
					'".$mysqli->real_escape_string($member_info['branch_id'])."', 
					'".$mysqli->real_escape_string($member_info['booking_id'])."', 
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
		}
		
		if(!empty($_POST['package_extender'])){
			$dis_aamt = 0;
		}else{
			if(!empty($_POST['disccount_money'])){
				$check_discount = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$booking_info['booking_id']."'"));
				if(!empty($check_discount['id'])){
					$dis_aamt = 1;
				}else{
					$dis_aamt = 0;
				}		
			}else{
				$dis_aamt = 0;
			}
		}
		$rent_infoi = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$member_info['booking_id']."' and month_name = '".month_name($month)."' AND data LIKE '%$year%' order by id desc"));
		if(!empty($rent_infoi['booking_id']) AND $rent_infoi['month_name'] == month_name($month) AND $rent_infoi['rent_status'] == 'Due'){
			$rent_insert_data = "update rent_info set
				checkout_date = '".$mysqli->real_escape_string($checkout_date)."',
				rent_amount = '".$mysqli->real_escape_string($rent_amount)."',			
				package = '".$mysqli->real_escape_string($package)."',
				package_name = '".$mysqli->real_escape_string($package_name)."',			
				parking = '".$mysqli->real_escape_string($parking_amountt)."',
				electricity = '".$mysqli->real_escape_string($electricity_bill)."',
				tea_coffee = '".$mysqli->real_escape_string($_POST['tea_coffee_bill'])."',
				total_amount = '".$mysqli->real_escape_string($_POST['total_result'])."',
				penalty = '".$mysqli->real_escape_string($panalty_amount)."',
				recharge_days = '".$mysqli->real_escape_string($recharge_days)."',
				card_p_amount = '".$mysqli->real_escape_string($card_p_amount)."',
				rent_status = 'Paid',
				payment_pattern = '".$mysqli->real_escape_string($_POST['payment_pattern'])."',
				notification_member = '1',
				notification_loby = '1',
				payment_method = '".$mysqli->real_escape_string($payment_method)."',
				data_one = '".$mysqli->real_escape_string($data_one)."',
				data_two = '".$mysqli->real_escape_string($transaction_idO)."',
				data_three = '".$mysqli->real_escape_string($renew)."',
				remarks = '".$mysqli->real_escape_string($_POST['remarks'])."',
				uploader_info = '".$mysqli->real_escape_string($uploader_info)."',
				data = '".$mysqli->real_escape_string(date('d/m/Y'))."',
				dis_aamt = '".$mysqli->real_escape_string($dis_aamt)."',
				discount_pattern = '".$mysqli->real_escape_string($_UPDATE_DPATTERN)."',
				discount_money = '".$mysqli->real_escape_string($_DISCOUNT_MONEY)."'
				where booking_id = '".$member_info['booking_id']."' and month_name = '".$rent_infoi['month_name']."' AND data LIKE '%$year%'
			";	
		}else{
			$rent_insert_data = "insert into rent_info values(
				'',
				'".$mysqli->real_escape_string($member_info['booking_id'])."',
				'".$mysqli->real_escape_string($member_info['branch_id'])."',
				'".$mysqli->real_escape_string($member_info['branch_name'])."',
				'".$mysqli->real_escape_string($booking_info['checkin_date'])."',
				'".$mysqli->real_escape_string($checkout_date)."',
				'".$mysqli->real_escape_string($booking_info['package_category'])."',
				'".$mysqli->real_escape_string($booking_info['package_category_name'])."',
				'".$mysqli->real_escape_string($package)."',
				'".$mysqli->real_escape_string($package_name)."',
				'".$mysqli->real_escape_string($booking_info['card_no'])."',
				'".$mysqli->real_escape_string($booking_info['m_name'])."',
				'".$mysqli->real_escape_string($rent_amount)."',
				'".$mysqli->real_escape_string($parking_amountt)."',
				'".$mysqli->real_escape_string($electricity_bill)."',
				'".$mysqli->real_escape_string($_POST['tea_coffee_bill'])."',
				'".$mysqli->real_escape_string($_POST['total_result'])."',
				'".$mysqli->real_escape_string($panalty_amount)."',
				'".$mysqli->real_escape_string($_POST['locker_bill'])."',
				'".$mysqli->real_escape_string($card_p_amount)."',
				'".$mysqli->real_escape_string($recharge_days)."', 
				'Paid',
				'".$mysqli->real_escape_string($_POST['payment_pattern'])."',
				'1',
				'1',			
				'".$mysqli->real_escape_string($payment_method)."',
				'".$mysqli->real_escape_string($data_one)."',
				'".$mysqli->real_escape_string($transaction_idO)."',			
				'".$mysqli->real_escape_string($renew)."',				
				'".$mysqli->real_escape_string($other_info."".$var_pen)."',
				'".$mysqli->real_escape_string($_POST['remarks'])."',
				'1',
				'".$mysqli->real_escape_string($uploader_info)."',
				'".$mysqli->real_escape_string(month_name($month))."',
				'".$mysqli->real_escape_string(date('d/m/Y'))."',
				'".$mysqli->real_escape_string($dis_aamt)."',
				'".$mysqli->real_escape_string($_UPDATE_DPATTERN)."',
				'".$mysqli->real_escape_string($_DISCOUNT_MONEY)."'
			)";			
		}
		if($_POST['past_due_amounts'] > 0){
			$mysqli->query("update rent_info set
				rent_status = 'Paid',
				payment_pattern = '1',
				payment_method = '".$mysqli->real_escape_string($payment_method)."',
				data_one = '".$mysqli->real_escape_string($data_one)."',
				data_two = '".$mysqli->real_escape_string($transaction_idO)."',
				data_three = '".$mysqli->real_escape_string($renew)."',
				remarks = '".$mysqli->real_escape_string($_POST['remarks'])."',
				uploader_info = '".$mysqli->real_escape_string($uploader_info)."'
				where booking_id = '".$member_info['booking_id']."' and rent_status = 'Due' and month_name not in ('".$rent_infoi['month_name']."')
			");
		}
		$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
		$balance = $account_info['balance'] + $_POST['total_result'];
		
		if(!empty($_POST['ipo_id'])){
			$ipo_member_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$_POST['ipo_id']."'"));
			$ipo_member_balance = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_balance where ipo_id = '".$ipo_member_info['ipo_id']."'"));
			if($_POST['discount_lavel'] == 'A'){
				if($_POST['payment_pattern'] == 0){
					$discount_lavel = 'AA';
				}else{
					$discount_lavel = 'B';
				}
			} else if($_POST['discount_lavel'] == 'AA'){
				$discount_lavel = 'B';
			} else if($_POST['discount_lavel'] == 'B'){
				if($_POST['payment_pattern'] == 0){
					$discount_lavel = 'BB';
				}else{
					$discount_lavel = 'C';
				}
			} else if($_POST['discount_lavel'] == 'BB'){
				$discount_lavel = 'C';
			} else if($_POST['discount_lavel'] == 'C'){
				if($_POST['payment_pattern'] == 0){
					$discount_lavel = 'CC';
				}else{
					$discount_lavel = 'D';
				}
			} else if($_POST['discount_lavel'] == 'CC'){
				$discount_lavel = 'D';
			} else {
				$discount_lavel = 'D';
			}
			
			if($_POST['ipo_discount_money_cal'] > 0){
				$update_ipo_member_balance = $ipo_member_balance['balance'] + (int)($_POST['ipo_commission_money_cal']);
				$mysqli->query("insert into ipo_referal_commission_logs values(
					'',
					'".$ipo_member_info['ipo_id']."',
					'".$row['booking_id']."',
					'Member Referal',
					'".$_POST['ipo_discount_condition']."',
					'".$_POST['ipo_discount_money_cal']."',
					'',
					'1',
					'".$uploader_info."',
					'".date('d/m/Y')."'
				)");
				$mysqli->query("update member_directory set ipo_discount = '".$discount_lavel."' where booking_id = '".$row['booking_id']."'");
				$mysqli->query("update ipo_member_balance set balance = '".$update_ipo_member_balance."' where ipo_id = '".$ipo_member_info['ipo_id']."'");
			}		
		}
		
		if($tea_coffee_bill > 0){
			$mysqli->query("update refreshment_item_sell set payment_status = 'Paid', data = '".date('d/m/Y')."' where buyer_id = '".$member_info['card_number']."'");
		}	
		if(
			$mysqli->query($rent_insert_data)
			AND
			$mysqli->query("update accounts set balance = '".$mysqli->real_escape_string($balance)."' where id = '1' ")
			AND
			$mysqli->query("update booking_info set available_days = '".$mysqli->real_escape_string($days_add)."' where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."' ")		
		){
			$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$mysqli->real_escape_string($member_info['branch_id'])."'"));
			if(!empty($branch['branch_phone_number'])){
				$phone_number = $branch['branch_phone_number'];
			}else{
				$phone_number = '+8809638666333';
			}
			$rent_id = mysqli_fetch_assoc($mysqli->query("SELECT * FROM rent_info WHERE booking_id = '".$member_info['booking_id']."' ORDER BY id DESC"));			
			if(sendsms($member_info['phone_number'],'Dear. '.$booking_info['m_name'].' We collect your rent Successfully, We Received Your Total Amount is BDT '.round($_POST['total_result'],2).'. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.' & For More Details Visit Here: https://www.superhomebd.com/')){ 
				$message = 'Dear, '.$booking_info['m_name'].' We collect your rent Successfully, We Received Your Total Amount is BDT '.round($_POST['total_result'],2).' & you get recharge days '.$recharge_days.'. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.' & For More Details Visit Here: https://www.superhomebd.com/';
				if(main_email('SUPER HOME MEMBER RENT COLLECTION INFORMATION',$message,'','',$member_info['email'],$booking_info['m_name'])){
					echo 'Rent Successfully Collected____0____'.$rent_id['id'].'';
				}else{
					echo 'Something Wrong In MAIL section! Rent Successfully Collected.____0____'.$rent_id['id'].'';
				}				
			}else{
				echo 'Something Wrong In SMS section! Rent Successfully Collected____0____'.$rent_id['id'].'';
			}		
		}else{
			echo 'Something wrong! please try again____1';
		}	
	}
}
?>