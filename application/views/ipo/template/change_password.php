<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Change Password</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('ipo-member'); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">My Profile</a></li>
						<li class="breadcrumb-item active">Change Password</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<div class="card card-primary" id="change_pass_card">
						<div class="card-header">
							<h3 class="card-title">Confirm Phone Number</h3>
						</div>
						<form action="<?=current_url(); ?>" method="post" id="confirm_phone_number">
							<div class="card-body">
								<div class="form-group" id="test_otp">
									<label>Phone Number</label>
									<div class="row">
										<div class="col-md-8 col-8">
											<input id="confirm_phone" type="text" class="form-control" placeholder="Enter Phone Number" required/>
										</div>
										<div class="col-md-4 col-4 align-self-center">
											<button name="confirm_phone_button" type="submit" class="btn btn-primary" style="float:right;">Send OTP</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="card card-primary">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#confirm_phone_number').on('submit', function () {
		event.preventDefault();
		let confirm_phone = $('#confirm_phone').val();
		console.log(confirm_phone);
		if(confirm_phone != ''){
			$.ajax({
				type: "POST",
				url:"<?=base_url('assets/ajax/option_select/send_otp_investment.php');?>",  
				data: {otp_phn: confirm_phone},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					let info = JSON.parse(data);
					$('#test_otp').html(info.html);
					console.log(info.html);
					// if(info.status[1] == '1'){
					// 	alert(value[0]);
					// 	$("#finish_booking").prop("disabled", false);
					// 	$('#booking_data_table').DataTable().ajax.reload( null , false);
					// }else{
					// 	alert(value[0]);					
					// 	$('#ipo_registration_form').modal('hide');
					// 	$("#finish_booking").prop("disabled", false);
					// 	reset_ipo_registration_form();
					// 	get_ipo_receipt(value[2], value[3], value[4]);
					// 	$('#booking_data_table').DataTable().ajax.reload( null , false);
					// 	//return view_profile_from_booking_1(value[2]);						
					// }				
				}
			});
		}else{
			$('#error_msg').html('Enter Phone Number');
		}
	});
	function go_to_save_js() {
		let confirm_otp = $('#confirm_otp').val();
		$.ajax({
				type: "POST",
				url:"<?=base_url('assets/ajax/option_select/confirm_ipo_member_otp.php');?>",  
				data: {confirm_otp: confirm_otp},
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					let info = JSON.parse(data);
					if(info.error === 'none'){
						$('#change_pass_card').html(info.html);
					}else{
						$('#message_span').html('OTP did not match');
					}
				}
			});
	}
	$(document).ready(function(){
		$('#my_profile').addClass('active');
		$('#change_password_nav').addClass('active');
	});
</script>