<div class="content-wrapper">
	<style>
		table.dataTable tbody td {
			word-break: break-word !important;
			vertical-align: top !important;
		}
	</style>
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Deduction Approval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Deduction Approval</li>
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
							<i class="fas fa-paper-plane"></i> Deduction Approval Logs
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;/*white-space: nowrap;*/">
								<thead>
									<tr>
										<th>SL:NO:</th>
										<th>Photo</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Designation</th>
										<th>Amount</th>
										<th>Reason</th>
										<th>Month</th>
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
				<div class="col-sm-1"></div>
			</div>
			<!------->
			
		</div>
	</div>
</div>
<script>

function deduction_accept_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/loan/deduction_accept_ssubmit.php'); ?>",			
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

function deduction_reject_function(id){
	if(id != ''){
		if(confirm("Are you sure?")){
			$.ajax({
				url: "<?=base_url('assets/ajax/form_submit/hrm/loan/deduction_accept_ssubmit.php'); ?>",			
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
		"order": [[ 9, "asc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/loan/employee_deduction_approval_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>