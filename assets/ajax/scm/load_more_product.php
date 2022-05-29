<?php
include("../../../application/config/ajax_config.php");

$query = 'SELECT scm_product_has_department.department_id, scm_product_types.name as types_name, scm_scales.name as scale_name, scm_product_category.name as category_name, scm_product_category.product_types_id, scm_products.*, scm_brands.name as brand_name FROM `scm_products` INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id INNER JOIN scm_scales on scm_scales.id = scm_products.scale_id INNER JOIN scm_product_types on scm_product_types.id = scm_product_category.product_types_id LEFT JOIN scm_brands on scm_brands.id = scm_products.brand_id INNER JOIN scm_product_has_department on scm_product_has_department.product_id = scm_products.id ';
if($_GET['type'] == 'food'){
    $where = " scm_product_types.name = 'Food' ";
}else{
    $where = " scm_product_types.name != 'Food' ";
}
if(isset($_GET['department_id'])){
    if(!empty($_GET['department_id'])){
        $where .= " AND scm_product_has_department.department_id in (";
        foreach($_GET['department_id'] as $idx=>$department_id){
            if($idx == 0){
                $where .= "'$department_id'";
            }else{
                $where .= ",'$department_id'";
            }
        }
        $where .= ") ";
        $data['department_filter'] = $_GET['department_id'];
    }
}
// if(isset($_GET['product_search'])){
if(!empty($_GET['product_name_search'])){
    $where .= ' AND ( scm_products.product_name LIKE \'%'.$_GET['product_name_search'].'%\' OR scm_brands.name LIKE \'%'.$_GET['product_name_search'].'%\' OR scm_product_category.name LIKE \'%'.$_GET['product_name_search'].'%\' )';
}
// }
// if($where == ''){
//     $final_query = $query.' GROUP BY scm_products.id';
// }else{
$final_query = $query.' where '.$where.' GROUP BY scm_products.id LIMIT '.$_GET['offset'] . ', 12';
$products = $mysqli->query($final_query);
$html = '';
foreach($products as $product){
    $html .= '<div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card text-center product-div-'.$product['id'].'" style="height: 280px;">
                    <div class="card-body">
                        <input type="hidden" id="product_department_'.$product['id'].'" value="'.rahat_encode($product['department_id']).'">
                        <img src="'.$home.$product['product_image'].'" style="width:100px;height:100px;"/>
                        <p id="product_info_'.$product['id'].'">'.( ( is_null($product['brand_name']) ) ? $product['product_name'] : $product['brand_name'] . ' - ' .$product['product_name'] )  .'</p>
                        <small> in <span id="scale_info_'.$product['id'].'">'.$product['scale_name'].'</span> </small>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row justify-content-center">
                                    <div class="btn-group w-75 " role="group" aria-label="Basic example">
                                        <button style="height: 85% !important;" type="button" class="button-counter left btn btn-default btn-sm" onclick="minus_number('.$product['id'].')"><i class="fas fa-minus span-custom"></i></button>
                                        <input style="height: 85% !important;" type="number" name="product_'.$product['id'].'" id="product_'.$product['id'].'" class="form-control input-counter counter" placeholder="0" value="0" min="0">
                                        <button style="height: 85% !important;" type="button" class="button-counter right btn btn-default btn-sm" onclick="add_number('.$product['id'].')"><i class="fas fa-plus span-custom"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 mt-2">
                                <abbr title="Add to Cart"><button type="button" class="btn btn-default shadow-sm float-bottom-right" value="'.$product['id'].'" onclick="show_slider(this.value)"><span class="mr-1">Add to cart</span><i class="fas fa-cart-plus"></i></button></abbr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
}
$info = array(
    'html' => $html,
    'offset' => (int)$_GET['offset'] + 12,
);
echo json_encode($info);