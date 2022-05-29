<?php
include("../../../application/config/ajax_config.php");
// $html = '<div class="form-group">
//             <select class="form-control select2" name="vendor_id" id="vendor_id" required>
//                 <option value="">Select Vendor</option>';
$vendors = $mysqli->query("SELECT company_name, id from scm_vendor");
$vendors_arr = array();
// while($vendor = mysqli_fetch_assoc($vendors)){ 
//     $html .= '<option value="'.$vendor["id"].'">'.$vendor["company_name"].'</option>';
// }
// $html .=    '</select>
//         </div>';
// echo $html;
$purchase_order = $_POST['purchase_order'];
$products = $mysqli->query("SELECT scm_product_category.product_types_id, scm_scales.name as scale_name, scm_brands.name as brand_name, scm_products.*, scm_product_order_details.approved_amount, scm_product_order_details.color, scm_product_order_details.product_size, scm_product_order_details.id as purchase_id from scm_product_order_details INNER JOIN scm_products on scm_products.id = scm_product_order_details.product_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id  LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id LEFT JOIN scm_scales on scm_scales.id = scm_products.scale_id where pre_purchase_order_id = '".$purchase_order."'");
$html = '<div class="row">
            <div class="col-md-12">
                <ul class="list-group">';
if(strtolower($_POST['type']) != 'food'){
    $html .= '  <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-1 font-weight-bold" style="border-right: 1px solid gray;">Product Image</div>
                        <div class="col-md-1 font-weight-bold" style="border-right: 1px solid gray;">Product Name</div>
                        <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Specification</div>
                        <div class="col-md-1 font-weight-bold" style="border-right: 1px solid gray;">Amounts</div>
                        <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Vendors</div>
                        <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Warrenty/Expiery</div>
                        <div class="col-md-2 font-weight-bold">Unit Price</div>
                    </div>
                </li>';
    $i = 0;
    while($product = mysqli_fetch_assoc($products)){
        $html .= '  <input type="hidden" name="product_order_details_id[]" value="'.$product['purchase_id'].'">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-1" style="border-right: 1px solid gray;"><img src="'.$home.$product['product_image'].'" alt="assets/img/photo_avatar.png" width="60px" height="60px"></div>
                            <div class="col-md-1" style="border-right: 1px solid gray;">'.((is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ').$product['product_name'].'</div>';
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
            $html .= '<div class="col-md-2" style="border-right: 1px solid gray;"> - </div>';
        }else{
            $html .= '<div class="col-md-2" style="border-right: 1px solid gray;">'.$specification_html.'</div>';
        }
        $html .=           '<div class="col-md-1" style="border-right: 1px solid gray;">'.$product['approved_amount'].' <small class="text-secondary">'.$product['scale_name'].'</small></div>';
        $html .=           '<div class="col-md-2" style="border-right: 1px solid gray;">';								
                    $html .=    '<select class="form-control select2" name="vendor[]" required>
                                    <option value="">Select Vendor</option>';
                    if($i == 0){
                        while($vendor = mysqli_fetch_assoc($vendors)){
                            $data = array(
                                'id' => $vendor["id"],
                                'company_name' => $vendor["company_name"],
                            );
                            array_push($vendors_arr, $data);
                            if($vendor['id'] == 43){
                                $html .= '<option value="'.$vendor["id"].'" selected>'.$vendor["company_name"].'</option>';
                            }else{
                                $html .= '<option value="'.$vendor["id"].'">'.$vendor["company_name"].'</option>';
                            }
                            // $html .= '<option value="'.$vendor["id"].'">'.$vendor["company_name"].'</option>';
                        }
                    }else{
                        foreach($vendors_arr as $vendor ){
                            if($vendor['id'] == 43){
                                $html .= '<option value="'.$vendor["id"].'" selected>'.$vendor["company_name"].'</option>';
                            }else{
                                $html .= '<option value="'.$vendor["id"].'">'.$vendor["company_name"].'</option>';
                            }
                        }
                    }
                    $i++;
                    $html .=    '</select>';
        $html .=           '</div>';
        if($product['product_types_id'] == '3'){
            $html .=   '<div class="col-md-3" style="border-right: 1px solid gray;">
                            <input type="hidden" name="expiry_date[]" value="">
                            <select class="form-control select2" name="warrenty[]" required onchange="get_warrenty(this.value, '.$i.')" style="width: 50% !important">
                                <option>No</option>
                                <option>Yes</option>
                            </select>
                            <div class="row mt-1 mb-1" style="display: none;" id="warrenty_div_'.$i.'">
                                <div class="col-sm-4">
                                    <select class="form-control select2" name="warrenty_days[]" id="warrenty_days">
                                        <option value="">Day</option>
                                        <option value="1">1 Day</option>
                                        <option value="2">2 Days</option>
                                        <option value="3">3 Days</option>
                                        <option value="4">4 Days</option>
                                        <option value="5">5 Days</option>
                                        <option value="6">6 Days</option>
                                        <option value="7">7 Days</option>
                                        <option value="8">8 Days</option>
                                        <option value="9">9 Days</option>
                                        <option value="10">10 Days</option>
                                        <option value="11">11 Days</option>
                                        <option value="12">12 Days</option>
                                        <option value="13">13 Days</option>
                                        <option value="14">14 Days</option>
                                        <option value="15">15 Days</option>
                                        <option value="16">16 Days</option>
                                        <option value="17">17 Days</option>
                                        <option value="18">18 Days</option>
                                        <option value="19">19 Days</option>
                                        <option value="20">20 Days</option>
                                        <option value="21">21 Days</option>
                                        <option value="22">22 Days</option>
                                        <option value="23">23 Days</option>
                                        <option value="24">24 Days</option>
                                        <option value="25">25 Days</option>
                                        <option value="26">26 Days</option>
                                        <option value="27">27 Days</option>
                                        <option value="28">28 Days</option>
                                        <option value="29">29 Days</option>
                                        
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control select2" name="warrenty_months[]" id="warrenty_months">
                                        <option value="">Month</option>
                                        <option value="1">1 Month</option>
                                        <option value="2">2 Months</option>
                                        <option value="3">3 Months</option>
                                        <option value="4">4 Months</option>
                                        <option value="5">5 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="7">7 Months</option>
                                        <option value="8">8 Months</option>
                                        <option value="9">9 Months</option>
                                        <option value="10">10 Months</option>
                                        <option value="11">11 Months</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control select2" name="warrenty_years[]" id="warrenty_years">
                                        <option value="">Year</option>
                                        <option value="1">1 Year</option>
                                        <option value="2">2 Years</option>
                                        <option value="3">3 Years</option>
                                        <option value="4">4 Years</option>
                                        <option value="5">5 Years</option>
                                        <option value="6">6 Years</option>
                                        <option value="7">7 Years</option>
                                        <option value="8">8 Years</option>
                                        <option value="9">9 Years</option>
                                        <option value="10">10 Years</option>
                                        <option value="11">11 Years</option>
                                        <option value="12">12 Years</option>
                                        <option value="13">13 Years</option>
                                        <option value="14">14 Years</option>
                                        <option value="15">15 Years</option>
                                        <option value="16">16 Years</option>
                                        <option value="17">17 Years</option>
                                        <option value="18">18 Years</option>
                                        <option value="19">19 Years</option>
                                        <option value="20">20 Years</option>
                                    </select>
                                </div>
                            </div>
                        </div>';
        }else{
            $html .= '<div class="col-md-3" style="border-right: 1px solid gray;">
                          <input type="hidden" name="warrenty[]" value="no">
                          <input type="text" class="form-control datepicker" name="expiry_date[]" placeholde="Expiry Date if any!">
                      </div>';
        }        
        $html .=    '<div class="col-md-2"><input name="product_unit_price[]" type="number" step="any" class="form-control" placeholder="Unit Price" value="0" required></div>';
        $html .=        '</div>
                    </li>';
    }
    $button = '<button class="btn btn-primary btn-sm">Create Purchase Order</button>';
    $action = $home.'admin/scm/manage-product-purchase/add-vendor';
}else{
    $html .= '  <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Product Image</div>
                        <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Product Name</div>
                        <div class="col-md-3 font-weight-bold" style="border-right: 1px solid gray;">Amounts</div>
                        <div class="col-md-2 font-weight-bold" style="border-right: 1px solid gray;">Expiry Date</div>
                        <div class="col-md-2 font-weight-bold">Unit Price</div>
                    </div>
                </li>';
    while($product = mysqli_fetch_assoc($products)){
        $html .= '  <input type="hidden" name="product_order_details_id[]" value="'.$product['purchase_id'].'">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2" style="border-right: 1px solid gray;"><img src="'.$home.$product['product_image'].'" alt="assets/img/photo_avatar.png" width="60px" height="60px"></div>
                            <div class="col-md-3" style="border-right: 1px solid gray;">'.((is_null($product['brand_name'])) ? '' : $product['brand_name'].' - ').$product['product_name'].'</div>';        
        $html .=           '<div class="col-md-3" style="border-right: 1px solid gray;">'.$product['approved_amount'].' <small class="text-secondary">'.$product['scale_name'].'</small></div>';
        $html .=    '<div class="col-md-2" style="border-right: 1px solid gray;">
                        <input type="text" class="form-control datepicker" name="expiry_date[]" placeholde="Expiry Date if any!">
                    </div>';
        $html .=           '<div class="col-md-2"><input name="product_unit_price[]" type="number" step="any" class="form-control" placeholder="Unit Price" value="0" required></div>';
        $html .=        '</div>
                    </li>';
    }    
    $button = '<button class="btn btn-primary btn-sm">Create Order</button>';
    $action = $home.'admin/scm/manage-product-purchase/add-vendor-food';
}
                    
$html .=       '</ul>
            </div>
        </div>';
$data = array(
    'html' => $html,
    'button' => $button,
    'action' => $action,
);
echo json_encode($data);