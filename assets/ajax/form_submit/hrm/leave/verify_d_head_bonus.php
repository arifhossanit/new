<?php
include("../../../../../application/config/ajax_config.php");
$get_d_head_department = mysqli_fetch_assoc($mysqli->query("SELECT department from employee where employee_id = ".$_POST['employee_id']." AND d_head = 1"));
$selected_month = new DateTime($_POST['selected_month']);
if(!is_null($get_d_head_department)){
    $verify_d_head_subordinate_performance = mysqli_fetch_assoc($mysqli->query(
        "SELECT count(id) as id_count from employee_performance_logs where department = '".$get_d_head_department['department']."' AND month_year = '".$selected_month->format('m/Y')."'")
    );
    if($verify_d_head_subordinate_performance['id_count'] == 0){
        echo json_encode(array('status' => false, 'count' => $verify_d_head_subordinate_performance['id_count']));
        return;
    }
}
echo json_encode(array('status' => true));