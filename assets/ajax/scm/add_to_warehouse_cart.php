<?php
include("../../../application/config/ajax_config.php");
// var_dump($_POST['id']);
// // // unset($_SESSION['warehouse_transfer_cart']);
// exit();
if(isset($_POST['id'])){
    if($_POST['amount'] > 0){
        if(isset($_SESSION['warehouse_transfer_cart'])){
            /*
                department stock table id.
                for adding to existing product of same id.
            */
            $idx = array_search($_POST['id'], array_column($_SESSION['warehouse_transfer_cart'], 'id'));
            if($idx !== false){
                $new_amount = intval($_SESSION['warehouse_transfer_cart'][$idx]['amount']) + intval($_POST['amount']);
                if(mysqli_fetch_assoc($mysqli->query("SELECT id from scm_warehouse_product_stock where id = ".$_POST['id']." AND stock_amount >= ".$new_amount))){
                    $_SESSION['warehouse_transfer_cart'][$idx]['amount'] = $new_amount;
                }
            }else{
                if(mysqli_fetch_assoc($mysqli->query("SELECT id from scm_warehouse_product_stock where id = ".$_POST['id']." AND stock_amount >= ".$_POST['amount']))){
                    array_push(
                        $_SESSION['warehouse_transfer_cart'], 
                        array(
                            'id' => $_POST['id'],
                            'amount' => $_POST['amount'],
                            'name' => $_POST['name'],
                        )
                    );
                }
            }        
        }else{
            if(mysqli_fetch_assoc($mysqli->query("SELECT id from scm_warehouse_product_stock where id = ".$_POST['id']." AND stock_amount >= ".$_POST['amount']))){
                $_SESSION['warehouse_transfer_cart'] = array();
                array_push(
                    $_SESSION['warehouse_transfer_cart'],
                    array(
                        'id' => $_POST['id'],
                        'amount' => $_POST['amount'],
                        'name' => $_POST['name'],
                    )
                );
            }
        }    
    }        
}
// var_dump($_SESSION['warehouse_transfer_cart']);
$html = '<table class="table table-bordered" id="product_cart">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Name</td>
                    <td>Amount</td>
                </tr>
            </thead>
            <tbody>';
if(isset($_SESSION['warehouse_transfer_cart'])){
    foreach($_SESSION['warehouse_transfer_cart'] as $product){
        $html .= '<tr>';
        $html .= '<td>'.$product['id'].'</td>';
        $html .= '<td>'.$product['name'].'</td>';
        $html .= '<td>
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-12">
                            <div class="btn-group w-75" role="group" aria-label="Basic example">
                                <button style="height: 85% !important;" type="button" class="button-counter left btn btn-default btn-sm" onclick="minus_number_cart('.$product['id'].')"><i class="fas fa-minus span-custom"></i></button>
                                <input style="height: 31px !important;" type="number" name="product_cart_'.$product['id'].'" id="product_cart_'.$product['id'].'" class="form-control input-counter-cart counter" placeholder="0" value="'.$product['amount'].'" min="0">
                            </div>
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

// var_dump($_SESSION['warehouse_transfer_cart']);
// unset($_SESSION['warehouse_transfer_cart']);
// exit();
$error = '';
$alert = '';
if(isset($_POST['id'])){
    if($_POST['amount'] > 0){
        $validate_amount = mysqli_fetch_assoc($mysqli->query("SELECT SUM(stock_amount) as stock_amount from scm_department_stock where scm_product_requisition_received_id = ".$_POST['requisition_receive']." GROUP BY scm_product_requisition_received_id"));
        if(isset($_SESSION['warehouse_transfer_cart'])){
            if($_POST['type'] === '3'){
                /*
                    department stock table id.
                    for adding to existing product of same id.
                */
                $idx = array_search($_POST['id'], array_column($_SESSION['warehouse_transfer_cart'], 'id'));
                if($idx !== false){
                    if($validate_amount['stock_amount'] >= $_POST['amount']){
                        $_SESSION['warehouse_transfer_cart'][$idx]['amount'] = $_POST['amount'];
                        $_SESSION['warehouse_transfer_cart'][$idx]['barcodes'] = $_POST['product_to_add'];
                    }else{
                        $error = 'Transfer amount exceeds stock amount!';
                        $alert = alert_for_js('warning', $error);
                    }
                }else{
                    if($validate_amount['stock_amount'] >= $_POST['amount']){
                        array_push(
                            $_SESSION['warehouse_transfer_cart'], 
                            array(
                                'id' => $_POST['id'],
                                'amount' => $_POST['amount'],
                                'name' => $_POST['name'],
                                'type' => $_POST['type'],
                                'rqst_id' => $_POST['rqst_id'],
                                'requisition_receive' => $_POST['requisition_receive'],
                                'barcodes' => $_POST['product_to_add']
                            ));
                    }else{
                        $error = 'Transfer amount exceeds stock amount!';
                        $alert = alert_for_js('warning', $error);
                    }
                }
            }else{
                /*
                    department stock table id.
                    for adding to existing product of same id.
                */
                $idx = array_search($_POST['id'], array_column($_SESSION['warehouse_transfer_cart'], 'id'));
                if($idx !== false){
                    $new_amount = intval($_SESSION['warehouse_transfer_cart'][$idx]['amount']) + intval($_POST['amount']);
                    if(mysqli_fetch_assoc($mysqli->query("SELECT id from scm_department_stock where id = ".$_POST['id']." AND stock_amount >= ".$new_amount))){
                        $_SESSION['warehouse_transfer_cart'][$idx]['amount'] = $new_amount;
                    }else{
                        $error = 'Transfer amount exceeds stock amount!';
                        $alert = alert_for_js('warning', $error);
                    }
                }else{
                    if($validate_amount['stock_amount'] >= $_POST['amount']){
                        array_push(
                            $_SESSION['warehouse_transfer_cart'], 
                            array(
                                    'id' => $_POST['id'],
                                    'amount' => $_POST['amount'],
                                    'name' => $_POST['name'],
                                    'type' => $_POST['type'],
                                    'rqst_id' => $_POST['rqst_id'],
                                    'requisition_receive' => $_POST['requisition_receive'],
                                    'pur_pk' => $_POST['pur_pk'],
                                ));
                    }else{
                        $error = 'Transfer amount exceeds stock amount!';
                        $alert = alert_for_js('warning', $error);
                    }
                }
            }
        }else{
            if($_POST['type'] === '3'){
                if($validate_amount['stock_amount'] >= $_POST['amount']){
                    $_SESSION['warehouse_transfer_cart'] = array();
                    array_push(
                        $_SESSION['warehouse_transfer_cart'],
                        array(
                                'id' => $_POST['id'],
                                'amount' => $_POST['amount'],
                                'name' => $_POST['name'],
                                'type' => $_POST['type'],
                                'rqst_id' => $_POST['rqst_id'],
                                'requisition_receive' => $_POST['requisition_receive'],
                                'barcodes' => $_POST['product_to_add']
                            ));
                }else{
                    $error = 'Transfer amount exceeds stock amount!';
                    $alert = alert_for_js('warning', $error);
                }
            }else{
                if($validate_amount['stock_amount'] >= $_POST['amount']){
                    $_SESSION['warehouse_transfer_cart'] = array();
                    array_push(
                        $_SESSION['warehouse_transfer_cart'],
                        array(
                                'id' => $_POST['id'],
                                'amount' => $_POST['amount'],
                                'name' => $_POST['name'],
                                'type' => $_POST['type'],
                                'rqst_id' => $_POST['rqst_id'],
                                'requisition_receive' => $_POST['requisition_receive'],
                                'pur_pk' => $_POST['pur_pk'],
                            ));
                }else{
                    $error = 'Transfer amount exceeds stock amount!';
                    $alert = alert_for_js('warning', $error);
                }
            }
            
        }    
    }else{
        $error = 'Select amount to transfer!';
        $alert = alert_for_js('warning', $error);
    }
}
// var_dump($_SESSION['warehouse_transfer_cart']);
$html = '<table class="table table-bordered" id="product_cart">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Name</td>
                    <td>Amount</td>
                </tr>
            </thead>
            <tbody>';
if(isset($_SESSION['warehouse_transfer_cart'])){
    foreach($_SESSION['warehouse_transfer_cart'] as $product){
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
$info = array(
    'html' => $html,
    'error' => $error,
    'alert' => $alert,
);
echo json_encode($info);