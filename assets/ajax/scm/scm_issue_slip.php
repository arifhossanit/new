<?php
include("../../../application/config/ajax_config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$requisition_id = $_POST['requisition_id'];
$requisition_information = mysqli_fetch_assoc($mysqli->query("SELECT employee.full_name, department.department_name, branches.branch_code, scm_product_requisition.* from scm_product_requisition
INNER JOIN branches on branches.branch_id = scm_product_requisition.branch_requested_for
INNER JOIN department on department.department_id = scm_product_requisition.department_requested_for
INNER JOIN employee on employee.employee_id = scm_product_requisition.requested_by
where scm_product_requisition.requisition_id = '".$requisition_id."' "));
$order_date = new DateTime($requisition_information['requested_on']);  
$warehosue_exit = new DateTime($requisition_information['warehouse_exit_date']);  
$html = '<div class="row justify-content-between">
            <div class="col-print-12 text-center">
                <div class="row">
                    <div class="col-print-1">
                        <img width="140px" src='.$home.'assets/img/neways.png>
                    </div>
                    <div class="col-print-10">
                        <p style="font-size: 25px;font-weight: 700; margin-bottom: 0;">Neways International Company Limited</p>
                        <p style="font-size: 18px;font-weight: 500; margin-top: 0">House: 2/KA/10, Mymensingh Road, Shahbag, Dhaka-1000</p>
                    </div>
                    <div class="col-print-1">
                    </div>
                </div>
            </div>
            <div class="col-print-12 text-center">
                <p style="font-size: 25px;text-decoration: underline;font-weight: 700; margin-bottom: 0;">WAREHOUSE MATERIAL ISSUE SLIP</p>
            </div>
            <div class="col-print-4">
                <div class="row">
                    <div class="col-print-12">
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">To: '. $requisition_information['branch_code'] .'</p>
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">Department: '.$requisition_information['department_name'].'</p>
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">Responsible Person: '.$requisition_information['full_name'].'</p>
                    </div>
                </div>
            </div>
            <div class="col-print-3">
                <div class="row">
                    <div class="col-print-12">
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">Date Received: '.$warehosue_exit->format('d/m/Y').' </p>
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;">Date Required: '.$order_date->format('d/m/Y').'</p>
                        <p style="font-size: 18px;font-weight: 500;margin-bottom: 0px;"></p>
                    </div>
                </div>
            </div>
            </div>
            <div class="row justify-content-between mt-3">
            <div class="col-print-12">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <th>Sl</th>
                        <th style="width: 50%;">Item Description</th>
                        <th>Quantity (Required)</th>
                        <th>Quantity (Received)</th>
                    </thead>
                    <tbody>';
$order_details = $mysqli->query("SELECT scm_scales.name as scale_name, scm_brands.name as brand_name, scm_products.*, scm_product_requisition_details.approved_amount, scm_product_requisition_details.sent_amount, scm_product_requisition_details.color, scm_product_requisition_details.product_size, scm_product_requisition_details.id as purchase_id, scm_product_requisition_details.requisition_id
from scm_product_requisition_details
INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id
LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id
INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id
where scm_product_requisition_details.requisition_id = '".$requisition_id."'");
$i = 1;
$total_amount = 0;
while($order_detail = mysqli_fetch_assoc($order_details)){
    $html .= '  <tr>';
    if($i <= 9){
        $html .=       "<td>0$i</td>";
    }else{
        $html .=       "<td>$i</td>";
    }
    $product_name = ((is_null($order_detail['brand_name'])) ? '' : $order_detail['brand_name'].' - ').$order_detail['product_name'];
    $specification = '';
    $has_specification = $mysqli->query("SELECT * FROM `scm_has_product_specification` where product_category_id = ".$order_detail['product_category_id']);
    if($has_specification->num_rows != 0){
        $html .= '<div class="col-md-3" style="border-right: 1px solid gray;">';
        $specifications = $mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification FROM `scm_product_order_specification` INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_order_specification.scm_product_specification_id INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where scm_product_order_pk = ".$order_detail['purchase_id']);
        if($specifications->num_rows != 0){
            $specification .= '<p class="m-0">';
            $specification_tmp = '';
            while($specification_row = mysqli_fetch_assoc($specifications)){
                $specification_tmp .= $specification_row['specification_name'].' - '.$specification_row['specification'].', ';
            }
            $specification .= rtrim($specification_tmp, ', ').'</p>';
        }        
    }
    if($order_detail['color'] != 0){
        $get_color = mysqli_fetch_assoc($mysqli->query("SELECT color from scm_product_color where id = ".$order_detail['color']));
        $specification .= '<p class="m-0">Color: '.$get_color['color'].'</p>';
    }
    if($order_detail['product_size'] != 0){
        $get_size = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_measurement where id = ".$order_detail['product_size']));
        $specification .= '<p class="m-0">Size: '.$get_size['width'].( ($get_size['height'] == 0) ? '' : ' x '.$get_size['height'] ).' '.$get_size['unit'].'</p>';
    }
    $html .=       "<td><div>$product_name</div><div class='m-0 text-secondary'>$specification</div></td>";    
    $html .=        '<td>'.$order_detail['approved_amount'].' <small class="text-secondary">'.$order_detail['scale_name'].'</td>
                    <td>'.$order_detail['sent_amount'].' <small class="text-secondary">'.$order_detail['scale_name'].'</td>
                </tr>';
    $i++;
}
$html .=           '</tbody>
                </table>
            </div>
            </div>
            <div class="row justify-content-between mt-3" style="margin-bottom: 45px">
            <div class="col-print-12">
                <p class="margin-check"> Note: <span ></span></p>
            </div>
            </div>
            <div class="row justify-content-between mt-3">
            <div class="col-print-3">
                <p class="mb-0">Reciver</p>
                <p class="mb-0" style="margin-top: 45px;">________________________________</p>
            </div>
            <div class="col-print-3">
                <p class="mb-0">Warehosue In-Charge</p>
                <p class="mb-0" style="margin-top: 45px;">________________________________</p>
            </div>
        </div>';

        
echo $html; ?>

<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
