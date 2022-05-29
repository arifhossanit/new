<?php
include("../../../application/config/ajax_config.php");
$purchase_order = $_POST['purchase_order'];
$html = '<input type="hidden" name="purchase_order" value="'.$purchase_order.'">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <th>Sl</th>
                <th style="width: 35%;">Item Description</th>
                <th>Quantity</th>
                <th style="width: 13%;">Unit Price</th>
                <th style="width: 13%;">Total Price</th>
                <th style="width: 8%;">Received</th>
                <th style="width: 8%;">Stolen</th>
                <th style="width: 8%;">Damaged</th>
            </thead>
            <tbody>';
$product_type = '';
if(isset($_POST['food'])){
    $order_details = $mysqli->query("SELECT scm_scales.name as scale_name, scm_brands.name as brand_name, scm_products.*, scm_product_order_details.*, scm_product_order_details.id as purchase_id from scm_product_order_details INNER JOIN scm_products on scm_products.id = scm_product_order_details.product_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id where pre_purchase_order_id = '".$purchase_order."'");
    $product_type = 'food';
}else{
    $order_details = $mysqli->query("SELECT scm_product_types.name as type_name, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_products.*, scm_product_order_details.*, scm_product_order_details.id as purchase_id from scm_product_order_details INNER JOIN scm_products on scm_products.id = scm_product_order_details.product_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id where purchase_order_id = '".$purchase_order."'");
}
$i = 1;
$total_amount = 0;
while($order_detail = mysqli_fetch_assoc($order_details)){
    if($product_type != 'food'){
        $product_type = $order_detail['type_name'];
    }
    $html .= '  <tr id="receive_order_'.$i.'">';
    if($i <= 9){
        $html .=       "<td>0$i</td>";
    }else{
        $html .=       "<td>$i</td>";
    }
    $html .=       '<td>'.((is_null($order_detail['brand_name'])) ? '' : $order_detail['brand_name'].' - ').$order_detail['product_name'].'</td>';
    $amount = $order_detail['unit_price'] * $order_detail['approved_amount'];
    $total_amount += $amount;
    $html .=        '<td>'.$order_detail['approved_amount'].' <small class="text-secondary">'.$order_detail['scale_name'].'</td>
                    <td>'.money($order_detail['unit_price']).'</td>
                    <td>'.money($amount).'</td>';
    if($_POST['type'] == 'not_received'){
        $html .=   '<td><input class="form-control" name="received_amount[]" type="number" value="'.$order_detail['approved_amount'].'" max="'.$order_detail['approved_amount'].'" min="0" placeholder="Received Amount" step="any"></td>
                    <td><input class="form-control" name="stolen_amount[]" type="number" value="0" max="'.$order_detail['approved_amount'].'" min="0" placeholder="Stolen Amount" step="any"></td>
                    <td><input class="form-control" name="damaged_amount[]" type="number" value="0" max="'.$order_detail['approved_amount'].'" min="0" placeholder="Stolen Amount" step="any"></td>
                    <input type="hidden" name="product_id[]" value="'.$order_detail['purchase_id'].'">
                    <input type="hidden" name="product_type[]" value="'.strtolower($product_type).'">';
    }else if($_POST['type'] == 'received'){
        $html .=   '<td>'.$order_detail['received_amount'].'</td>
                    <td>'.$order_detail['stolen_amount'].'</td>
                    <td>'.$order_detail['damaged_amount'].'</td>';
    }
    $html .=   '</tr>';
    $i++;
}
$html .=    '</tbody>
        </table>';
if($_POST['type'] == 'not_received'){
    $button = '<button type="submit" class="btn btn-primary btn-sm">Submit</button>';
}else if($_POST['type'] == 'received'){
    $button = '';
}
$info = array(
    'html' => $html,
    'button' => $button,
);
echo json_encode($info);