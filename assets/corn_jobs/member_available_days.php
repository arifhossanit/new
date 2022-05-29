<?php 
include("../../application/config/ajax_config.php");
function month($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$memberm = $mysqli->query("SELECT * FROM member_directory WHERE status = '1'");
$today = new DateTime();
$file = fopen('E:/xampp/htdocs/super_home/assets/corn_jobs/logs/available_days_log.txt', 'a');
fwrite($file, "Starte at: " . $today->format('Y-m-d H:i:s') . "; ");
$number_of_record = 0;
$try_us = 0;
$try_us_cancel = 0;
$monthly = 0;
$monthly_cancel = 0;
while($row = mysqli_fetch_assoc($memberm)){
	$number_of_record++;
	$package = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$row['package']."'"));
	$booking_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM booking_info WHERE booking_id = '".$row['booking_id']."'"));
	$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$mysqli->real_escape_string($row['branch_id'])."'"));
	if(!empty($branch['branch_phone_number'])){
		$phone_number = $branch['branch_phone_number'];
	}else{
		$phone_number = '+8809638666333';
	}
	if($package['try_us'] == 1){ // Automatic Software Work for Try Us Packages
		$try_us++;
		if($package['package_days'] == 30){ // Automatic Software Work for Try Us Packages whois 30days
			if($row['card_number'] != 'Unauthorized'){
				if((int)$booking_info['available_days'] > -5){
					$minus_days = (int)$booking_info['available_days'] - 1;
					$mysqli->query("UPDATE booking_info SET available_days = '".$minus_days."' WHERE booking_id = '".$row['booking_id']."'");
				}				
				if($package['aggreement'] == 1){ // Aggreement Member 
					$package_name_a = 'Contract: '.$package['package_name'].'';
					if((int)$booking_info['available_days'] == 1){
						$datetime = new DateTime('tomorrow');
						$data =  $datetime->format('d-m-Y');
						$data1 =  $datetime->format('d/m/Y');
						$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your '.$package['package_category_name'].'-'.$package['package_name'].' membership will expired '.$data.' at 02.00PM. Please contact with Branch lobby or call this number "'.$phone_number.'" for cancel seat, pay installment or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
						$mysqli->query("INSERT INTO cancel_reminder VALUES(
							'',
							'".$row['branch_id']."',
							'".$row['booking_id']."',
							'".$row['phone_number']."',
							'".$message."',
							'".$data." at 02.00PM',
							'".date('l, d/m/Y h:i:sa')."',
							'".$package_name_a."',
							'Auto reminder message from software',
							'1',
							'Software Robot',
							'".$data1."'
						)");
						sendsms($row['phone_number'],$message); 
					}
					// if((int)$booking_info['available_days'] == -2){
					// 	$datetime = new DateTime('tomorrow');
					// 	$data =  $datetime->format('d-m-Y');
					// 	$data1 =  $datetime->format('d/m/Y');
					// 	$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your '.$package['package_category_name'].'-'.$package['package_name'].' membership has expired. Please contact with Branch lobby or call this number "'.$phone_number.'" for cancel seat, Compleate your payment, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
					// 	$mysqli->query("INSERT INTO cancel_reminder VALUES(
					// 		'',
					// 		'".$row['branch_id']."',
					// 		'".$row['booking_id']."',
					// 		'".$row['phone_number']."',
					// 		'".$message."',
					// 		'".$data." at 02.00PM',
					// 		'".date('l, d/m/Y h:i:sa')."',
					// 		'".$package_name_a."',
					// 		'Auto reminder message from software',
					// 		'1',
					// 		'Software Robot',
					// 		'".$data1."'
					// 	)");
					// 	sendsms($row['phone_number'],$message); 
					// }
					if((int)$booking_info['available_days'] == -1 AND (int)$booking_info['status'] != 0){
						$try_us_cancel++;
						$mysqli->query("UPDATE booking_info SET
							status = '0'
							WHERE booking_id = '".$row['booking_id']."'
						");
						$bed_id = $row['bed_id'];
						$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
						if($get_bed_number[0] > 1){
							$mysqli->query("UPDATE beds SET
								uses = '2'
								WHERE id = '".$row['bed_id']."'
							");
						}else{
							$mysqli->query("UPDATE beds SET
								uses = '4'
								WHERE id = '".$row['bed_id']."'
							");
						}
						$mysqli->query("INSERT INTO cencel_request VALUES(
							'',
							'".$row['booking_id']."',
							'".$row['branch_id']."',
							'".$row['id']."',
							'".$row['bed_id']."',
							'".date('Y-m-d')."',
							'Request For Cancel for rental payment issue (auto cancel from software)',
							'1',
							'',
							'".date('d/m/Y')."'
						)");
						$message = 'Dear valuable member, '.$row['full_name'].', your seat is auto canceled for Unpaid Rent or Renew Package & Your security diposit is not refundable. Thank You For Staying With US. For any Query Feel free to call US '.$phone_number.'';
						sendsms($row['phone_number'],$message);
					}					
				}else{
					$package_name_a = 'try_us_30_days';
					if((int)$booking_info['available_days'] == 1){
						$datetime = new DateTime('tomorrow');
						$data =  $datetime->format('d-m-Y');
						$data1 =  $datetime->format('d/m/Y');
						$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your '.$package['package_category_name'].'-'.$package['package_name'].' membership will expired '.$data.' at 02.00PM. Please contact with Branch lobby or call this number "'.$phone_number.'" for cancel seat, pay installment or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
						$mysqli->query("INSERT INTO cancel_reminder VALUES(
							'',
							'".$row['branch_id']."',
							'".$row['booking_id']."',
							'".$row['phone_number']."',
							'".$message."',
							'".$data." at 02.00PM',
							'".date('l, d/m/Y h:i:sa')."',
							'".$package_name_a."',
							'Auto reminder message from software',
							'1',
							'Software Robot',
							'".$data1."'
						)");
						sendsms($row['phone_number'],$message); 
					}
					if((int)$booking_info['available_days'] == 0 AND (int)$booking_info['status'] != 0){
						$try_us_cancel++;
						$mysqli->query("UPDATE booking_info SET
							status = '0'
							WHERE booking_id = '".$row['booking_id']."'
						");
						$bed_id = $row['bed_id'];
						$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
						if($get_bed_number[0] > 1){
							$mysqli->query("UPDATE beds SET
								uses = '2'
								WHERE id = '".$row['bed_id']."'
							");
						}else{
							$mysqli->query("UPDATE beds SET
								uses = '4'
								WHERE id = '".$row['bed_id']."'
							");
						}
						$mysqli->query("INSERT INTO cencel_request VALUES(
							'',
							'".$row['booking_id']."',
							'".$row['branch_id']."',
							'".$row['id']."',
							'".$row['bed_id']."',
							'".date('Y-m-d')."',
							'Request For Cancel for rental payment issue (auto cancel from software)',
							'1',
							'',
							'".date('d/m/Y')."'
						)");
						$message = 'Dear valuable member, '.$row['full_name'].', your seat is auto cancel for Unpaid Rent or Renew Package & Your security diposit is not refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
						sendsms($row['phone_number'],$message);
					}				
				}	
			}else{ //if unathorized member not come in right time
				$gd = explode('/',$row['check_in_date']);
				$i_date = $gd[0] + 1;
				$i_month = $gd[1];
				$i_year = $gd[2];
				if($i_date == date('d') AND $i_month == date('m') AND $i_year == date('Y')){
					$new_card = time() * rand();
					$mysqli->query("UPDATE member_directory SET
						card_number = '".$new_card."',
						security_deposit = '0',
						status = '3',
						bed_id = '0',
						note = 'Diposit money return'
						WHERE id = '".$row['id']."'
					");
					$mysqli->query("UPDATE booking_info SET
						card_no = '".$new_card."',
						security_deposit = '0',
						status = '2',
						count_reword = '1'
						WHERE booking_id = '".$row['booking_id']."'
					");
					$mysqli->query("UPDATE rent_info SET
						card_no = '".$new_card."'
						WHERE booking_id = '".$row['booking_id']."'
					");
					$bed_id = $row['bed_id'];
					$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
					if($get_bed_number[0] > 1){
						$mysqli->query("UPDATE beds SET
							uses = '2'
							WHERE id = '".$row['bed_id']."'
						");
					}else{
						$mysqli->query("UPDATE beds SET
							uses = '0'
							WHERE id = '".$row['bed_id']."'
						");
					}
					$mysqli->query("INSERT INTO return_diposit_money VALUES(
						'',
						'".$row['branch_id']."',
						'".$row['booking_id']."',
						'0',
						'Auto Refund',
						'',
						'',
						'',
						'',
						'Auto Refunded for CheckIn Date issue (auto Refunded from software)',
						'1',
						'',
						'".date('d/m/Y')."'
					)");
					$message = 'Dear valuable member, '.$row['full_name'].', your seat is auto cancel for not came in checkin date. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
					sendsms($row['phone_number'],$message);
				} /*--------------------*/
			}


			
		}else{ // Automatic Software Work for Try Us Packages whois less ten 30days
			$try_us++;
			if($row['card_number'] != 'Unauthorized'){
				if((int)$booking_info['available_days'] > 0){
					$minus_days = (int)$booking_info['available_days'] - 1;
					$mysqli->query("UPDATE booking_info SET 
						available_days = '".$minus_days."' 
						WHERE booking_id = '".$row['booking_id']."'
					");
				}
				if((int)$booking_info['available_days'] == 1){
					$datetime = new DateTime('tomorrow');
					$data =  $datetime->format('d-m-Y');
					$data1 =  $datetime->format('d/m/Y');
					$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your '.$package['package_category_name'].'-'.$package['package_name'].' membership will expired '.$data.' at 02.00PM. Please contact with Branch lobby or call this number '.$phone_number.' for cancel or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
					$mysqli->query("INSERT INTO cancel_reminder VALUES(
						'',
						'".$row['branch_id']."',
						'".$row['booking_id']."',
						'".$row['phone_number']."',
						'".$message."',
						'".$data." at 02.00PM',
						'".date('l, d/m/Y h:i:sa')."',
						'try_us_non_30_days',
						'Auto reminder message from software',
						'1',
						'Software Robot',
						'".$data1."'
					)");
					sendsms($row['phone_number'],$message); 
				}
				if((int)$booking_info['available_days'] == 0 AND (int)$booking_info['status'] != 0){
					$try_us_cancel++;
					$mysqli->query("UPDATE booking_info SET
						status = '0'
						WHERE booking_id = '".$row['booking_id']."'
					");
					$bed_id = $row['bed_id'];
					$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
					if($get_bed_number[0] > 1){
						$mysqli->query("UPDATE beds SET
							uses = '2'
							WHERE id = '".$row['bed_id']."'
						");
					}else{
						$mysqli->query("UPDATE beds SET
							uses = '4'
							WHERE id = '".$row['bed_id']."'
						");
					}
					$mysqli->query("INSERT INTO cencel_request VALUES(
						'',
						'".$row['booking_id']."',
						'".$row['branch_id']."',
						'".$row['id']."',
						'".$row['bed_id']."',
						'".date('Y-m-d')."',
						'Request For Cancel for rental payment issue (auto cancel from software)',
						'1',
						'',
						'".date('d/m/Y')."'
					)");
					$message = 'Dear valuable member, '.$row['full_name'].', your seat is auto cancel for Unpaid Rent or Renew Package & Your security diposit is not refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
					sendsms($row['phone_number'],$message);
				}
			}else{ //if unathorized member not come in right time
				$gd = explode('/',$row['check_in_date']);
				$i_date = $gd[0] + 1;
				$i_month = $gd[1];
				$i_year = $gd[2];
				if($i_date == date('d') AND $i_month == date('m') AND $i_year == date('Y')){
					$new_card = time() * rand();
					$mysqli->query("UPDATE member_directory SET
						card_number = '".$new_card."',
						security_deposit = '0',
						status = '3',
						bed_id = '0',
						note = 'Diposit money return'
						WHERE id = '".$row['id']."'
					");
					$mysqli->query("UPDATE booking_info SET
						card_no = '".$new_card."',
						security_deposit = '0',
						status = '2'
						WHERE booking_id = '".$row['booking_id']."'
					");
					$mysqli->query("UPDATE rent_info SET
						card_no = '".$new_card."'
						WHERE booking_id = '".$row['booking_id']."'
					");
					$bed_id = $row['bed_id'];
					$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
					if($get_bed_number[0] > 1){
						$mysqli->query("UPDATE beds SET
							uses = '2'
							WHERE id = '".$row['bed_id']."'
						");
					}else{
						$mysqli->query("UPDATE beds SET
							uses = '0'
							WHERE id = '".$row['bed_id']."'
						");
					}
					$mysqli->query("INSERT INTO return_diposit_money VALUES(
						'',
						'".$row['branch_id']."',
						'".$row['booking_id']."',
						'0',
						'Auto Refund',
						'',
						'',
						'',
						'',
						'Auto Refunded for CheckIn Date issue (auto Refunded from software)',
						'1',
						'',
						'".date('d/m/Y')."'
					)");
					$message = 'Dear valuable member, '.$row['full_name'].', your seat is auto cancel for not came in chackin date. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
					sendsms($row['phone_number'],$message); 
				}/*--------------------*/
			}
		}
	}else if($package['try_us'] == 0){ // Automatic Software Work for Monthly Packages
		$monthly++;
		if($row['card_number'] != 'Unauthorized'){			
			$minus_days = (int)$booking_info['available_days'] - 1;
			$mysqli->query("UPDATE booking_info SET available_days = '".$minus_days."' WHERE booking_id = '".$row['booking_id']."'");
			if((int)$booking_info['available_days'] <= 0){
				$rent_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM rent_info WHERE booking_id = '".$row['booking_id']."' AND month_name = '".month(date('m'))."' AND data LIKE '%".date('Y')."'"));
				if(!empty($rent_info['id'])){
					if($rent_info['payment_pattern'] == '2' OR $rent_info['payment_pattern'] == ''){
						if(date('d') >= 10 ){			
							$panalty_amount = '100';
							$panalty = (int)$rent_info['penalty'] + (int)$panalty_amount;
							$mysqli->query("UPDATE rent_info SET
								penalty = '".$panalty."'
								WHERE id = '".$rent_info['id']."'
							");
						}
						if(date('d') == 14 ){
							$datetime = new DateTime('tomorrow');
							$data =  $datetime->format('d-m-Y');
							$data1 =  $datetime->format('d/m/Y');
							$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your package will expired '.$data.'. Please contact with Branch lobby or call this number "'.$phone_number.'" for cancel or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
							$mysqli->query("INSERT INTO cancel_reminder VALUES(
								'',
								'".$row['branch_id']."',
								'".$row['booking_id']."',
								'".$row['phone_number']."',
								'".$message."',
								'".$data." at 02.00PM',
								'".date('l, d/m/Y h:i:sa')."',
								'monthly_membership',
								'Auto reminder message from software',
								'1',
								'Software Robot',
								'".$data1."'
							)");
							sendsms($row['phone_number'],$message); // meessage open & change by ibrahim vai ( 17-04-2021)
						}
						if(date('d') == 15 ){
							$monthly_cancel++;
							$mysqli->query("UPDATE booking_info SET
								status = '0'
								WHERE booking_id = '".$row['booking_id']."'
							");					
							$bed_id = $row['bed_id'];
							$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
							if($get_bed_number[0] > 1){
								$mysqli->query("UPDATE beds SET
									uses = '2'
									WHERE id = '".$row['bed_id']."'
								");
							}else{
								$mysqli->query("UPDATE beds SET
									uses = '4'
									WHERE id = '".$row['bed_id']."'
								");
							}					
							$mysqli->query("INSERT INTO cencel_request VALUES(
								'',
								'".$row['booking_id']."',
								'".$row['branch_id']."',
								'".$row['id']."',
								'".$row['bed_id']."',
								'".date('Y-m-d')."',
								'Request For Cancel for rental payment issue (auto cancel from software)',
								'1',
								'',
								'".date('d/m/Y')."' 
							)");
							$message = 'Dear valuable member, Mr. '.$row['full_name'].', your seat is auto cancel for Unpaid Rent & Your security diposit is not refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
							sendsms($row['phone_number'],$message);  // meessage open & change by ibrahim vai ( 17-04-2021)
						}
					}else if($rent_info['payment_pattern'] == '0'){
						if(date('d') >= 25 ){			
							$panalty_amount = '100';
							$panalty = $rent_info['penalty'] + $panalty_amount;
							$mysqli->query("UPDATE rent_info SET
								penalty = '".$panalty."'
								WHERE id = '".$rent_info['id']."'
							");
						}
						$number_of_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
						$one_day = $number_of_month - 1;
						if(date('d') == $one_day ){
							$datetime = new DateTime('tomorrow');
							$data =  $datetime->format('d-m-Y');
							$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your package will expired '.$data.'. Please contact with Branch lobby or call this number "'.$phone_number.'" for cancel or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
							sendsms($row['phone_number'],$message); // meessage open & change by ibrahim vai ( 17-04-2021)
						}
						if(date('d') ==  $number_of_month  AND (int)$booking_info['status'] != 0){
							$monthly_cancel++;
							$mysqli->query("UPDATE booking_info SET
								status = '0'
								WHERE booking_id = '".$row['booking_id']."'
							");					
							$bed_id = $row['bed_id'];
							$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
							if($get_bed_number[0] > 1){
								$mysqli->query("UPDATE beds SET
									uses = '2'
									WHERE id = '".$row['bed_id']."'
								");
							}else{
								$mysqli->query("UPDATE beds SET
									uses = '4'
									WHERE id = '".$row['bed_id']."'
								");
							}					
							$mysqli->query("INSERT INTO cencel_request VALUES(
								'',
								'".$row['booking_id']."',
								'".$row['branch_id']."',
								'".$row['id']."',
								'".$row['bed_id']."',
								'".date('Y-m-d')."',
								'Request For Cancel for rental payment issue (auto cancel from software)',
								'1',
								'',
								'".date('d/m/Y')."' 
							)");
							sendsms($row['phone_number'],'Dear valuable member, '.$row['full_name'].', your seat is auto cancel for Unpaid Rent & Your security diposit is not refundable. Thank You For Stay With US. For any Query Feel free to call US +8809638666333');// meessage open & change by ibrahim vai ( 17-04-2021)
						}
					}
				}else{
					$pack_cat = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages_category WHERE id = '".$row['package_category']."'"));
					if($row['parking'] == '1'){
						$parking_amount = $row['parking_amount'];
					}else{
						$parking_amount = '0';
					}			
					$tc_d = date('Y-m').'-30 first day of last month';
					$dt=date_create($tc_d);
					$yes_month = $dt->format('m/Y');
					$tcql = mysqli_fetch_assoc($mysqli->query("SELECT SUM(total_amount) AS t_c_am FROM refreshment_item_sell WHERE buyer_id = '".$row['card_number']."' AND payment_status = 'Due' AND data LIKE '%".$yes_month."'"));
					$total_adren = $row['rent_amount'] + $parking_amount + $tcql['t_c_am'];
					if(!empty($row['locker_amount']) AND $row['locker_amount'] > 0){
						$locaker = $row['locker_amount'];
					}else{
						$locaker = '0';
					}
					$pakg = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$row['package']."'"));
					$discount = mysqli_fetch_assoc($mysqli->query("SELECT * FROM discount_member WHERE booking_id = '".$row['booking_id']."'"));
					$rent_count = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM rent_info WHERE booking_id = '".$row['booking_id']."'"));
					if(!empty($discount['id'])){
						if($rent_count[0] > 2){
							$get_discount = '';
							$d_p = 'NO';
						}else{
							$get_discount = '0';
							$d_p = 'A';
						}					
					}else{
						$get_discount = '1';
						$d_p = 'YES';
					}
					$mysqli->query("insert into rent_info values(
						'',
						'".$row['booking_id']."',
						'".$row['branch_id']."',
						'".$row['branch_name']."',
						'".$row['check_in_date']."',
						'',
						'".$pack_cat['id']."',
						'".$pack_cat['package_category_name']."',
						'".$row['package']."',
						'".$row['package_name']."',
						'".$row['card_number']."',
						'".$row['full_name']."',
						'".$row['rent_amount']."',
						'".$parking_amount."',
						'0',
						'".$tcql['t_c_am']."',
						'".$total_adren."',
						'0',
						'".$locaker."',
						'0',
						'0',
						'Due',
						'2',
						'1',
						'1',
						'',
						'',
						'',
						'',
						'',
						'',
						'1',
						'',
						'".month(date('m'))."',
						'".date('d/m/Y')."',
						'".$get_discount."',
						'".$d_p."',
						'0'
					)");
				}
			}			
			
		}
	}
}
fwrite($file, "Number of record: TryUs: $try_us, TryUsCancel: $try_us_cancel; Monthly: $monthly, MonthlyCancel: $monthly_cancel; ");

//============================Corn Jobs Traces by database & sms =======================================

if($mysqli->query("INSERT INTO corn_jobs_log VALUES(
	'',
	'Member Available Date Manage & Rental Issue',
	'".date("l")."',
	'".date("h:i:sa")."',
	'".date("d/m/Y")."'
)")){
	$message = 'Message From Corn Jobs (Member Available Date Manage). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms('01704123498',$message);
	sendsms('01704123492',$message);
}else{
	$message = 'Something wrong! Message From Corn Jobs (Member Available Date Manage). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms('01704123498',$message);
	sendsms('01704123492',$message);
}
$now = new DateTime();
$diff = $now->getTimestamp() - $today->getTimestamp();
fwrite($file, "Totat time taken: $diff s. \n");
fclose($file);  
?>