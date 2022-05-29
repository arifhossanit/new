<div class="content-wrapper">		   
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
					<form id="card_check_form" action="#" method="post">
						<div class="form-group" style="margin-top:10px;">
							<input type="text" name="card_number" id="card_number_id" class="number_int form-control" style="font-size:30px;color:#f00;font-weight:bolder;" required autocomplete="off"/>
						</div>
					</form>
					</div>
					<div class="col-sm-4"></div>
				</div>
			</div>
			<div class="row" style="width:100%;">
				<div class="col-sm-2" style="width:100%;min-height:700px;max-height:700px;overflow-y:scroll;background-color:#eee;">

				</div>
				<div class="col-sm-8" style="">
					<div class="row">
						<div class="col-sm-12" id="result"></div>
					</div>
					<div class="row" style="position: absolute; width: 100%; bottom: 0%;">
						<div class="col-sm-4">
							<center>
								<h1><i class="fas fa-cloud-sun"></i> &nbsp;Sehri/Breakfast</h1>
								<span style="font-size: 120px; font-weight: bolder; color: #f00;line-height: 100px;">
									<?php 
										if(!empty($breakfast)){
											$i = 1;
											$brk_tot = 0;
											foreach($breakfast as $row){
												$brk_tot = $brk_tot + $i;
											}
											echo $brk_tot; 
										}else{ 
											echo '0';
										}
									?>
								</span>
							</center>
						</div>
						<div class="col-sm-4">
							<center>
								<h1><i class="fas fa-sun"></i> &nbsp;Lunch/Iftar</h1>
								<span style="font-size: 120px; font-weight: bolder; color: #f00;line-height: 100px;">
									<?php 
										if(!empty($lunch)){
											$j = 1;
											$brk_tot = 0;
											foreach($lunch as $row){
												$brk_tot = $brk_tot + $j;
											}
											echo $brk_tot; 
										}else{ 
											echo '0';
										}
									?>
								</span>
							</center>
						</div>
						<div class="col-sm-4">
							<center>
								<h1><i class="fas fa-cloud-moon"></i> &nbsp;Dinner</h1>
								<span style="font-size: 120px; font-weight: bolder; color: #f00;line-height: 100px;">
									<?php 
										if(!empty($dinner)){
											$k = 1;
											$brk_tot = 0;
											foreach($dinner as $row){
												$brk_tot = $brk_tot + $k;
											}
											echo $brk_tot; 
										}else{ 
											echo '0';
										}
									?>
								</span>
							</center>
						</div>
					</div>
				</div>
				<div class="col-sm-2" id="quee_member" style="width:100%;min-height:700px;max-height:700px;overflow-y:scroll;background-color:#eee;">

				</div>
			</div>
		</div>
	</div>
</div>
<audio controls style="display: none;">
	<source id="source" src="" type="audio/mpeg">
</audio>
<script>
$('document').ready(function(){
	setTimeout(function () {
		$("#card_number_id").focus();
		$("#card_number_id").css({"background-color":"green","color":"white"});
	}, 1500);	
	var branch_id = '<?php echo $branch_id; ?>';
	var acval = '1';
	$.ajax({  
		url:"<?=base_url('assets/ajax/dining/dining_member_quee_reqult.php');?>",  
		method:"POST",  
		data:{acval:acval,branch_id:branch_id},
		success:function(data){	
			$('#quee_member').html(data); 
		}  
	});	
	$("#card_check_form").on("submit",function(){
		var length = $("#card_number_id").val().length;
		var card_value = $("#card_number_id").val();
		if(length != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/dining/dining_member_card_check_result.php');?>",  
				method:"POST",  
				data:{card_number:card_value,branch_id:branch_id},
				beforeSend:function(){
					//$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					//$('#data-loading').html('');
					var value = data.split('__________');
					$('#result').html(value[0]);
					var noresult_found = '<?php echo base_url("assets/audio/no_result_found.mp3"); ?>';
					var thank_you = '<?php echo base_url("assets/audio/thank_you_e.mp3"); ?>';
					var time_over = '<?php echo base_url("assets/audio/time_over_e.mp3"); ?>';
					if(value[1] == 0){ //no result found
						$('audio #source').attr('src', noresult_found); $('audio').get(0).load(); $('audio').get(0).play();
					}else if(value[1] == 1){ //auto cancel
						$('audio #source').attr('src', noresult_found); $('audio').get(0).load(); $('audio').get(0).play();
					}else if(value[1] == 2){ //time over
						$('audio #source').attr('src', time_over); $('audio').get(0).load(); $('audio').get(0).play();
					}else if(value[1] == 4){ //already take
						$('audio #source').attr('src', noresult_found); $('audio').get(0).load(); $('audio').get(0).play();
					}else{ //thank you
						$('audio #source').attr('src', thank_you); $('audio').get(0).load(); $('audio').get(0).play();
					}
					setTimeout(function () {
						$.ajax({  
							url:"<?=base_url('assets/ajax/dining/dining_member_quee_reqult.php');?>",  
							method:"POST",  
							data:{acval:acval,branch_id:branch_id},
							success:function(data){	
								$('#quee_member').html(data); 
							}  
						});
						window.open('<?php echo current_url(); ?>','_self');
					}, 2000);
				}  
			});
		}
		return false;
	})
})
</script>