<?php
include("../../../application/config/ajax_config.php");
$product_category_id = $_POST['product_category_id'];
$product_category_name = $_POST['product_category_name'];
$product_category_status = $_POST['product_category_status'];
$product_type_id = $_POST['product_type_id'];
$html = '<input type="hidden" name="product_id" value="'.$product_category_id.'">
        <div class="form-group">
            <input class="form-control" type="text" name="product_category" id="product_category" placeholder="Enter Product Category" value="'.$product_category_name.'">
        </div>
        <div class="form-group">
            <label>Product Enable/Disable</label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            if($product_category_status == '1'){
                $html .= '<input type="checkbox" id="product_status" name="product_status" data-bootstrap-switch data-off-color="danger" data-on-color="success" checked>';
            }else{
                $html .= '<input type="checkbox" id="product_status" name="product_status" data-bootstrap-switch data-off-color="danger" data-on-color="success">';
            }
$html .= '</div>
        <div class="form-group">
            <label for="product_type">Select Product Type</label>
            <select class="form-control select2" name="product_type" id="product_type" required>';
$types = $mysqli->query("SELECT * from scm_product_types");
while($type = mysqli_fetch_assoc($types)){
    if($type['id'] == $product_type_id){
        $html .= '<option value="'.$type['id'].'" selected>'.$type['name'].'</option>';
    }else{
        $html .= '<option value="'.$type['id'].'">'.$type['name'].'</option>';
    }
} 
$html .=    '</select>
        </div>';
echo $html;