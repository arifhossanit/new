<?php
include("../../../application/config/ajax_config.php");
$get_requisition_types = $mysqli->query("SELECT scm_service_product_details.description, scm_service_product_details.requisition_type, scm_product_category.name, scm_service_product_details.id from scm_service_product_details INNER JOIN scm_product_category on scm_product_category.id = scm_service_product_details.product_type_id where scm_service_product_details.product_type_id = ".$_POST['requisition_for']);
$html = '';
if(isset($_SESSION['super_admin'])){
    $logged_in_employee = $_SESSION['super_admin']['employee_ids'];
}else{
    $logged_in_employee = $_SESSION['employee_info']['user_id'];
}
foreach($get_requisition_types as $get_requisition_type){
    if(strtolower($get_requisition_type['requisition_type']) == 'hourly'){
        $service_histories = $mysqli->query("SELECT * from scm_service_requisition where service_product_id = ".$get_requisition_type['id']." AND ( end_date LIKE '".$_POST['date']."%' OR start_date LIKE '".$_POST['date']."%' )");
        foreach($service_histories as $service_history){        
            $html .= "<tr>";
            $html .= "<td>".$service_history['id']."</td>";

            // Requested by
            $requested_by = mysqli_fetch_assoc($mysqli->query("SELECT full_name, photo from employee where employee_id = ".$service_history['requisition_by']));
            $html .= '<td><img src="'.$home.$requested_by['photo'].'" alt="" width="50px">';

            $html .= "<td>".$get_requisition_type['name'].' - '.$get_requisition_type['description']."</td>";
            // Time formatting
            $comparing_date = new DateTime($_POST['date']);
            $start_date = new DateTime($service_history['start_date']);
            $end_date = new DateTime($service_history['end_date']);
            $driver_start_date = new DateTime($service_history['driver_start_date']);
            if($driver_start_date > $start_date){
                if($start_date < $comparing_date){
                    $html .= "<td class='text-secondary'><span class='text-danger'>".$driver_start_date->format('d-m-Y h:i A')."</span></td>";
                }else{
                    $html .= "<td class='text-danger'>".$driver_start_date->format('h:i A')."</td>";
                }
            }else{
                if($start_date < $comparing_date){
                    $html .= "<td class='text-secondary'>".$start_date->format('d-m-Y h:i A')."</td>";
                }else{
                    $html .= "<td>".$start_date->format('h:i A')."</td>";
                }
            }            

            // Driver end date will be considered as end date if driver arrived earlier.
            $driver_end_date = new DateTime($service_history['driver_end_date']); // only will work when driver_end_date is less then the requested_end_date
            if($driver_end_date < $end_date){
                $html .= "<td class='text-info'>".$driver_end_date->format('h:i A')."</td>";
            }else if($driver_end_date > $end_date){
                $html .= "<td class='text-danger'>".$driver_end_date->format('h:i A')."</td>";
            }else{
                $html .= "<td>".$end_date->format('h:i A')."</td>";
            }

            // Total duration
            $date_diff = $start_date->diff($end_date);
            $hours = '';
            if($date_diff->h != '0'){
                $hours .= $date_diff->h." Hour, ";
            }
            if($date_diff->i != '0'){
                $hours .= $date_diff->i." Minute, ";
            }
            $hours = rtrim($hours, ', ');
            $html .= "<td>$hours</td>";            

            // Travel history
            $date_diff_driver = $driver_start_date->diff($driver_end_date);
            $html .= "<td>";
            if($service_history['status'] == 0){
                $html .= '<badge class="badge badge-danger">Rejected</badge>';
            }else if($service_history['status'] == 4){
                $driver_start_date = new DateTime($service_history['driver_start_date']);
                $date_diff_driver = $driver_start_date->diff($driver_end_date);
                $hours = '';
                if($date_diff_driver->h != '0'){
                    $hours .= $date_diff_driver->h." Hour, ";
                }
                if($date_diff_driver->i != '0'){
                    $hours .= $date_diff_driver->i." Minute, ";
                }
                $hours = rtrim($hours, ', ');
                if($driver_end_date < $end_date){
                    $history_class = 'text-primary';
                }else if($driver_end_date > $end_date){
                    $history_class = 'text-danger';
                }else{
                    $history_class = '';
                }
                $html .= '<p class="m-0 p-0 '.$history_class.'">'.$hours.'. '.( (int)$service_history['mileage_end'] - (int)$service_history['mileage_start'] ).' Miles</p>';
            }else if($service_history['status'] == 3){
                $html .= '<badge class="badge badge-warning">On rute</badge>';
            }else{
                $html .= '<badge class="badge badge-info">Not Started Yet</badge>';
            }
            $html .= "</td>";
    
            $html .= "<td>".$service_history['destination_from']."</td>";
            $html .= "<td>".$service_history['destination_to']."</td>";
            if($service_history['status'] == 1){
                $html .= "<td>".$service_history['note']."</td>";
            }else if($service_history['status'] == 2){
                $get_approval_note = mysqli_fetch_assoc($mysqli->query("SELECT note from scm_service_requisition_approval_logs where service_requisition_id = ".$service_history['id']." ORDER BY id DESC LIMIT 1"));
                $html .= "<td>".$get_approval_note['note']."</td>";
            }else if($service_history['status'] == 0){
                $get_approval_note = mysqli_fetch_assoc($mysqli->query("SELECT note from scm_service_requisition_approval_logs where service_requisition_id = ".$service_history['id']." ORDER BY id DESC LIMIT 1"));
                $html .= "<td>".$get_approval_note['note']."</td>";
            }else if($service_history['status'] == 3){
                $get_driver_note = mysqli_fetch_assoc($mysqli->query("SELECT note from scm_service_driver_travel_logs where service_requisition_id = ".$service_history['id']." ORDER BY id DESC LIMIT 1"));
                $html .= "<td>".$get_driver_note['note']."</td>";
            }else if($service_history['status'] == 4){
                $get_driver_note = mysqli_fetch_assoc($mysqli->query("SELECT note from scm_service_driver_travel_logs where service_requisition_id = ".$service_history['id']." ORDER BY id DESC LIMIT 1"));
                $html .= "<td>".$get_driver_note['note']."</td>";
            }
            // Requested by
            $html .= "<td>".$requested_by['full_name']."</td>";
    
            // Creation date
            $creation_date = new DateTime($service_history['creation_date']);
            $html .= "<td>".$creation_date->format('d-m-Y h:i:s A')."</td>";
            $html .= "<td>";
            if($service_history['status'] == 1){
                $html .= '<badge class="badge badge-secondary">Pending</badge>';
            }else if($service_history['status'] == 2){
                $html .= '<badge class="badge badge-primary">Approved</badge>';
            }else if($service_history['status'] == 0){
                $html .= '<badge class="badge badge-danger">Rejected</badge>';
            }else if($service_history['status'] == 3){
                $html .= '<badge class="badge badge-warning">On route</badge>';
            }else if($service_history['status'] == 4){
                $html .= '<badge class="badge badge-success">Finished</badge>';
            }
            if($service_history['status'] == 1 OR $service_history['status'] == 2){
                if($logged_in_employee == $service_history['requisition_by']){
                    $html .= '<button data-target="#service_approval" data-toggle="modal" title="Remove" class="btn btn-xs btn-sm btn-danger ml-2" onclick="remove_service_requisition('.$service_history['id'].')"><i class="fas fa-times-circle mr-1"></i>Remove</button>';
                }
            }
            $html .= "</td>";
            $html .= "</tr>";
        }
    }
}

echo $html;