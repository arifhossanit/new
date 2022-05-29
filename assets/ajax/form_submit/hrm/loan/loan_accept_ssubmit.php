<?php
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['accept_id'])){
	$id = $_POST['accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_grant_loan where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($_POST['type'] == 'boss'){
		if($mysqli->query("update employee_grant_loan set
			aproval = '1'
			where id = '".$id."'
		")){
			if($mysqli->query("insert into employee_loan_aproval values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Approved',
				'".$_POST['note']."',
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
	}else if($_POST['type'] == 'd_head'){
		if($mysqli->query("update employee_grant_loan set
			aproval = '0'
			where id = '".$id."'
		")){
			if($mysqli->query("insert into employee_loan_aproval values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Approved',
				'".$_POST['note']."',
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
}
if(isset($_POST['rejected_id'])){
	$id = $_POST['rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_grant_loan where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($_POST['type'] == 'boss'){
		if($mysqli->query("update employee_grant_loan set
			aproval = '2'
			where id = '".$id."'
		")){
			if($mysqli->query("insert into employee_loan_aproval values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Rejected',
				'".$_POST['note']."',
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
	}else if($_POST['type'] == 'd_head'){
		if($mysqli->query("update employee_grant_loan set
			aproval = '4'
			where id = '".$id."'
		")){
			if($mysqli->query("insert into employee_loan_aproval values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Rejected',
				'".$_POST['note']."',
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
}
?>