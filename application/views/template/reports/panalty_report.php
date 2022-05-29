<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Panalty Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Panalty Report</li>
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
									<h3 class="card-title"><i class="far fa-bed"></i> Panalty Report</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<div class="row">								
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-4">
													<div style="border: solid 1px #bfbebe;border-radius:5px;padding:5px;">
														<label>Short By Date(mm/dd/yyyy)</label><button onclick="return booking_reset()" type="button" class="btn btn-xs btn-success" style="float:right;"><i class="fas fa-retweet"></i> Reset</button>
														<div class="row">
															<div class="col-sm-1">
																<label>From</label>
															</div>
															<div class="col-sm-5">
																<div class="form-group">
																	<input type="date" id="short_from" class="form-control"/>
																</div>
															</div>
															<div class="col-sm-1">
																<label>To</label>
															</div>
															<div class="col-sm-5">
																<div class="form-group">
																	<input type="date" id="short_to" class="form-control"/>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<div class="col-sm-2">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Package</label>
																<select id="package_category" onchange="return get_packages()" name="package_category" class="form-control">
																	<option value="">All</option>
																	<?php
																	if(!empty($package_category)){
																		foreach($package_category as $row){
																			echo '<option value="'.$row->id.'">'.$row->package_category_name.'</option>';
																		}
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Membership</label>
																<select id="package" class="form-control" onchange="return booking_report_table()">
																	<option value="">All</option>
																</select>
															</div>
														</div>
													</div>
													
												</div>
												
												<div class="col-sm-2">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Vehicle / Parking</label>
																<select id="parking" class="form-control" onchange="return booking_report_table()">
																	<option value="">All</option>
																	<option value="1">YES</option>
																	<option value="0">NO</option>
																</select>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Paid & Unpaid</label>
																<select id="paid_un_paid" class="form-control" onchange="return booking_report_table()">
																	<option value="">All</option>
																	<option value="Paid">Paid</option>
																	<option value="unpaid">Unpaid</option>
																</select>
															</div>
														</div>
													</div>
													
												</div>

											</div>
											
											<div class="row">										
												
												
											</div>
											
										</div>
									</div>
								
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Id</th>
												<th>Card_NO</th>
												<th>Name</th>												
												<th>Phone_NO</th>
												<th>Bed</th>
												<th>P:Category</th>
												<th>Membership</th>
												<th>R:Days</th>
												<th>P:Method</th>
												<th>Rent</th>
												<th>Parking</th>
												<th>Electricity</th>
												<th>Tea_coffee</th>
												<th>Penalty</th>
												<th>T:Amount</th>
												<th>Rent_status</th>
												<th>Collect_By</th>
												<th>OPT</th>
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



<script>


//-----------------rental work java script-------------------------

function get_packages(){
	var package_category = $("#package_category").val();
	if(package_category != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_package_options.php');?>",  
			method:"POST",  
			data:{view_id:package_category},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){
				$('#data-loading').html('');	
				$('#package').html(data); 
				return booking_report_table();
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
				$('#members_result_details').html(data); 
				$('#total_bed_information').html(''); 
				$('#bed_at_a_glance_model').modal('hide');   
				$('#member_prifile_model_details').modal('show');   
			}  
		});  
	}
}

function view_profile_from_booking(id){
	var book_id = id;
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/booking_details_information.php');?>",  
			method:"POST",  
			data:{book_id:book_id},
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
$("#booking_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#booking_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#checkin_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#checkin_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#checkout_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#checkout_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})

function booking_reset(){
	$("#booking_from").val('');
	$("#booking_to").val('');
	return booking_report_table();
}

function checkin_reset(){
	$("#checkin_from").val('');
	$("#checkin_to").val('');
	return booking_report_table();
}

function checkout_reset(){
	$("#checkout_from").val('');
	$("#checkout_to").val('');
	return booking_report_table();
}



$('document').ready(function(){	
	//return booking_report_table();
})
function booking_report_table(){
	var other = 'package_category='+$("#package_category").val()+'&package='+$("#package").val()+'&parking='+$("#parking").val()+'&paid_un_paid='+$("#paid_un_paid").val()+'';
	var report_info = '&'+other;
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/rental_report_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){
	var other = 'package_category='+$("#package_category").val()+'&package='+$("#package").val()+'&parking='+$("#parking").val()+'&paid_un_paid='+$("#paid_un_paid").val()+'';
	var report_info = '&'+other;
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/rental_report_datatable.php"+condition,
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>