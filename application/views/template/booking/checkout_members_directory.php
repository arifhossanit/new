<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">CheckOut Member Directory</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">CheckOut Member Directory</li>
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
						<span id="data_send_success_message"></span>
							<div class="card card-success">
								<div class="card-header">
									<div class="row">
										<div class="col-sm-2">
											<div class="form-group" style="margin:0px;">
												<select onchange="return booking_report_table();" class="form-control select2" id="branch_id_hrad">
													<?php
													if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
														echo '<option value="1">All Branches</option>';
													}
													if(!empty($banches)){
														foreach($banches as $row){
															echo '<option value="'.rahat_encode($row->branch_id).'">'.$row->branch_name.'</option>';
														}
													}													
													?>
												</select>
											</div>
										</div>
										<div class="col-sm-10">
											<h3 class="card-title">CheckOut Member Directory</h3>
											<div id="export_buttons" style="float: right;"></div>
										</div>
									</div>									
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label>Select Date</label>
												<div class="input-group">
													<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
													</div>
													<input onchange="return checkout_report_update()" id="date_range" type="text" class="form-control float-right date_range">
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label style="visibility: hidden;">Download All</label>
												<div class="input-group">
													<button class="btn btn-md btn-success download_all">Download All</button>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
											<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
												<thead>
													<tr>
														<th>id</th>
														<!--<th>Image</th>-->
														<th>Branch</th>
														<th>Card No</th>
														<th>Name</th>												
														<th>Phone Number</th>
														<th>Email</th>
														<th>Bed</th>
														<th>CheckIN</th>
														<th>CheckOut</th>
														<th>P:Category</th>
														<th>Package</th>
														<th>S:Deposit</th>
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
<!----End vaiw member profile model-->

<!----vaiw model-->
	<div class="modal fade" id="member_rental_information">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Rental information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result_rental">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<script>

$(document).on("click", ".download_all", function(){
	var date_range = $("#date_range").val();
	var url = "<?php echo base_url();?>"+"admin/download_all?date_range="+date_range;   
    window.open(url);  
});


var branch_id = "<?php echo base64_encode($_SESSION['super_admin']['branch']); ?>";
function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_profile_information.php');?>",  //form_model/
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
				$('#members_result_rental').html(data); 
				$('#member_rental_information').modal('show');   
			}  
		});  
	}
}
function booking_report_table(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
	var ajax_data = "<?=base_url(); ?>assets/ajax/data_table/checkout_member_directiry_datatable.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();
}

function checkout_report_update(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var condition = '?branch_id='+branch_sele_id;
	var date_range = $("#date_range").val();
	condition = condition.concat('&date_range=' + date_range);	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/checkout_member_directiry_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();
}

$(document).ready(function() {
	
    if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
	var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
		
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/checkout_member_directiry_datatable.php"+condition,
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
	table.buttons().container().appendTo($('#export_buttons'));
})
</script>