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
						<li class="breadcrumb-item"><a href="#">Leave</a></li>
						<li class="breadcrumb-item active">Apply Leave Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<?php if(!empty($department)){ ?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<div class="card card-info">
						<div class="card-header">
							Leave Request Info
						</div>
						<div class="card-body">
							<form action="<?php echo current_url(); ?>" method="POST">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Select Employee</label>
											<select name="employee_id[]" multiple="multiple" class="form-control select2" required >
												<?php
													if(!empty($emp_list)){
														foreach($emp_list as $row){
															echo '<option value="'.$row->employee_id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
														}
													}
												?>
											</select>
										</div>
									</div>
								</div>											
								<div class="row mb-2 mt-2">
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-1">
												<input value="full_day" type="radio" class="regular-radio" name="leave_type" id="full_day" required>
											</div>
											<div class="col-md-3 p-0">
												<label for="full_day">Full Day</label>
											</div>
											<div class="col-md-1">
												<input value="half_day" type="radio" class="regular-radio" name="leave_type" id="half_day" required>
											</div>
											<div class="col-md-3 p-0">
												<label  for="half_day">Half Day</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row" id="full_day_form" style="display: none;">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Start Date</label>
											<input type="date" name="start_date" id="start_date" min="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Start Date" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label>How Many Days <span id="loading"></span></label>
											<input type="number" maxlength="3" oninput="return how_many_days_get_result()" name="how_many_days" id="how_many_days" class="form-control" placeholder="How Many Days" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label>End Date</label>
											<input type="date" name="end_date" id="end_date" class="form-control" />
										</div>
									</div>	
								</div>
								<div class="row" id="half_day_form" style="display: none;">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Leave In</label>
											<select name="leave_in_type" id="leave_in_type" class="form-control select2" >
												<option value="">--select--</option>
												<option value="Morning">Morning</option>
												<option value="Day">Day</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Leave Date</label>
											<input type="date" name="leave_date" id="leave_date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="Date" />
										</div>
									</div>	
								</div>
								<?php
									$check_employee = $this->Dashboard_model->mysqlii("select * from employee where role = '407277242147262618' and id = '".$_SESSION['user_info']['employee_id']."'"); // Housekeeping Role
									if(!empty($check_employee[0]->id)){
								?>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label>Choose Employee For Aproval</label>
												<select name="h_aproval" class="form-control select2" required>
													<option value="">--select--</option>
													<?php
														$get_emp = $this->Dashboard_model->mysqlii("select * from employee where d_head = '1' and department = '1806965207554226682'"); // Branch Operation Department
														if(!empty($get_emp[0]->id)){
															foreach($get_emp as $row){
																if($row->id != $_SESSION['user_info']['employee_id']){
																	echo '<option value="'.$row->id.'">'.$row->full_name.'</option>';
																}
															}
														}else{
															$get_emp = $this->Dashboard_model->mysqlii("select * from employee where d_head = '1' and role = '390647376434090456'"); // HR Department if no department head is found!
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
										<div class="form-group" style="    margin-top: 28px;">
											<label>Hold Employee:</label>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="hold_employee" data-bootstrap-switch data-off-color="danger" data-on-color="success">
										</div>
									</div>
								</div>
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
				<div class="col-sm-8">
				
					<div class="card card-info">
						<div class="card-header">
							Leave Request Logs
						</div>
						<div class="card-body">
							<table class="table table-sm table-bordered" id="leave_logs_table">
								<thead>
									<tr>
										<th>id</th>
										<th>Name</th>
										<th>Start Date</th>
										<th>NOD</th>
										<th>End Date</th>
										<th>Status</th>												
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
										<td><?php echo $row->id; ?></td>
										<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
										<td><?php echo $row->start_days; ?></td>												
										<td><?php echo $row->how_many_days; ?></td>
										<td><?php echo $row->end_date; ?></td>
										<td>
											<?php if($row->aproval == 1){ ?>
												<button type="button" class="btn btn-xs btn-success">Approved</button>
											<?php }else if($row->aproval == 2){ ?>
												<button type="button" class="btn btn-xs btn-danger">Rejected</button>
											<?php }else{ ?>
												<button type="button" class="btn btn-xs btn-info">Pending</button>	
											<?php } ?>
										</td>
										<td>
											<?php
												$u = explode('___',$row->uploader_info);
												$em = $this->Dashboard_model->mysqlii("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01");
												echo $em[0]->full_name.' - '.$em[0]->employee_id; 
											?>
										</td>
										<td><?php echo $row->data; ?></td>
										<td>
											<?php if($row->aproval != 1){ ?>
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
			</div>
		</div>
	</div>
	
	
	
	<?php } else { ?>
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="card card-info">
								<div class="card-header">
									Leave Request Info
								</div>
								<div class="card-body">
									<form action="<?php echo current_url(); ?>" method="POST">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label>Select Employee</label>
													<select name="employee_id[]" multiple="multiple" class="form-control select2" required >
														<?php
															if(!empty($emp_list)){
																foreach($emp_list as $row){
																	echo '<option value="'.$row->employee_id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
																}
															}
														?>
													</select>
												</div>
											</div>
										</div>											
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>Start Date</label>
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
													<label>End Date</label>
													<input type="date" name="end_date" class="form-control" readonly="readonly"/>
												</div>
											</div>	
										</div>
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group" style="    margin-top: 28px;">
													<label>Hold Employee:</label>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="checkbox" name="hold_employee" data-bootstrap-switch data-off-color="danger" data-on-color="success">
												</div>
											</div>
										</div>
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
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<script>
$('input[type=radio][name=leave_type]').change(function() {
    if (this.value == 'full_day') {
		$('#start_date').prop('required', true);
		$('#how_many_days').prop('required', true);
		$('#end_date').prop('required', true);
		$('#leave_in_type').prop('required', false);
		$('#leave_date').prop('required', false);
        $('#full_day_form').show();
        $('#half_day_form').hide();
    }else if (this.value == 'half_day') {
		$('#start_date').prop('required', false);
		$('#how_many_days').prop('required', false);
		$('#end_date').prop('required', false);
		$('#leave_in_type').prop('required', true);
		$('#leave_date').prop('required', true);
        $('#full_day_form').hide();
        $('#half_day_form').show();
    }
});
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
$(document).ready(()=> {
	$('#leave_logs_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"scrollX": true,
    });
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>