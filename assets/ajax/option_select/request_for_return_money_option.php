<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['book_id'])){
	$booking_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM booking_info WHERE id = '".$_POST['book_id']."'"));
	$member_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory WHERE booking_id = '".$booking_info['booking_id']."'"));
	$actual_return_money = $_POST['actual_return_money'];
	$return_percentage = $_POST['return_percentage'];
	$return_money = $_POST['return_money'];
	$book_id = $_POST['book_id'];
	$return_note = $_POST['return_note'];
	$check_out_date = date('d/m/Y');
	$card_number = time();
	$dudct_percentage = 100 - (float)$return_percentage;
	$amount = (float)$actual_return_money - (float)$return_money;	
	$uploader_info = $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
	if($_FILES['provement_file']['name'] != ''){
		$permission_file = image_upload_permission_file('provement_file');
	}else{
		$permission_file = '';
	}	
	$cencel_info = "insert into cencel_request values(
		'',
		'".$mysqli->real_escape_string($member_info['booking_id'])."',
		'".$mysqli->real_escape_string($member_info['branch_id'])."',
		'".$mysqli->real_escape_string($member_info['id'])."',
		'".$mysqli->real_escape_string($member_info['bed_id'])."',
		'".$mysqli->real_escape_string($check_out_date)."',
		'".$mysqli->real_escape_string($return_note)."',
		'1',
		'".$mysqli->real_escape_string($uploader_info)."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."' 
	)";	
	$bed_id = $member_info['bed_id'];
	$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
	if($get_bed_number[0] > 1){
		$bed_update_query = "update beds set uses = '2' where id = '".$member_info['bed_id']."'";
	}else{
		$bed_update_query = "update beds set uses = '0' where id = '".$member_info['bed_id']."'";
	}
	$update_booking_info = "update booking_info set 
		status = '2', 
		checkout_date = '".$check_out_date."',
		card_no = '".$card_number."',
		security_deposit = '".$return_money."',
		count_reword = '1',
		status = '2'
		where booking_id = '".$member_info['booking_id']."'
	";
	$update_member_info = "update member_directory set
		card_number = '".$card_number."',
		security_deposit = '".$return_money."',
		check_out_date = '".$check_out_date."',
		status = '3',
		bed_id = '0'
		where id = '".$member_info['id']."'
	";
	$rent_info = "update rent_info set
		card_no = '".$card_number."'
		where booking_id = '".$member_info['booking_id']."'
	";
	$checkout_info = "insert into withdraw_checkout values(
		'',
		'".$mysqli->real_escape_string($member_info['booking_id'])."',
		'".$mysqli->real_escape_string($member_info['id'])."',
		'".$mysqli->real_escape_string(date('l, d/m/Y h:i:sa'))."',
		'',		
		'Deduct money ".$dudct_percentage."% For Request For Return Money',		
		'".$mysqli->real_escape_string($amount)."',		
		'',
		'',
		'',
		'',	
		'".$mysqli->real_escape_string($return_note)."',
		'1',
		'".$mysqli->real_escape_string($uploader_info)."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."' 
	)";
	$checkout_confirmation = "insert into checkout_confirmation values(
		'',
		'".$mysqli->real_escape_string($member_info['booking_id'])."',
		'1'
	)";
	$unthorized_return_diposit_money = "INSERT INTO unathorized_return_diposit_money_logs VALUES(
		'',	
		'".$mysqli->real_escape_string($member_info['booking_id'])."',		
		'".$actual_return_money."',
		'".$return_percentage."',
		'".$return_money."',
		'".$permission_file."',	
		'".$mysqli->real_escape_string($return_note)."',
		'1',
		'".$mysqli->real_escape_string($uploader_info)."',
		'".$mysqli->real_escape_string(date('d/m/Y'))."' 
	)";
	if(
		$mysqli->query($cencel_info) AND
		$mysqli->query($bed_update_query) AND
		$mysqli->query($update_booking_info) AND
		$mysqli->query($update_member_info) AND
		$mysqli->query($rent_info) AND
		$mysqli->query($unthorized_return_diposit_money) AND
		$mysqli->query($checkout_confirmation) AND
		$mysqli->query($checkout_info)
	){
		echo 'Data Successfully Submitted!';
	}else{
		echo 'Something Wrong! Please Try Again Later!';
	}	
}
?>