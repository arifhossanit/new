<?php
include("../../../application/config/ajax_config.php");
$ipo_id = $_POST['ipo_id'];
$member = mysqli_fetch_assoc($mysqli->query("SELECT card_number, personal_phone_number from ipo_member_directory where ipo_id = '$ipo_id'"));
echo json_encode(array(
    'card_number' => $member['card_number'],
    'personal_phone_number' => $member['personal_phone_number'],
));
// echo $member['card_number'];
