<?php
include("../../../application/config/ajax_config.php");
$product_info = explode('~', $_POST['product']);
$product_specifications = $mysqli->query("SELECT scm_product_extra_specification.* FROM `scm_product_extra_specification` INNER JOIN scm_has_product_specification on scm_product_extra_specification.id = scm_has_product_specification.product_extra_specification_id where scm_has_product_specification.product_category_id = ".$product_info[0]);
$html = '';
while($specification = mysqli_fetch_assoc($product_specifications)){
    $html .= '<div class="col-sm-4" id="'.$specification['id'].'">
                <label for="">'.$specification['name'].'</label>
                <input type="text" name="'.$specification['id'].'" placeholder="'.$specification['name'].'" class="form-control">
            </div>';
}
echo $html;
// var_dump($product_specifications);
