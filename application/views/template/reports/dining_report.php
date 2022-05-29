<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dining Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Dining Report</li>
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
									<h3 class="card-title"><i class="far fa-bed"></i> Dining Report</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<div class="row" style="margin-bottom:15px;">								
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-6">
													<div style="border: solid 1px #bfbebe;border-radius:5px;padding:5px;">
														<label>Short By Date(mm/dd/yyyy)</label><button onclick="return booking_reset()" type="button" class="btn btn-xs btn-success" style="float:right;"><i class="fas fa-retweet"></i> Reset</button>
														<div class="row">
															<div class="col-sm-1">
																<label>From</label>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<input type="date" id="short_from" class="form-control"/>
																</div>
															</div>
															<div class="col-sm-1" style="text-align:center;">
																<label>To</label>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																	<input type="date" id="short_to" class="form-control"/>
																</div>
															</div>
															<div class="col-sm-4">
																<select class="form-control select2" name="" id="meal_type_filter" onchange="return booking_report_table();">
																	<option value="0">All</option>
																	<option value="1">Breakfast</option>
																	<option value="2">Lunch</option>
																	<option value="3">Dinner</option>
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
												<th>Branch</th>
												<th>Member</th>												
												<th>card</th>												
												<th>package</th>												
												<th>Membership</th>												
												<th>Day</th>												
												<th>Breakfast</th>												
												<th>Lunch</th>												
												<th>Dinner</th>												
												<th>Request</th>																							
												<th>Given_By</th>
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
			</div>
		</div>
	</div>
</div>



<script>


//-----------------rental work java script-------------------------

$("#short_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#short_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})


function booking_reset(){
	$("#short_from").val('');
	$("#short_to").val('');
	$("#meal_type_filter").html('<option value="0">All</option> <option value="1">Breakfast</option> <option value="2">Lunch</option> <option value="3">Dinner</option>');
	return booking_report_table();
}




$('document').ready(function(){	
	//return booking_report_table();
})
function booking_report_table(){
	var other = 'meal_type_filter='+$("#meal_type_filter").val()+'&booking_from='+$("#short_from").val()+'&booking_to='+$("#short_to").val()+'';
	var report_info = '&'+other;
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/dining_report_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){
	var other = 'meal_type_filter='+$("#meal_type_filter").val()+'&booking_from='+$("#short_from").val()+'&booking_to='+$("#short_to").val()+'';
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/dining_report_datatable.php"+condition,
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