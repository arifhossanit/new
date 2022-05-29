<?php
include("../../../application/config/ajax_config.php");
$investor_phone = mysqli_fetch_assoc($mysqli->query("SELECT personal_phone_number from ipo_member_directory where card_number = '".$_POST['card_number']."'"));
$otp = rand(1111,9999);
$message = 'SUPER HOME OTP: '.$otp;
if(sendsms($investor_phone['personal_phone_number'], $message)){
    $info = array(
        'html' => '<div class="row">
                        <div class="col-md-6">
                            <input class="form-control" type="number" name="confirm_otp" id="confirm_otp" placeholder="Enter OTP">
                        </div>
                        <div class="col-md-6">
                            <button type="button" onclick="confirm_investor_otp()" class="btn btn-success">Confirm</button>
                        </div>
                    </div>',
        'button' => 'OTP sent'
    );
    $_SESSION['investor_refreshment_otp'] = $otp;
}else{
    $info = array(
        'html' => 'Something went wrong! Please send again!',
        'button' => 'Send OTP'
    );
}
echo json_encode($info);