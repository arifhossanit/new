<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Request For Cancel Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Request For Cancel</li>
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
											<h3 class="card-title"><i class="far fa-bed"></i>Request For Cancel Report</h3>									
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
												<div class="col-sm-4"></div>
												<div class="col-sm-4">
													<div style="border: solid 1px #bfbebe;border-radius:5px;padding:5px;">
														<label>Short By Date(mm/dd/yyyy)</label><button onclick="return booking_reset()" type="button" class="btn btn-xs btn-success" style="float:right;"><i class="fas fa-retweet"></i> Reset</button>
														<div class="row justify-content-center">
															<div class="col-sm-8">
																<input onchange="booking_report_table()" id="date_range" type="text" value="<?php if(!empty($date_range)){ echo $date_range; } ?>" class="form-control float-right date_range">
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
												<th>id</th>
												<th>Image</th>												
												<th>Card_No</th>
												<th>Branch</th>
												<th>Name</th>												
												<th>Phone_Number</th>
												<th>Email</th>
												<th>Bed</th>
												<th>Package_Category</th>
												<th>Membership</th>
												<th>Cancel_Date</th>
												<th>Req_Date</th>
												<th>Note</th>
												<th>Canceled_By</th>
												<th>Option</th>
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
						<h4 class="modal-title">Member information</h4>
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
				$('#member_prifile_model_details').modal('show');   
			}  
		});  
	}
}

$("#short_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#short_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
function booking_reset(){
	$("#short_from").val('');
	$("#short_to").val('');
	return booking_report_table();
}
$('document').ready(function(){	
	//return booking_report_table();
})
function booking_report_table(){
	var report_info = '&date_range='+$("#date_range").val()+'&booking_to='+$("#short_to").val()+'';
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '<?php echo "?branch_id='+branch_sele_id+'&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/request_for_cancel_report_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){	
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var report_info = '&booking_from='+$("#short_from").val()+'&booking_to='+$("#short_to").val()+'';
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
		"scrollX": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/request_for_cancel_report_datatable.php"+condition,
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