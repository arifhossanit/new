<?php 
include("../../../application/config/ajax_config.php");
$number = $_POST['phone'];
$otp = rand(1111,9999);
$message = "Super Home Pre-Booking Credential: ".$otp;
$error = false;
$existing = mysqli_fetch_assoc($mysqli->query("SELECT * from pre_booking_directory where phone = '".$number."'"));
if(is_null($existing)){
    if(otp_sendsms($number,$message)){
        $_SESSION['pre_book_otp'] = $otp;   
        $error_message = 'Enter OTP!';
    }else{
        $error = true;
        $error_message = "OTP sent unsuccessfull!";
    }
}else{
    $error = true;
    $error_message = "Phone already exists!";
}

$info = array(
    'error' => $error,
    'message' => $error_message,
);
echo json_encode($info);