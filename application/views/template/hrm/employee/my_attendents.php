<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">My Attendance</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item active">My Attendance</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				
				<div class="col-sm-12" style="padding-top:20px;">				
					<div class="card card-primary">
						<div class="card-header">
							<div class="col-sm-12" style="padding-top:20px;">				
								<div class="row">
									<div class="col-sm-6">
										<h3 class="card-title">My Attendance</h3>
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
						<div class="card-body" id="attendence_result">
							
						</div>
					</div>			
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
var employee_id = "<?php echo rahat_encode($_SESSION['user_info']['employee_id']); ?>";
function years_change(){
	var years = $("#years_id").val();
	return get_employee_attendance_information(employee_id,years);
}
$('document').ready(function(){
	var years = $("#years_id").val();
	return get_employee_attendance_information(employee_id,years);
})
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