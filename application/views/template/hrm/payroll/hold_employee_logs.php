<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Hold Employee Logs</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Leave</a></li>
						<li class="breadcrumb-item active">Hold Employee Logs</li>
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
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<div class="card card-info">
								<div class="card-header">
									Hold Employee Logs
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example2">
										<thead>
											<tr>
												<th>Name</th>
												<th>Hold_Status</th>
												<th>Aproval_Status</th>												
												<th>Uploader</th>
												<th>Date</th>
												<th>Option</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(!empty($hold_employee_list)){
												foreach($hold_employee_list as $row){
													$emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->e_db_id."' order by id desc limit 01");
										?>
											<tr>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td>
													<?php if($emp[0]->status == 1){ ?>
														<button type="button" class="btn btn-xs btn-success">UNHOLD</button>
													<?php }else if($emp[0]->status == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger">HOLD</button>
													<?php } ?>
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
														<input type="hidden" name="delete_id" value="<?php echo $row->id; ?>"/>
														<input type="hidden" name="unhold_id" value="<?php echo $row->id; ?>"/>
														<?php if($row->aproval == 1){ if($emp[0]->status == 2){ ?>
														<button type="submit" name="unhold_employe" class="btn btn-xs btn-warning" onclick="return confirm('Are you sure want to UNHOLD <?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?>?')">UNHOLD</button>
														<?php } }else{ ?>
														<button type="submit" name="delete_data" class="btn btn-xs btn-danger" onclick="return confirm('Are you Sure want to holding request?')">Remove</button>
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