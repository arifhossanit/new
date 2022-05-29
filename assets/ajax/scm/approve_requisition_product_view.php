<?php
include("../../../application/config/ajax_config.php");
$requisition_id = $_POST['requisition_id'];
$products = $mysqli->query("SELECT scm_products.product_name, scm_product_category.name as category_name, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_product_requisition_details.* FROM scm_product_requisition_details INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id LEFT JOIN scm_scales on scm_scales.id = scm_products.scale_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id where scm_product_requisition_details.requisition_id = '$requisition_id'");
$html = '<table class="table table-sm text-center table-bordered table-hover" id="requisition_details_table">
            <thead>
                <tr>
                    <th>id</th>
                    <th style="width: 30%">Product Name</th>
                    <th style="width: 30%">Product Specification</th>
                    <th>Requested Amount</th>
                    <th style="width: 15%">Approve Amount</th>
                </tr>
            </thead>
            <tbody>';
while($product = mysqli_fetch_assoc($products)){
    // will not run without purchase order
    // $stock = mysqli_fetch_assoc($mysqli->query("SELECT sum(t2.requested_amount) as total_amount from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_order_details.requested_amount, scm_product_order_details.purchase_order_id,scm_product_order_details.warehouse_id, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id where scm_product_order_details.purchase_order_id is NOT null) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id) GROUP BY t2.id HAVING COUNT(*) = ".$specification_count['specification_count']));

    // will run without purchase order
     $html .= '<tr>';
    $html .= '<td>'.$product['id'].'</td>';
    $product_name = $product['category_name'].': '.( (is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ' ).$product['product_name'];
    $html .= '<td>'.$product_name.'</td>';

    /*
    if($specifications->num_rows != 0){
        $html .= '<td><small>';
        $i = 0;
        while($specification = mysqli_fetch_assoc($specifications)){
            if($i == 0){
                $html .= $specification['specification_type'].' - '.$specification['specification_name'];
            }else{
                $html .= ', '.$specification['specification_type'].' - '.$specification['specification_name'];
            }
            $i++;
        }
        $html .= '</small></td>';
    }else{
        $html .= '<td> - </td>';
    }
    */

    $specification = false;
    $specifications = $mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification from scm_product_requisition_specification INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_requisition_specification.scm_product_specification_id  INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where requisition_pk = ".$product['id']);
    $html .= '<td><small>';
    if($specifications->num_rows != 0){
        if($specifications->num_rows != 0){
            $html .= '<p class="mb-0">';
            $temp = '';
            while($specification = mysqli_fetch_assoc($specifications)){
                $temp .= $specification['specification_name'].' - '.$specification['specification'].', ';
            }
            $html .= rtrim($temp, ', ').'</p>';
            $specification = true;
        }        
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
    // $html .= '<td><button type="button" data-target="#show_product_stock" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_product_stocks(\''.$product['id'].'\', \''.$product_name.'\', \''.$product['scale_name'].'\')"><i class="fas fa-eye"></i></button></td>';
    $html .= '<td>
                <input name="product_id[]" type="hidden" value="'.$product['id'].'">
                <input class="form-control" name="approved_amount[]" type="number" step="any" value="'.$product['requested_amount'].'" max="'.$product['requested_amount'].'" min="0">
            </td>';
    $html .= '</tr>';
}
$html .=    '</tbody>
        </table>';
print_r(mysqli_error($mysqli));
$info = array(
    'html' => $html,
);
echo json_encode($info);
