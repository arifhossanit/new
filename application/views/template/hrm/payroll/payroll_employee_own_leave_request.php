<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Apply Leave Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Apply Leave Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
<?php
	if(!empty($emp_list)){
		foreach($emp_list as $row){
			if($row->id == $_SESSION['user_info']['employee_id']){
				$employee_id = $row->employee_id;
				$employee_name = $row->full_name . ' - ' . $row->employee_id;
			}
		}
	}
?>

<div class="modal fade" id="full_day_leave_modal">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">	
			<div class="modal-header btn-success">
				<h4 class="modal-title">Full Day Leave Apply</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<form action="<?php echo current_url(); ?>" method="POST">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">													
								<input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>"/>
								<input type="text" name="employee_info" value="<?php echo $employee_name; ?>" class="form-control" readonly="readonly"/>
							</div>
						</div>
					</div>											
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Start Date<small>(mm/dd/yyyy)</small></label>
								<input type="date" name="start_date" min="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Start Date" required="required"/>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>How Many Days <span id="loading"></span></label>
								<input type="number" maxlength="3" oninput="return how_many_days_get_result()" name="how_many_days" class="form-control" placeholder="How Many Days" required="required"/>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>End Date<small>(mm/dd/yyyy)</small></label>
								<input type="date" name="end_date" class="form-control" readonly="readonly"/>
							</div>
						</div>	
					</div>
					<?php
						$check_employee = $this->Dashboard_model->mysqlii("select * from employee where role = '407277242147262618' and id = '".$_SESSION['user_info']['employee_id']."' AND d_head = 1");
						if(!empty($check_employee[0]->id)){
							?>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Choose Employee For Aproval</label>
										<select name="h_aproval" class="form-control select2" required>
											<option value="">--select--</option>
											<?php
												$get_emp = $this->Dashboard_model->mysqlii("select * from employee where d_head = '1' and branch = '".$check_employee[0]->branch."'");
												if(!empty($get_emp[0]->id)){
													foreach($get_emp as $row){
														if($row->id != $_SESSION['user_info']['employee_id']){
															echo '<option value="'.$row->id.'">'.$row->full_name.'</option>';
														}
													}
												}else{
													$get_emp = $this->Dashboard_model->mysqlii("select * from employee where d_head = '1' and role = '390647376434090456'");
													foreach($get_emp as $row){
														if($row->id != $_SESSION['user_info']['employee_id']){
															echo '<option value="'.$row->id.'">'.$row->full_name.'</option>';
														}
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>		
						<?php } ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Note</label>
								<textarea name="note" placeholder="Note" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<button type="submit" name="apply" class="btn btn-success" style="float:right;">Apply</button>
							</div>
						</div>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="half_day_leave_modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">	
			<div class="modal-header btn-info">
				<h4 class="modal-title">Half Day Leave Apply</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<form action="<?php echo current_url(); ?>" method="POST">
					<input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>"/>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Leave In</label>
								<select name="leave_in_type" class="form-control select2" required="required">
									<option value="">--select--</option>
									<option value="Morning">Morning</option>
									<option value="Day">Day</option>
								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Leave Date</label>
								<input type="date" name="leave_date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date" required />
							</div>
						</div>
						<?php
							$check_employee = $this->Dashboard_model->mysqlii("select * from employee where role = '407277242147262618' and id = '".$_SESSION['user_info']['employee_id']."' AND d_head = 1");
							if(!empty($check_employee[0]->id)){
						?>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Choose Employee For Aproval</label>
									<select name="h_aproval" class="form-control select2" required>
										<option value="">--select--</option>
										<?php
											$get_emp = $this->Dashboard_model->mysqlii("select * from employee where d_head = '1' and branch = '".$check_employee[0]->branch."'");
											if(!empty($get_emp[0]->id)){
												foreach($get_emp as $row){
													if($row->id != $_SESSION['user_info']['employee_id']){
														echo '<option value="'.$row->id.'">'.$row->full_name.'</option>';
													}
												}
											}else{
												$get_emp = $this->Dashboard_model->mysqlii("select * from employee where d_head = '1' and role = '390647376434090456'");
												foreach($get_emp as $row){
													if($row->id != $_SESSION['user_info']['employee_id']){
														echo '<option value="'.$row->id.'">'.$row->full_name.'</option>';
													}
												}
											}
										?>
									</select>
								</div>
							</div>
						</div>	
						<?php } ?>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Note</label>
								<textarea name="note" placeholder="Note" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<button name="get_leave_today" type="submit" class="btn btn-info" style="width:100%;"><i class="fas fa-chalkboard-teacher"></i> &nbsp;&nbsp;Apply</button>
							</div>
						</div>
					</div>										
				</form>
			</div>
		</div>
	</div>
</div>
	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-10" style="margin-bottom:30px;">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-6">
									<button onclick="return open_full_day_leave_modal()" type="button" class="btn btn-success" style="width:100%;">Full Days Leave</button>
								</div>
								<div class="col-sm-6">
									<button onclick="return open_half_day_leave_modal()" type="button" class="btn btn-info" style="width:100%;">Half Days Leave</button>
								</div>
							</div>
						</div>
						<div class="col-sm-3"></div>
					</div>
				</div>
				<div class="col-sm-1"></div>			
				<!---------------------------------------------------------------------->				
				<div class="col-sm-1"></div>
				<div class="col-sm-10">

<script>
function open_full_day_leave_modal(){
	$('#full_day_leave_modal').modal('show');
	$('#half_day_leave_modal').modal('hide');
}
function open_half_day_leave_modal(){
	$('#half_day_leave_modal').modal('show');
	$('#full_day_leave_modal').modal('hide');
}
</script>					
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<div class="card card-info">
								<div class="card-header">
									Leave Request Logs
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example2">
										<thead>
											<tr>
												<th>Name</th>
												<th>Start Date</th>
												<th>NOD</th>
												<th>Note</th>
												<th>End Date</th>
												<th>Status</th>												
												<th>Approval Note</th>												
												<th>Uploader</th>
												<th>Date</th>												
												<th>Option</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(!empty($leave_request_list)){
												foreach($leave_request_list as $row){
													$emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->e_db_id."' order by id desc limit 01");
										?>
											<tr>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td><?php echo $row->start_days; ?></td>												
												<td><?php echo $row->how_many_days; ?> Days</td>
												<td><?php echo $row->note; ?></td>
												<td><?php echo $row->end_date; ?></td>
												<td>
													<?php if($row->aproval == 1){ ?>
														<button type="button" class="btn btn-xs btn-success">Approved</button>
													<?php }else if($row->aproval == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger">Boss Rejected</button>
													<?php }else if($row->h_aproval == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger">D.Head Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-info">Pending</button>	
													<?php } ?>
												</td>
												<td><?php
													$get_approval_note = $this->Dashboard_model->mysqlij("SELECT `note` from employee_leave_aproval_logs where leave_id = ".$row->id);
													if($get_approval_note){
														echo $get_approval_note->note;
													}else{
														echo ' - ';
													}
												?></td>
												<td>
													<?php
														$u = explode('___',$row->uploader_info);
														$em = $this->Dashboard_model->mysqlii("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01");
														echo $em[0]->full_name.' - '.$em[0]->employee_id; 
													?>
												</td>
												<td><?php echo $row->data; ?></td>
												<td>
													<?php if($row->aproval == 1 OR $row->aproval == 2 OR $row->h_aproval == 1 OR $row->h_aproval == 2 ){ } else { ?>
													<form action="<?php echo current_url(); ?>" method="post">
														<input type="hidden" name="delete_id" value="<?php echo $row->id; ?>"/>
														<button type="submit" name="delete_data"  class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Remove <?php echo $row->how_many_days; ?> Days Leave Request? NB: You can not remove request after approved!')">Remove</button>
													</form>
													<?php } ?>
												</td>
											</tr>
										<?php } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-sm-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function how_many_days_get_result(){
	var start_date = $('input[name="start_date"]').val();
	var how_many_days = $('input[name="how_many_days"]').val();
	if(start_date != '' && how_many_days != ''){
		$.ajax({
			url:"<?php echo base_url('assets/ajax/option_select/hrm/get_employee_days_end_date.php'); ?>",
			data: {start_date:start_date, how_many_days:how_many_days},
			method: "POST",
			beforeSend:function(){
				$("#loading").html('<i class="fas fa-spinner fa-pulse"></i>');
			},
			success:function(data){
				$("#loading").html('');
				$('input[name="end_date"]').val(data);				
			}
		});
	}else{
		alert('Please Select Start date & Type How many days!');
		$('input[name="how_many_days"]').val('');
	}
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>