<?php
include("../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
if(isset($_POST['full_name'])){
	$booking_id = date('d_m_Y__h_i_s_A').'_'.rand().'_'.rand() * time();
	$generated_password = spc_chr_mm(8);
	$full_name = $_POST['full_name'];
	$email = $_POST['email'];
	$phone_number = $_POST['phone_number'];
	$occupation = $_POST['occupation'];
	$religion = $_POST['religion'];
	$h_t_f_u = $_POST['h_t_f_u'];
	if(!empty($_POST['referance_id'])){
		$referance_id = $_POST['referance_id'];
	}else{
		$referance_id = '';
	}
	if(!empty($_POST['photo_avater'])){
		$photo_avater = $_POST['photo_avater'];
	}else{
		$photo_avater = '';
	}
	$father_name = $_POST['father_name'];
	$mother_name = $_POST['mother_name'];
	$emergency_number_1 = $_POST['emergency_number_1'];
	if(!empty($_POST['emergency_number_2'])){
		$emergency_number_2 = $_POST['emergency_number_2'];
	}else{
		$emergency_number_2 = '';
	}
	$address = $_POST['address'];
	if(!empty($_POST['remarks'])){
		$remarks = $_POST['remarks'];
	}else{
		$remarks = '';
	}
	
	$vaccinated = false;	
	
	//if(!empty($_POST['document_upload_again'])){
		//$doc_num = '';
		//$doc_typ = $_POST['document_type_again'];
		//$doc_upl = $_POST['document_upload_again'];
	//}else{
		$doc_num = '';
		$doc_typ = '';
		$doc_upl = '';
		foreach($_POST['document_type'] as $row => $value){
			if($_POST['document_type'][$row] == 'Vaccine Card'){
				$mysqli->query("INSERT INTO member_vaccinated (booking_id) value ('$booking_id')");
			}
			$doc_num .= $_POST['document_number'][$row].',';
			$doc_typ .= $_POST['document_type'][$row].',';
			$doc_upl .= $_POST['document_upload'][$row].',';
		}
	//}
	
	
	
	$branch_id = $_POST['branch_id'];	
	$uploader_info = $_POST['uploader_info'];	
	$package_category = $_POST['package_category'];
	
	
	$checkin_date = explode("-",$_POST['checkin_date']);	
	$checkin_date_m = $checkin_date[2].'/'.$checkin_date[1].'/'.$checkin_date[0];
	
	
	$try_us_condition_check = $_POST['try_us_condition_check'];
	$try_us_days = $_POST['try_us_days'];
	$package = $_POST['package'];
	$vicle_parking = $_POST['vicle_parking'];
	$bet_type = $_POST['bet_type'];
	$bed_id_script = $_POST['bed_id_script'];
	$selected_bed = $_POST['selected_bed'];
	$booking_date = $_POST['booking_date'];	
	
	$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$branch_id."'"));
	$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$bed_id_script."'"));
	$floor_info = mysqli_fetch_assoc($mysqli->query("select * from floors where id = '".$bed_info['floor_id']."'"));
	$unit_info = mysqli_fetch_assoc($mysqli->query("select * from units where id = '".$bed_info['unit_id']."'"));
	$room_info = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$bed_info['room_id']."'"));
	$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$package."'"));
	$pack_cat_info = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$package_category."'"));
	$account_info = mysqli_fetch_assoc($mysqli->query("select * from accounts where id = '1'"));
	
	if($try_us_condition_check == '1'){
		if($package_info['aggreement'] == '1'){
			$check_out_date_mmd = explode("-",$_POST['check_out_date']); 
			$pao = $check_out_date_mmd[0].'/'.$check_out_date_mmd[1].'/'.$check_out_date_mmd[2];
			if($package_info['sub_category_id'] == '12' ){
				$ag_days = '360';
			} else if ($package_info['sub_category_id'] == '13' ){
				$ag_days = '180';
			} else if ($package_info['sub_category_id'] == '14' ){
				$ag_days = '90';
			}
			
			if(isset($_POST['late_night_checkin'])){
				$ag_days = $ag_days - 1;
			}else{
				$r_minute = date('i');
				$r_hour = date('h');
				$r_apm = date('a');
				$hm = $r_hour.$r_minute;
				if($hm >= '0001' AND $hm <= '0400' AND $r_apm == 'am'){
					$ag_days = $ag_days - 1;
				}else{
					$ag_days = $ag_days;
				}
			}
			
			$check_out_date = date('d/m/Y', strtotime($pao));
			//$check_out_date = $_POST['check_out_date'];
		}else{
			if(isset($_POST['late_night_checkin'])){
				if($_POST['check_out_date'] == 'Not Confirm Yet'){
					$check_out_date = $_POST['check_out_date'];
				}else{
					$check_out_date_mmd = explode("-",$_POST['check_out_date']);
					$check_out_date1 = $check_out_date_mmd[0].'/'.$check_out_date_mmd[1].'/'.$check_out_date_mmd[2];
					$check_out_date = date("d/m/Y",strtotime('-1 days',strtotime($_POST['check_out_date'])));
				}
				
				
				//$check_out_date = $_POST['check_out_date'];
				
				/* $check_out_date_mmd = date('Y-m-d', strtotime($_POST['check_out_date']. ' - 1 days'));
				 $check_out_date = $check_out_date_mmd[2].'/'.$check_out_date_mmd[1].'/'.$check_out_date_mmd[0]; */
			}else{
				$r_minute = date('i');
				$r_hour = date('h');
				$r_apm = date('a');
				$hm = $r_hour.$r_minute;
				if($hm >= '0001' AND $hm <= '0400' AND $r_apm == 'am'){
					$check_out_date_mmd = explode("-",$_POST['check_out_date']);
					$check_out_date1 = $check_out_date_mmd[0].'/'.$check_out_date_mmd[1].'/'.$check_out_date_mmd[2];
					$check_out_date = date("d/m/Y",strtotime('-1 days',strtotime($_POST['check_out_date'])));
				}else{
					$check_out_date_mmd = explode("-",$_POST['check_out_date']);
					$check_out_date = $check_out_date_mmd[2].'/'.$check_out_date_mmd[1].'/'.$check_out_date_mmd[0];
				}
				
			}		
		}		
	}else{
		if(isset($_POST['late_night_checkin'])){
			$check_out_date = date('Y-m-d', strtotime($_POST['check_out_date']. ' - 1 days'));
		}else{
			$r_minute = date('i');
			$r_hour = date('h');
			$r_apm = date('a');
			$hm = $r_hour.$r_minute;
			if($hm >= '0001' AND $hm <= '0400' AND $r_apm == 'am'){
				$check_out_date = date('Y-m-d', strtotime($_POST['check_out_date']. ' - 1 days'));
			}else{
				$check_out_date = $_POST['check_out_date'];
			}			
			//$check_out_date_mmd = explode("-",$_POST['check_out_date']);
			//$check_out_date = $check_out_date_mmd[2].'/'.$check_out_date_mmd[1].'/'.$check_out_date_mmd[0];
		}		
	}
	
	$security_deposit = $_POST['security_deposit'];
	$security_money = $_POST['security_money'];
	$total_amount_get = (float)$_POST['booking_total_amount_c'];
	
	if($bed_info['uses'] == '2' ){
		if(!empty($_POST['card_number'])){
			$card_number = $_POST['card_number'];
		}else{
			$card_number = 'Unauthorized';
		}
		$bed_status = '2';
	}else{
		if(!empty($_POST['card_number'])){
			$card_number = $_POST['card_number'];
			$bed_status = '3';
		}else{
			$card_number = 'Unauthorized';
			$bed_status = '2';
		}
	}
	
	$rent_amount_show = $_POST['rent_amount_show'];
	$rent_amount_get = $_POST['rent_amount'];
	$parking_amount_show = $_POST['parking_amount'];
	if($_POST['vicle_parking'] == '1'){
		$parking_type = '1';
		$parking_amount_get = $_POST['parking_value'];
	}else{
		$parking_type = '0';
		$parking_amount_get = '';
	}	

	//--------locker	
	if(!empty($_POST['locker_ids'])){
		$locker = $_POST['locker_ids'];
	}else{
		$locker = '0';
	}if(!empty($_POST['locker_value'])){
		$locker_amount = $_POST['locker_value'];
	}else{
		$locker_amount = '0';
	}if(!empty($_POST['locker_qty'])){
		$locker_qty = $_POST['locker_qty'];
	}else{
		$locker_qty = '0';
	}

	$email = $_POST['email'];
	$phone_number = $_POST['phone_number'];
	$nid = $_POST['mother_name'];
	$todays_date = date('d/m/Y');
	$if_already_exist = mysqli_fetch_assoc($mysqli->query("select count(id) as howMany from member_directory where (phone_number = '".$phone_number."' or mother_name = '".$nid."' or email = '".$email."') and data = '".$todays_date."' "));
	
	if($if_already_exist['howMany'] != 0){
		return;
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
		echo "<script>window.open('".$home."admin/booking','_top')</script>";
		exit;
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
	$p_uploader_info = base64_decode($uploader_info);
	$p_table = 'booking_info';

	$booking_total_amount = (float)$_POST['booking_total_amount_c'];

	$booking_security_amount = (float)$_POST['booking_security_amount'];
	
	if($package_info['aggreement'] == 1){
		if(isset($_POST['force_rent'])){					
			$allow_s_backa = 1;
		}else{		
			if($card_number != 'Unauthorized'){					
				if($_POST['payment_pattern'] == 1 OR $_POST['payment_pattern'] == 0 ){					
					$allow_s_backa = 1;
				}else if($_POST['payment_pattern'] == 2){					
					$allow_s_backa = 0;
				}
			}
		}
		if($allow_s_backa == 1){
			$booking_security_amount = (float)$_POST['booking_security_amount'] - 1000;
		}else{
			$booking_security_amount = (float)$_POST['booking_security_amount'];
		}		
	}
	
	$d_exixt_check = mysqli_fetch_assoc($mysqli->query("select email from member_directory where email = '".$email."'"));
	if(!empty($d_exixt_check['email']) AND $d_exixt_check['email'] == $email AND $email != 'no_email@superhome.com' AND !empty($_POST['re_book_check']) AND $_POST['re_book_check'] == '0'){	// edit by rayhan (24/04/2021) found error on rebook post
		echo 'Email allready Exixt! Please try again.____1';		
	}else{
		$d_exixt_phnex = mysqli_fetch_assoc($mysqli->query("select phone_number from member_directory where phone_number = '".$phone_number."'"));
		if(!empty($d_exixt_phnex['phone_number']) AND $d_exixt_phnex['phone_number'] == $phone_number AND !empty($_POST['re_book_check']) AND $_POST['re_book_check'] == '0'){  // edit by rayhan (24/04/2021) found error on rebook post
			echo 'Phone Number allready Exixt! Please try again.____1';	
		}else{		
			if(!empty($_POST['card_number'])){
				$d_exixt_cardex = mysqli_fetch_assoc($mysqli->query("select card_number from member_directory where card_number = '".$_POST['card_number']."'"));
				if(!empty($d_exixt_cardex['card_number']) AND $d_exixt_cardex['card_number'] == $_POST['card_number']){
					$card_check_reprt = 1;
				}else{
					$card_check_reprt = 0;
				}
				/*
				if($try_us_condition_check == '1'){
					$d_exixt_cardex = mysqli_fetch_assoc($mysqli->query("select card_number, booking_id from member_directory where card_number = '".$_POST['card_number']."'"));
					if(!empty($d_exixt_cardex['card_number']) AND $d_exixt_cardex['card_number'] == $_POST['card_number']){
						$new_card_number = time();
						if(
							$mysqli->query("update member_directory set card_number = '".$new_card_number."' where booking_id = '".$d_exixt_cardex['booking_id']."'") AND
							$mysqli->query("update booking_info set card_no = '".$new_card_number."' where booking_id = '".$d_exixt_cardex['booking_id']."'") AND						
							$mysqli->query("update rent_info set card_no = '".$new_card_number."' where booking_id = '".$d_exixt_cardex['booking_id']."'")
						){
							$card_check_reprt = '0';
						}else{
							$card_check_reprt = '1';
						}					
					}else{
						$card_check_reprt = '0';
					}					
				}else{
					
				}
				
				*/	
			}else{
				$card_check_reprt = 0;
			}
			if($card_check_reprt == 1){
				echo 'Card Number allready Exixt! Please try again.____1';	
			}else{
				$member_count_check = mysqli_fetch_assoc(
					$mysqli->query("select * from member_directory where 
						check_out_date = '".date('d/m/Y')."' AND						
						phone_number like '%".$phone_number."%'
					")
				);
				if(!empty($member_count_check['id'])){
					$count_reword = '1';
				}else{
					$count_reword = '';
				}
				
				//--------------------------
				if($package_info['try_us'] == '1' ){
					$avaible_Days = $package_info['package_days'];
				}else{							
					$t_day = explode("-",$_POST['checkin_date']);
					$number_of_month = cal_days_in_month(CAL_GREGORIAN,$t_day[1],$t_day[0]);
					$avaible_Days = $number_of_month - $t_day[2] + 1;					
				}
				
				if(!empty($_POST['booking_parking_amount']) AND $_POST['booking_parking_amount'] > 0){
					$booking_parking_amount = $_POST['booking_parking_amount'];
				}else{
					if($package_info['try_us'] == '1' ){
						$pkg_pr_w_amn = $package_info['monthly_rent'] / $package_info['package_days'];;
					}else{
						$t_day = explode("-",$_POST['checkin_date']);
						$number_of_month = cal_days_in_month(CAL_GREGORIAN,$t_day[1],$t_day[0]);
						$pkg_pr_w_amn = $package_info['monthly_rent'] / $number_of_month;
					}
					$booking_parking_amount = $pkg_pr_w_amn * $avaible_Days;
				}
				
				if(!empty($_POST['booking_rent_amount']) AND $_POST['booking_rent_amount'] > 0){
					$booking_rent_amount = $_POST['booking_rent_amount'];
				}else{
					if($package_info['try_us'] == '1' ){
						$pkg_re_w_amn = $package_info['monthly_rent'] / $package_info['package_days'];;
					}else{
						$t_day = explode("-",$_POST['checkin_date']);
						$number_of_month = cal_days_in_month(CAL_GREGORIAN,$t_day[1],$t_day[0]);
						$pkg_re_w_amn = $package_info['monthly_rent'] / $number_of_month;
					}				
					$booking_rent_amount = $pkg_re_w_amn * $avaible_Days;
				}	
				//--------------------------
								
				
				$card_p_amount = $_POST['booking_total_amount'] - $_POST['booking_total_amount_c'];				
				if($card_p_amount > 0 ){
					$card_p_amount = $_POST['booking_total_amount'] - $_POST['booking_total_amount_c'];
				}else{
					$card_p_amount = 0;
				}
				
				if($_POST['payment_pattern'] == '1'){
					$payment_pattern = '1';
					$avaible_Days = $avaible_Days;
				}else if($_POST['payment_pattern'] == '2'){
					$payment_pattern = '2';
					$avaible_Days = 0;
				}else if($_POST['payment_pattern'] == '0'){
					$payment_pattern = '0';
					$booking_parking_amount = 0;
					$avaible_Days = $avaible_Days / 2;
					$booking_total_amount = $booking_total_amount - $booking_rent_amount;
				}
				
				
				
				if(isset($_POST['late_night_checkin'])){
					$avaible_Days = $avaible_Days - 1;
				}
				
				if(isset($_POST['force_rent'])){
					
				}else{
					if($card_number == 'Unauthorized'){
						$avaible_Days = 0;
					}
				}
				
				
				if($_POST['vicle_parking'] == '1'){
					$parking_rdb_amount = $booking_parking_amount;
				}else{
					$parking_rdb_amount = '';
				}
				
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
				$transaction_information = "insert into transaction values(
					'',
					'".$transaction_idO."',
					'".$mysqli->real_escape_string($branch_id)."',
					'".$mysqli->real_escape_string($booking_id)."',
					'".$mysqli->real_escape_string($full_name)."',
					'Defult',
					'Defult',
					'".$mysqli->real_escape_string((float)$_POST['booking_total_amount_c'])."',
					'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
					'Credit',
					'Booking Account',
					'".$mysqli->real_escape_string($payment_method)."',
					'".$mysqli->real_escape_string($data_one)."',
					'".$mysqli->real_escape_string($data_two)."',
					'".$mysqli->real_escape_string($data_three)."',
					'Booking Money Collection',
					'1',
					'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."'
				)";	
				
				if(!empty($referance_id)){
					$check_share_holder = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where card_number = '".$referance_id."'"));
					if(!empty($check_share_holder)){
						if($package_info['try_us'] == '1' ){ 
							$ipo_discount = 'NaN';
						}else{
							$mysqli->query("insert into ipo_referal_approval values(
								'',
								'".$check_share_holder['ipo_id']."',
								'".$booking_id."',
								'0',
								'',
								'".$full_name." is refered you. If you wnow him/her ten you can approve.',
								'1',
								'".uploader_info()."',
								'".date('d/m/Y')."'
							)");
							$ipo_discount = 'Start';
						}
					}else{
						$ipo_discount = 'NaN';
					}
				}else{
					$ipo_discount = 'NaN';
				}
				
				$member_directory = "insert into member_directory values(
					'',
					'".$mysqli->real_escape_string($booking_id)."',
					'".$mysqli->real_escape_string($branch_id)."',
					'".$mysqli->real_escape_string($branch_info['branch_name'])."',
					'".$mysqli->real_escape_string($floor_info['id'])."',
					'".$mysqli->real_escape_string($floor_info['floor_name'])."',
					'".$mysqli->real_escape_string($unit_info['id'])."',
					'".$mysqli->real_escape_string($unit_info['unit_name'])."',
					'".$mysqli->real_escape_string($room_info['id'])."',
					'".$mysqli->real_escape_string($room_info['room_name'])."',
					'".$mysqli->real_escape_string($bed_info['id'])."',
					'".$mysqli->real_escape_string($bed_info['bed_name'])."',
					'".$mysqli->real_escape_string($full_name)."',
					'".$mysqli->real_escape_string($email)."',
					'".$mysqli->real_escape_string($generated_password)."',
					'".$mysqli->real_escape_string($phone_number)."',
					'".$mysqli->real_escape_string($_POST['id_card'])."',
					'".$mysqli->real_escape_string($occupation)."',
					'".$mysqli->real_escape_string($religion)."',
					'".$mysqli->real_escape_string($remarks)."',
					'".$mysqli->real_escape_string($h_t_f_u)."',
					'".$mysqli->real_escape_string($referance_id)."',
					'".$mysqli->real_escape_string($father_name)."',
					'".$mysqli->real_escape_string($mother_name)."',
					'".$mysqli->real_escape_string($emergency_number_1)."',
					'".$mysqli->real_escape_string($emergency_number_2)."',
					'".$mysqli->real_escape_string($photo_avater)."',
					'".$mysqli->real_escape_string($address)."',
					'".$mysqli->real_escape_string($doc_num)."',
					'".$mysqli->real_escape_string($doc_typ)."',
					'".$mysqli->real_escape_string($doc_upl)."',
					'".$mysqli->real_escape_string($booking_date)."',
					'".$mysqli->real_escape_string($checkin_date_m)."',
					'".$mysqli->real_escape_string($card_number)."',
					'".$mysqli->real_escape_string($package_category)."',
					'".$mysqli->real_escape_string($package_info['id'])."',
					'".$mysqli->real_escape_string($package_info['package_name'])."',
					'".$mysqli->real_escape_string($check_out_date)."',
					'".$mysqli->real_escape_string($bet_type)."',
					'".$mysqli->real_escape_string($booking_security_amount)."',
					'".$mysqli->real_escape_string($rent_amount_get)."',
					'".$mysqli->real_escape_string($parking_type)."',
					'".$mysqli->real_escape_string($_POST['booking_parking_amount'])."',		
					'".$mysqli->real_escape_string($locker)."',
					'".$mysqli->real_escape_string($locker_qty)."',
					'".$mysqli->real_escape_string($locker_amount)."',
					'".$mysqli->real_escape_string($total_amount_get)."',
					'',
					'1',
					'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."',
					'".$mysqli->real_escape_string($_POST['member_type'])."',
					'".$mysqli->real_escape_string($ipo_discount)."'
				)";				
				
				if($locker_qty > 0){
					$locker = explode(',',$locker);
					foreach($locker as $low){
						$mysqli->query("update manage_locker set uses = '3' where id = '".$low."'");
					}					
				}
				if(!empty($_POST['disccount_money']) AND $_POST['disccount_money'] > 0){			
					if($_POST['member_type'] == 'GROUP'){
						$discount_amount = $package_info['group_discount_amount'];
					}else{
						$discount_amount = $package_info['discount_amount'];
					}
					
					//==========================discount---------------
					$_MEMBER_DISCOUNT = 'YES';
					
					$cash_back_amount = $_POST['disccount_money'];
					$dis_aamt = '1';
				}else{
					$_MEMBER_DISCOUNT = 'NO';
					$cash_back_amount = '0';
					$dis_aamt = '0';
				}			
				
				if(!empty($_POST['ac_rent_amount_1']) AND $_POST['ac_rent_amount_1'] > 0){
					$ac_rent_amount_1 = $_POST['ac_rent_amount_1'];
				}else{
					$ac_rent_amount_1 = 0;
				}				
				
				
				
				if(isset($_POST['force_rent'])){
					if(!empty($_POST['disccount_money']) AND $_POST['disccount_money'] > 0){
						if($booking_rent_amount > $discount_amount){
							if($_POST['payment_pattern'] == 0){
								$_RENT_DIS_PATTERN = 'A';
								$discount_money_rent = $_POST['disccount_money'] / 2;
							}elseif($_POST['payment_pattern'] == 1){
								$_RENT_DIS_PATTERN = 'B';
								$discount_money_rent = 0;
							}else{
								$_RENT_DIS_PATTERN = 'YES';
								$discount_money_rent = 0;
							}						
						}else{
							$_RENT_DIS_PATTERN = 'YES';
							$discount_money_rent = 0;
						}
					}else{
						$_RENT_DIS_PATTERN = 'NO';
						$discount_money_rent = 0;
					}
					$rent_information = "insert into rent_info values(
						'',
						'".$mysqli->real_escape_string($booking_id)."',
						'".$mysqli->real_escape_string($branch_id)."',
						'".$mysqli->real_escape_string($branch_info['branch_name'])."',
						'".$mysqli->real_escape_string($checkin_date_m)."',
						'".$mysqli->real_escape_string($check_out_date)."',
						'".$mysqli->real_escape_string($pack_cat_info['id'])."',
						'".$mysqli->real_escape_string($pack_cat_info['package_category_name'])."',
						'".$mysqli->real_escape_string($package_info['id'])."',
						'".$mysqli->real_escape_string($package_info['package_name'])."',
						'".$mysqli->real_escape_string($card_number)."',
						'".$mysqli->real_escape_string($full_name)."',
						'".$mysqli->real_escape_string($ac_rent_amount_1)."',
						'".$mysqli->real_escape_string($_POST['booking_parking_amount'])."',
						'0',
						'0',
						'".$mysqli->real_escape_string($booking_total_amount)."',
						'0',
						'".$mysqli->real_escape_string($locker_amount)."',
						'".$mysqli->real_escape_string($card_p_amount)."',
						'".$mysqli->real_escape_string($avaible_Days)."',
						'Paid',
						'".$mysqli->real_escape_string($payment_pattern)."',
						'1',
						'1',
						'".$mysqli->real_escape_string($payment_method)."',
						'".$mysqli->real_escape_string($data_one)."',
						'".$mysqli->real_escape_string($transaction_idO)."',
						'".$mysqli->real_escape_string($data_three)."',
						'booking',
						'',
						'1',
						'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
						'".$mysqli->real_escape_string(month_name(date('m')))."',
						'".$mysqli->real_escape_string(date('d/m/Y'))."',
						'".$mysqli->real_escape_string($dis_aamt)."',
						'".$mysqli->real_escape_string($_RENT_DIS_PATTERN)."',
						'".$mysqli->real_escape_string($discount_money_rent)."'
					)";
					$mysqli->query($rent_information);
					$allow_s_back = 1;
					$_GET_DISCOUNT_NOW = 'YES';
				}else{				
					 if($card_number != 'Unauthorized'){
						if($_POST['payment_pattern'] == 1 OR $_POST['payment_pattern'] == 0 ){
							if(!empty($_POST['disccount_money']) AND $_POST['disccount_money'] > 0){
								if($booking_rent_amount > $discount_amount){
									if($_POST['payment_pattern'] == 0){
										$_RENT_DIS_PATTERN = 'A';
										$discount_money_rent = $_POST['disccount_money'] / 2;
									}elseif($_POST['payment_pattern'] == 1){
										$_RENT_DIS_PATTERN = 'B';
										$discount_money_rent = 0;
									}else{
										$_RENT_DIS_PATTERN = 'YES';
										$discount_money_rent = 0;
									}						
								}else{
									$_RENT_DIS_PATTERN = 'YES';
									$discount_money_rent = 0;
								}
							}else{
								$_RENT_DIS_PATTERN = 'NO';
								$discount_money_rent = 0;
							}
							$rent_information = "insert into rent_info values(
								'',
								'".$mysqli->real_escape_string($booking_id)."',
								'".$mysqli->real_escape_string($branch_id)."',
								'".$mysqli->real_escape_string($branch_info['branch_name'])."',
								'".$mysqli->real_escape_string($checkin_date_m)."',
								'".$mysqli->real_escape_string($check_out_date)."',
								'".$mysqli->real_escape_string($pack_cat_info['id'])."',
								'".$mysqli->real_escape_string($pack_cat_info['package_category_name'])."',
								'".$mysqli->real_escape_string($package_info['id'])."',
								'".$mysqli->real_escape_string($package_info['package_name'])."',
								'".$mysqli->real_escape_string($card_number)."',
								'".$mysqli->real_escape_string($full_name)."',
								'".$mysqli->real_escape_string($ac_rent_amount_1)."',
								'".$mysqli->real_escape_string($_POST['booking_parking_amount'])."',
								'0',
								'0',
								'".$mysqli->real_escape_string($booking_total_amount)."',
								'0',
								'".$mysqli->real_escape_string($locker_amount)."',
								'".$mysqli->real_escape_string($card_p_amount)."',
								'".$mysqli->real_escape_string($avaible_Days)."',
								'Paid',
								'".$mysqli->real_escape_string($payment_pattern)."',
								'1',
								'1',
								'".$mysqli->real_escape_string($payment_method)."',
								'".$mysqli->real_escape_string($data_one)."',
								'".$mysqli->real_escape_string($transaction_idO)."',
								'".$mysqli->real_escape_string($data_three)."',
								'booking',
								'',
								'1',
								'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
								'".$mysqli->real_escape_string(month_name(date('m')))."',
								'".$mysqli->real_escape_string(date('d/m/Y'))."',
								'".$mysqli->real_escape_string($dis_aamt)."',
								'".$mysqli->real_escape_string($_RENT_DIS_PATTERN)."',
								'".$mysqli->real_escape_string($discount_money_rent)."'
							)";
							$mysqli->query($rent_information);
							$allow_s_back = 1;
							$_GET_DISCOUNT_NOW = 'YES';
						}else if($_POST['payment_pattern'] == 2){
							if(!empty($_POST['disccount_money']) AND $_POST['disccount_money'] > 0){
								if($booking_rent_amount > $discount_amount){
									if($_POST['payment_pattern'] == 0){
										$_RENT_DIS_PATTERN = 'A';
										$discount_money_rent = $_POST['disccount_money'] / 2;
									}elseif($_POST['payment_pattern'] == 1){
										$_RENT_DIS_PATTERN = 'B';
										$discount_money_rent = 0;
									}else{
										$_RENT_DIS_PATTERN = 'YES';
										$discount_money_rent = 0;
									}						
								}else{
									$_RENT_DIS_PATTERN = 'YES';
									$discount_money_rent = 0;
								}
							}else{
								$_RENT_DIS_PATTERN = 'NO';
								$discount_money_rent = 0;
							}
							$rent_information = "insert into rent_info values(
								'',
								'".$mysqli->real_escape_string($booking_id)."',
								'".$mysqli->real_escape_string($branch_id)."',
								'".$mysqli->real_escape_string($branch_info['branch_name'])."',
								'".$mysqli->real_escape_string($checkin_date_m)."',
								'".$mysqli->real_escape_string($check_out_date)."',
								'".$mysqli->real_escape_string($pack_cat_info['id'])."',
								'".$mysqli->real_escape_string($pack_cat_info['package_category_name'])."',
								'".$mysqli->real_escape_string($package_info['id'])."',
								'".$mysqli->real_escape_string($package_info['package_name'])."',
								'".$mysqli->real_escape_string($card_number)."',
								'".$mysqli->real_escape_string($full_name)."',
								'".$mysqli->real_escape_string($ac_rent_amount_1)."',
								'".$mysqli->real_escape_string($_POST['booking_parking_amount'])."',
								'0',
								'0',
								'".$mysqli->real_escape_string($booking_total_amount)."',
								'0',
								'".$mysqli->real_escape_string($locker_amount)."',
								'".$mysqli->real_escape_string($card_p_amount)."',
								'".$mysqli->real_escape_string($avaible_Days)."',
								'Due',
								'".$mysqli->real_escape_string($payment_pattern)."',
								'1',
								'1',
								'".$mysqli->real_escape_string($payment_method)."',
								'".$mysqli->real_escape_string($data_one)."',
								'".$mysqli->real_escape_string($transaction_idO)."',
								'".$mysqli->real_escape_string($data_three)."',
								'1',
								'',
								'1',
								'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
								'".$mysqli->real_escape_string(month_name(date('m')))."',
								'".$mysqli->real_escape_string(date('d/m/Y'))."',
								'".$mysqli->real_escape_string($dis_aamt)."',
								'".$mysqli->real_escape_string($_RENT_DIS_PATTERN)."'
								'".$mysqli->real_escape_string($discount_money_rent)."'
							)";
							$mysqli->query($rent_information);
							$allow_s_back = 0;
							$_GET_DISCOUNT_NOW = 'NO';
						}
					}
				}
				
				if($package_info['aggreement'] == 1){					
					if($allow_s_back == 1){
						if($_POST['payment_pattern'] == 1){
							$payment_condition_type = 'Full';
						}else{
							$payment_condition_type = 'Half';
						}
						$mysqli->query("insert into aggreement_monthly_deposit_back values(
							'',
							'".$mysqli->real_escape_string($booking_id)."',
							'1000',
							'".$payment_condition_type."',
							'',
							'1',
							'".uploader_info()."',
							'".date('d/m/Y')."'
						)");
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
							'".$mysqli->real_escape_string($booking_id)."', 
							'".$mysqli->real_escape_string($full_name)."', 
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
				
				if(isset($_POST['late_night_checkin'])){
					$get_note = 'Late-Night CheckIn';
				}else{
					$get_note = '';
				}
				$booking_information = "insert into booking_info values(
					'',
					'".$mysqli->real_escape_string($booking_id)."',
					'".$mysqli->real_escape_string($branch_id)."',
					'".$mysqli->real_escape_string($branch_info['branch_name'])."',
					'".$mysqli->real_escape_string($checkin_date_m)."',
					'".$mysqli->real_escape_string($check_out_date)."',
					'".$mysqli->real_escape_string($pack_cat_info['id'])."',
					'".$mysqli->real_escape_string($pack_cat_info['package_category_name'])."',
					'".$mysqli->real_escape_string($package_info['id'])."',
					'".$mysqli->real_escape_string($package_info['package_name'])."',
					'".$mysqli->real_escape_string($card_number)."',
					'".$mysqli->real_escape_string($full_name)."',
					'".$mysqli->real_escape_string($bed_info['id'])."',
					'".$mysqli->real_escape_string($bed_info['bed_name'])."',
					'".$mysqli->real_escape_string($booking_security_amount)."',
					'".$mysqli->real_escape_string($phone_number)."',			
					'".$mysqli->real_escape_string($booking_rent_amount)."',
					'".$mysqli->real_escape_string($_POST['booking_parking_amount'])."',					
					'".$mysqli->real_escape_string($locker)."',
					'".$mysqli->real_escape_string($locker_qty)."',
					'".$mysqli->real_escape_string($locker_amount)."',						
					'".$mysqli->real_escape_string($card_p_amount)."',						
					'".$mysqli->real_escape_string($total_amount_get)."',			
					'".$mysqli->real_escape_string($avaible_Days)."',
					'".$mysqli->real_escape_string($payment_pattern)."',
					'".$mysqli->real_escape_string($payment_method)."',				
					'".$mysqli->real_escape_string($data_one)."',
					'".$mysqli->real_escape_string($transaction_idO)."',
					'".$mysqli->real_escape_string($data_three)."',
					'".$get_note."',
					'1',
					'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."',
					'".$mysqli->real_escape_string($cash_back_amount)."',
					'".$mysqli->real_escape_string($count_reword)."'
				)";	
				
				//============Member discount---------------
				
				if($_MEMBER_DISCOUNT == 'YES'){
					if($_GET_DISCOUNT_NOW == 'YES'){
						if($booking_rent_amount > $discount_amount){
							if($payment_pattern == 0){
								$_INSERT_DISCOUNT = 'A';
							}else if($payment_pattern == 1){
								$_INSERT_DISCOUNT = 'B';
							}else if($payment_pattern == 2){
								$_INSERT_DISCOUNT = 'YES';
							}
						} else {
							$_INSERT_DISCOUNT = 'YES';
						}
					}else{
						$_INSERT_DISCOUNT = 'YES';
					}
					
					$discount_info = "INSERT INTO discount_member VALUES(
						'',
						'".$mysqli->real_escape_string($branch_id)."',
						'".$mysqli->real_escape_string($booking_id)."',
						'".$mysqli->real_escape_string($pack_cat_info['id'])."',
						'".$mysqli->real_escape_string($package_info['id'])."',
						'".$mysqli->real_escape_string($checkin_date_m)."',
						'".$mysqli->real_escape_string($discount_amount)."', 
						'".$mysqli->real_escape_string(date('d'))."',
						'".$mysqli->real_escape_string(date('m'))."',
						'".$mysqli->real_escape_string(date('Y'))."',
						'',
						'1',
						'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
						'".$mysqli->real_escape_string(date('d/m/Y'))."',
						'".$mysqli->real_escape_string($payment_pattern)."',
						'".$mysqli->real_escape_string($_INSERT_DISCOUNT)."'
					)";
					$mysqli->query($discount_info);
				}else{
					$_INSERT_DISCOUNT = 'NO';
				}
				
				$booking_receipt_logs = "insert into booking_receipt_logs values(
					'',
					'".$mysqli->real_escape_string($booking_id)."',
					'".$mysqli->real_escape_string($branch_id)."',
					'".$mysqli->real_escape_string($branch_info['branch_name'])."',
					'".$mysqli->real_escape_string($checkin_date_m)."',
					'".$mysqli->real_escape_string($check_out_date)."',
					'".$mysqli->real_escape_string($pack_cat_info['id'])."',
					'".$mysqli->real_escape_string($pack_cat_info['package_category_name'])."',
					'".$mysqli->real_escape_string($package_info['id'])."',
					'".$mysqli->real_escape_string($package_info['package_name'])."',
					'".$mysqli->real_escape_string($card_number)."',
					'".$mysqli->real_escape_string($full_name)."',
					'".$mysqli->real_escape_string($bed_info['id'])."',
					'".$mysqli->real_escape_string($bed_info['bed_name'])."',
					'".$mysqli->real_escape_string($booking_security_amount)."',
					'".$mysqli->real_escape_string($phone_number)."',			
					'".$mysqli->real_escape_string($booking_rent_amount)."',
					'".$mysqli->real_escape_string($_POST['booking_parking_amount'])."',					
					'".$mysqli->real_escape_string($locker)."',
					'".$mysqli->real_escape_string($locker_qty)."',
					'".$mysqli->real_escape_string($locker_amount)."',						
					'".$mysqli->real_escape_string($card_p_amount)."',						
					'".$mysqli->real_escape_string($total_amount_get)."',			
					'".$mysqli->real_escape_string($avaible_Days)."',
					'".$mysqli->real_escape_string($payment_pattern)."',
					'".$mysqli->real_escape_string($payment_method)."',				
					'".$mysqli->real_escape_string($data_one)."',
					'".$mysqli->real_escape_string($transaction_idO)."',
					'".$mysqli->real_escape_string($data_three)."',
					'".$get_note."',
					'1',
					'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."',
					'".$mysqli->real_escape_string($cash_back_amount)."',
					'".$mysqli->real_escape_string($count_reword)."',
					'".$mysqli->real_escape_string($_INSERT_DISCOUNT)."'
				)";
				
				$mysqli->query($booking_receipt_logs);
				$update_bed_info = "update beds set
					uses = '".$mysqli->real_escape_string($bed_status)."'
					where id = '".$mysqli->real_escape_string($bed_info['id'])."'
				";	
				
				$old_blnc = $account_info['balance'];
				$new_blnc = $old_blnc + $booking_total_amount;
				$account_information = "update accounts set
					balance = '".$new_blnc."'
					where id = '1'
				";				
				
				$shpont_information = "insert into balance_shpoint values(
					'',
					'".$mysqli->real_escape_string($booking_id)."',
					'0',
					'".$mysqli->real_escape_string(date('d/m/Y'))."'
				)";
				
				
						
				
				if(!empty($referance_id)){
					$check_id = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$referance_id."' and status = 1'"));
					if(!empty($check_id['card_number'])){
						$get_bal = mysqli_fetch_assoc($mysqli->query("select * from balance_shpoint where booking_id = '".$check_id['booking_id']."'"));
						$get_award = mysqli_fetch_assoc($mysqli->query("select * from member_referal_award where id = '1' and status = '1'"));
						if(!empty($get_award['amount']) AND $get_award['amount'] > 0){
							$amount = $get_award['amount'];
						}else{
							$amount = '0';
						}						
						$mmb_bal_result = $get_bal['balance'] + $amount;						
						$mysqli->query("update balance_shpoint set balance = '".$mmb_bal_result."' where booking_id = '".$check_id['booking_id']."'");
					}
				}			
				
				$activity_log = "insert into activity_log values(
					'',
					'".$mysqli->real_escape_string($branch_id)."',
					'".$mysqli->real_escape_string($branch_info['branch_name'])."',
					'".$mysqli->real_escape_string($full_name." is booked by ".base64_decode($uploader_info))."',
					'".$mysqli->real_escape_string(base64_decode($uploader_info))."',
					'".$mysqli->real_escape_string(date('d/m/Y'))."'
				)";				
				
				if(!empty($_POST['pre_b_id']) AND $_POST['pre_b_id'] > 0){
					$mysqli->query("update pre_booking_directory set status = '0' where id = '".$_POST['pre_b_id']."'");
				}
				
				if(
					$mysqli->query($member_directory)
					AND
					$mysqli->query($booking_information)
					AND
					$mysqli->query($account_information)
					AND
					$mysqli->query($update_bed_info)
					AND
					$mysqli->query($transaction_information)
					AND
					$mysqli->query($shpont_information)
					AND
					$mysqli->query($activity_log)			
				){
					if(!empty($_SESSION['photo_avater'])){
						unset($_SESSION['photo_avater']);
					}
					if(!empty($_SESSION['re_book_member_id'])){
						unset($_SESSION['re_book_member_id']);
					}
					if(!empty($_SESSION['re_book_member_id'])){
						unset($_SESSION['re_book_member__money']);
					}				
					
					$bK_idi = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$booking_id."'"));
					if(!empty($bK_idi['id'])){
						$bki_id = $bK_idi['id'];
					}else{
						$bki_id = '';
					}
					include("email_template/email_template/bk_details.php");
					$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$branch_id."'"));
					if(!empty($branch['branch_phone_number'])){
						$phone_numbera = $branch['branch_phone_number'];
					}else{
						$phone_numbera = '+8809638666333';
					}
					$message_body = 'Dear, '.$full_name.' Your Booking Successfully Done, We Received Your Total Amount is BDT '.round($total_amount_get,2).'. Your Login Information: CardNumber: '.$card_number.' & Password: '.$generated_password.'. Link: '.$home.'member | Thank You For Stay With US. For any Query Feel free to call US '.$phone_numbera.' & For More Details Visit Here: https://www.superhomebd.com/';
					if(sendsms($phone_number,$message_body)){
						$message = booking_mail($card_number, $generated_password, $home);									
						if(main_email('SUPER HOME MEMBER LOGIN INFORMATION',$message,'','',$email,$full_name)){
							echo 'Booking Successfeully Done, Mail & SMS also sended!.____0____'.$bki_id.'____'.$card_number; // <span style="color:green;font-weight:bolder;"></span>
						}else{
							echo 'Something Wrong In MAIL section! Booking Successfully Done.____0____'.$bki_id.'____'.$card_number;
						}				
					}else{
						echo 'Something Wrong In SMS section! Booking Successfully Done.____0____'.$bki_id.'____'.$card_number;
					}			
				}else{			
					echo 'Something Wrong! Please Try again.____1';
				}
			}
		}
	}
}
?>