<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Leave Report</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Leave Report</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="row justify-content-center">
			<div class="col-sm-11">
				<div class="card card-info">
					<div class="card-header">
						Leave Request Logs
					</div>
					<div class="card-body">
						<div class="form-group row">
							<div class="col-md-2">
								<label for="start">Select month:</label>
								<input onchange="change_month(this.value)" class="form-control" type="month" id="month" name="month" value="<?php echo date('Y-m'); ?>">
							</div>

							<div class="col-md-2">
								<label for="select_end_date">Select Day:</label>
								<select onchange="change_date(this.value)" class="form-control" name="select_end_date" id="select_end_date">
									<option value="">Select Date</option>
								  	<option value="01">01</option>
								  	<option value="02">02</option>
								  	<option value="03">03</option>
								  	<option value="04">04</option>
								  	<option value="05">05</option>
								  	<option value="06">06</option>
								  	<option value="07">07</option>
								  	<option value="08">08</option>
								  	<option value="09">09</option>
								  	<option value="10">10</option>
								  	<option value="11">11</option>
								  	<option value="12">12</option>
								  	<option value="13">13</option>
								  	<option value="14">14</option>
								  	<option value="15">15</option>
								  	<option value="16">16</option>
								  	<option value="17">17</option>
								  	<option value="18">18</option>
								  	<option value="19">19</option>
								  	<option value="20">20</option>
								  	<option value="21">21</option>
								  	<option value="22">22</option>
								  	<option value="23">23</option>
								  	<option value="24">24</option>
								  	<option value="25">25</option>
								  	<option value="26">26</option>
								  	<option value="27">27</option>
								  	<option value="28">28</option>
								  	<option value="29">29</option>
								  	<option value="30">30</option>
								  	<option value="31">31</option>
								</select>
							</div>


						</div>
						<table class="table table-sm table-bordered" id="datatable">
							<thead>
								<tr>
									<th>#</th>
									<th>Image</th>
									<th>Employee</th>
									<th>Branch</th>
									<th>Department</th>
									<th>Designation</th>
									<th>Start Date</th>
									<th>Date</th> 
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
<script>
function how_many_days_get_result(){
	var start_date = $('input[name="start_date"]').val();
	var how_many_days = $('input[name="how_many_days"]').val();
	if(start_date != '' && how_many_days != ''){
		$.ajax({
			url:"<?php echo base_url('assets/ajax/option_select/hrm/get_employee_days_end_date.php'); ?>",
			data: {start_date:start_date, how_many_days:how_many_days},
			method: "POST",
			beforeSend:function(){
				$("#loading").html('<i class="fas fa-spinner fa-pulse"></i>');
			},
			success:function(data){
				$("#loading").html('');
				$('input[name="end_date"]').val(data);				
			}
		});
	}else{
		alert('Please Select Start date & Type How many days!');
		$('input[name="how_many_days"]').val('');
	}
}

let change_month = (selected_month) => {
	let ajax_data = "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/hr_leave_logs_datatable.php?month=" + selected_month + "&end_date=" + $('#select_end_date').val();
	$('#datatable').DataTable().ajax.url(ajax_data).load();	
}

let change_date= (selected_date) => {
	let ajax_data = "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/hr_leave_logs_datatable.php?month=" + $("#month").val() + "&end_date=" + selected_date;
	$('#datatable').DataTable().ajax.url(ajax_data).load();	
}


$(document).ready(function() {
	var table_booking = $('#datatable').DataTable({
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
		"columnDefs": [
			{
				"targets": [ 17 ], 
				"visible": false
			}
		],
		"ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/hr_leave_logs_datatable.php?month=" + $('#month').val() + "&end_date=" + $('#select_end_date').val(),
	});
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script> 

<!-- <script>
  $("#end_date").change(function(){
  	 var end_date = $("#end_date").val();
  	 alert(end_date);
  });
</script> -->