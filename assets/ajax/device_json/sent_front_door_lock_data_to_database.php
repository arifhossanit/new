<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['door_open'])){
	$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where status = '1' and card_number = '".$_POST['door_open']."'"));
	$check_data = mysqli_fetch_assoc($mysqli->query("select * from front_door_logs where days = '".date('d')."' and month = '".date('m')."' and year = '".date('Y')."' and time = '".date('h:i:sa')."' and booking_id = '".$mem_info['booking_id']."'"));
	if($check_data['id'] == ''){	
		if($mysqli->query("insert into front_door_logs values(
			'',
			'".$mem_info['branch_id']."',
			'".$mem_info['booking_id']."',
			'".date('d')."',
			'".date('m')."',
			'".date('Y')."',
			'".date('h:i:sa')."',
			'',
			'1',
			'Door_lock_system',
			'".date('d/m/Y')."'
		)")){
			echo 'Door Open Successfully!';
		}else{
			echo 'Door Open Successfully & Something wrong in database!';
		}
	}
	
}
?>