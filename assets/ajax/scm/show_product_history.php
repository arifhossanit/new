<?php
include("../../../application/config/stack.php");
include("../../../application/config/ajax_config.php");
function get_table_name($table){
    switch($table){
        case 'scm_department_stock':
            return 'Department Warehouse';
        case 'scm_product_requisition_uses':
            return 'Using';
        case 'scm_damaged_goods':
            return 'Damaged Good';
        case 'scm_stolen_goods':
            return 'Product Stolen';
        case 'scm_warehouse_product_stock':
            return 'Warehouse';
        default:
            echo "Null!";
    }
}
$stack = new Stack(50);
function get_product_history($table, $id, $mysqli, $stack, $count){
    $get_prev_table = mysqli_fetch_assoc($mysqli->query("SELECT transfer_to_table, transfer_to_table_id, transfer_from_table, transfer_from_table_id, amount, creation_date from scm_product_transfer_log where transfer_to_table = '$table' AND transfer_to_table_id = $id"));
    // print_r($count);
    // if($count > 10){
    //     return;
    // }else 
    if(empty($get_prev_table)){
        return;
    }else{
        $stack->push($get_prev_table);
        get_product_history($get_prev_table['transfer_from_table'], $get_prev_table['transfer_from_table_id'], $mysqli, $stack, ++$count);
    }
}
get_product_history(rahat_decode($_POST['tb']), rahat_decode($_POST['id']), $mysqli, $stack, 1);
$html = '<table class="table table-bordered" id="product_history_datatable" style="width: 100%">
            <thead>
                <tr>
                    <td style="width: 10%;">#</td>
                    <td style="width: 30%;">Used By</td>
                    <td style="width: 30%;">Sent From</td>
                    <td style="width: 30%;">Using From</td>
                </tr>
            </thead>
            <tbody>';
// $stack->pop();
// var_dump($stack);
while(!$stack->isEmpty()){
    $html .= '<tr>';
    $row = $stack->pop();
    if($row['transfer_to_table'] == 'scm_product_requisition_uses'){
        $use_data = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_requisition_uses where id = ".$row['transfer_to_table_id']));
        if($use_data['type'] == 'Branch'){
            $branch_name = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$use_data['branch_id']."'"));
            $html .= '<td><div class="row justify-content-center"><div class="col-md-2 align-self-center"><i class="far fa-building fa-lg"></i><div></div></td><td><p><span class="text-secondary">Used By: </span>'.$branch_name['branch_name'].' - '.$use_data['unit_name'].$use_data['room_name'].'<p></td>';
        }else{
            $employee_name = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where employee_id = '".$use_data['employee_id']."'"));
            $html .= '<td><div class="row justify-content-center"><div class="col-md-2 align-self-center"><i style=" vertical-align: middle;" class="fas fa-user-alt fa-lg"></i><div></div></td><td><p><span class="text-secondary">Used By: </span>'.$employee_name['full_name'].'</p></td>';
        }
    }else if($row['transfer_to_table'] == 'scm_department_stock'){
        $use_data = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_requisition.department_requested_for, scm_department_stock.branch_id FROM `scm_department_stock` INNER JOIN scm_product_requisition_details on scm_product_requisition_details.id = scm_department_stock.scm_product_requisition_details_id INNER JOIN scm_product_requisition on scm_product_requisition.requisition_id = scm_product_requisition_details.requisition_id where scm_department_stock.id = ".$row['transfer_to_table_id']));
        $branch_name = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$use_data['branch_id']."'"));
        $department_name = mysqli_fetch_assoc($mysqli->query("SELECT department_name from department where department_id = '".$use_data['department_requested_for']."'"));
        $html .= '<td><div class="row justify-content-center"><div class="col-md-2 align-self-center"><i class="fas fa-warehouse fa-lg"></i><div></div></td><td><p><span class="text-secondary">Stored in: </span>'.$branch_name['branch_name'].' by '.$department_name['department_name'].'</P></td>';
    }else if($row['transfer_to_table'] == 'scm_warehouse_product_stock'){
        $html .= '<td><div class="row justify-content-center"><div class="col-md-2 align-self-center"><i class="fas fa-warehouse fa-lg"></i><div></div></td><td><span class="text-secondary">Stored in: </span>Warehouse.</td>';
    }else if($row['transfer_to_table'] == 'scm_damaged_goods'){
        $html .= '<td><div class="row justify-content-center"><div class="col-md-2 align-self-center"><i class="fas fa-wrench fa-lg"></i><div></div></td><td>Damaged Product.</td>';
    }else if($row['transfer_to_table'] == 'scm_stolen_goods'){
        $html .= '<td></td><td>Stolen Product.</td>';
    }else if($row['transfer_to_table'] == 'scm_product_requisition_details'){
        $html .= '<td><div class="row justify-content-center"><div class="col-md-2 align-self-center"><i class="fas fa-truck fa-lg"></i><div></div></td><td><span class="text-secondary">Assigned to: </span>Department Requisition.</td>';
    }else{
        $html .= '<td><div class="row justify-content-center"><div class="col-md-2 align-self-center"><i class="fas fa-exclamation fa-lg"></i><div></div></td><td>'.$row['transfer_to_table'].'</td>';
    }
    if($row['transfer_from_table'] == 'scm_product_requisition_uses'){
        $use_data = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_requisition_uses where id = ".$row['transfer_from_table_id']));
        if($use_data['type'] == 'Branch'){
            $branch_name = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$use_data['branch_id']."'"));
            $html .= '<td><p><span class="text-secondary">Sent From: </span>'.$branch_name['branch_name'].' - '.$use_data['unit_name'].$use_data['room_name'].'</p></td>';
        }else{
            $employee_name = mysqli_fetch_assoc($mysqli->query("SELECT full_name from employee where employee_id = '".$use_data['employee_id']."'"));
            $html .= '<td><p><span class="text-secondary">Sent From: </span>'.$employee_name['full_name'].'</p></td>';
        }
    }else if($row['transfer_from_table'] == 'scm_department_stock'){
        $use_data = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_requisition.department_requested_for, scm_department_stock.branch_id FROM `scm_department_stock` INNER JOIN scm_product_requisition_details on scm_product_requisition_details.id = scm_department_stock.scm_product_requisition_details_id INNER JOIN scm_product_requisition on scm_product_requisition.requisition_id = scm_product_requisition_details.requisition_id where scm_department_stock.id = ".$row['transfer_from_table_id']));
        $branch_name = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$use_data['branch_id']."'"));
        $department_name = mysqli_fetch_assoc($mysqli->query("SELECT department_name from department where department_id = '".$use_data['department_requested_for']."'"));
        $html .= '<td><p><span class="text-secondary">Sent From: </span>'.$branch_name['branch_name'].' by '.$department_name['department_name'].'</p></td>';
    }else if($row['transfer_from_table'] == 'scm_warehouse_product_stock'){
        $html .= '<td><span class="text-secondary">Stored in: </span>Warehouse.</td>';
    }else if($row['transfer_from_table'] == 'scm_damaged_goods'){
        $html .= '<td>Damaged Product.</td>';
    }else if($row['transfer_from_table'] == 'scm_stolen_goods'){
        $html .= '<td>Stolen Product.</td>';
    }else if($row['transfer_from_table'] == 'scm_product_requisition_details'){
        $html .= '<td>Sent by SCM</td>';
    }else{
        $html .= '<td>'.$row['transfer_from_table'].'</td>';
    }
    $html .= '<td>'.date_format(new DateTime($row['creation_date']),"d/m/Y H:i:s").'</td>';
    $html .= '</tr>';
}
$html .= '<tbody></table>';
// var_dump($stack);
echo $html;