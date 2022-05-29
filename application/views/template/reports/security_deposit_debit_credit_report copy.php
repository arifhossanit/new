<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Security Deposit Collection Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Security Deposit Collection Report</li>
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
									<div class="row">
										<div class="col-sm-3">
											<h3 class="card-title"><i class="far fa-bed"></i>Income Report</h3>									
										</div>
										<div class="col-sm-2">
											<?php //if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
											<div class="form-group" style="margin:0px;">
												<select onchange="return booking_report_table()" class="form-control select2" id="branch_id_hrad">
													<?php if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
													<option value="1">All Branches</option>
													<?php 
													}
													if(!empty($banches)){
														foreach($banches as $row){
															echo '<option value="'.rahat_encode($row->branch_id).'">'.$row->branch_name.'</option>';
														}
													}													
													?>
												</select>
											</div>
											<?php //}else{ ?>
											
											<input type="hidden" id="branch_id_hradd" value=""/>
											<?php //} ?>
										</div>
										<div class="col-sm-7">
											<div id="export_buttons" style="float: right;"></div>
										</div>
									</div>	
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-3">
                                                    <label>Select Date(mm/dd/yyyy)</label>
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <label>From</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
																<input onchange="return booking_report_table()" id="date_range" type="text" class="form-control float-right date_range">
                                                                <!-- <input type="date" id="date_from" class="form-control" onchange="return booking_report_table()"/> -->
                                                            </div>
                                                        </div>
                                                    </div>
												</div>
												
												<div class="col-sm-2" style="display: none;">
													<div class="form-group">
														<label>Select Payment Pattern</label>
														<select id="payment_pattern" class="form-control" onchange="return booking_report_table()">
															<option value="on_hand">On Hand</option>
															<option value="returned">Returned</option>
														</select>
													</div>
												</div>
											</div>
											
										</div>
									</div>
									<div class="row justify-content-center" style="font-size: 20px;">
										<div class="col-md-2"><p class="text-secondary mb-0">Total Security Deposit: </p><p class="mb-0" id="debit_amount"></p></div>
										<div class="col-md-2"><p class="text-secondary mb-0">Total Returned Deposit: </p><p class="mb-0" id="credit_amount"></p></div>
										<div class="col-md-2"><p class="text-secondary mb-0">Balance: </p><p class="mb-0" id="balance"></p></div>
										<div class="col-md-2"><p class="text-secondary mb-0">Total Cancel Deposit: </p><p class="mb-0" id="total_cancel_deposit"></p></div>
									</div>
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Id</th>
												<th>Branch</th>
												<th>Name</th>
												<th>Package</th>
												<th>Card No</th>
												<th>Security Deposit</th>
												<th>Deposit Date</th>
												<th>Deposit Return</th>
												<th>Return Date</th>
												<th>Auto Cancel</th>
												<th>Package Id</th>
												<th>Cancel Deposite</th>
												<th>Uploader Info</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
										<tfoot>
											<tr>
												<th colspan="5" style="text-align:right">Total:</th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
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
    <!----vaiw member profile model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	

						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="button" id="select_bed" class="btn btn-warning"><i class="fas fa-save"></i> Select</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_profile_information.php');?>",  
			method:"POST",
			data:{profile_id:profile_id},
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
//-----------------rental work java script-------------------------
function booking_report_table(){
	var date_range = $("#date_range").val();	
	var filter = '?branch_id='+$("#branch_id_hrad").val()+'&date_range='+date_range+'&payment_pattern='+$("#payment_pattern").val();
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/security_deposit_report_debit_credit_datatable.php'+filter;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){
	var date_range = $("#date_range").val();
	if(date_range === ''){
		date_range = ' - '
	}
	var filter = '?branch_id='+$("#branch_id_hrad").val()+'&date_range='+date_range+'&payment_pattern='+$("#payment_pattern").val();
	// var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/checkin_report_datatable.php'+filter;
	var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": false,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/security_deposit_report_debit_credit_datatable.php"+filter,
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
        ],
		createdRow: function (row, data, index) {
                            //
                            // if the second column cell is blank apply special formatting
                            //
                            if (data[9] == "Yes") {
                                console.dir(row);
                                $(row).addClass("auto-cancel");
                            }
                        },
		"columnDefs": [
			{
				"targets": [ 10 ],
				"visible": false,
				"searchable": false
			},
		],
		"footerCallback": function(row, data, start, end, display) {
			var api = this.api();
			let total_deposit = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
					var y = parseFloat(b) || 0;
					return x + y;
                }, 0 );
			let total_return = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
					var y = parseFloat(b) || 0;
					return x + y;
                }, 0 );
			let total_cancel_deposit = api
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
					var y = parseFloat(b) || 0;
					return x + y;
                }, 0 );
			// $('#sum').html(total);
			var formatter = new Intl.NumberFormat('en-US', {
				style: 'currency',
				currency: 'BDT',

				// These options are needed to round to whole numbers if that's what you want.
				minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
				//maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
			});
			$( api.column( 5 ).footer() ).html(
                formatter.format(total_deposit)
            );
			$( api.column( 7 ).footer() ).html(
                formatter.format(total_return)
            );
			$( api.column( 11 ).footer() ).html(
                formatter.format(total_cancel_deposit)
            );
			$('#debit_amount').html(formatter.format(total_deposit));
			$('#credit_amount').html(formatter.format(total_return));
			$('#balance').html(formatter.format(total_deposit - (total_return + total_cancel_deposit)));
			$('#total_cancel_deposit').html(formatter.format(total_cancel_deposit));
		}
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>