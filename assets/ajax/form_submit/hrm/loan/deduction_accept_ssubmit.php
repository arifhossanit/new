<?php
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['accept_id'])){
	$id = $_POST['accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_sallary_deduction where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_sallary_deduction set
		aproval = '1'
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_deduction_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',
			'Approved By ".$_SESSION['super_admin']['email']."',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)")){
			echo 'Approved Successfully';
		}else{
			echo 'Something Wrong! Please Try again';
		}
	}else{
		echo 'Something Wrong! Please Try again';
	}
}
if(isset($_POST['rejected_id'])){
	$id = $_POST['rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_sallary_deduction where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_sallary_deduction set
		aproval = '2'
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_deduction_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Rejected By ".$_SESSION['super_admin']['email']."',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)")){
			echo 'Rejected Successfully';
		}else{
			echo 'Something Wrong! Please Try again';
		}
	}else{
		echo 'Something Wrong! Please Try again';
	}
}
?>