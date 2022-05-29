<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['get_id'])){
$employee = mysqli_fetch_assoc($mysqli->query("select * from employee where personal_Phone = '".$_POST['get_id']."' or Company_phone = '".$_POST['get_id']."'"));
$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where phone_number = '".$_POST['get_id']."' or card_number = '".$_POST['get_id']."'"));
	if(!empty($employee['id'])){
		echo '1____1';
	}else if(!empty($member['id'])){
		echo '1____2';
	}else{
		echo '0';
	}
} 
?>