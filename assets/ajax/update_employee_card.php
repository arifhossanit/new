<?php
include("../../application/config/ajax_config.php");

$validate_card_employee = mysqli_fetch_assoc($mysqli->query("SELECT id, full_name, employee_id from employee where card_number = '".$_POST['new_card']."' AND status = 1"));
if(!is_null($validate_card_employee)){
    echo json_encode(array('error' => true, 'message' => 'Card already assigned to: '.$validate_card_employee['full_name'].' ('.$validate_card_employee['employee_id'].')'));
    return;
}

$validate_card_member = mysqli_fetch_assoc($mysqli->query("SELECT id, full_name from member_directory where card_number = '".$_POST['new_card']."'"));
if(!is_null($validate_card_member)){
    echo json_encode(array('error' => true, 'message' => 'Card already assigned to: '.$validate_card_member['full_name']));
    return;
}

if(isset($_POST['new_card'])){
    $mysqli->query("UPDATE employee set card_number = '".$_POST['new_card']."' where id = ".$_POST['employee_id']);
}
echo json_encode(array('error' => false, 'message' => ''));
return;