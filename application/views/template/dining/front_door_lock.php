<div class="content-wrapper">		   
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<div class="form-group" style="margin-top:10px;">
							<input type="number" name="card_number" id="card_number_id" class="card_number_id form-control" style="font-size:30px;color:#f00;font-weight:bolder;" required />
						</div>
						<br />
						<div class="col-sm-12" id="result"></div>
					</div>
					<div class="col-sm-4"></div>
				</div>
				<div class="row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<?php if(!empty($last_member_name)){
							echo '<h3>'.$last_member_name.'</h3>';
						} ?>
						<?php if(!empty($last_member_card)){
							echo '<span>'.$last_member_card.'</span>';
						} ?>
						<?php if(!empty($last_member_img_url)){
							echo '<img src="'.$last_member_img_url.'" style="width:100%;"/>';
						} ?>
						
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	var branch_id = "<?php echo $branch_id; ?>";
	var branch_name = "<?php echo $branch_name; ?>";
	var ip_address = "<?php echo $ip_address; ?>";
	setTimeout(function () {
		$(".card_number_id").focus();
	}, 500);	
	$("#card_number_id").on("keypress",function(){ // 
		var length = $(this).val().length;
		var card_value = $(this).val();
		if(length > 7){
			$.ajax({  
				url:"<?=base_url('assets/ajax/device_json/front_door_lock_member_card_check_from_database.php'); ?>",  
				method:"POST",  
				data:{
					door_open:card_value,
					branch_id:branch_id
				},
				success:function(data){	
					var get_value = data;
					if(get_value == 1){
						$.ajax({  
							url:"<?=base_url('assets/ajax/device_json/front_door_lock_ardinuo.php'); ?>",  
							method:"POST",  
							data:{
								door_open:card_value,
								ip_address:ip_address
							},
							beforeSend:function(){					
								$('#data-loading').html(data_loading);
							},
							success:function(data){
								$('#data-loading').html('');
								var value = data.split('____');
								var success = value[1];
								var card_number = value[2];
								if(success == 'success'){
									$.ajax({  
										url:"<?=base_url('assets/ajax/device_json/sent_front_door_lock_data_to_database.php'); ?>",  
										method:"POST",  
										data:{door_open:card_number},
										success:function(data){							
											$("#result").html('<h1 style="color:#f00;text-align:center;">'+data+'</h1>');
											setTimeout(function () {
												window.open("<?php echo base_url(); ?>dining-table/front-door-lock<?php if(!empty($branch_id_encode)){ echo '/'.$branch_id_encode; }?><?php if(!empty($branch_name_url)){ echo '/'.$branch_name_url; }?>","_self");
											}, 500);
										}  
									});
								}else{
									$("#result").html('<h1 style="color:#f00;text-align:center;">Door Lock Syatem Not Connected!</h1>');
									setTimeout(function () {
										window.open("<?php echo base_url(); ?>dining-table/front-door-lock<?php if(!empty($branch_id_encode)){ echo '/'.$branch_id_encode; }?><?php if(!empty($branch_name_url)){ echo '/'.$branch_name_url; }?>","_self");
									}, 500);
								}
							}  
						});
					}else{
						$("#result").html('<h1 style="color:#f00;text-align:center;">Card number did not matched!</h1>');
						setTimeout(function () {
							window.open("<?php echo base_url(); ?>dining-table/front-door-lock<?php if(!empty($branch_id_encode)){ echo '/'.$branch_id_encode; }?><?php if(!empty($branch_name_url)){ echo '/'.$branch_name_url; }?>","_self");
						}, 500);
					}
				}  
			});
		}
	})
})
</script>