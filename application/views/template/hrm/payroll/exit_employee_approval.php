<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Exit Employee Aproval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Exit Employee Aproval</li>
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
									Exit Employee Aproval Logs
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example2">
										<thead>
											<tr>
												<th>Photo</th>
												<th>Name</th>
												<th>Location</th>
												<th>Designation</th>
												<th>Department</th>
												<th>Deactive Note</th>
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
													$emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->exit_emp_id."' order by id desc limit 01");
													$branch = $this->Dashboard_model->mysqlii("select * from branches where branch_id = '".$emp[0]->branch."'");
										?>
											<tr>
												<td><img src="<?php echo base_url($emp[0]->photo); ?>" style="width:50px;"/></td>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td><?php echo $branch[0]->branch_name; ?></td>
												<td><?php echo $emp[0]->designation_name; ?></td>
												<td><?php echo $emp[0]->department_name; ?></td>
												<td><?php echo $row->deactive_note; ?></td>
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
															if($row->aproval == 1){ 
																if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
																	if($emp[0]->extra_note == ''){
														?>
																	
																	<button type="button" onclick="return aprove_modal(<?php echo $row->id; ?>)" class="btn btn-xs btn-success">Aprove</button>
																	<button type="button" onclick="return reject_modal(<?php echo $row->id; ?>)" class="btn btn-xs btn-danger">Reject</button>
																	
														<?php }	}
															}else{ 
														?>
															<button type="button" onclick="return aprove_modal(<?php echo $row->id; ?>)" class="btn btn-xs btn-success">Aprove</button>
															<button type="button" onclick="return reject_modal(<?php echo $row->id; ?>)" class="btn btn-xs btn-danger">Reject</button>
														<?php 
															}															
														?>
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
					<div class="form-group">
						<label>Note</label>
						<textarea name="note" class="form-control" placeholder="Note" required="required" style="height:200px;"></textarea>
					</div>

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
<script>
function reject_modal(id){
	$('input[name="reject_id"]').val(id);
	$("#rejection_modal").modal('show');
}
function aprove_modal(id){
	$('input[name="aprove_id"]').val(id);
	$("#aproval_modal").modal('show');
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>