<?php
include("../../../application/config/ajax_config.php");
if(!isset($_SESSION['super_admin']['email'])){
    redirect(base_url('admin/login'));
}else{
    // unset($_SESSION['damaged_product_department_receive']);
    // var_dump($_SESSION['damaged_product_department_receive']);
    // exit();
    if($_POST['type'] == 'consumeable'){
        $products = $mysqli->query("SELECT scm_product_requisition_received.amount, scm_products.product_name, scm_product_order_details.pre_purchase_order_id, scm_product_order_details.purchase_order_id, scm_warehouses.name as warehouse_name, scm_product_requisition_received.id from scm_product_requisition_received 
        INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id
        INNER JOIN scm_product_order_details on scm_product_order_details.id = scm_warehouse_product_stock.scm_product_order_details_id
        INNER JOIN scm_products on scm_products.id = scm_product_order_details.product_id
        INNER JOIN scm_warehouses on scm_warehouses.id = scm_warehouse_product_stock.warehouse_id
        where scm_product_requisition_received.scm_product_requisition_details_id = ".$_POST['id']);
        $html = '   <input type="hidden" id="product_id_stolen" value="'.$_POST['id'].'">
                    <input type="hidden" id="product_type" value="consumable">
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Purchase Order</td>
                            <td>Name</td>
                            <td>Warehouse</td>
                            <td>Amount</td>
                        </tr>
                    </thead>
                    <tbody>';
        $idx = 0;
        while($product = mysqli_fetch_assoc($products)){
            /*
                Getting max amount for, when any damaged amount is set.
            */
            $max_amount = $product['amount'];
            if(isset($_SESSION['damaged_product_department_receive_from_department'][$_POST['id']])){
                if(isset($_SESSION['damaged_product_department_receive_from_department'][$_POST['id']][$product['id']])){
                    $max_amount = $product['amount'] - $_SESSION['damaged_product_department_receive_from_department'][$_POST['id']][$product['id']];
                }
            }
            $amount = '';
            if(isset($_SESSION['stolen_product_department_receive_from_department'][$_POST['id']][$product['id']])){
                $amount = $_SESSION['stolen_product_department_receive_from_department'][$_POST['id']][$product['id']];
            }
            $html .= '<tr>';
            $html .= '<td>'.$product['purchase_order_id'].'</td>';
            $html .= '<td>'.$product['product_name'].'</td>';
            $html .= '<td>'.$product['warehouse_name'].'</td>';
            $html .= '<td><input type="hidden" name="receive_id[]" value="'.$product['id'].'"><input type="number" step="any" class="form-control" name="stolen_product[]" max="'.$max_amount.'" value="'.$amount.'" placeholder="Maximum Amount: '.$max_amount.'"></td>';
            $html .= '</tr>';
        }
        $html .= '<tbody>
                </table>';
        echo $html;
    }else{
        // print_r($_SESSION['stolen_product_department_receive']);
        $barcodes = $mysqli->query("SELECT id, barcode from scm_product_barcode where product_id = '".$_POST['id']."'");
        $html = '<div class="row">
                    <input type="hidden" id="product_type" value="storeable">
                    <input type="hidden" id="product_id_stolen" value="'.$_POST['id'].'">';
        $idx = 0;
        while($barcode = mysqli_fetch_assoc($barcodes)){
            $idx++;
            if(isset($_SESSION['stolen_product_department_receive_from_department'][$_POST['id']])){
                if(array_search($barcode['id'],$_SESSION['stolen_product_department_receive_from_department'][$_POST['id']]) !== false){
                    $html .= '  <div class="col-md-4">
                                    <div class="form-check">
                                        <input name="stolen_product[]" class="form-check-input regular-checkbox" type="checkbox" value="'.$barcode['id'].'" id="flexCheckDefault_'.$idx.'" checked>
                                        <label style="font-size: 25px;" class="form-check-label ml-2" for="flexCheckDefault_'.$idx.'">
                                            '.$barcode['barcode'].'
                                        </label>
                                    </div>
                                </div>';
                    continue;
                }           
            }
            if(isset($_SESSION['damaged_product_department_receive_from_department'][$_POST['id']])){
                if(array_search($barcode['id'],$_SESSION['damaged_product_department_receive_from_department'][$_POST['id']]) !== false){
                    $html .= '  <div class="col-md-4">
                                    <div class="form-check">
                                        <input name="stolen_product[]" class="form-check-input regular-checkbox" type="checkbox" value="'.$barcode['id'].'" id="flexCheckDefault_'.$idx.'" disabled>
                                        <label style="font-size: 25px;" class="form-check-label ml-2" for="flexCheckDefault_'.$idx.'">
                                            '.$barcode['barcode'].'
                                        </label>
                                    </div>
                                </div>';
                    continue;
                }
            }
            $html .= '  <div class="col-md-4">
                                    <div class="form-check">
                                        <input name="stolen_product[]" class="form-check-input regular-checkbox" type="checkbox" value="'.$barcode['id'].'" id="flexCheckDefault_'.$idx.'">
                                        <label style="font-size: 25px;" class="form-check-label ml-2" for="flexCheckDefault_'.$idx.'">
                                            '.$barcode['barcode'].'
                                        </label>
                                    </div>
                                </div>';
        }
        $html .= '</div>';
        echo $html;
    }
}