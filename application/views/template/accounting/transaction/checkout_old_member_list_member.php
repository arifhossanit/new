<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Checkout Old Member List</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
              <li class="breadcrumb-item active">Checkout Old Member List</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
<?php
if(!empty($edit)){
	$button = '
		<button type="submit" name="update" class="btn btn-warning">Update</button>
		<a href="'.current_url().'" class="btn btn-danger">Close</a>
	';
}else{
	$button = '<button type="submit" name="save" class="btn btn-primary">Save</button>';
}
?>	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12">
									<button data-target="#old_member" data-toggle="modal" class="btn btn-primary mb-2">Add Old Member</button>
								</div>
							</div>
							<span id="data_send_success_message"></span>
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">Checkout Old Member Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>id</th>
												<th>Branch</th>
												<th>Card No</th>
												<th>Name</th>												
												<th>Phone Number</th>
												<th>Bed</th>
												<th>CheckIN</th>
												<th>CheckOut</th>
												<th>Package</th>
												<th>S:Deposit</th>
												<th>Option</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
										<tfoot>	
											<tr>
												<th>id</th>
												<th>Branch</th>
												<th>Card No</th>
												<th>Name</th>												
												<th>Phone Number</th>
												<th>Bed</th>
												<th>CheckIN</th>
												<th>CheckOut</th>
												<th>Package</th>
												<th>S:Deposit</th>
												<th>Option</th>
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
<!----Insert member modal-->
	<div class="modal fade" id="old_member">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=base_url('admin/accounting/transaction/checkout-old-member-list/insert'); ?>" method="post" enctype="multipart/form-data">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Refund Sicurity Diposit Submit Form</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">
						<div class="row">
							<div class="col-md-6">
								<label for="branch">Branch</label>
								<input type="text" class="form-control" name="branch" placeholder="Branch">
							</div>
							<div class="col-md-6">
								<label for="card_no">Card Number</label>
								<input type="text" class="form-control" name="card_no" placeholder="Card Number">
							</div>
							<div class="col-md-6">
								<label for="name">Member Name</label>
								<input type="text" class="form-control" name="name" placeholder="Member Name">
							</div>
							<div class="col-md-6">
								<label for="phone">Phone</label>
								<input type="text" class="form-control" name="phone" placeholder="Phone">
							</div>
							<div class="col-md-6">
								<label for="bed">Bed</label>
								<input type="text" class="form-control" name="bed" placeholder="Bed">
							</div>
							<div class="col-md-6">
								<label for="package">Package</label>
								<input type="text" class="form-control" name="package" placeholder="Package">
							</div>
							<div class="col-md-6">
								<label for="check_in">Check In Date</label>
								<input type="date" class="form-control" name="check_in" placeholder="Check In Date">
							</div>
							<div class="col-md-6">
								<label for="check_out">Check Out Date</label>
								<input type="date" class="form-control" name="check_out" placeholder="Check Out Date">
							</div>
						</div>						
						<div class="row mt-3">
							<div class="col-md-4">
								<input type="file" name="file" class="form-control-file">
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="submit" id="form_submit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End insert member model-->


<!----Payment form-->
<div class="modal fade" id="old_member_payment">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=base_url('admin/accounting/transaction/checkout-old-paymetnt/insert'); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="old_member_id" id="old_member_id">
				<input type="hidden" name="old_member_name" id="old_member_name">
				<div class="modal-header btn-success">
					<h4 class="modal-title">Refund Security Deposit Submit Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">
				
					<div class="row mb-3">
						<div class="col-md-3">
							<select class="form-control" name="status" required>
								<option value="">Select Deposit Status</option>
								<option value="1">Rechecked</option>
								<option value="2">Deposit Returned</option>
							</select>
						</div>
						<div class="col-md-5">
							<textarea class="form-control" name="note" id="note" cols="30" rows="2" placeholder="Note!"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<h4 style="text-decoration:underline;">
								Payment Information									
								<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
									<button type="button" id='removeButton_payment' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
									<button type="button" id='addButton_payment' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
								</div>
							</h4>
							<span style="color:red;font-weight:bolder;" id="document_error_message"></span>
						</div>
					</div>
					<div id='UnitBoxesGroup_payment'>
						<div id="UnitBoxDiv_payment1">
							<div class="row" style="margin-top: 10px;">
								<div class="col-sm-3">
									<div class="form-group">
										<select onchange="return payment_function_on_change()" id="payment_method1" name="payment_method[]" class="form-control" required>
											<option value="">select payment method</option>
											<option value="Cash">Cash</option>
											<option value="Mobile Banking">Mobile Banking</option>
											<option value="Credit / Debit Card">Credit / Debit Card</option>
											<option value="Check">Check</option>										
										</select>
									</div>
								</div>
								<div class="col-sm-9">								
									<div class="row" id="mobile_banking1" style="display:none;">
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<select id="agent1" name="agent[]" class="form-control">
													<option value="">select agent</option>
													<option value="Bikash">bKash</option>
													<option value="Rocket">Rocket</option>
													<option value="Nogod">Nogod</option>
												</select>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="text" id="mobile_banking_number1" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="text" id="transaction_id1" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="number" id="mobile_amount1" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
											</div>
										</div>
										
									</div>
									<div class="row" id="check_number1" style="display:none;">
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="text" id="bank_name1" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="text" id="check_number1" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="date" id="withdraw_date1" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="number" id="check_amount1" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
											</div>
										</div>
									</div>
									
									<div class="row" id="credit_card1" style="display:none;">
										<div class="col-sm-6">
											<div class="form-group" style="width:100%;">
												<input type="text" id="credit_card_number1" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
											</div>
										</div>
										<input type="hidden" id="card_secret1" name="card_secret[]" value="0"/>

										
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="month" id="Expiry_Date1" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="number" id="card_amount1" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
											</div>
										</div>
									</div>
									
									<div class="row" id="cash1" style="display:none;">
										<div class="col-sm-9">
											<div class="form-group" style="width:100%;">
												<textarea id="cash_other_information_remarks1" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>											
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group" style="width:100%;">
												<input type="number" id="cash_amount1" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
											</div>
										</div>
									</div>							
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
					<div>
						<button type="submit" id="form_submit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End Payment form-->
<script>
let old_member_payment_info = (id, name) => {
	$('#old_member_id').val(id);
	$('#old_member_name').val(name);	
}

function card_payment_calculator(){
	if( $("#payment_method1").val() == 'Credit / Debit Card' && $("#payment_method12").val() == 'Credit / Debit Card' && $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#card_amount1").val());
		}else{
			var atot = 0;
		}		
		var rmatch_t = atot / 100 * 2;
		// $("#card_amount1").val(rmatch_t);
		
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#card_amount12").val());
		}else{
			var atot2 = 0;
		}		
		var rmatch_t2 = atot2 / 100 * 2;
		// $("#card_amount12").val(rmatch_t2);
		
		if($("#Expiry_Date13").val() > 0){
			var atot3 = parseFloat($("#card_amount13").val());
		}else{
			var atot3 = 0;
		}	

		var rmatch_t3 = atot3 / 100 * 2;
		// $("#card_amount13").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		
		var grnd_total_amt = rmatch_t + rmatch_t2 + rmatch_t3 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 6%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method1").val() == 'Credit / Debit Card' && $("#payment_method12").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#Expiry_Date1").val());
		}else{
			var atot = 0;
		}

		var rmatch_t = atot / 100 * 2;
		$("#card_amount1").val(rmatch_t);
		
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date12").val());
		}else{
			var atot2 = 0;
		}
		
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_amount12").val(rmatch_t2);
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t2 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method12").val() == 'Credit / Debit Card' && $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date12").val());
		}else{
			var atot2 = 0;
		}

		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_amount12").val(rmatch_t2);
		
		if($("#Expiry_Date13").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date13").val());
		}else{
			var atot3 = 0;
		}
		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_amount13").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t2 + rmatch_t3 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method1").val() == 'Credit / Debit Card' && $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#Expiry_Date1").val());
		}else{
			var atot = 0;
		}

		var rmatch_t = atot / 100 * 2;
		$("#card_amount1").val(rmatch_t);
		
		if($("#Expiry_Date13").val() > 0){
			var atot3 = parseFloat($("#Expiry_Date13").val());
		}else{
			var atot3 = 0;
		}

		var rmatch_t3 = atot3 / 100 * 2;
		$("#card_amount13").val(rmatch_t3);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + rmatch_t3;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
		
	}else if( $("#payment_method1").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date1").val() > 0){
			var atot = parseFloat($("#Expiry_Date1").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_amount1").val(rmatch_t);	
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt));		
	}else if( $("#payment_method12").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date12").val() > 0){
			var atot2 = parseFloat($("#Expiry_Date12").val());
		}else{
			var atot2 = 0;
		}
		var rmatch_t2 = atot2 / 100 * 2;
		$("#card_amount12").val(rmatch_t2);		
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t2 + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 2%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else if( $("#payment_method13").val() == 'Credit / Debit Card'){
		if($("#Expiry_Date13").val() > 0){
			var atot = parseFloat($("#Expiry_Date13").val());
		}else{
			var atot = 0;
		}
		var rmatch_t = atot / 100 * 2;
		$("#card_amount13").val(rmatch_t);				
		
		var total = parseFloat($("#booking_total_amount_c").val());
		var grnd_total_amt = rmatch_t + total;
		
		$("#booking_total_amount").val(grnd_total_amt);
		$("#crd_add_sudm").html('(CP: 4%)');
		$('#total_amount_large').html(formatCurrency(grnd_total_amt)); 
	}else{
		var atot = parseFloat($("#booking_total_amount_c").val());
		$("#booking_total_amount").val(atot);
		$("#crd_add_sudm").html('');
		$('#total_amount_large').html(formatCurrency(atot)); 
	}
}

function re_book_this_member_with_money(id){
	var member_id = id;
	if(member_id != ''){
		if(confirm('Are you sure? Want to Re-Book this member!')){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_submit/re_book_member_id_open_in_add_book_with_money.php'); ?>",  
				method:"POST",  
				data:{member_id:member_id},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					window.open(data,'_self');
				}
			}); 
		}
	}
}


function check_print_modal(id){
	var check_id = id;
	if(check_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/check_print_model.php');?>",  
			method:"POST",  
			data:{check_id:check_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#check_print_result').html(data); 
				$("#check_print_model").modal('show');   
			}  
		});  
	}	
}
$('document').ready(function(){
	$("#sicuriey_deposit_submit").on("submit",function(){
		event.preventDefault();
		var form = $('#sicuriey_deposit_submit')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/security_deposit_submit_drom_account.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#form_submit").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				// $("#form_submit").prop("disabled", false);
				var value = data.split('_____');
				$("#member_prifile_model").modal('hide');
				$("#data_send_success_message").html(value[0]);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
				if(value[2] != '' && value[2] > 0){
					return check_print_modal(value[2]);
				}
				
			}
		});
		return false;
	})
})

var branch_id = "<?php echo base64_encode($_SESSION['super_admin']['branch']); ?>";
function view_member_profile(id){
	var check_sms_verify = '<?php if(!empty($refund_sms_check)){ echo $refund_sms_check; } ?>';
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/return_deposit_money_form.php');?>",  
			method:"POST",  
			data:{
				profile_id:profile_id,
				check_sms_verify:check_sms_verify
			},
			beforeSend:function(){				
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show');   
			}  
		});  
	}
}
$(document).ready(function() {
    var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
	var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [0, 'desc'],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
		initComplete: function(){
            var api = this.api();
            api.columns().every(function(){
                var that = this;
                $('input', this.footer()).on('keyup change', function(){
                    if (that.search() !== this.value){
                        that.search(this.value).draw();
                    }
                });
            });
        },
		columnDefs: [
			{ "width": "2%", "targets": 0 },
			{ "width": "15%", "targets": [6,7]},
		],
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/crm_checkout_old_member_list_datatable.php"+table_info,
		<?php if(check_permission('role_1603980015_79')){ ?>
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
		<?php } ?>
    });
	table.buttons().container().appendTo($('#export_buttons'));
	$('#booking_data_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" title="Search By ' + title + '" placeholder="Search ' + title + '" />');
    });
})


function payment_function_on_change(){
	if($("#payment_method1").val() == 'Mobile Banking'){
		$("#mobile_banking1").css({"display":"flex"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',true);
		$('input[id="mobile_banking_number1"]').prop('required',true);
		$('input[id="transaction_id1"]').prop('required',true);
		$('input[id="mobile_amount1"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---		
		
	}else if($("#payment_method1").val() == 'Check'){
		$("#mobile_banking1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#check_number1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',true);
		$('input[id="check_number1"]').prop('required',true);
		$('input[id="withdraw_date1"]').prop('required',true);
		$('input[id="check_amount1"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---		
		
	}else if($("#payment_method1").val() == 'Credit / Debit Card'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1[]"]').prop('required',true);
		$('input[id="Expiry_Date1"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---	
		
	}else if($("#payment_method1").val() == 'Cash'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',true);
		//-----cash---
		
	}else{
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent1"]').prop('required',false);
		$('input[id="mobile_banking_number1"]').prop('required',false);
		$('input[id="transaction_id1"]').prop('required',false);
		$('input[id="mobile_amount1"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name1"]').prop('required',false);
		$('input[id="check_number1"]').prop('required',false);
		$('input[id="withdraw_date1"]').prop('required',false);
		$('input[id="check_amount1"]').prop('required',false);
	 //-----check---
		
		//-----card---
		$('input[id="credit_card_number1"]').prop('required',false);
		$('input[id="Expiry_Date1"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount1"]').prop('required',false);
		//-----cash---
		
	}
	
	if($("#payment_method12").val() == 'Mobile Banking'){
		$("#mobile_banking12").css({"display":"flex"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',true);
		$('input[id="mobile_banking_number12"]').prop('required',true);
		$('input[id="transaction_id12"]').prop('required',true);
		$('input[id="mobile_amount12"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method12").val() == 'Check'){
		$("#mobile_banking12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#check_number12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
		
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',true);
		$('input[id="check_number12"]').prop('required',true);
		$('input[id="withdraw_date12"]').prop('required',true);
		$('input[id="check_amount12"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method12").val() == 'Credit / Debit Card'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',true);
		$('input[id="Expiry_Date12"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
		
	}else if($("#payment_method12").val() == 'Cash'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',true);
		//-----cash---
		
	}else{
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent12"]').prop('required',false);
		$('input[id="mobile_banking_number12"]').prop('required',false);
		$('input[id="transaction_id12"]').prop('required',false);
		$('input[id="mobile_amount12"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name12"]').prop('required',false);
		$('input[id="check_number12"]').prop('required',false);
		$('input[id="withdraw_date12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		$('input[id="check_amount12"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number12"]').prop('required',false);
		$('input[id="Expiry_Date12"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount12"]').prop('required',false);
		//-----cash---
		
	}
	
	if($("#payment_method13").val() == 'Mobile Banking'){
		$("#mobile_banking13").css({"display":"flex"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',true);
		$('input[id="mobile_banking_number13"]').prop('required',true);
		$('input[id="transaction_id13"]').prop('required',true);
		$('input[id="mobile_amount13"]').prop('required',true);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method13").val() == 'Check'){
		$("#mobile_banking13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#check_number13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',true);
		$('input[id="check_number13"]').prop('required',true);
		$('input[id="withdraw_date13"]').prop('required',true);
		$('input[id="check_amount13"]').prop('required',true);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method13").val() == 'Credit / Debit Card'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',true);
		$('input[id="Expiry_Date13"]').prop('required',true);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
		
	}else if($("#payment_method13").val() == 'Cash'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"flex"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',true);
		//-----cash---
		
	}else{
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
		//-----mobile banking---
		$('select[id="agent13"]').prop('required',false);
		$('input[id="mobile_banking_number13"]').prop('required',false);
		$('input[id="transaction_id13"]').prop('required',false);
		$('input[id="mobile_amount13"]').prop('required',false);
		//-----mobile banking---
		
		//-----check---
		$('select[id="bank_name13"]').prop('required',false);
		$('input[id="check_number13"]').prop('required',false);
		$('input[id="withdraw_date13"]').prop('required',false);
		$('input[id="check_amount13"]').prop('required',false);
		//-----check---
		
		//-----card---
		$('input[id="credit_card_number13"]').prop('required',false);
		$('input[id="Expiry_Date13"]').prop('required',false);
		//-----card---
		
		//-----cash---
		$('input[id="cash_amount13"]').prop('required',false);
		//-----cash---
	}
}

//-------------------payment-----------
	
var counter_payment = 2;
$("#addButton_payment").click(function () {	
	if( counter_payment == 4 ){
		alert("Sorry! Maximum number of field reached");
		return false;			
	}
	var newTextBoxDiv = $(document.createElement('div')).attr({
		id:'UnitBoxDiv_payment1' + counter_payment ,
		class: 'row',
		style: 'width:100%margin-top: 10px;'
	});
	
	var dataq = '<div class="col-sm-3">';
		dataq += '<div class="form-group">';
		dataq += '<select onchange="return payment_function_on_change()" id="payment_method1'+counter_payment+'" name="payment_method[]" class="form-control">';
		dataq += '<option value="">select payment method</option>';
		dataq += '<option value="Cash">Cash</option>';
		dataq += '<option value="Mobile Banking">Mobile Banking</option>';
		dataq += '<option value="Credit / Debit Card">Credit / Debit Card</option>';
		dataq += '<option value="Check">Check</option>';
		dataq += '</select>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="col-sm-9">	';							
		dataq += '<div class="row" id="mobile_banking1'+counter_payment+'" style="display:none;">';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<select id="agent1'+counter_payment+'" name="agent[]" class="form-control">';
		dataq += '<option value="">select agent</option>';
		dataq += '<option value="Bikash">bKash</option>';
		dataq += '<option value="Rocket">Rocket</option>';
		dataq += '<option value="Nogod">Nogod</option>';
		dataq += '</select>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="mobile_banking_number1'+counter_payment+'" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';			
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="transaction_id1'+counter_payment+'" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="mobile_amount1'+counter_payment+'" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="row" id="check_number1'+counter_payment+'" style="display:none;">';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="bank_name1'+counter_payment+'" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';			
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="check_number1'+counter_payment+'" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="date" id="withdraw_date1'+counter_payment+'" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="check_amount1'+counter_payment+'" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="row" id="credit_card1'+counter_payment+'" style="display:none;">';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="credit_card_number1'+counter_payment+'" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<input type="hidden" name="card_secret[]" value="0"/>';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="month" id="Expiry_Date1'+counter_payment+'" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" id="card_amount1'+counter_payment+'" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="row" id="cash1'+counter_payment+'" style="display:none;">';
		dataq += '<div class="col-sm-9">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<textarea id="cash_other_information_remarks1'+counter_payment+'" name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>';											
		dataq += '</div>';
		dataq += '</div>';
		dataq += '<div class="col-sm-3">';
		dataq += '<div class="form-group" style="width:100%;">';
		dataq += '<input type="text" type="text" id="cash_amount1'+counter_payment+'" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '</div>';
		dataq += '</div>';

	newTextBoxDiv.after().html(dataq);
	newTextBoxDiv.appendTo("#UnitBoxesGroup_payment");
	counter_payment++;
});
$("#removeButton_payment").click(function () {
	if( counter_payment == 2 ){
		alert("Sorry! The System Can Not Remove This field");
		return false;
	}
	counter_payment--;
	$("#UnitBoxDiv_payment1" + counter_payment).remove();
});
	
//-------------------------------------
</script>