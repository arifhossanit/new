<?php
include("../../../../application/config/ajax_config.php");
if(isset($_POST['start_date'])){ 
	$date = $_POST['how_many_days'] - 1;
	$check_out_date_mmd = date('Y-m-d', strtotime($_POST['start_date']. ''.$date.' days'));
	echo $check_out_date_mmd;
} 

if(isset($_POST['leave_id'])){ 
	$row = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$_POST['leave_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<b>Leave Info</b>
		<hr />
		Start Date: <?php echo $row['start_days']; ?><br />
		End Date: <?php echo $row['end_date']; ?>
		<hr />
		<div class="row">
			<div class="col-sm-12">
				<ul style="list-style:none;">
<?php
	$check_requesti = mysqli_fetch_assoc($mysqli->query("select * from employee_everyday_withdraw_logs where unique_id = '".$row['unique_id']."'"));
	$check_r = $mysqli->query("select * from employee_everyday_withdraw_logs where unique_id = '".$row['unique_id']."'");
	$actual = array();
	while($check_request = mysqli_fetch_assoc($check_r)){
		$request_ides = explode(',',$check_request['withdraw_ids']);
		foreach($request_ides as $value){
			$actual[] = array(
				'id' => $value,
				'aproval' => $check_request['approval']
			);
		}
	}
	$not_show_id = '';
	$leave_logs = $mysqli->query("select * from employee_everyday_leave_logs where unique_id = '".$row['unique_id']."' group by days");
	while($in = mysqli_fetch_assoc($leave_logs)){
		$g_YMD = $in['year'].$in['month'].$in['days'];
		$r_YMD = date('Ymd');
		$end_date = DateTime::createFromFormat('d/m/Y', $in['days'].'/'.$in['month'].'/'.$in['year']);
		$now = new DateTime();
		$end_date_diff = $end_date->diff($now);
		$twelve = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 12:00:00');
		if($end_date > $now){
			if(!is_null($check_requesti)){
				foreach($actual as $go){
					if($go['id'] == $in['id']){
						if($go['aproval'] == 1){
							$status = '<small style="color:green;">(Approved)</small>';
						}else if($go['aproval'] == 2){
							$status = '<small style="color:red;">(Rejected)</small>';
						}else{
							$status = '<small style="color:blue;">(Peding..)</small>';
						}
						echo '
							<li>
								<label>	
									<i class="fas fa-calendar-week"></i>
									'.$in['date_full'].' '.$status.'
								<label>
							</li>
						';
						$not_show_id = $go['id'];
					}
				}				
			}
			if($not_show_id != $in['id']){
				echo '
					<li>
						<label>
							<input type="checkbox" name="deduct_date[]" value="'.$in['id'].'"/>
							'.$in['date_full'].' <small style="color:green;">(Withdraw available!)</small>
						<label>
					</li>
				';
			}	
		}else if(true){
			if(!is_null($check_requesti)){
				foreach($actual as $go){
					if($go['id'] == $in['id']){
						if($go['aproval'] == 1){
							$status = '<small style="color:green;">(Approved)</small>';
						}else if($go['aproval'] == 2){
							$status = '<small style="color:red;">(Rejected)</small>';
						}else{
							$status = '<small style="color:blue;">(Peding..)</small>';
						}
						echo '
							<li>
								<label>	
									<i class="fas fa-calendar-week"></i>
									'.$in['date_full'].' '.$status.'
								<label>
							</li>
						';
						$not_show_id = $go['id'];
					}
				}				
			}
			if($not_show_id != $in['id']){
				echo '
					<li>
						<label>
							<input type="checkbox" name="deduct_date[]" value="'.$in['id'].'"/>
							'.$in['date_full'].' <small style="color:green;">(Withdraw available!)</small>
						<label>
					</li>
				';
			}		
		}else{
			if(!is_null($check_requesti)){
				foreach($actual as $go){
					if($go['id'] == $in['id']){
						if($go['aproval'] == 1){
							$status = '<small style="color:green;">(Approved)</small>';
						}else if($go['aproval'] == 2){
							$status = '<small style="color:red;">(Rejected)</small>';
						}else{
							$status = '<small style="color:blue;">(Peding..)</small>';
						}
						echo '
							<li>
								<label>	
									<i class="fas fa-calendar-week"></i>
									'.$in['date_full'].' '.$status.'
								<label>
							</li>
						';
						$not_show_id = $go['id'];
					}
				}				
			}else{
				echo '
				<li>
					<label>
						<i class="far fa-calendar-times" style="color:#f00;" title="Date Expired!"></i>
						'.$in['date_full'].' <small style="color:red;">(Date Expired!)</small>
					<label>
				</li>
			';
			}
		}
	} 
?>		
				</ul>
			</div>
		</div>
		<div align="right" style="margin-bottom:10px;">
			<button type="button" id="select" class="btn btn-xs btn-danger" style="margin-left:15px;"><i class="fa fa-list-ul" aria-hidden="true"></i> Select all</button>
			<button type="button" id="unselect" class="btn btn-xs btn-warning"><i class="fa fa-bars" aria-hidden="true"></i> Unselect all</button>
			<button type="button" id="btn_delete" class="btn btn-xs btn-success">Request for Withdraw</button>
		</div>
	</div>
</div>	
<script>
$('document').ready(function(){ 
	var request_id = "<?php echo $row['id']; ?>";
	$("#select").click(function(){
		$('input:checkbox').prop('checked',true);     
	});
	$("#unselect").click(function(){
		$('input:checkbox').prop('checked',false);     
	});
	$('#btn_delete').click(function(){  
		if(confirm("Are you sure you want to Request selected Iteam?")){
			var id = [];   
			$(':checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					url:'<?php echo $home; ?>assets/ajax/option_select/hrm/get_employee_days_end_date.php',
					method:'POST',
					data:{
						request_id:request_id,
						date_ids:id
					},
					success:function(data) {
						alert(data);
						$('#widthdraw_leave_modal_result').html('');	
						$('#widthdraw_leave_modal').modal('hide');
					}     
				});
			}   
		} else {
			return false;
		}
	});
	
});
</script>
<?php } 


//============================================================================
if(isset($_POST['request_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from employee_leave_logs where id = '".$_POST['request_id']."'"));
	$ids = '';
	$dates = '';
	foreach($_POST['date_ids'] as $data){
		$in = mysqli_fetch_assoc($mysqli->query("select * from employee_everyday_leave_logs where id = '".$data."'"));
		$ids .= $in['id'].',';
		$dates .= $in['date_full'].',';
	}
	$ids = rtrim($ids,',');
	$dates = rtrim($dates,',');
	if($row['hold_unhold'] == '1'){
		$h_data = 'YES';
	}else{
		$h_data = 'NO';
	}
	$d_head = '';
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."'"));
	
	if($emp['department'] == '1810685559802248792' OR $emp['department'] == '2335318469842157306'){
		$get_department_head = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where department = '".$emp['department']."' AND d_head = 1 AND status = 1"));
	}else{
		$get_department_head = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where department = '".$emp['department']."' AND d_head = 1 AND status = 1 AND branch = '".$emp['branch']."'"));
	}
	$get_hr_head = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where department = '1383007286312996344' AND d_head = '1'"));
	if(!empty($get_department_head['id']) AND $get_department_head['id'] == $_SESSION['super_admin']['employee_id']){
		if($get_department_head['d_head_reporting'] != '0'){
			$d_head_id = $get_department_head['d_head_reporting'];
		}else{
			$d_head_id = $get_hr_head['id'];
		}
	}else{
		if(!empty($get_department_head['id'])){
			$d_head_id = $get_department_head['id'];
		}else{
			$d_head_id = $get_hr_head['id'];
		}
	}

	$d_head = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where id = ".$d_head_id));
	if($mysqli->query("insert into employee_everyday_withdraw_logs values(
		'',
		'".$row['unique_id']."',
		'".$row['e_db_id']."',
		'".$row['employee_id']."',
		'Leave Info: Start date - ".$row['start_days'].", End date - ".$row['end_date'].", Number of days - ".$row['how_many_days']." Days, Is employee hold - ".$h_data.", Leave Request date was - ".$row['data']."',
		'".$dates."',
		'".$ids."',
		'0',		
		'".$d_head['id']."',
		'".$d_head['employee_id']."',		
		'1',
		'".uploader_info()."',
		'".date('d/m/Y')."'
	)")){
		echo 'Request Successfully sended';
	}else{
		echo 'Something wrong! Please Try again.';
	}
}
?>