<?php
include("../../../application/config/ajax_config.php");
// adding to cart
// unset($_SESSION['scm_cart']);
// var_dump(rahat_decode($_POST['product_department']));
// exit();
if(isset($_POST['cart_add'])){
    /*
        Type check for food or other product.
    */
    if(isset($_SESSION['type'])){        
        if($_SESSION['type'] != $_POST['type']){
            $error = array(
                'error' => 'type_different'
            );
            echo json_encode($error);
            return;
        }
    }else{
        $_SESSION['type'] = $_POST['type'];
    }
    if(isset($_SESSION['scm_cart'])){
        // if(array_key_exists($_POST['product_id'], $_SESSION['scm_cart'])){
        //     $_SESSION['scm_cart'][$_POST['product_id']] = $_SESSION['scm_cart'][$_POST['product_id']] + $_POST['product_amount'];
        // }
        $product = array(
            'product_id' => $_POST['product_id'],
            'product_amount' => $_POST['product_amount'],
            'product_info' => $_POST['product_info'],
            'scale_info' => $_POST['scale_info'],
            'product_color' => $_POST['product_color'],
            'product_size' => $_POST['product_size'],
            'product_category_id' => $_POST['product_category'],
            'scm_purchase_order' => $_POST['scm_purchase_order'],
            'product_department' => rahat_decode($_POST['product_department'])
        );
        $specifications = $mysqli->query("SELECT * from scm_has_product_specification where product_category_id = ".$_POST['product_category']);
        while($specification = mysqli_fetch_assoc($specifications)){
            // $specification_arr = array(
            //     $specification['product_extra_specification_id'] => $_POST[$specification['product_extra_specification_id']]
            // );
            // array_push($product, $specification_arr);
            if(isset($_POST[$specification['product_extra_specification_id']])){
                $product[$specification['product_extra_specification_id']] = $_POST[$specification['product_extra_specification_id']];
            }
        }
        // var_dump($_SESSION['scm_cart']);
        array_push($_SESSION['scm_cart'], $product);
    }else{
        $product = array(
            'product_id' => $_POST['product_id'],
            'product_amount' => $_POST['product_amount'],
            'product_info' => $_POST['product_info'],
            'scale_info' => $_POST['scale_info'],            
            'product_color' => $_POST['product_color'],
            'product_size' => $_POST['product_size'],
            'product_category_id' => $_POST['product_category'],
            'scm_purchase_order' => $_POST['scm_purchase_order'],
            'product_department' => rahat_decode($_POST['product_department'])
        );
        $specifications = $mysqli->query("SELECT * from scm_has_product_specification where product_category_id = ".$_POST['product_category']);
        while($specification = mysqli_fetch_assoc($specifications)){
            // $specification_arr = array(
            //     $specification['product_extra_specification_id'] => $_POST[$specification['product_extra_specification_id']]
            // );
            if(isset($_POST[$specification['product_extra_specification_id']])){
                $product[$specification['product_extra_specification_id']] = $_POST[$specification['product_extra_specification_id']];
            }
            // array_push($product, $specification['product_extra_specification_id'], $_POST[$specification['product_extra_specification_id']]);
        }
        $_SESSION['scm_cart'] = array();
        array_push($_SESSION['scm_cart'], $product);
    }
}
// remove from cart
if(isset($_POST['remove_from_cart'])){
    array_splice($_SESSION['scm_cart'], $_POST['idx'], 1);
}
if(isset($_POST['update_cart_amount'])){
    $_SESSION['scm_cart'][$_POST['idx']]['product_amount'] = $_POST['updated_amount'];
}
// var_dump($_SESSION['scm_cart']);
// unset($_SESSION['scm_cart']);
// exit();
/* html for cart */
$html = '';
// count(array_unique(array_column($_SESSION['scm_cart'], 'product_department')));
// if(){

// }
if(isset($_SESSION['scm_cart']) && count($_SESSION['scm_cart']) != 0){
    foreach($_SESSION['scm_cart'] as $idx => $product){
        $html .= '<div class="product-cart">
                <div class="row">
                    <div class="col-md-6">
                        <ul style="padding-left: 5px;">
                            <li><h5>'.$product['product_info'].'</h5></li>';
            if($product['product_size'] != ''){
                $size = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_measurement where id = ".$product['product_size']));
                $html .=   '<li><p class="gray-text"><span>Size: </span>'.$size['width'].( ($size['height'] == '0') ? '' : ' x '.$size['height'] ).' '.$size['unit'].'</p></li>';
            }
            if($product['product_color'] != ''){
                $product_color = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_product_color where id = ".$product['product_color']));
                $html .= '<li><p class="gray-text"><span>Color: </span>'.$product_color['color'].'</p></li>';
            }
            $specifications = $mysqli->query("SELECT product_extra_specification_id from scm_has_product_specification where product_category_id = ".$product['product_category_id']);
            while($specification = mysqli_fetch_assoc($specifications)){
                if(isset($product[$specification['product_extra_specification_id']])){
                    $specification_name = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_extra_specification.name as specification_name, scm_product_specification.name as specification from scm_product_specification inner join scm_product_extra_specification on scm_product_extra_specification.id = scm_product_specification.product_extra_specification_id where scm_product_specification.id = ".$product[$specification['product_extra_specification_id']]));
                    $html .= '<li><p class="gray-text"><span>'.$specification_name['specification_name'].': </span>'.$specification_name['specification'].'</p></li>';
                }
            }            
            // if($product['extra_measurement'] != ''){
            //     $extra_measurement = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_extra_product_measurement where id = ".$product['extra_measurement']));
            //     $html .= '<li><p class="gray-text"><span>'.$extra_measurement['name'].': </span>'.$extra_measurement['width'].' x '.$extra_measurement['height'].' '.$extra_measurement['unit'].'</p></li>';
            // }                   
        $html .=       '</ul>
                    </div>
                    <div class="col-md-4 col-md-6 col-10">
                        <ul style="padding-left: 12px;">
                            <div class="row">
                                <label for="">Amount</label>
                            </div>
                            <div class="row">
                                <div class="btn-group" role="group" aria-label="Basic example" style="width: 50%">
                                    <button style="height: 85% !important;" type="button" class="button-counter left btn btn-default btn-sm" onclick="minus_number(\'cart_'.$idx.'\')"><i class="fas fa-minus span-custom"></i></button>
                                    <input style="height: 85% !important;" type="number" name="product_cart_'.$idx.'" id="product_cart_'.$idx.'" class="form-control input-counter counter" placeholder="0" value="'.$product['product_amount'].'" min="0" onchange="update_cart_amount('.$idx.')">
                                    <button style="height: 85% !important;" type="button" class="button-counter right btn btn-default btn-sm" onclick="add_number(\'cart_'.$idx.'\')"><i class="fas fa-plus span-custom"></i></button>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div class="col-md-2 col-2 align-self-end">
                        <ul style="padding-left: 12px;">
                            <button type="button" class="btn btn-xs btn-danger" value="'.$idx.'" onclick="remove_from_cart(this.value)"><i class="fas fa-trash-alt"></i></button>
                        </ul>
                    </div>
                </div>
            </div>';
    }
    $count = count($_SESSION['scm_cart']);
}else{
    $html = '<p class="text-danger p-2 font-weight-bold"> Cart is Empty </p>';
    $count = 0;
}
// if(isset($_SESSION['scm_cart']) && !empty($_SESSION['scm_cart'])){ 
//     if($_POST['scm_purchase_order'] == 'yes'){
//         $button = '<a href="'.$home.'admin/scm/confirm-product-purchase"><button class="btn btn-success" style="float: right;margin-right: 15px;"><span class="mr-1"><i class="fas fa-check"></i></span>Confirm Purchase</button></a>';
//     }else{
//         $button = '<a href="'.$home.'admin/scm/confirm-product-requisition"><button class="btn btn-success" style="float: right;margin-right: 15px;"><span class="mr-1"><i class="fas fa-check"></i></span>Confirm Requisition</button></a>';
//     }
// }else{
//     $button = '';
// }
if(isset($_SESSION['scm_cart']) && !empty($_SESSION['scm_cart'])){ 
    if($_POST['scm_purchase_order'] == 'yes'){
        $button = '<button type="button" class="btn btn-success" style="float: right;margin-right: 15px;" onclick="goToNextStep()"><span class="mr-1"><i class="fas fa-arrow-right"></i></span>Go to Next Step</button>';
    }else{
        $button = '<button type="button" class="btn btn-success" style="float: right;margin-right: 15px;" onclick="goToNextStepRequisition()"><span class="mr-1"><i class="fas fa-arrow-right"></i></span>Go to Next Step</button>';
        // $button = '<a href="'.$home.'admin/scm/confirm-product-requisition"><button type="button" class="btn btn-success" style="float: right;margin-right: 15px;"><span class="mr-1"><i class="fas fa-check"></i></span>Confirm Requisition</button></a>';
    }
}else{
    $button = '';
}

$info = array(
    'html' => $html,
    'count' => $count,
    'button' => $button,
    'error' => 'no'
);
echo json_encode($info);
// unset($_SESSION['scm_cart']);
// var_dump($_SESSION['scm_cart']);
// echo array_search("Atop Rice",$_SESSION['scm_cart']);
