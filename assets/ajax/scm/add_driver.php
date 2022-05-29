<?php
include("../../../application/config/ajax_config.php");
$get_driver_info = mysqli_fetch_assoc($mysqli->query("SELECT scm_vehicle_driver_log.id as log_id, scm_vehicle_driver_log.started_from, employee.full_name, employee.employee_id, scm_service_product_details.driver from scm_service_product_details INNER JOIN scm_vehicle_driver_log on scm_vehicle_driver_log.id = scm_service_product_details.driver INNER JOIN employee on employee.employee_id = scm_vehicle_driver_log.driver_id where scm_service_product_details.id = ".$_POST['driver_of']));
$html = '';
if(!is_null($get_driver_info)){
    $start_date = new DateTime($get_driver_info['started_from']);
    $html .= '<p style="font-size: 18px;"><span class="text-secondary">Assinged Driver: </span>'.$get_driver_info['full_name'].' - '.$get_driver_info['employee_id'].' (from: '.$start_date->format('d-m-Y').')</p>';
    $driver_filter = " AND employee_id != ".$get_driver_info['employee_id'];
    $exists = $get_driver_info['log_id'];
}else{
    $html .= '<p style="font-size: 18px;">No Driver Assigned</p>';
    $driver_filter = "";
    $exists = 0;
}
$get_drivers = $mysqli->query("SELECT full_name, employee_id from employee where `department` = '1383007286312996344' AND `role` = '2207924020933712775'".$driver_filter);
$html .= '<input type="hidden" name="existing_driver" value="'.$exists.'">
        <div class="row">
            <div class="col-sm-6">
                <div class="from-group">
                    <label for="driver">Select driver</label>
                    <select class="form-control" name="driver" id="driver">
                        <option value=""> Update driver </option>';
foreach($get_drivers as $get_driver){
    $html .= '<option value="'.$get_driver['employee_id'].'"> '.$get_driver['full_name'].' </option>';
}
$html .=            '</select>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="starting_from">Starting from</label>
                <input type="text" class="form-control datepicker" autocomplete="off" name="starting_from" id="starting_from" placeholder="Date">
            </div>
            <div class="col-sm-12">
                <textarea class="form-control mt-3" name="note" rows="1" placeholder="Note"></textarea>
            </div>
        </div>';
echo $html;