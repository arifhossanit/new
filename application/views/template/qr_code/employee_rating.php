<div class="content-wrapper">		   
	<div class="">
		<div class="">
			<div class="" id="result">
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	var get_id = '<?php echo $get_id; ?>';
	if(get_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/qr_code/employee_rating_form_qr_code.php');?>",  
			method:"POST",  
			data:{get_id:get_id},
			beforeSend:function(){					
				// $('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				// $('#data-loading').html('');
				$('#result').html(data); 
			}  
		});
	}
})
</script>