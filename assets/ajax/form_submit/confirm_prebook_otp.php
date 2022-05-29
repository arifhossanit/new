<?php 
include("../../../application/config/ajax_config.php");
$error_message = "";
$error = false;
if(isset($_SESSION['pre_book_otp'])){
    if($_SESSION['pre_book_otp'] != $_POST['otp_confirm']){
        $error = true;
        $error_message = 'OTP did not match! Enter OTP again!';
    }   
}else{
    $error = true;
    $error_message = "Enter your phone number properly!";
}
$info = array(
    'error' => $error,
    'message' => $error_message,
);
echo json_encode($info);