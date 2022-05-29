<?php
include("../../../application/config/ajax_config.php");
$product_id = $_POST['product_id'];
$product_amount = $_POST['product_amount'];
$product_measurements = $mysqli->query("SELECT * from scm_product_measurement where product_id = $product_id");
$product_category = mysqli_fetch_assoc($mysqli->query("SELECT product_category_id from scm_products where id = $product_id"));
$product_specifications = $mysqli->query("SELECT * from scm_product_specification where product_id = ".$product_id);
$scm_product_colors = $mysqli->query("SELECT * from scm_product_color where product_id = $product_id");
// var_dump($product_measurements);
if($product_measurements->num_rows != 0 || $product_specifications->num_rows != 0 || $scm_product_colors->num_rows != 0){
    $product_info = mysqli_fetch_assoc($mysqli->query("SELECT product_name, product_image, product_description from scm_products where id = $product_id"));
    $html = '<form action="" id="add_product_to_cart" onsubmit="add_to_cart(\''.$product_id.'\')" method="post">
            <input type="hidden" name="product_id" value="'.$product_id.'">
            <input type="hidden" name="cart_add" value="yes">
            <input type="hidden" name="product_category" value="'.$product_category['product_category_id'].'">
            <div class="row align-items-center justify-content-center" style="margin: 5%;">
                <div class="col-sm-12 col-12 text-center">
                    <img class="slider-image" src="'.$home.$product_info['product_image'].'" alt="" width="300px" height="300px">
                </div>
                <div class="col-sm-6 col-6 text-center">
                    <p>'.$product_info['product_name'].'</p>
                </div>';
    if($scm_product_colors->num_rows != 0){
        $html .='<div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="product_color">Colors</label>
                            <div class="row">';
        $i = 0;
        while($scm_product_color = mysqli_fetch_assoc($scm_product_colors)){
                $html .=       '<div class="col-sm-2 col-6">
                                    <input type="radio" name="product_color" id="product_color_'.$i.'" class="regular-radio" value="'.$scm_product_color['id'].'" />
                                    <label class="cart-option-label" for="product_color_'.$i.'"> '.$scm_product_color['color'].' </label>
                                </div>';
                $i++;
        }
        $html   .=      '   </div>
                        </div>
                  </div>';
    }
    $html   .= '<div class="col-sm-12 col-12">
                    <div class="form-group">
                        <label for="product_name">Product Description</label>
                        <p> '.$product_info['product_description'].' </p>
                        <!-- <input class="form-control" type="text" name="product_image" id="product_image" placeholder="Enter prodcut description/specifications" required> -->
                    </div>
                </div>';
    if($product_measurements->num_rows != 0){
        $html .=   '<div class="col-sm-12 col-12">
                        <div class="form-group">
                            <label for="product_name">Sizes</label>
                            <div class="row">';
        $i = 0;
        while($product_measurement = mysqli_fetch_assoc($product_measurements)){
                        $html .= '<div class="col-sm-2 col-6">
                                    <input type="radio" name="product_size" id="product_size_'.$i.'" class="regular-radio" value="'.$product_measurement['id'].'" />
                                    <label class="cart-option-label" for="product_size_'.$i.'"> '.$product_measurement['width'].( ($product_measurement['height'] == '0') ? '' : ' x '.$product_measurement['height'] ).' '.$product_measurement['unit'].' </label>
                                </div>';
            $i++;
        }                
        $html .=           '</div>
                        </div>
                    </div>';
    }
    // if($product_extra_measurements->num_rows != 0){
    //     $html .=   '<div class="col-sm-12 col-12">
    //                     <div class="form-group">';
    //     $idx = 0;
    //     while($extra_product_measurement = mysqli_fetch_assoc($product_extra_measurements)){
    //         if($idx == 0){
    //             $html .= '<label for="product_name">'.$extra_product_measurement['name'].'</label>
    //                 <div class="row">';
    //         }
    //         $html .= '  <div class="col-sm-2 col-6">
    //                         <input type="radio" name="extra_measurement" class="regular-radio" value="'.$extra_product_measurement['id'].'" />
    //                         <label class="cart-option-label" for="measurement"> '.$extra_product_measurement['width'].' x '.$extra_product_measurement['height'].' '.$extra_product_measurement['unit'].' </label>
    //                     </div>';
    //         $idx++;
    //     }
    //     $html .=           '</div>
    //                     </div>
    //                 </div>';
    // }
    if($product_specifications->num_rows != 0){
        $html .=   '';
        $idx = 0;
        $prev_name = '';
        while($extra_product_measurement = mysqli_fetch_assoc($product_specifications)){
            if($prev_name != $extra_product_measurement['product_extra_specification_id']){
                $name = mysqli_fetch_assoc($mysqli->query("SELECT `name` FROM `scm_product_extra_specification` where id = ".$extra_product_measurement['product_extra_specification_id']));
                if($idx == 0){
                    $html .= '<div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="product_name">'.$name['name'].'</label>
                                    <div class="row">';
                }else{
                    $html .= '      </div>
                                </div>
                            </div>
                    <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="product_name">'.$name['name'].'</label>
                                    <div class="row">';
                }                
                $prev_name = $extra_product_measurement['product_extra_specification_id'];
            }
            $html .= '  <div class="col-sm-2 col-6">
                            <input type="radio" name="'.$extra_product_measurement['product_extra_specification_id'].'" id="'.$extra_product_measurement['product_extra_specification_id'].'_'.$idx.'" class="regular-radio" value="'.$extra_product_measurement['id'].'" />
                            <label class="cart-option-label" for="'.$extra_product_measurement['product_extra_specification_id'].'_'.$idx.'"> '.$extra_product_measurement['name'].' </label>
                        </div>';
            $idx++;
        }
        $html .=           '</div>
                        </div>
                    </div>';
    }
    $html .=   '<div class="col-sm-12 col-12 text-center">
                    <abbr title="Add to Cart"><button type="submit" class="btn btn-default shadow-sm float-bottom-right" value=""><span class="mr-1">Add to cart</span><i class="fas fa-cart-plus"></i></button></abbr>
                </div>
            </div>
            </form>';
}else{
    $html = 'no_options';
}
$data = array(
    'product_amount' => $product_amount,
    'html' => $html,
    'product_category' => $product_category['product_category_id']
);
echo json_encode($data);