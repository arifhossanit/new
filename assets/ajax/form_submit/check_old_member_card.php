<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['check_card'])){
	$new_list = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['check_card']."'"));
	$old_list = mysqli_fetch_assoc($mysqli->query("select * from old_members where card_no = '".$_POST['check_card']."'"));
	if(!empty($new_list['id']) OR !empty($old_list['id'])){
		echo '1';
	}else{
		echo '0';
	}
}
?>