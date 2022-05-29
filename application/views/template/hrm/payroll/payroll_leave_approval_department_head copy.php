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
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<div class="card card-info">
						<div class="card-header">
							<i class="fas fa-sort-amount-up"></i> Leave Approval Logs
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>#</th>
										<th>Image</th>
										<th>Employee</th>
										<th>Branch</th>
										<th>Start Date</th>
										<th>NOD</th>
										<th>Note</th>
										<th>End Date</th>
										<th>Image</th>
										<th>D:HEAD</th>
										<th>Aproval</th>
										<th>Uploder</th>
										<th>Date</th>
										<th>Note</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<!--
							<div align="left" style="position: absolute; margin-top: -32px;">
								<button type="button" id="select" class="btn btn-xs btn-warning"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
								<button type="button" id="unselect" class="btn btn-xs btn-success"><i class="fa fa-bars" aria-hidden="true"></i></button>
								&nbsp;|&nbsp;
								<button type="button" id="btn_delete_accept" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i></button>
								<button type="button" id="btn_delete_reject" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i></button>
							</div>
							-->
						</div>
					</div>
				</div>
				<div class="col-sm-1"></div>
			</div>
			<!------->
			<!--
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
			</div>-->
		</div>
	</div>
</div>
<script>
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
function leave_reject_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",			
				method: "POST",
				data: {rejected_id_head:id},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$('#booking_data_table').DataTable().ajax.reload( null , false);
					alert(data);
				}
			});
		}
	}else{
		alert('Something wrong! Please try again');
	}
}
function leave_accept_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/leave/leave_approval_rejection_delete_ssubmit.php'); ?>",			
				method: "POST",
				data: {accept_id_head:id},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$('#booking_data_table').DataTable().ajax.reload( null , false);
					// alert(data);
				}
			});
		}
	}else{
		alert('Something wrong! Please try again');
	}
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
	var dipartment = "?department=<?php echo $_SESSION['user_info']['department']; ?>";
    var table_booking = $('#booking_data_table').DataTable({
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_leave_approval_datatable.php"+dipartment,
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>