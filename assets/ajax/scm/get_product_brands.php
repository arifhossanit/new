<?php
include("../../../application/config/ajax_config.php");
$html = '<option value="">Select Category</option>';
$product_category = $_POST['product_category'];
$brands = $mysqli->query("SELECT * from scm_brands where product_category_id = $product_category");
if($brands->num_rows > 0){
    $html = '<label for="product_category">Select Product Brand</label>
            <select class="form-control select2" name="product_brand" id="product_brand" required>
                <option value="">Select Brand</option>';
    while($brand = mysqli_fetch_assoc($brands)){
        $html .=    '<option value="'.$brand['id'].'">'.$brand['name'].'</option>';
    }
    $html .= '</select>';
}else{
    $html = 'no';
}
$product_specification = $mysqli->query("SELECT scm_product_extra_specification.name, scm_has_product_specification.* from scm_has_product_specification inner join scm_product_extra_specification on scm_product_extra_specification.id = scm_has_product_specification.product_extra_specification_id where product_category_id = $product_category");
if($product_specification->num_rows > 0){
    $product_specification_html = '';
    while($specification = mysqli_fetch_assoc($product_specification)){
        $product_specification_html .= ' <div class="form-group">
                                            <label for="">'.$specification['name'].'</label>
                                            <input class="form-control" type="text" name="'.$specification['product_extra_specification_id'].'[]">
                                            <div id="'.$specification['product_extra_specification_id'].'">
                                            </div>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="remove_specification(\''.$specification['product_extra_specification_id'].'\')"><i class="fas fa-minus"></i></button>
                                                <button value="extra_specification" type="button" class="btn btn-secondary btn-sm" onclick="add_specification(\''.$specification['product_extra_specification_id'].'\')"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>';
    }
}else{
    $product_specification_html = 'no';
}
$info = array(
    'html' => $html,
    'specification' => $product_specification_html
);
echo json_encode($info);