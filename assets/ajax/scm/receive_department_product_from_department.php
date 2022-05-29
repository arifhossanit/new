<?php
include("../../../application/config/ajax_config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['super_admin']['email'])){
    redirect(base_url('admin/login'));
}else{
    // echo('-------- post');
    // var_dump($_POST);
    // echo('   --------');
    // echo('<br>');
    // echo('-------- stolen: ');
    // var_dump($_SESSION['stolen_product_department_receive_from_department']);
    // echo('   --------');
    // echo('<br>');
    // echo('-------- damaged: ');
    // var_dump($_SESSION['damaged_product_department_receive_from_department']);
    // echo('   --------');
    // foreach($_SESSION['stolen_product_department_receive_from_department'][109] as $idx=>$receive_id){
    //     print_r($idx.' :idx<br>');
    // }
    // exit();
    /*
        Amount validation.
    */
    foreach($_POST['rqst_id'] as $idx=>$requisition_pk){    // rqst_id is primary key of requisition_details table
        $sent_amount = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_category.product_types_id, scm_product_requisition_details.id, scm_product_requisition_details.sent_amount
        from scm_product_requisition_details
        INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id
        INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id
        where scm_product_requisition_details.id = ".$requisition_pk));
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
    // ==> End validation

    /*
        For every requisition one scm_department_send_product_details row has been be generated.
        scm_department_send_product_details stores where the products needs to be sent.
    */
    $use_product_details = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_requisition.branch_requested_for,scm_product_requisition.note as requisition_note, scm_department_send_product_details.*
    from scm_department_send_product_details
    INNER JOIN scm_product_requisition on scm_product_requisition.department_send_details_id = scm_department_send_product_details.id
    where scm_product_requisition.requisition_id = '".$_POST['requisition_id']."'"));
    $employee_id = '';
    $unit_name = '';
    $room_name = '';
    if($use_product_details['type'] == 'Employee'){
        $employee_id = $use_product_details['employee_id'];
    }else if($use_product_details['type'] == 'Branch'){
        $unit_name = $use_product_details['unit_name'];
        $room_name = $use_product_details['room_name'];
    }
    foreach($_POST['rqst_id'] as $idx=>$requisition_pk){        // rqst_id is primary key of scm_product_requisition_details table
        $sent_amount = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_category.product_types_id, scm_product_requisition_details.id, scm_product_requisition_details.sent_amount
        from scm_product_requisition_details
        INNER JOIN scm_products on scm_products.id = scm_product_requisition_details.product_id
        INNER JOIN scm_product_category on scm_product_category.id = scm_products.product_category_id
        where scm_product_requisition_details.id = ".$requisition_pk));
        if($_POST['stolen_amount'][$idx] > 0){
            if($sent_amount['product_types_id'] == 3){
                /*
                    Updating all the barcodes that are selected to have been stolen.
                    Create indevidual record for barcodes that have the same `purchsae_order`.
                    Requisition received is not being updated for storeable product. Correct amount is being get by query in COMMENT#receive_for_barcodes
                */
                $qry = '';
                foreach($_SESSION['stolen_product_department_receive_from_department'][$requisition_pk] as $barcode){
                    $qry .= $barcode.', ';
                }
                $qry = rtrim($qry, ', ');
                /*
                    Getting all the distinct purchase_order for the selected barcodes.
                */
                $distinct_ids = $mysqli->query('SELECT purchase_table_id, product_id, count(*) as amount from scm_product_barcode where id in ( '.$qry.' ) GROUP BY purchase_table_id');
                while($distinct_id = mysqli_fetch_assoc($distinct_ids)){
                    $insert_stolen_goods = $mysqli->query("INSERT into scm_stolen_goods (`amount`,`purchase_pk`,`created_by`,`created_at`,`note`,`status`) values (".$distinct_id['amount'].", ".$distinct_id['purchase_table_id'].", '".$_SESSION['super_admin']['employee_ids']."', '".date('Y-m-d H:i:s')."', '', 1 )");
                    $insert_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                    $update = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_stolen_goods', product_id = ".$insert_id['max_id']." WHERE id in (SELECT id from scm_product_barcode where id in ( $qry ) AND id_table_name = 'scm_department_stock' AND product_id = ".$distinct_id['product_id'].")");
                    $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_department_stock', ".$distinct_id['product_id'].", 'scm_damaged_goods', ".$insert_id['max_id'].", ".$distinct_id['amount'].", 'stolen', 'Send Stolen Product to Warehouse From Department Whene Receiving From Department!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."')");
                }
                unset($_SESSION['stolen_product_department_receive_from_department'][$requisition_pk]);
            }else{
                /*
                    Non-storable products also create session value which has number of stolen product per `purchase_oreder`.
                    Having session value indidicates that there are products from different `purchase_order`.
                    If all these product are from same `purchase_order` than updates `requisition_received` table sequentially.
                */
                if(isset($_SESSION['stolen_product_department_receive_from_department'][$requisition_pk])){
                    foreach($_SESSION['stolen_product_department_receive_from_department'][$requisition_pk] as $receive_id=>$amount){
                        if((int)$amount != 0){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$amount." where id = ".$receive_id);
                            /*
                                Here warehouse_product_id => department_stock_id.
                                Here getting `department_stock_id` is redundent as in $requisition_received we are again joining with `requisition_received`.
                            */
                            $department_stock = mysqli_fetch_assoc($mysqli->query("SELECT scm_department_stock.id FROM `scm_product_requisition_received` INNER JOIN `scm_department_stock` on scm_department_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where id = ".$receive_id));
                            $requisition_received = mysqli_fetch_assoc($mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id FROM `scm_product_requisition_received` INNER JOIN scm_department_stock on scm_department_stock.id = scm_product_requisition_received.scm_department_stock_id INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_department_stock.id = ".$department_stock['id']));
                            $insert = $mysqli->query("INSERT INTO `scm_stolen_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$receive_id.", 'scm_stolen_goods', ".$inserted_id['max_id'].", ".$amount.", 'stolen', 'Stolen When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }                            
                    }
                    unset($_SESSION['stolen_product_department_receive_from_department'][$requisition_pk]);
                }else{
                    $department_order = $mysqli->query("SELECT * FROM `scm_product_requisition_received` where scm_product_requisition_details_id = ".$sent_amount['id']);
                    $remaining_amount = (int)$_POST['stolen_amount'][$idx];
                    while($row = mysqli_fetch_assoc($department_order)){
                        /*
                            requisition_received has warehouse_id for that department stock.
                        */
                        $department_stock = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_requisition_received_id FROM `scm_department_stock` where id = ".$row['scm_warehouse_product_stock_id']));
                        $requisition_received = mysqli_fetch_assoc($mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id, scm_product_requisition_received.* FROM `scm_product_requisition_received` INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_received.id = ".$department_stock['scm_product_requisition_received_id']));
                        if((int)$row['amount'] < $remaining_amount){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = 0 where id = ".$row['id']);
                            $remaining_amount -= (int)$row['amount'];
                            $insert_stolen_goods = $mysqli->query("INSERT INTO `scm_stolen_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$row['amount'].")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_stolen_goods', ".$inserted_id['max_id'].", ".$row['amount'].", 'stolen', 'Stolen When Receiving From Department to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }else{
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$remaining_amount." where id = ".$row['id']);
                            $insert_stolen_goods = $mysqli->query("INSERT INTO `scm_stolen_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$remaining_amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_stolen_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_stolen_goods', ".$inserted_id['max_id'].", ".$remaining_amount.", 'stolen', 'Stolen When Receiving From Department to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
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
                    Requisition received is not being updated for storeable product. Correct amount is being get by query in COMMENT#receive_for_barcodes
                */
                $qry = '';
                foreach($_SESSION['damaged_product_department_receive_from_department'][$requisition_pk] as $barcode){
                    $qry .= $barcode.', ';
                }
                $qry = rtrim($qry, ', ');
                $distinct_ids = $mysqli->query('SELECT purchase_table_id, product_id, count(*) as amount from scm_product_barcode where id in ( '.$qry.' ) GROUP BY purchase_table_id');
                while($distinct_id = mysqli_fetch_assoc($distinct_ids)){
                    $insert_stolen_goods = $mysqli->query("INSERT into scm_damaged_goods (`amount`,`purchase_pk`,`created_by`,`created_at`,`note`,`status`) values (".$distinct_id['amount'].", ".$distinct_id['purchase_table_id'].", '".$_SESSION['super_admin']['employee_ids']."', '".date('Y-m-d H:i:s')."', '', 1 )");
                    $insert_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                    $update = $mysqli->query("UPDATE scm_product_barcode set id_table_name = 'scm_damaged_goods', product_id = ".$insert_id['max_id']." WHERE id in (SELECT id from scm_product_barcode where id in ( $qry ) AND id_table_name = 'scm_department_stock' AND product_id = ".$distinct_id['product_id'].")");
                    $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_department_stock', ".$distinct_id['product_id'].", 'scm_damaged_goods', ".$insert_id['max_id'].", ".$distinct_id['amount'].", 'stolen', 'Send Damaged Product to Warehouse From Department Whene Receiving From Department!', '".date('Y-m-d H:i:s')."', '".$_SESSION['super_admin']['employee_ids']."')");
                }
                unset($_SESSION['damaged_product_department_receive_from_department'][$requisition_pk]);
            }else{
                /*
                    Non-storable products also create session value which has number of stolen product per `purchase_oreder`.
                    Having session value indidicates that there are products from different `purchase_order`.
                    If all these product are from same `purchase_order` than updates `requisition_received` table sequentially.
                */
                if(isset($_SESSION['damaged_product_department_receive_from_department'][$requisition_pk])){
                    foreach($_SESSION['damaged_product_department_receive_from_department'][$requisition_pk] as $receive_id=>$amount){
                        if((int)$amount != 0){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$amount." where id = ".$receive_id);
                            /*
                                Here warehouse_product_id => department_stock_id.
                                Here getting `department_stock_id` is redundent as in $requisition_received we are again joining with `requisition_received`.
                            */
                            $department_stock = mysqli_fetch_assoc($mysqli->query("SELECT scm_department_stock.id FROM `scm_product_requisition_received` INNER JOIN `scm_department_stock` on scm_department_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where id = ".$receive_id));
                            $requisition_received = mysqli_fetch_assoc($mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id FROM `scm_product_requisition_received` INNER JOIN scm_department_stock on scm_department_stock.id = scm_product_requisition_received.scm_department_stock_id INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_department_stock.id = ".$department_stock['id']));
                            $insert = $mysqli->query("INSERT INTO `scm_damaged_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$receive_id.", 'scm_damaged_goods', ".$inserted_id['max_id'].", ".$amount.", 'stolen', 'Damaged When Receiving From Warehouse to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }                            
                    }
                    unset($_SESSION['damaged_product_department_receive_from_department'][$requisition_pk]);
                }else{
                    $department_order = $mysqli->query("SELECT * FROM `scm_product_requisition_received` where scm_product_requisition_details_id = ".$sent_amount['id']);
                    $remaining_amount = (int)$_POST['damaged_amount'][$idx];
                    while($row = mysqli_fetch_assoc($department_order)){
                        /*
                            requisition_received has warehouse_id for that department stock.
                        */
                        $department_stock = mysqli_fetch_assoc($mysqli->query("SELECT scm_product_requisition_received_id FROM `scm_department_stock` where id = ".$row['scm_warehouse_product_stock_id']));
                        $requisition_received = mysqli_fetch_assoc($mysqli->query("SELECT scm_warehouse_product_stock.scm_product_order_details_id, scm_product_requisition_received.* FROM `scm_product_requisition_received` INNER JOIN scm_warehouse_product_stock on scm_warehouse_product_stock.id = scm_product_requisition_received.scm_warehouse_product_stock_id where scm_product_requisition_received.id = ".$department_stock['scm_product_requisition_received_id']));
                        if((int)$row['amount'] < $remaining_amount){
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = 0 where id = ".$row['id']);
                            $remaining_amount -= (int)$row['amount'];
                            $insert_stolen_goods = $mysqli->query("INSERT INTO `scm_damaged_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$row['amount'].")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_damaged_goods', ".$inserted_id['max_id'].", ".$row['amount'].", 'stolen', 'Damaged When Receiving From Department to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }else{
                            $update_receive_amount = $mysqli->query("UPDATE scm_product_requisition_received set amount = amount - ".$remaining_amount." where id = ".$row['id']);
                            $insert_stolen_goods = $mysqli->query("INSERT INTO `scm_damaged_goods`(`purchase_pk`, `created_by`, `created_at`, `amount`) VALUES ('".$requisition_received['scm_product_order_details_id']."', '".$_SESSION['super_admin']['employee_ids']."', '".date("Y-m-d H:i:s")."', ".$remaining_amount.")");
                            $inserted_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_damaged_goods"));
                            $transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_received', ".$row['id'].", 'scm_damaged_goods', ".$inserted_id['max_id'].", ".$remaining_amount.", 'stolen', 'Damaged When Receiving From Department to Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
                        }
                    }
                }
            }
        }
        $update_requisition_details = $mysqli->query("UPDATE scm_product_requisition_details set received_amount = ".$_POST['received_amount'][$idx].", stolen_amount = ".$_POST['stolen_amount'][$idx].", damaged_amount = ".$_POST['damaged_amount'][$idx]." where id = ".$requisition_pk);
        /*
            `scm_product_requisition_received` is set when auto_assigning from department.
            Looping through each `received` ids from department_stock and creating indevidual rows for each row of department_stock.
        */
        $requisition_received = $mysqli->query("SELECT scm_product_requisition_received.* FROM `scm_product_requisition_received` where scm_product_requisition_details_id = ".$sent_amount['id']);
        while($row = mysqli_fetch_assoc($requisition_received)){
            if($sent_amount['product_types_id'] == 3){                    
                /*  #receive_for_barcodes
                    Storeable product recieved_amount was to being updated.
                    So this ensures for storeable products, after adding stolen or damaged amount, correct amount is received for each `department_use`.
                */
                $received_amount_row = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as received_amount from scm_product_barcode where id_table_name = 'scm_product_requisition_details' AND product_id = ".$row['scm_product_requisition_details_id']));
                $received_amount = $received_amount_row['received_amount'];
            }else{
                $received_amount = $row['amount'];
            }
            if($received_amount > 0){
                /*
                    Here `scm_warehouse_product_stock_id` => `department_stock_id`
                */
                $scm_product_requisition_uses_insert = $mysqli->query("INSERT INTO `scm_product_requisition_uses`(`scm_department_stock_id`, `scm_product_requisition_details_id`, `type`, `branch_id`, `employee_id`, `unit_name`, `room_name`, `amount`, `updated_by`, `updated_at`, `creationDate`, `status`, `note`) VALUES ('".$row['scm_warehouse_product_stock_id']."', '".$row['scm_product_requisition_details_id']."', '".$use_product_details['type']."', '".$use_product_details['branch_requested_for']."', '".$employee_id."', '".$unit_name."', '".$room_name."', '".$received_amount."', '".$_SESSION['super_admin']['employee_ids']."', '".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."', '1', 'Sent from Department to Department')");
                echo mysqli_error($mysqli);

                $stock_id = mysqli_fetch_assoc($mysqli->query("SELECT max(id) as max_id from scm_product_requisition_uses"));
                /*
                    When auto-assigning all the storeable product from differnt stocks are changed to the table `requisition_details`. For that reason limit is used here.
                */
                $update_barcode = $mysqli->query("UPDATE scm_product_barcode set `id_table_name` = 'scm_product_requisition_uses', product_id = ".$stock_id['max_id']." where id_table_name = 'scm_product_requisition_details' AND product_id = ".$requisition_pk." LIMIT ".$row['amount']);

                $insert_transfer_log = $mysqli->query("INSERT INTO `scm_product_transfer_log`(`transfer_from_table`, `transfer_from_table_id`, `transfer_to_table`, `transfer_to_table_id`, `amount`, `transfer_type`, `note`, `creation_date`, `created_by`, `status`) VALUES ('scm_product_requisition_details', ".$requisition_pk.", 'scm_product_requisition_uses', ".$stock_id['max_id'].", ".$_POST['received_amount'][$idx].", 'from_department_to_department', 'Sent From Department To Department', '".date("Y-m-d H:i:s")."', '".$_SESSION['super_admin']['employee_ids']."', 1)");
            }            
        } 
        if(mysqli_error($mysqli)){
            $info = array(
                'message' => 'Something Went Wrong! Try Again!<br>Error message: '.mysqli_error($mysqli),
                'error' => true,
            );                
            echo json_encode($info);
            return;
        }
    }
    if($mysqli->query("UPDATE scm_product_requisition set received_by = '".$_SESSION['super_admin']['employee_ids']."', received_date = '".date('Y-m-d H:i:s')."', status = '9' where requisition_id = '".$_POST['requisition_id']."'")){
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
    echo mysqli_error($mysqli);
}