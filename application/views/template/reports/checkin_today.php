
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">CheckIn Today Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">CheckIn Today Report</li>
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
											<h3 class="card-title"><i class="far fa-bed"></i>CheckIn Today Report</h3>									
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
												<div class="col-sm-2">
													<div class="form-group">
														<label>Select Occuparion</label>
														<select id="occupation" class="form-control" onchange="return booking_report_table()">
															<option value="">All</option>
															<option value="Student">Student</option>
															<option value="Job Holder">Job Holder</option>
															<option value="Business Man">Business Man</option>
															<option value="Teacher">Teacher</option>
															<option value="Doctor">Doctor</option>										
															<option value="Driver">Driver</option>
															<option value="Housewife">Housewife</option>
															<option value="Other">Other</option>
														</select>
													</div>
												</div>
												
												<div class="col-sm-2">
													<div class="form-group">
														<label>Select Religion</label>
														<select id="religion" class="form-control" onchange="return booking_report_table()">
															<option value="">All</option>
															<option value="Muslim">Muslim</option>
															<option value="Hindu">Hindu</option>
															<option value="Christian">Christian</option>
															<option value="Buddhist">Buddhist</option>
															<option value="Other">Other</option>
														</select>
													</div>
												</div>
												
												<div class="col-sm-2">
													<div class="form-group">
														<label>How To Find Us</label>
														<select id="h_t_f_u" class="form-control" onchange="return booking_report_table()">
															<option value="">All</option>
															<option value="News Paper">News Paper</option>
															<option value="Google">Google</option>
															<option value="Facebook">Facebook</option>
															<option value="Youtube">Youtube</option>
															<option value="Parents">Parents</option>
															<option value="TVC">TVC</option>
															<option value="Friends">Friends</option>
															<option value="Colleague">Colleague</option>
														</select>
													</div>
												</div>
												
												<div class="col-sm-2">
													<div class="form-group">
														<label>Select Package Category</label>
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
												
												<div class="col-sm-2">
													<div class="form-group">
														<label>Select Package</label>
														<select id="package" class="form-control" onchange="return booking_report_table()">
															<option value="">All</option>
														</select>
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
																<label>Authorization</label>
																<select id="authorization" class="form-control" onchange="return booking_report_table()">
																	<option value="">All</option>
																	<option value="Unauthorized">Unauthorized</option>
																</select>
															</div>
														</div>
													</div>
													
												</div>
											</div>
											
										</div>
									</div>
								
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Id</th>
												<th>Card No</th>
												<th>Name</th>												
												<th>Phone Number</th>
												<th>Bed</th>
												<th>CheckIN</th>
												<th>CheckOut</th>
												<th>P:Category</th>
												<th>Package</th>
												<th>A:Days</th>
												<th>S:Deposit</th>
												<th>B:Date</th>
												<th>Occupation</th>
												<th>Religion</th>
												<th>HTFU</th>
												<th>Parking</th>
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
	var other = 'occupation='+$("#occupation").val()+'&religion='+$("#religion").val()+'&h_t_f_u='+$("#h_t_f_u").val()+'&package_category='+$("#package_category").val()+'&package='+$("#package").val()+'&parking='+$("#parking").val()+'&authorization='+$("#authorization").val()+'';
	var report_info = '&'+other;
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '<?php echo "?branch_id='+branch_sele_id+'&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/booking_report_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var other = 'occupation='+$("#occupation").val()+'&religion='+$("#religion").val()+'&h_t_f_u='+$("#h_t_f_u").val()+'&package_category='+$("#package_category").val()+'&package='+$("#package").val()+'&parking='+$("#parking").val()+'&authorization='+$("#authorization").val()+'';
	var report_info = '&'+other;
	var table_info = '<?php echo "?branch_id='+branch_sele_id+'&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/checkin_today_report_datatable.php"+condition,
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