<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Member Directory</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Member Directory</li>
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
						<div class="col-sm-2" style="margin-bottom:15px;">
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
						<div class="col-sm-2">
							<div class="form-group">
								<select id="member_info_type" onchange="return booking_report_table();" class="form-control select2">
									<option value="ALL">ALL Member</option>
									<option value="MEMBERSHIP">Membership</option>
									<option value="TRYUS">Tryus</option>
								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<span id="data_send_success_message"></span>
							<div class="card card-primary card-outline card-outline-tabs">
								<div class="card-header p-0 border-bottom-0">
									<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Member Directory</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Manual Cancel</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Auto Cancel</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="true">Force Cancel</a>
										</li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-four-tabContent">
										<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
											<div class="card card-success">
												<div class="card-header">
													<h3 class="card-title">Member Directory</h3>
													<div id="export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
													<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
														<thead>
															<tr>
																<th>id</th>
																<th>Image</th>
																<th>Branch</th>
																<th>Card No</th>
																<th>Name</th>												
																<th>Phone Number</th>
																<th>Member Type</th>
																<th>Bed</th>
																<th>CheckIN</th>
																<th>CheckOut</th>
																<th>P:Category</th>
																<th>Package</th>
																<th>S:Deposit</th>
																<th style="width:170px;">Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
														<tfoot>
															<tr>
																<th>id</th>
																<th>Image</th>
																<th>Branch</th>
																<th>Card No</th>
																<th>Name</th>												
																<th>Phone Number</th>
																<th>Member Type</th>
																<th>Bed</th>
																<th>CheckIN</th>
																<th>CheckOut</th>
																<th>P:Category</th>
																<th>Package</th>
																<th>S:Deposit</th>
																<th style="width:170px;">Option</th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
										
										
										<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
											<div class="card card-danger">
												<div class="card-header">
													<h3 class="card-title">Cancel Member Directory</h3>
													<div id="cancel_export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style>#member_cencel_data_table td{text-align:center;vertical-align: middle;}#member_cencel_data_table th{text-align:center;vertical-align: middle;}</style>
													<table id="member_cencel_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>id</th>
																<th>Image</th>
																<th>Branch</th>
																<th>Card No</th>
																<th>Name</th>												
																<th>Phone Number</th>
																<th>Member Type</th>
																<th>Bed</th>
																<th>CheckIN</th>
																<th>CheckOut</th>
																<th>P:Category</th>
																<th>Package</th>
																<th>S:Deposit</th>
																<th style="width:170px;">Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
														<tfoot>
															<tr>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>												
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th style="width:170px;"></th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
										
										
										<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
											<div class="card card-danger">
												<div class="card-header">
													<h3 class="card-title">Auto Cancel Member Directory</h3>
													<div id="auto_cancel_export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style>#auto_cancel_table td{text-align:center;vertical-align: middle;}#auto_cancel_table th{text-align:center;vertical-align: middle;}</style>
													<table id="auto_cancel_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>id</th>
																<th>Image</th>
																<th>Branch</th>
																<th>Card No</th>
																<th>Name</th>												
																<th>Phone Number</th>
																<th>Member Type</th>
																<th>Bed</th>
																<th>CheckIN</th>
																<th>CheckOut</th>
																<th>P:Category</th>
																<th>Package</th>
																<th>S:Deposit</th>
																<th style="width:170px;">Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
														<tfoot>
															<tr>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>												
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th style="width:170px;"></th>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
										</div>
										
										
										<div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
											<div class="card card-dark">
												<div class="card-header">
													<h3 class="card-title">Force Cancel Member Directory</h3>
													<div id="force_cancel_export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">
													<style>#force_cancel_table td{text-align:center;vertical-align: middle;}#force_cancel_table th{text-align:center;vertical-align: middle;}</style>
													<table id="force_cancel_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th>id</th>
																<th>Image</th>
																<th>Branch</th>
																<th>Card No</th>
																<th>Name</th>												
																<th>Phone Number</th>
																<th>Member Type</th>
																<th>Bed</th>
																<th>CheckIN</th>																
																<th>P:Category</th>
																<th>Package</th>
																<th>S:Deposit</th>
																<th style="width:170px;">Option</th>
															</tr>
														</thead>
														<tbody>	
														</tbody>
														<tfoot>
															<tr>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>												
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th></th>
																<th style="width:170px;"></th>
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
<!----vaiw card change model-->
	<div class="modal fade" id="member_card_change_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="card_change_form" method="post" enctype="multipart/form-data">
					<div class="modal-header btn-primary">
						<h4 class="modal-title">Member Card Change Form</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="card_change_result" style="max-height:780px;overflow-y:scroll;">	

						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="submit" id="change_card_submit_button" class="btn btn-info"><i class="fas fa-credit-card"></i>&nbsp;&nbsp; Change Card</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw card change model-->

<!----Shifting model-->
	<div class="modal fade" id="Shifting_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Shifting Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="Shifting_model_result" style="max-height:780px;min-height:510px;overflow-y:scroll;">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End Shifting model-->

<!----bed model-->
	<div class="modal fade" id="bed_selecting_model">
		<div class="modal-dialog modal-xl" style="min-width:90%;">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title" id="bed_info_header"></h4>
						<button type="button" onclick="return ref_bed_typ()" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="bed_result">	

						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" onclick="return ref_bed_typ()" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End bed model-->

<!----request for cencel model-->
	<div class="modal fade" id="request_for_celcel_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-danger">
						<h4 class="modal-title">Request For Cancel</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="cencel_request_result" style="max-height:780px;min-height:510px;overflow-y:scroll;">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End request for cencel model-->

<!----Final Checkout model-->
	<div class="modal fade" id="final_checkout_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Finally Check Out</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="final_checkOut_result" style="max-height:780px;min-height:510px;overflow-y:scroll;">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End Final Checkout model-->

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
<!----Shifting accepting model-->
	<div class="modal fade" id="Shifting_model_accept">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form id="Shifting_model_accept_form" action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-dark">
						<h4 class="modal-title">Accepting Shifting Member</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="Shifting_model_accept_result" style="/* max-height:780px;min-height:510px;overflow-y:scroll;*/ "> </div>
				</form>
			</div>
		</div>
	</div>
<!----End Shifting accepting model-->
<style>
.btn_member_direc button{
	margin-right:5px;
}
.btn_member_direc button:last-child{
	margin-right:0px;
}
</style>
<script>
var uploader_info = "<?php echo base64_encode($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']); ?>";
function member_pre_check_print_model(id){
	alert('Feature Comming Soon! Thank you');
	
	/* var pre_check_print = id;
	if(confirm('Are You Sure?')){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/member_cencel_request_form.php');?>",  
			method:"POST",  
			data:{ pre_check_print:pre_check_print },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}  
		});
	} */
}
function member_accepting_shifting_modal(id){
	var member_id = id;
	if(member_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/accept_shifting_member_from_other_branch.php'); ?>",  
			method:"POST",  
			data:{member_id:member_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#Shifting_model_accept_result').html(data);
				$('#Shifting_model_accept').modal('show');
			}  
		});  
	}
}
$('document').ready(function(){
	$("#Shifting_model_accept_form").on("submit",function(){
		event.preventDefault();
		var form = $('#Shifting_model_accept_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo base_url().'assets/ajax/form_submit/accept_shifting_member_from_other_branch_submit.php'; ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#change_card_submit_button").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				alert(data);
				$('#Shifting_model_accept').modal('hide');
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}
		});
		return false;
	})
})

function get_package_pc(){
	var id = $("#package_category").val();
	if(id != ''){
		$.ajax({  
			url:"<?php echo base_url().'assets/ajax/option_select/get_package_from_oackage_category.php'; ?>",  
			method:"POST",
			data:{ pc_ctg_id:id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				var value = data.split('____');
				$('#data-loading').html('');	
				$('#package_id').html(value[0]);
				$('#psh_room_type').val(value[1]);
			}  
		}); 
	}
}
function get_avaible_bed_info_package_shifting_accept_branch(){
	var bra_id_shif = $(".accept_branch_id").val(); 
	var bed_typ_sh = $("#psh_room_type").val();
	if(bed_typ_sh != ''){
		$.ajax({  
			url:"<?php echo base_url().'assets/ajax/select_beds_information_accept_branch.php'; ?>",  
			method:"POST",  
			data:{
				bed_type : bed_typ_sh,
				branch_id : bra_id_shif
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$('#bed_result').html(data); 
				$('#bed_info_header').html('<i class="fas fa-check"></i> Selected Bed Information. Bed Type: '+bed_typ_sh);
				$('#Shifting_model_accept').modal('hide');
				$('#bed_selecting_model').modal('show');   
			}
		});
	}else{
		alert('Please Select Package Category!');
	}
}
function get_bet_info_accept_branch(id){
	var bed_id = id;				
	if(bed_id != ''){
		$.ajax({
			url:"<?php echo base_url().'assets/ajax/select_beds_information.php';?>",  
			method:"POST",  
			data:{bed_id:bed_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('_');
				$("#pack_new_bed_name").val(value[1]);
				$("#pack_bed_id").val(value[0]);
				$('#bed_selecting_model').modal('hide');  
				$('#Shifting_model_accept').modal('show');
			}  
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}		
}

//----------------------------------------
function send_cencel_request_message(id){
	var member_id = id;
	if(member_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_submit/send_cencel_request_message.php');?>",  
			method:"POST",  
			data:{member_id:member_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data); 
				$('#request_for_celcel_model').modal('hide');
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

function member_final_checkout_modal(id){
	var book_id = id;
	var branch_id = "<?php echo $_SESSION['super_admin']['branch']; ?>";
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/member_final_checkout_form.php');?>",  
			method:"POST",  
			data:{
				book_id:book_id,
				uploader_info:uploader_info,
				branch_id:branch_id
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#final_checkOut_result').html(data); 
				$('#final_checkout_model').modal('show');   
			}  
		});
	}
}

function member_withdraw_modal(id){
	if(confirm('Are You Confirm to withdraw this member?')){
		var book_id = id;
		if(book_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_submit/request_for_withdraw_submit.php');?>",  
				method:"POST",  
				data:{ member_id:book_id },
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					$('#data_send_success_message').html(data); 
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}  
			});
		}
	}
}

function member_cancel_request_modal(id){
	var book_id = id;
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/member_cencel_request_form.php');?>",  
			method:"POST",  
			data:{
				book_id:book_id,
				uploader_info:uploader_info
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#cencel_request_result').html(data); 
				$('#request_for_celcel_model').modal('show');   
			}  
		});
	}
}

function get_bet_info(id){
	var bed_id = id;				
	if(bed_id != ''){
		$.ajax({  
			url:"<?php echo base_url().'assets/ajax/select_beds_information.php';?>",  
			method:"POST",  
			data:{bed_id:bed_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('_');
				$("#new_bed_name").val(value[1]);
				$("#bed_id").val(value[0]);
				$('#bed_selecting_model').modal('hide');  
				$('#Shifting_model').modal('show');
			}  
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}		
}

// function member_shifting_modal(id){
// 	var book_id = id;
// 	if(book_id != ''){
// 		$.ajax({  
// 			url:"<?=base_url('assets/ajax/member_shifting_form.php');?>",  
// 			method:"POST",  
// 			data:{
// 				book_id:book_id,
// 				uploader_info:uploader_info
// 			},
// 			beforeSend:function(){					
// 				$('#data-loading').html(data_loading);					 
// 			},
// 			success:function(data){	
// 				$('#data-loading').html('');
// 				$('#Shifting_model_result').html(data); 
// 				$('#Shifting_model').modal('show');   
// 			}  
// 		});
// 	}
// }

function member_shifting_modal(id){
	var book_id = id;
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_shifting_form.php');?>",  
			method:"POST",  
			data:{
				book_id:book_id,
				uploader_info:uploader_info
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#Shifting_model_result').html(data); 
				$('#Shifting_model').modal('show');  
				package_category_loading(); 
			}  
		});
	}
}






$("#card_change_form").on("submit",function(){ 
	if($("#new_card_number").val() == '' ){
		$("#card_change_error_message").html('New Card number Required!');
		$("#new_card_number").focus();
		return false;
	}
	/*
	 else if($("#payment_method_aut1").val() == '' ){
		$("#card_change_error_message").html('Payment Method Required!');
		$("#payment_method_aut1").focus();
		return false;
	} */
	
	else{
		event.preventDefault();
		var form = $('#card_change_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo base_url().'assets/ajax/form_submit/card_change_form_submit.php'; ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#change_card_submit_button").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('____');
				if(value[1] == '1'){
					$('#card_change_error_message').html(value[0]);
					$("#change_card_submit_button").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					$('#data_send_success_message').html(value[0]);										
					$('#member_card_change_model').modal('hide');
					$("#change_card_submit_button").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}					
			}
		});
		return false;
	}	
})


function member_card_change_modal(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_card_change_form.php');?>",  
			method:"POST",  
			data:{
				profile_id:profile_id,
				uploader_info:uploader_info
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#card_change_result').html(data); 
				$('#member_card_change_model').modal('show');   
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
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show');   
			}  
		});  
	}
}
//==================================================================

function booking_report_table(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
    var condition_2 = '?branch_id='+branch_sele_id+'&member_type='+$("#member_info_type").val();	
	
	
	
	//var ajax_data = "<?=base_url(); ?>assets/ajax/data_table/booking_information_datatable.php"+condition;
	//$('#booking_data_table').DataTable().ajax.url(ajax_data).load();
	
	var ajax_data2 = "<?=base_url(); ?>assets/ajax/data_table/auto_cancel_member_directiry_datatable.php"+condition_2;
	$('#auto_cancel_table').DataTable().ajax.url(ajax_data2).load();
	
	var ajax_data3 = "<?=base_url(); ?>assets/ajax/data_table/cancel_member_directiry_datatable.php"+condition_2;
	$('#member_cencel_data_table').DataTable().ajax.url(ajax_data3).load();
	
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/member_directiry_datatable.php"+condition_2;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
}


$(document).ready(function() {
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
    var table = $('#force_cancel_table1').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/auto_cancel_member_directiry_datatable.php"+condition,
		initComplete: function() {
            var api = this.api();
 
            // Apply the search
            api.columns().every(function() {
                var that = this;
 
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        },
		<?php if(check_permission('role_1606371206_64')){ ?>
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
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
		<?php } ?>
    });
	table.buttons().container().appendTo($('#force_cancel_export_buttons'));

	/*$('#force_cancel_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });*/
})

$(document).ready(function() {
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
    var table = $('#auto_cancel_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/auto_cancel_member_directiry_datatable.php"+condition,
		initComplete: function() {
            var api = this.api();
 
            // Apply the search
            api.columns().every(function() {
                var that = this;
 
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        },
		<?php if(check_permission('role_1606371206_64')){ ?>
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
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
		<?php } ?>
    });
	table.buttons().container().appendTo($('#auto_cancel_export_buttons'));

	/*$('#auto_cancel_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });*/
})


$(document).ready(function() {
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
    var table = $('#member_cencel_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/cancel_member_directiry_datatable.php"+condition,
		initComplete: function() {
            var api = this.api();
 
            // Apply the search
            api.columns().every(function() {
                var that = this;
 
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        },
		<?php if(check_permission('role_1606371206_64')){ ?>
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
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
		<?php } ?>
    });
	table.buttons().container().appendTo($('#cancel_export_buttons'));

	/*$('#member_cencel_data_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });*/
})


$(document).ready(function() {
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id+'&member_type='+$("#member_info_type");
    var condition = table_info;	
    var table = $('#booking_data_table').DataTable({
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
		"ScrollX": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/member_directiry_datatable.php"+condition,
		initComplete: function() {
            var api = this.api();
 
            // Apply the search
            api.columns().every(function() {
                var that = this;
 
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        },
		<?php if(check_permission('role_1606371206_64')){ ?>
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
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
		<?php } ?>
    });
	table.buttons().container().appendTo($('#export_buttons'));
	$('#booking_data_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input style="border:none;" type="text" class="form-control" title="Search By ' + title + '" placeholder="Search ' + title + '" />');
    });
})
</script>