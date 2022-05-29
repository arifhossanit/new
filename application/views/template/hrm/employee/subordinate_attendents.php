<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Subordinate Attendance</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item active">Subordinate Attendance</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">				
				<div class="col-sm-3" style="padding-top:20px;">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Subordinates</h3>														
						</div>
						<div class="card-body">
							<select onchange="return years_change()" id="subordinate_id" class="form-control select2">
								<option value="">Select Subordinate</option>
								<?php foreach($subordinates as $subordinate){ ?>
									<option value="<?php echo rahat_encode($subordinate->id)."~".$subordinate->full_name;?>"><?php echo $subordinate->full_name.' '.$subordinate->employee_id; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-9" style="padding-top:20px;">				
					<div class="card card-primary">
						<div class="card-header">
							<div class="col-sm-12" style="padding-top:20px;">				
								<div class="row">
									<div class="col-sm-6">
										<h3 class="card-title">Attendance</h3>
									</div>									
									<div class="col-sm-4"></div>
									<div class="col-sm-2" style="height:0px;margin-top:-17px;">
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
							</div>														
						</div>
						<div class="card-body">
							<div id="employee_name_div" style="display: none;"><p style="font-size: 20px;"> <span class="text-secondary">Name: </span><span id="employee_name" style="font-weight: bold;"></span></p></div>
							<div id="attendence_result"></div>
							<p class="text-center">Select Subordinate!</p>
						</div>
					</div>			
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
function years_change(){
	let temp = $("#subordinate_id").val().split('~');
	var employee_id = temp[0];
	var years = $("#years_id").val();
	console.log(employee_id);
	return get_employee_attendance_information(employee_id,years,temp[1]);
}
function get_employee_attendance_information(em_id,yea,name){
	// return 0;
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
			$('#employee_name_div').show();
			$('#employee_name').html(name);
			$('#attendence_result').html(data);
		}  
	});
}
</script>