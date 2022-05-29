<style>
	.bonus{
		display: none;
	}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Performance</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Award</a></li>
						<li class="breadcrumb-item active">Employee Performance</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<div class="row">
						<div class="col-sm-3">
							<div class="card card-info">
								<div class="card-header">
									Employee Performance Info
								</div>
								<div class="card-body">
									<form action="<?php echo current_url(); ?>" method="POST">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label>Select Employee</label>
													<select name="employee_id" id="employee_id" class="form-control select2" onchange="verify_bonus_for_d_head()" required >
														<option value="">--select--</option>
														<?php
															if(!empty($emp_list)){
																foreach($emp_list as $row){
																	if($row->id != $_SESSION['user_info']['employee_id']){
																		echo '<option data-d_head="'.$row->d_head.'" value="'.$row->employee_id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
																	}
																}
															}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Percentage<small>(%)</small></label>
													<input type="number" name="percentage" placeholder="Percentage" autocomplete="off" class="number_int form-control" required="required" min="5" max="30"/>
												</div>
												<div class="form-group">
													<label>Select salary Month</label>
													<?php
														$min = date("Y-m",strtotime('-1 months',strtotime(date('Y-m-d'))));
														$rdate = date("Y-m",strtotime('-1 months',strtotime(date('Y-m-d'))));
													?>
													<!-- <input type="month" name="selected_month" value="<?php echo $rdate; ?>" min="<?php echo $min; ?>" class="form-control" required="required"/> -->
													<input onchange="verify_bonus_for_d_head()" type="month" name="selected_month" id="selected_month" min="<?php echo $min; ?>" class="form-control" required="required"/>
												</div>
												<div class="row">
													<div class="bonus col-md-1">
														<input value="0" type="radio" class="regular-radio" name="bonus_type" id="pay_cut">
													</div>
													<div class="bonus col-md-3">
														<label for="pay_cut">Bonus</label>
													</div>
													<div class="col-md-1">
														<input value="1" type="radio" class="regular-radio" name="bonus_type" id="bonus" required>
													</div>
													<div class="col-md-3">
														<label  for="bonus">Penalty</label>
													</div>
												</div>
												<div class="form-group">
													<label>Note</label>
													<textarea name="note" placeholder="Note" class="form-control" required></textarea>
												</div>
												<div class="form-group">
													<button type="submit" name="save" class="btn btn-success" style="float:right;">Save</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="col-sm-9">
							<div class="card card-success">
								<div class="card-header">
									Increament Logs
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example2">
										<thead>
											<tr>
												<th>Name</th>
												<th>Percentage</th>
												<th>Month</th>
												<th>Aproval</th>
												<th>Uploader</th>
												<th>Date</th>
												<th>Type</th>
												<th>Option</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(!empty($emp_list_table)){
												foreach($emp_list_table as $row){
													$emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->e_db_id."' order by id desc limit 01");
										?>
											<tr>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td><b><?php echo $row->percentage; ?></b><small>%</small></td>
												<td><?php echo $row->month_year; ?></td>												
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
													<?php echo ($row->pay_cut) ? '<span class="badge badge-danger">Pay Cut</span>' : '<span class="badge badge-primary">Bonus</span>'; ?>
												</td>
												<td>
													<?php if($_SESSION['user_info']['d_head'] == 1 AND $row->aproval == 0){ ?>
													<form action="<?php echo current_url(); ?>" method="post">
														<input type="hidden" name="delete_id" value="<?php echo $row->id; ?>"/>
														<button type="submit" name="delete_data"  class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Remove <?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?>?')">Remove</button>
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
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<script>
	let verify_bonus_for_d_head = () => {
		let employee_id = $('#employee_id').val();
		let selected_month = $('#selected_month').val();
		$.ajax({
			url: "<?=base_url('assets/ajax/form_submit/hrm/leave/verify_d_head_bonus.php'); ?>",
			method:'POST',
			data:{employee_id, selected_month},
			success:function(response) {
				let info = JSON.parse(response);
				if(info.status){
					$('.bonus').show();
					$('#pay_cut').prop('required', true);
				}else{
					$('.bonus').hide();
					$('#pay_cut').prop('required', false);
				}
			}     
		});
	}
</script>