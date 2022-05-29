<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['hidden_id'])){
	$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$_POST['hidden_id']."'"));
	if($mysqli->query("insert into hold_employe_logs values(
		'',
		'".$emp_info['id']."',
		'".$emp_info['employee_id']."',
		'1',
		'".$_POST['note']."',
		'1',
		'0',
		'".uploader_info()."',
		'".date('d/m/Y')."'
	)")){
		echo 'Employee HOLD Request Send Successfully!';
	}else{
		echo 'Something Wrong! Please Try again.';
	}
}
?>