<?php
include("../../../application/config/ajax_config.php");
$purchase_order = $_POST['purchase_order'];
$products = $mysqli->query("SELECT scm_scales.name as scale_name, scm_brands.name as brand_name, scm_products.*, scm_product_order_details.requested_amount, scm_product_order_details.color, scm_product_order_details.product_size, scm_product_order_details.id as purchase_id, scm_product_order_details.purchase_order_id, scm_product_order_details.unit_price from scm_product_order_details INNER JOIN scm_products on scm_products.id = scm_product_order_details.product_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id LEFT JOIN scm_scales on scm_scales.id = scm_products.scale_id where pre_purchase_order_id = '".$purchase_order."'");
$button = '';
$html = '<div class="row">
            <div class="col-md-12">
                <p style="font-size: 25px;font-weight: 100;">Purchasing for: <span style="font-weight: 500;">Main Warehouse</span></p>
            </div>
            <div class="col-md-12">
                <ul class="list-group">';
if(strtolower($_POST['type']) == 'food'){
    if($_POST['approved'] == 'no'){
        $html .=            '<li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Product Image</div>
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Product Name</div>
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Requested Amounts</div>
                                    <div class="col-md-3 font-weight-bold">Approved Amounts</div>
                                </div>
                            </li>';
        while($product = mysqli_fetch_assoc($products)){
            $html .= '<li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3" style="border-right: 1px solid gray;"><img src="'.$home.$product['product_image'].'" alt="assets/img/photo_avatar.png" width="60px" height="60px"></div>
                                <div class="col-md-3" style="border-right: 1px solid gray;">'.((is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ').$product['product_name'].'</div>';   
            $html .=           '<div class="col-md-3" style="border-right: 1px solid gray;">'.$product['requested_amount'].' <small class="text-secondary">'.$product['scale_name'].'</small></div>
                                <div class="col-md-3"><input class="form-control mt-1" type="number" value="'.$product['requested_amount'].'" name="approved_amount[]"></div>
                                <input type="hidden" value="'.$product['purchase_id'].'" name="product_id[]">
                            </div>
                        </li>';
        }
        $button = '<button id="approve_button" class="btn btn-primary btn-sm">Approve</button>';
    }else{
        $html .=            '<li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Product Image</div>
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Product Name</div>
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Amounts</div>
                                    <div class="col-md-3 font-weight-bold">Unit Price</div>
                                </div>
                            </li>';
        while($product = mysqli_fetch_assoc($products)){
            $html .= '<li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3" style="border-right: 1px solid gray;"><img src="'.$home.$product['product_image'].'" alt="assets/img/photo_avatar.png" width="60px" height="60px"></div>
                                <div class="col-md-3" style="border-right: 1px solid gray;">'.((is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ').$product['product_name'].'</div>';   
            $html .=            '<div class="col-md-3" style="border-right: 1px solid gray;">'.$product['requested_amount'].' <small class="text-secondary">'.$product['scale_name'].'</small></div>';
            $html .=            '<div class="col-md-3">'.money($product['unit_price']).'</div>';            
            $html .=        '</div>
                      </li>';
        }
    }
}else{
    if($_POST['approved'] == 'no'){
        $html .=            '<li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Product Image</div>
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Product Name</div>
                                    <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Specification</div>
                                    <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Requested Amounts</div>
                                    <div class="col-md-2 font-weight-bold">Approve Amounts</div>
                                </div>
                            </li>';
        while($product = mysqli_fetch_assoc($products)){
            $html .= '<li class="list-group-item">
                            <div class="row">
                                <div class="col-md-2" style="border-right: 1px solid gray;"><img src="'.$home.$product['product_image'].'" alt="assets/img/photo_avatar.png" width="60px" height="60px"></div>
                                <div class="col-md-3" style="border-right: 1px solid gray;">'.((is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ').$product['product_name'].'</div>';
            $specification = false;
            $has_specification = $mysqli->query("SELECT * FROM `scm_has_product_specification` where product_category_id = ".$product['product_category_id']);
            $specification_html = '';
            if($has_specification->num_rows != 0){
                $specifications = $mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification FROM `scm_product_order_specification` INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_order_specification.scm_product_specification_id INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where scm_product_order_pk = ".$product['purchase_id']);
                if($specifications->num_rows != 0){
                    while($specification = mysqli_fetch_assoc($specifications)){
                        $specification_html .= '<p class="mb-0">'.$specification['specification_name'].' - '.$specification['specification'].'</p>';
                    }
                    $specification = true;
                }        
            }
            if($product['color'] != 0){
                $get_color = mysqli_fetch_assoc($mysqli->query("SELECT color from scm_product_color where id = ".$product['color']));
                $specification_html .= '<p class="mb-0">Color: '.$get_color['color'].'</p>';
                $specification = true;
            }
            if($product['product_size'] != 0){
                $get_size = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_measurement where id = ".$product['product_size']));
                $specification_html .= '<p class="mb-0">Size: '.$get_size['width'].( ($get_size['height'] == 0) ? '' : ' x '.$get_size['height'] ).' '.$get_size['unit'].'</p>';
                $specification = true;
            }
            if(!$specification){
                $html .= '<div class="col-md-3" style="border-right: 1px solid gray;"> - </div>';
            }else{
                $html .= '<div class="col-md-3" style="border-right: 1px solid gray;">'.$specification_html.'</div>';
            }
            $html .=           '<div class="col-md-2" style="border-right: 1px solid gray;">'.$product['requested_amount'].' <small class="text-secondary">'.$product['scale_name'].'</small></div>
                                <div class="col-md-2"><input class="form-control mt-1" type="number" value="'.$product['requested_amount'].'" name="approved_amount[]"></div>
                                <input type="hidden" value="'.$product['purchase_id'].'" name="product_id[]">
                            </div>
                        </li>';
        }
        $button = '<button id="approve_button" class="btn btn-primary btn-sm">Approve</button>';
    }else{
        $html .=            '<li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Product Image</div>
                                    <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Product Name</div>
                                    <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Specification</div>
                                    <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Amounts</div>
                                    <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Vendor</div>
                                    <div class="col-md-2 font-weight-bold">Unit Price</div>
                                </div>
                            </li>';
        while($product = mysqli_fetch_assoc($products)){
            $html .= '<li class="list-group-item">
                            <div class="row">
                                <div class="col-md-2" style="border-right: 1px solid gray;"><img src="'.$home.$product['product_image'].'" alt="assets/img/photo_avatar.png" width="60px" height="60px"></div>
                                <div class="col-md-2" style="border-right: 1px solid gray;">'.((is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ').$product['product_name'].'</div>';
            
            $has_specification = $mysqli->query("SELECT * FROM `scm_has_product_specification` where product_category_id = ".$product['product_category_id']);
            $html_specification = '';
            $html .= '<div class="col-md-2" style="border-right: 1px solid gray;">';

            if($product['product_size'] != 0){
                $get_size = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_measurement where id = ".$product['product_size']));
                $html .= '<p class="mb-0">Size: '.$get_size['width'].( ($get_size['height'] == 0) ? '' : ' x '.$get_size['height'] ).' '.$get_size['unit'].'</p>';
            }

            $specifications = $mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification FROM `scm_product_order_specification` INNER JOIN scm_product_specification on scm_product_specification.id = scm_product_order_specification.scm_product_specification_id INNER JOIN scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where scm_product_order_pk = ".$product['purchase_id']);
            if($has_specification->num_rows != 0 AND $specifications->num_rows != 0){
                while($specification = mysqli_fetch_assoc($specifications)){
                    $html .= '<p class="mb-0">'.$specification['specification_name'].' - '.$specification['specification'].'</p>';
                }
            }

            $html .= '</div>';
            $html .=            '<div class="col-md-2" style="border-right: 1px solid gray;">'.$product['requested_amount'].' <small class="text-secondary">'.$product['scale_name'].'</small></div>';
            if(!is_null($product['purchase_order_id'])){
                $vendor_info = mysqli_fetch_assoc($mysqli->query("SELECT scm_vendor.company_name from scm_purchase_order INNER JOIN scm_vendor on scm_vendor.id = scm_purchase_order.vendor_id where scm_purchase_order.purchase_order_id = '".$product['purchase_order_id']."'"));
                $html .=            '<div class="col-md-2" style="border-right: 1px solid gray;">'.$vendor_info['company_name'].'</div>';
                $html .=            '<div class="col-md-2">'.money($product['unit_price']).'</div>';
            }else{
                $html .=            '<div class="col-md-2" style="border-right: 1px solid gray;">Not Assigned</div>';
                $html .=            '<div class="col-md-2">Not Assigned</div>';
            }
            
            $html .=            '</div>
                    </li>';
        }
    }
}                    
$html .=       '</ul>
            </div>
        </div>';
$data = array(
    'html' => $html,
    'button' => $button
);
echo json_encode($data);