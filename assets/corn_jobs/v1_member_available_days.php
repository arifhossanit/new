<?php 
include("../../application/config/ajax_config.php");
function month($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$runing_task = '0';
$total_adren = '0';
$memberm = $mysqli->query("select * from member_directory where status = '1'");
while($row = mysqli_fetch_assoc($memberm)){
	$check = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$row['booking_id']."' and status = '1'"));
	if($check['card_no'] != 'Unauthorized'){
	
		if(!empty($check['id'])){
			$package_category_name1 = 'try';
			$package_category = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$row['package_category']."' and package_category_name like '%".$package_category_name1."%'"));
			if(!empty($package_category)){
				$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));
				if($check['available_days'] == '1'){
					$datetime = new DateTime('tomorrow');
					$data =  $datetime->format('d-m-Y');
					$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your '.$package['package_category_name'].'-'.$package['package_name'].' membership will expired '.$data.' at 02.00PM. Please contact with Branch lobby or call this number "+880 9638666333" for cancel or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US +880 9638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';
					//sendsms($row['phone_number'],$message); 
					$runing_task = '1';
				}else if($check['available_days'] == '0'){
					$mysqli->query("update member_directory set
						check_out_date = '".date('d/m/Y')."'
						where id = '".$row['id']."'
					");					
					$mysqli->query("update booking_info set
						status = '0',
						checkout_date = '".date('d/m/Y')."'
						where booking_id = '".$row['booking_id']."'
					");					
					$mysqli->query("update beds set
						uses = '4'
						where id = '".$row['bed_id']."'
					");					
					$mysqli->query("insert into cencel_request values(
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
					$message = 'Dear valuable member, '.$row['full_name'].', your seat is auto cancel for Unpaid Rent & Your security diposit is not refundable. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';
					//sendsms($row['phone_number'],$message);
					$runing_task = '0';
				}else{
					$runing_task = '1';
				}
			}else{
				$runing_task = '1';
			}
			if($runing_task == '1'){
				$total_date = $check['available_days'] - 1;
				$mysqli->query("update booking_info set
					available_days = '".$total_date."'
					where booking_id = '".$row['booking_id']."'
				");
				$rent_info = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' and month_name = '".month(date('m'))."' and data like '%".date('Y')."'"));
				if(!empty($rent_info['id'])){
					if($rent_info['payment_pattern'] == '2' OR $rent_info['payment_pattern'] == ''){
						if(date('d') >= 10 ){			
							$panalty_amount = '100';
							$panalty = $rent_info['penalty'] + $panalty_amount;
							$mysqli->query("update rent_info set
								penalty = '".$panalty."'
								where id = '".$rent_info['id']."'
							");
						}
						if(date('d') >= 14 ){
							$datetime = new DateTime('tomorrow');
							$data =  $datetime->format('d-m-Y');
							$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your package will expired '.$data.'. Please contact with Branch lobby or call this number "+880 9638666333" for cancel or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US +880 9638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';
							//sendsms($row['phone_number'],$message);
						}
						if(date('d') >= 15 ){
							$mysqli->query("update member_directory set
								check_out_date = '".date('d/m/Y')."'
								where id = '".$row['id']."'
							");					
							$mysqli->query("update booking_info set
								status = '0',
								checkout_date = '".date('d/m/Y')."'
								where booking_id = '".$row['booking_id']."'
							");					
							$mysqli->query("update beds set
								uses = '4'
								where id = '".$row['bed_id']."'
							");					
							$mysqli->query("insert into cencel_request values(
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
							$message = 'Dear valuable member, Mr. '.$row['full_name'].', your seat is auto cancel for Unpaid Rent & Your security diposit is not refundable. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';
							//sendsms($row['phone_number'],$message);
						}
					}else if($rent_info['payment_pattern'] == '0'){
						if(date('d') >= 25 ){			
							$panalty_amount = '100';
							$panalty = $rent_info['penalty'] + $panalty_amount;
							$mysqli->query("update rent_info set
								penalty = '".$panalty."'
								where id = '".$rent_info['id']."'
							");
						}
						$number_of_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
						$one_day = $number_of_month - 1;
						if(date('d') == $one_day ){
							$datetime = new DateTime('tomorrow');
							$data =  $datetime->format('d-m-Y');
							$message = '(REMINDER MESSAGE FROM SUPER HOME) Dear valuable member, '.$row['full_name'].' Your package will expired '.$data.'. Please contact with Branch lobby or call this number "+880 9638666333" for cancel or renew the package befor expired time, otherwise security deposit will not be refundable. Thank You For Stay With US. For any Query Feel free to call US +880 9638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.';
							//sendsms($row['phone_number'],$message);
						}
						if(date('d') ==  $number_of_month){
							$mysqli->query("update member_directory set
								check_out_date = '".date('d/m/Y')."'
								where id = '".$row['id']."'
							");					
							$mysqli->query("update booking_info set
								status = '0',
								checkout_date = '".date('d/m/Y')."'
								where booking_id = '".$row['booking_id']."'
							");					
							$mysqli->query("update beds set
								uses = '4'
								where id = '".$row['bed_id']."'
							");					
							$mysqli->query("insert into cencel_request values(
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
							//sendsms($row['phone_number'],'Dear valuable member, '.$row['full_name'].', your seat is auto cancel for Unpaid Rent & Your security diposit is not refundable. Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/ NB: This message only for experimental research & If you gotted any wrong message/information then we will maintain it officially.');
						}
					}
				}else{
					$pack_cat = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$row['package_category']."'"));
					if($row['parking'] == '1'){
						$parking_amount = $row['parking_amount'];
					}else{
						$parking_amount = '0';
					}			
					$tc_d = date('Y-m').'-30 first day of last month';
					$dt=date_create($tc_d);
					$yes_month = $dt->format('m/Y');
					$tcql = mysqli_fetch_assoc($mysqli->query("select sum(total_amount) as t_c_am from refreshment_item_sell where buyer_id = '".$row['card_number']."'and payment_status = 'Due' and data like '%".$yes_month."'"));
					$total_adren = $row['rent_amount'] + $parking_amount + $tcql['t_c_am'];
					if(!empty($row['locker_amount']) AND $row['locker_amount'] > 0){
						$locaker = $row['locker_amount'];
					}else{
						$locaker = '0';
					}
					$pakg = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));
					if($pakg['try_us'] == '0'){
						$mysqli->query("insert into rent_info values(
							'',
							'".$row['booking_id']."',
							'".$row['branch_id']."',
							'".$row['branch_name']."',
							'".$row['check_in_date']."',
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
							''
						)");
					}
				}		
			}
		}
	}
}
if($mysqli->query("insert into corn_jobs_log values(
	'',
	'Member Available Date Manage & Rental Issue',
	'".date("l")."',
	'".date("h:i:sa")."',
	'".date("d/m/Y")."'
)")){
	$message = 'Message From Corn Jobs (Member Available Date Manage). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms($dev_number,$message);
}else{
	$message = 'Something wrong! Message From Corn Jobs (Member Available Date Manage). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms($dev_number,$message);
}
?>