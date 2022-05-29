<?php error_reporting(0);
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['accept_id'])){
	$id = $_POST['accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_fired_list where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_fired_list set
		aproval = '1'
		where id = '".$id."'
	")){
		// deleting from set_department_head_logs if employee is department head.
		$mysqli->query("delete from set_department_head_logs where employee_id = '".$emp['employee_id']."'");
		
		if($mysqli->query("insert into employee_fired_aproval values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',
			'Approved By ".$_SESSION['super_admin']['email']."',
			'1',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			
			if($mysqli->query("insert into exit_employee_chain_hr values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'0',
				'',
				'1',
				'".uploader_info()."',
				'".date('d/m/Y')."'
			)")){ 
				echo 'Approved Successfully';
			}else{
				echo 'Something Wrong! Please Try again';
			}		
		}else{
			echo 'Something Wrong! Please Try again';
		}
	}else{
		echo 'Something Wrong! Please Try again';
	}
}
if(isset($_POST['rejected_id'])){
	$id = $_POST['rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_fired_list where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_fired_list set
		aproval = '2'
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_fired_aproval values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Rejected By ".$_SESSION['super_admin']['email']."',
			'1',
			'".uploader_info()."',
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