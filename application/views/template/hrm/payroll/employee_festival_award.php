<?php
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
?>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Festival Award</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Award</a></li>
						<li class="breadcrumb-item active">Employee Festival Award</li>
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
									Employee Festival Award Info
								</div>
								<div class="card-body">
									<form id="employee_festival_award_form" action="<?php echo current_url(); ?>" method="POST">
										<input type="hidden" name="award_submit_token" value="<?php echo md5(time());?>"/>
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label>Select Year</label>
													<select name="year" id="year" class="form-control select2" required >
														<option value="">--select--</option>
														<?php
															$year = date('Y');
															$year1 = date('Y') + 10;
															for($year; $year <= $year1; $year++){
																echo '<option value="'.$year.'">'.$year.'</option>';
															}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Select Month</label>
													<select id="month" name="month" class="form-control select2">
														<option value="">--select--</option>
														<?php
															for($j = '1'; $j <= 12; $j++){
																if(isset($_POST['month_id']) AND $_POST['month_id'] == $j){
																	$selected = 'selected';
																}else{
																	$selected = '';
																}
																echo '<option value="'.$j.'">'.month_name($j).'</option>';
															}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Select Dates</label>
													<select name="dates[]" id="dates" class="form-control select2" data-placeholder="select dates" multiple required></select>
												</div>
												<div class="form-group">
													<label>Select Reliagion</label>
													<select id="reliagion" name="reliagion" class="form-control select2" required>	
														<option value="All">All</option>	
														<option value="Islam">Islam</option>
														<option value="Hinduism">Hinduism</option>
														<option value="Christianity">Christianity</option>
														<option value="Buddhism">Buddhism</option>
														<option value="Judaism">Judaism</option> 
														<option value="Other">Other</option> 
														<option value="Not Specified">Not Specified</option>
													</select>
												</div>
												<div class="form-group">
													<label>Percentage<small>(% 0 - 100)</small></label>
													<input type="text" name="percentage" value="100" placeholder="Percentage" autocomplete="off" class="number_int form-control" readonly />
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
									Employee Festival Award Logs
									<span id="export_buttons" style="float:right;"></span>
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="booking_data_table">
										<thead>
											<tr>
												<th>Id</th>
												<th>Dates</th>
												<th>Reliagion</th>
												<th>Percentage</th>
												<th>Note</th>
												<th>Uploader</th>
												<th>up:Date</th>
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
$('document').ready(function(){
	$("#employee_festival_award_form").on("submit",function(){
		event.preventDefault();
		var form = $('#employee_festival_award_form')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/dashboard/input_festivle_data_to_database.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$('button[name="save"]').prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('button[name="save"]').prop("disabled", false);
				$('#data-loading').html('');
				alert(data);
				window.open('<?php echo current_url(); ?>','_self');
			}
		});
		return false;
	})
	$('select[name="month"]').on("change",function(){
		var year = $('select[name="year"]').val();
		var month = $('select[name="month"]').val();
		if(year == ''){
			alert('please select year!');
		} else if (month == '') {
			alert('please select Month!');
		} else {
			$.ajax({  
				url:"<?=base_url('assets/ajax/dashboard/get_month_days_ajax.php');?>",  
				method:"POST",  
				data:{month:month,year:year},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					$('#dates').html(data);   
				}  
			}); 	
		}
	})
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_festivle_award_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>