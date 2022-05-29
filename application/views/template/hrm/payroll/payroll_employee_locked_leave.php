<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Locked Leave</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Locked Leave</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-12">
					<div class="card card-info">
						<div class="card-header">
							<i class="fas fa-sort-amount-up"></i> Locked Leave
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <input id="date_filter" onchange="date_filter(this.value)" type="month" class="form-control" value="<?= date('Y-m') ?>">
                                </div>
                                <div class="col-md-12">
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
                                                <th>Start Date (Y/m/d)</th>
                                                <th>NOD</th>
                                                <th>Note</th>
                                                <th>End Date</th>
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
			<!------->
		</div>
	</div>
</div>

<script>
let date_filter = (selected_month) => {
    let ajax_data = "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_locked_leave_datatable.php" + `?date=${selected_month}`;
    $('#booking_data_table').DataTable().ajax.url(ajax_data).load();
}

$(document).ready(function() {
    let date = $('#date_filter').val();
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ],
		"searching": true,
		"ordering": true,
		"order": [[ 12, "asc" ], [ 6, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
		"columnDefs": [
			{
                "targets": [ 17 ],
                "visible": false
            }
		],
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_locked_leave_datatable.php" + `?date=${date}`,
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>