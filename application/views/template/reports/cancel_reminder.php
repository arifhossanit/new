
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cancel Reminder</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Cancel Reminder</li>
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
				</div>
				<div class="col-sm-12">					
					<div class="card card-primary card-tabs">
						<div class="card-header p-0 pt-1">
							<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
								<li class="pt-2 px-3"><h3 class="card-title">Cancel Reminder</h3></li>
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Monthly Members</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Try Us (30) Days</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Try US (Non 30) Days</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-two-tabContent">
								<div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
									<div class="card card-success">
										<div class="card-header">
											Monthly Members
											<div id="export_buttons" style="float: right;"></div>
										</div>
										<div class="card-body">
											<style> #booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
											<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
												<thead>
													<tr>
														<th>Id</th>
														<th>Branch</th>
														<th>Name</th>
														<th>Card_number</th>
														<th>Package_Category</th>
														<th>Package</th>
														<th>CheckIn</th>
														<th>CheckOut</th>
														<th>Message_Time</th>
														<th>Date</th>
														<th>OPT</th>
													</tr>
												</thead>
												<tbody>	
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
									<div class="card card-info">
										<div class="card-header">
											Try Us (30) Days
											<div id="export_buttons_dropbox" style="float: right;"></div>
										</div>
										<div class="card-body">
											<style> #30days_booking_data_table td{text-align:center;vertical-align: middle;}#30days_booking_data_table th{text-align:center;vertical-align: middle;}#30days_booking_data_table td:last-child{text-align:left;}</style>
											<table id="30days_booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
												<thead>
													<tr>
														<th>Id</th>
														<th>Branch</th>
														<th>Name</th>
														<th>Card_number</th>														
														<th>Package_Category</th>
														<th>Package</th>
														<th>CheckIn</th>
														<th>CheckOut</th>
														<th>Message_Time</th>
														<th>Date</th>
														<th>OPT</th>
													</tr>
												</thead>
												<tbody>	
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
									<div class="card card-info">
										<div class="card-header">
											Try US (Non 30) Days
											<div id="export_buttons_dropbox_collection" style="float: right;"></div>
										</div>
										<div class="card-body">
											<style> #non_30days_booking_data_table td{text-align:center;vertical-align: middle;}#non_30days_booking_data_table th{text-align:center;vertical-align: middle;}#non_30days_booking_data_table td:last-child{text-align:left;}</style>
											<table id="non_30days_booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
												<thead>
													<tr>
														<th>Id</th>
														<th>Branch</th>
														<th>Name</th>												
														<th>Card_number</th>												
														<th>Package_Category</th>
														<th>Package</th>
														<th>CheckIn</th>
														<th>CheckOut</th>
														<th>Message_Time</th>
														<th>Date</th>
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
	</div>
</div>
<!----vaiw model-->
	<div class="modal fade" id="sms_model_details">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">View SMS</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="sms_result_details">					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<script>
function view_reminder_message(id){
	var sms_id = id;				
	if(sms_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/cancel_reminder_view_sms_information.php');?>",  
			method:"POST",  
			data:{sms_id:sms_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');				
				$('#sms_result_details').html(data);  
				$('#sms_model_details').modal('show');  
			}
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}	
}
function filter_data_table(){
	var branch_id = $("#branch_id").val();
	var date_range = $("#date_range").val();	
    var condition = '?branch_id='+branch_id+'&date_range='+date_range+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/report/cancel_reminder_membership_datatable.php"+condition;
	var ajax_data5 = "<?=base_url(); ?>assets/ajax/data_table/report/cancel_reminder_try_us_30days_datatable.php"+condition;
	var ajax_data6 = "<?=base_url(); ?>assets/ajax/data_table/report/cancel_reminder_try_us_non_30days_datatable.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
	$('#30days_booking_data_table').DataTable().ajax.url(ajax_data5).load();
	$('#non_30days_booking_data_table').DataTable().ajax.url(ajax_data6).load();
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
		"scrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/cancel_reminder_membership_datatable.php",
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
	var table_booking = $('#30days_booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1], 
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"] 
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"scrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/cancel_reminder_try_us_30days_datatable.php",
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
	table_booking.buttons().container().appendTo($('#export_buttons_dropbox'));
	var table_booking = $('#non_30days_booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1], 
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"] 
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"scrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/cancel_reminder_try_us_non_30days_datatable.php",
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
	table_booking.buttons().container().appendTo($('#export_buttons_dropbox_collection'));
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>