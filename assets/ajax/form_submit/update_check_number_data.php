<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['check_id'])){
	$check_number = mysqli_fetch_assoc($mysqli->query("select * from check_print_data where check_no = '".$_POST['new_number']."'"));
	if(!empty($check_number['check_no'])){
		echo 'This Number Allready Exixt! Please Try again';
	}else{
		if($mysqli->query("insert into check_number_update_logs values(
			'',
			'".$_POST['check_id']."',
			'".$_POST['old_number']."',
			'".$_POST['new_number']."',
			'".$_POST['change_note']."',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			if($mysqli->query("UPDATE check_print_data SET
				check_no = '".$_POST['new_number']."'
				WHERE id = '".$_POST['check_id']."'
			")){			
				echo 'Card Number Successfully Changed!';
			}else{
				echo 'Something wrong! Please Try again';
			}
		}else{
			echo 'Something wrong! Please Try again';
		}		
	}
}
?>