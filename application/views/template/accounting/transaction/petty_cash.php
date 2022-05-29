<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Petty Cash</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
				<li class="breadcrumb-item active">Petty Cash</li>
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
									<form action="<?php echo current_url(); ?>" method="post">
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
														<?php $_COUNT_BRANCH = $this->Dashboard_model->mysqlii("SELECT count(*) as total_request FROM petty_cash_request_logs where status = '1'"); ?>
														<label>Branch <span style="color:#f00;">(<?php echo $_COUNT_BRANCH[0]->total_request; ?>)</span></label>
														<select name="branch_id" id="branch_id" class="form-control select2" required onchange="get_petty_cash_limit()">
															<option value="">--select--</option>
															<?php
																if(!empty($petty_cash)){
																	foreach($petty_cash as $row){
																		$_RWQUESTED_BRANCH = $this->Dashboard_model->mysqlii("SELECT * FROM petty_cash_request_logs WHERE status = '1' AND branch_id = '".$row->branch_id."'");
																		if(!empty($_RWQUESTED_BRANCH[0]->id) AND $_RWQUESTED_BRANCH[0]->branch_id == $row->branch_id){
																			if(!empty($branch)){
																				foreach($branch as $pow){
																					if($pow->branch_id == $row->branch_id){
																						$branch_name = $pow->branch_name;
																					}
																				}
																			}
																			if($row->given_date == date('Y-m-d')){
																				$disabled = 'disabled';
																				$paid = ' - (Paid)';
																			}else{
																				$disabled = '';
																				$paid = '';
																			}
																			$disabled = '';
																			$paid = '';
																			echo '<option value="'.$row->branch_id.'" '.$disabled.'>'.$branch_name.''.$paid.' </option>'; //'.$_RWQUESTED_BRANCH[0]->amount.' -
																		}																		
																	}
																}
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label>Amount</label>
														<input type="number" name="amount" id="amount" class="form-control" required onkeyup="adjust_amount()"/>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label>Petty Cash Limit</label>
														<input type="number" name="petty_cash_limit" id="petty_cash_limit" class="form-control" placeholder="Select Branch !!" readonly />
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
												<textarea name="note" class="form-control" style="height:150px;" required ></textarea>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm">
													<p> Adjust Amount: <span class="text-danger text-bold" id="amount_remaining"></span></p>
												</div>
												<div class="col-sm">
													<div class="form-group">
														<button name="add_amount" id="add_amount" type="submit" class="btn btn-success" style="float:right;" disabled>Submit</button>
													</div>
												</div>
											</div>											
										</div>
									</form>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-sm-12">
									<h4>Branch wise rest of amount</h4>
									<div style="overflow:scroll;width:100%;max-height:300px;">
									<table class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
										<thead>
											<tr>
												<th>Id</th>
												<th>Transaction ID</th>
												<th>Branch</th>
												<th>Amount</th>
												<th>Added Date</th>
												<th>Note</th>												
											</tr>
										</thead>
										<tbody>	
<?php
	if(!empty($petty_cash)){
		foreach($petty_cash as $row){
			if(!empty($branch)){
				foreach($branch as $bow){
					if($bow->branch_id == $row->branch_id){
						$branch_name = $bow->branch_name;
					}					
				}
			}
?>										
											<tr>
												<td><?php echo $row->id; ?></td>
												<td><?php echo $row->transaction_id; ?></td>
												<td><?php echo $branch_name; ?></td>
												<td style="font-weight:bolder;color:#f00;"><?php echo money($row->amount); ?></td>
												<input type="hidden" value="<?php echo $row->amount; ?>" id="petty_cash_amount_<?php echo $row->branch_id; ?>">
												<td><?php echo $row->given_date; ?></td>
												<td><?php echo $row->note; ?></td>
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
				<div class="col-sm-7">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title"><i class="far fa-bed"></i> Petty Cash Logs</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped nowrap" style="width:100%;white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Transaction ID</th>
										<th>Branch</th>
										<th>Amount</th>
										<th>Added Date</th>
										<th>Note</th>
										<th>Added By</th>												
										<th>Date</th>
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
<script>
function get_petty_cash_limit() {
	let branch_id = $('#branch_id').val();
	$.ajax({  
		url:"<?=base_url()?>assets/ajax/accounting/get_petty_cash_limit_for_branch.php",
		method:"POST",
		data:{branch_id:branch_id },
		success:function(data){
			$('#petty_cash_limit').val(data);
			adjust_amount(branch_id);
		}  
	});
}
function adjust_amount() {
	let branch_id = $('#branch_id').val();
	let petty_cash_amount = Number($('#petty_cash_amount_' + branch_id).val());
	let amount = ($('#amount').val() == '') ? 0 : Number($('#amount').val());
	let petty_cash_limit = Number($('#petty_cash_limit').val());
	// console.log(petty_cash_amount + amount);
	if((amount) <= petty_cash_limit){
		$('#add_amount').prop('disabled', false);
	}else{
		$('#add_amount').prop('disabled', true);
	}
	$('#amount_remaining').html(Math.ceil( petty_cash_limit - (petty_cash_amount + amount) ));
	//$('input[name="amount"]').val(petty_cash_limit - (petty_cash_amount + amount));
}
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"scrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/branch_petty_cash_logs_datatable.php",
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
                titleAttr: 'PDF',
				exportOptions: {
					columns: ':visible'
				}
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
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>