<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['e_db_id'])){
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$_POST['e_db_id']."'"));
	if($mysqli->query("insert into employee_unhold_logs values(
		'',
		'".$info['employee_id']."',
		'',
		'1',
		'".uploader_info()."',
		'".date('d/m/Y')."'
	)")){
		if($mysqli->query("update employee set status = '1' where id = '".$info['id']."'")){
			echo 'Unhold Successfully!';
		}else{
			echo 'Something wrong! Please try again.';
		}
	}else{
		echo 'Something wrong! Please try again.';
	}
}
?>