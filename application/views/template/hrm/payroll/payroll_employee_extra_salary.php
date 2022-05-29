<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Extra Salary</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Extra Salary</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>	
	<div class="content">
		<div class="container-fluid">			
			<div class="row justify-content-center">
				<div class="col-sm-3">
					<div class="card card-info">
						<div class="card-header">
							Extra Salary Info
						</div>
						<div class="card-body">
							<form action="<?php echo current_url(); ?>" method="POST">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Select Employee</label>
											<select name="employee_id[]" multiple="multiple" class="form-control select2" required >
												<option value="">--select--</option>
												<?php
													if(!empty($emp_list)){
														foreach($emp_list as $row){
															echo '<option value="'.$row->employee_id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';
														}
													}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Extra Amount</label>
											<input type="test" name="amount" placeholder="Extra Amount" autocomplete="off" class="number_int form-control" required="required"/>
										</div>
										<div class="form-group">
											<label>Extra Salary Reason</label>
											<textarea name="deduction_reason" style="height:150px;" placeholder="Extra Salary Reason" class="form-control"></textarea>
										</div>
										<div class="form-group">
											<label>Extra Salary Month</label>
											<?php
												$check_date = $this->Dashboard_model->mysqlii("select * from employee_sallary_generate_logs where year = '".date('Y')."' order by id desc");
												if(empty($check_date)){
													$year = (int)date('Y') - 1;
													$month = '12';
												}else{
													$year = date('Y');
													$month = sprintf("%02d", $check_date[0]->month);
												}
											?>
											<input type="month" name="month" value="<?php echo date('Y-m'); ?>" min="<?php echo $year.'-'.($month); ?>" class="form-control" required="required"/>
										</div>
										<div class="form-group">
											<label>Note</label>
											<textarea name="note" placeholder="Note" class="form-control"></textarea>
										</div>
										<div class="form-group">
											<button type="submit" name="save" class="btn btn-success" style="float:right;">Save</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-9">
					<div class="card card-success">
						<div class="card-header">
							Extra Salary Logs
							<div id="export_buttons" style="float:right;"></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-2 mb-3">
									<input onchange="change_month(this.value)" class="form-control" type="month" id="month_filter" value="<?php echo date('Y-m'); ?>">
								</div>
								<div class="col-12">
									<table class="table table-sm table-bordered" id="booking_data_table">
										<thead>
											<tr>
												<th>Name</th>
												<th>Extra Amount</th>
												<th>Extra Salary Month</th>
												<th>Extra Salary Reason</th>
												<th>Aproval</th>
												<th>Uploader</th>
												<th>Date</th>
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
	</div>
</div>
<script>
let change_month = (month_filter) => {
	let ajax_data = "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_extra_sallary_datatable.php" + `?month_filter=${month_filter}`;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();
}

$(document).ready(function() {
	let month_filter = $('#month_filter').val();

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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_extra_sallary_datatable.php" + `?month_filter=${month_filter}`,
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>