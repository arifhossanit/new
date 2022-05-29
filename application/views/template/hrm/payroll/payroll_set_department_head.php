<!---- Add / Update Department head reporting boss -->
<div class="modal fade" id="update_reporting_boss">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?php echo current_url(); ?>" method="post">
                <input type="hidden" name="update_employee_id" id="update_employee_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product Configuration</h4>
				</div>
				<div class="modal-body" id="configuration_select">
					<div class="form-group">
						<label>Select Department Head Reporting Boss</label>
						<select name="d_head_reporting" id="d_head_reporting_update" class="form-control select2" required >
							<option value=""> -- Select -- </option>
							<?php
								if(!empty($top_management)){
									foreach($top_management as $row){
										echo '<option value="'.$row->id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
									}
								}
							?>
						</select>
					</div>
				</div>                
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" name="update">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Set Department Head</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Set Department Head</li>
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
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-3">
									<div class="card card-info">
										<div class="card-header">
											Set Department Head
										</div>
										<div class="card-body">
											<form action="<?php echo current_url(); ?>" method="POST">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<label>Select Employee</label>
															<select name="employee_id" class="form-control select2" required >
																<option value="">--select--</option>
																<?php
																	if(!empty($employeies)){
																		foreach($employeies as $row){
																			echo '<option value="'.$row->employee_id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
																		}
																	}
																?>
															</select>
														</div>
														<div class="form-group">
															<label>Start Date</label>
															<input type="date" name="selected_date" class="form-control" required="required"/>
														</div>
														<div class="form-group">
															<label>Select Department Head Reporting Boss</label>
															<select name="d_head_reporting" class="form-control select2">
																<option value=""> -- Select -- </option>
																<?php
																	if(!empty($top_management)){
																		foreach($top_management as $row){
																			echo '<option value="'.$row->id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
																		}
																	}
																?>
															</select>
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
											Set Department Head Logs
										</div>
										<div class="card-body">
											<table class="table table-sm table-bordered" id="example2">
												<thead>
													<tr>
														<th>Name</th>
														<th>Department</th>
														<th>Start Date</th>
														<th>Reporting Boss</th>
														<th>Uploader</th>
														<th>Date</th>
														<th>Option</th>
													</tr>
												</thead>
												<tbody>
												<?php
													if(!empty($head_emp)){
														foreach($head_emp as $row){
															$emp = $this->Dashboard_model->mysqlii("select full_name, d_head_reporting, department from employee where employee_id = '".$row->employee_id."' order by id desc limit 01");
												?>
													<tr>
														<td><?php echo $emp[0]->full_name.' - '.$row->employee_id; ?></td>
														<td><?php echo $row->department_name; ?></td>
														<td><?php echo $row->start_date; ?></td>
														<td><?php
														 if($emp[0]->d_head_reporting == '0' ){
															 echo '<p class="text-danger m-0 p-0"> Not Assigned </p>';
														 }else{
															$d_head_report = $this->Dashboard_model->mysqlij("SELECT full_name from employee where id = ".$emp[0]->d_head_reporting);
															echo $d_head_report->full_name;
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
															<div class="row w-50">
																<?php if($emp[0]->department != '749568347163692080'){ ?>
																	<div class="col-sm-6">
																		<button data-toggle="tooltip" data-placement="top" title="Add Reporting Boss" type="button" name="delete_data" class="btn btn-xs btn-info" onclick="update_department_reporting_boss('<?php echo $row->employee_id; ?>', '<?php echo ($emp[0]->d_head_reporting != '0') ? $emp[0]->d_head_reporting : ''; ?>')"><i class="fas fa-plus"></i></button>
																	</div>
																<?php } ?>
																<div class="col-sm-6">
																	<form action="<?php echo current_url(); ?>" method="post">
																		<input type="hidden" name="delete_id" value="<?php echo $row->id; ?>"/>
																		<button type="submit" name="delete_data" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Remove <?php echo $emp[0]->full_name.' - '.$row->employee_id; ?>?')">Remove</button>
																	</form>
																</div>
															</div>
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
	</div>
</div>
<script>
	function update_department_reporting_boss(id, reporting_boss){
		if(reporting_boss != ''){	
			console.log(reporting_boss);		
			$('#d_head_reporting_update').val(reporting_boss).change();
		}
		$('#update_employee_id').val(id);
		$('#update_reporting_boss').modal('toggle');
	}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>