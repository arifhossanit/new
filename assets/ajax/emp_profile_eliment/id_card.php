<div class="tab-pane" id="id_card">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">ID Card</h3>							
				</div>
				<div class="card-body" id="id_card_result">
					
				</div>
			</div>	
		</div>
	</div>
</div> 
<script>
var employee_id = "<?php echo rahat_encode($row['id']); ?>";
$('document').ready(function(){
	return get_employee_attendance_information(employee_id);
})
function get_employee_attendance_information(em_id){
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/data_table/employee_id_card_from_profile.php';?>",  
		method:"POST",  
		data:{
			employee_id:em_id,
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#id_card_result').html(data);    
		}  
	});
}
</script>