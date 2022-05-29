<?php
include("../../../application/config/ajax_config.php");
$requisition_id = $_POST['requisition_id'];
$products = $mysqli->query("SELECT scm_products.product_name, scm_product_category.name as category_name, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_product_requisition_details.* FROM scm_product_requisition_details INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id where scm_product_requisition_details.requisition_id = '$requisition_id' ORDER by scm_product_requisition_details.id desc");
// var_dump($products);
$html = '<div class="text-danger" id="error_message"></div>
        <table class="table table-sm text-center table-bordered table-hover" id="requisition_details_table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Product Name</th>
                    <th>Product Specification</th>
                    <th>Requested Amount</th>
                    <th>Approved Amount</th>
                    <th>Sent Amount</th>
                    <th>Received Amount</th>
                    <th>Stolen Amount</th>
                    <th>Damaged Amount</th>
                </tr>
            </thead>
            <tbody>';
$auto_assign = true;
$i = 0;
while($product = mysqli_fetch_assoc($products)){
    $html .= '<tr id="row_'.$i.'">';
    $i++;
    $html .= '<td>'.$product['id'].'</td>';
    $product_name = $product['category_name'].': '.( (is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ' ).$product['product_name'];
    $html .= '<td>'.$product_name.'</td>';
    $specification = false;
    $specifications = $mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification from scm_product_requisition_specification INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_requisition_specification.scm_product_specification_id  INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where requisition_pk = ".$product['id']);
    $html .= '<td><small>';
    if($specifications->num_rows != 0){
        $html .= '<p class="mb-0">';
        $temp = '';
        while($specification = mysqli_fetch_assoc($specifications)){
            $temp .= $specification['specification_name'].' - '.$specification['specification'].', ';
        }
        $html .= rtrim($temp, ', ').'</p>';
        $specification = true;
    }        
    if($product['color'] != 0){
        $get_color = mysqli_fetch_assoc($mysqli->query("SELECT color from scm_product_color where id = ".$product['color']));
        $html .= '<p class="mb-0">Color: '.$get_color['color'].'</p>';
        $specification = true;
    }
    if($product['product_size'] != 0){
        $get_size = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_measurement where id = ".$product['product_size']));
        $html .= '<p class="mb-0">Size: '.$get_size['width'].( ($get_size['height'] == 0) ? '' : ' x '.$get_size['height'] ).' '.$get_size['unit'].'</p>';
        $specification = true;
    }
    if(!$specification){
        $html .= ' - ';
    }
    $html .= '</small></td>';
    $html .= '<td>'.$product['requested_amount'].' '.$product['scale_name'].'</td>';
    $html .= '<td>'.$product['approved_amount'].' '.$product['scale_name'].'</td>';
    $html .= '<td>'.$product['sent_amount'].' '.$product['scale_name'].'</td>';
    $html .= '<td>'.$product['received_amount'].'</td>';
    $html .= '<td>'.$product['stolen_amount'].'</td>';
    $html .= '<td>'.$product['damaged_amount'].'</td>';    
    $html .= '</tr>';
}
$html .=    '</tbody>
        </table>';
print_r(mysqli_error($mysqli));
$info = array(
    'html' => $html,
    'button' => '',
);
echo json_encode($info);
