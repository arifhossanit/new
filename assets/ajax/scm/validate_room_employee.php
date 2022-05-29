<?php
include("../../../application/config/ajax_config.php");
$error = 'no';
$error_msg = '';
if($_POST['recipient_type'] == 'room'){
    if(strlen($_POST['recipient_type_desc'])){
        $validate = $mysqli->query("SELECT id from rooms where branch_id = '".$_POST['branch_for_department']."' AND unit_name = '".strtoupper($_POST['recipient_type_desc'][0].$_POST['recipient_type_desc'][1])."' AND room_name = '".strtoupper($_POST['recipient_type_desc'][2].$_POST['recipient_type_desc'][3])."' AND status = 1");
        if($validate->num_rows == 0){
            $error = 'yes';
            $error_msg = 'Room does not exits!';
        }
    }else{
        $error = 'yes';
        $error_msg = 'Enter Proper Length!';
    }
}else if($_POST['recipient_type'] == 'employee'){
    $validate = $mysqli->query("SELECT id from employee where branch = '".$_POST['branch_for_department']."' AND employee_id = '".$_POST['recipient_type_desc']."' AND status = 1");
    if($validate->num_rows == 0){
        $error = 'yes';
        $error_msg = 'Employee Does not exists/Not in selected Branch!';
    }
}
$info = array(
    'error' => $error,
    'error_msg' => $error_msg,
);
echo json_encode($info);