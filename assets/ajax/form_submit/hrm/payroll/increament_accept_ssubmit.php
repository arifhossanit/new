<?php
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['dec_accept_id'])){
	$id = $_POST['dec_accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_decreament_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	$desig = mysqli_fetch_assoc($mysqli->query("select * from designation where designation_id = '".$info['designation']."'"));
	if($mysqli->query("update employee_decreament_logs set
		aproval = '1'
		where id = '".$id."'
	")){
		if($mysqli->query("update employee set
			designation = '".$desig['designation_id']."',
			designation_name = '".$desig['designation_name']."'
			where id = '".$emp['id']."'
		")){
			notification(
				'Decreament', 
				'Decreament Aproved', 
				'http://erp.superhostelbd.com/super_home/admin',
				$emp['employee_id'],
				'',
				'1',
				$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']
			);
			$get_hr = mysqli_fetch_assoc($mysqli->query("select * from employee where department = '1383007286312996344' and d_head = '1'"));
			notification(
				'Decreament', 
				'Decreament Aproved', 
				'http://erp.superhostelbd.com/super_home/admin/hrm/payroll/increament-approval',
				$get_hr['employee_id'],
				'',
				'1',
				$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']
			);
			if($mysqli->query("insert into employee_decreament_approval values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Approved',
				'Approved',
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

if(isset($_POST['dec_rejected_id'])){
	$id = $_POST['dec_rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_decreament_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_decreament_logs set
		aproval = '2'
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_decreament_approval values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Rejected',
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
if(isset($_POST['accept_id'])){
	$id = $_POST['accept_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_increament_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	$desig = mysqli_fetch_assoc($mysqli->query("select * from designation where designation_id = '".$info['designation']."'"));
	if($mysqli->query("update employee_increament_logs set
		aproval = '1'
		where id = '".$id."'
	")){
		if($mysqli->query("update employee set
			designation = '".$desig['designation_id']."',
			designation_name = '".$desig['designation_name']."'
			where id = '".$emp['id']."'
		")){
			notification(
				'Increament', 
				'Increament Aproved', 
				'http://erp.superhostelbd.com/super_home/admin',
				$emp['employee_id'],
				'',
				'1',
				$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']
			);
			$get_hr = mysqli_fetch_assoc($mysqli->query("select * from employee where department = '1383007286312996344' and d_head = '1'"));
			notification(
				'Increament', 
				'Increament Aproved', 
				'http://erp.superhostelbd.com/super_home/admin/hrm/payroll/increament-approval',
				$get_hr['employee_id'],
				'',
				'1',
				$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']
			);
			if($mysqli->query("insert into employee_increament_approval values(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'".$info['id']."',
				'Approved',
				'Approved',
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
if(isset($_POST['rejected_id'])){
	$id = $_POST['rejected_id'];
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_increament_logs where id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."'"));
	if($mysqli->query("update employee_increament_logs set
		aproval = '2'
		where id = '".$id."'
	")){
		if($mysqli->query("insert into employee_increament_approval values(
			'',
			'".$emp['id']."',
			'".$emp['employee_id']."',
			'".$info['id']."',
			'Rejected',
			'Rejected',
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


if(isset($_POST['view_increament_info_id'])){
	if($_POST['view_increament_type'] == 1){
		$data = 'Increament';
		$row = mysqli_fetch_assoc($mysqli->query("select * from employee_increament_logs where id = '".$_POST['view_increament_info_id']."'"));
	}else{
		$data = 'Decreament';
		$row = mysqli_fetch_assoc($mysqli->query("select * from employee_decreament_logs where id = '".$_POST['view_increament_info_id']."'"));
	}
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$row['e_db_id']."'"));
	
	$increament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_increament_logs where e_db_id = '".$emp['id']."' and aproval = '1'"));
	$decreament = mysqli_fetch_assoc($mysqli->query("select sum(amount) as total from employee_decreament_logs where e_db_id = '".$emp['id']."' and aproval = '1'"));
	
	$old_deg = mysqli_fetch_assoc($mysqli->query("select * from designation  where designation_id = '".$row['old_designation']."'"));
	$new_deg = mysqli_fetch_assoc($mysqli->query("select * from designation  where designation_id = '".$row['designation']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table style="width:100%;">
			<tr>
				<td>Name</td>
				<td>:</td>
				<td><b><?php echo $emp['full_name'].' - '.$emp['employee_id']; ?></b></td>
			</tr>
			
			<tr>
				<td>Department</td>
				<td>:</td>
				<td><b><?php echo $emp['department_name']; ?></b></td>
			</tr>
			
			<tr>
				<td>D:From</td>
				<td>:</td>
				<td><b style="<?php if($_POST['view_increament_type'] == 1){ echo 'color:red;'; }else{ echo 'color:green;'; } ?>"><?php echo $old_deg['designation_name']; ?></b></td>
			</tr>
			
			<tr>
				<td>D:TO</td>
				<td>:</td>
				<td><b style="<?php if($_POST['view_increament_type'] == 1){ echo 'color:green;'; }else{ echo 'color:red;'; } ?>"><?php echo $new_deg['designation_name']; ?></b></td>
			</tr>
			
			<tr>
				<td>Joining Salary</td>
				<td>:</td>
				<td><b style="color:blue;"><?php echo money($emp['basic_salary']); ?></b></td>
			</tr>
			<tr>
				<td>Total Increament</td>
				<td>:</td>
				<td><b style="color:green;"><?php echo money($increament['total']); ?></b></td>
			</tr>			
			<tr>
				<td>Total Decreament</td>
				<td>:</td>
				<td><b style="color:red;"><?php echo money($decreament['total']); ?></b></td>
			</tr>
			<tr>
				<td>Runing Salary</td>
				<td>:</td>
				<td><b style="color:black;"><?php $rs = $emp['basic_salary'] + $increament['total'] - $decreament['total']; echo money($rs); ?></b></td>
			</tr>			
			<?php if($row['aproval'] == 0){ ?>
			<tr>
				<td>New <?php echo $data; ?></td>
				<td>:</td>
				<td><b style="<?php if($_POST['view_increament_type'] == 1){ echo 'color:green;'; }else{ echo 'color:red;'; } ?>"><?php echo money($row['amount']); ?></b></td>
			</tr>
			<tr>
				<td>Aftar Aproval</td>
				<td>:</td>
				<td><b style="color:black;"><?php ($_POST['view_increament_type'] == 1) ? $aft_a = $rs + $row['amount'] : $aft_a = $rs - $row['amount']; echo money($aft_a); ?></b></td>
			</tr>
			<tr>
				<td>Date</td>
				<td>:</td>
				<td><b style="color:black;"><?php echo $row['data']; ?></b></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>:</td>
				<td><button type="button" class="btn btn-info btn-xs">Pending!</button></td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td><?php echo $data; ?> Amount</td>
				<td>:</td>
				<td><b style="<?php if($_POST['view_increament_type'] == 1){ echo 'color:green;'; }else{ echo 'color:red;'; } ?>"><?php echo money($row['amount']); ?></b></td>
			</tr>
			<tr>
				<td>Date</td>
				<td>:</td>
				<td><b style="color:black;"><?php echo $row['data']; ?></b></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>:</td>
				<td><button type="button" class="btn btn-success btn-xs">Approved!</button></td>
			</tr>
			<tr>
				<td>Note</td>
				<td>:</td>
			<td><?php echo $row['note']?>></td>
			</tr>
			<?php } ?>
		</table>
		<hr />
		<h3>History</h3>
		<table style="width:100%;">
		<?php 
			if($_POST['view_increament_type'] == 1){
				$sql = $mysqli->query("select * from employee_increament_logs where e_db_id = '".$emp['id']."' and aproval = '1'");
			}else{
				$sql = $mysqli->query("select * from employee_decreament_logs where e_db_id = '".$emp['id']."' and aproval = '1'");
			}
			while($in = mysqli_fetch_assoc($sql)){
		?>
			<tr>
				<td><?php echo $in['data']; ?></td>
				<td>:</td>
				<td><b><?php echo money($in['amount']); ?></b></td>
			</tr>
		<?php } ?>
		</table>
	</div>
</div>
<?php } ?>