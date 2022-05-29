<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Resign Employee Aproval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Resign Employee Aproval</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="row">
						
						<div class="col-sm-12">
							<div class="card card-success">
								<div class="card-header">
									Resign Employee Aproval Logs
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example2">
										<thead>
											<tr>
												<th>Photo</th>
												<th>Name</th>
												<th>Dept:</th>
												<th>Application</th>
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
													$dept = $this->Dashboard_model->mysqlii("select * from department where department_id = '".$emp[0]->department."' order by id desc limit 01");
										?>
											<tr>
												<td><a href="<?php echo base_url($emp[0]->photo); ?>" target="_blank"><img src="<?php echo base_url($emp[0]->photo); ?>" style="width:50px;"/></a></td>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td><?php echo $dept[0]->department_name; ?></td>
												<td>
													<button onclick="return view_application(<?php echo $row->id; ?>)" class="btn btn-xs btn-success" type="button"><i class="far fa-eye"></i>  View Application</button>
												</td>												
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
													<?php
														if(isset($for_hr_flag)){
															$check_hr_department_head = $this->Dashboard_model->mysqlii("SELECT id from employee where department = '1383007286312996344' and d_head = '1' and id = ".$_SESSION['user_info']['employee_id']);
															if(!empty($check_hr_department_head[0]->id)){ 
																$check_if_sent_chain = $this->Dashboard_model->mysqlij("SELECT count(id) as chain_count from exit_employee_chain_aproval where exit_emp_employee_id = ".$emp[0]->employee_id);
																if($check_if_sent_chain->chain_count == 0){
															?>
																	<button type="button" onclick="return aprove_modal(<?php echo $row->e_db_id; ?>, 'for_hr')" class="btn btn-xs btn-success">Chain Approval</button>
																	<button type="button" onclick="return reject_modal(<?php echo $row->e_db_id; ?>)" class="btn btn-xs btn-danger">Reject</button>
													<?php		}else{ 
															?>
																	<span class="badge badge-primary text-white">Approval Sent</span>
													<?php		}
															}
														}else{ ?>
															<button type="button" onclick="return aprove_modal(<?php echo $row->e_db_id; ?>, '')" class="btn btn-xs btn-success">Aprove</button>
															<button type="button" onclick="return reject_modal(<?php echo $row->e_db_id; ?>)" class="btn btn-xs btn-danger">Reject</button>
													<?php } ?>															
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
<!----aprove model-->
<div class="modal fade" id="aproval_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<input type="hidden" name="aprove_id" value="" />
				<div class="modal-header btn-success">
					<h4 class="modal-title">Aprove Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group" id="hr_employee_selection_div" style="display: none;">
						<label>Select aproval Employee</label>
						<select id="hr_employee_selection" name="aproval_employee[]" multiple="multiple" class="form-control select2" disabled>
							<option value=""> -- Select -- </option>
							<?php 
								$table = $this->Dashboard_model->select('employee',array( 'status' => '1'),'id','asc','result');
								if(!empty($table)){
									foreach($table as $row){ ?>
										<option value="<?php echo $row->employee_id; ?>"><?php echo $row->full_name; ?> - <?php echo $row->employee_id; ?></option>
							<?php } } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Note</label>
						<textarea name="extra_note" class="form-control" placeholder="Note" style="height:200px;"></textarea>
						<!-- <textarea name="extra_note" class="form-control" placeholder="Note" required="required" style="height:200px;"></textarea> -->
					</div>
					<!--
					<div class="form-group">
						<label>Select Date</label>
						<input type="date" class="form-control" name="deactive_Date" value="<?php echo date('Y-m-d'); ?>"/>
					</div>
					-->
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="aprove_data" class="btn btn-success">Aprove</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End aprove model-->
<!----reject model-->
<div class="modal fade" id="rejection_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<input type="hidden" name="reject_id" value="" />
				<div class="modal-header btn-danger">
					<h4 class="modal-title">Reject Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Note</label>
						<textarea name="note" class="form-control" placeholder="Note" required="required" style="height:200px;"></textarea>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="reject_data" class="btn btn-danger">Reject</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End reject model-->

<!----view model-->
<div class="modal fade" id="application_view_model">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Application Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="application_view_result"> </div>
				<div class="modal-footer">
					<button type="button" style="float:right;" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End view model-->
<script>
function view_application(id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/resign_employee_application.php');?>",  
		method:"POST",
		data:{ application_id:id },
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');			
			$('#application_view_result').html(data);
			$('#application_view_model').modal('show');
		}  
	});
}
function reject_modal(id){
	$('input[name="reject_id"]').val(id);
	$("#rejection_modal").modal('show');
}
function aprove_modal(id, flag){
	$('input[name="aprove_id"]').val(id);
	if(flag != ''){
		$("#hr_employee_selection").prop('disabled', false);
		$("#hr_employee_selection").prop('required', true);
		$("#hr_employee_selection_div").show();
	}
	$("#aproval_modal").modal('show');
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>