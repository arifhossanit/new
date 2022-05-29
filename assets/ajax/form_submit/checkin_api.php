<?php
include("../../../application/config/ajax_config.php");

$get_ip = mysqli_fetch_assoc($mysqli->query("SELECT * from branch_raspberry_ip where branch_id = '".$_SESSION['super_admin']['branch']."'"));
$url = $get_ip['ip_address'].'/super_home/checkin_pi.php';

$get_member_data = mysqli_fetch_assoc($mysqli->query("SELECT * from member_directory where card_number = '".$_POST['card_number']."'"));

// create & initialize a curl session
$curl = curl_init();

// set our url with curl_setopt()
curl_setopt($curl, CURLOPT_URL, $url);

curl_setopt($curl, CURLOPT_POST, 1);

var_dump($get_member_data['card_number']);

// Set Post Fields
$data = array(
    'authorization' => 'raspberry!@#$%',
    'card_number' => $get_member_data['card_number'],
    'branch' => $get_member_data['branch_id'],
    'name' => $get_member_data['full_name'],
    'image_link' => 'http://erp.superhostelbd.com/super_home/' . $get_member_data['photo_avater'],
);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

// curl_exec() executes the started curl session
// $output contains the output string
$output = curl_exec($curl);

// close curl resource to free up system resources
// (deletes the variable made by curl_init)
curl_close($curl);