<?php
header('content-type: image/jpeg');
$font_name="E:/xampp/htdocs/super_home/assets/font/greatvibes.ttf";
$font_date="E:/xampp/htdocs/super_home/assets/font/BebasNeue.ttf";
$start_date = DateTime::createFromFormat('d/m/Y', $start_and_end_date->data);
$expiry_date = DateTime::createFromFormat('d/m/Y', $start_and_end_date->expirity_date);
if($start_date->format('d') == $expiry_date->format('d')){
    $expiry_date->sub(new DateInterval('P1D'));
}


if($total_purchase->total_sum >= 5000000){
    $image = imagecreatefrompng(base_url('/assets/img/gold-certificate.png'));
}else{
    $image = imagecreatefrompng(base_url('/assets/img/silver-certificate.png'));
}

$color = imagecolorallocate($image, 19,21,22);
$name = $member_information->personal_full_name;
$bbox = imagettfbbox(100, 100, $font_name, $name);
$width = abs($bbox[4] - $bbox[0]) * 3;
$x = 2010 - ($width / 2);

// start: 1170; stop: 3050; This is start end of the name underlines
imagettftext($image, 120, 0, $x, 2080, $color, $font_name, $name);
imagettftext($image, 70, 0, 1550, 2440, $color, $font_date, $start_date->format('d-m-Y'));
imagettftext($image, 70, 0, 2450, 2440, $color, $font_date, $expiry_date->format('d-m-Y'));
// $today = date('d-m-Y');
// imagettftext($image, 70, 0, 650, 2680, $color, $font_date, $today);
$path = base_url('/assets/uploads/certificate/'.$name.'.png');
imagepng($image);
imagedestroy($image);