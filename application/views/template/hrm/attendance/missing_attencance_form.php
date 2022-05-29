<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee MIssing Attendance Form</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item active">MIssing Attendance Form</li>
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
						<div class="col-sm-2"></div>
						<div class="col-sm-8">
							<div class="card card-info">
								<div class="card-header">
									<h3 class="card-title"><i class="fas fa-users"></i> Select Employee</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">	
									<div class="row">
										<div class="col-sm-12">
											<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
												<div class="row">
													<div class="col-sm-3">
														<div class="form-group">
															<label>Select Employee</label>
															<select name="employee_id" class="form-control select2" required>
																<option value="">--select--</option>
																<?php
																if(!empty($employee)){
																	foreach($employee as $row){
																		echo '<option value="'.$row->employee_id.'">'.$row->employee_id.' - '.$row->full_name.'</option>';
																	}
																}
																?>
															</select>
														</div>
													</div>	
													<div class="col-sm-2">
														<div class="form-group">
															<label>Start Date</label>
															<input type="date" name="attendate_date" id="attendate_date" max="<?php echo date('Y-m-d'); ?>" class="form-control" required onchange="calculate_date()"/>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-group">
															<label>How Many Days</label>
															<input type="number" name="how_many_days" id="how_many_days" placeholder="0" class="form-control" required oninput="calculate_date()"/>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-group">
															<label>End Date</label>
															<input type="text" name="end_date" id="end_date" class="form-control" readonly/>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="form-group">
															<label>Choose One</label>
															<select id="attendance" name="attendance" class="form-control select2" required>
																<option value="">--select--</option>
																<option value="0.5_half">Half Day</option>
																<option value="absent">Absent</option>
																<option value="1">Present</option>
																<option value="1_home">Work From Home</option>
															</select>
														</div>
													</div>
													<div class="col-sm-1">
														<div class="form-group">
															<label>&nbsp;&nbsp;&nbsp;</label>
															<button name="get_attendance" class="btn btn-success" type="submit" style="width:100%;">Submit</button>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-9">
														<label>Note</label>
														<textarea name="name" class="form-control" placeholder="note"></textarea>
													</div>
												</div>
											</form>
										</div>
									</div>
									<hr />
									<?php /* ?>
									<div class="row">
										<div class="col-sm-12">
											<label>Missing Attentance Logs</label>
										</div>
										<div class="col-sm-12">
											<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
											<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
												<thead>
													<tr>
														<th>Id</th>
														<th>Employee ID</th>
														<th>Attendance Date</th>
														<th>Given By</th>
														<th>Date</th>														
														<th>Note</th>														
													</tr>
												</thead>
												<tbody>	
												</tbody>												
											</table>
										</div>
									</div>
									<?php */ ?>
								</div>
							</div>
						</div>						
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<script>
function calculate_date(){
	let attendance_date = new Date($('#attendate_date').val());
	attendance_date.setHours(0,0,0,0);
	let today = new Date();
	today.setHours(0,0,0,0);
	if(attendance_date < today){
		$('#attendance').html(`<option value="">--select--</option>
								<option value="0.5_half">Half Day</option>
								<option value="absent">Absent</option>`);
	}else{		
		$('#attendance').html(`<option value="">--select--</option>
								<option value="0.5_half">Half Day</option>
								<option value="absent">Absent</option>
								<option value="1">Present</option>
								<option value="1_home">Work From Home</option>`);
	}
	let start_date = $('#attendate_date').val();
	let days = Number($('#how_many_days').val()) - 1;
	if(start_date != '' && days >= 0){
		let result = new Date(start_date);
		result.setDate(result.getDate() + days);
		$('#end_date').val(result.getDate() + '/' + ((result.getMonth() < 9) ? '0'+ (result.getMonth()+1) : (result.getMonth()+1)) + '/' + result.getFullYear());
	}	
}
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/missing_attendance_datatable.php",
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