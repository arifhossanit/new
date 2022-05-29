<?php
include("../../../application/config/ajax_config.php");
// file_upload($_POST['document']);
// var_dump($_FILES['document']['name']);
// return;
$validate = $mysqli->query("SELECT id from scm_service_product_billing where `month` = ".$_POST['month']." AND `year` = ".$_POST['year'] . " AND service_product_id = " . $_POST['bill_of']);
$error = false;
$message = 'Success!';
if($validate->num_rows > 0){
    $error = true;
    $message = 'This Months Bill Already Submitted!';
}else{
    $document = file_upload_service('document');
    $insert_data = $mysqli->query("INSERT INTO `scm_service_product_billing` (`service_product_id`, `month`, `year`, `amount`, `document`, `status`, `note`, `created_by`, `created_at`) VALUES ('".$_POST['bill_of']."', '".$_POST['month']."', '".$_POST['year']."', '".$_POST['amount']."', '".$document."', '1', '".$_POST['note']."',  '".$_SESSION['super_admin']['employee_id']."',  '".date('Y-m-d H:i:s')."')");
}
if(mysqli_error($mysqli)){
    $error = true;
    $message = '<p class="p-0 m-0">Something went wrong!</p><p class="p-0 m-0">Error: <span class="text-secondary">'.mysqli_error($mysqli).'</span></p>';
}
$info = array(
    'error' => $error,
    'message' => $message,
);
echo json_encode($info);