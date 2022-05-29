<div class="content-wrapper">		   
	<div class="container">
		<div class="row">
			<div class="col-sm-12" id="result">
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	var booking_id = '<?php echo $card_number; ?>';
	if(booking_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/qr_code/booking_details_information_qr_code.php');?>",  
			method:"POST",  
			data:{booking_id:booking_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#result').html(data); 
			}  
		});
	}

})
</script>