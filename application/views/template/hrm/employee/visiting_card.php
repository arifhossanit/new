<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">My Visiting Card</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item active">My Visiting Card</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container">			
			<div class="row">		
				<div class="col-sm-12" style="padding-top:20px;">				
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">My Visiting Card, QR CODE & Link</h3>							
						</div>
						<div class="card-body" id="visiting_card_result">
							
						</div>
					</div>			
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
var employee_id = "<?php echo rahat_encode($_SESSION['user_info']['employee_id']); ?>";
$('document').ready(function(){
	return get_employee_attendance_information(employee_id);
})
function get_employee_attendance_information(em_id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/data_table/employee_visiting_card_from_profile.php');?>",  
		method:"POST",  
		data:{
			employee_id:em_id,
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#visiting_card_result').html(data);    
		}  
	});
}
</script>