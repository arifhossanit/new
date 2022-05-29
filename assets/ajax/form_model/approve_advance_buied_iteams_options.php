<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['transaction_id'])){
	$logs = mysqli_fetch_assoc($mysqli->query("select * from advance_transaction_logs where transaction_id = '".$_POST['transaction_id']."'"));
	if(!empty($_SESSION['super_admin']['email'])){
		$approval_update = "update advance_transaction_logs set
			approval = '1'
			where id = '".$logs['id']."'
		";
		$insert_approval_logs = "insert into advance_petty_approval_logs values(
			'',
			'".$mysqli->real_escape_string($logs['transaction_id'])."',
			'".$mysqli->real_escape_string($logs['employee_id'])."',
			'".$mysqli->real_escape_string($logs['amount'])."',
			'',
			'1',
			'".$mysqli->real_escape_string($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'])."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)";
		if(
			$mysqli->query($approval_update) AND
			$mysqli->query($insert_approval_logs)			
		){
			echo 'Transaction Approved Successfully!';
		}else{
			echo 'Something Wrong! Please Tray again';
		}
	}else{
		echo 'Your Session is expired! Please Refresh your page';
	}

} ?>