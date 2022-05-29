<?php
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['hold_rejects_ids'])){
	foreach($_POST['hold_rejects_ids'] as $row ){
		$id = $row;
		$info = mysqli_fetch_assoc($mysqli->query("select * from hold_employe_logs where id = '".$id."'"));
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
		$mysqli->query("update hold_employe_logs set aproval = '2' where id = '".$id."' ");
		$mysqli->query("update employee set status = '1' where id = '".$emp['id']."' ");
		$mysqli->query("insert into employee_leave_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Hold Rejected',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)");
	}
	echo 'Rejected Successfully';
}
if(isset($_POST['hold_aproved_ids'])){
	foreach($_POST['hold_aproved_ids'] as $row ){
		$id = $row;
		$info = mysqli_fetch_assoc($mysqli->query("select * from hold_employe_logs where id = '".$id."'"));
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
		$mysqli->query("update hold_employe_logs set aproval = '1' where id = '".$id."' ");
		$mysqli->query("update employee set status = '2' where id = '".$emp['id']."' ");
		$mysqli->query("insert into employee_leave_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',
			'Hold Approved',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)");
	}
	echo 'Approved Successfully';
}
if(isset($_POST['hold_rejected_id'])){
	$id = $_POST['hold_rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from hold_employe_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update hold_employe_logs set
		aproval = '2'
		where id = '".$id."'
	")){
		if($mysqli->query("update employee set
			status = '1'
			where id = '".$emp['id']."'
		")){
			if($mysqli->query("insert into employee_leave_aproval_logs values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Rejected',
				'Hold Rejected',
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
	}else{
		echo 'Something Wrong! Please Try again';
	}
}
if(isset($_POST['hold_accept_id'])){
	$id = $_POST['hold_accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from hold_employe_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update hold_employe_logs set
		aproval = '1'
		where id = '".$id."'
	")){
		if($mysqli->query("update employee set
			status = '2'
			where id = '".$emp['id']."'
		")){
			if($mysqli->query("insert into employee_leave_aproval_logs values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Approved',
				'Hold Approved',
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
	}else{
		echo 'Something Wrong! Please Try again';
	}
}
//------------------------------------------------------------------------------------------------------------------
if(isset($_POST['rejected_id'])){
	$id = $_POST['rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($_POST['type'] == 'head'){
		$validate_update = $mysqli->query("update employee_leave_logs set h_aproval = '2' where id = '".$id."'");
	}else if($_POST['type'] == 'boss'){
		$validate_update = $mysqli->query("update employee_leave_logs set aproval = '2' where id = '".$id."'");
	}
	if($validate_update){
		if($mysqli->query("insert into employee_leave_aproval_logs values(
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

if(isset($_POST['rejected_id_head'])){
	$id = $_POST['rejected_id_head'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_leave_logs set
		h_aproval = '2'
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_leave_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Leave Rejected',
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


if(isset($_POST['leave_rejects_ids'])){
	foreach($_POST['leave_aproved_ids'] as $row){
		$id = $row;
		$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$id."'"));
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
		$mysqli->query("update employee_leave_logs set aproval = '2' where id = '".$id."' ");
		$mysqli->query("insert into employee_leave_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Leave Rejected',
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
		$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$id."'"));
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
		$mysqli->query("update employee_leave_logs set aproval = '1' where id = '".$id."' ");
		$mysqli->query("insert into employee_leave_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',
			'Leave Approved',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)");
	}
	echo 'Approved Successfully';
}

if(isset($_POST['accept_id'])){
	$id = $_POST['accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($_POST['type'] == 'head'){
		if($emp['department'] == '1810685559802248792' OR $emp['department'] == '2335318469842157306'){ // Food, Engineering and Maintenance
			$validate_update = $mysqli->query("update employee_leave_logs set h_aproval = '1', aproval = '1' where id = '".$id."'");
		}else{
			$validate_update = $mysqli->query("update employee_leave_logs set h_aproval = '1' where id = '".$id."'");
		}
	}else if($_POST['type'] == 'boss'){
		$validate_update = $mysqli->query("update employee_leave_logs set aproval = '1' where id = '".$id."'");
	}else if($_POST['type'] == 'housekeeping_head'){
		$housekeeping_incharge = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['h_id']."'"));
		$branch_incharge = mysqli_fetch_assoc($mysqli->query("select * from employee where d_head = 1 AND branch = '".$housekeeping_incharge['branch']."' AND department = '1806965207554226682'"));
		
		if(is_null($branch_incharge)){
			$get_hr = mysqli_fetch_assoc($mysqli->query("select * from employee where d_head = 1 AND department = '1383007286312996344'"));
			$head = $get_hr['id'];
		}else{
			$head = $branch_incharge['id'];
		}
		// var_dump($head);
		// print_r("update employee_leave_logs set h_id = '".$head."', h_aproval = '3' where id = '".$id."'");
		// exit();
		$validate_update = $mysqli->query("update employee_leave_logs set h_id = '".$head."', h_aproval = '3' where id = '".$id."'");
	}
	if($validate_update){
		if($mysqli->query("insert into employee_leave_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',
			'".$_POST['note']."',
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
}


if(isset($_POST['accept_id_head'])){
	$id = $_POST['accept_id_head'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("UPDATE employee_leave_logs set
		h_aproval = '1'
		where id = '".$id."'
	")){
		if($mysqli->query("INSERT into employee_leave_aproval_logs values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Approved',
			'Leave Approved',
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

if(isset($_POST['view_approved_ids'])){
?>
<div class="row">
	<div class="col-sm-12">
		<?php
			echo '<ul class="list-group">';
			$info = $mysqli->query("select * from employee_leave_aproval_logs where leave_id = '".$_POST['view_approved_ids']."'");
			while($row = mysqli_fetch_assoc($info)){
				$get_uploader_info = explode('___',$row['uploader_info']);
				$get_employee_name = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where email = '".$get_uploader_info[1]."'"));
				echo '<li class="list-group-item"><p><span style="font-size: 1.1rem" class="text-secondary">'.$get_employee_name['full_name'].'</span> : <span style="font-size: 1.3rem">'.$row['note'].'</span></p></li>';
			}
	  		echo '</ul>';			
		?>
	</div>
</div>
<?php } ?>