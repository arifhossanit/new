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
	<body >
		<div class="container-fluid">  
			<div class="row">
				<div class="col-md-12">
                    <div style="max-width:700px;
                                margin-right:auto;
                                margin-left:auto;
                                background-image: linear-gradient(to bottom right, #330202, #4c07ed);
                                margin-top:30px;
                                min-width:85vw;
                                color:white;">
                        <center style="font-weight: 700;font-size:16pt;padding-top:50px;">
                            <i class="fab fa-android" style="font-size: 20pt;color:#17c2ae;"></i>  <span style="margin-left: 20;">  App Version : 0.0.5</span>
                        </center>
                        <ul style="margin-top:50px;list-style: none;">
						<li style="list-style: none;"><i class="fas fa-arrow-right"> </i> 
							Company Phonebook with on duty check
						</li>
						<li style="list-style: none;"><i class="fas fa-arrow-right"> </i> 
							Option to launch QR code from launcher Icon
						</li>
						<li style="list-style: none;"><i class="fas fa-arrow-right"> </i> 
							UI change
						</li>
						<li style="list-style: none;"><i class="fas fa-arrow-right"> </i> 
							Reset password
						</li>
						<li style="list-style: none;"><i class="fas fa-arrow-right"> </i> 
							Admin Menu improvement
						</li>
						<li style="list-style: none;"><i class="fas fa-arrow-right"> </i> 
							Major bug fixes
						</li>

                        </ul>
                        <center>
                            <img src="<?php print base_url('assets/img/neways-apk.png') ?>" alt="">
                        </center>
                        <center>
                            <a href="http://erp.superhostelbd.com/downloadapp/neways3.apk">
                            <button class="btn btn-info" style="margin-top: 40px;">Update</button>
                            </a>
                        </center>
                        <center style="padding-top: 15px;padding-bottom:10px;">
                            <small>Developed By <span style="color:lawngreen;">Neways</span> S & IT</small>
                        </center>
                    </div>
                </div>
			</div>
		</div>
		<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
		<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>
	</body>
</html>