<?php
// error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_package_shifting_id'])){
$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_package_shifting_id']."'"));
$pack_cat_info = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id  = '".$_POST['package_category']."'"));
$pack_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id  = '".$_POST['package_id']."'"));
$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
	if($mem_info['status'] != 1){
		echo 'Member is not active____1';
	}else{
		//--------payment method------
		$payment_method = '';
		$data_one = '';
		$data_two = '';
		$data_three = '';
		$transaction_idO = '';

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
			$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$mem_info['branch_id']."'"));
		}
		$transaction_id = $bc['branch_code'].'-'.$today;

		/**
		 * 	Enter full amount for transaction!
		 */
		if($_POST['total_amount_with_security_rent'] > 0){
			$transaction_idO = $transaction_id;
			$payment_method = '';
			$data_one = '';
			$data_two = '';
			$data_three = '';
			$payment_details = '';
			$p_branch_id = $mem_info['branch_id'];
			$p_booking_id = $mem_info['booking_id'];
			$p_uploader_info = base64_decode($_POST['uploader_info']);
			$p_table = 'package_change_info';
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
			$mysqli->query("insert into transaction values(
				'',
				'".$mysqli->real_escape_string($transaction_idO)."',
				'".$mysqli->real_escape_string($mem_info['branch_id'])."',
				'".$mysqli->real_escape_string($mem_info['booking_id'])."',
				'".$mysqli->real_escape_string($mem_info['full_name'])."',
				'Defult',
				'Defult',
				'".$mysqli->real_escape_string($_POST['total_amount_with_security_rent'])."',
				'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
				'Credit',
				'Package Shifting Account',
				'".$mysqli->real_escape_string($payment_method)."',
				'".$mysqli->real_escape_string($data_one)."',
				'".$mysqli->real_escape_string($data_two)."',
				'".$mysqli->real_escape_string($data_three)."',
				'Package Shifting Money Collection',
				'1',
				'".$mysqli->real_escape_string(base64_decode($_POST['uploader_info']))."',
				'".$mysqli->real_escape_string(date('d/m/Y'))."'
			)");			
		}

		/**
		 * Enter into member wallet when securti deposit in less then zero.
		 * 
		 */
		if($_POST['total_amount_get'] < 0){
			$m_get_amount = $_POST['total_amount_get'] * - 1 ;
			if(!empty($m_get_amount) AND $m_get_amount > 0){
				if($mysqli->query("insert into member_wallet_logs values(
					'',
					'".$mem_info['booking_id']."',
					'insert',
					'".$m_get_amount."',
					'',
					'1',
					'".uploader_info()."',
					'".date('d/m/Y')."'
				)")){
					$mysqli->query("update balance_shpoint set balance = '".$m_get_amount."' where booking_id = '".$mem_info['booking_id']."'");
				}
			}			
		}		
		/*
		else{
			$payment_method = '';
			$data_one = '';
			$data_two = '';
			$data_three = '';
			$transaction_idO = '';
			
			$m_get_amount = $_POST['total_amount_get'] * - 1 ;
			if(!empty($m_get_amount) AND $m_get_amount > 0){
				if($mysqli->query("insert into member_wallet_logs values(
					'',
					'".$mem_info['booking_id']."',
					'insert',
					'".$m_get_amount."',
					'',
					'1',
					'".uploader_info()."',
					'".date('d/m/Y')."'
				)")){
					$mysqli->query("update balance_shpoint set balance = '".$m_get_amount."' where booking_id = '".$mem_info['booking_id']."'");
				}
			}			
		}
		*/
		
		
		
		
		
		if($mem_info['parking'] == '1'){
			$parking_a = $pack_info['parking_amount'];
			$parking = 1;
		}else{
			$parking_a = '0';
			$parking = '0';
		}
		$total_amount = $pack_info['package_price'] + $pack_info['monthly_rent'] + $parking_a;
		if(!empty($_POST['pack_new_bed_id'])){
			$beeed_old = mysqli_fetch_assoc($mysqli->query("select * from beds WHERE id = '".$_POST['pack_old_bed_id']."'"));
			$beeed_new = mysqli_fetch_assoc($mysqli->query("select * from beds WHERE id = '".$_POST['pack_new_bed_id']."'"));
			$mysqli->query("UPDATE beds SET uses = '3' WHERE id = '".$_POST['pack_new_bed_id']."'");
			$bed_id = $_POST['pack_old_bed_id'];
			$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
			if($get_bed_number[0] > 1){
				$mysqli->query("UPDATE beds SET uses = '2' WHERE id = '".$_POST['pack_old_bed_id']."'");
			}else{
				$mysqli->query("UPDATE beds SET uses = '0' WHERE id = '".$_POST['pack_old_bed_id']."'");
			}
			$member_bed = ",
				floor_id = '".$beeed_new['floor_id']."',
				floor_name = '".$beeed_new['floor_name']."',
				unit_id = '".$beeed_new['unit_id']."',
				unit_name = '".$beeed_new['unit_name']."',
				room_id = '".$beeed_new['room_id']."',
				room_name = '".$beeed_new['room_name']."',			
				bed_id = '".$beeed_new['id']."',
				bed_name = '".$beeed_new['bed_name']."'
			";
			$booking_bed = ",
				bed_id = '".$beeed_new['id']."',
				bed_name = '".$beeed_new['bed_name']."'
			";
		}else{
			$member_bed = "";
			$booking_bed = "";
		}
		$old_package_membership = mysqli_fetch_assoc($mysqli->query("SELECT try_us from packages where id = ".$_POST['old_package']));
		$checkout_member_directory = '';
		$checkout_booking_info = '';
		if($old_package_membership['try_us'] == '1' AND $pack_info['try_us'] == '0'){
			$checkout_member_directory = "check_out_date = 'Not Yet Confirm',";
			$checkout_booking_info = "checkout_date = 'Not Yet Confirm',";			
		}
		if($old_package_membership['try_us'] == '0' AND $pack_info['try_us'] == '1'){
			$checkout_member_directory = "check_out_date = '".date('d/m/Y')."',";
			$checkout_booking_info = "checkout_date = '".date('d/m/Y')."',";
		}
		$booking_info = "UPDATE booking_info set			
			package_category = '".$mysqli->real_escape_string($pack_cat_info['id'])."',
			package_category_name = '".$mysqli->real_escape_string($pack_cat_info['package_category_name'])."',
			package = '".$mysqli->real_escape_string($pack_info['id'])."',
			package_name = '".$mysqli->real_escape_string($pack_info['package_name'])."',	
			card_no = '".$mysqli->real_escape_string($_POST['card_number'])."',
			security_deposit = '".$mysqli->real_escape_string($pack_info['package_price'])."',
			rent_amount = '".$mysqli->real_escape_string($pack_info['monthly_rent'])."',
			parking_amount = '".$mysqli->real_escape_string($parking_a)."',			
			payment_method = '".$mysqli->real_escape_string($payment_method)."',
			data_one = '".$mysqli->real_escape_string($data_one)."',
			data_two = '".$mysqli->real_escape_string($transaction_idO)."',
			$checkout_booking_info
			data_three = '".$mysqli->real_escape_string($data_three)."'
			$booking_bed
			where booking_id = '".$mem_info['booking_id']."'
		";
		$get_room_type = mysqli_fetch_assoc($mysqli->query("select * from room_type where package_category = '".$pack_cat_info['id']."'"));
		$member_info = "UPDATE member_directory set
			card_number = '".$mysqli->real_escape_string($_POST['card_number'])."',
			bet_type = '".$mysqli->real_escape_string($get_room_type['room_type'])."',
			package_category = '".$mysqli->real_escape_string($pack_cat_info['id'])."',
			package = '".$mysqli->real_escape_string($pack_info['id'])."',
			package_name = '".$mysqli->real_escape_string($pack_info['package_name'])."',
			security_deposit = '".$mysqli->real_escape_string($pack_info['package_price'])."',
			rent_amount = '".$mysqli->real_escape_string($pack_info['monthly_rent'])."',
			parking = '".$mysqli->real_escape_string($parking)."',
			parking_amount = '".$mysqli->real_escape_string($parking_a)."',
			$checkout_member_directory
			total_amount = '".$mysqli->real_escape_string($total_amount)."'
			$member_bed
			where booking_id = '".$mem_info['booking_id']."'
		";
		/* 
		$rent_info = "update rent_info set
			card_no = '".$mysqli->real_escape_string($_POST['card_number'])."',
			package_category = '".$mysqli->real_escape_string($pack_cat_info['id'])."',
			package_category_name = '".$mysqli->real_escape_string($pack_cat_info['package_category_name'])."',
			package = '".$mysqli->real_escape_string($pack_info['id'])."',
			package_name = '".$mysqli->real_escape_string($pack_info['package_name'])."',
			rent_amount = '".$mysqli->real_escape_string($pack_info['monthly_rent'])."',
			parking = '".$mysqli->real_escape_string($parking)."'
			where booking_id = '".$mem_info['booking_id']."'
		"; */
		$total_in = $account_info['balance'] + $_POST['total_amount_get'];
		$acct_info = "update accounts set
			balance = '".$total_in."'
			where id = '1'
		";		
		$activity_log = "INSERT into activity_log values(
			'',
			'".$mysqli->real_escape_string($mem_info['branch_id'])."',
			'".$mysqli->real_escape_string($mem_info['branch_name'])."',
			'".$mysqli->real_escape_string($mem_info['full_name']." is Change Package by ".base64_decode($_POST['uploader_info']))."',
			'".$mysqli->real_escape_string(base64_decode($_POST['uploader_info']))."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";	
		$dat_s = explode('-',$_POST['shifting_date']);
		$dat_s = $dat_s[0].'/'.$dat_s[1].'/'.$dat_s[2];
		$package_change_info = "INSERT into package_change_info values(
			'',
			'".$mysqli->real_escape_string($mem_info['booking_id'])."',
			'".$mysqli->real_escape_string($_POST['old_category'])."',
			'".$mysqli->real_escape_string($_POST['old_package'])."',
			'".$mysqli->real_escape_string($pack_cat_info['id'])."',
			'".$mysqli->real_escape_string($pack_info['id'])."',
			'".$mysqli->real_escape_string($dat_s)."',
			'',
			'1',
			'".$mysqli->real_escape_string(base64_decode($_POST['uploader_info']))."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."',
			'".$transaction_idO."'
		)";	
		
		//$card_chaeck = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['card_number']."'"));
		//if(!empty($card_chaeck['card_number']) AND $card_chaeck['card_number'] == $_POST['card_number']){
		//	echo 'Card Number Already Exixt! Please Try again.____1';
		//}else{
			//$mysqli->query($rent_info)
			//	AND
			if(
				$mysqli->query($booking_info)
				AND
				$mysqli->query($member_info)
				AND				
				$mysqli->query($acct_info)
				AND
				$mysqli->query($activity_log)
				AND
				$mysqli->query($package_change_info)
			){
				$get_change_info_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from package_change_info"));

				/**
				 * 	For security deposit!
				 */
				if($_POST['total_amount_get'] != 0){
					$mysqli->query("INSERT INTO `package_change_transaction_info`(`transaction_category`, `amount`, `package_change_id`) VALUES ('Security Deposit Account', ".$_POST['total_amount_get'].",'".$get_change_info_id['max_id']."')");
				}

				/**
				 * 	For extra rent!
				 */
				if($_POST['extra_rent_amount'] > 0){
					$mysqli->query("INSERT INTO `package_change_transaction_info`(`transaction_category`, `amount`, `package_change_id`) VALUES ('Rental Account', ".$_POST['extra_rent_amount'].",'".$get_change_info_id['max_id']."')");
				}
				
				if($_POST['total_amount_get'] > 0){				
					$extr = 'We Received Your Total Amount is BDT '.round($_POST['total_amount_get'],2).'';
				}else{
					$extr = '';
				}
				if(sendsms($mem_info['phone_number'],'Dear '.$mem_info['full_name'].' Your Package Successfully Change, '.$extr.' Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.')){ // 
					$message = 'Mr. '.$mem_info['full_name'].' Your Package Successfully Change, Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';		// We Received Your Total Amount is BDT '.round($_POST['total_amount_get'],2).'.							
					if(main_email('SUPER HOME MEMBER Package Change information',$message,'','',$mem_info['email'],$mem_info['full_name'])){
						echo 'Package Change Successfeully Done.____0____'.$get_change_info_id['max_id'];
					}else{
						echo 'Something Wrong In MAIL section! Package Change Successfeully Done.____0____'.$get_change_info_id['max_id'];
					}				
				}else{
					echo 'Something Wrong In SMS section! Package Change Successfeully Done.____0____'.$get_change_info_id['max_id'];
				}		
			}else{			
				echo 'Something Wrong! Please Try again.____1';
			}
		//}		
	}
}
?>