<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Fired Approval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Fired Approval</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row justify-content-center">		
				<div class="col-sm-9">
					<div class="card card-info">
						<div class="card-header">
							<i class="fas fa-paper-plane"></i> Fired Approval Logs
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Photo</th>
										<th>Employee</th>
										<th>Department</th>
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
		</div>
	</div>
</div>
<!----aprove model-->
<div class="modal fade" id="aproval_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<input type="hidden" name="aprove_id" value="" />
				<div class="modal-header btn-success">
					<h4 class="modal-title">Request for Chain approval</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Select aproval Employee</label>
						<select name="aproval_employee[]" multiple="multiple" class="form-control select2" required>
							<option value="">--select--</option>
							<?php 
								$table = $this->Dashboard_model->select('employee',array( 'status' => '1'),'id','asc','result');
								if(!empty($table)){
									foreach($table as $row){
										if($row->employee_id != '00001' AND $row->employee_id != '00002' AND $row->employee_id != '00003'){
							?>
								<option value="<?php echo $row->employee_id; ?>"><?php echo $row->full_name; ?> - <?php echo $row->employee_id; ?></option>
							<?php } } } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Note</label>
						<textarea name="extra_note" class="form-control" placeholder="Note" required="required" style="height:200px;"></textarea>
					</div>
<!--
					<div class="form-group">
						<label>Select Date</label>-->
						<input type="hidden" class="form-control" name="deactive_Date" value="<?php echo date('Y-m-d'); ?>"/>
					<!--</div>-->

				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="status_off" onclick="return confirmation_check()" class="btn btn-success">Send Verify Request</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End aprove model-->

<!-- Last working date modal -->
<div class="modal fade" id="give_last_working_day">
	<div class="modal-dialog">
		<div class="modal-content">
			<input type="hidden" id="accept_function_id" value=""/>
			<div class="modal-header btn-success">
				<h4 class="modal-title">Last Working Day</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="error_message" class="text-danger"></p>
				<input class="form-control mb-3" type="text" id="last_working_date_d_head" value="Not Mentioned!" readonly>
				<input class="form-control" type="date" name="last_working_date" id="last_working_date" required>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" id="give_last_working_day_submit" name="status_off" onclick="return hr_fired_accept_function()" class="btn btn-success">Submit</button>
			</div>
		</div>
	</div>
</div>
<script>
function confirmation_check(){
	var employee = $('select[name="aproval_employee[]"]').val();
	if(employee == ''){
		if(confirm('Are you sure want to exit him with out other employee approval.')){
			return true;
		}else{
			return false;
		}
	}else{
		return true;
	}
}
</script>
<!----aprove model-->
<div class="modal fade" id="pending_status_modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Pending status modal</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="pending_status_modal_result" style="max-height:760px;overflow-y:scroll;">					
				</div>
			</form>
		</div>
	</div>
</div>
<!----End aprove model-->


<script>
function view_pending_status(id){
	$.ajax({
		url: "<?=base_url('assets/ajax/form_submit/hrm/loan/hr_fired_accept_view_pending_status.php'); ?>",			
		method: "POST",
		data: {employee_id:id},
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#pending_status_modal_result').html(data);
			$('#pending_status_modal').modal('show');			
		}
	});
}
function hr_request_for_chain_approval(id){
	$('input[name="aprove_id"]').val(id);
	$("#aproval_modal").modal('show');
}

let set_id_for_release_date = (id, last_date) => {
	if(last_date != 'none'){
		$('#last_working_date_d_head').val(last_date);
	}
	$('#last_working_date').val('0000-00-00');
	$('#error_message').html('');
	$('#give_last_working_day_submit').prop('disabled', false);
	$('#accept_function_id').val(id);
}

function hr_fired_accept_function(){
	let id = $('#accept_function_id').val();
	let last_working_date = $('#last_working_date').val();
	if(last_working_date == ''){
		$('#error_message').html('Date Required!');
		return;
	}
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/loan/hr_fired_accept_ssubmit.php'); ?>",			
				method: "POST",
				data: {accept_id:id, last_working_date},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
					$('#give_last_working_day_submit').prop('disabled', true);
				},
				success:function(data){
					$('#give_last_working_day').modal('toggle');
					$('#give_last_working_day_submit').prop('disabled', false);
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

function hr_fired_reject_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/loan/hr_fired_accept_ssubmit.php'); ?>",			
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/loan/employee_fired_approval_hrm_chain_request_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>