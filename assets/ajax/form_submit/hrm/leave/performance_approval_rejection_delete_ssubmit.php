<?php
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['rejected_id'])){
	$id = $_POST['rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_performance_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_performance_logs set
		aproval = '2'
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_performance_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',".
			"'".$mysqli -> real_escape_string($_POST['approval_note'])."',"
			."'1',
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
if(isset($_POST['leave_rejects_ids'])){
	foreach($_POST['leave_aproved_ids'] as $row){
		$id = $row;
		$info = mysqli_fetch_assoc($mysqli->query("select * from employee_performance_logs where id = '".$id."'"));
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
		$mysqli->query("update employee_performance_logs set aproval = '2' where id = '".$id."' ");
		$mysqli->query("insert into employee_performance_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Performance Rejected',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)");
	}
	echo 'Rejected Successfully';
}

if(isset($_POST['leave_aproved_ids'])){
	foreach($_POST['leave_aproved_ids'] as $row){
		$id = $row;
		$info = mysqli_fetch_assoc($mysqli->query("select * from employee_performance_logs where id = '".$id."'"));
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
		$mysqli->query("update employee_performance_logs set aproval = '1' where id = '".$id."' ");
		$mysqli->query("insert into employee_performance_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',
			'Performance Approved',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)");
	}
	echo 'Approved Successfully';
}

if(isset($_POST['accept_id'])){
	$id = $_POST['accept_id'];
	$final_percentage = $_POST['final_percentage'];
	$pay_cut = 0;
	$approval = '1';

	if($final_percentage < 0){
		$pay_cut = 1;
	}

	if($final_percentage == 0){
		$approval = '2';
	}

	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_performance_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("UPDATE employee_performance_logs set
		aproval = '$approval', percentage = ".abs($final_percentage).", pay_cut = $pay_cut
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_performance_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',".
			"'".$mysqli -> real_escape_string($_POST['approval_note'])."',"
			."'1',
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
?>