<?php
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
?>
<style>
	/* .select2-selection__rendered {
		line-height: 31px !important;
	} */
	/* .select2-container .select2-selection--single {
		height: 35px !important;
		overflow: visible;
	} */
	/* .select2-selection__arrow {
		height: 34px !important;
	} */
	.select2-choices {
		min-height: 250px !important;
		max-height: 250px !important;
		overflow-y: visible;
	}
	ul.select2-results {
		min-height: 250px !important;
		max-height: 250px !important;
	}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Attendance Overview</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Attendance</a></li>
						<li class="breadcrumb-item active">Attendance Overview</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-12" style="padding-top:20px;">
					<form id="attendance_form" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="view_attendance" value="yes">
						<div class="row">
							<div class="col-sm-1">
								<select id="years_id" name="year_id" class="form-control select2"> <!--onchange="return years_change()"-->
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
							
							<div class="col-sm-1">
								<select id="month_id" name="month_id" class="form-control select2"> <!--onchange="return years_change()"-->
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
							<div class="col-sm-1">
								<select onchange="return custom_employee_type()" id="emp_type" name="emp_type" class="form-control select2">
									<option value="">ALL</option>
									<option value="1">Active</option>
									<option value="2">Exit</option>
									<option value="3">Custom Select</option>
								</select>
							</div>
							<div class="col-sm-3" style="display:none;" id="custom_employee_container">
								<div class="row">
									<div class="col-sm-12">
										<select id="custom_employee_id" name="custom_employee_id[]" multiple class="form-control select2" data-placeholder="select employee">
											<?php
												$get_employee = $this->Dashboard_model->mysqlii("select * from employee");
												if(!empty($get_employee)){
													foreach($get_employee as $row){
														if($row->status == 0){
															$status = ' - Exit';
														}else{
															$status = '';
														}
														echo '<option value="'.$row->employee_id.'">'.$row->full_name.' | '.$row->employee_id.''.$status.'</option>';
													}
												}
											?>
										</select>
									</div>									
								</div>								
							</div>
							<div class="col-sm-1">
								<button name="view_attendance" class="btn btn-success" type="submit" style="width:100%;">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-sm-12" style="padding-top:20px;">				
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">My Attendance</h3>
							<div id="export_buttons_attendance" style="float: right;"></div>
						</div>
						<div class="card-body" id="attendence_result">

						</div>
					</div>			
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
$('#attendance_form').on('submit', function(){
	event.preventDefault();
	var form = $('#attendance_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?=base_url('assets/ajax/attendance_overview_table.php');?>",
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#attendence_result').html(data);
			var table_booking = $('#attendance_data_table').DataTable({
				"paging": true,
				"lengthChange": true,
				"lengthMenu": [
					[10, 25, 50, 100, 500],
					[10, 25, 50, 100, 500]
				],
				"searching": true,
				"ordering": true,
				"info": true,
				"scrollX": true,
				"autoWidth": false,
				"responsive": false,
				"processing": true,
				"serverSide": false,
				dom: 'lBfrtip',
				buttons: [			
					{
						extend: 'copy',
						text: '<i class="fas fa-copy"></i> Copy',
						titleAttr: 'Copy'
					},
					{
						extend: 'excel',
						text: '<i class="fas fa-file-excel"></i> Excel',
						titleAttr: 'Excel'
					},
					{
						extend: 'csv',
						text: '<i class="fas fa-file-csv"></i> CSV',
						titleAttr: 'CSV'
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
						titleAttr: 'Print'
					}
				]
			});
			$('#export_buttons_attendance').html('');
			table_booking.buttons().container().appendTo($('#export_buttons_attendance'));
		}
	});	
});
function custom_employee_type(){
	var emp_type = $("#emp_type").val();
	if(emp_type == '3'){
		$("#custom_employee_container").css({"display":"block"});
	}else{
		$("#custom_employee_container").css({"display":"none"});
	}
}
function years_change(){
	var years = $("#years_id").val();
	var month = $("#month_id").val();
	var emp_type = $("#emp_type").val();
	if( emp_type != 'NaN'){

		return get_employee_attendance_information(years,month,emp_type);
	}
}
//$('document').ready(function(){
//	var years = $("#years_id").val();
//	var month = $("#month_id").val();
//	return get_employee_attendance_information(years,month);
//})
function get_employee_attendance_information(yea,mon,emp_type){
	$.ajax({  
		url:"<?=base_url('assets/ajax/data_table/employee_attendance_overview.php');?>",  
		method:"POST",  
		data:{
			years:yea,
			emp_type:emp_type,
			month:mon
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#attendence_result').html(data);    
		}  
	});
}


$(document).ready(function() {
    var table_booking = $('#attendance_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"info": true,
		"scrollX": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": false,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
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
                titleAttr: 'Print'
            }
        ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons_attendance'));
})
</script>
