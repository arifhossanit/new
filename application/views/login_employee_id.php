<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Super Home | Log in</title>
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
			.desktop-qrcode{
				position: relative;
				left: -60px;
				background-color: #eceff1;
				border-radius: 5px;
				padding: 5px;
				display: inline-block;
				transition: 500ms;
				opacity: 85%;
				box-shadow: 0px 0px 5px #b0bec5;
			}
			.desktop-qrcode:hover{
				opacity: 100%;
				box-shadow: 0px 0px 9px #b0bec5;
			}
			.desktop-qrcode img{
				width: 40px;
			}
			#reload_qr_code > div > i:hover{
				text-shadow: 0px 0px 5px #b0bec5;
			}
			@media only screen and (max-width: 600px) {
				.desktop-qrcode{
					left: -40px;
					bottom: 5px;
				}
			}
		</style>
	</head>
	<body class="login-page">
<?php
	if (isset($_SESSION['message_time']) && (time() - $_SESSION['message_time'] > 01)) {unset($_SESSION['alert_message']);}
	if(!empty($_SESSION['alert_message'])){echo $_SESSION['alert_message'];}
?>
		<div class="row align-items-center mt-5" >
			<div class="col-md-12">
				<input type="hidden" id="input_type" value="app">
				<div class="desktop-qrcode" onclick="employy_id_qr_code()"><img id="type_icon" src="<?=base_url('assets/img/login/mobile.png');?>" alt="" ></div>
			
				<div class="card">
					<div class="card-body login-card-body">
						<div class="login-logo">
							<a href="<?=base_url('admin');?>">
								<img src="<?=base_url('assets/img/neways.png');?>" style="width: 150px;padding-top: 15px;" alt="Super Hostel" title="Super Hostel"/>
							</a>
						</div>
						<span id="app_login">
							<p class="text-center">Scan QR Code From Your App to Login</p>
							<div class="row justify-content-center" id="reload_qr_code" style="display: none;">
								<div class="col-md-1 text-info"><i class="fas fa-redo" onclick="relaod_qr_code()"></i></div>
							</div>
							<div class="row justify-content-center">
								<div class="col-md-12">
									<img style="width:250px;border: 1px #eee solid;" id="app_image" src="" class="image-responsive"/>
								</div>
							</div>
						</span>
						<span id="desktop_login" style="display: none">
							<p class="login-box-msg"> Sign in to start your session </p>
							<form action="<?=current_url(); ?>" method="post" style="margin-bottom:20px;">		
								<div class="input-group mb-3">
									<input name="employee_id" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')" type="text" autocomplete="off" class="form-control" placeholder="Employee ID" required>
									<div class="input-group-append">
										<div class="input-group-text">
											<span class="fas fa-user"></span>
										</div>
									</div>
								</div>						
								<div class="row">
									<div class="col-12">
										<button name="set_employee_id" type="submit" class="btn btn-primary" style="float:right;">Next</button>
									</div>
								</div>
							</form>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
				<center>
					<button class="btn btn-info" data-toggle="modal" data-target="#downloadAppModal">Download <i class="fab fa-android"></i> App</button>
				</center>
		</div>
		<!--App Download Modal start -->
		<div class="modal fade" id="downloadAppModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="padding-top:10px;">
						<center>
							<span style="text-align: center;font-size:15pt;font-weight:800;color:maroon;">
								Scan this QR-Code to download <span style="color:darkturquoise">Neways3</span> App
							</span>
						</center>
					<div class="modal-body" style="margin-bottom: 20px;">
						<center>
							<img src="<?php print base_url('assets/img/neways-apk.png') ?>" alt="" style="width: 200px;height: 200px;">
						</center>
						<center style="padding-top:10px;">
							<span style="font-size:18pt;color:firebrick;font-weight:700;">or</span>
						</center>
						<center>
							<a href="http://erp.superhostelbd.com/downloadapp/neways3.apk">
								<button class="btn btn-info" style="margin-top: 10px;">Download</button>
							</a>
						</center>
					</div>
						<span style="font-size:small;text-align:center;padding-bottom:10px;">
							<b>NB:</b> <span style="color:green;">Don't worry if you see any warning message while downloading this app.</span>
						</span>
				</div>
			</div>
		</div>
		<!--App Download Modal end -->
		<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
		<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>

		
		<script>
			var source;
			let employy_id_qr_code = () => {
				let input_type = $('#input_type').val();
				console.log(input_type);
				if(input_type === 'desktop'){
					$('#desktop_login').show();
					$('#app_login').hide();
					$('#input_type').val('app');
					$('#type_icon').attr('src', '<?=base_url('assets/img/login/mobile.png');?>' + '?rand=' + Math.random());
					source.close();
					return;
				}

				if(input_type === 'app'){
					$.ajax({  
						url:"<?=base_url('assets/ajax/get_app_login_otp.php');?>",  
						method:"POST",
						success:function(data){	
							$('#app_image').css('filter', 'blur(0)');
							let info = JSON.parse(data);
							$('#app_image').attr('src', info.url);
							$('#desktop_login').hide();
							$('#app_login').show();
							$('#input_type').val('desktop');
							$('#type_icon').attr('src', '<?=base_url('assets/img/login/desktop.png');?>' + '?rand=' + Math.random());
							setTimeout(()=>{
								$('#app_image').css('filter', 'blur(3px)');
								$('#reload_qr_code').show();
							}, 180000);
							if (!!window.EventSource) {
								source = new EventSource('<?=base_url('assets/ajax/app_login/login_stream.php');?>');
								source.addEventListener('message', function(e) {
									console.log(e.data);
									if(e.data === 'logged_in'){
										window.location.href = "<?= base_url('admin/app-login')?>";
									}
								}, false);
							}
						}  
					});
				}
			}

			let test = () => {
				$.ajax({  
					url:"<?=base_url('assets/ajax/app_login/test.php');?>",  
					method:"POST",
					success:function(data){	
					}  
				});
			}

			let relaod_qr_code = () => {
				location.reload();
			}

			employy_id_qr_code();
		</script>
	</body>
</html>
