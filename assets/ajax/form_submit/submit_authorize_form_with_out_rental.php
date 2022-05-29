<?php //error_reporting(0);@ini_set('display_errors', 0);
include("../../../application/config/ajax_config.php");
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
		$activity_logd = "insert into activity_log values(
			'',
			'".$mysqli->real_escape_string($booking_info['branch_id'])."',
			'".$mysqli->real_escape_string($booking_info['branch_name'])."',
			'".$mysqli->real_escape_string(base64_decode($_POST['uploader_infoe'])." is Athorized Mr. ".$booking_info['m_name']." As Member And give card number")."',
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
			$avaible_Days = $package_info['package_days'];
			if(
				$mysqli->query("update beds set uses = '3' where id = '".$member_infoooe['bed_id']."'")
				AND
				$mysqli->query("update booking_info set card_no = '".$_POST['card_numberss']."', checkin_date = '".date('d/m/Y')."', available_days = '".$avaible_Days."' where booking_id = '".$booking_info['booking_id']."'")
				AND
				$mysqli->query("update member_directory set card_number = '".$_POST['card_numberss']."', check_in_date = '".date('d/m/Y')."' where booking_id = '".$booking_info['booking_id']."'")
				AND
				$mysqli->query("update rent_info set card_no = '".$_POST['card_numberss']."', checkin_date = '".date('d/m/Y')."' where booking_id = '".$booking_info['booking_id']."'")
				AND
				$mysqli->query($activity_logd)
			){	
				$bK_id = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$booking_id."'"));
				if(sendsms($member_infoooe['phone_number'],'Dear, '.$booking_info['m_name'].' Your Athorization Successfully Done, Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/')){								
					$message = 'Mr. '.$booking_info['m_name'].' Your Athorization Successfully Done, Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/';									
					if(main_email('SUPER HOME MEMBER Athorozation information',$message,'','',$member_infoooe['email'],$member_infoooe['full_name'])){
						echo 'Athorized Successfeully Done In Try Us Package.____0____'.$bK_id['id'].'';
					}else{
						echo 'Something Wrong In MAIL section! Athorized Successfeully Done In Try Us Package.____0____'.$bK_id['id'].'';
					}				
				}else{
					echo 'Something Wrong In SMS section! Athorized Successfeully Done In Try Us Package.____0____'.$bK_id['id'].'';
				}			
			}else{			
				echo 'Something Wrong! Please Try again.____1';
			}
		}else{
			$card_chaeck = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['card_numberss']."'"));
			if(!empty($card_chaeck['card_number']) AND $member_infoooe['card_number'] == $_POST['card_numberss']){
				echo 'Card Number Already Exixt! Please Try again.____1';
			}else{
				$m_check_in = explode("/",$member_infoooe['check_in_date']); //30-05-2021 avaiable days update in athorize form membership
				$r_check_in = explode("/",date('d/m/Y'));
				$date_one = $m_check_in[0]; //20210603
				$date_two = $r_check_in[0]; //20210531			
				$date_one1 = $m_check_in[2].$m_check_in[1].$m_check_in[0]; //20210603
				$date_two1 = $r_check_in[2].$r_check_in[1].$r_check_in[0]; //20210531
				
				$date_one11 = $m_check_in[0].'/'.$m_check_in[1].'/'.$m_check_in[2]; //06032021
				$date_two11 = $r_check_in[0].'/'.$r_check_in[1].'/'.$r_check_in[2]; //05312021
				
				if($date_one1 == $date_two1){
					$in_date = $date_one;
					$ab_days = cal_days_in_month(CAL_GREGORIAN,$m_check_in[1],$m_check_in[2]) - $in_date + 1;			
					$rental_amount = ($package_info['monthly_rent'] / cal_days_in_month(CAL_GREGORIAN,$m_check_in[1],$m_check_in[2])) * $ab_days;				
					$check_in_date = $date_one11;
				}else if ($date_one1 > $date_two1){
					$in_date = $date_two;
					$ab_days = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y')) - $in_date + 1;			
					$rental_amount = ($package_info['monthly_rent'] / cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'))) * $ab_days;
					$check_in_date = $date_two11;
				}else if($date_one1 < $date_two1){
					$in_date = $date_one;
					$ab_days = cal_days_in_month(CAL_GREGORIAN,$m_check_in[1],$m_check_in[2]) - $in_date + 1;			
					$rental_amount = ($package_info['monthly_rent'] / cal_days_in_month(CAL_GREGORIAN,$m_check_in[1],$m_check_in[2])) * $ab_days;
					$check_in_date = $date_one11;
				}	
				
				$submitted_rent_status = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as verify from rent_info where rent_status = 'Paid' AND booking_id = '".$booking_info['booking_id']."'"));
				if($submitted_rent_status['verify'] == 0){
					$ab_days = 0;
				}
						
				if(
					$mysqli->query("update beds set uses = '3' where id = '".$member_infoooe['bed_id']."'")
					AND
					$mysqli->query("update booking_info set 
						card_no = '".$_POST['card_numberss']."', 
						checkin_date = '".$check_in_date."', 
						rent_amount = '".$rental_amount."', 
						available_days = '".$ab_days."' 
						where booking_id = '".$booking_info['booking_id']."'
					") AND
					$mysqli->query("update member_directory set 
						card_number = '".$_POST['card_numberss']."',
						check_in_date = '".$check_in_date."' 
						where booking_id = '".$booking_info['booking_id']."'
					") AND
					$mysqli->query("update rent_info set card_no = '".$_POST['card_numberss']."' where booking_id = '".$booking_info['booking_id']."'")
					AND
					$mysqli->query($activity_logd)			
				){
					$bK_id = mysqli_fetch_assoc($mysqli->query("SELECT * from booking_info where booking_id = '".$booking_id."'"));
					$rent_id = mysqli_fetch_assoc($mysqli->query("SELECT id from rent_info where booking_id = '".$booking_info['booking_id']."' ORDER BY id desc"));
					if(sendsms($member_infoooe['phone_number'],'Mr. '.$booking_info['m_name'].' Your Athorization Successfully Done, Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/')){
						$message = 'Mr. '.$booking_info['m_name'].' Your Athorization Successfully Done, Thank You For Stay With US. For any Query Feel free to call US +8809638666333 & For More Details Visit Here: https://www.superhomebd.com/';									
						if(main_email('SUPER HOME MEMBER Athorozation information',$message,'','',$member_infoooe['email'],$member_infoooe['full_name'])){
							echo 'Athorized Successfeully Done.____0____'.$bK_id['id'].'____'.$rent_id['id'];
						}else{
							echo 'Something Wrong In MAIL section! Athorized Successfeully Done.____0____'.$bK_id['id'].'____'.$rent_id['id'];
						}				
					}else{
						echo 'Something Wrong In SMS section! Athorized Successfeully Done.____0____'.$bK_id['id'].'____'.$rent_id['id'];
					}			
				}else{			
					echo 'Something Wrong! Please Try again.____1';
				}
			}		
		}
	}
}
?>