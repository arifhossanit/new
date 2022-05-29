<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Apply withdraw Leave Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Apply withdraw Leave Request</li>
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
									Leave Request Logs  <span id="loading"></span>
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
												<td>
													<?php
														$u = explode('___',$row->uploader_info);
														$em = $this->Dashboard_model->mysqlii("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01");
														echo $em[0]->full_name.' - '.$em[0]->employee_id; 
													?>
												</td>
												<td><?php echo $row->data; ?></td>
												<td>
													<?php 
														if($row->h_aproval == 1 OR $row->aproval == 2 OR $row->aproval == 1 OR $row->aproval == 2){
															if($row->aproval == 1 OR $row->h_aproval == 1){
																$end_date = DateTime::createFromFormat('d/m/Y', $row->end_date);
																$now = new DateTime();
																$end_date_diff = $end_date->diff($now);
																$twelve = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d').' 12:00:00');
																if($end_date > $now){ ?>
																	<button onclick="return widthdraw_leave_own_(<?php echo $row->id; ?>)" type="button" class="btn btn-xs btn-success">Withdraw Leave</button>
																<?php }else if($end_date_diff->d == '0' && $end_date_diff->m == '0' && $end_date_diff->y == '0' && $now <= $twelve){ ?>
																	<button onclick="return widthdraw_leave_own_(<?php echo $row->id; ?>)" type="button" class="btn btn-xs btn-success">Withdraw Leave</button>
																<?php } else{ ?> 
																	<button type="button" class="btn btn-xs btn-danger">Date Expired</button>
																<?php } 
															}
													?>
												</td>
											</tr>
										<?php } } } ?>
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


<div class="modal fade" id="widthdraw_leave_modal">
	<div class="modal-dialog modal-md" >
		<div class="modal-content">	
			<div class="modal-header btn-info">
				<h4 class="modal-title">Leave information</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body" id="widthdraw_leave_modal_result"> </div>
		</div>
	</div>
</div>




<script>
function widthdraw_leave_own_(id){
	$.ajax({
		url:"<?php echo base_url('assets/ajax/option_select/hrm/get_employee_days_end_date.php'); ?>",
		data: {leave_id:id},
		method: "POST",
		beforeSend:function(){
			$("#loading").html('<i class="fas fa-spinner fa-pulse"></i>');
		},
		success:function(data){
			$("#loading").html('');
			$('#widthdraw_leave_modal_result').html(data);	
			$('#widthdraw_leave_modal').modal('show');	
		}
	});
}


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