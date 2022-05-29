<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['door_open'])){
	$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where status = '1' and card_number = '".$_POST['door_open']."' and branch_id = '".$_POST['branch_id']."'"));
	$auto_cancel_check = mysqli_fetch_assoc($mysqli->query("SELECT * FROM cencel_request where booking_id = '".$mem_info['booking_id']."' AND note = 'Request For Cancel for rental payment issue (auto cancel from software)'"));
	if(empty($auto_cancel_check['id'])){
		if(!empty($mem_info['id'])){
			echo '1';
		}else{
			echo '0';
		}
	}else{
		echo '0';
	}
}
?>