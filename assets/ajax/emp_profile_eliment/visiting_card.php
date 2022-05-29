<div class="tab-pane" id="visiting_card">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Visiting Card</h3>							
				</div>
				<div class="card-body" id="visiting_card_result">
					
				</div>
			</div>	
		</div>
	</div>
</div> 
<script>
var employee_id = "<?php echo rahat_encode($row['id']); ?>";
$('document').ready(function(){
	return get_employee_visiting_card(employee_id);
})
function get_employee_visiting_card(em_id){
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/data_table/employee_visiting_card_from_profile.php';?>",  
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