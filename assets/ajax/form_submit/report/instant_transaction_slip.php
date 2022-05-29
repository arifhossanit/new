<?php
include("../../../../application/config/ajax_config.php");
$utime = sprintf('%.4f', microtime(TRUE)); 
$raw_time = DateTime::createFromFormat('U.u', $utime);  
$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
$slip_id = $raw_time->format('dmy-his-u');

$change_ids = implode(", ", $_POST['slip_id']);

$validate = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(DISTINCT(branch_id)) as validate, branch_id from instant_transaction_logs where id in ( $change_ids )"));

if($validate['validate'] > 1){
    echo json_encode(array(
        'error' => '1',
        'message' => 'Two Different Selected!',
    ));
    return;
}

$insert = $mysqli->query("INSERT into instant_transaction_slip_logs (slip_id, employee_id, branch_id) values ('$slip_id', '".$_SESSION['super_admin']['employee_ids']."', '".$validate['branch_id']."')");

$mysqli->query("UPDATE instant_transaction_logs set slip_id = '$slip_id' where id in ( $change_ids )");

echo json_encode(array(
    'error' => '0',
    'message' => $slip_id,
));
return;