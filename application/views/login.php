<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Super Home | Log in <?php print_r($_SESSION['set_employee_id']); ?></title>
		<link rel="icon" href="<?=base_url('assets/img/favicon.png');?>" type="image/gif" sizes="16x16">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?=base_url('assets/');?>plugins/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="<?=base_url('assets/');?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		<link rel="stylesheet" href="<?=base_url('assets/');?>dist/css/adminlte.min.css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		<link rel="stylesheet" href="<?=base_url('assets/');?>plugins/select2/css/select2.min.css">
		<link rel="stylesheet" href="<?=base_url('assets/');?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
		<style>
			.select2-container .select2-selection--single{     
				height: 38px !important;
			}
			.select2-container--default .select2-selection--single{
				border: 1px solid #ced4da !important;
			}
			.select2-container--default .select2-selection--single .select2-selection__arrow{
				height: 36px !important;
			}
		</style>
	</head>
	<body class="hold-transition login-page">
<?php
	if (isset($_SESSION['message_time']) && (time() - $_SESSION['message_time'] > 01)) {unset($_SESSION['alert_message']);}
	if(!empty($_SESSION['alert_message'])){echo $_SESSION['alert_message'];}
?>
		<div class="login-box" style="margin-top: -300px;">  
			<div class="card">
				<div class="card-body login-card-body">
					<div class="login-logo">
						<a href="<?=base_url('admin');?>">
							<img src="<?=base_url('assets/img/neways.png');?>" style="width: 150px;padding-top: 15px;" alt="Super Hostel" title="Super Hostel"/>
						</a>
					</div>
					<div class="login-logo">
						<img src="<?=base_url(rahat_decode($_SESSION['set_employee_id']['employee_photo']));?>" style="width: 100px;height: 100px;border-radius: 50%;" alt="Super Hostel" title="Super Hostel"/>
					</div>
					<p class="login-box-msg"> Sign in to start your session </p>
					<form action="<?=current_url(); ?>" method="post" style="margin-bottom:20px;">		
						<div class="input-group mb-3">
							<input name="sms_otp" type="text" id="otp_input" style="font-size: 30px; font-weight: bolder; color: #009688;" value="i-" autocomplete="off" spellcheck="false" class="form-control" title="IBRAHIM">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						
						<div class="input-group mb-3">
							<input name="password" type="password" class="form-control" placeholder="Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12" style="margin-bottom:20px;">
								<button onclick="return goto_employee_id_page()" type="button" class="btn btn-danger">Back</button>
								<button name="login" type="submit" class="btn btn-primary" style="float:right;">Sign In</button>
							</div>
						</div>						
						<div class="row">
							<div class="col-8">
								<div class="icheck-primary">
									<input type="checkbox" id="remember">
									<label for="remember">
										Remember Me
									</label>
								</div>
							</div>							
						</div>
					</form>
					<p class="mb-1" id="resend_otp">Resend OTP in <span id="time_remaining">01:00</span></p>
					<p class="mb-1"> <a href="<?=base_url('admin/forgot-password'); ?>">I forgot my password</a> </p>
					<p class="mb-0"> <a href="<?=base_url('employee-information-form/new-employee-details-form'); ?>" target="_blank" class="text-center">Request For Employee ID</a> </p>
				</div>

			</div>
		</div>
		<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
		<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>
		<script>
			$(document).ready(function(){
				let time = 59;
				let count_down = setInterval(function () {
					if(time <= 0){
						$('#resend_otp').html('<a onclick="return resend_otp__i(\'<?php echo rahat_encode($_SESSION["set_employee_id"]["employee_id"]); ?>\')" href="#">Resend OTP</a>');
						clearInterval(count_down);
					}
					console.log(time);
					if(time <= 9){
						$('#time_remaining').html('00:0' + time);
					}else{
						$('#time_remaining').html('00:' + time);
					}
					console.log(time);
					time -= 1;
				}, 1000);
				setTimeout(function(){ $('input[name="sms_otp"]').focus(); }, 1000);
			});
			function fixed_value_f(){
				if($("#otp_input").val().length > 0 && $("#otp_input").val().substr(0,2) != 'i-' || $("#otp_input").val() == ''){
					$("#otp_input").val('i-');    
				}				
			}
			function resend_otp__i(otp_id){ if(otp_id != ''){ $.ajax({ url:"<?=base_url('assets/ajax/option_select/distroy_otp_ajax.php');?>", method:"POST", data:{ otp_id:otp_id }, success:function(data){ alert(data); window.open('<?php echo current_url(); ?>','_self'); } }); }else{ alert('Something Wrong! Please Try Again'); } }
			function goto_employee_id_page(){ var go_back = '1'; $.ajax({ url:"<?=base_url('assets/ajax/option_select/distroy_otp_ajax.php');?>", method:"POST", data:{ go_back:go_back }, success:function(data){ window.open('<?php echo current_url(); ?>','_self'); } }); }
		</script>
	</body>
</html>