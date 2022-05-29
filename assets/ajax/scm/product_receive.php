<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['product_id'])){
    foreach($_POST['product_id'] as $idx=>$product_id){
        $approved_amount = mysqli_fetch_assoc($mysqli->query("SELECT `approved_amount`, `warehouse_id`, `id` from scm_product_order_details where id = ".$product_id));
        if($approved_amount['approved_amount'] != ( $_POST['received_amount'][$idx] + $_POST['stolen_amount'][$idx] + $_POST['damaged_amount'][$idx] ) ){
            $message_arr = array(
                'message' => 'mismatch',
                'serial' => $idx+1,
            );
            echo json_encode($message_arr);
            return;
        }
    }
    foreach($_POST['product_id'] as $idx=>$product_id){
        $approved_amount = mysqli_fetch_assoc($mysqli->query("SELECT `approved_amount`, `warehouse_id`, `id` from scm_product_order_details where id = ".$product_id));
        if(!$mysqli->query("UPDATE scm_product_order_details set `received_amount` = ".$_POST['received_amount'][$idx].", `stolen_amount` = ".$_POST['stolen_amount'][$idx].", `damaged_amount` = ".$_POST['damaged_amount'][$idx].", `status` = 1 where id = ".$product_id)){
            echo mysqli_error($mysqli);
            echo 'error 1';
            return;
        }
        if(!$mysqli->query("INSERT INTO `scm_warehouse_product_stock`(`warehouse_id`, `scm_product_order_details_id`, `stock_amount`) VALUES (".$approved_amount['warehouse_id'].", ".$approved_amount['id'].", ".$_POST['received_amount'][$idx].")")){
            echo 'error 2';
            echo mysqli_error($mysqli);
            return;
        }else{
            echo mysqli_error($mysqli);
        }
        // if($_POST['stolen_amount'][$idx] > 0){
        //     $insert = $mysqli->query("INSERT INTO `scm_stolen_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$approved_amount['id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$_POST['stolen_amount'][$idx].")");
        //     $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
        //     $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_order_details', ".$approved_amount['id'].", 'scm_stolen_goods', ".$inserted_id['max_id'].", ".$_POST['stolen_amount'][$idx].", 'stolen', 'Stolen When Receiving From Vendor', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
        // }
        // if($_POST['damaged_amount'][$idx] > 0){
        //     $insert = $mysqli->query("INSERT INTO `scm_damaged_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$approved_amount['id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$_POST['damaged_amount'][$idx].")");
        //     $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
        //     $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_order_details', ".$approved_amount['id'].", 'scm_damaged_goods', ".$inserted_id['max_id'].", ".$_POST['damaged_amount'][$idx].", 'damaged', 'Damaged When Receiving From Vendor', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
        // }
        if($_POST['product_type'][$idx] == 'storable'){
            $max_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as id FROM `scm_warehouse_product_stock`"));
            $max_barcode = mysqli_fetch_assoc($mysqli->query("SELECT max(barcode) as barcode FROM `scm_product_barcode`"));
            $barcode = $max_barcode['barcode'];
            for($i = 0; $i < $_POST['received_amount'][$idx]; $i++){
                $barcode += 11;
                if(!$mysqli->query("INSERT INTO `scm_product_barcode`(`purchase_table_id`, `product_id`, `barcode_symbology`, `barcode`, `status`, `id_table_name`) VALUES ( ".$approved_amount['id'].", ".$max_id['id'].",'TYPE_CODE_128', '".$barcode."', 1, 'scm_warehouse_product_stock')")){
                    echo 'error 3';
                    echo mysqli_error($mysqli);
                    return;
                }
            }
        }       
    }
    if(isset($_POST['food'])){
        $mysqli->query("UPDATE scm_pre_purchase_order set `received` = '".$_SESSION['super_admin']['employee_ids']."', `received_date` = '".date('Y-m-d H:i:s')."', `status` = '4' where purchase_order_id = '".$_POST['purchase_order']."'");
        $mysqli->query("UPDATE scm_product_order_details set `status` = '1' where pre_purchase_order_id = '".$_POST['purchase_order']."'");
    }else{
        $mysqli->query("UPDATE scm_purchase_order set `status` = '1', `received` = '".$_SESSION['super_admin']['employee_ids']."', `received_date` = '".date('Y-m-d H:i:s')."' where purchase_order_id = '".$_POST['purchase_order']."'");
        $mysqli->query("UPDATE scm_product_order_details set `status` = '1' where purchase_order_id = '".$_POST['purchase_order']."'");
    }
    $alert = alert_for_js('success', 'Product Added!!');
    $message_arr = array(
        'message' => 'done',
        'alert' => $alert
    );
    echo json_encode($message_arr);
}