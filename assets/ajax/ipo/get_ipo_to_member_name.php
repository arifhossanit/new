<?php include("../../../application/config/ajax_config.php");
$card_number = $_POST['card_number'];
$member = mysqli_fetch_assoc($mysqli->query("SELECT personal_full_name from ipo_member_directory where card_number = '$card_number'"));
if($member){
    $member = array(
        'name' => $member['personal_full_name'],
        'member_type' => 'member'
    );
}else{
    $member = mysqli_fetch_assoc($mysqli->query("SELECT personal_full_name from ipo_member_directory_pre where card_number = '$card_number'"));
    if($member){
        $member = array(
            'name' => $member['personal_full_name'],
        );
    }else{
        $member = array(
            'name' => 'No Member Found',
        );
    }
}
echo json_encode($member);