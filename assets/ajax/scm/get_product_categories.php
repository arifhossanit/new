<?php
include("../../../application/config/ajax_config.php");
$html = '<option value="">Select Category</option>';
$product_type = $_POST['product_type'];
$categories = $mysqli->query("SELECT * from scm_product_category where product_types_id = $product_type");
$html = '<option value="">Select Category</option>';
while($category = mysqli_fetch_assoc($categories)){
    $html .=    '<option value="'.$category['id'].'~'.$category['name'].'">'.$category['name'].'</option>';
}
echo $html;