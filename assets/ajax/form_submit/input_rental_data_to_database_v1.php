<?php
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
if(isset($_POST['card_number'])){
	$booking_info = mysqli_fetch_assoc($mysqli->query("select * from booking_info where card_no = '".$_POST['card_number']."'"));
	$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$booking_info['branch_id']."'"));
	$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking_info['package']."'"));
	$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
	$rent_info = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$booking_info['booking_id']."' and month_name = '".month_name(date('m'))."' order by id desc"));
	$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$booking_info['booking_id']."'"));
	if(!empty($_POST['uploader_info'])){
		$uploader_info = rahat_decode($_POST['uploader_info']);
	}else{
		$uploader_info = '';
	}	
	if(!empty($_POST['card_number'])){
		$card_number = $_POST['card_number'];
	}else{
		$card_number = '';
	}	
	if(!empty($_POST['rent_amount_final'])){
		$rent_amount = $_POST['rent_amount_final'];
	}else{
		$rent_amount = '0';
	}	
	if(!empty($_POST['parking_amount'])){
		$parking_amount = $_POST['parking_amount'];
	}else{
		$parking_amount = '0';
	}	
	if(!empty($_POST['panalty_amount'])){
		$panalty_amount = $_POST['panalty_amount'];
	}else{
		$panalty_amount = '0';
	}		
	if(!empty($_POST['electricity_bill'])){
		$electricity_bill = $_POST['electricity_bill'];
	}else{
		$electricity_bill = '0';
	}
	if(!empty($_POST['tea_coffee_bill'])){
		$tea_coffee_bill = $_POST['tea_coffee_bill'];
	}else{
		$tea_coffee_bill = '0';
	}
	$payment_pattern = $_POST['payment_pattern'];

	//--------payment method------
	function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){
		global $mysqli;
		global $db;
		$invoice_id = mysqli_fetch_assoc($mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$table."'"));
		$inv_id = date('dmy').$invoice_id['AUTO_INCREMENT'];
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
	$p_uploader_info = $uploader_info;
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
	//--------end payment method------
	$transaction_infor = "insert into transaction values(
		'',
		'".$transaction_idO."',
		'".$mysqli->real_escape_string($member_info['branch_id'])."',
		'".$mysqli->real_escape_string($member_info['booking_id'])."',
		'".$mysqli->real_escape_string($booking_info['m_name'])."',
		'Defult',
		'Defult',
		'".$mysqli->real_escape_string($_POST['total_result'])."',
		'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
		'Credit',
		'Rental Account',			
		'".$mysqli->real_escape_string($payment_method)."',
		'".$mysqli->real_escape_string($data_one)."',
		'".$mysqli->real_escape_string($data_two)."',
		'".$mysqli->real_escape_string($data_three)."',
		'Rent Collection',
		'1',
		'".$mysqli->real_escape_string($uploader_info)."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)";
	//--payment_info	
	if(isset($_POST['soap'])){
		$soap = 'Soap: YES |';
	}else{
		$soap = 'Soap: NO |';
	}	
	if(isset($_POST['shampoo'])){
		$shampoo = 'Shampoo : YES |';
	}else{
		$shampoo = 'Shampoo : NO |';
	}	
	if(isset($_POST['tishue'])){
		$tishue = 'Tishue : YES';
	}else{
		$tishue = 'Tishue : NO';
	}	
	$other_info = $soap.$shampoo.$tishue;	
	$balance = $account_info['balance'] + $_POST['total_result'];	
	if($_POST['payment_pattern'] == '3'){
		$var_pen = ' ( This Member Got 50% Pendamic Discount! )';
	}else{
		$var_pen = '';
	}	
	if(!empty($_POST['rental_mpnth'])){
		$m_d = explode("-",$_POST['rental_mpnth']);
		if($m_d[0] > date('Y')){
			$month = $m_d[1];
		}else{
			if($m_d[1] > date('m')){
				$month = $m_d[1];
			}else{
				$month = $m_d[1];
			}			
		}	
	}else{
		$month = date('m');
	}
	if(!empty($_POST['package_extender'])){
		$data = explode('____',$_POST['package_extender']);
		$package = $data[0];
		$package_days = $data[2];		
		$date = date_create(date('Y-m-d'));
		date_add($date, date_interval_create_from_date_string($package_days.' days'));
		$set_checkOut = date_format($date, 'd/m/Y');		
		$pk_nw_in = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$package."'"));
		if($pk_nw_in['package_days'] > 28 ){
			if($payment_pattern == 1){
				$recharge_days = $pk_nw_in['package_days'];
			}else if($payment_pattern == 0){
				$recharge_days = $pk_nw_in['package_days'] / 2;
			}else if($payment_pattern == 3){
				$recharge_days = $pk_nw_in['package_days'];
			}else{
				$recharge_days = $pk_nw_in['package_days'];
			}
		}else{
			$recharge_days = $pk_nw_in['package_days'];
		}
		if($parking_amount > 0){
			$parking = " parking = '".$mysqli->real_escape_string($parking_amount)."',";
			$parking_amount = " parking_amount = '".$mysqli->real_escape_string($parking_amount)."',";
		}else{
			$parking = "";
			$parking_amount = "";
		}
		$mysqli->query("update member_directory set
			package = '".$mysqli->real_escape_string($pk_nw_in['id'])."',
			package_name = '".$mysqli->real_escape_string($pk_nw_in['package_name'])."',
			rent_amount = '".$mysqli->real_escape_string($pk_nw_in['monthly_rent'])."',
			$parking
			check_out_date = '".$mysqli->real_escape_string($set_checkOut)."'
			where booking_id = '".$mysqli->real_escape_string($booking_info['booking_id'])."'
		");
		$mysqli->query("update booking_info set
			checkout_date = '".$mysqli->real_escape_string($set_checkOut)."',
			$parking_amount
			package = '".$mysqli->real_escape_string($pk_nw_in['id'])."',
			package_name = '".$mysqli->real_escape_string($pk_nw_in['package_name'])."'
			where booking_id = '".$mysqli->real_escape_string($booking_info['booking_id'])."'
		");
		if(!empty($rent_info['month_name']) AND $rent_info['month_name'] == month_name($month) AND $rent_info['rent_status'] == 'Due'){
			$mysqli->query("update rent_info set
				package = '".$mysqli->real_escape_string($pk_nw_in['id'])."',
				package_name = '".$mysqli->real_escape_string($pk_nw_in['package_name'])."',
				$parking
				rent_amount = '".$mysqli->real_escape_string($pk_nw_in['monthly_rent'])."'
				where id = '".$mysqli->real_escape_string($rent_info['id'])."'
			");		
		}
		$days_add = (int)$booking_info['available_days'] + (int)$recharge_days;
		$renew = 'renew';
		$package = $pk_nw_in['id'];
		$package_name = $pk_nw_in['package_name'];
	}else{		
		if(empty($rent_info['id'])){
			if($package_info['try_us'] == 1){				
				if($package_info['package_days'] > 27){
					if($payment_pattern == 1){
						$recharge_days = $package_info['package_days'];						
					}else if($payment_pattern == 0){
						$recharge_days = $package_info['package_days'] / 2;
					}else if($payment_pattern == 3){
						$recharge_days = $package_info['package_days'];
					}else{
						$recharge_days = $package_info['package_days'];
					}
				}else{
					$recharge_days = $package_info['package_days'];
				}				
				$days_add = (int)$booking_info['available_days'] + (int)$recharge_days;
				$date = date_create(date('Y-m-d'));
				date_add($date, date_interval_create_from_date_string($days_add.' days'));
				$set_checkOut = date_format($date, 'd/m/Y'); 
				$mysqli->query("update member_directory set
					check_out_date = '".$mysqli->real_escape_string($set_checkOut)."'
					where booking_id = '".$mysqli->real_escape_string($booking_info['booking_id'])."'
				");
				$mysqli->query("update booking_info set
					checkout_date = '".$mysqli->real_escape_string($set_checkOut)."'
					where booking_id = '".$mysqli->real_escape_string($booking_info['booking_id'])."'
				");				
			} else {
				$number_of_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));		
				$check_in = explode("/",$booking_info['checkin_date']);
				$tt_day = $check_in[2].'-'.$check_in[1].'-'.$check_in[0];
				$t_day = explode("-",$tt_day);
				if(sprintf("%02d", $t_day[2]) == sprintf("%02d", date('d'))){		//sprintf("%02d", date('m')) //sprintf("%02d", $t_day[2])
					$recharge_days = $number_of_month - date("d");
				}else if(sprintf("%02d", $t_day[1]) == sprintf("%02d", date('m'))){
					$recharge_days = $number_of_month - date("d");				
				}else if(sprintf("%02d", $t_day[1]) > sprintf("%02d", date('m'))){
					$number_after_d = sprintf("%02d", $t_day[2]);
					$date_month = $t_day[1] + 1;
					$number_after_n = cal_days_in_month(CAL_GREGORIAN,sprintf("%02d", $date_month),$t_day[0]);
					$recharge_days = $number_after_n - $number_after_d;			
				}else if(sprintf("%02d", $t_day[0]) == sprintf("%02d", date('Y'))){
					$number_after_d = sprintf("%02d", $t_day[2]);
					$date_month = $t_day[1] + 1;
					$number_after_n = cal_days_in_month(CAL_GREGORIAN,sprintf("%02d", $date_month),$t_day[0]);
					$recharge_days = $number_after_n - $number_after_d;			
				}else if(sprintf("%02d", $t_day[0]) > sprintf("%02d", date('Y'))){
					$number_after_d = sprintf("%02d", $t_day[2]);
					$number_after_m = sprintf("%02d", $t_day[1]);
					$number_after_y = $t_day[0];
					$date_year = $number_after_y + 1;
					$number_after_n = cal_days_in_month(CAL_GREGORIAN,sprintf("%02d", $number_after_m),sprintf("%02d", $date_year));
					$recharge_days = $number_after_n - $number_after_d;
				}else{
					$recharge_days = $number_of_month - date("d");			
				}
				$days_add = (int)$booking_info['available_days'] + (int)$recharge_days;
				$renew = $data_three;
			}		
		}else{
			if($package_info['try_us'] == 1){				
				if($package_info['package_days'] > 27){
					if($payment_pattern == 1){
						$check_rent = mysqli_fetch_assoc($mysqli->query("select count(*) from rent where booking_id = '".$booking_info['booking_id']."' order by id desc"));
						if($check_rent[0] >= 1 ){
							$recharge_days = $package_info['package_days'] / 2;
						}else{
							$recharge_days = $package_info['package_days'];
						}						
					}else if($payment_pattern == 0){
						$recharge_days = $package_info['package_days'] / 2;
					}else if($payment_pattern == 3){
						$recharge_days = $package_info['package_days'];
					}else{
						$recharge_days = $package_info['package_days'];
					}
				}else{
					$recharge_days = $package_info['package_days'];
				}			
				$days_add = (int)$booking_info['available_days'] + (int)$recharge_days;
				$date = date_create(date('Y-m-d'));
				date_add($date, date_interval_create_from_date_string($days_add.' days'));
				$set_checkOut = date_format($date, 'd/m/Y'); 
				$mysqli->query("update member_directory set
					check_out_date = '".$mysqli->real_escape_string($set_checkOut)."'
					where booking_id = '".$mysqli->real_escape_string($booking_info['booking_id'])."'
				");
				$mysqli->query("update booking_info set
					checkout_date = '".$mysqli->real_escape_string($set_checkOut)."'
					where booking_id = '".$mysqli->real_escape_string($booking_info['booking_id'])."'
				");				
			}else{				
				if($payment_pattern == 1){
					$check_rent = mysqli_fetch_assoc($mysqli->query("select count(*) from rent where booking_id = '".$booking_info['booking_id']."' AND month_name = '".month_name(date('m'))."' order by id desc"));
					if($check_rent[0] >= 1 ){
						$recharge_days = $package_info['package_days'] / 2;
					}else{
						$recharge_days = $package_info['package_days'];
					}
				}else if($payment_pattern == 0){
					$recharge_days = $package_info['package_days'] / 2;
				}else if($payment_pattern == 3){
					$recharge_days = $package_info['package_days'];
				}else{
					$recharge_days = $package_info['package_days'];
				}
			}
			$days_add = (int)$booking_info['available_days'] + (int)$recharge_days;
			$renew = $data_three;
		}	
		$date = date_create(date('Y-m-d'));
		date_add($date, date_interval_create_from_date_string($days_add.' days'));
		$set_checkOut = date_format($date, 'd/m/Y'); 		
		//-------------------		
		$package = $package_info['id'];
		$package_name = $package_info['package_name'];
	}	
	$card_p_amount = $_POST['total_result'] - $_POST['total_result_c'];
	if($card_p_amount > 0){
		$card_p_amount = $_POST['total_result'] - $_POST['total_result_c'];
	}else{
		$card_p_amount = 0;
	}	
	if(!empty($_POST['disccount_money']) AND $_POST['disccount_money'] > 0){
		$check_discount = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$booking_info['booking_id']."'"));
		if(empty($check_discount['booking_id'])){
			$discount_info = "insert into discount_member values(
				'',
				'".$mysqli->real_escape_string($branch_info['branch_id'])."',
				'".$mysqli->real_escape_string($booking_info['booking_id'])."',
				'".$mysqli->real_escape_string($booking_info['package_category'])."',
				'".$mysqli->real_escape_string($package)."',
				'".$mysqli->real_escape_string($member_info['check_in_date'])."', 
				'".$mysqli->real_escape_string($_POST['disccount_money'])."',
				'".$mysqli->real_escape_string(date('d'))."',
				'".$mysqli->real_escape_string(date('m'))."',
				'".$mysqli->real_escape_string(date('Y'))."',
				'',
				'1',
				'".$mysqli->real_escape_string($uploader_info)."',
				'".$mysqli->real_escape_string(date('d/m/Y'))."'
			)";
			$mysqli->query($discount_info);
			$dis_aamt = '1';
		}else{
			$dis_aamt = '0';
		}		
	}else{
		$dis_aamt = '0';
	}
	$rent_infoi = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$member_info['booking_id']."' and month_name = '".month_name($month)."' order by id desc"));
	if(!empty($rent_infoi['booking_id']) AND $rent_infoi['month_name'] == month_name($month) AND $rent_infoi['rent_status'] == 'Due'){
		$rent_insert_data = "update rent_info set
			rent_amount = '".$mysqli->real_escape_string($rent_amount)."',			
			package = '".$mysqli->real_escape_string($package)."',
			package_name = '".$mysqli->real_escape_string($package_name)."',			
			parking = '".$mysqli->real_escape_string($parking_amount)."',
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
			data_two = '".$mysqli->real_escape_string($data_two)."',
			data_three = '".$mysqli->real_escape_string($renew)."',
			remarks = '".$mysqli->real_escape_string($_POST['remarks'])."',
			uploader_info = '".$mysqli->real_escape_string($uploader_info)."',
			data = '".$mysqli->real_escape_string(date('d/m/Y'))."',
			dis_aamt = '".$mysqli->real_escape_string($dis_aamt)."'
			where booking_id = '".$member_info['booking_id']."' and month_name = '".$rent_infoi['month_name']."'
		";	
	}else{
		$rent_insert_data = "insert into rent_info values(
			'',
			'".$mysqli->real_escape_string($booking_info['booking_id'])."',
			'".$mysqli->real_escape_string($branch_info['branch_id'])."',
			'".$mysqli->real_escape_string($branch_info['branch_name'])."',
			'".$mysqli->real_escape_string($booking_info['checkin_date'])."',
			'".$mysqli->real_escape_string($booking_info['package_category'])."',
			'".$mysqli->real_escape_string($booking_info['package_category_name'])."',
			'".$mysqli->real_escape_string($package)."',
			'".$mysqli->real_escape_string($package_name)."',
			'".$mysqli->real_escape_string($booking_info['card_no'])."',
			'".$mysqli->real_escape_string($booking_info['m_name'])."',
			'".$mysqli->real_escape_string($rent_amount)."',
			'".$mysqli->real_escape_string($parking_amount)."',
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
			'".$mysqli->real_escape_string($data_two)."',
			
			'".$mysqli->real_escape_string($renew)."',	
			
			'".$mysqli->real_escape_string($other_info."".$var_pen)."',
			'".$mysqli->real_escape_string($_POST['remarks'])."',
			'1',
			'".$mysqli->real_escape_string($uploader_info)."',
			'".$mysqli->real_escape_string(month_name($month))."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."',
			'".$mysqli->real_escape_string($dis_aamt)."'
		)";			
	}	
	$wid_mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$booking_info['booking_id']."'"));	
	$check_cencel = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where member_id = '".$wid_mem['id']."'"));
	if(!empty($check_cencel['id'])){
		$mysqli->query("update booking_info set
			status = '1'
			where booking_id = '".$wid_mem['booking_id']."'
		");
		$mysqli->query("update beds set
			uses = '3'
			where id = '".$wid_mem['bed_id']."'
		");
		$mysqli->query("delete from cencel_request 
			where member_id = '".$wid_mem['id']."'
		");
	}	
	if(
		$mysqli->query($rent_insert_data)
		AND
		$mysqli->query($transaction_infor)
		AND
		$mysqli->query("update accounts set
			balance = '".$mysqli->real_escape_string($balance)."'
			where id = '1'
		")
		AND
		$mysqli->query("update booking_info set
			available_days = '".$mysqli->real_escape_string($days_add)."'
			where booking_id = '".$mysqli->real_escape_string($booking_info['booking_id'])."'
		")		
	){
		if(sendsms($member_info['phone_number'],'Dear. '.$booking_info['m_name'].' We collect your rent Successfully, We Received Your Total Amount is BDT '.round($_POST['total_result'],2).'. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/  NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.')){ // & you get recharge days '.$days_add.'
			$message = 'Dear, '.$booking_info['m_name'].' We collect your rent Successfully, We Received Your Total Amount is BDT '.round($_POST['total_result'],2).' & you get recharge days '.$days_add.'. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/  NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';
			if(main_email('SUPER HOME MEMBER RENT COLLECTION INFORMATION',$message,'','',$member_info['email'],$booking_info['m_name'])){
				$rent_id = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$member_info['booking_id']."' order by id desc"));
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
?>