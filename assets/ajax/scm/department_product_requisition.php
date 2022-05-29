<?php
include("../../../application/config/ajax_config.php");
$requisition_id = $_POST['requisition_id'];
$products = $mysqli->query("SELECT scm_product_types.name as type_name, scm_products.product_name, scm_product_category.name as category_name, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_product_requisition_details.* FROM scm_product_requisition_details INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id where scm_product_requisition_details.requisition_id = '$requisition_id' ORDER by scm_product_requisition_details.id desc");
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
    // Product Specification
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
    $html .= '<td><input name="rqst_id[]" type="hidden" value="'.$product['id'].'"><input type="number" class="form-control" name="received_amount[]" value="'.$product['sent_amount'].'" max="'.$product['sent_amount'].'" min="0"></td>';
    if($product['type_name'] == 'Storable'){
        // stolen product
        $html .= '<td>
                    <div class="row">
                        <div class="col-md-6">';
        if(isset($_SESSION['stolen_product_department_receive'][$product['id']])){
            $html .= '<input type="hidden" class="form-control" name="stolen_amount[]" value="'.count($_SESSION['stolen_product_department_receive'][$product['id']]).'"><p>'.count($_SESSION['stolen_product_department_receive'][$product['id']]).'</p>';
        }else{            
            $html .= '<input type="hidden" class="form-control" name="stolen_amount[]" value="0"><p>0</p>';
        }
        $html .=        '</div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-xs btn-info" type="button" onclick="get_stolen_amount('.$product['id'].', \'storable\')"><i class="fas fa-plus"></i></button>
                        </div>
                    </div></td>';
        // damaged product
        $html .= '<td>
                    <div class="row">
                        <div class="col-md-6">';
        if(isset($_SESSION['damaged_product_department_receive'][$product['id']])){
            $html .= '<input type="hidden" class="form-control" name="damaged_amount[]" value="'.count($_SESSION['damaged_product_department_receive'][$product['id']]).'"><p>'.count($_SESSION['damaged_product_department_receive'][$product['id']]).'</p>';
        }else{            
            $html .= '<input type="hidden" class="form-control" name="damaged_amount[]" value="0"><p>0</p>';
        }
        $html .=        '</div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-xs btn-info" type="button" onclick="get_damaged_amount('.$product['id'].', \'storable\')"><i class="fas fa-plus"></i></button>
                        </div>
                    </div></td>';
    }else{
        $number_of_row = mysqli_fetch_assoc($mysqli->query("SELECT count(DISTINCT(scm_warehouse_product_stock.scm_product_order_details_id)) as num_row from scm_product_requisition_received INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_received.scm_product_requisition_details_id = ".$product['id']));
        if((int)$number_of_row['num_row'] > 1){
            // stolen product
            $html .= '<td>
                    <div class="row">
                        <div class="col-md-6">';
            if(isset($_SESSION['stolen_product_department_receive'][$product['id']])){
                $html .= '<input type="hidden" class="form-control" name="stolen_amount[]" value="'.array_sum($_SESSION['stolen_product_department_receive'][$product['id']]).'"><p>'.array_sum($_SESSION['stolen_product_department_receive'][$product['id']]).'</p>';
            }else{            
                $html .= '<input type="hidden" class="form-control" name="stolen_amount[]" value="0"><p>0</p>';
            }
            $html .=        '</div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-xs btn-info" type="button" onclick="get_stolen_amount('.$product['id'].', \'consumeable\')"><i class="fas fa-plus"></i></button>
                        </div>
                    </div></td>';
            // damaged product
            $html .= '<td>
                    <div class="row">
                        <div class="col-md-6">';
            if(isset($_SESSION['damaged_product_department_receive'][$product['id']])){
                $html .= '<input type="hidden" class="form-control" name="damaged_amount[]" value="'.array_sum($_SESSION['damaged_product_department_receive'][$product['id']]).'"><p>'.array_sum($_SESSION['damaged_product_department_receive'][$product['id']]).'</p>';
            }else{            
                $html .= '<input type="hidden" class="form-control" name="damaged_amount[]" value="0"><p>0</p>';
            }
            $html .=        '</div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-xs btn-info" type="button" onclick="get_damaged_amount('.$product['id'].', \'consumeable\')"><i class="fas fa-plus"></i></button>
                        </div>
                    </div></td>';
        }else{
            $html .= '<td><input type="number" class="form-control" name="stolen_amount[]" value="0" max="'.$product['sent_amount'].'" min="0"></td>';
            $html .= '<td><input type="number" class="form-control" name="damaged_amount[]" value="0" max="'.$product['sent_amount'].'" min="0"></td>';
        }
    }
    $html .= '</tr>';
}
$html .=    '</tbody>
        </table>';
print_r(mysqli_error($mysqli));
$button = '<button type="submit" class="btn btn-success btn-sm">Receive</button>';
$info = array(
    'html' => $html,
    'button' => $button,
);
echo json_encode($info);
