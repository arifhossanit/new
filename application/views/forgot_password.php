<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Super Home | Forgot Password</title>
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
					<p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
					<form action="<?=current_url(); ?>" method="post">	
						<div class="input-group mb-3">
							<input name="phone_number" autocomplete="off" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" minlength="11" maxlength="11" class="form-control" placeholder="Ex: 01XXXXXXXXX (Phone Number)" required />
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-mobile-alt"></span>
								</div>
							</div>
						</div>
						<div class="input-group mb-3">
							<input name="employee_id" type="text" autocomplete="off" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control" placeholder="Employee Id" required />
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user-tie"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<button name="request_new_password" type="submit" class="btn btn-primary btn-block">Request new password</button>
							</div>
						</div>
					</form>

					<p class="mt-3 mb-1">
						<a href="<?=base_url('admin/login'); ?>">Login</a>
					</p>
					<p class="mb-0">
						<a href="<?=base_url('employee-information-form/new-employee-details-form'); ?>" target="_blank" class="text-center">Request For Employee ID</a>
					</p>
				</div>
			</div>
		</div>
		<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
		<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>
	</body>
</html>
