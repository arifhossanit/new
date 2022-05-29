<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['unique_id'])){ 
	$sms = mysqli_fetch_assoc($mysqli->query("select * from employee_missing_attendance_request where unique_id = '".rahat_decode($_POST['unique_id'])."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table style="width:100%;" class="table table-bordered">
			<tbody>
				<?php
					$sql = $mysqli->query("select * from employee_missing_attendance_request_date where unique_id = '".$sms['unique_id']."'");
					while($row = mysqli_fetch_assoc($sql)){
				?>
				<tr>
					<td><?php echo $row['adj_date']; ?> <small style="font-weight:bolder;">(<?php echo $row['adj_reason']; ?>)</small></td>
					<td><textarea class="form-control" id="text_note_<?php echo $row['id']; ?>" placeholder="Note"><?php if(!empty($row['hr_note'])){ echo $row['hr_note']; } ?></textarea></td>
					<td><?php if($row['is_hr_checked'] == '1'){ ?>
						<button type="button" class="btn btn-xs btn-success" style="float:right;">Checked!</button>
						<?php }else if($row['is_hr_checked'] == '2'){ ?> 
						<button type="button" class="btn btn-xs btn-danger" style="float:right;">Rejected!</button>
						<?php }else{ ?>
						<button onclick="return checked_by_hrm_hr('<?php echo $row['id']; ?>','<?php echo $_POST['unique_id']; ?>')" type="button" class="btn btn-xs btn-success" style="float:right;">Accept</button>
						<button onclick="return reject_by_hrm_hr('<?php echo $row['id']; ?>','<?php echo $_POST['unique_id']; ?>')" type="button" class="btn btn-xs btn-danger" style="float:right;margin-right:10px;">Reject</button>						
						<?php } ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>	
</div>
<?php } ?>
<?php
if(isset($_POST['boss_unique_id'])){ 
	$sms = mysqli_fetch_assoc($mysqli->query("select * from employee_missing_attendance_request where unique_id = '".rahat_decode($_POST['boss_unique_id'])."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table style="width:100%;" class="table table-bordered">
			<thead>
				<tr>
					<th>Date/Reason</th>
					<th>HR Note</th>
					<th>HR Status</th>
					<th>Diduction Amount(if Need)</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sql = $mysqli->query("select * from employee_missing_attendance_request_date where unique_id = '".$sms['unique_id']."'");
					while($row = mysqli_fetch_assoc($sql)){
				?>
				<tr>
					<td><?php echo $row['adj_date']; ?> <small style="font-weight:bolder;">(<?php echo $row['adj_reason']; ?>)</small></td>
					<td><textarea class="form-control" placeholder="Note" disabled><?php if(!empty($row['hr_note'])){ echo $row['hr_note']; } ?></textarea></td>
					<td><?php if($row['is_hr_checked'] == '1'){ ?>
						<button type="button" class="btn btn-xs btn-success" style="float:right;margin-right:10px;">Checked!</button>
						<?php }else if($row['is_hr_checked'] == '2'){ ?> 
						<button type="button" class="btn btn-xs btn-danger" style="float:right;margin-right:10px;">Rejected!</button>
						<?php }else{ ?>
						<button type="button" class="btn btn-xs btn-info" style="float:right;margin-right:10px;">Pending!</button>											
						<?php } ?>					
					</td>
					<td>
						<?php 
						if($row['aproval'] == '1'){ 
						$get_data = mysqli_fetch_assoc($mysqli->query("select * from boss_emp_missing_att_checked_logs where missing_att_id = '".$row['id']."'"));
						?>
						<input type="number" value="<?php if(!empty($get_data['deduction_amount'])){ echo $get_data['deduction_amount']; } ?>" class="form-control" placeholder="Amount" Disabled />
						<textarea class="form-control" placeholder="Note" disabled ><?php if(!empty($get_data['boss_note'])){ echo $get_data['boss_note']; } ?></textarea>
						<?php }else{ if($row['is_hr_checked'] == '1'){ ?>
						<input type="number" class="form-control" id="deduction_amount_<?php echo $row['id']; ?>" placeholder="Amount" <?php if($row['is_hr_checked'] == '1'){ }else{ ?>Disabled<?php } ?>/>
						<textarea class="form-control" id="text_note_<?php echo $row['id']; ?>" placeholder="Note"></textarea>
						<?php } }?>
					</td>
					<td>
						<?php if($row['aproval'] == '1'){ ?>
						<button type="button" class="btn btn-xs btn-success" style="float:right;margin-right:10px;">Approved!</button>
						<?php } else { if($row['is_hr_checked'] == '1'){ ?>
						<button onclick="return checked_by_hrm_hr('<?php echo $row['id']; ?>','<?php echo $_POST['boss_unique_id']; ?>')" type="button" class="btn btn-xs btn-success" style="float:right;margin-right:10px;">Accept</button>
						<button onclick="return reject_by_hrm_hr('<?php echo $row['id']; ?>','<?php echo $_POST['boss_unique_id']; ?>')" type="button" class="btn btn-xs btn-danger" style="float:right;margin-right:10px;">Reject</button>	
						<?php } } ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>	
</div>
<?php } ?>
<?php
if(isset($_POST['accept_checked_id'])){
	$id = $_POST['accept_checked_id'];
	$note = $_POST['note'];
	$info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_missing_attendance_request_date WHERE id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$info['employee_id']."'"));
	$checked_attendance = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where employee_id = '".$info['employee_id']."' and days = '".$info['days']."' and month = '".$info['month']."' and years = '".substr($info['years'],2)."'"));
	if(!empty($checked_attendance['id'])){
		echo 'Missing Date already in attendance list!';
	}else{
		if($mysqli->query("UPDATE employee_missing_attendance_request_date SET
			is_hr_checked = '1',
			hr_note = '".$mysqli->real_escape_string($note)."'
			WHERE id = '".$id."'
		")){
			if($mysqli->query("INSERT INTO hr_emp_missing_att_checked_logs VALUES(
				'',
				'".$id."',
				'".$note."',
				'Approved',
				'".uploader_info()."',
				'".date('d/m/Y')."'
			)")){
				notification( 'HR approved missing attendance!', 'Need your Approval. HR approved '.$emp['full_name'].'`s missing Attendance Request Date ('.$info['adj_date'].')', $home.'admin/profile/attendance-adsjustment-boss-aproval', 00001, '', '1', uploader_info() );
				notification( 'HR approved missing attendance!', 'HR approved Your missing Attendance Request Date ('.$info['adj_date'].')', $home.'admin/profile/attendance-adsjustment', $info['employee_id'], '', '1', uploader_info() );
				echo 'Checked Successfully';
			}else{
				echo 'Please fill all information';
			}		
		}else{
			echo 'Please fill all information';
		}
	}
}



if(isset($_POST['reject_checked_id'])){
	$id = $_POST['reject_checked_id'];
	$note = $_POST['note'];
	$info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_missing_attendance_request_date WHERE id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$info['employee_id']."'"));
	$checked_attendance = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where employee_id = '".$info['employee_id']."' and days = '".$info['days']."' and month = '".$info['month']."' and years = '".substr($info['years'],2)."'"));
	if(!empty($checked_attendance['id'])){
		$enote = 'Missing Date already in attendance list!';
	}else{
		$enote = '';
	}
	if($mysqli->query("UPDATE employee_missing_attendance_request_date SET
		is_hr_checked = '2',
		hr_note = '".$mysqli->real_escape_string($note)." | ".$enote."'
		WHERE id = '".$id."'
	")){
		if($mysqli->query("INSERT INTO hr_emp_missing_att_checked_logs VALUES(
			'',
			'".$id."',
			'".$note."',
			'Rejected',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			notification( 'HR rejected missing attendance!', 'HR Rejected Your missing Attendance Request Date ('.$info['adj_date'].')', $home.'admin/profile/attendance-adsjustment', $info['employee_id'], '', '1', uploader_info() );
			echo 'Rejected Successfully';
		}else{
			echo 'Please fill all information';
		}		
	}else{
		echo 'Please fill all information';
	}	
}


if(isset($_POST['boss_accept_checked_id'])){
	$id = $_POST['boss_accept_checked_id'];
	$deduction_amount = $_POST['deduction_amount'];
	$note = $_POST['note'];
	$info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_missing_attendance_request_date WHERE id = '".$id."'"));
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$info['employee_id']."'"));
		
	if($mysqli->query("UPDATE employee_missing_attendance_request_date SET
		aproval = '1',
		deduction_amount = '".$mysqli->real_escape_string($deduction_amount)."'
		WHERE id = '".$id."'
	")){
		if($mysqli->query("INSERT INTO boss_emp_missing_att_checked_logs VALUES(
			'',
			'".$id."',			
			'".$mysqli->real_escape_string($deduction_amount)."',
			'".$mysqli->real_escape_string($note)."',
			'Approved',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			if($mysqli->query("INSERT INTO employee_attendence VALUES(
				'',
				'".$emp['id']."',
				'".$emp['employee_id']."',
				'1',
				'',
				'',
				'',
				'".$info['days']."',
				'".$info['month']."',
				'".substr($info['years'],2)."',				
				'".uploader_info()."',
				'".date('d/m/Y')."',
				'".date('Y-m-d H:i:s')."',
				''
			)")){				
				notification( 'Boss approved missing attendance!', 'Boss approved Your missing Attendance Request Date ('.$info['adj_date'].')', $home.'admin/profile/attendance-adsjustment', $info['employee_id'], '', '1', uploader_info() );
				echo 'Checked Successfully';
			}else{
				echo 'Please fill all information';
			}		
		}else{
			echo 'Please fill all information';
		}		
	}else{
		echo 'Please fill all information';
	}	
}
?>