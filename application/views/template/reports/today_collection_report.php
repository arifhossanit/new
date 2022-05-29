<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Transaction Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Transaction Report</li>
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
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group" style="margin:0px;">
										<select onchange="return filter_data_table();" class="form-control select2" id="branch_id">
											<?php if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
											<option value="1">All Branches</option>
											<?php 
											}
											if(!empty($banches)){
												foreach($banches as $row){
													echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
												}
											}													
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
											<input onchange="return filter_data_table()" id="date_range" type="text" class="form-control float-right date_range">
										</div>
									</div>
								</div>
							</div>					
							
							<div class="card card-primary card-tabs">
								<div class="card-header p-0 pt-1">
									<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
										<li class="pt-2 px-3"><h3 class="card-title">Transaction Report</h3></li>
										<li class="nav-item">
											<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home-id" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Credit</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile-id" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Debit</a>
										</li>										  
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-one-tabContent">
										<div class="tab-pane fade active show" id="custom-tabs-one-home-id" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
											<div class="card card-success">
												<div class="card-header">
													Credit Transaction Report
													<div id="export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style> #booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
													<table id="booking_data_table" class="table table-sm table-bordered table-striped" style="width:100%;">
														<thead style="width:100%;">
															<tr style="width:100%;">
																<th>Id</th>
																<th>Transaction ID</th>
																<th>Branch</th>												
																<th>CareOf</th>
																<th>Amount</th>
																<th>Date</th>
																<th>Transaction Type</th>
																<th>Account Categoty</th>
																<th>Transaction By</th>
																<th>Entry Date</th>
																<th>OPT</th>
																<th>Member Detail</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
														<tfoot></tfoot>
													</table>
												</div>
											</div>													
										</div>
										<div class="tab-pane fade" id="custom-tabs-one-profile-id" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
											<div class="card card-danger">
												<div class="card-header">
													Debit Transaction Report
													<div id="debit_export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<table id="debit_booking_data_table" class="table table-sm table-bordered table-striped" style="width:100%;">
														<thead style="width:100%;">
															<tr style="width:100%;">
																<th>Id</th>
																<th>Transaction ID</th>
																<th>Branch</th>												
																<th>CareOf</th>
																<th>Amount</th>
																<th>Date</th>
																<th>Transaction Type</th>
																<th>Account Categoty</th>
																<th>Transaction By</th>
																<th>Entry Date</th>
																<th>OPT</th>
																<th>Member Detail</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
														<tfoot></tfoot>
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
			</div>
		</div>
	</div>
</div>




<!----vaiw model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Booking information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->





<!----vaiw model-->
	<div class="modal fade" id="member_prifile_model_details">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result_details" style="max-height:780px;overflow-y:scroll;">	

						
					</div>
					<div class="modal-footer justify-content-between">

					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->



<!----vaiw model-->
	<div class="modal fade" id="transaction_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Transaction information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="transaction_model_result"> </div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->

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
<!----End vaiw member profile model-->

<script>
//-----------------rental work java script-------------------------
function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('/assets/ajax/member_profile_information.php');?>",  
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

function view_transaction_report(id){
	var transaction_id = id;
	if(transaction_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/receipt/transaction_details_information.php');?>",  
			method:"POST",  
			data:{transaction_id:transaction_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#transaction_model_result').html(data); 
				$('#transaction_model').modal('show');   
			}  
		});  
	}
}


function view_rental_recipt(id){
	var rent_id = id;
	if(rent_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/rental_details_information.php');?>",  
			method:"POST",  
			data:{rent_id:rent_id},
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

function filter_data_table(){
	var branch_id = $("#branch_id").val();
	var date_range = $("#date_range").val();	
    var condition = '?branch_id='+branch_id+'&date_range='+date_range+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/report/cridet_transaction_report_datatable.php"+condition;
	var ajax_data5 = "<?=base_url(); ?>assets/ajax/data_table/report/debit_transaction_report_datatable.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
	$('#debit_booking_data_table').DataTable().ajax.url(ajax_data5).load();
}
$('document').ready(function(){
	var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1], 
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"] 
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/cridet_transaction_report_datatable.php",
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
	table_booking.buttons().container().appendTo($('#export_buttons'));
	//----------------------------
	var table_booking = $('#debit_booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1], 
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"] 
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/debit_transaction_report_datatable.php",
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
	table_booking.buttons().container().appendTo($('#debit_export_buttons'));
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
