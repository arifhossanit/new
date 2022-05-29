<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['old_bed_id'])){
$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_bed_shifting_id']."'"));
if($mem_info['bed_id'] != $_POST['old_bed_id']){
	echo 'Something wrong in member bed section in database';
}else{
	$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$_POST['new_bed_id']."'"));
	if(empty($bed_info['id'])){
		echo 'Something wrong in member bed section in database 2';
	}else{
		if(!empty($_POST['payment_method'][0])){
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
				$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$mem_info['branch_id']."'"));
			}
			$transaction_id = $bc['branch_code'].'-'.$today;

			$transaction_idO = $transaction_id;
			$payment_method = '';
			$data_one = '';
			$data_two = '';
			$data_three = '';
			$payment_details = '';
			$p_branch_id = $mem_info['branch_id'];
			$p_booking_id = $mem_info['booking_id'];
			$p_uploader_info = base64_decode($_POST['uploader_infoe']);
			$p_table = 'bed_change_info';
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
			$acunt = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
			$total_in = $acunt['balance'] + 500;
			$ac_up_info = "update accounts set
				balance = '".$total_in."'
				where id = '1'
			";
			$in_trns_info = "insert into transaction values(
				'',
				'".$transaction_idO."',
				'".$mem_info['branch_id']."',
				'".$mem_info['booking_id']."',
				'".$mem_info['full_name']."',
				'Defult',
				'Defult',
				'500',
				'".date('l, d/m/Y h:i:sa')."',
				'Credit',
				'Bed Change Account',
				'".$payment_method."',
				'".$data_one."',
				'".$data_two."',
				'".$data_three."',
				'Bed Change Money Collection',
				'1',
				'".base64_decode($_POST['uploader_infoe'])."',
				'".date('d/m/Y')."'
			)";
			$mysqli->query($ac_up_info);
			$mysqli->query($in_trns_info);
		}	

		
		$datee = explode('-',$_POST['bed_changing_date']);
		$datee = $datee[2].'/'.$datee[1].'/'.$datee[0];
		$change_bed_info = "insert into bed_change_info values(
			'',
			'".$mem_info['booking_id']."',
			'".$_POST['old_bed_id']."',
			'".$_POST['new_bed_id']."',
			'".$datee."',
			'0',
			'1',
			'".base64_decode($_POST['uploader_infoe'])."',
			'".date('d/m/Y')."'
		)";		
		$beeed_old = mysqli_fetch_assoc($mysqli->query("select * from beds WHERE id = '".$_POST['old_bed_id']."'"));
		$beeed_new = mysqli_fetch_assoc($mysqli->query("select * from beds WHERE id = '".$_POST['new_bed_id']."'"));		
		$activity_logd = "insert into activity_log values(
			'',
			'".$mem_info['branch_id']."',
			'".$mem_info['branch_name']."',
			'".base64_decode($_POST['uploader_infoe'])." is Change from ".$beeed_old['bed_name']." to ".$beeed_new['bed_name']." for Mr. ".$mem_info['full_name']." As Member And give the new Bed',
			'".base64_decode($_POST['uploader_infoe'])."',
			'".date('d/m/Y')."'
		)";

		$bed_id = $_POST['old_bed_id'];
		$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
		if($get_bed_number[0] > 1){
			$update_old_bed = "UPDATE beds SET uses = '2' WHERE id = '".$_POST['old_bed_id']."'";
		}else{
			$update_old_bed = "UPDATE beds SET uses = '0' WHERE id = '".$_POST['old_bed_id']."'";
		}		
		if(
			$mysqli->query("UPDATE beds SET uses = '".$beeed_old['uses']."' WHERE id = '".$_POST['new_bed_id']."'")
			AND
			$mysqli->query($update_old_bed)
			AND
			$mysqli->query("UPDATE member_directory SET 
				floor_id = '".$beeed_new['floor_id']."',
				floor_name = '".$beeed_new['floor_name']."',
				unit_id = '".$beeed_new['unit_id']."',
				unit_name = '".$beeed_new['unit_name']."',
				room_id = '".$beeed_new['room_id']."',
				room_name = '".$beeed_new['room_name']."',			
				bed_id = '".$beeed_new['id']."',
				bed_name = '".$beeed_new['bed_name']."'
				WHERE id = '".$mem_info['id']."'
			")
			AND
			$mysqli->query("UPDATE booking_info SET
				bed_id = '".$beeed_new['id']."',
				bed_name = '".$beeed_new['bed_name']."'
				WHERE booking_id = '".$mem_info['booking_id']."'
			")
			AND			
			$mysqli->query($change_bed_info)
			AND
			$mysqli->query($activity_logd)
		){
			//if(sendsms($mem_info['phone_number'],'Mr. '.$mem_info['full_name'].' Your Bed Successfully Change. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.')){ //, We Received Your Total Amount is BDT '.round(500,2).'
				//$message = 'Mr. '.$mem_info['full_name'].' Your Bed Successfully Change. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/  NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';	//, We Received Your Total Amount is BDT '.round(500,2).'								
				//if(main_email('SUPER HOME MEMBER Bed Change information',$message,'','',$mem_info['email'],$mem_info['full_name'])){
					echo 'Bed Change Successfeully Done.____0';
				//}else{
				//	echo 'Something Wrong In MAIL section! Bed Change Successfeully Done.____0';
				//}				
			//}else{
			//	echo 'Something Wrong In SMS section! Bed Change Successfeully Done.____0';
			//}			
		}else{			
			echo 'Something Wrong! Please Try again.____1';
		}
	}
}
}
?>