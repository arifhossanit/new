<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Advance For purchase</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
				<li class="breadcrumb-item active">Advance For purchase</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-5">
					<div class="card card-success">
						<div class="card-header">
							Input Money Information
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<form id="advance_money_aproval_form" action="<?php echo current_url(); ?>" method="post">
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label>Transaction ID:</label>
														<input type="text" name="transaction_id" value="<?php echo date('dmY').'-'.rand(); ?>" class="form-control" readonly />
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<?php 
															$total = 1;
															$totalr = 0;
															$e_requesti = $this->Dashboard_model->mysqlii("SELECT * FROM advance_money_request where status = '1'");
															foreach($e_requesti as $a){
																$totalr = $totalr + $total++;
															}															
														?>
														<label>Employee <?php echo '<span style="color:#f00p;">('.$totalr.')</span>';?></label>
														<select name="request_id" id="request_id" onchange="return fillup_money_form()" class="form-control select2" required >
															<option value="">--select--</option>
															<?php
																$e_request = $this->Dashboard_model->mysqlii("SELECT * FROM advance_money_request where status = '1' ORDER BY id ASC");
																foreach($e_request as $row){
																	$employeei = $this->Dashboard_model->mysqlii("SELECT * FROM employee where status = '1' and employee_id = '".$row->employee_id."'");
																	foreach($employeei as $emp){
																		$name = $emp->full_name;
																		$emp_id = $emp->employee_id;
																	}
																	echo '<option value="'.$row->id.'">'.$name.' - '.$emp_id.' ('.money($row->amount).')</option>';
																}
															?>
														</select>
														<input type="hidden" id="employee_id" name="employee_id" value=""/>
														<input type="hidden" id="add_amount" name="add_amount" value="true"/>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label>Amount</label>
														<input type="text" id="amount" name="amount" autocomplete="off" class="number_int form-control" required />
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label>Department</label>
														<input type="text" id="department_name" name="department" autocomplete="off" class="number_int form-control" required />
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label>Date</label>
														<input type="date" name="date_given" value="<?php echo date('Y-m-d'); ?>" class="form-control" readonly />
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Note</label>
												<textarea name="note" id="note" class="form-control" required ></textarea>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Approver Note</label>
												<textarea name="approver_note" id="approver_note" placeholder="Approver Note" class="form-control" required ></textarea>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<button name="add_amount_reject" type="submit" class="btn btn-danger" style="float:left;"><i class="fas fa-times"></i> Reject</button>
												<button name="add_amount_accept" type="submit" class="btn btn-success" style="float:right;"><i class="fas fa-check"></i> Accept</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<script>
								/*$('document').ready(function(){
									$("#advance_money_aproval_form").on("submit",function(){
										$('button[name="add_amount_accept"]').prop('disabled', true);
										$('button[name="add_amount_reject"]').prop('disabled', true);
										return true;
									})
								})
								*/
							</script>
							<hr />
							<div class="row">
								<div class="col-sm-12">
									<div id="export_buttons_dropbox_collection_details" style="float: right;"></div>
								</div>
								<div class="col-sm-12">
									<h4>Employee wise rest of amount</h4>
<?php
	$total = 0;
	if(!empty($petty_cash)){
		foreach($petty_cash as $row){
			$total = $total + (float)$row->amount;
		}
	} 
	echo '<p>Total Amount In Advance Petty cash: <span style="font-weight:bolder;color:#f00;">'. money($total).'</span></p>';
?>										
									<table id="employee_amount_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
										<thead>
											<tr>
												<th>Id</th>
												<th>Last Transaction ID</th>
												<th>Employee</th>
												<th>Department</th>
												<th>Amount</th>
												<th>Added Date</th>
												<th>Last Note</th>												
											</tr>
										</thead>
										<tbody>	
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-7">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title"><i class="far fa-bed"></i> Petty Cash Logs</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Id</th>
										<th>Transaction ID</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Amount</th>
										<th>Added Date</th>
										<th>Note</th>
										<th>Added By</th>												
										<th>Date</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>	
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($_SESSION['advance_pratty_warning_modal'])){ ?>
<div class="modal fade" id="advance_pratty_warning_modal">
	<div class="modal-dialog modal-xl" >
		<div class="modal-content">	
			<div class="modal-header btn-danger">
				<h4 class="modal-title">Warning!</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="padding-top:50px;">
				<center>
					<i class="fas fa-exclamation-triangle" style="font-size:70px;color:#f00;"></i>
					<h1 style="padding-top:70px;padding-bottom:70px;">
						<?php echo $_SESSION['advance_pratty_warning_modal']; ?>
					</h1>
					<br />
					<a href="javascript:void(0);" onclick="return advance_patty_cash_page_refresh();"><h4>Click here to refresh the page!</h4></a>
				</center>
			</div>
		</div>
	</div>
</div>
<script>
function advance_patty_cash_page_refresh(){
	var status = '1';
	$.ajax({  
		url:"<?php echo current_url(); ?>",  
		method:"POST",  
		data:{ distry_advance_pratty_warning:status },
		success:function(data){	
			window.open('<?php echo current_url(); ?>','_self');
		}
	});
}
$(document).ready(function(){
	$('#advance_pratty_warning_modal').modal('show');
	$('#advance_pratty_warning_modal').on('hidden.bs.modal', function () {
		var status = '1';
		$.ajax({  
			url:"<?php echo current_url(); ?>",  
			method:"POST",  
			data:{ distry_advance_pratty_warning:status },
			success:function(data){	
				window.open('<?php echo current_url(); ?>','_self');
			}
		});
	});
})

</script>
<?php } ?>
<script>
function resend_balance_accepted_otp(id, db_id){
	var employee_id = id;
	if(employee_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/resend_balance_accepted_otp.php');?>",  
			method:"POST",  
			data:{ employee_id:employee_id, db_id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data);
			}
		});
	}
}
function fillup_money_form(){
	var request_id = $("#request_id").val();
	if(request_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/get_advance_money_request_info.php');?>",  
			method:"POST",  
			data:{ request_id:request_id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
			
				$('#data-loading').html('');
				var value = data.split('________');
				$("#amount").val(value[0]); 
				$("#note").val(value[1]);
				$("#employee_id").val(value[2]);
				$("#department_name").val(value[3]); 
				$('#amount').prop('readOnly', true);
				$('#department_name').prop('readOnly', true);
				$('#note').prop('readOnly', true);
				
			}
		});
	}
}
$(document).ready(function() {
	var table_booking = $('#employee_amount_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"scrollX": true,
		"searching": true,
		"ordering": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/advance_petty_cash_datatable.php",
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
            }
        ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons_dropbox_collection_details'));	
	
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"scrollX": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/advance_petty_cash_logs_datatable.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            }, {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            }, {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            }, {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            }
        ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>