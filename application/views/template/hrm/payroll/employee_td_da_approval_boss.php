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
									<table class="table table-sm table-bordered" id="ta_da_table_boss">
										<thead>
											<tr>
												<th>#</th>
												<th>Image</th>
												<th>Name</th>
												<th>Department - Designation</th>	
												<th>Destination & Date</th>	
												<th>Type & Details</th>
												<th>Vehicle & Reason</th>
												<th>Amount</th>										
												<th>Uploader & Attachment</th>
												<th>D:HEAD</th>
												<th>Aproval</th>
												<th>Date</th>
												<th>#</th>
												<th>Option</th>
												<th>boss_approval</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(!empty($emp_list_table)){
												foreach($emp_list_table as $row){
													$emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->e_db_id."' order by id desc limit 01");
													$D_emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->department_head_id."' order by id desc limit 01");
										?>
											<tr>
												<td><?php echo $emp_list_table->id; ?></td>
												<td><?php echo '<img src="'.base_url($emp[0]->photo).'" style="width:50px;"/>' ?></td>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td><?php echo $emp[0]->department_name.' - '.$emp[0]->designation_name; ?></td>
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
													<b>Transport Amount:</b> <b style="color:red;"><?php echo money($row->transport_amount); ?>
														<?php if($row->self_aproval == 1 OR $row->accounts_aproval == 1 OR $row->boss_aproval == 1 OR $row->self_aproval == 2 OR $row->accounts_aproval == 2 OR $row->boss_aproval == 2){ } else{ ?>
														<a onclick="return edit_ta_money('<?php echo $row->id; ?>','<?php echo $row->transport_amount; ?>','<?php if(!empty($row->food_amount)){ echo $row->food_amount; }else{ echo 'NaN'; } ?>')" href="javascript:void(0)"><i class="fas fa-edit"></i></a>
														<?php } ?>
													</b>
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
												<td><?php if(!empty($D_emp[0]->photo)){ echo '<img src="'.base_url($D_emp[0]->photo).'" style="width:50px;"/>'; } ?></td>
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
													<?php if($row->self_aproval == 1 OR $row->accounts_aproval == 1 OR $row->boss_aproval == 1 OR $row->self_aproval == 2 OR $row->accounts_aproval == 2 OR $row->boss_aproval == 2){}else{ ?>
														<input value="<?php echo $row->id; ?>" name="selected_ids[]" type="checkbox" class="regular-checkbox">
													<?php } ?>
												</td>
								</form>
												<td>
													<?php if($row->self_aproval == 1 OR $row->accounts_aproval == 1 OR $row->boss_aproval == 1 OR $row->self_aproval == 2 OR $row->accounts_aproval == 2 OR $row->boss_aproval == 2){ } else{ ?>
													<form class="individual-form" action="<?php echo current_url(); ?>" method="post">
														<input type="hidden" name="hidden_id" value="<?php echo $row->id; ?>"/>
														<button type="submit" name="aprove_data"  class="btn btn-xs btn-success" onclick="return confirm('Are you sure want to Aprove <?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?>?')">Approve</button>
														<button type="submit" name="reject_data"  class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Reject <?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?>?')">Reject</button>
													</form>
													<?php } ?>
												</td>
												<td><?php echo $row->boss_aproval; ?></td>
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
<div class="modal fade" id="ta_da_model_edit">
	<div class="modal-dialog modal-sm" >
		<div class="modal-content">	
			<div class="modal-header btn-info">
				<h4 class="modal-title">Amount Info</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="#" method="POST">
					<input type="hidden" name="info_id" value=""/>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>TA Amount</label>
								<input type="text" name="ta_amount" class="form-control" autocomplete="off" id="ta_amount" placeholder="TA Amount" required />
							</div>
							<div class="form-group">
								<label>DA Amount</label>
								<input type="text" name="da_amount" class="form-control" autocomplete="off" id="da_amount" placeholder="DA Amount"/>
							</div>
							<div class="form-group">								
								<button onclick="return save_data_ta_da()" type="button" class="btn btn-success" style="width:100%;">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
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

function save_data_ta_da(){
	var info_id = $('input[name="info_id"]').val();
	var ta_amount = $('input[name="ta_amount"]').val();
	var da_amount = $('input[name="da_amount"]').val();
	if( info_id != '' && ta_amount != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_submit/ta_amount_update.php');?>",  
			method:"POST",
			data:{
				info_id:info_id,
				ta_amount:ta_amount,
				da_amount:da_amount
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('input[name="info_id"]').val('');
				$('input[name="ta_amount"]').val('');
				$('input[name="da_amount"]').val('');
				alert(data);
				$("#ta_da_model_edit").modal('hide');
				window.open('<?php echo current_url(); ?>','_self');
			}  
		});  
	}else{
		alert('Something Wrong! Please try Again');
	}
}
function edit_ta_money(id, tr_amount, da_amount){
	$('input[name="info_id"]').val(id);
	$('input[name="ta_amount"]').val(tr_amount);
	$('input[name="da_amount"]').val(da_amount);
	$("#ta_da_model_edit").modal('show');
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>