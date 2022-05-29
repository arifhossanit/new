<?php
include("../../../application/config/ajax_config.php");
$idx = array_search($_POST['id'], array_column($_SESSION['department_transfer_cart'], 'id'));
if(isset($_POST['remove'])){
    array_splice($_SESSION['department_transfer_cart'], $idx, 1);
}else{
    $_SESSION['department_transfer_cart'][$idx]['amount'] -= 1;
}
// var_dump($_SESSION['department_transfer_cart']);
$html = '<table class="table table-bordered" id="product_cart">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Name</td>
                    <td>Amount</td>
                </tr>
            </thead>
            <tbody>';
if(isset($_SESSION['department_transfer_cart'])){
    foreach($_SESSION['department_transfer_cart'] as $product){
        $html .= '<tr>';
        $html .= '<td>'.$product['id'].'</td>';
        $html .= '<td>'.$product['name'].'</td>';
        $html .= '<td>
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-12">
                            <div class="btn-group w-75" role="group" aria-label="Basic example">';
        if($product['type'] !== '3'){            
            $html .=    '<button style="height: 85% !important;" type="button" class="button-counter left btn btn-default btn-sm" onclick="minus_number_cart('.$product['id'].')"><i class="fas fa-minus span-custom"></i></button>
                        <input style="height: 31px !important;" type="number" name="product_cart_'.$product['id'].'" id="product_cart_'.$product['id'].'" class="form-control input-counter-cart counter" placeholder="0" value="'.$product['amount'].'" min="0">';
        }else{
            $html .=    '<input style="height: 31px !important;" type="number" name="product_cart_'.$product['id'].'" id="product_cart_'.$product['id'].'" class="form-control" placeholder="0" value="'.$product['amount'].'" min="0" readonly>';
        }
        $html .=        '</div>
                        </div>
                        <div class="col-md-2 col-12">
                            <button type="button" class="btn btn-danger btn-sm" onclick="remove_item_from_cart('.$product['id'].')"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </td>';
        $html .= '</tr>';
    }
}
$html .='   </tbody>
        </table>';
echo $html;
