<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee MIssing Attendance Overview</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item active">Yearly Attendance Overview</li>
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
						<div class="col-sm-12">
							<div class="card card-info">								
								<div class="card-header">
									<div class="row">
										<div class="col-sm-2">
											<div class="form-group">
												<select onchange="return years_change()" id="employee_id" class="form-control select2" required>
													<option value="">--select employee--</option>
													<?php
													if(!empty($employee)){
														foreach($employee as $row){
															echo '<option value="'.rahat_encode($row->id).'">'.$row->employee_id.' - '.$row->full_name.'</option>';
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group">
												<select onchange="return years_change()" id="years_id" class="form-control select2">
													<?php
														$before = date('Y') - 10;
														for($i = $before; $i <= date('Y'); $i++){
															if($i == date('Y')){
																$selected = 'selected';
															}else{
																$selected = '';
															}
															echo '<option value="'.substr($i,2).'" '.$selected.'>'.$i.'</option>';
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-sm-2">
											<h3 class="card-title"><i class="fas fa-users"></i> Employee Attendance</h3>
										</div>
										<div class="col-sm-6">
											<div id="export_buttons" style="float: right;"></div>
										</div>
									</div>									
								</div>
								<div class="card-body" id="attendence_result">	
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
function years_change(){
	var employee_id = $("#employee_id").val();
	if(employee_id != ''){
		var years = $("#years_id").val();
		return get_employee_attendance_information(employee_id,years);
	}
}
function get_employee_attendance_information(em_id,yea){
	$.ajax({  
		url:"<?=base_url('assets/ajax/data_table/employee_attendance_from_profile.php');?>",  
		method:"POST",  
		data:{
			employee_id:em_id,
			years:yea
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
</script>