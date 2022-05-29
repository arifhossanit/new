<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['confirm_otp'])){
	if($_POST['confirm_otp'] == $_SESSION['investor_otp_number']){
		$html = '<div class="card-header">
					<h3 class="card-title">Change Password</h3>
				</div>
				<form action="'.$home.'ipo-member/change-password" method="post">
					<div class="card-body">
						<div class="form-group">
							<label>Old Password</label>
							<input name="old_password" type="password" class="form-control" placeholder="Old Password" required/>
						</div>
						<div class="form-group">
							<label>New Password</label>
							<input name="new_password" type="password" class="form-control" placeholder="New Password" required/>
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" required/>
						</div>
					</div>
					<div class="card-footer">								
						<button name="change_password" type="submit" class="btn btn-primary" style="float:right;">Change Password</button>
					</div>
				</form>';
		$error = 'none';
	}else{
		$html = '';
		$error = 'mismatch';
	}
	$info = array(
		'html' => $html,
		'error' => $error,
	);
	echo json_encode($info);
}

?>