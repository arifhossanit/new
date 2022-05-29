<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Collection Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">All Collection Report</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
<style>
@media print
{    
    .no-print {
        display: none !important;
    }
}
</style>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">					
					<div class="row">
						<div class="col-sm-12">
							<form action="<?php echo current_url(); ?>" method="post">
								<div class="row" style="margin-bottom:15px;">								
									<div class="col-sm-12">
										<div class="row">
											<!-- 
											<div class="col-sm-2">
												<div class="form-group">
													<select name="branch_id" class="form-control select2">
														<?php /*
														if($_SESSION['super_admin']['role_id'] == '2805597208697462328' OR $_SESSION['super_admin']['role_id'] == '1622657840330042228'){
															echo '<option value="1">All Branches</option>';
														}									
														if(!empty($banches)){
															foreach($banches as $row){
																if(!empty($b_id) AND $row->branch_id == $b_id){
																	$selected = 'selected';
																}else{
																	$selected = '';
																}
																echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
															}
														}	*/												
														?>
													</select>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="far fa-calendar-alt"></i>
														</span>
														</div>
														<input name="date_range" type="text" value="<?php if(!empty($date_range)){ echo $date_range; } ?>" class="form-control float-right date_range">
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<button type="submit" name="date_sub" class="btn btn-success" style="float:left;"> Filter</button>
											</div>										 -->
										</div>											
										<div class="row">																			
											
										</div>
										
									</div>
								</div>
							</form>
							

							<div class="card card-primary card-outline card-outline-tabs">
								<div class="card-header p-0 border-bottom-0">
									<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
										<?php if(check_permission('role_1609928808_79')){ ?>
										<li class="nav-item">
											<a class="nav-link <?php if(empty($mis_act)){ echo  'active'; } ?>" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Collection</a>
										</li>
										<?php } ?>
										<?php if(check_permission('role_1609828362_40')){ ?>
										<!-- <li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-dropbox-tab <?php if(!empty($mis_act)){ echo  'active'; } ?>" data-toggle="pill" href="#custom-tabs-four-dropbox" role="tab" aria-controls="custom-tabs-four-dropbox" aria-selected="false">DropBox</a>
										</li> -->
										<?php } ?>
										<?php if(check_permission('role_1609828362_81')){ ?>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-collected_dropbox-tab" data-toggle="pill" href="#custom-tabs-four-collected_dropbox" role="tab" aria-controls="custom-tabs-four-collected_dropbox" aria-selected="false">Collected Cash Report</a>
										</li>
										<?php } ?>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-four-tabContent">
										<?php if(check_permission('role_1609928808_79')){ ?>
										<div class="tab-pane fade <?php if(empty($mis_act)){ echo  'show active'; } ?>" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
											<div class="card card-success">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i>Collection Report</h3>
													<div id="export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">	<!--display: contents;-->								
													<style>#collection_report_datatable_wrapper{overflow-x:scroll;} #collection_report_datatable td{text-align:center;vertical-align: middle;white-space: pre;}#collection_report_datatable th{text-align:center;vertical-align: middle;}#collection_report_datatable td:last-child{text-align:left;}</style>
													<table id="collection_report_datatable" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>#</th>
																<th>SL</th>
																<th>Branch</th>
																<th>Transaction_ID</th>
																<th>Payment_Purpose</th>
																<th>Payments_Details</th>
																<th>Name</th>										
																<th>Package</th>												
																<th>Card</th>												
																<th>Cash</th>												
																<th>Mobile</th>											
																<th>Chaque</th>											
																<th>Sub_total</th>																					
																<th>Received_By</th>
																<th>Date</th>
															</tr>
														</thead>
														<tbody>
															<?php															
															if(!empty($payment_reports)){
																$i = 1;
																$card_total = 0;
																$cash_total = 0;
																$mobile_total = 0;
																$check_total = 0;
																$subb_total = 0;
																$swf_amount = 0;
																foreach($payment_reports as $row){
																	if(!empty($transaction)){																				
																		foreach($transaction as $tow){
																			if($tow->transaction_id == $row->transaction_id){
																				$Payment_Purpose = $tow->note;
																				$type = $tow->transaction_type;
																				$transaction_id = $tow->transaction_id;
																				$amount = $tow->amount;
																				break;
																			}	    
																		}
																	}else{
																		$Payment_Purpose = '';
																		$type = '';
																		$transaction_id = '';
																		$amount = '';
																	}
																	if(!empty($banches)){
																		$branch_name = '';
																		foreach($banches as $bow){
																			if($bow->branch_id == $row->branch_id){
																				$branch_name .= $bow->branch_name;
																				break;
																			}		    
																		}
																	}
																	$member_info = $this->Dashboard_model->mysqlij("select * from ipo_member_directory where ipo_id = '".$row->ipo_id."'");
																	
																	
																	$full_name = $member_info->personal_full_name;
																	$package = '-';
																	
																	$up_inf = explode('___',$row->uploader_info);
																	$emp_name = $this->Dashboard_model->mysqlij("select f_name, l_name, employee_id from employee where email = '".$up_inf[1]."'");
																	$employee_name = $emp_name->f_name.' '.$emp_name->l_name.' | '.$emp_name->employee_id;
																	if(!empty($type) AND $type == 'Credit'){
																	$sub_total = (float)$row->card_amount + (float)$row->cash_amount + (float)$row->mobile_amount + (float)$row->check_amount;
																?>										
																<tr>
																	<td style="white-space: unset;">
																		<?php if($row->note == 'cash_received' ){ ?>
																			<div style="width:18.33px;height:18.33px;background-color:green;border-radius:5px;margin-left:3.3px;border:solid 3px #333;"></div>
																		<?php 
																		}else{
																			if($row->cash_amount > 0 OR $row->check_amount > 0){ ?>
																				<input type="checkbox" class="sent_ides_checkbox" name="received_ids" id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" style="transform: scale(1.5);"/>
																		<?php }else{ ?>
																				<div style="width:18.33px;height:18.33px;background-color:#f00;border-radius:5px;margin-left:3.3px;border:solid 3px #333;"></div>
																		<?php } } ?>
																	</td>
																	<td><?php echo $i++; if(!empty($_SESSION['super_admin']['user_type']) AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>_<?php echo $row->id; } ?></td>
																	<td><?php echo $branch_name; ?></td>
																	<!--<td style="font-weight:bolder;color:green;">#<?php echo $row->invoice_number; ?></td>-->
																	<td style="font-weight:bolder;color:green;"><?php echo $transaction_id; ?></td>
																	<!--<td><?php echo $type; ?></td>-->
																	<td><?php echo $Payment_Purpose; ?></td>
																	<td><marquee style="width:150px; height: 17px; line-height: 16px;"><?php echo $row->details; ?></marquee></td>
																	<td><?php if(!empty($full_name)){ echo $full_name; } ?></td>
																	<td><?php if(!empty($package)){ echo $package; } ?></td>
																	<td style="text-align:right;<?php if($row->card_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->card_amount; ?></td>
																	<td style="text-align:right;<?php if($row->cash_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->cash_amount; ?></td>
																	<td style="text-align:right;<?php if($row->mobile_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->mobile_amount; ?></td>
																	<td style="text-align:right;<?php if($row->check_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->check_amount; ?></td>
																	<td style="text-align:right;<?php if($sub_total > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo $sub_total; ?></td>
																	<td style="text-align:right;"><?php echo $employee_name; ?></td>
																	<td style="text-align:right;"><?php echo $row->data; ?></td>
																</tr>											
															<?php 
																	$card_total = $card_total + (float)$row->card_amount;
																	$cash_total = $cash_total + (float)$row->cash_amount;
																	$mobile_total = $mobile_total + (float)$row->mobile_amount;
																	$check_total = $check_total + (float)$row->check_amount;
																	$subb_total = $subb_total + $sub_total;
																	$swf_amount = $swf_amount + $amount;
																	}
																}
															?>	
															<tr style="font-size:23px;">
																<td style="font-size:0px;">x</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td style="text-align:right;font-weight:bolder;color:green;">Total:</td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $card_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $cash_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $mobile_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $check_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $subb_total; ?></td>
																<td></td>
																<td></td>
															</tr>
															<?php																
															} 
															?>											
														</tbody>
													</table>
													<div align="left" style="margin-bottom:10px;margin-top: 15px;">
														<button type="button" id="select" class="btn btn-warning" style="margin-left:15px;">Select All</button>
														<button type="button" id="unselect" class="btn btn-success">Unselect All</button>
														<button type="button" id="cash_collect" class="btn btn-danger">Collect Cash Amount</button>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if(check_permission('role_1609828362_81')){ ?>
										<div class="tab-pane fade" id="custom-tabs-four-collected_dropbox" role="tabpanel" aria-labelledby="custom-tabs-four-collected_dropbox-tab">
											<div class="card card-primary">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i>Collected Form DropBox</h3>
													<div id="export_buttons_dropbox_collection" style="float: right;"></div>
												</div>
												<style>
													.table_header{
														color:#f00;
														font-weight:bold;
														background-color:#fff;
														padding:3px;
														border-radius:5px;
													}
												</style>											
												<div class="card-body">	
												<table id="collection_received_datatable" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>SL</th>
																<th>Branch</th>
																<th>Transaction_ID</th>
																<th>Payment_Purpose</th>
																<th>Payments_Details</th>
																<th>Name</th>										
																<th>Package</th>												
																<th>Cash</th>												
																<th>Withdrawn_By</th>
																<th>Withdraw Date</th>
															</tr>
														</thead>
														<tbody>
															<?php															
															if(!empty($payment_reports_received)){
																$i = 1;
																$card_total = 0;
																$cash_total = 0;
																$mobile_total = 0;
																$check_total = 0;
																$subb_total = 0;
																$swf_amount = 0;
																foreach($payment_reports_received as $row){
																	if(!empty($transaction)){																				
																		foreach($transaction as $tow){
																			if($tow->transaction_id == $row->transaction_id){
																				$Payment_Purpose = $tow->note;
																				$type = $tow->transaction_type;
																				$transaction_id = $tow->transaction_id;
																				$amount = $tow->amount;
																				break;
																			}	    
																		}
																	}else{
																		$Payment_Purpose = '';
																		$type = '';
																		$transaction_id = '';
																		$amount = '';
																	}
																	if(!empty($banches)){
																		$branch_name = '';
																		foreach($banches as $bow){
																			if($bow->branch_id == $row->branch_id){
																				$branch_name .= $bow->branch_name;
																				break;
																			}		    
																		}
																	}
																	$member_info = $this->Dashboard_model->mysqlij("select * from ipo_member_directory where ipo_id = '".$row->ipo_id."'");
																	
																	
																	$full_name = $member_info->personal_full_name;
																	$package = '-';
																	
																	$emp_name = $this->Dashboard_model->mysqlij("select f_name, l_name, employee_id from employee where employee_id = '".$row->collected_by."'");
																	$employee_name = $emp_name->f_name.' '.$emp_name->l_name.' | '.$emp_name->employee_id;
																	if(!empty($type) AND $type == 'Credit'){
																	$sub_total = (float)$row->card_amount + (float)$row->cash_amount + (float)$row->mobile_amount + (float)$row->check_amount;
																?>										
																<tr>
																	<td><?php echo $i++; if(!empty($_SESSION['super_admin']['user_type']) AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>_<?php echo $row->id; } ?></td>
																	<td><?php echo $branch_name; ?></td>
																	<!--<td style="font-weight:bolder;color:green;">#<?php echo $row->invoice_number; ?></td>-->
																	<td style="font-weight:bolder;color:green;"><?php echo $transaction_id; ?></td>
																	<!--<td><?php echo $type; ?></td>-->
																	<td><?php echo $Payment_Purpose; ?></td>
																	<td><marquee style="width:150px; height: 17px; line-height: 16px;"><?php echo $row->details; ?></marquee></td>
																	<td><?php if(!empty($full_name)){ echo $full_name; } ?></td>
																	<td><?php if(!empty($package)){ echo $package; } ?></td>
																	<td style="text-align:right;<?php if($row->cash_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->cash_amount; ?></td>
																	<td style="text-align:right;"><?php echo $employee_name; ?></td>
																	<td style="text-align:right;"><?php echo $row->received_date; ?></td>
																</tr>											
															<?php 
																	$card_total = $card_total + (float)$row->card_amount;
																	$cash_total = $cash_total + (float)$row->cash_amount;
																	$mobile_total = $mobile_total + (float)$row->mobile_amount;
																	$check_total = $check_total + (float)$row->check_amount;
																	$subb_total = $subb_total + $sub_total;
																	$swf_amount = $swf_amount + $amount;
																	}
																}
															?>	
															<tr style="font-size:23px;">
																<td style="font-size:0px;">x</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td style="text-align:right;font-weight:bolder;color:green;">Total:</td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $cash_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"></td>
																<td style="text-align:right;font-weight:bolder;color:green;"></td>
																<td></td>
																<td></td>
															</tr>
															<?php																
															} 
															?>											
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<?php } ?>
										
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
<!----Add Rent Model-->
	<div class="modal fade" id="collection_details_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">				
				<div class="modal-header btn-success">
					<h4 class="modal-title">Callection Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="callection_details_body" style="max-height:780px;min-height:400px;overflow-y:scroll;">	
					
				</div>
			</div>
		</div>
	</div>
<!----End Add Rent Model-->

<!---
<form action="<?php echo current_url(); ?>" method="post">
	<input type="hidden" name="hidden_id" value="<?php echo $row->id; ?>"/>
	<button onclick="return confirm('Are You sure want to sent back this transaction?')" class="btn btn-xs btn-danger" name="missing" type="submit"><i class="fas fa-backspace"></i> Missing</button>
</form>
																	
-->																	

<script>
function details_collection_money(ids){
	if(ids != ''){
		$.ajax({
			url:'<?php echo base_url(); ?>assets/ajax/option_select/collected_money_details_information.php',
			method:'POST',
			data:{collected_id:ids},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){
				$('#data-loading').html('');
				$("#callection_details_body").html(data);				
				$("#collection_details_model").modal('show');				
			}     
		});
	} 
}
$(document).ready(function(){ 
	$("#select_back").click(function(){
			$('.sent_back_ides_checkbox:checkbox').prop('checked',true);     
	});
	$("#unselect_back").click(function(){
			$('.sent_back_ides_checkbox:checkbox').prop('checked',false);     
	});
	$('#btn_delete_back').click(function(){  
		if(confirm("Are you sure you want to Missing selected Iteam?")){
			var id = [];   
			$('.sent_back_ides_checkbox:checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					url:'<?= current_url(); ?>',
					method:'POST',
					data:{missing_id:id},
					beforeSend:function(){					
						$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
					},
					success:function(data){
						$('#data-loading').html('');
						var val = data.split('________');
						alert(val[0]);
						window.open('<?= current_url(); ?>','_self');
					}     
				});
			}   
		}else{
			return false;
		}
	});

	//sent_ides_checkbox
	$("#select").click(function(){
			$('.sent_ides_checkbox:checkbox').prop('checked',true);     
	});
	$("#unselect").click(function(){
			$('.sent_ides_checkbox:checkbox').prop('checked',false);     
	});
	$('#cash_collect').click(function(){  		
			var id = [];   
			$('.sent_ides_checkbox:checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select at least one checkbox");
				return false;
			}
			if(confirm("Are you sure you want to send selected Iteam?")){
				$.ajax({
					url:'<?= current_url(); ?>',
					method:'POST',
					data:{cash_collect:id},
					beforeSend:function(){					
						$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
					},
					success:function(data){
						$('#data-loading').html('');
						var val = data.split('________');
						alert(val[0]);
						window.open('<?= current_url(); ?>','_self');
					}     
				});
			} else {
				return false;
			}
	});
 
});

//-----------------rental work java script-------------------------
$('document').ready(function(){
	var table_booking1 = $('#collection_report_datatable').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": false,
		"autoWidth": false,
		"responsive": false,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table_booking1.buttons().container().appendTo($('#export_buttons'));	
	
	var table_booking3 = $('#collection_received_datatable').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table_booking3.buttons().container().appendTo($('#export_buttons_dropbox'));	
	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>