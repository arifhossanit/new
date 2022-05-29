<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Super Home | Reset Password</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?=base_url('assets/');?>plugins/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="<?=base_url('assets/');?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		<link rel="stylesheet" href="<?=base_url('assets/');?>dist/css/adminlte.min.css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	</head>
<?php
	if (isset($_SESSION['message_time']) && (time() - $_SESSION['message_time'] > 01)) {unset($_SESSION['alert_message']);}
	if(!empty($_SESSION['alert_message'])){echo $_SESSION['alert_message'];}
?>	
	<body class="hold-transition login-page">
		<div class="login-box" style="margin-top:-300px;">			
			<div class="card">
				<div class="card-body login-card-body">
					<div class="login-logo">
						<a href="<?=base_url('admin');?>">
							<img src="<?=base_url('assets/img/neways.png');?>" style="width: 150px;padding-top: 15px;" alt="Super Hostel" title="Super Hostel"/>
						</a>
					</div>					
					<p class="login-box-msg">Change Password By Your Self</p>
					<form action="<?=current_url(); ?>" method="post">
						<input type="hidden" name="employee_id" value="<?php if(!empty($employee_id)){ echo $employee_id; } ?>"/> 
						<input type="hidden" name="phone_number" value="<?php if(!empty($phone_number)){ echo $phone_number; } ?>"/> 
						<div class="input-group mb-3">
							<input name="new_password" autocomplete="off" type="text" minlength="6" class="form-control" placeholder="New Password" required />
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-key"></span>
								</div>
							</div>
						</div>
						<div class="input-group mb-3">
							<input name="confirm_password" type="text" autocomplete="off"  minlength="6" class="form-control" placeholder="Confirm Password" required />
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-key"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<button name="change_password" type="submit" class="btn btn-primary btn-block">Change Password</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
		<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>
	</body>
</html>
