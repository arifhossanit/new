<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['uploader_info'])){
	$check_phone_number = mysqli_fetch_assoc($mysqli->query("select * from add_extrarecharge_number where phone_number = '".$_POST['phone_number']."'"));
	if(!empty($check_phone_number['id'])){
		echo 'Phone Number Allerady Exixt! Please Try again';
	}else{
		if($mysqli->query("insert into add_extrarecharge_number values(
			'',
			'".$_POST['employee_id']."',
			'".$_POST['purpose']."',
			'".$_POST['phone_number']."',
			'".$_POST['amount']."',
			'',
			'1',
			'".$_POST['employee_id']."',
			'".date('d/m/Y')."'
		)")){
			echo 'Data Successfully Saved';
		}else{
			echo 'Something Wrong! Please Try again';
		}
	}
}
if(isset($_POST['post_id'])){
	if($mysqli->query("delete from add_extrarecharge_number where id = '".$_POST['post_id']."'")){
		echo 'Data Successfully Delete';
	}else{
		echo 'Something Wrong! Please Try again';
	}
}
?>