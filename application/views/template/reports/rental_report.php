<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Rental Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Rental Report</li>
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
											<h3 class="card-title"><i class="far fa-bed"></i> Booking Report</h3>									
										</div>
										<div class="col-sm-2">
											<?php //if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
											<div class="form-group" style="margin:0px;">
												<select class="form-control" id="branch_id_hrad">
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
										<div class="col-sm-12" style="margin-bottom:15px;">
											<center>
												<?php /* ?>
												<div class="btn-group">
													<button id="today_cash_cossection_report" type="button" class="btn btn-default btn-sm">Today Cash Collection Report</button>
													<button id="today_tea_coffee_report" type="button" class="btn btn-default btn-sm">Today Tea & Coffee Report</button>
													<button id="today_refreshment_report" type="button" class="btn btn-default btn-sm">Today Refreshment Report</button>
													<button id="today_paid_unpaid_report" type="button" class="btn btn-default btn-sm">Paid & Un-pain Report</button>
													<button id="today_installment_report" type="button" class="btn btn-default btn-sm">Today Installment Report</button>
												</div><?php */ ?>
											<center>
										</div>									
										<div class="col-sm-12" style="margin-bottom:15px;">
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
																	<input type="date" id="booking_from" class="form-control"/>
																</div>
															</div>
															<div class="col-sm-1">
																<label>To</label>
															</div>
															<div class="col-sm-5">
																<div class="form-group">
																	<input type="date" id="booking_to" class="form-control"/>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>										
										</div>
									</div>
								
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display nowrap table table-sm table-bordered table table-striped" style="width:100%">
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
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Rental information</h4>
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
			url:"<?=base_url('assets/ajax/rental_details_information.php');?>",  
			method:"POST",  
			data:{rent_id:book_id},
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
$("#branch_id_hrad").on("change",function(){
	return booking_report_table();
})
$("#booking_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#booking_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
function booking_reset(){
	$("#booking_from").val('');
	$("#booking_to").val('');
	return booking_report_table();
}
function booking_report_table(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
    var condition = '?branch_id='+branch_sele_id+'&booking_to='+$("#booking_to").val()+'&booking_from='+$("#booking_from").val()+'';	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/rental_report_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
    var condition = '?branch_id='+branch_sele_id+'&booking_to='+$("#booking_to").val()+'&booking_from='+$("#booking_from").val()+'';
	var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1],
			[10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
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
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>