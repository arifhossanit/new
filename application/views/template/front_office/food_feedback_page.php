<div class="content-wrapper">	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div style="padding-top:100px;">
					<div class="row">
						<div class="col-sm-12">
							<center>
								<h1 style="margin-bottom:70px;">Share Your feeling!</h1>
							</center>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-1"></div>
						<?php
							if(!empty($emoji)){
								foreach($emoji as $row){
						?>
						<div class="col-sm-2">
							<div>
								<center>
									<a onclick="return give_feedback_form('<?php echo $row->feed_back_value; ?>','<?php echo $row->id; ?>')" href="javascript:void(0);">
										<img src="<?php echo base_url($row->emoji_image); ?>" style="" class="custom_moj_d image-responsive"/>
									</a>
									<p style="margin-bottom:0px;"><?php echo $row->feedback_title_english; ?></p>
									<p><?php echo $row->feedback_title_bangla; ?></p>
								</center>
							</div>
						</div>
						<?php } } ?>
						<div class="col-sm-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="give_feedback_form_modal">
	<div class="modal-dialog modal-xl" >
		<div class="modal-content">
			<div class="modal-body" id="give_feedback_form_result">
				
			</div>
		</div>
	</div>
</div>
<style>
.custom_moj_d{
	width:200px;
	height:200px;
}
.custom_moj_d:hover{
	transform:scale(1.2);
	transition:0.3s;
}
</style>
<script>
function give_feedback_form(value,id){
	if(value != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/give_feedback_form_option.php');?>",  
			method:"POST",
			data:{ value:id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');				
				$('#give_feedback_form_result').html(data);
				$("#give_feedback_form_modal").modal('show');
			}  
		});	
	}
}
</script>