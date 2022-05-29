<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee TA/DA Aproval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Employee TA/DA Aproval</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-12">
					<div class="row">
						
						<div class="col-sm-12">
							<div class="card card-success">
								<div class="card-header">
									Employee TA/DA Aproval Logs
								</div>
								<div class="card-body">
								<form action="<?php echo current_url(); ?>" method="post">
									<button onclick="return confirm('Are you sure, you want to Approve all selected requests?')" class="selected_button btn btn-info btn-xs mb-2" name="approve_selected_button" style="display: none;">Approve All Selected!</button>
									<button onclick="return confirm('Are you sure, you want to Reject all selected requests?')" class="selected_button btn btn-danger btn-xs mb-2" name="reject_selected_button" style="display: none;">Reject All Selected!</button>
									<table class="table table-sm table-bordered" id="ta_da_table">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Destination & Date</th>	
												<th>Type & Details</th>
												<th>Vehicle & Reason</th>
												<th>Amount</th>										
												<th>Uploader & Attachment</th>
												<th>Aproval</th>
												<th>Date</th>
												<th>#</th>
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
												<td><?php echo $row->id; ?></td>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td>
													<b>From:</b> <?php echo $row->destination_from; ?> | <b>TO:</b> <?php echo $row->destination_to; ?>
													<hr style="margin:0px;"/>
													<b>Date:</b> <?php echo $row->transport_date; ?>
												</td>
												<td>
													<b>Transport Type:</b> <?php echo $row->transport_type; ?>
													<hr style="margin:0px;"/>
													<b>Details:</b> <?php echo $row->transport_details; ?>
												</td>												
												<td>
													<b>Vehicle Type:</b> <?php echo $row->vehicle_type; ?>
													<hr style="margin:0px;"/>
													<b>Reason:</b> <?php echo $row->vehicle_type_reason; ?>
												</td>
												<td>
													<b>Transport Amount:</b> <b style="color:red;"><?php echo money($row->transport_amount); ?></b>
													<hr style="margin:0px;"/>
													<b>Food Amount:</b> 
													<b style="color:red;">
													<?php
														if(!empty($row->food_amount)){
															echo money($row->food_amount);
														}else{
															echo 'NaN';
														}
													?>
													</b>
												</td>										
												<td>
													<?php
														$u = explode('___',$row->uploader_info);
														$em = $this->Dashboard_model->mysqlii("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01");
														echo $em[0]->full_name.' - '.$em[0]->employee_id; 
													?>
													<hr style="margin:0px;"/>
													<b>Attachment:</b> <a href="<?php echo base_url($row->bill_attachment); ?>" target="_blank">View Attachment</a>
												</td>
												<td>
													<div class="btn-group scst_grp">
													<?php if($row->department_head_aproval == 1){ ?>
														<button type="button" class="btn btn-xs btn-success" title="Department Head Aproval">DEH: Approved</button>
													<?php }else if($row->department_head_aproval == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger" title="Department Head Aproval">DEH: Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-info" title="Department Head Aproval">DEH: Pending</button>	
													<?php } ?>
													
													<?php if($row->boss_aproval == 1){ ?>
														<button type="button" class="btn btn-xs btn-success" title="Boss Aproval">BOS: Approved</button>
													<?php }else if($row->boss_aproval == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger" title="Boss Aproval">BOS: Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-info" title="Boss Aproval">BOS: Pending</button>	
													<?php } ?>
													</div>
													<hr style="margin:0px;"/>
													<div class="btn-group scst_grp">
													<?php if($row->accounts_aproval == 1){ ?>
														<button type="button" class="btn btn-xs btn-success" title="Account Aproval">ACC: Approved</button>
													<?php }else if($row->accounts_aproval == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger" title="Account Aproval">ACC: Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-info" title="Account Aproval">ACC: Pending</button>	
													<?php } ?>
													
													<?php if($row->self_aproval == 1){ ?>
														<button type="button" class="btn btn-xs btn-success" title="Self Aproval">SLF: Approved</button>
													<?php }else if($row->self_aproval == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger" title="Self Aproval">SLF: Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-info" title="Self Aproval">SLF: Pending</button>	
													<?php } ?>
													</div>
												</td>
												<td><?php echo $row->data; ?></td>												
												<td>
													<?php if($row->self_aproval == 1 OR $row->accounts_aproval == 1 OR $row->accounts_aproval == 1 OR $row->department_head_aproval == 1 OR $row->self_aproval == 2 OR $row->accounts_aproval == 2 OR $row->accounts_aproval == 2 OR $row->department_head_aproval == 2){}else{ ?>
														<input value="<?php echo $row->id; ?>" name="selected_ids[]" type="checkbox" class="regular-checkbox">
													<?php } ?>
												</td>
								</form>
												<td>
													<?php if($row->self_aproval == 1 OR $row->accounts_aproval == 1 OR $row->accounts_aproval == 1 OR $row->department_head_aproval == 1 OR $row->self_aproval == 2 OR $row->accounts_aproval == 2 OR $row->accounts_aproval == 2 OR $row->department_head_aproval == 2){ } else{ ?>
													<form class="individual-form" action="<?php echo current_url(); ?>" method="post">
														<input type="hidden" name="hidden_id" value="<?php echo $row->id; ?>"/>
														<button type="submit" name="aprove_data"  class="btn btn-xs btn-success" onclick="return confirm('Are you sure want to Aprove <?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?>?')">Approve</button>
														<button type="submit" name="reject_data"  class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Reject <?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?>?')">Reject</button>
													</form>
													<?php } ?>
												</td>
											</tr>
										<?php } } ?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="10">
													<button type="button" id="select" class="btn btn-xs btn-success" style="margin-left:5px;"><i class="fas fa-tasks"></i></button>
													<button type="button" id="unselect" class="btn btn-xs btn-danger"><i class="fa fa-bars" aria-hidden="true"></i></button>
												</td>
											</tr>
										</tfoot>
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
$("#select").click(function(){
	$('.selected_button').show();
	$('.individual-form').hide()
	$('input:checkbox').prop('checked',true);  	  
});
$("#unselect").click(function(){
	$('.selected_button').hide();
	$('.individual-form').show()
	$('input:checkbox').prop('checked',false);
});

$(document).ready(() => {
	let checkboxes = $("input[type=checkbox]")
	let enabledSettings = [];

	// Attach a change event handler to the checkboxes.
	checkboxes.change(function() {
		checked = checkboxes
			.filter(":checked") // Filter out unchecked boxes.
			.get()				// Get array.
		if($( this ).is(":checked")){
			$(this).closest("td").next().find('.individual-form').hide();
		}else{
			$(this).closest("td").next().find('.individual-form').show();
		}
		if(checked.length != 0){	
			$('.selected_button').show();
		}else{
			$('.selected_button').hide();
		}
	});
});

</script>