<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Request For Cancel</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('member'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Request For Cancel</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<form id="cencel_requiest_form" method="post">
						<div class="card card-danger">
							<div class="card-header">
								<h4>Please Read Carefully</h4>
							</div>
							<div class="card-body">
								<?php if(!empty($booking_info) AND $booking_info->status == '2'){ ?>
								<div class="row">
									<h3 style="color:#f00;text-align:center;">
										You all ready Requested for your Membership Cancelation
									</h3>
								</div>
								<?php }else{?>
								<div class="row">
									<label style="color:Red;"><i class="far fa-clone"></i> Terms & Conditions</label>
									<div class="form-group" style="min-width:100%;max-height:200px;overflow-y:scroll;text-align:left;float:left;font-weight:500;border: 1px solid #ced4da; border-radius: 5px;padding-top:15px;padding-bottom:15px;">
										<ol class="trm_list">
											<li>We will refund security Deposit money after checkout through Bkash/Cheque/Cash.</li>
											<li>Cheque withdrawal date might be a late date.</li>
											<li>You Can withdraw your cancellation request before checkout.</li>
											<li>Without rent clear, you can't request for cancel</li>											
										</ol>
									</div>
									
									<div class="col-sm-12">
										<label>
											<input type="checkbox" id="accept_trms_condition" onclick="return submit_button_event()" name="transconditions" required style="transform: scale(1.6);"/>
											&nbsp;&nbsp;&nbsp;&nbsp;
											<b style="color:#a50101;">I, hereby acknowledge & agree to abide by the terms and conditions as provided here above. I understand that any violation of the aforesaid terms and conditions may result in the revocation of my access and privileges in the Hostel premises and/or disciplinary actions may be taken along with other legal action. </b>
										<label>
									</div>
									<script>									
										function submit_button_event(){
											if($('#accept_trms_condition').is(':checked')){
												$("#submit_button").css({"display":"block"});
											}else{
												$("#submit_button").css({"display":"none"});
											}
										}									
									</script>
									<div class="col-sm-12" style="margin-top:30px;"></div>
								</div>
								<div class="row">
									<div class="col-sm-4"></div>
									<div class="col-sm-4">
										<div class="card card-default">
											<div class="card-header">
												<h5>Type All Information</h5>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<label>Select CheckOut Date <small style="color:#f00;">*</small></label>
															<?php $number_of_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));?>
															<?php
																
																if($packages->try_us == '1'){
																	$tyu = explode('/',$profile_picture->check_out_date); //check_out_date
																	$min_data = $tyu[2].'-'.$tyu[1].'-'.$tyu[0];
																	$tryus = 1;
																}else{
																	$min_data = date('Y-m').'-'.$number_of_month;
																	$tryus = 0;
																}
																
															?>
															<input type="hidden" name="member_id" value="<?php echo $profile_picture->id; ?>"/>
															<input type="hidden" name="bed_id" value="<?php echo $profile_picture->id; ?>"/>
															<input type="hidden" name="uploader_info" value="<?php echo rahat_encode('Member_'.$profile_picture->email.'_'.$profile_picture->branch_id); ?>"/>
															<input type="date" name="checkout_date" value="" min="<?php echo $min_data; ?>" max="<?php echo $min_data; ?>" class="form-control" required/>
														</div>
													</div>
													<div class="col-sm-12">
														<div class="form-group">
															<label>Cancel Reason <small style="color:#f00;">*</small></label>
															<textarea name="note" placeholder="Cancel Reason" class="form-control" style="height:200px;" required></textarea>
														</div>
													</div>
													<div class="col-sm-12">
														<span id="cencel_request_error_message" style="color:#f00;font-weight:bolder;"></span>
													</div>
													<div class="col-sm-12">
														<?php
															if($tryus == 0){
																if(!empty($rent_info->data) and $rent_info->payment_pattern == '1' ){
																//$rent_d = explode(" ", $rent_info['data']);
																$rent_s = explode('/',$rent_info->data);
																$rent_g = $rent_s[0];
																$rent_m = $rent_s[1];
																if($rent_g <= 10){  
																	$rent_clr = 1;
														?>
																	<span style="color:green;">Your Rent Clear FOR CENCEL </span>		
														<?php  }else{ 
																	$rent_clr = 0; ?>
																	<span style="color:#f00;">Your Rent Not Clear FOR CENCEL </span>		
														<?php 	} 
																} else { 
																$rent_clr = 0;
														?>
																<span style="color:#f00;">Your Rent Not Clear FOR CENCEL </span>	
																
														<?php
																}
															}else{ 
																$rent_clr = 1; ?>
																	<span style="color:#f00;">Your Membership : Try Us </span>	
														<?php 	} ?>
														<span id="cencel_request_error_message" style="color:#f00;font-weight:bolder;"></span>
														<span id="cencel_request_error_message" style="color:#f00;font-weight:bolder;"></span>
														<div class="form-group" id="submit_button" style="display:none;">								
															<button type="submit" id="cencel_request_button" name="save" class="btn btn-success" <?php if($rent_clr == '0'){ echo 'disabled'; } ?> style="float:right;"><i class="fas fa-chalkboard-teacher"></i>  &nbsp;&nbsp;&nbsp;Apply</button>								
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4"></div>
								</div>
								
								<?php } ?>
							</div>
						</div>
					</form>
				</div>				
			</div>
		</div>
	</div>
</div>
<script>
$("#cencel_requiest_form").on("submit",function(){
	event.preventDefault();
	var form = $('#cencel_requiest_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?php echo base_url().'assets/ajax/form_submit/request_for_cencel_submit.php'; ?>",  
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$("#cencel_request_button").prop("disabled", true);
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			var value = data.split('____');
			if(value[1] == '1'){
				$('#cencel_request_error_message').html(value[0]);
				$("#cencel_request_button").prop("disabled", false);
			}else{
				alert(value[0]);
				window.open('<?php echo base_url("member/widthdraw-cancel-request"); ?>','_self');
			}					
		}
	});
	return false;
})
</script>