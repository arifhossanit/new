<?php
include("../../../application/config/ajax_config.php");
$product_id = $_POST['product_id'];
$scale = $_POST['scale'];
$number_of_specification = $_POST['number_of_specification'];
if($number_of_specification != 0){
    $specificatin_condition =  " HAVING COUNT(*) = ".$number_of_specification;
}else{
    $specificatin_condition =  "";
}
$size_query = "";
if($_POST['size_id'] != '0'){
    $size_query = "AND scm_product_order_details.product_size = {$_POST['size_id']}";
}
// print_r($_POST['product_id']);
// exit();

// will not run w/o purchase code
// $products = $mysqli->query("SELECT t2.id, t2.product_id, t2.purchase_order_id, t2.warehouse_id, t2.received_amount from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '$requisition_pk') t1, (SELECT scm_product_order_details.received_amount, scm_product_order_details.purchase_order_id,scm_product_order_details.warehouse_id, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id) GROUP BY t2.id".$specificatin_condition);

// will run w/o purchase code
// $products = $mysqli->query("SELECT t2.id, t2.product_id, t2.purchase_order_id, t2.warehouse_id, t2.received_amount from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '$requisition_pk') t1, (SELECT ( scm_product_order_details.received_amount - scm_product_order_details.received_amount_offset ) as received_amount, scm_product_order_details.purchase_order_id,scm_product_order_details.warehouse_id, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id) GROUP BY t2.id".$specificatin_condition);
if($_POST['product_types_id'] == 5){
    $products = $mysqli->query("SELECT scm_pre_purchase_order.order_date, scm_warehouse_product_stock.warehouse_id, scm_scales.name as scale_name, scm_pre_purchase_order.received_date, scm_product_category.name as category_name, scm_products.product_name, scm_warehouse_product_stock.stock_amount, scm_product_order_details.color, scm_product_order_details.product_size, scm_warehouse_product_stock.id, scm_product_order_details.id as details_id,scm_warehouse_product_stock.scm_product_order_details_id
    FROM `scm_warehouse_product_stock`
    INNER JOIN scm_product_order_details on scm_product_order_details.id = scm_warehouse_product_stock.scm_product_order_details_id
    INNER JOIN scm_products on  scm_products.id = scm_product_order_details.product_id
    INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id
    INNER JOIN scm_pre_purchase_order on scm_pre_purchase_order.purchase_order_id = scm_product_order_details.pre_purchase_order_id
    INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id
    WHERE scm_pre_purchase_order.status = 4 AND scm_product_order_details.product_id = ".$product_id." $size_query AND scm_warehouse_product_stock.stock_amount > 0 GROUP BY scm_warehouse_product_stock.warehouse_id, scm_warehouse_product_stock.scm_product_order_details_id ORDER BY scm_warehouse_product_stock.id ASC");    
}else{
    $products = $mysqli->query("SELECT scm_purchase_order.order_date, scm_vendor.company_name, scm_warehouse_product_stock.warehouse_id, scm_scales.name as scale_name, scm_purchase_order.received_date, scm_product_category.name as category_name, scm_products.product_name, scm_warehouse_product_stock.stock_amount, scm_product_order_details.color, scm_product_order_details.product_size, scm_warehouse_product_stock.id, scm_product_order_details.id as details_id,scm_warehouse_product_stock.scm_product_order_details_id
    FROM `scm_warehouse_product_stock`
    INNER JOIN scm_product_order_details on scm_product_order_details.id = scm_warehouse_product_stock.scm_product_order_details_id
    INNER JOIN scm_products on  scm_products.id = scm_product_order_details.product_id
    INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id
    INNER JOIN scm_purchase_order on scm_purchase_order.purchase_order_id = scm_product_order_details.purchase_order_id
    INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id
    INNER JOIN scm_vendor on scm_vendor.id = scm_purchase_order.vendor_id
    WHERE scm_purchase_order.status = 1 AND scm_product_order_details.product_id = ".$product_id." $size_query AND scm_warehouse_product_stock.stock_amount > 0 GROUP BY scm_warehouse_product_stock.warehouse_id, scm_warehouse_product_stock.scm_product_order_details_id ORDER BY scm_warehouse_product_stock.id ASC");
}


$html = '<input type="hidden" id="rqusition" name="rqusition" value="'.$_POST['rqusition'].'">
        <table class="table table-sm text-center table-bordered table-hover" id="warehouse_stock_table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Product Name</th>
                    <th>Stock Amount</th>
                    <th>Warehouse</th>
                    <th>Order Details</th>
                    <th style="width: 170px;">Option</th>
                </tr>
            </thead>
            <tbody>';
while($product = mysqli_fetch_assoc($products)){
    // var_dump($products);
    // $product_specification = $mysqli->query("SELECT * FROM `scm_product_order_specification` where scm_product_order_pk = ".$product['id']);
    $details = '';    
    $warehouse = mysqli_fetch_assoc($mysqli->query("SELECT `name` from scm_warehouses where id = '".$product['warehouse_id']."'"));
    if($product['category_name'] == $product['product_name']){
        $name = $product['product_name'];
    }else{
        $name = $product['category_name']. ' - ' .$product['product_name'];
    }
    $specifications = $mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification_detail FROM `scm_product_order_specification` INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_order_specification.scm_product_specification_id INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where scm_product_order_specification.scm_product_order_pk  = ".$product['details_id']);
    if(!is_null($specifications)){
        while($specification = mysqli_fetch_assoc($specifications)){
            $details .= '<span class="text-secondary">'.$specification['specification_name'].': </span>'.$specification['specification_detail'].', ';
        }
    }
    if($product['product_size'] != 0){
        $size = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `scm_product_measurement` where id = ".$product['product_size']));
        $temp = '<span class="text-secondary">Size: </span>';
        if($size['width'] != ''){
            $temp .= $size['width'].' x ';
        }
        if($size['height'] != ''){
            $temp .= $size['height'].' x ';
        }
        $temp = rtrim($temp, ' x ');
        $details .= $temp.' '.$size['unit'].', ';
    }
    if($product['color'] != 0){
        $color = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `scm_product_color` where id = ".$product['color']));
        $details .= '<span class="text-secondary">Color: </span>'.$color['color'].', ';;
    }
    if($details != ''){
        $details = rtrim($details, ', ');
        $details .= '.';
    }    
    $html .= '<tr>';
    $html .= '<td>'.$product['id'].'</td>';
    $html .= "<td><p class=\"p-0 m-0\">".$name."</p>$details</td>";    
    $html .= '<td>'.$product['stock_amount'].' '.$product['scale_name'].'</td>';
    $html .= '<td>'.$warehouse['name'].'</td>';  
    $html .= '<td>'.( (isset($product['company_name'])) ? '<p class="mb-0"><span class="text-secondary">Vendor Name: </span>'.$product['company_name'].'</p>' : '' )
                .'<p class="mb-0"><span class="text-secondary">Order Date: </span>'.$product['order_date'].'</p>'
                .'<p class="mb-0"><span class="text-secondary">Receive Date: </span>'.$product['received_date'].'</p>'.'</td>';
    $html .= '<td>  
                <div class="row justify-content-center">';
    if($_POST['product_types_id'] == 3){
        $html .=    '<div class="col-md-3 col-12">
                        <button data-target="#product_details" data-toggle="modal" type="button" class="btn btn-info btn-xs" onclick="show_department_product_details('.$product['id'].', \''.$name.'\', '.$_POST['rqusition'].', '.$product['details_id'].', '.$product['id'].')"><i class="fas fa-eye"></i></button>
                    </div>';
    }else{
        $html .=    '<div class="col-md-9 col-12">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button style="height: 85% !important;" type="button" class="button-counter left btn btn-default btn-sm" onclick="minus_number('.$product['id'].')"><i class="fas fa-minus span-custom"></i></button>
                            <input style="height: 31px !important;" type="number" name="product_'.$product['id'].'" id="product_'.$product['id'].'" class="form-control input-counter counter" placeholder="0" value="'.$_POST['amount'].'" min="0">
                            <button style="height: 85% !important;" type="button" class="button-counter right btn btn-default btn-sm" onclick="add_number('.$product['id'].')"><i class="fas fa-plus span-custom"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <button type="button" class="btn btn-default btn-sm" onclick="add_warehouse_cart('.$product['id'].', \''.$name.'\''.', '.$_POST['product_types_id'].', '.$product_id.')"><i class="fas fa-cart-plus"></i></button>
                    </div>';
    }    
    $html .=    '</div>
            </td>';
    $html .= '</tr>';
}
$html .=    '</tbody>
        </table>';
print_r(mysqli_error($mysqli));
echo $html;
