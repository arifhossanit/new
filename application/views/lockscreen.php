<?php
$emp = $this->Dashboard_model->mysqlii("SELECT * FROM employee WHERE id = '".rahat_decode($_SESSION['employee_lock_screen_id'])."' ORDER BY id DESC LIMIT 01");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $emp[0]->full_name; ?> | Lockscreen</title>
		<link rel="icon" href="<?=base_url('assets/img/favicon.png');?>" type="image/gif" sizes="16x16">
		<meta http-equiv="refresh" content="300;url=<?php echo current_url(); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?=base_url('assets/'); ?>plugins/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="<?=base_url('assets/'); ?>dist/css/adminlte.min.css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	</head>
	<body class="hold-transition lockscreen">
	<?php
		if (isset($_SESSION['message_time']) && (time() - $_SESSION['message_time'] > 01)) {unset($_SESSION['alert_message']);}
		if(!empty($_SESSION['alert_message'])){echo $_SESSION['alert_message'];}
	?>
		<div class="lockscreen-wrapper">
			<div class="lockscreen-logo">
				<a href="javascript:void(0)">
					<img src="<?=base_url('assets/img/neways.png');?>" style="width: 150px;border-radius: 7px;" alt="Neways" title="Neways" />
				</a>
			</div>

			<div class="lockscreen-name" style="margin-bottom: 50px;"><?php echo $emp[0]->full_name; ?></div>


			<div class="lockscreen-item">
				<div class="lockscreen-image">
					<img src="<?php echo base_url($emp[0]->photo); ?>" alt="<?php echo $emp[0]->full_name; ?>">
				</div>
				<form class="lockscreen-credentials" action="<?php echo current_url(); ?>" method="POST">
					<div class="input-group">
						<input value="i-" oninput="return fixed_value_f()" type="text" name="last_otp" id="otp_input" class="form-control" placeholder="Last Login OTP" required autocomplete="off" spellcheck="false" title="IBRAHIM"/>
						<input type="hidden" name="employee_id" value="<?php echo rahat_encode(rahat_encode($emp[0]->employee_id)); ?>"/>
						<input type="hidden" name="lock_screen_login" value="<?php echo rahat_encode(rahat_encode('true')); ?>"/>
						<div class="input-group-append">
							<button name="login" type="submit" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
						</div>
					</div>
				</form>
			</div>
		
			<div class="help-block text-center">
				Enter your Last Login OTP to retrieve your session
			</div>
			
			<div class="text-center">
				<a onclick="return login_to_another_account()" href="javascript:void(0);">Or sign in as a different user</a>
			</div>

		</div>
		<script>
			function login_to_another_account(){ var employee_id_login_to_another_account = 1; $.ajax({ url:"<?=base_url('assets/ajax/dashboard/get_employee_lockscreen_session.php');?>", method:"POST", data:{ employee_id_login_to_another_account:employee_id_login_to_another_account }, success:function(data){ window.open("<?php echo base_url('admin/login'); ?>","_self"); } }); } setTimeout(function(){ var input = $('input[name="last_otp"]'); var len = input.val().length; input[0].focus(); input[0].setSelectionRange(len, len); }, 1000); function fixed_value_f(){ if($("#otp_input").val().length > 0 && $("#otp_input").val().substr(0,2) != 'i-' || $("#otp_input").val() == ''){ $("#otp_input").val('i-'); } }
		</script>
		<script src="<?=base_url('assets/'); ?>plugins/jquery/jquery.min.js"></script>
		<script src="<?=base_url('assets/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
