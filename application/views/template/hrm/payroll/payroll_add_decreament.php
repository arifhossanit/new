<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Decrement / Demotion</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Add Decrement</li>
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
									Decrement Info
								</div>
								<div class="card-body">
									<form action="<?php echo current_url(); ?>" method="POST">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label>Select Employee</label>
													<select onchange="return get_designation()" name="employee_id" class="form-control select2" required >
														<option value="">--select--</option>
														<?php
															if(!empty($emp_list)){
																foreach($emp_list as $row){
																	echo '<option value="'.$row->employee_id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
																}
															}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Select Designation</label>
													<select name="designation_id" class="form-control select2" required >
														<option value="">--select--</option>
														<?php
															if(!empty($deg_list)){
																foreach($deg_list as $row){
																	echo '<option value="'.$row->designation_id.'">'.$row->designation_name.'</option>';
																}
															}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Amount</label>
													<input type="test" name="amount" placeholder="Decreament Amount" autocomplete="off" class="number_int form-control" required="required"/>
												</div>
												<div class="form-group">
													<label>Select Date</label>
													<input type="date" name="selected_date" class="form-control" required="required"/>
												</div>
												<div class="form-group">
													<label>Note</label>
													<textarea name="note" placeholder="Note" class="form-control"></textarea>
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
									Decrement Logs
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example2">
										<thead>
											<tr>
												<th>Name</th>
												<th>Amount</th>
												<th>Start Date</th>
												<th>Designation</th>
												<th>Aproval</th>
												<th>Uploader</th>
												<th>Date</th>
												<th>Option</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(!empty($emp_list_table)){
												foreach($emp_list_table as $row){
													$emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->e_db_id."' order by id desc limit 01");
													$deg = $this->Dashboard_model->mysqlii("select * from designation where designation_id = '".$row->designation."' order by id desc limit 01");
										?>
											<tr>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td><?php echo money($row->amount); ?></td>
												<td><?php echo $row->start_date; ?></td>
												<td><?php echo $deg[0]->designation_name; ?></td>
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
													<form action="<?php echo current_url(); ?>" method="post">
														<input type="hidden" name="delete_id" value="<?php echo $row->id; ?>"/>
														<button type="submit" name="delete_data"  class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Remove <?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?>?')">Remove</button>
													</form>
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
<script>
function get_designation(){
	var employee_id = $('select[name="employee_id"]').val();
	if(employee_id != ''){
		$.ajax({
			url:"<?php echo base_url('assets/ajax/option_select/get_employee_designation.php'); ?>",
			data: {employee_id:employee_id},
			method: "POST",
			success:function(data){
				$('select[name="designation_id"]').val(data);
				$('select[name="designation_id"]').select2().trigger('change');
			}
		});
	}else{
		alert('Something wrong! Please Try again');
	}
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>