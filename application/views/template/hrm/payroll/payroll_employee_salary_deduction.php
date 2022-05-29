<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Salary Deduction</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Salary Deduction</li>
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
					<div class="row">
						<div class="col-sm-3">
							<div class="card card-info">
								<div class="card-header">
									Deduction Info
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
													<label>Deduction Amount</label>
													<input type="test" name="amount" placeholder="Deduction Amount" autocomplete="off" class="number_int form-control" required="required"/>
												</div>
												<div class="form-group">
													<label>Deduction Reason</label>
													<textarea name="deduction_reason" style="height:150px;" placeholder="Deduction Reason" class="form-control"></textarea>
												</div>
												<div class="form-group">
													<label>Deduction Month</label>
													<?php
														$check_date = $this->Dashboard_model->mysqlii("select * from employee_sallary_generate_logs where year = '".date('Y')."' order by id desc");
														$month = (!empty($check_date)) ? sprintf("%02d", $check_date[0]->month) : date('m');
														$min_year = (int)date('Y') - 1;
													?>
													<input type="month" name="month" value="<?php echo date('Y-m'); ?>" min="<?php echo $min_year.'-'.$month; ?>" class="form-control" required="required"/>
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
									Deduction Logs
									<div id="export_buttons" style="float:right;"></div>
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="booking_data_table">
										<thead>
											<tr>
												<th>Name</th>
												<th>Deduction Amount</th>
												<th>Deduction Month</th>
												<th>Deduction Reason</th>
												<th>Aproval</th>
												<th>Uploader</th>
												<th>Date</th>
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
<script>
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ],
		"searching": true,
		"ordering": true,
		"order": [[ 2, "desc" ]],
		"columnDefs": [
            {
                "targets": [ 8 ],
                "visible": false,
            },
        ],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_deduction_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>