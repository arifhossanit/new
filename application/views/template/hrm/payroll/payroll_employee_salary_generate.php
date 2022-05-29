<?php
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
?>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Salary Generate</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Salary Generate</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>	
	<div class="content">
		<div class="container">			
			<div class="row">		
				<div class="col-sm-12">
					<form id="employee_sallary_generate_form" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" id="sallary_token" name="sallary_token" value="<?php echo md5(time())?>"/>
						<div class="row">
							<div class="col-sm-3">
								<select onchange="return function_gate_employee_data_by_year_month();" id="years_id" name="year_id" class="form-control select2"> <!--onchange="return years_change()"-->
									<?php
										$before = date('Y') - 10;
										for($i = $before; $i <= date('Y'); $i++){
											if(isset($_POST['year_id']) AND $_POST['year_id'] == $i){
												$selected = 'selected';
											}else{
												if($i == date('Y')){
													$selected = 'selected';
												}else{
													$selected = '';
												}
											}
											echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
										}
									?>
								</select>
							</div>
							
							<div class="col-sm-3">
								<select onchange="return function_gate_employee_data_by_year_month();" id="month_id" name="month_id" class="form-control select2"> <!--onchange="return years_change()"-->
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
							
							<div class="col-sm-3">
								<select onchange="return get_employee_data();" name="employee_type" class="form-control" data-placeholder="Employee Type">
									
								</select>
							</div>

							<div class="col-sm-3">
								<button type="submit" name="salary_generate" class="btn btn-success" style="width:100%;">View Salary</button>
							</div>
							<textarea name="employee_ids" id="employee_ids" hidden></textarea>
							<input type="hidden" name="employee_type_get" value="" id="employee_type_get"/>
						</div>
					</form>
				</div>
				<div class="col-sm-12" style="margin-top:30px;"></div>
				<div class="col-sm-12">
					<div class="card card-info">
						<div class="card-header">
							<h4>
								Employee Generated Sallary Logs
								<div style="float:right;" id="export_buttons"></div>
							</h4>							
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Month</th>
										<th>Year</th>
										<th>Generate Date</th>
										<th>Generate Time</th>
										<th>Employee Type</th>
										<th>Uploader Info</th>
										<th>Option</th>										
									</tr>
								</thead>
								<tbody>	
								</tbody>								
							</table>
						</div>
					</div>
				</div>
				<div id="result"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="employee_salary_list_modal">
	<div class="modal-dialog modal-xl" style="min-width:100%;margin-top:0px;">
		<div class="modal-content">
			<form id="final_salary_generation" action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Employee Sallary List</h4>
					<button type="button" class="close btn-danger" style="background: #f00; color: #fff;" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="employee_salary_list_modal_result">

				</div>
				<div class="modal-footer">
					<div id="generate_modal_button" style="width: 30%;"></div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>	
function get_employee_data(){
	var get_data = $('select[name="employee_type"]').val();
	if(get_data != ''){
		var value = get_data.split('_____');
		$("#employee_ids").html(value[1]);
		$("#employee_type_get").val(value[0]);
	}else{
		alert('Something wrong to get employee IDs! Please try again from beginning!');
	}
}
function function_gate_employee_data_by_year_month(){
	var year = $('select[name="year_id"]').val();
	var month = $('select[name="month_id"]').val();
	if(year != '' && month  != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/dashboard/get_employee_type_for_salary_generate.php');?>",  
			method:"POST",
			data: {
				year: year,
				month: month
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},			
			success:function(data){
				$('#data-loading').html('');
				$('select[name="employee_type"]').html(data);				
			}  
		});
	}else{
		alert('Please select Year & Month Properly!');
	}
}

function confirm_otp(){
	let otp = $('#confirm_salary_password').val();
	if(otp != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/dashboard/generate_salary_confirm_otp.php');?>",  
			method:"POST",
			data: {otp: otp},
			success:function(data){
				let info = JSON.parse(data);
				if(info.message === 'ok'){
					$('#generate_modal_button').html(info.button);
				}else{
					$('#confirm_salary_otp').addClass('border border-danger');
					$('#otp_error').addClass('text-danger');
					$('#otp_error').html('Password did not match');
				}
			}  
		});
	}	
}
function send_otp(){
	$.ajax({  
		url:"<?=base_url('assets/ajax/dashboard/generate_salary_otp.php');?>",  
		method:"POST",
		success:function(data){	
			$('#generate_modal_button').html(data);
		}  
	});
}
function view_employee_sallary_list(unique_id){
	if(unique_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/dashboard/get_employee_sallary_list.php');?>",  
			method:"POST",  
			data:{unique_id:unique_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#employee_salary_list_modal').modal('show');   
				$('#employee_salary_list_modal_result').html(data);   
			}  
		});
	}
}
$('document').ready(function(){
	$('#employee_sallary_generate_form').on("submit",function(){
		event.preventDefault();
		var form = $('#employee_sallary_generate_form')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/finally_employee_generate_sallary.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#finish_booking").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				let info = JSON.parse(data);
				$('#data-loading').html('');
				if (info.message === undefined){
					console.log(info.total);
					$('#employee_salary_list_modal').modal('show');   
					$('#employee_salary_list_modal_result').html(info.html);
					$('#generate_modal_button').html(info.button);
					var formatter = new Intl.NumberFormat('en-US', {
						style: 'currency',
						currency: 'BDT',

						// These options are needed to round to whole numbers if that's what you want.
						minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
						//maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
					});
					$('#total_salary_amount').html(formatter.format(info.total));
					$('#salary_preview').DataTable({
						'paging': false
					});
				}else{
					alert(info.message);
				}				
			}
		});
		return false;
	})
})
$(document).ready(function() {
	$('#final_salary_generation').on("submit",function(){
		event.preventDefault();
		let year_id = $('#years_id').val();
		let month_id = $('#month_id').val();
		let sallary_token = $('#sallary_token').val();
		console.log(year_id);
		console.log(month_id);
		console.log(sallary_token);
		$.ajax({
			type: "POST",
			url:"<?=base_url('assets/ajax/form_submit/finally_employee_generate_sallary.php');?>",  
			data: {year_id: year_id, month_id: month_id, final_generation: 'yes', sallary_token: sallary_token},
			timeout: 600000,
			beforeSend:function(){
				$("#finish_booking").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				let info = JSON.parse(data);
				alert(info.message);
				$('#employee_salary_list_modal').modal('toggle');   
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}
		});
	})
})
$(document).ready(function() {
	var year = $('select[name="year_id"]').val();
	var month = $('select[name="month_id"]').val();
	$.ajax({  
		url:"<?=base_url('assets/ajax/dashboard/get_employee_type_for_salary_generate.php');?>",  
		method:"POST",
		data: {
			year: year,
			month: month
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},			
		success:function(data){
			$('#data-loading').html('');
			$('select[name="employee_type"]').html(data);				
		}  
	});
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_sallary_generate_logs_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>