<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$member_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory where id = '".$_POST['member_id']."'"));
	$card_number = $member_info['card_number'];
	$password = $member_info['password'];
	$name = $member_info['full_name'];
	$number = $member_info['phone_number'];
	$message = 'Dear, '.$name.' Your member panel login details: URL: '.$home.'member/, UserID: '.$card_number.' & Password: '.$password.'. Thank You for stay with us. For More details visit: https://www.superhomebd.com/';
	if(sendsms($number,$message)){
		echo 'SMS Send Successfully';
	}else{
		echo 'Something wrong in SMS section! Please try again';
	}
}
?>