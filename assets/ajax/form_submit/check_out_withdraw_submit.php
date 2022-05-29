<?php
include("../../../application/config/ajax_config.php");
if(!isset($_POST['member_id'])){
	return;
}
$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));	
$crd_packages = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_info['package']."'"));


if(!empty($_POST['checkout_iteam'])){
	$not_returned_items_array = array_diff($_POST['checkout_iteam'], [0]) ;
	$not_returned_items = implode(",", $not_returned_items_array);
}else{
	$not_returned_items = null;
}
// New code to store returns items
$to_returned_items = array();
if(!empty($not_returned_items)){
	$returnd_items_sql = $mysqli->query("select id from checkout_iteam 
		where branch_id = '".$member_info['branch_id']."' and status = '1' and id not in($not_returned_items)
	");

	foreach($returnd_items_sql as $retrun_items){
		$to_returned_items[] = $retrun_items['id'];
	}
}
$returned_items = implode(",", $to_returned_items);
if($returned_items){
	$returned_items = $returned_items;
}else{
	$returned_items = '';
}
// New code to store returns items end.

// new gula new style a show hobe old gula old style a show hobe.
$additional_field_arr = array();

if(!empty($_POST['af_field_name'])){
	foreach($_POST['af_field_name'] as $row=> $value){
		$additional_field_arr[$_POST['af_field_name'][$row]] = $_POST['af_amount'][$row];
	}
}
$additional_field = json_encode($additional_field_arr);
$card_number = time();


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
	$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']["branch"]."'"));
}else{
	$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$row['branch_id']."'"));
}
$transaction_id = $bc['branch_code'].'-'.$today;
$transaction_idO = $transaction_id;
if(!empty($_POST['total_amount']) AND $_POST['total_amount'] > 0){
	$payment_method = '';
	$data_one = '';
	$data_two = '';
	$data_three = '';
	$payment_details = '';
	$p_branch_id = $member_info['branch_id'];
	$p_booking_id = $member_info['booking_id'];
	$p_uploader_info = base64_decode($_POST['uploader_info']);
	$p_table = 'withdraw_checkout';
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
}else{
	$payment_method = '';
	$data_one = '';
	$data_two = '';
	$data_three = '';
}
//--------end payment method------
if(!empty($_POST['total_amount']) AND $_POST['total_amount'] > 0){
	$amount = (float)$_POST['total_amount'];
}else{
	$amount = '0';
}	
$result_amnt = $member_info['security_deposit'] - $amount;
$member_up_in = "update member_directory set
	card_number = '".$card_number."',
	security_deposit = '".$result_amnt."',
	status = '3',
	bed_id = '0'
	where id = '".$member_info['id']."'
";
$booking_info = "update booking_info set
	card_no = '".$card_number."',
	security_deposit = '".$result_amnt."',
	status = '2'
	where booking_id = '".$member_info['booking_id']."'
";	
$rent_info = "update rent_info set
	card_no = '".$card_number."'
	where booking_id = '".$member_info['booking_id']."'
";
$bed_id = $member_info['bed_id'];
$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT * FROM member_directory WHERE bed_id = '".$bed_id."' AND id != '".$member_info['id']."' AND status = 1"));
if(is_null($get_bed_number)){
	$bed_info = "update beds set
		uses = '0'
		where id = '".$member_info['bed_id']."'
	";
}else if($get_bed_number['card_number'] == 'Unauthorized'){
	$bed_info = "update beds set
		uses = '2'
		where id = '".$member_info['bed_id']."'
	";
}else{
	$bed_info = "update beds set
		uses = '3'
		where id = '".$member_info['bed_id']."'
	";
}
$check_data_withdraw = mysqli_fetch_assoc($mysqli->query("select * from withdraw_checkout where booking_id = '".$mysqli->real_escape_string($member_info['booking_id'])."' and member_id = '".$mysqli->real_escape_string($member_info['id'])."' and note = '".$mysqli->real_escape_string($_POST['note'])."'"));
if(empty($check_data_withdraw['id'])){
	$checkout_info = "insert into withdraw_checkout values(
		'',
		'".$mysqli->real_escape_string($member_info['booking_id'])."',
		'".$mysqli->real_escape_string($member_info['id'])."',
		'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
		'".$mysqli->real_escape_string($not_returned_items)."',		
		'".$mysqli->real_escape_string($additional_field)."',
		'".$mysqli->real_escape_string($amount)."',		
		'".$mysqli->real_escape_string($payment_method)."',
		'".$mysqli->real_escape_string($data_one)."',
		'".$mysqli->real_escape_string($returned_items)."',
		'".$mysqli->real_escape_string($data_three)."',		
		'".$mysqli->real_escape_string($_POST['note'])."',
		'1',
		'".$mysqli->real_escape_string(base64_decode($_POST['uploader_info']))."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."' 
	)";
	$mysqli->query($checkout_info);
}	


if(!empty($_POST['total_amount']) AND $_POST['total_amount'] > 0){
	$mysqli->query("insert into transaction values(
		'',
		'".$mysqli->real_escape_string($transaction_idO)."',
		'".$mysqli->real_escape_string($member_info['branch_id'])."',
		'".$mysqli->real_escape_string($member_info['booking_id'])."',
		'".$mysqli->real_escape_string($member_info['full_name'])."',
		'Defult',
		'Defult',
		'".$mysqli->real_escape_string($amount)."',
		'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
		'Credit',
		'Rental Account',			
		'".$mysqli->real_escape_string($payment_method)."',
		'".$mysqli->real_escape_string($data_one)."',
		'".$mysqli->real_escape_string($data_two)."',
		'".$mysqli->real_escape_string($data_three)."',
		'CheckOut iteams Fine Collection',
		'1',
		'".$mysqli->real_escape_string(base64_decode($_POST['uploader_info']))."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."'
	)");
	$last_id = isset($mysqli->insert_id) ? $mysqli->insert_id : null;
}

$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$mysqli->real_escape_string($member_info['branch_id'])."'"));
if(!empty($branch['branch_phone_number'])){
	$phone_number = $branch['branch_phone_number'];
}else{
	$phone_number = '+8809638666333';
}

if(isset($last_id)){
	echo $last_id;
}


if(isset($_POST['send_sms'])){
	if($_POST['send_sms'] == '1'){
		$check_out_confirmation = $mysqli->query("insert into checkOut_confirmation values(
			'',
			'".$member_info['booking_id']."',
			'0'
		)");
		$mysqli->query($check_out_confirmation);
		$encrypt_booking_id = rahat_encode($member_info['id']);
		$generated_link = $home.'checkout-verify/'.$encrypt_booking_id;
		$sms_message = 'Mr. '.$member_info['full_name'].',Click the link '.$generated_link.' to confitm your checkout. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
	}else{
		$check_out_confirmation = $mysqli->query("insert into checkOut_confirmation values(
			'',
			'".$member_info['booking_id']."',
			'1'
		)");
		$sms_message = 'Mr. '.$member_info['full_name'].',You Checked Out Successfully from Super Home. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
	}	
}else{
	$sms_message = 'Mr. '.$member_info['full_name'].',You Checked Out Successfully from Super Home. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.'';
}

if(
	$mysqli->query($booking_info)
	AND		
	$mysqli->query($bed_info)
	AND 
	$mysqli->query($member_up_in)
	AND 
	$mysqli->query($rent_info)
){
	if(sendsms($member_info['phone_number'],$sms_message)){
		$message = 'Mr. '.$member_info['full_name'].',You Checked Out Successfully from Super Home. Thank You For Stay With US. For any Query Feel free to call US +8809638666333';
		if(main_email('SUPER HOME MEMBER: CHECKOUT INFORMATION',$message,'','',$member_info['email'],$member_info['full_name'])){
			echo 'Checked out Submitted Successfully!____0____' . $member_info['card_number'];
		}else{
			echo 'Something Wrong In MAIL section! Checked out Submitted Successfully!____0';
		}				
	}else{
		echo 'Something Wrong In SMS section!Checked out Submitted Successfully!____0';
	}		
}else{
	echo 'Something Wrong! Please Try Again____1';
}
?>