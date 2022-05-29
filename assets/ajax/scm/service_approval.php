<?php
include("../../../application/config/ajax_config.php");
// $info = array(
//     'error' => true,
//     'message' => '',
// );
// echo json_encode($info);
// exit();
if($_POST['approval_type'] == 'approve'){
    $status = '2';
}else if($_POST['approval_type'] == 'reject'){
    $status = '0';
}
$error = false;
$message = "Successfull";
$update = $mysqli->query("UPDATE scm_service_requisition set `status` = $status where id = ".$_POST['approval_of']);
$insert_approval_note = $mysqli->query("INSERT INTO `scm_service_requisition_approval_logs` (`service_requisition_id`, `note`, `uploader`, `updated_at`) VALUES (".$_POST['approval_of'].", '".$_POST['note']."', '".$_SESSION['super_admin']['employee_ids']."', '".date('Y-m-d H:i:s')."')");
if(mysqli_error($mysqli)){
    $error = true;
    $message = mysqli_error($mysqli);
}
$info = array(
    'error' => $error,
    'message' => $message,
);
echo json_encode($info);