<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Transport Allowance / Food Allowance Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Transport Allowance / Food Allowance Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

<?php
$branch = $this->Dashboard_model->mysqlii("select * from branches where status = '1'");
?>	
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
									Information
								</div>
								<div class="card-body">
									<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
										<input type="hidden" name="employee_id" value="<?php echo $_SESSION['super_admin']['employee_ids']; ?>"/>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>From</label>
													<select onchange="return from_other_function()" name="destination_from" class="form-control select2" required="required">
														<option value="">From</option>
														<?php
															if(!empty($branch)){
																foreach($branch as $row){
																	echo '<option value="'.$row->branch_name.'">'.$row->branch_name.'</option>';
																}
															}
														?>
														<option value="1">Other</option>
													</select>
												</div>
												<div class="form-group from_other" style="display:none;"></div>
												
												<div class="form-group">
													<label>Select Date</label>
													<input type="date" name="transport_date" placeholder="Date" class="form-control" required="required" />
												</div>					
												<div class="form-group">
													<label>Transport Type</label>
													<select name="transport_type" class="form-control select2" required="required">
														<option value="">Transport Type</option>
														<option value="One Way">One Way</option>
														<option value="Up Down">Up Down</option>
													</select>
												</div>
												<div class="form-group">
													<label>Transportation Detail/Reason</label>
													<textarea name="transport_details" placeholder="Transportation Detail/Reason" class="form-control" required="required"></textarea>
												</div>
												
												
												<div class="form-group">
													<label>Note</label>
													<textarea name="note" placeholder="Note" class="form-control"></textarea>
												</div>
												
											</div>								
											
											<div class="col-sm-6">
												<div class="form-group">
													<label>To</label>
													<select onchange="return to_other_function()" name="destination_to" class="form-control select2" required="required">
														<option value="">To</option>
														<?php
															if(!empty($branch)){
																foreach($branch as $row){
																	echo '<option value="'.$row->branch_name.'">'.$row->branch_name.'</option>';
																}
															}
														?>
														<option value="1">Other</option>
													</select>
												</div>
												<div class="form-group to_other" style="display:none;"></div>
												
												
												
												<div class="form-group">
													<label>Transport Amount</label>
													<input type="text" name="transport_amount" placeholder="Transport Amount" autocomplete="off" class="number_int form-control" required="required"/>
												</div>
												<div class="form-group">
													<label>Food Amount(If Used)</label>
													<input type="text" name="food_amount" placeholder="Food Amount" autocomplete="off" class="number_int form-control"/>
												</div>
												<div class="form-group">
													<label>Vehicle Type</label>
													<select name="vehicle_type[]" data-placeholder="Vehicle Type" multiple="multiple" class="form-control select2" required="required">
														<option value="Bus">Bus</option>
														<option value="Riksha">Riksha</option>
														<option value="CNG">CNG</option>
														<option value="Pathaw">Pathaw</option>
														<option value="Ubar">Ubar</option>
														<option value="Vane">Vane</option>
														<option value="Truck">Truck</option>
													</select>
												</div>
												<div class="form-group">
													<label>Vehicle Type Reason</label>
													<textarea name="vehicle_type_reason" placeholder="Vehicle Type Reason" class="form-control" required="required"></textarea>
												</div>
												<div class="form-group">
													<label>Bill Attachment</label>
													<input type="file" name="bill_attachment" placeholder="Bill Attachment" style="padding-top:3px;padding-left:3px;" class="form-control"/>
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
						
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							TA / DA Logs
						</div>
						<div class="card-body">
							<table class="table table-sm table-striped table-bordered" id="example2">
								<thead>
									<tr>
										<th>Name</th>
										<th>Destination & Date</th>	
										<th>Type & Details</th>
										<th>Vehicle & Reason</th>
										<th>Amount</th>										
										<th>Uploader & Attachment</th>
										<th>Aproval</th>
										<th>Date</th>
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
											<?php if($row->self_aproval == 1 OR $row->accounts_aproval == 1 OR $row->accounts_aproval == 1 OR $row->department_head_aproval == 1 OR $row->self_aproval == 2 OR $row->accounts_aproval == 2 OR $row->accounts_aproval == 2 OR $row->department_head_aproval == 2){ } else{ ?>
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
<style>
.scst_grp button{
	width:100px;
}
</style>
<script>
function from_other_function(){
	var value = $('select[name="destination_from"]').val();
	if(value == 1){
		$(".from_other").css({"display":"block"});
		$(".from_other").html('<input type="text" name="from_other" placeholder="From Other" class="form-control" required="required"/>');
	}else{
		$(".from_other").css({"display":"none"});
		$(".from_other").html('');
	}
}
function to_other_function(){
	var value = $('select[name="destination_to"]').val();
	if(value == 1){
		$(".to_other").css({"display":"block"});
		$(".to_other").html('<input type="text" name="to_other" placeholder="From To" class="form-control" required="required"/>');
	}else{
		$(".to_other").css({"display":"none"});
		$(".to_other").html('');
	}
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>