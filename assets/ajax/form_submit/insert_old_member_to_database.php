<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['phone_number'])){
	$check_number = mysqli_fetch_assoc($mysqli->query("SELECT * FROM old_members WHERE phone_number = '".$_POST['phone_number']."'"));
	if(!empty($check_number['id'])){
		echo 'Phhone Number All Ready Exixt! Please Try again';
	}else{
		if($mysqli->query("INSERT INTO old_members VALUES(
			'',
			'".$_POST['full_name']."',
			'".$_POST['phone_number']."',
			'".$_POST['status']."',
			'".$_POST['card_number']."',
			'".$_POST['checkin_date']."',
			'".$_SESSION['super_admin']['user_type']."___".$_SESSION['super_admin']['email']."___".$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)")){
			echo 'Data Insert Successfully!';
		}else{
			echo 'Something wrong! Please Try again';
		}
	}
}
?>