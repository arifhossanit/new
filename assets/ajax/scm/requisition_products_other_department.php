<?php
include("../../../application/config/ajax_config.php");
$requisition_id = $_POST['requisition_id'];
$products = $mysqli->query("SELECT scm_products.product_name, scm_product_category.name as category_name, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_product_requisition_details.*
FROM scm_product_requisition_details INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id
INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id
INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id
LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id
where scm_product_requisition_details.requisition_id = '$requisition_id'");
// var_dump($products);
$html = '<table class="table table-sm text-center table-bordered table-hover" id="requisition_details_table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Product Name</th>
                    <th>Product Specification</th>
                    <th>Requested Amount</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>';
$auto_assign = true;
while($product = mysqli_fetch_assoc($products)){
    $specification_count = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as specification_count from scm_product_requisition_specification where requisition_pk = ".$product['id']));
    if($specification_count['specification_count'] != 0){
        $specification_condition = ' HAVING COUNT(*) = '.$specification_count['specification_count'];
    }else{
        $specification_condition = '';
    }

    // will not run without purchase order
    // $stock = mysqli_fetch_assoc($mysqli->query("SELECT sum(t2.requested_amount) as total_amount from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_order_details.requested_amount, scm_product_order_details.purchase_order_id,scm_product_order_details.warehouse_id, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id where scm_product_order_details.purchase_order_id is NOT null) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id) GROUP BY t2.id HAVING COUNT(*) = ".$specification_count['specification_count']));

    

    // will run without purchase order
    $total_stock = 0;
    // $stocks = $mysqli->query("SELECT t2.id from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_order_details.purchase_order_id,scm_product_order_details.status, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 1) GROUP BY t2.id".$specification_condition);
    $stocks = $mysqli->query("SELECT t2.department_requested_for, t2.id, t2.scm_product_requisition_details_id, t1.id as requisition_details_id from
    (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id
    FROM `scm_product_requisition_details`
    LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1,
    (SELECT scm_product_requisition.department_requested_for, scm_product_requisition.status, scm_product_requisition.requisition_for, scm_department_stock.id, scm_department_stock.stock_amount, scm_department_stock.scm_product_requisition_details_id, scm_product_requisition_details.product_id, scm_product_requisition_details.color, scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id
    FROM `scm_product_requisition_details`
    INNER JOIN scm_product_requisition using (requisition_id)
    INNER JOIN scm_department_stock on scm_department_stock.scm_product_requisition_details_id = scm_product_requisition_details.id
    LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id) t2
    where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 3 AND t2.requisition_for = 0 AND t2.stock_amount > 0 AND t1.id = ".$product['id']." AND t2.department_requested_for = '{$_SESSION['user_info']['department']}')
    GROUP BY t2.id".$specification_condition);
    // var_dump($stocks);
    // print_r("SELECT t2.id, t2.scm_product_requisition_details_id, t1.id as requisition_details_id from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1,
    // (SELECT scm_product_requisition.status, scm_product_requisition.requisition_for, scm_department_stock.id, scm_department_stock.stock_amount, scm_department_stock.scm_product_requisition_details_id, scm_product_requisition_details.product_id, scm_product_requisition_details.color, scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` INNER JOIN scm_product_requisition using (requisition_id) INNER JOIN scm_department_stock on scm_department_stock.scm_product_requisition_details_id = scm_product_requisition_details.id LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 3 AND t2.requisition_for = 0 AND t2.stock_amount > 0) GROUP BY t2.id".$specification_condition);

    // print_r("SELECT t2.id from (SELECT scm_product_requisition_details.id,scm_product_requisition_details.product_id,scm_product_requisition_details.color,scm_product_requisition_details.product_size, scm_product_requisition_specification.scm_product_specification_id FROM `scm_product_requisition_details` LEFT JOIN `scm_product_requisition_specification` on scm_product_requisition_specification.requisition_pk = scm_product_requisition_details.id WHERE scm_product_requisition_details.id = '".$product['id']."') t1, (SELECT scm_product_order_details.purchase_order_id,scm_product_order_details.status, scm_product_order_details.id, scm_product_order_details.product_id,scm_product_order_details.color,scm_product_order_details.product_size, scm_product_order_specification.scm_product_specification_id FROM `scm_product_order_details` LEFT JOIN `scm_product_order_specification` on scm_product_order_specification.scm_product_order_pk = scm_product_order_details.id) t2 where (t1.product_id = t2.product_id AND t1.color = t2.color AND t1.product_size = t2.product_size AND t1.scm_product_specification_id <=> t2.scm_product_specification_id AND t2.status = 1) GROUP BY t2.id".$specification_condition);
    if($stocks->num_rows != 0){
        $ids = '';
        while($stock = mysqli_fetch_assoc($stocks)){
            $ids .= $stock['id'].', ';
        }
        $ids = rtrim($ids, ', ');
        $temp = mysqli_fetch_assoc($mysqli->query("SELECT count(DISTINCT(branch_id)) as id_count, SUM(stock_amount) as received_amount from scm_department_stock where id in ( ".$ids." ) GROUP BY scm_product_requisition_details_id"));
        $total_stock += $temp['received_amount'];
        if($temp['id_count'] != 1){
            $auto_assign = false;
        }
    }
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
    $html .= '<td>'.$product['approved_amount'].' '.$product['scale_name'].'</td>';
    // $html .= '<td><button type="button" data-target="#show_product_stock" data-toggle="modal" class="btn btn-info btn-xs mr-1" onclick="show_product_stocks(\''.$product['id'].'\', \''.$product_name.'\', \''.$product['scale_name'].'\')"><i class="fas fa-eye"></i></button></td>';
    if($total_stock != 0){
        if($product['approved_amount'] > $total_stock){
            $auto_assign = false;
        }
        $html .= '<td>'.$total_stock.' '.$product['scale_name'].'</td>';
    }else{
        $auto_assign = false;
        $html .= '<td class="text-danger"> Not Available </td>';
    }
    $html .= '</tr>';
}
$html .=    '</tbody>
        </table>';
print_r(mysqli_error($mysqli));
$button = '';
if($auto_assign){
    $button = '<button type="submit" class="btn btn-success btn-sm">Autometically Asign</button>';
}
$info = array(
    'html' => $html,
    'button' => $button,
);
echo json_encode($info);
