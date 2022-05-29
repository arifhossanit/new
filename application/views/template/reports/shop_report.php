<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Shop Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Shop Report</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">	
					<div class="card card-primary card-outline card-outline-tabs">
						<div class="card-header p-0 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Shop Report</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Welcome Tea Report</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Facebook Winner Report</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-investor" role="tab" aria-controls="custom-tabs-four-investor" aria-selected="false">Investor Facilities</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-four-tabContent">
								<div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
									<div class="row">
										<div class="col-sm-12">
											<div class="card card-success">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i> Shop Report</h3>
													<div id="export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<div class="row" style="margin-bottom:15px;">								
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
																<div class="col-sm-4"> </div>
																<div class="col-sm-2"></div>
																<div class="col-sm-2">
																	<div class="form-group">
																		<input type="date" id="report_date" value="<?php echo date('Y-m-d'); ?>" class="form-control"/>
																	</div>
																	<button onclick="return print_today_report()" class="btn btn-success" style="float:right;">Print Today Report</button>
																</div>
															</div>															
														</div>
													</div>
												
													<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
													<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>Id</th>
																<th>Branch</th>
																<th>Buyer_name</th>																								
																<th>QTY</th>												
																<th>Amount</th>												
																<th>Status</th>												
																<th>Sell_By</th>
																<th>Date</th>
																<th>OTP</th>
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
								<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
									<div class="row">
										<div class="col-sm-12">
											<div class="card card-dark">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i> Welcome Tea</h3>
													<div id="export_buttons_renew" style="float: right;"></div>
												</div>
												<div class="card-body">
													<div class="row" style="margin-bottom:15px;">								
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-2">
																	<div class="form-group" style="margin:0px;">
																		<select onchange="return filter_data_table_welcome_tea();" class="form-control select2" id="branch_id_welcome_tea">
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
																			<input onchange="return filter_data_table_welcome_tea()" id="date_range_welcome_tea" type="text" class="form-control float-right date_range">
																		</div>
																	</div>
																</div>
															</div>															
														</div>
													</div>
												
													<style>#booking_data_table_welcome_tea td{text-align:center;vertical-align: middle;}#booking_data_table_welcome_tea th{text-align:center;vertical-align: middle;}#booking_data_table_welcome_tea td:last-child{text-align:left;}</style>
													<table id="booking_data_table_welcome_tea" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>Id</th>
																<th>Branch</th>
																<th>Buyer_name</th>																								
																<th>Phone_number</th>																							
																<th>Item_name</th>																							
																<th>Sell_By</th>
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
								<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
									<div class="row">
										<div class="col-sm-12">
											<div class="card card-info">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i> Facebook Winner</h3>
													<div id="export_buttons_due" style="float: right;"></div>
												</div>
												<div class="card-body">
													<div class="row" style="margin-bottom:15px;">								
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-2">
																	<div class="form-group" style="margin:0px;">
																		<select onchange="return filter_data_table_facebook_winner();" class="form-control select2" id="branch_id_facebook_winner">
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
																			<input onchange="return filter_data_table_facebook_winner()" id="date_range_facebook_winner" type="text" class="form-control float-right date_range">
																		</div>
																	</div>
																</div>
															</div>															
														</div>
													</div>
												
													<style>#booking_data_table_facebook_winner td{text-align:center;vertical-align: middle;}#booking_data_table_facebook_winner th{text-align:center;vertical-align: middle;}#booking_data_table_facebook_winner td:last-child{text-align:left;}</style>
													<table id="booking_data_table_facebook_winner" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>Id</th>
																<th>Branch</th>
																<th>Buyer_name</th>																								
																<th>Phone_number</th>
																<th>Item_name</th>																	
																<th>Sell_By</th>
																<th>Post_url</th>
																<th>attachment</th>
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
								<div class="tab-pane fade" id="custom-tabs-four-investor" role="tabpanel" aria-labelledby="custom-tabs-four-investor-tab">
									<div class="row">
										<div class="col-sm-12">
											<div class="card card-dark">
												<div class="card-header">
													<h3 class="card-title">Investor Facilities</h3>
													<div id="export_buttons_renew" style="float: right;"></div>
												</div>
												<div class="card-body">
													<div class="row" style="margin-bottom:15px;">
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-2">
																	<div class="form-group">
																		<div class="input-group">
																			<div class="input-group-prepend">
																			<span class="input-group-text">
																				<i class="far fa-calendar-alt"></i>
																			</span>
																			</div>
																			<input onchange="return filter_investor_table()" id="date_range_investor_table" type="text" class="form-control float-right date_range">
																		</div>
																	</div>
																</div>
															</div>															
														</div>
													</div>

													<!-- Investor Modal -->
													<div class="modal fade" id="investor_modal">
														<div class="modal-dialog modal-lg">
															<div class="modal-content">
																<form action="<?=current_url(); ?>" method="post">
																	<div class="modal-header btn-warning">
																		<h4 class="modal-title">Investor Facilities Details</h4>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body" id="investor_modal_body">	
																																			
																	</div>
																	<div class="modal-footer justify-content-between">
																		<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
																	</div>
																</form>
															</div>
														</div>
													</div>
													<table id="investor_table" class="display table table-sm table-bordered table-hover" style="width:100%">
														<thead>
															<tr>
																<th>Id</th>
																<th>Investor Name</th>
																<th>Card No</th>
																<th>Tea/Coffee</th>																								
																<th>Drinks</th>																							
																<th>Details</th>
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
					  <!-- /.card -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!----vaiw model-->
	<div class="modal fade" id="shop_model_details">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Member Shopping Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="shop_result_details">						
					</div>
					<div class="modal-footer justify-content-between">
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->


<div class="modal fade" id="shop_model_report">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Member Shopping Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="shop_result_reports">						
				</div>
				<div class="modal-footer justify-content-between">
				</div>
			</form>
		</div>
	</div>
</div>

<script>
function filter_data_table_facebook_winner(){
	var branch_id_facebook_winner = $("#branch_id_facebook_winner").val();
	var date_range_facebook_winner = $("#date_range_facebook_winner").val();	
    var condition = '?branch_id='+branch_id_facebook_winner+'&date_range='+date_range_facebook_winner+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/report/shop_facebook_winner_report_datatable.php"+condition;
	$('#booking_data_table_facebook_winner').DataTable().ajax.url(ajax_data4).load();
}
$('document').ready(function(){
	var branch_id_facebook_winner = $("#branch_id_facebook_winner").val();	
    var condition = '?branch_id='+branch_id_facebook_winner+'';
	
	var table_booking = $('#booking_data_table_facebook_winner').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/shop_facebook_winner_report_datatable.php"+condition,
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
	table_booking.buttons().container().appendTo($('#export_buttons_due'));
})
//===============================================================
//===============================================================
//===============================================================
function filter_data_table_welcome_tea(){
	var branch_id_welcome_tea = $("#branch_id_welcome_tea").val();
	var date_range_welcome_tea = $("#date_range_welcome_tea").val();	
    var condition = '?branch_id='+branch_id_welcome_tea+'&date_range='+date_range_welcome_tea+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/report/shop_welcome_tea_report_datatable.php"+condition;
	$('#booking_data_table_welcome_tea').DataTable().ajax.url(ajax_data4).load();
}
$('document').ready(function(){
	var branch_id_welcome_tea = $("#branch_id_welcome_tea").val();	
    var condition = '?branch_id='+branch_id_welcome_tea+'';
	
	var table_booking = $('#booking_data_table_welcome_tea').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/shop_welcome_tea_report_datatable.php"+condition,
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
	table_booking.buttons().container().appendTo($('#export_buttons_renew'));
})
//===============================================================
//===============================================================
//===============================================================
//-----------------shop work java script-------------------------
function print_today_report(){
	var report_id = $("#report_date").val();
	if(report_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/receipt/shop_report_information.php');?>",  
			method:"POST",  
			data:{report_id:report_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#shop_result_reports').html(data); 
				$('#shop_model_report').modal('show'); 
			}  
		});  
	}
}

function view________(id){
	var receipt_id = id;
	if(receipt_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/receipt/shop_details_information.php');?>",  
			method:"POST",  
			data:{receipt_id:receipt_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#shop_result_details').html(data); 
				$('#shop_model_details').modal('show'); 
			}  
		});  
	}
}


$('document').ready(function(){	
	//return booking_report_table();
})



function filter_data_table(){
	var branch_id = $("#branch_id").val();
	var date_range = $("#date_range").val();	
    var condition = '?branch_id='+branch_id+'&date_range='+date_range+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/report/shop_report_datatable.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
}
$('document').ready(function(){
	var branch_id = $("#branch_id").val();	
    var condition = '?branch_id='+branch_id+'';
	
	var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/shop_report_datatable.php"+condition,
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
	table_booking.buttons().container().appendTo($('#export_buttons'));
})

// ---------------Investor Report --------------
function get_investor_details(id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/investor_details_report.php');?>",  
		method:"POST",
		data:{id:id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#investor_modal_body').html(data);
		}  
	});  
}
function filter_investor_table(){
	var date_range = $("#date_range_investor_table").val();	
    var condition = '?date_range='+date_range+'';
	var ajax_data = "<?=base_url(); ?>assets/ajax/data_table/report/investor_table_datatable.php"+condition;
	$('#investor_table').DataTable().ajax.url(ajax_data).load();
}
$('document').ready(function(){
	var date_range = $("#date_range_investor_table").val();	
    var condition = '?date_range='+date_range+'';
	console.log(condition);
	var table_booking = $('#investor_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/investor_table_datatable.php"+condition,
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
	table_booking.buttons().container().appendTo($('#export_buttons_renew'));
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>