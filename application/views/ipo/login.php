<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Super Home | Investor Log in</title>
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
  <div class="login-logo">
    <a href="<?=base_url('admin');?>">
		<img src="<?=base_url('assets/img/logo.png');?>" style="width: 150px;padding-top: 15px;" alt="Super Hostel" title="Super Hostel"/>
	</a>
	<h2>Investor Panel</h2>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"> Sign in to start your session </p>

      <form action="<?=current_url(); ?>" method="post">		
		<div class="input-group mb-3">
          <input name="member_card_number" type="text" class="number_int form-control" placeholder="Member Card Number" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="far fa-credit-card"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
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
          <div class="col-4">
            <button name="login" type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
      <p class="mb-1"> <a href="<?=base_url('member/forgot-password'); ?>">I forgot my password</a> </p>
    </div>

  </div>
</div>

<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/select2/js/select2.full.min.js"></script>
<script>
	$(function () {
		$('.number_int').on("input",function(){
			this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
		})
		$('.select2').select2();
	})
</script>  
</body>
</html>
