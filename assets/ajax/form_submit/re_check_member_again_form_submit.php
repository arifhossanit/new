<?php 
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
if(isset($_POST['form_submit'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));
	$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$_POST['new_bed_id']."'"));
	$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));
	$cin = explode("-",$_POST['check_in_date']);
	$check_in = $cin[2].'/'.$cin[1].'/'.$cin[0];
	
	$electricity_bill = $package['package_price'] - $_POST['old_deposit'];
	
	if($cin[1] == date('m')){
		$days = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y')) - $cin[2] + 1;
		$number_days = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
		$month = date('m');
	}else{
		$days = cal_days_in_month(CAL_GREGORIAN,$cin[1],$cin[0]) - $cin[2] + 1;
		$number_days = cal_days_in_month(CAL_GREGORIAN,$cin[1],$cin[0]);
		$month = $cin[1];
	}
	$rent_amountt = $package['monthly_rent'] / $number_days;
	$rent = $rent_amountt * $days;
	$member_information = "update member_directory set
		floor_id = '".$bed_info['floor_id']."',
		floor_name = '".$bed_info['floor_name']."',
		unit_id = '".$bed_info['unit_id']."',
		unit_name = '".$bed_info['unit_name']."',
		room_id = '".$bed_info['room_id']."',
		room_name = '".$bed_info['room_name']."',
		bed_id = '".$bed_info['id']."',
		bed_name = '".$bed_info['bed_name']."',
		check_in_date = '".$check_in."',
		card_number = '".$_POST['card_number']."',
		check_out_date = 'Not Confirm Yet',
		bet_type = '".$row['bet_type']."',
		security_deposit = '".$package['package_price']."',
		rent_amount = '".$package['monthly_rent']."',
		note = '',
		status = '1',
		data = '".date('d/m/Y')."'
		where id = '".$row['id']."'
	";
	$booking_information = "update booking_info set
		checkin_date = '".$check_in."',
		checkout_date = 'Not Confirm Yet',
		card_no = '".$_POST['card_number']."',
		bed_id = '".$bed_info['id']."',
		bed_name = '".$bed_info['bed_name']."',
		security_deposit = '".$package['package_price']."',
		rent_amount = '".$rent."',
		available_days = '0',
		status = '1',
		uploader_info = '".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
		data = '".date('d/m/Y')."'
		where booking_id = '".$row['booking_id']."'
	";
	$booking_receipt_information = "update booking_receipt_logs set
		note = 'Re-Checkin Date: ".$check_in."'
		where booking_id = '".$row['booking_id']."'
	";
	$cencal_information = "delete from cencel_request where booking_id = '".$row['booking_id']."'";
	$widthdraw_check_out_information = "delete from withdraw_checkout where booking_id = '".$row['booking_id']."'";
	$recheckin_log_information = "insert into recheckin_log_information values(
		'',
		'".$row['booking_id']."',
		'',
		'1',
		'".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
		'".date('d/m/Y')."'
	)";
	if($row['parking'] == '1'){
		$parking_amount = $row['parking_amount'];
	}else{
		$parking_amount = '0';
	}
	if(!empty($row['locker_amount']) AND $row['locker_amount'] > 0){
		$locaker = $row['locker_amount'];
	}else{
		$locaker = '0';
	}
	$total = $electricity_bill + $rent;
	$rent_insert_data = "insert into rent_info values(
		'',
		'".$mysqli->real_escape_string($row['booking_id'])."',
		'".$mysqli->real_escape_string($row['branch_id'])."',
		'".$mysqli->real_escape_string($row['branch_name'])."',
		'".$mysqli->real_escape_string($check_in)."',
		'Not Confirm Yet',
		'".$mysqli->real_escape_string($package['package_category_id'])."',
		'".$mysqli->real_escape_string($package['package_category_name'])."',
		'".$mysqli->real_escape_string($package['id'])."',
		'".$mysqli->real_escape_string($package['package_name'])."',
		'".$mysqli->real_escape_string($_POST['card_number'])."',
		'".$mysqli->real_escape_string($row['full_name'])."',
		'".$mysqli->real_escape_string($rent)."',
		'".$mysqli->real_escape_string($parking_amount)."',
		'".$mysqli->real_escape_string($electricity_bill)."',
		'0',
		'".$mysqli->real_escape_string($total)."',
		'0',
		'".$mysqli->real_escape_string($locaker)."',
		'0',
		'0', 
		'Due',
		'2',
		'1',
		'1',			
		'',
		'',
		'Recheck',			
		'',				
		'',
		'',
		'1',
		'".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
		'".$mysqli->real_escape_string(month_name($month))."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."',
		''
	)";
	$bed_information = "update beds set uses = '3' where id = '".$bed_info['id']."'";
	if(
		$mysqli->query($member_information) AND
		$mysqli->query($booking_information) AND
		$mysqli->query($booking_receipt_information) AND
		$mysqli->query($cencal_information) AND
		$mysqli->query($widthdraw_check_out_information) AND
		$mysqli->query($recheckin_log_information) AND
		$mysqli->query($bed_information) AND
		$mysqli->query($rent_insert_data) 
	){
		echo 'Member Recheck SuccessFully';
	}else{
		echo 'Something wrong! Please try again';
	}
}
?>