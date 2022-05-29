<?php 
include("../../application/config/ajax_config.php");

$bytes = random_bytes(20);
$token = bin2hex($bytes);

$url = $home."json/app-login?key=$token";

$exp_time = new DateTime(date('Y-m-d H:i:s'));
$exp_time->add(new DateInterval('PT5M'));

$mysqli->query("INSERT INTO `app_desktop_login_token` (`token`, `expired_in`) VALUES ('$token', '".$exp_time->format('Y-m-d H:i:s')."')");

$file = "../uploads/qrcode/$token.png";
QRcode::png($url,$file , 'L', '10', 2);

setcookie('token', $token, time() + (300 * 30), '/');

echo json_encode(array(
    'url' => $home."assets/uploads/qrcode/$token.png",
    'token' => $token,
));