<?php
include("../../../application/config/ajax_config.php");
$product_category_id = $_POST['product_category_id'];
$product_specifications = $mysqli->query("SELECT scm_product_extra_specification.* FROM `scm_product_extra_specification` LEFT JOIN scm_has_product_specification on scm_product_extra_specification.id = scm_has_product_specification.product_extra_specification_id where scm_has_product_specification.id is NULL OR scm_has_product_specification.product_category_id != ".$product_category_id);
$html = '<select class="form-control select2" name="product_specification[]" id="product_specification" required multiple>';
while($product_specification = mysqli_fetch_assoc($product_specifications)){
    $html .= '<option value="'.$product_specification['id'].'">'.$product_specification['name'].'</option>';
}
$html .= '</select>';
echo $html;