<style>
	.button-box{
		position: relative;
	}
	.badge{
		border-radius: 50%;
		width: 1.2rem;
		height: 1.2rem;
		box-shadow: 1px gray;
		position: absolute;
		top: -15px;
		left: -5px;
		cursor: pointer;
	}
	.badge.increment{
		border: 1px solid rgb(76, 175, 80);
		background-color: rgb(76, 175, 80);
	}
	.badge.decrement{
		border: 1px solid rgb(191, 54, 12);
		background-color: rgb(191, 54, 12);		
	}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Increament/Decreament Approval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Increament/Decreament Approval</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-sm-12">
					<form action="<?php echo current_url(); ?>" method="post">
						<center style="margin-bottom:20px;">
							<span class="button-box">
								<?php echo ($pending_increment_count > 0) ? '<span class="badge increment"><span ="text">'.$pending_increment_count.'</span></span>' : '' ;?>
								<button type="submit" name="increament_approval" class="btn btn-success" style="margin-right:10px;">Increament Aproval Logs</button>
							</span>
							<span class="button-box">
								<?php echo ($pending_decrement_count > 0) ? '<span class="badge decrement">'.$pending_decrement_count.'</span>' : '' ;?>
								<button type="submit" name="decreament_approval" class="btn btn-danger">Decreament Aproval Logs</button>
							</span>
						</center>
					</form>
				</div>
			</div>
			
			<?php if(isset($_POST['increament_approval'])){ ?>
			<div class="row">			
				<div class="col-sm-12">
					<div class="card card-info">
						<div class="card-header">
							<i class="fas fa-sort-amount-up"></i> Increament Approval Logs
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body" style="overflow-x:scroll;">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;">
								<thead>
									<tr>
										<th>ID</th>
										<th>Image</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Designation From</th>
										<th>Designation To</th>
										<th>Option</th>
										<th>Start Date</th>
										<th>UP:By</th>
										<th>Uploder</th>
										<th>Reason</th>
										<th>Status</th>
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
			<!------->
			<?php } else if(isset($_POST['decreament_approval'])){ ?>
			<div class="row">		
				<div class="col-sm-12">
					<div class="card card-primary">
						<div class="card-header">
							<i class="fas fa-sort-amount-down"></i> Decreament Approval Logs
							<div id="cancel_export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body" style="overflow-x:scroll;">
							<style>#member_cencel_data_table td{text-align:center;vertical-align: middle;}#member_cencel_data_table th{text-align:center;vertical-align: middle;}#member_cencel_data_table td:last-child{text-align:left;}</style>
							<table id="member_cencel_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>ID</th>
										<th>Image</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Designation From</th>
										<th>Designation To</th>
										<th>Option</th>
										<th>Start Date</th>
										<th>Uploder</th>
										<th>Status</th>
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
			<?php } ?>
		</div>
	</div>
</div>
<div class="modal fade" id="view_increament_decreament_info_modal">
	<div class="modal-dialog modal-md" >
		<div class="modal-content">	
			<div class="modal-header btn-info">
				<h4 class="modal-title">View Information</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body" id="view_increament_decreament_info_result">
				
			</div>
		</div>
	</div>
</div>


<script>

function increament_hr_check_done(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_decreament_hr_check.php'); ?>",		
				method: "POST",
				data: {id:id, table: "employee_increament_logs"},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					//$('#member_cencel_data_table').DataTable().ajax.reload( null , false);
					//alert(data);
					 $(".hr_check_done").hide();
				}
			});
		}
	}else{
		alert('Something wrong! Please try again');
	}
}

function decreament_hr_check_done(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_decreament_hr_check.php'); ?>",		
				method: "POST",
				data: {id:id, table: "employee_decreament_logs"},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					//$('#member_cencel_data_table').DataTable().ajax.reload( null , false);
					//alert(data);
					$(".hr_check_done").hide();
				}
			});
		}
	}else{
		alert('Something wrong! Please try again');
	}
}

function view_increament_info(id,type){
	if(id != ''){
		$.ajax({
			url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_accept_ssubmit.php'); ?>",			
			method: "POST",
			data: {
				view_increament_info_id:id,
				view_increament_type:type
			},
			beforeSend:function(){ $('#data-loading').html(data_loading); },
			success:function(data){
				$('#data-loading').html('');
				$('#view_increament_decreament_info_result').html(data);
				$('#view_increament_decreament_info_modal').modal('show');
				
			}
		});
	}else{
		alert('Something wrong! Please try again');
	}
}
function decreament_accept_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_accept_ssubmit.php'); ?>",			
				method: "POST",
				data: {dec_accept_id:id},
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
function decreament_reject_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_accept_ssubmit.php'); ?>",			
				method: "POST",
				data: {dec_rejected_id:id},
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

function increament_accept_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_accept_ssubmit.php'); ?>",			
				method: "POST",
				data: {accept_id:id},
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

function increament_reject_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/payroll/increament_accept_ssubmit.php'); ?>",			
				method: "POST",
				data: {rejected_id:id},
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_decreament_approval_datatable.php",
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
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_increament_approval_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>