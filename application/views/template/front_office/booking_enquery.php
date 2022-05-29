<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Booking Enquiry</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Booking Enquiry</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-5">
				<div class="card card-primary"> 
					<div class="card-header">
						<h3 class="card-title">Booking Enquiry</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" id="generate_id" name="generate_id" class="form-control" value="<?php echo date('dmy').rand('11','99'); ?>" placeholder="Id Number" readonly/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" id="name" name="name" class="form-control" placeholder="Name" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" id="Email" name="email" class="form-control" placeholder="Email"/>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<textarea name="address" class="form-control" placeholder="Address" required></textarea>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<textarea name="description" class="form-control" placeholder="Description"></textarea>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<textarea name="note" class="form-control" placeholder="Note"></textarea>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date</label>
										<input type="date" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Next Follow Up Date</label>
										<input type="date" id="n_date" name="n_date" class="form-control" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Referance Id</label>
										<input type="text" id="referance_id" name="referance_id" class="form-control" placeholder="Referance Id"/>
									</div>
								</div>								
								<div class="col-sm-3">
									<div class="form-group">
										<label>How to find us</label>
										<select id="h_t_f_u" name="h_t_f_u" class="form-control">
											<option value="">How to find us</option>
											<option value="News Paper">News Paper</option>
											<option value="Google">Google</option>
											<option value="Facebook">Facebook</option>
											<option value="Youtube">Youtube</option>
											<option value="Parents">Parents</option>
											<option value="TVC">TVC</option>
											<option value="Friends">Friends</option>
											<option value="Colleague">Colleague</option>
											<option value="SMS">SMS</option>
											<option value="Phone Call">Phone Call</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Branch</label>
										<select id="branch" name="branch" class="form-control">
											<option value="">Select Branch</option>
											<?php foreach($banches as $banche){ ?>
												<option value="<?php echo rahat_encode($banche->branch_id)?>"><?php echo $banche->branch_name?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" onclick="return confirm('Are you sure want to save this data?')" name="save" class="btn btn-success">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="card card-info">
					<div class="card-header">
						<h3 class="card-title">Phone Call Logs</h3>
						<div id="export_buttons" style="float: right;"></div>
					</div>
					<div class="card-body" style="overflow-x: scroll;">
						<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Branch</th>
										<th>Name</th>
										<th>Phone Number</th>
										<th>Description</th>
										<th>FollowUP Date</th>
										<th>E:Date</th>
										<th>Last Followup</th>
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
<!----autharized model-->
	<div class="modal fade" id="information_view_modal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="information_view_modal_result" style="max-height:780px;min-height:510px;overflow-y:scroll;">	
					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End autharized model-->

<!----Add Description model-->
	<div class="modal fade" id="information_add_modal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<input type="hidden" name="hidden_id" id="hidden_id" value=""/>
					<div class="modal-header btn-info">
						<h4 class="modal-title">Add Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body"  style="max-height:780px;min-height:510px;overflow-y:scroll;">	
						<div class="row">
							<div class="col-sm-12">
								<span id="warning_message" style="color:#f00;font-weight:bolder;"></span>
								<div class="form-group">
									<label>New Description</label>
									<textarea name="new_description" id="new_description" class="form-control" placeholder="New Description" required ></textarea>
								</div>
								
								<div class="form-group">
									<label>note</label>
									<textarea name="note" id="new_note" class="form-control" placeholder="Note" required ></textarea>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Previous Date</label>
											<input type="date" id="previous_date" name="previous_date" class="form-control" readonly/>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Next FollowUP Date</label>
											<input type="date" name="next_date" id="next_date" class="form-control" required />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Branch</label>
											<select id="branch_update" name="branch_update" class="form-control">
												<option value="">Select Branch</option>
												<?php foreach($banches as $banche){ ?>
													<option value="<?php echo rahat_encode($banche->branch_id)?>"><?php echo $banche->branch_name?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<button type="button" class="btn btn-success" onclick="return save_additional_data();" style="float:right;">Save Data</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End add description model-->
<script>
function save_additional_data(){
	let updated_branch = $('#branch_update').val();
	var description = $("#new_description").val();
	var note = $("#new_note").val();
	var previous_date = $("#previous_date").val();
	var next_date = $("#next_date").val();
	if(description == ''){
		$("#warning_message").html('Description fiels Required!');
		description.focus();
	} else if (next_date == ''){
		$("#warning_message").html('Next FollowUP Date Required!');
		next_date.focus();
	}else{
		var post_id = $("#hidden_id").val();
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/booking_enquiry_information_view.php');?>",  
			method:"POST",  
			data:{
				post_id:post_id,
				description:description,
				note:note,
				previous_date:previous_date,
				previous_date:previous_date,
				updated_branch,
				next_date:next_date
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data);
				window.open('<?php echo current_url(); ?>','_self');
				$('#information_add_modal').modal('hide');  
			}  
		});
	}
}
function add_information(id,follo_up_date,branch_id){
	$('#hidden_id').val(id);
	if(follo_up_date != ''){
		$("#previous_date").val(follo_up_date);
	}else{
		$("#previous_date").val('<?php echo date("Y-m-d"); ?>');
	}	   
	$('#information_view_modal').modal('hide');  
	$('#information_add_modal').modal('show');
	$('#branch_update').val(branch_id);
}
function view_information(id){
	if(id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/booking_enquiry_information_view.php');?>",  
			method:"POST",  
			data:{enquary_id:id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#information_view_modal_result').html(data); 
				$('#information_view_modal').modal('show');   
			}  
		});
	}else{
		alert('Something Wrong! Please Try again.');
	}
}
$(document).ready(function() {
	var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	var table_info = '?branch_id='+branch_sele_id;
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 5, "asc" ]],
		//"info": true,
		//"autoWidth": true,
		//"responsive": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/phone_call_logs_information_datatable.php"+table_info,
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
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>