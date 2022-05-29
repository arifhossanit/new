<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Leave & Hold Approval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Leave & Hold Approval</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Pending Leave</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Approved Leave</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-four-tabContent">
								<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
									<div class="card-body">
										<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
										<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;">
											<thead>
												<tr>
													<th>#</th>
													<th>Image</th>
													<th>Employee</th>
													<th>Branch</th>
													<th>Department</th>
													<th>Designation</th>
													<th>Start Date</th>
													<th>End Date</th>
													<th>NOD</th>
													<th>Note</th>
													<th>A:By</th>
													<th>D:HEAD</th>
													<th>Aproval</th>
													<th>Uploder</th>
													<th>Date</th>
													<th>Note</th>
													<th>Option</th>
													<th>employee_id</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
									<div class="card-body">
										<div class="row">
											<div class="col-md-2">
												<input onchange="get_approved_leave(this.value)" id="leave_date" class="form-control" type="date">
											</div>
											<div class="col-md-12 mt-2">
												<style>#booking_data_table_approved td{text-align:center;vertical-align: middle;}#booking_data_table_approved th{text-align:center;vertical-align: middle;}#booking_data_table_approved td:last-child{text-align:left;}</style>
												<table id="booking_data_table_approved" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;">
													<thead>
														<tr>
															<th>#</th>
															<th>Image</th>
															<th>Employee</th>
															<th>Branch</th>
															<th>Department</th>
															<th>Designation</th>
															<th>Start Date</th>
															<th>End Date</th>
															<th>NOD</th>
															<th>Note</th>
															<th>A:By</th>
															<th>D:HEAD</th>
															<th>Aproval</th>
															<th>Uploder</th>
															<th>Date</th>
															<th>Note</th>
															<th>Option</th>
															<th>employee_id</th>
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
			<!------->
			<div class="row">		
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="card card-primary">
						<div class="card-header">
							<i class="fas fa-sort-amount-down"></i> Hold Employee Approval Logs
							<div id="cancel_export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#member_cencel_data_table td{text-align:center;vertical-align: middle;}#member_cencel_data_table th{text-align:center;vertical-align: middle;}#member_cencel_data_table td:last-child{text-align:left;}</style>
							<table id="member_cencel_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>#</th>
										<th>Employee</th>
										<th>Hold_Status</th>
										<th>Aproval_Status</th>
										<th>Uploder</th>
										<th>Date</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<div align="left" style="position: absolute; margin-top: -32px;">
								<button type="button" id="select_hold" class="btn btn-xs btn-warning"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
								<button type="button" id="unselect_hold" class="btn btn-xs btn-success"><i class="fa fa-bars" aria-hidden="true"></i></button>
								&nbsp;|&nbsp;
								<button type="button" id="btn_delete_accept_hold" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i></button>
								<button type="button" id="btn_delete_reject_hold" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_aproval">
	<div class="modal-dialog modal-md">
		<div class="modal-content">	
			<form id="modal_aproval_form" action="<?php echo current_url(); ?>" method="Post" enctype="multipart/form-data">
				<input type="hidden" name="hidden_id" id="approval_accept_id" value=""/>
				<input type="hidden" name="approval_type" id="approval_type" value=""/>
				<div class="modal-header btn-info">
					<h4 class="modal-title">Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<textarea id="aproval_modal_note" class="form-control" placeholder="Note"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success" style="float:right;">Accept</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_reject">
	<div class="modal-dialog modal-md">
		<div class="modal-content">	
			<form id="modal_reject_form" action="<?php echo current_url(); ?>" method="Post" enctype="multipart/form-data">
				<input type="hidden" name="hidden_id" id="rejection_accept_id" value=""/>
				<input type="hidden" name="rejection_type" id="rejection_type" value=""/>
				<div class="modal-header btn-info">
					<h4 class="modal-title">Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<textarea id="rejected_modal_note" class="form-control" placeholder="Note"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success" style="float:right;">Accept</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="view_modal_aproval_note">
	<div class="modal-dialog modal-md">
		<div class="modal-content">	
			<input type="hidden" name="hidden_id" id="approval_accept_id" value=""/>
			<div class="modal-header btn-info">
				<h4 class="modal-title">Note</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body" id="view_modal_aproval_note_result"></div>
		</div>
	</div>
</div>

<script>
function view_note_function(id){
	$.ajax({
		 url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",
		 method:'POST',
		 data:{view_approved_ids:id},
		 success:function(data) {
			$('#view_modal_aproval_note_result').html(data);
			$('#view_modal_aproval_note').modal('show');
		}     
	});
}


$(document).ready(function(){ 
	$("#select_hold").click(function(){
		$('input[id="hold_check"]').prop('checked',true);     
	});
	$("#unselect_hold").click(function(){
		$('input[id="hold_check"]').prop('checked',false);     
	});
	
	$('#btn_delete_reject_hold').click(function(){  
		if(confirm("Are you sure you want to delete selected Iteam?")){
			var id = [];   
			$('input[id="hold_check"]:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					 url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",
					 method:'POST',
					 data:{hold_rejects_ids:id},
					 success:function() {
						$('#booking_data_table').DataTable().ajax.reload( null , false);
						alert(data);
					}     
				});
			}   
		} else {
			return false;
		}
	});
	$('#btn_delete_accept_hold').click(function(){  
		if(confirm("Are you sure you want to delete selected Iteam?")){
			var id = [];   
			$('input[id="leave_check"]:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					 url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",
					 method:'POST',
					 data:{hold_aproved_ids:id},
					 success:function() {
						$('#booking_data_table').DataTable().ajax.reload( null , false);
						alert(data);
					}     
				});
			}   
		} else {
			return false;
		}
	}); 
});

function hold_reject_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_accept_ssubmit.php'); ?>",			
				method: "POST",
				data: {hold_rejected_id:id},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$('#member_cencel_data_table').DataTable().ajax.reload( null , false);
					alert(data);
				}
			});
		}
	}else{
		alert('Something wrong! Please try again');
	}
}
function hold_accept_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",		
				method: "POST",
				data: {hold_accept_id:id},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$('#member_cencel_data_table').DataTable().ajax.reload( null , false);
					alert(data);
				}
			});
		}
	}else{
		alert('Something wrong! Please try again');
	}
}
//-------------------------------------------------------------------------------------------------------------------
$(document).ready(function(){ 
	$("#select").click(function(){
			$('input[id="leave_check"]').prop('checked',true);     
	});
	$("#unselect").click(function(){
			$('input[id="leave_check"]').prop('checked',false);     
	});
	
	$('#btn_delete_reject').click(function(){  
		if(confirm("Are you sure you want to delete selected Iteam?")){
			var id = [];   
			$('input[id="leave_check"]:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					 url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",
					 method:'POST',
					 data:{leave_rejects_ids:id},
					 success:function() {
						$('#booking_data_table').DataTable().ajax.reload( null , false);
						alert(data);
					}     
				});
			}   
		} else {
			return false;
		}
	});
	$('#btn_delete_accept').click(function(){  
		if(confirm("Are you sure you want to delete selected Iteam?")){
			var id = [];   
			$('input[id="leave_check"]:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					 url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",
					 method:'POST',
					 data:{leave_aproved_ids:id},
					 success:function() {
						$('#booking_data_table').DataTable().ajax.reload( null , false);
						alert(data);
					}     
				});
			}   
		} else {
			return false;
		}
	}); 
});

let get_approved_leave = (leave_date) => {
	var ajax_data = "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_approved_leave_approval_datatable.php?leave_date=" + leave_date;
	$('#booking_data_table_approved').DataTable().ajax.url(ajax_data).load();
}

$(document).ready(function(){
	$('#modal_aproval_form').on("submit",function(){
		event.preventDefault();
		var id = $('#approval_accept_id').val();
		var type = $('#approval_type').val();
		if($('#aproval_modal_note').val() != ''){
			var note = $('#aproval_modal_note').val();
		}else{
			var note = '';
		}		
		// if(id != ''){
		// 	if(confirm("Are you sure?")){
		$.ajax({
			url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",			
			method: "POST",
			data: {
				accept_id:id,
				note:note,
				type
			},
			beforeSend:function(){
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$('#booking_data_table').DataTable().ajax.reload( null , false);
				$('#modal_aproval').modal('hide');
				// alert(data);
			}
		});
		// 	}
		// }else{
		// 	alert('Something wrong! Please try again');
		// }
		return false;
	})
	$('#modal_reject_form').on("submit",function(){
		event.preventDefault();
		var id = $('#rejection_accept_id').val();
		var type = $('#rejection_type').val();
		if($('#rejected_modal_note').val() != ''){
			var note = $('#rejected_modal_note').val();
		}else{
			var note = '';
		}		
		// if(id != ''){
		// 	if(confirm("Are you sure?")){
		$.ajax({
			url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",			
			method: "POST",
			data: {
				rejected_id:id,
				note,
				type
			},
			beforeSend:function(){
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$('#booking_data_table').DataTable().ajax.reload( null , false);
				$('#modal_reject').modal('hide');
				// alert(data);
			}
		});
		// 	}
		// }else{
		// 	alert('Something wrong! Please try again');
		// }
		return false;
	})
})
function leave_accept_function(id, type){
	$('#approval_accept_id').val(id);
	$('#approval_type').val(type);
	$('#modal_aproval').modal('show');
}
function leave_reject_function(id, type){
	$('#rejection_accept_id').val(id);
	$('#rejection_type').val(type);
	$('#modal_reject').modal('show');
}




$(document).ready(function() {
    var table_booking = $('#member_cencel_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_hold_approval_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#cancel_export_buttons'));	
})
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ],
		"searching": true,
		"ordering": true,
		// "order": [[ 12, "asc" ], [ 6, "desc" ]],
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
		"columnDefs": [
			{
                "targets": [ 17, 5, 13, 14, 0 ],
                "visible": false
            },
			{
                "targets": [ 7, 6 ],
                "orderable": false
            },
		],
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_leave_approval_datatable.php",
		// dom: 'lBfrtip',
        // buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	// table_booking.buttons().container().appendTo($('#export_buttons'));	

	let leave_date = $('#leave_date').val();
    var table_booking = $('#booking_data_table_approved').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ],
		"searching": true,
		"ordering": true,
		// "order": [[ 12, "asc" ], [ 6, "desc" ]],
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
		"columnDefs": [
			{
                "targets": [ 17, 5, 13, 14, 0 ],
                "visible": false
            }
		],
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_approved_leave_approval_datatable.php",
		// dom: 'lBfrtip',
        // buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	// table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>