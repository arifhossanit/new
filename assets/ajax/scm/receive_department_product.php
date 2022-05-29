<?php
include("../../../application/config/ajax_config.php");
if(!isset($_SESSION['super_admin']['email'])){
    redirect(base_url('admin/login'));
}else{
    // echo('-------- post');
    // var_dump($_POST);
    // echo('   --------');
    // echo('<br>');
    // echo('-------- stolen: ');
    // var_dump($_SESSION['stolen_product_department_receive']);
    // echo('   --------');
    // echo('<br>');
    // echo('-------- damaged: ');
    // var_dump($_SESSION['damaged_product_department_receive']);
    // echo('   --------');
    // foreach($_SESSION['stolen_product_department_receive'][109] as $idx=>$receive_id){
    //     print_r($idx.' :idx<br>');
    // }
    // exit();
    /*
        Amount validation.
    */
    foreach($_POST['rqst_id'] as $idx=>$requisition_pk){        // rqst_id is primary key of requisition_details table
        $sent_amount = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_category.product_types_id, scm_product_requisition_details.id, scm_product_requisition_details.sent_amount from scm_product_requisition_details INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id where scm_product_requisition_details.id = ".$requisition_pk));
        if($sent_amount['sent_amount'] != ( $_POST['received_amount'][$idx] + $_POST['stolen_amount'][$idx] + $_POST['damaged_amount'][$idx]) ){
            $info = array(
                'message' => 'Amount Mismatch!!',
                'error' => true,
                'idx' => $idx
            );
            echo json_encode($info);
            return;
        }
    }

    $branch = mysqli_fetch_assoc($mysqli->query("SELECT branch_requested_for from scm_product_requisition where requisition_id = '".$_POST['requisition_id']."'"));
    foreach($_POST['rqst_id'] as $idx=>$requisition_pk){        // rqst_id is primary key of requisition_details table
        $sent_amount = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_category.product_types_id, scm_product_requisition_details.id, scm_product_requisition_details.sent_amount from scm_product_requisition_details INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id where scm_product_requisition_details.id = ".$requisition_pk));
        if($_POST['stolen_amount'][$idx] > 0){
            if($sent_amount['product_types_id'] == 3){
                /*
                    Updating all the barcodes that are selected to have been stolen.
                    Create indevidual record for barcodes that have the same `purchsae_order`.
                */
                $qry = '';
                foreach($_SESSION['stolen_product_department_receive'][$requisition_pk] as $barcode){
                    $qry .= $barcode.', ';
                }
                $qry = rtrim($qry, ', ');
                $distinct_ids = $mysqli->query('SELECT purchase_table_id, product_id, count(*) as amount from scm_product_barcode where id in ( '.$qry.' ) GROUP BY purchase_table_id');
                while($distinct_id = mysqli_fetch_assoc($distinct_ids)){
                    // print_r($distinct_id);
                    $insert_stolen_goods = $mysqli->query("INSERT into scm_stolen_goods (`amount`,`purchase_pk`,`created_by`,`created_at`,`note`,`status`) values (".$distinct_id['amount'].", ".$distinct_id['purchase_table_id'].", '".$_SESSION['super_admin']['employee_ids']."', '".date('Y-m-d H:i:s')."', '', 1 )");
                    $insert_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                    $update = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_stolen_goods', product_id = ".$insert_id['max_id']." WHERE id in (SELECT id from scm_product_barcode where id in ( $qry ) AND id_table_name = 'scm_product_requisition_details' AND product_id = ".$distinct_id['product_id'].")");
                    $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_details', ".$distinct_id['product_id'].", 'scm_damaged_goods', ".$insert_id['max_id'].", ".$distinct_id['amount'].", 'stolen', 'Send Stolen Product to Warehouse From Department Whene Receiving!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."')");
                }
                // exit();
                unset($_SESSION['stolen_product_department_receive'][$requisition_pk]);
            }else{
                /*
                    This checks if there are same product from different `purchase_order`.
                    If not than updates `requisition_received` table sequentially.
                */
                if(isset($_SESSION['stolen_product_department_receive'][$requisition_pk])){
                    foreach($_SESSION['stolen_product_department_receive'][$requisition_pk] as $receive_id=>$amount){
                        if((int)$amount != 0){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$amount." where id = ".$receive_id);
                            $requisition_received = mysqli_fetch_assoc($mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id FROM `scm_product_requisition_received` INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_received.id = ".$receive_id));
                            $insert = $mysqli->query("INSERT INTO `scm_stolen_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$receive_id.", 'scm_stolen_goods', ".$inserted_id['max_id'].", ".$amount.", 'stolen', 'Stolen When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }                            
                    }
                    unset($_SESSION['stolen_product_department_receive'][$requisition_pk]);
                }else{
                    $requisition_received = $mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id, scm_product_requisition_received.* FROM `scm_product_requisition_received` INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_details_id = ".$sent_amount['id']);
                    $remaining_amount = (int)$_POST['stolen_amount'][$idx];
                    while($row = mysqli_fetch_assoc($requisition_received)){
                        if((int)$row['amount'] < $remaining_amount){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = 0 where id = ".$row['id']);
                            $remaining_amount -= (int)$row['amount'];
                            $insert_stolen_goods = $mysqli->query("INSERT INTO `scm_stolen_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$row['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$row['amount'].")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_stolen_goods', ".$inserted_id['max_id'].", ".$row['amount'].", 'stolen', 'Stolen When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }else{
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$remaining_amount." where id = ".$row['id']);
                            $insert_stolen_goods = $mysqli->query("INSERT INTO `scm_stolen_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$row['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$remaining_amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_stolen_goods', ".$inserted_id['max_id'].", ".$remaining_amount.", 'stolen', 'Stolen When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }
                    }
                }
            }
        }
        if($_POST['damaged_amount'][$idx] > 0){
            if($sent_amount['product_types_id'] == 3){
                /*
                    Updating all the barcodes that are selected to have been stolen.
                    Create indevidual record for barcodes that have the same `purchsae_order`.
                */
                $qry = '';
                foreach($_SESSION['damaged_product_department_receive'][$requisition_pk] as $barcode){
                    $qry .= $barcode.', ';
                }
                $qry = rtrim($qry, ', ');
                $distinct_ids = $mysqli->query('SELECT purchase_table_id, product_id, count(*) as amount from scm_product_barcode where id in ( '.$qry.' ) GROUP BY purchase_table_id');
                while($distinct_id = mysqli_fetch_assoc($distinct_ids)){
                    // print_r($distinct_id);
                    $insert_damaged_goods = $mysqli->query("INSERT into scm_damaged_goods (`amount`,`purchase_pk`,`created_by`,`created_at`,`note`,`status`) values (".$distinct_id['amount'].", ".$distinct_id['purchase_table_id'].", '".$_SESSION['super_admin']['employee_ids']."', '".date('Y-m-d H:i:s')."', '', 1 )");
                    $insert_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                    $update = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_damaged_goods', product_id = ".$insert_id['max_id']." WHERE id in (SELECT id from scm_product_barcode where id in ( $qry ) AND id_table_name = 'scm_product_requisition_details' AND product_id = ".$distinct_id['product_id'].")");
                    $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_details', ".$distinct_id['product_id'].", 'scm_damaged_goods', ".$insert_id['max_id'].", ".$distinct_id['amount'].", 'damaged', 'Send Damaged Product to Warehouse From Department Whene Receiving!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."')");
                }
                // exit();
                unset($_SESSION['damaged_product_department_receive'][$requisition_pk]);
            }else{
                /*
                    This checks if there are same product from different `purchase_order`.
                    If not than updates `requisition_received` table sequentially.
                */
                if(isset($_SESSION['damaged_product_department_receive'][$requisition_pk])){
                    foreach($_SESSION['damaged_product_department_receive'][$requisition_pk] as $receive_id=>$amount){
                        if((int)$amount != 0){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$amount." where id = ".$receive_id);
                            $requisition_received = mysqli_fetch_assoc($mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id FROM `scm_product_requisition_received` INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_received.id = ".$receive_id));
                            $insert = $mysqli->query("INSERT INTO `scm_damaged_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$receive_id.", 'scm_damaged_goods', ".$inserted_id['max_id'].", ".$amount.", 'damaged', 'Damaged When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }                            
                    }
                    unset($_SESSION['damaged_product_department_receive'][$requisition_pk]);
                }else{
                    $requisition_received = $mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id, scm_product_requisition_received.* FROM `scm_product_requisition_received` INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_details_id = ".$sent_amount['id']);
                    $remaining_amount = (int)$_POST['damaged_amount'][$idx];
                    while($row = mysqli_fetch_assoc($requisition_received)){
                        if((int)$row['amount'] < $remaining_amount){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = 0 where id = ".$row['id']);
                            $remaining_amount -= (int)$row['amount'];
                            $insert_damaged_goods = $mysqli->query("INSERT INTO `scm_damaged_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$row['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$row['amount'].")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_damaged_goods', ".$inserted_id['max_id'].", ".$row['amount'].", 'damaged', 'Damaged When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }else{
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$remaining_amount." where id = ".$row['id']);
                            $insert_damaged_goods = $mysqli->query("INSERT INTO `scm_damaged_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$row['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$remaining_amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_damaged_goods', ".$inserted_id['max_id'].", ".$remaining_amount.", 'damaged', 'Damaged When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }
                    }
                }
            }
        }
        $update_requisition_details = $mysqli->query("UPDATE scm_product_requisition_details set received_amount = ".$_POST['received_amount'][$idx].", stolen_amount = ".$_POST['stolen_amount'][$idx].", damaged_amount = ".$_POST['damaged_amount'][$idx]." where id = ".$requisition_pk);
        /*
            `scm_product_requisition_received` is set when auto_assigning from warehouse.
            Looping through each `received` ids from warehosuse_stock and creating indevidual rows for each row of warehouse.
        */
        $requisition_received = $mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id, scm_product_requisition_received.* FROM `scm_product_requisition_received` INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_details_id = ".$sent_amount['id']);
        while($row = mysqli_fetch_assoc($requisition_received)){
            if($sent_amount['product_types_id'] == 3){
                /*
                    This ensures for storeable products that after adding stolen or damaged amount, correct amount is received fom each `warehouse_stock`.
                */
                $received_amount_row = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as received_amount from scm_product_barcode where purchase_table_id = ".$row['scm_product_order_details_id']." AND id_table_name = 'scm_product_requisition_details' AND product_id = ".$row['scm_product_requisition_details_id']));
                $received_amount = $received_amount_row['received_amount'];
            }else{
                $received_amount = $row['amount'];
            }
            if($received_amount > 0){
                $insert_stock = $mysqli->query("INSERT INTO `scm_department_stock`(`scm_product_requisition_details_id`, `branch_id`, `stock_amount`, `scm_product_requisition_received_id`) VALUES ($requisition_pk, '".$branch['branch_requested_for']."', ".$received_amount.", ".$row['id'].")");
                $stock_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_department_stock"));
                $update_barcode = $mysqli->query("UPDATE scm_product_barcode set `id_table_name` = 'scm_department_stock', product_id = ".$stock_id['max_id']." where id_table_name = 'scm_product_requisition_details' AND purchase_table_id = ".$row['scm_product_order_details_id']." LIMIT ".$row['amount']);
                $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_details', ".$requisition_pk.", 'scm_department_stock', ".$stock_id['max_id'].", ".$_POST['received_amount'][$idx].", 'from_warehouse_to_department', 'Sent From Warehouse To Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
            }            
        }            
        if(!$update_requisition_details AND !$insert_stock AND !$update_barcode AND !$insert_transfer_log){
            $info = array(
                'message' => 'Something Went Wrong! Try Again!',
                'error' => true,
            );                
            echo json_encode($info);
            return;
        }
    }
    if($mysqli->query("UPDATE scm_product_requisition set received_by = '".$_SESSION['super_admin']['employee_ids']."', received_date = '".date('Y-m-d H:i:s')."', status = '3' where requisition_id = '".$_POST['requisition_id']."'")){
        $alert = alert_for_js('success', 'Product Received!!');
        $info = array(
            'alert' => $alert,
            'error' => false,
        );
    }else{
        $info = array(
            'message' => mysqli_error($mysqli),
            'error' => true,
        );
    }
    echo json_encode($info);
}