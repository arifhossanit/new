<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Investment Member Directory</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Investment Member Directory</li>
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
						<div class="col-sm-12" style="margin-bottom:20px;">							
							<button type="button" onclick="window.open('<?php echo base_url('admin/ipo'); ?>','_self')" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-fast-backward"></i> &nbsp;&nbsp;Back</button>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<span id="data_send_success_message" style="font-weight:bolder;color:green;"></span>
							<div class="card card-dark">
								<div class="card-header">
									<h3 class="card-title">Investment Member Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
										<thead>
											<tr>
												<th>id</th>
												<th>Image</th>
												<th>Card:No</th>
												<th>Name</th>
												<th>Phone</th>
												<th>Email</th>
												<th>NID</th>
												<th>Aggrement Type</th>
												<th>Growth</th>
												<th>Bank</th>												
												<th>TRXN Type</th>												
												<th>Account Number</th>
												<th>Uploader</th>
												<th style="width:170px;">Option</th>
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



<!----vaiw ipo_member_card_change_form_model model-->
	<div class="modal fade" id="ipo_member_card_change_form_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="card_change_ipo_member_form_form_id" method="post" enctype="multipart/form-data">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Investment Card Change Form</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="ipo_member_card_change_form_result" style="max-height:780px;overflow-y:scroll;"> </div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="submit" id="ipo_member_card_change_form_button" class="btn btn-info"><i class="fas fa-credit-card"></i> &nbsp;&nbsp;Change Card</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End ipo_member_card_change_form_model model-->

<!----vaiw ipo_member_shifting_form model-->
	<div class="modal fade" id="ipo_member_shifting_form_model">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form id="shifting_ipo_member_form_form_id" method="post" enctype="multipart/form-data">
					<div class="modal-header btn-primary">
						<h4 class="modal-title">Investment Agreement Shifting Form</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="ipo_member_shifting_form_result" style="max-height:780px;overflow-y:scroll;"> </div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="submit" id="ipo_member_shifting_form_button" class="btn btn-info"><i class="fas fa-credit-card"></i> &nbsp;&nbsp;Change Card</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End ipo_member_card_change_form_model model-->

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
<!----vaiw edit model-->
	<div class="modal fade" id="ipo_member_edit_modal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="ipo_member_edit_form" method="post" enctype="multipart/form-data">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Member Information Change Form</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body" id="ipo_member_edit_modal_body" style="max-height:780px;overflow-y:scroll;"></div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="submit" id="update_informaion_submit_button" class="btn btn-info"><i class="fas fa-credit-card"></i>&nbsp;&nbsp; Update Information</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End edit model-->

<!----vaiw ipo_memver_view_information_modal model-->
	<div class="modal fade" id="ipo_memver_view_information_modal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="ipo_memver_view_information_form" method="post" enctype="multipart/form-data">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
					</div>
					<div class="modal-body" id="ipo_memver_view_information_body" style="max-height:780px;overflow-y:scroll;"></div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End ipo_memver_view_information_modal model-->
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
function ipo_member_information(id){
	$.ajax({  
		url:"<?php echo base_url().'assets/ajax/ipo/get_ipo_member_information.php'; ?>",  
		method:"POST",  
		data:{ ipo_member_view_id : id },
		beforeSend:function(){ $('#data-loading').html(data_loading); },
		success:function(data){
			$('#data-loading').html('');
			$('#ipo_memver_view_information_body').html(data); 
			$('#ipo_memver_view_information_modal').modal('show');   
		}  
	});
}
function ipo_member_edit_form(id){
	$.ajax({  
		url:"<?php echo base_url().'assets/ajax/ipo/get_ipo_member_information.php'; ?>",  
		method:"POST",  
		data:{ ipo_db_id : id },
		beforeSend:function(){ $('#data-loading').html(data_loading); },
		success:function(data){
			$('#data-loading').html('');
			$('#ipo_member_edit_modal_body').html(data); 
			$('#ipo_member_edit_modal').modal('show');   
		}  
	});
}
$('document').ready(function(){
	$("#ipo_member_edit_form").on("submit",function(){
		event.preventDefault();
		var form = $('#ipo_member_edit_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo base_url().'assets/ajax/ipo/get_ipo_member_information.php'; ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#update_informaion_submit_button").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$("#update_informaion_submit_button").prop("disabled", false);				
				alert(data);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
				$('#ipo_member_edit_modal_body').html(''); 
				$('#ipo_member_edit_modal').modal('hide'); 				
			}
		});		
		return false;
	})
})



function get_old_bed_info(){
	var old_bed_id = $('select[name="old_bed_id"]').val();
	if(old_bed_id != ''){
		var value = old_bed_id.split('____');	
		$("#old_bed_id_agrement").val(value[0]);
		$("#branch_id_agrement").val(value[1]);
		$("#bed_type_agrement").val(value[2]);		
		$("#old_agrement_id").val(value[3]);		
		$("#new_bed_name").prop('disabled',false);
		$("#new_bed_name").prop('required',true);
	}else{
		$("#old_bed_id_agrement").val('');
		$("#branch_id_agrement").val('');
		$("#bed_type_agrement").val('');		
		$("#old_agrement_id").val('');		
		$("#new_bed_name").prop('disabled',true);
		$("#new_bed_name").prop('required',false);
	}
}
function get_avaible_bed_info(){
	var bra_id_shif = $("#branch_id_agrement").val();
	var bed_typ_sh = $("#bed_type_agrement").val();
	$.ajax({  
		url:"<?php echo base_url().'assets/ajax/ipo/select_beds_options.php'; ?>",  
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
			$('#ipo_member_shifting_form_model').modal('hide');
			$('#bed_selecting_model').modal('show');   
		}  
	});	
}
function get_bet_info(id){
	var bed_id = id;				
	if(bed_id != ''){
		$.ajax({  
			url:"<?php echo base_url().'assets/ajax/ipo/select_beds_information.php';?>",  
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
				$('#ipo_member_shifting_form_model').modal('show');
			}  
		});  
	}else{
		alert('Something wrong! Please contact with IT Department.');
	}		
}
function ipo_member_shifting_form(id){
	var member_id = id;
	if(member_id != ''){
		$.ajax({
			url:"<?=base_url('assets/ajax/ipo/ipo_member_agreement_shifting_form.php');?>",  
			method:"POST",  
			data:{ member_id:member_id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#ipo_member_shifting_form_result').html(data); 
				$('#ipo_member_shifting_form_model').modal('show');   
			}  
		});  
	}
}

function ipo_member_card_change_form(id){
	var member_id = id;
	if(member_id != ''){
		$.ajax({
			url:"<?=base_url('assets/ajax/ipo/ipo_member_card_change_form.php');?>",  
			method:"POST",  
			data:{ member_id:member_id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#ipo_member_card_change_form_result').html(data); 
				$('#ipo_member_card_change_form_model').modal('show');   
			}  
		});  
	}
}
$('document').ready(function(){
	$("#shifting_ipo_member_form_form_id").on("submit",function(){
		event.preventDefault();
		var form = $('#shifting_ipo_member_form_form_id')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo base_url().'assets/ajax/ipo/shifting_ipo_member_form_form_submit.php'; ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#ipo_member_shifting_form_button").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('____');
				if(value[1] == '1'){
					$('#card_change_error_message').html(value[0]);
					$("#ipo_member_shifting_form_button").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					$('#data_send_success_message').html(value[0]);										
					$('#ipo_member_shifting_form_model').modal('hide');
					$("#ipo_member_shifting_form_button").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}					
			}
		});
		return false;
	})
	
	$("#card_change_ipo_member_form_form_id").on("submit",function(){
		event.preventDefault();
		var form = $('#card_change_ipo_member_form_form_id')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?php echo base_url().'assets/ajax/form_submit/card_change_ipo_member_form_submit.php'; ?>",  
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
					$("#ipo_member_card_change_form_button").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					$('#data_send_success_message').html(value[0]);										
					$('#ipo_member_card_change_form_model').modal('hide');
					$("#ipo_member_card_change_form_button").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}					
			}
		});
		return false;
	})
})


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
$(document).ready(function(){
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_member_directiry_datatable.php",
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
    });
	table.buttons().container().appendTo($('#export_buttons'));
})
</script>