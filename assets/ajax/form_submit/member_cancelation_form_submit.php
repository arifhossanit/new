<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));	
	if($_POST['cancelation_type'] == '1'){
		$number = $member_info['phone_number'];
		$message = $_POST['reminder_message'];
		if(sendsms($number,$message)){
			if($mysqli->query("insert into member_reminder_message values(
				'',
				'".$mysqli->real_escape_string($mysqli->$member_info['branch_id'])."',
				'".$mysqli->real_escape_string($member_info['booking_id'])."',
				'".$mysqli->real_escape_string($message)."',
				'".$mysqli->real_escape_string($_POST['reminder_remarks'])."',
				'".$mysqli->real_escape_string(date('d'))."',
				'".$mysqli->real_escape_string(date('m'))."',
				'".$mysqli->real_escape_string(date('Y'))."',
				'".$mysqli->real_escape_string(date('h:i:sa'))."',
				'',
				'1',
				'".$mysqli->real_escape_string($_SESSION['super_admin']['email'])."',
				'".$mysqli->real_escape_string(date('d/m/Y'))."'
			)")){
				echo 'Reminder SMS Send successfully____0';
			}else{
				echo 'Something wrong in DATABASE section! Please try again____1';
			}
		}else{
			echo 'Something wrong in SMS section! Please try again____1';
		}
	} else if ($_POST['cancelation_type'] == '2') {
		
	} else if ($_POST['cancelation_type'] == '3') {
		
	} else if ($_POST['cancelation_type'] == '4') {
		
	}else{
		
	}
}
?>