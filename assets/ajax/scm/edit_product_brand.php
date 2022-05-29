<?php
include("../../../application/config/ajax_config.php");
$brand_id = $_POST['brand_id'];
$product_brand_name = $_POST['product_brand_name'];
$brand_status = $_POST['brand_status'];
    $html = '<input type="hidden" name="brand_id" value="'.$brand_id.'">
        <div class="form-group">
            <input class="form-control" type="text" name="product_brand_name" id="product_brand_name" placeholder="Enter Product Category" value="'.$product_brand_name.'">
        </div>
        <div class="form-group">
            <label>Brand Enable/Disable</label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            if($brand_status == '1'){
                $html .= '<input type="checkbox" id="product_status" name="product_status" data-bootstrap-switch data-off-color="danger" data-on-color="success" checked>';
            }else{
                $html .= '<input type="checkbox" id="product_status" name="product_status" data-bootstrap-switch data-off-color="danger" data-on-color="success">';
            }
echo $html;