<?php
include("../../../application/config/ajax_config.php");
$insert_log = $mysqli->query("INSERT INTO `scm_vehicle_driver_log`(`service_product_details_id`, `driver_id`, `started_from`, `created_at`, `created_by`, `note`, `status`) VALUES (".$_POST['driver_of'].", ".$_POST['driver'].", '".$_POST['starting_from']."', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."', '".$_POST['note']."', 1)");
$inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_vehicle_driver_log"));
if($_POST['existing_driver'] != 0){
    $update_old = $mysqli->query("UPDATE scm_vehicle_driver_log set end_date = '".date('Y-m-d')."', status = 0 where id = ".$_POST['existing_driver']);
}
$update = $mysqli->query("UPDATE scm_service_product_details set driver = '".$inserted_id['max_id']."' where id = ".$_POST['driver_of']);
if(mysqli_error($mysqli)){
    echo mysqli_error($mysqli);
}else{
    echo 'done';
}